<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'admin-access',
            'user-access',
            // Add more permissions as needed
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'administrator']);
        $userRole = Role::create(['name' => 'user']);
        $teknisiRole = Role::create(['name' => 'teknisi']);
        $eselonRole = Role::create(['name' => 'eselon']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $userRole->givePermissionTo(['user-access']);
        $teknisiRole->givePermissionTo(['user-access']);
        $eselonRole->givePermissionTo(['user-access']);

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('administrator');

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        // Create teknisi user
        $teknisi = User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@example.com',
            'password' => bcrypt('password'),
        ]);

        $teknisi->assignRole('teknisi');

        // Create eselon user
        $eselon = User::create([
            'name' => 'Eselon',
            'email' => 'eselon@example.com',
            'password' => bcrypt('password'),
        ]);

        $eselon->assignRole('eselon');
    }
}
