<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            "review_id"      => 1,
            "user_id"        => 1,
            "user_ip"        => "1.1.1.1",
            "comment"        => "地政学的条件の必然によって世界史、各国の外交が理解できる。地理でその国の歴史や国柄が決まる。",
            "created_at"     => "2019-07-22 02:31:00",
            "updated_at"     => "2019-07-22 02:31:00",
        ]);
        DB::table('comments')->insert([
            "review_id"      => 1,
            "user_id"        => 2,
            "user_ip"        => "2.2.2.2",
            "comment"        => "確かに。地政学を学んでから世界史を学ぶとよく理解できるのだよな。",
            "created_at"     => "2019-07-22 02:32:00",
            "updated_at"     => "2019-07-22 02:32:00",
        ]);
       
    }
}
