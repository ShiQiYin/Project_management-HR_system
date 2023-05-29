<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait HelperFunction
{
    private function createRoles($roles)
    {
        if ($_roles = array_diff($roles, Role::all()->pluck('name')->toArray())) {
            $_roles = collect($_roles)->map(fn($role) => [
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ])->toArray();
            Role::insert($_roles);
        }
    }

    private function createAndAssociatePermissions($permissions)
    {
        $p_names = array_keys($permissions);
        if ($_permissions = array_diff($p_names, Permission::all()->pluck('name')->toArray())) {
            $_permissions = collect($_permissions)->map(fn($permission) => [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ])->toArray();
            Permission::insert($_permissions);
        }

        $permissionIdByName = Permission::all()->pluck('id', 'name')->toArray();
        $roleIdByName = Role::all()->pluck('id', 'name')->toArray();

        foreach ($permissions as $p_name => $r_names) {
            DB::table('role_has_permissions')->insert(
                collect($r_names)->map(fn($r_name) => [
                    'permission_id' => $permissionIdByName[$p_name],
                    'role_id' => $roleIdByName[$r_name]
                ])->toArray()
            );
        }
    }

    private function createUser($userid, $name)
    {
        try
        {
            $user = User::factory()->create([
                'userid' => $userid,
                'name' => $name
            ]);
        }
        catch (QueryException $e)
        {
            // User exists
            $user = User::where('userid', $userid)->first();
        }
        return $user;
    }
}