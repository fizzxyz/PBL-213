<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pendaftaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function createPayment(Request $request)
    {
        try {
            // Get pendaftaran data
            $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

            // Generate unique transaction code
            $kodeTransaksi = 'TRX-' . strtoupper(Str::random(8));

            // Calculate total amount
            $totalAmount = $pendaftaran->penerimaan->biaya + 5000; // Base fee + additional fee

            // Create transaction record
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'pendaftaran_id' => $pendaftaran->id,
                'total' => $totalAmount,
                'is_paid' => false
            ]);

            // Set transaction parameters for Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $kodeTransaksi,
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $pendaftaran->penerimaan->id,
                        'price' => $pendaftaran->penerimaan->biaya,
                        'quantity' => 1,
                        'name' => 'Pendaftaran ' . $pendaftaran->penerimaan->nama,
                    ],
                    [
                        'id' => 'fee',
                        'price' => 5000,
                        'quantity' => 1,
                        'name' => 'Biaya Layanan',
                    ]
                ],
            ];

            // Generate Snap token
            $snapToken = $this->midtransService->createSnapToken($params);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'transaction' => $transaksi
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkout_success(Request $request)
    {
        // Handle successful payment callback from Midtrans
        $kodeTransaksi = $request->order_id;

        // Find the transaction
        $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksi)->first();

        if ($transaksi) {
            // Get transaction data from the request
            $transactionData = null;

            if ($request->has('transaction_data')) {
                try {
                    // Decode the JSON string from the URL parameter
                    $transactionData = json_decode($request->transaction_data, true);
                } catch (\Exception $e) {
                    // Log error but continue processing
                    \Log::error('Failed to decode transaction data: ' . $e->getMessage());
                }
            }

            // Prepare data to update
            $updateData = [
                'is_paid' => true,
                'metode_pembayaran' => $request->payment_type ?? 'midtrans'
            ];

            // If we have valid transaction data, add it to bukti_pembayaran
            if ($transactionData) {
                // Store important transaction details in bukti_pembayaran
                $buktiPembayaran = [
                    'transaction_id' => $transactionData['transaction_id'] ?? null,
                    'order_id' => $transactionData['order_id'] ?? null,
                    'payment_type' => $transactionData['payment_type'] ?? null,
                    'status_code' => $transactionData['status_code'] ?? null,
                    'pdf_url' => $transactionData['pdf_url'] ?? null,
                    'transaction_time' => $transactionData['transaction_time'] ?? null,
                    'gross_amount' => $transactionData['gross_amount'] ?? null,
                    'payment_details' => $transactionData // Store all details for future reference
                ];

                $updateData['bukti_pembayaran'] = json_encode($buktiPembayaran);

                // Also update transaction status if we received one
                if (isset($transactionData['transaction_status'])) {
                    $updateData['status'] = $transactionData['transaction_status'];
                }
            }

            // Update the transaction record
            $transaksi->update($updateData);
        }

        return view('transaksi.success', compact('transaksi'));
    }
}