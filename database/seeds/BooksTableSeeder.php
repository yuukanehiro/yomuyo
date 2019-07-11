<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            "name"     => "成功するチームの作り方",
            "author"   => "増田智明",
            "comment"  => "チーム開発を音楽のオーケストレーションに準えたマネジメント本。買いです！",
            "tag"      => "IT",
            "users_id" => "1",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);
    }
}
