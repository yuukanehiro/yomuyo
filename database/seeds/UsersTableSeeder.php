<?php

use Carbon\Carbon; // 日付クラス
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name' => '優',
           'email' => 'yuu@example.net',
           'password' => bcrypt('pass'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
           'name' => '加藤',
           'email' => 'kato@example.net',
           'password' => bcrypt('pass'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
           'name' => 'ちょこ',
           'email' => 'choko@example.net',
           'password' => bcrypt('pass'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
    }
}
