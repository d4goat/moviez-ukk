<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_has_permissions')->delete();

        // reset cache roles and permissons
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $menuAdmin = [
            'master',
            'admin-dashboard',
            'master',
            'master-role',
            'master-cinema',
            'master-film',
            'master-film-cast',
            'master-film-review',
            'master-genre',
            'master-promotion',
            'master-studio',
            'master-studio-seat',
            'master-studio-show-time',
            'master-users',
            'booking',
            'setting'
        ];

        $permissionsByRole = [
            'admin' => ['dashboard', ...$menuAdmin]
        ];

        foreach ($permissionsByRole as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            $permissionIds = [];
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'api']);
                $permissionIds[] = $permission->id;
            }

            // Sinkronisasi role dengan permissions
            $role->syncPermissions($permissionIds);
        }
    }
}
