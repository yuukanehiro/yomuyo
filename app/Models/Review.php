<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // ←追加 ●DBを操作するのにこれは必須
use Illuminate\Http\Request;       // ←追加 ●きっと後で使うよ
use Storage; // AWS S3

class Review extends Model
{
    protected $table      = 'reviews';      // テーブル名
    protected $primaryKey = 'id';           // PK
    protected $guarded    = array('id');    // PK

    public function create(Request $request)
    {
        $user = \Auth::user(); // ログインユーザID取得
        $user_id = $user->id;

        //\Request::setTrustedProxies(['10.0.0.0/8']); // IP取得の準備 VPCのネットワークをホワイトリストに追加

        //echo $request->google_books_id;
        //exit();

        if($request->netabare_flag == ''){
            $request->netabare_flag = false;
        }

        $param = [
            "book_id"        => $request->google_books_id, // Googl Books ID
            "user_id"        => $user_id,                  // ユーザID
            "netabare_flag"  => $request->netabare_flag,   // ネタばれフラグ
            "user_ip"        => \Request::ip(),            // アクセスIP
            "comment"        => $request->comment,         // 感想
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        //DBに保存
        DB::insert('INSERT INTO reviews (book_id, user_id, netabare_flag, user_ip, comment, created_at, updated_at)
                                    VALUES(:book_id, :user_id, :netabare_flag, :user_ip, :comment, :created_at, :updated_at)', $param);

        // 本のサムネイルをAWS S3 バケット(yomuyo-img)に保存
        $thumbnail_url = $request->input('thumbnail') . '&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api';
        $img = file_get_contents($thumbnail_url);
        $id  = $request->input('google_books_id');
        $disk = Storage::disk('s3')->put("books/{$id}.jpg", $img, 'public');
        //$disk->put($id."jpg", $fileContents);

        return true;
    }
}
