<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Set konfigurasi saat service dipanggil
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    /**
     * Generate Snap Token dari parameter transaksi.
     */
    public function createSnapToken(array $params)
    {
        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap token created successfully for order: ' . $params['transaction_details']['order_id']);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Failed to create snap token: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleNotification()
    {
        try {
            $notification = new Notification();

            // Verifikasi signature dari Midtrans
            $this->verifySignature($notification);

            return [
                'transaction_status' => $notification->transaction_status,
                'order_id' => $notification->order_id,
                'payment_type' => $notification->payment_type ?? null,
                'fraud_status' => $notification->fraud_status ?? null,
                'gross_amount' => $notification->gross_amount ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to handle notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verifikasi signature dari Midtrans untuk keamanan
     */
    protected function verifySignature($notification)
    {
        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $serverKey = config('midtrans.serverKey');

        $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        $signatureKey = $notification->signature_key;

        if ($mySignature !== $signatureKey) {
            Log::error('Invalid signature for order: ' . $orderId);
            throw new \Exception('Invalid signature');
        }

        Log::info('Signature verified for order: ' . $orderId);
    }
}