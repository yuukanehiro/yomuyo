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
            "id"              => 1,
            "google_book_id"  => "C2EFxQEACAAJ",
            "name"            => "図解 眠れなくなるほど面白い地政学の話",
            "created_at"      => "2019-07-22 01:30:23",
            "updated_at"      => "2019-07-22 01:30:23",
        ]);
        DB::table('books')->insert([
            "id"             => 2,
            "google_book_id" => "PzAargEACAAJ",
            "name"           => "まんがでわかる 7つの習慣",
            "created_at"     => "2019-07-22 01:30:24",
            "updated_at"     => "2019-07-22 01:30:24",
        ]);
    }
}
