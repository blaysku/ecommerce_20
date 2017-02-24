<?php

use Illuminate\Database\Seeder;

class SuggestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i < 11; $i++) {
            DB::table('suggests')->insert([
                'user_id' => rand(1, 3),
                'category_id' => rand(4, 12),
                'name' => $faker->name,
                'description' => $faker->text($maxNbChars = 200),
                'status' => rand(0, 1),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
