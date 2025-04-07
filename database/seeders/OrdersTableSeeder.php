<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all user IDs
        $userIds = DB::table('users')->pluck('id');

        // Create, for example, 10 orders
        for ($i = 0; $i < 10; $i++) {
            DB::table('orders')->insert([
                'user_id'     => $faker->randomElement($userIds),
                'total_amount'=> $faker->randomFloat(2, 20, 500), // between 20 and 500
                'status'      => $faker->randomElement(['pending','processing','completed','canceled']),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
