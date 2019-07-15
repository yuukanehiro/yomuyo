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
           'name' => 'test3',
           'email' => 'test3@example.net',
           'password' => bcrypt('yomuyo55'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
    }
}
