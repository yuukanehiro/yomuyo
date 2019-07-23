<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            "book_id"        => 1,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "わかりやすい",
            "created_at"     => "2019-07-22 01:30:23",
            "updated_at"     => "2019-07-22 01:30:23",
        ]);
        DB::table('reviews')->insert([
            "book_id"        => 2,
            "user_id"        => 1,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "まんがという形なのでどうやって7つの習慣を使ったらよいか、具体的に学ぶことができる。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "book_id"        => 3,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "Dockerの基本からKubernetesの開発までの流れを解説している。EKSについて特集して欲しかった。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "book_id"        => 4,
            "user_id"        => 1,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "アルジャーノンはネズミである。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "book_id"        => 5,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "狂うこと。枠から外れ広がるのだ。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);

 
    }
}
