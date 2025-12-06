<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permissions yang diperlukan
        $permissions = [
            'view dashboard',
            'view profile',
            'edit profile',
            'edit user profile',
            'view laporan',
            'create laporan',
            'edit laporan',
            'delete laporan',
            'balas laporan',
            'view balasan-laporan',
            'edit balasan-laporan',
            'delete balasan-laporan',
            'view pengguna',
            'create pengguna',
            'edit pengguna',
            'delete pengguna',
            'view hak-akses',
            'create hak-akses',
            'edit hak-akses',
            'delete hak-akses',
            'view roles-permission',
            'edit roles-permission',
            'view perangkat-daerah',
            'create perangkat-daerah',
            'edit perangkat-daerah',
            'delete perangkat-daerah',
            'view tipe-layanan',
            'create tipe-layanan',
            'edit tipe-layanan',
            'delete tipe-layanan',
            'view kategori-layanan',
            'create kategori-layanan',
            'edit kategori-layanan',
            'delete kategori-layanan',
            'view layanan',
            'create layanan',
            'edit layanan',
            'delete layanan',
            'view buku-manual',
            'create buku-manual',
            'edit buku-manual',
            'delete buku-manual',
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Buat roles
        $adminRole = Role::firstOrCreate([
            'name' => 'administrator',
            'guard_name' => 'web'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        $teknisiRole = Role::firstOrCreate([
            'name' => 'teknisi',
            'guard_name' => 'web'
        ]);

        $eselonRole = Role::firstOrCreate([
            'name' => 'eselon',
            'guard_name' => 'web'
        ]);

        // Assign semua permission ke admin
        $adminRole->givePermissionTo($permissions);

        // Assign permission terbatas ke user
        $userPermissions = [
            'view dashboard',
            'view profile',
            'edit profile', 
            'view laporan',
            'create laporan',
            'view balasan-laporan',
            'view buku-manual',
        ];

        $userRole->givePermissionTo($userPermissions);

        // Assign permission untuk teknisi
        $teknisiPermissions = [
            'view dashboard',
            'view profile',
            'edit profile', // Teknisi bisa edit profile sendiri
            'view laporan',
            'balas laporan',
            'view balasan-laporan', // Teknisi bisa melihat semua balasan
            'view buku-manual',
        ];

        $teknisiRole->givePermissionTo($teknisiPermissions);

        // Assign permission untuk eselon
        $eselonPermissions = [
            'view dashboard',
            'view profile',
            'edit profile', // Eselon bisa edit profile sendiri
            'view laporan',
            'view balasan-laporan', // Eselon bisa melihat semua balasan
            'view buku-manual',
        ];

        $eselonRole->givePermissionTo($eselonPermissions);
    }
}
