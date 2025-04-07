<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all order IDs and product IDs
        $orderIds   = DB::table('orders')->pluck('id');
        $productIds = DB::table('products')->pluck('id');

        // Create, for example, 20 random order items
        for ($i = 0; $i < 20; $i++) {
            $productId = $faker->randomElement($productIds);

            // For the sake of example, let's pick a random price from the products table
            $price = DB::table('products')->where('id', $productId)->value('price');
            $quantity = $faker->numberBetween(1, 5);

            DB::table('order_items')->insert([
                'order_id'   => $faker->randomElement($orderIds),
                'product_id' => $productId,
                'quantity'   => $quantity,
                'price'      => $price, // or you could do $price * quantity if you store line total
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
