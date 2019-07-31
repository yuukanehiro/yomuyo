<?php

 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use App\Models\Review;
 use Illuminate\Support\Facades\Log;
 use Carbon\Carbon;
 use Illuminate\Support\Facades\DB;

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




    /** ================================
     *   レビュー編集ページ表示(GET)
     *  ================================
     *
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $user_id = (int) $user->id;

        // レビューの取得
        $request = $request->all();
        unset($request['_token']); // トークン削除
        $review_id = (int) $request['id'];
        $review = new Review();
        $item = $review->get($review_id);

        $s3_bucket = config('app.img_url'); // s3.yomuyo.net
        $thumbnail_url = "http://{$s3_bucket}/books/{$item->thumbnail}";


        // ユーザ情報取得, レビュー情報を取得して/mypageにリダイレクト
        return view('mypage.review.edit', ["user" => $user, "item" => $item, 'thumbnail_url' => $thumbnail_url]);
    }



    /** ===================================
     *  レビュー編集実行(POST)
     *  ===================================
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request)
    {
        $request = $request->all();
        unset($request['_token']);
        $request['netabare_flag'] = isset($request['netabare_flag'])? $request['netabare_flag'] : false; // ネタばれがあるかを判定
        $review_id = (int) $request['id'];

        // レビュー編集実行
        DB::table('reviews')->where('id', $review_id)
                            ->update([
                                           'comment'        => $request['comment'],
                                           'netabare_flag'  => $request['netabare_flag'],
                                           'updated_at'     => Carbon::now()
                                     ]);

        $user = Auth::user(); // ログインユーザ情報取得

        // ユーザのレビュー情報取得
        $id   = $user->id;
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $id);

        // レビュー投稿 書籍情報取得を取得してリダイレクト
        return view('mypage.index', compact("user", "reviews"));
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
        // 対象レコードをログ出力してから削除
        $request = $request->all();
        unset($request['_token']); // トークン削除
        $review_id = (int) $request['id'];
        $record = Review::find($review_id);
        $json = json_encode($record, JSON_UNESCAPED_UNICODE);
        $message = "reviewsテーブルのレコードを削除: {$json}";
        LOG::info($message);         // ログ出力
        Review::destroy($review_id); // 削除実行

        // ユーザ情報取得, レビュー情報を取得して/mypageにリダイレクト
        $user = Auth::user();
        $user_id = (int) $user->id;
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);
        return view('mypage.index', compact("user", "reviews"));
    }



}
