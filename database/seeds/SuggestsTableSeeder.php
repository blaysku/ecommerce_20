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
        for ($i = 1; $i < 20; $i++) {
            DB::table('suggests')->insert([
                'user_id' => rand(1, 20),
                'category_id' => rand(6, 14),
                'name' => $faker->name,
                'description' => $faker->text($maxNbChars = 200),
                'status' => rand(0, 2),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
