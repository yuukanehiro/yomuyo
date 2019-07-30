<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class MypageController extends Controller
{
    public function __construct()
    {
        // authミドルウェア生成.認証の有無ををチェックする。
        // このコントローラで利用する関数すべてに影響を与える
        $this->middleware('auth');
    }

    /** ========================
    *    /mypage index表示
    *   ========================
    */
    public function index(Request $request)
    {
        $user = Auth::user(); // ログインユーザ情報取得

        // ユーザのレビュー情報取得
        $id   = $user->id;
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $id);

        // レビュー投稿 書籍情報取得を取得してリダイレクト
        $item = $request;
        unset($item['_token']); // トークン削除
        return view('mypage.index', compact("user", "reviews", "item"));
    }



    /** ========================
    *    レビューの投稿
    *   ========================
    */
    public function post(Request $request)
    {
        $user = Auth::user();
        $review = new Review();
        $result = $review->create($request);

        // 投稿成功後の処理
        if($result == true){
            $id   = $user->id;
            $reviews = $review->getList(null, null, 5, $id);

            return view('mypage.index', ['user' => $user, 'reviews' => $reviews]);
        }
        else {
            echo "投稿に失敗しました";
            exit();
        }

    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
            //
    }

    /** ===========================
     *   レビューの削除
     *  ============================
     *  @param  int  $id
     *  @return Response
     */
    public function destroy(Request $request)
    {
            // レビューの削除
            $request = $request->all();
            unset($request['_unset']);
            $review_id = (int) $request['id'];
            Review::destroy($review_id);

            // ユーザ情報取得, レビュー情報を取得して/mypageにリダイレクト
            $user = Auth::user();
            $user_id = (int) $user->id;
            $review = new Review();
            $reviews = $review->getList(null, null, 5, $user_id);
            return view('mypage.index', compact("user", "reviews"));
    }



}
