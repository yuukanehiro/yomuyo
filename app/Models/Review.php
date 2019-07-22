<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // ←追加 ●DBを操作するのにこれは必須
use Illuminate\Http\Request;       // ←追加 ●きっと後で使うよ
use Storage;                       // AWS S3アクセス league/flysystem-aws-s3-v3

class Review extends Model
{
    protected $table      = 'reviews';      // テーブル名
    protected $primaryKey = 'id';           // PK
    protected $guarded    = array('id');    // PK

    public function sum()
    {
        return $count = DB::table('reviews')->count();
    }

    public function create(Request $request)
    {
        $user = \Auth::user(); // ログインユーザID取得
        $user_id = $user->id;

        if($request->netabare_flag == ''){
            $request->netabare_flag = false;
        }

        DB::beginTransaction();
        try{
                // books テーブにデータを保存
                $books_param = [
                    "google_book_id" => $request->google_books_id, // Googl Books ID
                    "name"           => $request->title,           // 本のタイトル
                    "thumbnail"      => $request->thumbnail,       // 本のサムネイル
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                DB::insert('INSERT INTO books (google_book_id, name, thumbnail, created_at, updated_at)
                                    VALUES(:google_book_id, :name, :thumbnail, :created_at, :updated_at)', $books_param);

                // booksテーブルに挿入されたレコードのid(主キー)を取得
                $id = DB::getPdo()->lastInsertId();



                 // reviewsテーブルに保存
                $reviews_param = [
                    "book_id"        => $id,                       // booksテーブルid
                    "user_id"        => $user_id,                  // ユーザID
                    "netabare_flag"  => $request->netabare_flag,   // ネタばれフラグ
                    "user_ip"        => \Request::ip(),            // アクセスIP
                    "comment"        => $request->comment,         // 感想
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                DB::insert('INSERT INTO reviews (book_id, user_id, netabare_flag, user_ip, comment, created_at, updated_at)
                                    VALUES(:book_id, :user_id, :netabare_flag, :user_ip, :comment, :created_at, :updated_at)', $reviews_param);


                // 本のサムネイルをAWS S3 バケット(yomuyo-img/books/)に保存
                $thumbnail_url = $request->input('thumbnail') . '&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api';
                $img = file_get_contents($thumbnail_url);
                $id  = $request->input('google_books_id');
                $disk = Storage::disk('s3')->put("books/{$id}.jpg", $img, 'public');

                return true;
        }catch(\PDOException $e){
            DB::rollBack();
            Log::error(get_class() . ':register() PDOException Error. Rollback was executed.' . $e);
            return false;
        }
    }// public function create()

}
