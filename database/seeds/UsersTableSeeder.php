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
           'id'         => 1,
           'name'       => '優',
           'email'      => 'yuu@example.net',
           'password'   => bcrypt('pass'),
           'comment'    => 'いつも頑張っています。',
           'website'    => 'https://www.yuulinux.tokyo/',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
           'id'         => 2,
           'name'       => '加藤',
           'email'      => 'kato@example.net',
           'password'   => bcrypt('pass'),
           'comment'    => '技術技巧。',
           'website'    => 'https://sys-guard.com/',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
           'id'         => 3,
           'name'       => 'ちょこ',
           'email'      => 'choko@example.net',
           'password'   => bcrypt('pass'),
           'comment'    => 'ちょこです。',
           'website'    => 'https://sys-guard.com/',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
         'id'         => 4,
         'name'       => 'ななしさん',
         'email'      => 'nanasi@example.net',
         'password'   => bcrypt('pass'),
         'comment'    => '投稿する気なし子さんです!',
         'website'    => 'https://google.co.jp/',
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
      ]);
    }
}
