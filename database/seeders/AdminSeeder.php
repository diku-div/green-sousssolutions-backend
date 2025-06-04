<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            'first_name'    => 'John',
            'last_name'     => 'Doe',
            'email'         => 'admin@gmail.com',
            'phone_number'  => '1234567890',
            'date_of_birth' => '1990-01-01',
            'country'       => 'USA',
            'city'          => 'New York',
            'postal_code'   => '10001',
            'picture_url'   => '\profile5.jpeg',
            'password'      => Hash::make('admin'), // Always hash passwords
        ]);
    }
}
