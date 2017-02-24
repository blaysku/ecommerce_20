<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.vn',
            'gender' => rand(0, 1),
            'avatar' => 'avatar/default.jpg',
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'password' => bcrypt(123456),
            'status' => 1,
            'is_admin' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        
        for ($i = 1; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'gender' => rand(0, 1),
                'avatar' => 'avatar/default.jpg',
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'password' => bcrypt($faker->password),
                'status' => rand(0, 1),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
