<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your individual seeders here
        $this->call([
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            ProductImagesTableSeeder::class,
            OrdersTableSeeder::class,
           OrderItemsTableSeeder::class,
           ReviewsTableSeeder::class,
        ]);
    }
}
