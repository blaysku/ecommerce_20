<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 5; $i++) {
            DB::table('categories')->insert([
                'level' => 1,
                'parent_id' => 0,
                'name' => $faker->name,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }

        for ($i = 1; $i < 10; $i++) {
            DB::table('categories')->insert([
                'level' => 2,
                'parent_id' => $faker->numberBetween(1, 5),
                'name' => $faker->name,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
