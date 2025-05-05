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
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
