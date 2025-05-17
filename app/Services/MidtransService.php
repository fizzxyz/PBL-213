<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
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
    public function createSnapToken(array $params): string
    {
        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Failed to create Snap token: ' . $e->getMessage());
            throw $e;
        }
    }
}
