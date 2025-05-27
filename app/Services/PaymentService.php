<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function createPayment(int $pendaftaranId)
    {
        $pendaftaran = Pendaftaran::with('penerimaan')->findOrFail($pendaftaranId);

        // Generate kode transaksi unik dengan format yang lebih baik
        $kodeTransaksi = 'TRX-' . str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) . '-' . time();

        // Cek apakah sudah ada transaksi untuk pendaftaran ini
        $existingTransaksi = Transaksi::where('pendaftaran_id', $pendaftaranId)
                                    ->where('is_paid', false)
                                    ->first();

        if ($existingTransaksi) {
            // Gunakan transaksi yang sudah ada
            $transaksi = $existingTransaksi;
            $kodeTransaksi = $transaksi->kode_transaksi;
        } else {
            // Buat record transaksi baru
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => Auth::id(),
                'pendaftaran_id' => $pendaftaranId,
                'total' => $pendaftaran->penerimaan->biaya,
                'is_paid' => false,
                'metode_pembayaran' => null,
                'bukti_pembayaran' => null,
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $kodeTransaksi,
                'gross_amount' => (int) $pendaftaran->penerimaan->biaya,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama_lengkap,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'FORM-' . $pendaftaran->penerimaan->id,
                    'price' => (int) $pendaftaran->penerimaan->biaya,
                    'quantity' => 1,
                    'name' => 'Formulir ' . $pendaftaran->penerimaan->nama
                ]
            ],
            'callbacks' => [
                'finish' => route('payment.finish')
            ]
        ];

        Log::info('Creating payment for transaction', [
            'kode_transaksi' => $kodeTransaksi,
            'pendaftaran_id' => $pendaftaranId,
            'amount' => $pendaftaran->penerimaan->biaya
        ]);

        return $this->midtransService->createSnapToken($params);
    }

    public function handlePaymentNotification()
    {
        $notification = $this->midtransService->handleNotification();

        Log::info('Processing payment notification', $notification);

        $kodeTransaksi = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $paymentType = $notification['payment_type'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;

        // Cari transaksi berdasarkan kode transaksi
        $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksi)->first();

        if (!$transaksi) {
            Log::error('Transaction not found: ' . $kodeTransaksi);
            throw new \Exception('Transaction not found: ' . $kodeTransaksi);
        }

        // Update status transaksi berdasarkan status dari Midtrans
        $this->updateTransactionStatus($transaksi, $transactionStatus, $paymentType, $fraudStatus);

        return $transactionStatus;
    }

    protected function updateTransactionStatus(Transaksi $transaksi, string $transactionStatus, ?string $paymentType, ?string $fraudStatus)
    {
        Log::info("Updating transaction status", [
            'kode_transaksi' => $transaksi->kode_transaksi,
            'old_status' => $transaksi->is_paid ? 'paid' : 'unpaid',
            'new_status' => $transactionStatus,
            'payment_type' => $paymentType,
            'fraud_status' => $fraudStatus
        ]);

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'accept') {
                    $this->markAsPaid($transaksi, $paymentType);
                } else {
                    $this->markAsPending($transaksi, $paymentType);
                }
                break;

            case 'settlement':
                $this->markAsPaid($transaksi, $paymentType);
                break;

            case 'pending':
                $this->markAsPending($transaksi, $paymentType);
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $this->markAsFailed($transaksi, $paymentType, $transactionStatus);
                break;

            default:
                Log::warning("Unknown transaction status", [
                    'status' => $transactionStatus,
                    'kode_transaksi' => $transaksi->kode_transaksi
                ]);
                break;
        }
    }

    protected function markAsPaid(Transaksi $transaksi, ?string $paymentType)
    {
        $transaksi->update([
            'is_paid' => true,
            'metode_pembayaran' => $paymentType,
            'bukti_pembayaran' => 'PAID_VIA_MIDTRANS',
            'paid_at' => now()
        ]);

        Log::info("Transaction marked as PAID", [
            'kode_transaksi' => $transaksi->kode_transaksi,
            'payment_type' => $paymentType,
            'amount' => $transaksi->total
        ]);

        // Tambahan: Update status pendaftaran jika diperlukan
        // $transaksi->pendaftaran->update(['status' => 'paid']);
    }

    protected function markAsPending(Transaksi $transaksi, ?string $paymentType)
    {
        $transaksi->update([
            'metode_pembayaran' => $paymentType,
            'is_paid' => false
        ]);

        Log::info("Transaction marked as PENDING", [
            'kode_transaksi' => $transaksi->kode_transaksi,
            'payment_type' => $paymentType
        ]);
    }

    protected function markAsFailed(Transaksi $transaksi, ?string $paymentType, string $reason)
    {
        $transaksi->update([
            'metode_pembayaran' => $paymentType,
            'is_paid' => false
        ]);

        Log::info("Transaction marked as FAILED", [
            'kode_transaksi' => $transaksi->kode_transaksi,
            'payment_type' => $paymentType,
            'reason' => $reason
        ]);
    }
}