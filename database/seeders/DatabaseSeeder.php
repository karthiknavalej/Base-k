<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(ActionSeeder::class);
        // $this->call(PivotSeeder::class);
    }
}
