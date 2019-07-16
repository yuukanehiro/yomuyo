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
            "tag"      => "IT",
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);
    }
}
