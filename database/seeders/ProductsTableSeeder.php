<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $marketingPhrases = [
            "Revitalize your skin with our nourishing formula",
            "Experience luxury in every drop",
            "The ultimate solution for radiant skin",
            "Nature-inspired care for your delicate skin",
            "Transform your skincare routine with our premium blend",
            "Indulge in a spa-like experience at home",
            "Dermatologist-tested for your peace of mind",
            "Gentle yet effective for all skin types",
            "The secret to glowing skin revealed",
            "Hydration that lasts all day long",
            "Anti-aging properties for timeless beauty",
            "Organic ingredients for pure skincare",
            "Wake up to fresher, brighter skin",
            "The perfect gift for skincare enthusiasts",
            "Cruelty-free beauty you can feel good about"
        ];

        $english = [
            // Soap related
            'Lavender', 'Aloe', 'Oatmeal', 'Charcoal', 'Tea Tree', 'Coconut', 
            'Shea', 'Olive', 'Goat Milk', 'Honey', 'Rose', 'Peppermint',
            
            // Dishwashing related
            'Lemon', 'Citrus', 'Degreaser', 'Ultra', 'Power', 'Sparkle',
            'Shine', 'Fresh', 'Eco', 'Antibacterial',
            
            // Laundry related
            'Tide', 'Breeze', 'Mountain', 'Ocean', 'Spring', 'Floral',
            'Pure', 'Clean', 'Bright', 'Fresh', 'Soft', 'Hypoallergenic',
            
            // Personal hygiene
            'Antibacterial', 'Moisturizing', 'Exfoliating', 'Deodorizing',
            'Refreshing', 'Cooling', 'Sensitive', 'Pure', 'Clear', 'Mild'
        ];


        
        $faker = Faker::create('en_US');
        // Create, for example, 10 products
        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
            'name' => ucfirst($faker->randomElement($english)) . ' ' . $faker->randomElement([
                    'Soap', 'Bar', 'Wash', 'Gel', 'Liquid', 'Cream',
                    'Dish Soap', 'Detergent', 'Cleaner', 'Scrub',
                    'Hand Wash', 'Body Wash', 'Shampoo', 'Conditioner'
                ]),
                'description' =>fake()->randomElement($marketingPhrases),
                'price'       => $faker->randomFloat(2, 10, 200), // price between 10 and 200
                'stock'       => $faker->numberBetween(10, 100),
                'image'       => $faker->imageUrl(640, 480, 'technics', true, 'soap'),
                'created_at'  => now(),
                'updated_at'  => now(),
                // randomly pick a category from 1, 2, 3
                'category_id' => $faker->randomElement([1, 2, 3]),
            ]);
        }
    }
}
