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
            "id"             => 1,
            "book_id"        => 1,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "わかりやすい",
            "created_at"     => "2019-07-22 01:30:23",
            "updated_at"     => "2019-07-22 01:30:23",
        ]);
        DB::table('reviews')->insert([
            "id"             => 2,
            "book_id"        => 2,
            "user_id"        => 1,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "まんがという形なのでどうやって7つの習慣を使ったらよいか、具体的に学ぶことができる。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 3,
            "book_id"        => 2,
            "user_id"        => 2,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "部下の為に購入。要点がまとまっているのでずっと入っていきやすい。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 4,
            "book_id"        => 3,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "Dockerの基本からKubernetesの開発までの流れを解説している。EKSについて特集して欲しかった。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 5,
            "book_id"        => 3,
            "user_id"        => 2,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "DockerはWEBの開発現場の標準になりつつある。k8sを学ぶことでDockerや周辺技術も得ることが出来る。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 6,
            "book_id"        => 4,
            "user_id"        => 1,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "アルジャーノンはネズミである。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 7,
            "book_id"        => 4,
            "user_id"        => 2,
            "netabare_flag"  => 0,
            "user_ip"        => "1.1.1.1",
            "comment"        => "文体が独特で引き込まれる",
            "created_at"     => "2019-07-22 01:31:24",
            "updated_at"     => "2019-07-22 01:31:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 8,
            "book_id"        => 5,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "狂うこと。枠から外れ広がるのだ。",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 9,
            "book_id"        => 6,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "プロダクトづくりのエッセンスが詰まっています。まずは小さく開発してPMFを目指すのだ！",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 10,
            "book_id"        => 6,
            "user_id"        => 2,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "サービスの創造とグロースについて。まず1人のユーザを獲得すること、ユーザから学ぶこと。リーンでリリースすること。Done is better than perfect.",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 11,
            "book_id"        => 6,
            "user_id"        => 3,
            "netabare_flag"  => 0,
            "user_ip"        => "3.3.3.3",
            "comment"        => "本通りに完璧に進めようとすると起業は出来なくなってしまうだろう。開発とリリースを進めながらこの本を地図にして進めていこう。",
            "created_at"     => "2019-07-22 01:36:24",
            "updated_at"     => "2019-07-22 01:36:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 12,
            "book_id"        => 7,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "この本から私のIT技術者のキャリアがスタートしました。",
            "created_at"     => "2019-07-22 01:37:24",
            "updated_at"     => "2019-07-22 01:37:24",
        ]);
         DB::table('reviews')->insert([
            "id"             => 13,
            "book_id"        => 8,
            "user_id"        => 2,
            "netabare_flag"  => 1,
            "user_ip"        => "2.2.2.2",
            "comment"        => "ファクトの見方が恣意的な点がありこの本自身が皮肉になっている、客観視することの大切さを教えてくれる",
            "created_at"     => "2019-07-22 01:38:24",
            "updated_at"     => "2019-07-22 01:38:24",
        ]);
         DB::table('reviews')->insert([
            "id"             => 14,
            "book_id"        => 8,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "事実に基づいて世界をみるということ。",
            "created_at"     => "2019-07-22 01:39:24",
            "updated_at"     => "2019-07-22 01:39:24",
        ]);
        DB::table('reviews')->insert([
            "id"             => 15,
            "book_id"        => 9,
            "user_id"        => 1,
            "netabare_flag"  => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "めちゃめちゃわかりやすい！かわいい！この作者さんのアナーキーな切り口が好みなんだよなあ。",
            "created_at"     => "2019-07-22 01:40:24",
            "updated_at"     => "2019-07-22 01:40:24",
        ]);
    }
}
