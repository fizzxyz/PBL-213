<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit_pendidikans')->insert([
            [
                'nama' => 'SMKIT DBS 01',
                'alamat' => 'Jl. Pendidikan No. 123',
                'about' => 'Sekolah menengah pertama unggulan dengan berbagai prestasi akademik dan non-akademik.',
                'slug' => 'smkit-dbs-01',
                'logo' => 'smkit-dbs-01-logo.png',
                'visi' => 'Mencetak generasi yang berprestasi dan berakhlak mulia.',
                'misi' => 'Menyediakan pendidikan berkualitas, mengembangkan potensi siswa, dan membentuk karakter yang baik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
