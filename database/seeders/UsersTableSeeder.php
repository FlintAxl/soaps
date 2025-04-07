<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create, for example, 10 random users
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'password'   => Hash::make('password'),  // or bcrypt('password')
                'photo'      => $faker->imageUrl(200, 200, 'people', true, 'FakeUser'),
                'role'       => 'user',
                'created_at' => now(),
                'updated_at' => now(),
                'status'     => $faker->boolean(80),     // 80% chance of being true
                'address'    => $faker->address,
            ]);
        }

    }
}
