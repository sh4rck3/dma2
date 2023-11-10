<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class NewrolefinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // create new roles
         $role_financial = Role::create(['name' => 'financeiro']);
 
         $permission_read = Permission::create(['name' => 'read financial']);
         $permission_edit = Permission::create(['name' => 'edit financial']);
         $permission_write = Permission::create(['name' => 'write financial']);
         $permission_delete = Permission::create(['name' => 'delete financial']);
 
         
         $permissions_financial = [$permission_read, $permission_edit, $permission_write, $permission_delete];
 
         $role_financial->givePermissionTo($permissions_financial);
    }
}
