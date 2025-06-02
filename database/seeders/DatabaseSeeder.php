<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // <- TAMBAH ini buat role

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitSeeder::class,
            ContentSeeder::class,
            PermissionSeeder::class,
        ]);

        // Bikin role admin kalau belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Bikin user admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'unit_pendidikan_id' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Assign role ke user admin
        $admin->assignRole($adminRole);
    }
}
