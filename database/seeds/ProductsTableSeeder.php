<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 30; $i++) {
            DB::table('products')->insert([
                'name' => $faker->name,
                'description' => $faker->text($maxNbChars = 200),
                'image' => 'public/images/default.jpg',
                'category_id' => rand(6, 14),
                'avg_rating' => rand(1, 5),
                'is_trending' => rand(0, 1),
                'price' => rand(100, 9500),
                'quantity' => rand(0, 100),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
