<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class NewrolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create new roles
        $role_default = Role::create(['name' => 'default']); 
        $role_suporte = Role::create(['name' => 'suporte']);
        $role_juridico = Role::create(['name' => 'juridico']);
        $role_rh = Role::create(['name' => 'rh']);

        $permission_read = Permission::create(['name' => 'read tickets']);
        $permission_edit = Permission::create(['name' => 'edit tickets']);
        $permission_write = Permission::create(['name' => 'write tickets']);
        $permission_delete = Permission::create(['name' => 'delete tickets']);

        $permissions_default = [$permission_read, $permission_edit, $permission_write];
        $permissions_suporte = [$permission_read, $permission_edit, $permission_write, $permission_delete];
        $permissions_juridico = [$permission_read, $permission_edit, $permission_write];
        $permissions_rh = [$permission_read, $permission_edit, $permission_write];

        $role_default->givePermissionTo($permissions_default);
        $role_suporte->syncPermissions($permissions_suporte);
        $role_juridico->givePermissionTo($permissions_juridico);
        $role_rh->givePermissionTo($permissions_rh);
    }
}
