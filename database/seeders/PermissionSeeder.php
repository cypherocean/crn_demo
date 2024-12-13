<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $userPermissions = [
            'product-create',
            'product-edit',
            'product-view',
            'product-delete',
        ];

        $adminPermissions = [
            'role-create',
            'role-edit',
            'role-view',
            'role-delete',
            'permission-create',
            'permission-edit',
            'permission-view',
            'permission-delete',
            'access-view',
            'access-edit',
            'subdomain-create',
            'subdomain-edit',
            'subdomain-view',
            'subdomain-delete',
            'user-create',
            'user-edit',
            'user-view',
            'user-delete',
        ];

        $permissions = array_merge($adminPermissions, $userPermissions);

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $userRole = Role::where('name', 'user')->first();
        $userRole->givePermissionTo($userPermissions);

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($permissions);
    }
}
