<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => "ahmed",
            'last_name' => "soliman",
            'email' => "admin@dev.com",
            'mobile_number' => "0111200066",
            'avatar' => null,
            'password' => Hash::make('123456'),
            'is_active' => true,
        ]);
    }
}