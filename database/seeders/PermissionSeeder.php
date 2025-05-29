<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all resources and their permissions
        $resources = [
            'artikel' => ['view', 'create', 'edit', 'delete'],
            'balasan' => ['view', 'create', 'edit', 'delete'],
            'calendar' => ['view', 'create', 'edit', 'delete'],
            'category' => ['view', 'create', 'edit', 'delete'],
            'galeri' => ['view', 'create', 'edit', 'delete'],
            'home_content' => ['view', 'create', 'edit', 'delete'],
            'komentar' => ['view', 'create', 'edit', 'delete'],
            'media_sosial' => ['view', 'create', 'edit', 'delete'],
            'navbar' => ['view', 'create', 'edit', 'delete'],
            'pendaftaran' => ['view', 'create', 'edit', 'delete'],
            'penerimaan' => ['view', 'create', 'edit', 'delete'],
            'role' => ['view', 'create', 'edit', 'delete'],
            'transaksi' => ['view', 'create', 'edit', 'delete'],
            'unit_pendidikan' => ['view', 'create', 'edit', 'delete'],
            'user' => ['view', 'create', 'edit', 'delete'],
            'video' => ['view', 'create', 'edit', 'delete'],
            'yayasan' => ['view', 'create', 'edit', 'delete'],
        ];

        // General permissions
        $generalPermissions = [
            'access_admin_panel',
        ];

        // Create general permissions
        foreach ($generalPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create permissions for each resource
        foreach ($resources as $resource => $actions) {
            foreach ($actions as $action) {
                Permission::create(['name' => $action . '_' . $resource]);
            }
        }

        // Create roles with specific permissions
        $this->createRoles();
    }

    private function createRoles()
    {
        // Super Admin - Has all permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Has most permissions except role management
        $admin = Role::create(['name' => 'admin']);
        $adminPermissions = Permission::whereNotIn('name', [
            'create_role', 'edit_role', 'delete_role'
        ])->get();
        $admin->givePermissionTo($adminPermissions);

        // Create default super admin user
        $superAdminUser = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'unit_pendidikan_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('password123'), // Use a secure password
        ]);
        $superAdminUser->assignRole('super_admin');
    }
}
