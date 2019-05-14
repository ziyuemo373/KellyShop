<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            [
                'id' => '1',
                'name' => 'root',
                'position' => '1',
                'image' => NULL,
                'status' => '1',
                '_lft' => '1',
                '_rgt' => '14',
                'parent_id' => NULL,
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ]
        ]);
    }
}
