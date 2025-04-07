<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch all product IDs from the database (assuming some products exist)
        $productIds = DB::table('products')->pluck('id');

        // For each product, insert between 1 to 3 images
        foreach ($productIds as $productId) {
            $imagesCount = rand(1, 3);
            for ($i = 0; $i < $imagesCount; $i++) {
                DB::table('product_images')->insert([
                    'product_id'  => $productId,
                    'image_path'  => $faker->imageUrl(640, 480, 'technics', true, 'soap-images'),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
