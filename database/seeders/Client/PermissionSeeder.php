<?php

namespace Database\Seeders\Client;

use Shared\Enums\Client\PermissionEnum;
use Shared\Enums\Client\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('permission.table_names');

        Schema::disableForeignKeyConstraints();
        DB::table($tableNames['permissions'])->truncate();
        DB::table($tableNames['roles'])->truncate();
        DB::table($tableNames['role_has_permissions'])->truncate();

        $guards = config('permission.seeded_guards');

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($guards as $guard) {
            $guardPermissions = collect(PermissionEnum::getValues())->map(function ($permission) use ($guard) {
                return ['name' => $permission, 'guard_name' => $guard, 'created_at' => now(), 'updated_at' => now()];
            })->toArray();

            $guardRoles = collect(RoleEnum::getValues())->map(function ($role) use ($guard) {
                return ['name' => $role, 'guard_name' => $guard, 'created_at' => now(), 'updated_at' => now()];
            })->toArray();
            Permission::insert($guardPermissions);
            Role::insert($guardRoles);
        }



        $permissionsByRole = RoleEnum::getRolesPermissions();

        $insertPermissions = fn ($role) => DB::table($tableNames['permissions'])
            ->select(['id'])
            ->whereIn('name', $permissionsByRole[$role])->get()->pluck('id');

        $permissionIdsByRole = [];
        foreach (RoleEnum::getValues() as $roleName) {
            $permissionIdsByRole[$roleName] = $insertPermissions($roleName);
        }

        $roles = Role::all();
        $rolesPermissionsData = [];
        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $rolesPermissionsData = array_merge(
                $rolesPermissionsData,
                collect($permissionIds)->map(function ($id) use ($roles, $role) {
                    return [
                        'role_id' => $roles->firstWhere('name', $role)->id,
                        'permission_id' => $id,
                    ];
                })->toArray()
            );
        }
        DB::table($tableNames['role_has_permissions'])->insert($rolesPermissionsData);
    }
}
