<?php

namespace Database\Seeders\Client;

use Database\Factories\Client\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // The "truncate" function is called so you do not have to refresh
        // the database if you just want to update the seeded data.
        DB::table('users')->truncate();

        UserFactory::new()->create();
    }
}
