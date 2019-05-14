<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'status' => 1,
        ]);
    }
}
