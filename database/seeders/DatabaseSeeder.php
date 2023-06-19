<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $roles = ['admin', 'appuser', 'manager'];
        $this->createRoles($roles);

        // Create permissions
        // Format: '{CRUD}-{Resource}' => {ArrayOfRoles}
        $permissions = [
            'update-password' => ['appuser', 'manager'],
            'approve-leave' => ['manager'],
            'add-user' => [],
            // 'approve-leave' => ['manager']
        ];
        $this->createAndAssociatePermissions($permissions);
    }

    private function seedLeavesNumber($id) 
    {

        $leaves = [
            'id' => Str::uuid()->toString(),
            'user_id' => $id,
            'al' => 14,
            'sl' => 14,
            'hl' => 60,
            'pl' => 14,
            'cl' => 3,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('leaves_type')->insert(
            $leaves
        );
    }

    private function seedUsers()
    {
        $admin = $this->createUser('admin', 'Administrator');
        $admin->assignRole('admin');
        // echo($admin->id)
        $this->seedLeavesNumber($admin->id);

        $appuser = $this->createUser('appuser', 'Katy Perry');
        $appuser->assignRole('appuser');
        $this->seedLeavesNumber($appuser->id);

        $appuser2 = $this->createUser('appuser2', 'Adam Lamber');
        $appuser2->assignRole('appuser');
        $this->seedLeavesNumber($appuser2->id);

        $manager = $this->createUser('manager', 'Adele');
        $manager->assignRole('manager');
        $this->seedLeavesNumber($manager->id);

        $manager2 = $this->createUser('manager2', 'Calvin Harris');
        $manager2->assignRole('manager');
        $this->seedLeavesNumber($manager2->id);
    }
}
