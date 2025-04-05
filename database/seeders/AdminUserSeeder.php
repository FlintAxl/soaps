<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'flintaxl.celetaria@gmail.com',
            'password' => Hash::make('123'),
            'photo' => null,
            'role' => 'admin'
        
        ]);
    }
}

