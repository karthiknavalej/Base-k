<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(1)->roles()->attach(1);
        User::find(1)->roles()->attach(2);
        User::find(2)->roles()->attach(2);

        Role::find(1)->actions()->attach(1);
        Role::find(1)->actions()->attach(8);
        Role::find(2)->actions()->attach(1);
        Role::find(2)->actions()->attach(8);
    }
}
