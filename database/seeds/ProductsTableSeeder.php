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

        for ($i = 1; $i < 20; $i++) {
            DB::table('products')->insert([
                'name' => $faker->name,
                'description' => $faker->text($maxNbChars = 200),
                'image' => 'image/image' . $i . '.jpg',
                'category_id' => rand(4, 12),
                'avg_rating' => rand(1, 5),
                'is_trending' => rand(0, 1),
                'price' => rand(100, 1000),
                'quantity' => rand(0, 20),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
