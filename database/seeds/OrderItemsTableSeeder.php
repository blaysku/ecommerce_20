<?php

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 20; $i++) {
            DB::table('order_items')->insert([
                'product_id' => rand(1, 19),
                'quantity' => rand(1, 10),
                'price' => rand(100, 1000),
                'order_id' => rand(1, 5),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
