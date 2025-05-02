<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Action;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            [
                'name' => 'all action',
                'slug' => 'all-action',
                'module' => 'action',
                'action' => 'all',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'list action',
                'slug' => 'list-action',
                'module' => 'action',
                'action' => 'list',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'create action',
                'slug' => 'create-action',
                'module' => 'action',
                'action' => 'create',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'edit action',
                'slug' => 'edit-action',
                'module' => 'action',
                'action' => 'edit',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'show action',
                'slug' => 'show-action',
                'module' => 'action',
                'action' => 'show',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'update action',
                'slug' => 'update-action',
                'module' => 'action',
                'action' => 'update',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'destroy action',
                'slug' => 'destroy-action',
                'module' => 'action',
                'action' => 'destroy',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'all role',
                'slug' => 'all-role',
                'module' => 'role',
                'action' => 'all',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'list role',
                'slug' => 'list-role',
                'module' => 'role',
                'action' => 'list',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'create role',
                'slug' => 'create-role',
                'module' => 'role',
                'action' => 'create',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'edit role',
                'slug' => 'edit-role',
                'module' => 'role',
                'action' => 'edit',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'show role',
                'slug' => 'show-role',
                'module' => 'role',
                'action' => 'show',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'update role',
                'slug' => 'update-role',
                'module' => 'role',
                'action' => 'update',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ],
            [
                'name' => 'destroy role',
                'slug' => 'destroy-role',
                'module' => 'role',
                'action' => 'destroy',
                'created_by' => 1,
                'created_at' => now(config('constants.TIME_ZONE')),
            ]
        ];

        Action::insert($actions);
    }
}
