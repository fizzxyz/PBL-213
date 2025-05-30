<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ChatSupport extends Component
{
    public $showAdminList = false;
    public $admins = [];

    public function mount()
    {
        // Mengambil data admin dari database berdasarkan role spatie
        $this->admins = User::role('admin')
            ->select('id', 'name', 'nomor_hp', 'avatar')
            ->get()
            ->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'nomor_hp' => $admin->nomor_hp,
                    'avatar' => $admin->avatar,
                ];
            })
            ->toArray();
    }

    public function toggleAdminList()
    {
        $this->showAdminList = !$this->showAdminList;

        // Optional: Add some debugging
        // logger('Admin list toggled: ' . ($this->showAdminList ? 'shown' : 'hidden'));
    }

    public function contactAdmin($nomor_hp)
    {
        if (empty($nomor_hp)) {
            session()->flash('error', 'Nomor WhatsApp tidak tersedia');
            return;
        }

        // Format nomor WhatsApp (hapus karakter non-numerik dan tambah kode negara jika perlu)
        $cleanPhone = preg_replace('/[^0-9]/', '', $nomor_hp);

        // Jika nomor dimulai dengan 0, ganti dengan 62 (Indonesia)
        if (substr($cleanPhone, 0, 1) === '0') {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        // Jika nomor sudah dimulai dengan 62, biarkan
        if (substr($cleanPhone, 0, 2) !== '62') {
            $cleanPhone = '62' . $cleanPhone;
        }

        $whatsappUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode("Halo, saya butuh bantuan dari tim support.");

        // Close the admin list before redirecting
        $this->showAdminList = false;

        // Redirect ke WhatsApp
        return redirect()->away($whatsappUrl);
    }

    public function render()
    {
        return view('livewire.chat-support');
    }
}