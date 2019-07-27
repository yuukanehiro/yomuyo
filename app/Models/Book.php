<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // ←追加 ●DBを操作するのにこれは必須
use Illuminate\Http\Request;       // ←追加 ●きっと後で使うよ

class Book extends Model
{
    protected $table = 'books';             // テーブル名
    protected $primaryKey = 'id';           // PK
    protected $guarded = array('id');       // PK

   /** ===========================
    *   リレーション
    *  ===========================
    *  @return array
    */
    public function review()
    {
        return $this->hasMany(Review::class);
    } 

}
