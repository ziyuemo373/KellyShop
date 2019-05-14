<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();

        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table('customers')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
                'date_of_birth' => $faker->dateTimeBetween('-40 years', '-16 years'),
                'email' => $faker->unique()->email,
                'status' => 1,
                'password' => bcrypt('123456'),
                'is_verified' => 1,
                'token' => md5(uniqid(rand(), true)),
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ]);
        }
    }
}
