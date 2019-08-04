<?php

use Illuminate\Database\Seeder;

class NicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nices')->insert([
            "review_id"        => 11,
            "user_id"          => 1,
            "created_at"     => "2019-07-22 01:31:23",
            "updated_at"     => "2019-07-22 01:31:23",
        ]);
        DB::table('nices')->insert([
            "review_id"        => 2,
            "user_id"          => 1,
            "created_at"     => "2019-07-22 01:32:23",
            "updated_at"     => "2019-07-22 01:32:23",
        ]);
        DB::table('nices')->insert([
            "review_id"        => 2,
            "user_id"          => 2,
            "created_at"     => "2019-07-22 01:33:23",
            "updated_at"     => "2019-07-22 01:33:23",
        ]);
        DB::table('nices')->insert([
            "review_id"        => 2,
            "user_id"          => 3,
            "created_at"     => "2019-07-22 01:34:23",
            "updated_at"     => "2019-07-22 01:34:23",
        ]);
        DB::table('nices')->insert([
            "review_id"        => 14,
            "user_id"          => 2,
            "created_at"     => "2019-07-22 01:35:23",
            "updated_at"     => "2019-07-22 01:34:23",
        ]);
        DB::table('nices')->insert([
            "review_id"        => 14,
            "user_id"          => 3,
            "created_at"     => "2019-07-22 01:36:23",
            "updated_at"     => "2019-07-22 01:34:23",
        ]);
    }
}
