<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "user_email" => "admin@gmail.com",
            "user_firstName" => "admin",
            "user_middleName" => "admin",
            "user_lastName" => "admin",
            "user_password" => "admin",
            'user_officeId' => 1,
            "user_roleId" => 1,

        ]);
    }
}
