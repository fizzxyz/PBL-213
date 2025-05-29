<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_contents')->insert([
            'hero_title' => 'Selamat Datang di Website Kami',
            'hero_text' => 'Lorem Ipsum Dolor Sit Amet.',
            'hero_sm_title' => 'Darussalam Batam',
            'hero_image' => 'home/hero/01JSTYY1E45E86YKHVH4SPXSS6.jpg',
            'card_title' => 'Visi',
            'card_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'galeri_title' => 'Galeri Kegiatan',
            'galeri_sm_title' => 'Dokumentasi Momen',
            'video_title' => 'Video Profil',
            'video_sm_title' => 'Tentang Kami',
            'pengantar_title' => 'Sekapur Sirih Ketua Yayasan',
            'pengantar_sm_title' => 'Pesan dan Harapan',
            'pengantar_text' => 'Selamat datang di website resmi kami. Semoga informasi di sini dapat memberikan manfaat bagi seluruh pengunjung.',
            'pengantar_image' => 'home/pengantar/01JSVD9GJ0ZJT4ZSRZGR3MTSMY.png',
            'pengantar_sm_text1' => 'Maju bersama',
            'pengantar_sm_text2' => 'Bersama Kita Bisa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('yayasans')->insert([
            'name' => 'Darussalam Batam',
            'address' => 'Komp Perum Jaya Asri, Jalan Aviari, Buliang, Batu Aji, Kota Batam, Kepulauan Riau 29432',
            'phone' => '(0778) 361890',
            'email' => 'darussalam@sch.id',
            'logo' => '01JSVD9GJ0ZJT4ZSRZGR3MTSMY.png',
            'sejarah' => 'Yayasan Darussalam Batam didirikan pada tahun 1995 dengan tujuan untuk menyediakan pendidikan berkualitas bagi anak-anak di Batam.',
            'tentang' => 'Yayasan Darussalam Batam berkomitmen untuk memberikan pendidikan yang terbaik dan menciptakan lingkungan belajar yang kondusif bagi siswa.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
