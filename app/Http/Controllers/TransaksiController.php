<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function getSnapToken($id)
    {
        try {
            $snapToken = $this->paymentService->createPayment($id);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Failed to get snap token: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create payment'], 500);
        }
    }

    /**
     * Handle webhook notification dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            // Log semua data yang diterima
            Log::info('Midtrans webhook received', [
                'headers' => $request->headers->all(),
                'body' => $request->all()
            ]);

            $status = $this->paymentService->handlePaymentNotification();

            Log::info('Webhook processed successfully', ['status' => $status]);

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Webhook notification error: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process notification'
            ], 500);
        }
    }
}