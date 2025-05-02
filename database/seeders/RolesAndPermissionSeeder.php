<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'superadmin','guard_name'=>'api']);
        $role2 = Role::create(['name' => 'admin','guard_name'=>'api']);
        $role3 = Role::create(['name' => 'business','guard_name'=>'api']);

        

        $Permission1 = Permission::create(['name' => 'all user','guard_name'=>'api']);
        $Permission2 = Permission::create(['name' => 'list user','guard_name'=>'api']);
        $Permission3 = Permission::create(['name' => 'create user','guard_name'=>'api']);
        $Permission4 = Permission::create(['name' => 'edit user','guard_name'=>'api']);
        $Permission5 = Permission::create(['name' => 'show user','guard_name'=>'api']);
        $Permission6 = Permission::create(['name' => 'update user','guard_name'=>'api']);
        $Permission7 = Permission::create(['name' => 'destroy user','guard_name'=>'api']);

        $role1->givePermissionTo(Permission::all());
        $role2->givePermissionTo([$Permission1,
        $Permission2,$Permission3,$Permission4,$Permission5,$Permission6]);
        $role3->givePermissionTo([$Permission1,
        $Permission2,$Permission5]);
    }
}
