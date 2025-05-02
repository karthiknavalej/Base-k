<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => "superadmin",
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('Base@321'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "admin",
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('Base@321'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "user",
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('Base@321'),
                'remember_token' => Str::random(10),
            ]
        ];

        User::insert($users);

        // $role1 = Role::findByName('superadmin','api');
        // dd($role1);

        $user = User::where('name','superadmin')->first();
        $role = Role::where('id', '1')->first();
        
        //Get all Permission gor given role id
        $groupsWithRoles = $role->getPermissionNames();
        
        // Attach Permissions to user
        $user->givePermissionTo($groupsWithRoles);
        
        // Attach role to user
        $user->assignRole('superadmin');

        // --------------------------

        $user = User::where('name','admin')->first();
        $role = Role::where('id', '1')->first();

        //Get all Permission gor given role id
        $groupsWithRoles = $role->getPermissionNames();

        // Attach Permissions to user
        $user->givePermissionTo($groupsWithRoles);

        // Attach role to user
        $user->assignRole('admin');
        
        // --------------------------

        $user = User::where('name','user')->first();
        $role = Role::where('id', '1')->first();
        
        //Get all Permission gor given role id
        $groupsWithRoles = $role->getPermissionNames();

        // Attach Permissions to user
        $user->givePermissionTo($groupsWithRoles);

        // Attach role to user
        $user->assignRole('business');
    }
}
