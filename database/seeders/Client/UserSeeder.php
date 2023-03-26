<?php

namespace Database\Seeders\Client;

use Domain\Client\Models\User;
use Illuminate\Database\Seeder;
use Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //create if not found by email check
        User::firstOrCreate([
            'email' => config('default.admin.email'),
        ], [
            'name' => 'Admin',
            'email_verified_at' => now(),
            'password' => Hash::make(config('default.admin.password')),
            'remember_token' => Str::random(10),
        ]);
    }

}
