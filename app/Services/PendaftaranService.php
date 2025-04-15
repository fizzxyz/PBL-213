<?php
namespace App\Helpers;

use App\Models\Pendaftaran;

class PendaftaranHelper {
    /**
     * Update status pendaftaran dengan validasi
     */
    public static function updateStatus(Pendaftaran $pendaftaran, string $status): bool {
        $allowedStatus = ['pending', 'diterima', 'ditolak'];
        if (in_array($status, $allowedStatus)) {
            $pendaftaran->update(['status_pendaftaran' => $status]);
            return true;
        }
        return false;
    }
}