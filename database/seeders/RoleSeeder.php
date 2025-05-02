<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'slug' => 'admin',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'business',
                'slug' => 'business',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ]
        ];

        Role::insert($roles);
    }
}
