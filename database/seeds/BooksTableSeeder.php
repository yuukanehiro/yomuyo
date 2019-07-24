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
            "id"               => 1,
            "google_book_id"   => "C2EFxQEACAAJ",
            "name"             => "図解 眠れなくなるほど面白い地政学の話",
            "thumbnail"        => "C2EFxQEACAAJ.jpg",
            "created_at"       => "2019-07-22 01:30:23",
            "updated_at"       => "2019-07-22 01:30:23",
        ]);
        DB::table('books')->insert([
            "id"              => 2,
            "google_book_id" => "PzAargEACAAJ",
            "name"            => "まんがでわかる 7つの習慣",
            "thumbnail"        => "PzAargEACAAJ.jpg",
            "created_at"      => "2019-07-22 01:32:24",
            "updated_at"      => "2019-07-22 01:32:24",
        ]);
        DB::table('books')->insert([
            "id"              => 3,
            "google_book_id" => "iGn6ugEACAAJ",
            "name"            => "Docker/Kubernete",
            "thumbnail"        => "iGn6ugEACAAJ.jpg",
            "created_at"      => "2019-07-22 01:33:24",
            "updated_at"      => "2019-07-22 01:33:24",
        ]);
        DB::table('books')->insert([
            "id"              => 4,
            "google_book_id" => "ViEzrgEACAAJ",
            "name"            => "アルジャーノンに花束を",
            "thumbnail"        => "ViEzrgEACAAJ.jpg",
            "created_at"      => "2019-07-22 01:34:24",
            "updated_at"      => "2019-07-22 01:34:24",
        ]);
        DB::table('books')->insert([
            "id"              => 5,
            "google_book_id" => "ZsmcBgAAQBAJ",
            "name"            => "［新釈］講孟余話",
            "thumbnail"        => "ZsmcBgAAQBAJ.jpg",
            "created_at"      => "2019-07-22 01:35:24",
            "updated_at"      => "2019-07-22 01:35:24",
        ]);
        DB::table('books')->insert([
            "id"               => 6,
            "google_book_id"   => "UN2tswEACAAJ",
            "name"             => "起業の科学",
            "thumbnail"        => "UN2tswEACAAJ.jpg",
            "created_at"       => "2019-07-22 01:36:23",
            "updated_at"       => "2019-07-22 01:36:23",
        ]);
        DB::table('books')->insert([
            "id"               => 7,
            "google_book_id"   => "8RBTBgAAQBAJ",
            "name"             => "これならわかる!Linux入門講座",
            "thumbnail"        => "8RBTBgAAQBAJ",
            "created_at"       => "2019-07-22 01:37:23",
            "updated_at"       => "2019-07-22 01:37:23",
        ]);

    }
}
