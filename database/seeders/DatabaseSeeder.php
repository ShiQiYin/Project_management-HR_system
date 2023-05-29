<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use HelperFunction;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedRolesAndPermissions();
        $this->seedUsers();
    }

    private function seedRolesAndPermissions()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = ['admin', 'appuser'];
        $this->createRoles($roles);

        // Create permissions
        // Format: '{CRUD}-{Resource}' => {ArrayOfRoles}
        $permissions = [
            'update-password' => ['appuser']
        ];
        $this->createAndAssociatePermissions($permissions);
    }

    private function seedUsers()
    {
        $admin = $this->createUser('admin', 'Administrator');
        $admin->assignRole('admin');

        $appuser = $this->createUser('appuser', 'Application User');
        $appuser->assignRole('appuser');
    }
}
