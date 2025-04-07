<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        // Create a Faker instance with the English locale
        $faker = Faker::create('en_US');

        // Grab user, product, and order IDs
        $userIds    = DB::table('users')->pluck('id');
        $productIds = DB::table('products')->pluck('id');
        $orderIds   = DB::table('orders')->pluck('id');

        // Create, for example, 10 random reviews
        for ($i = 0; $i < 10; $i++) {
            DB::table('reviews')->insert([
                'user_id'    => $faker->randomElement($userIds),
                'product_id' => $faker->randomElement($productIds),
                'order_id'   => $faker->randomElement($orderIds),
                'comment'    => $faker->realText(200),
                'rating'     => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
