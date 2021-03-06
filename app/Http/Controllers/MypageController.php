<?php

 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Http\Requests\ReviewRequest;
 use Illuminate\Support\Facades\Auth;
 use App\Models\Review;
 use App\Models\Following;
 use App\Models\ReviewForAuthedUser;
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
        $user_id   = $user->id;
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);

        // レビュー投稿 書籍情報取得を取得してリダイレクト
        $item = $request->all();
        if(isset($item['id']))
        {
            $google_books_thumbnail_url = "https://books.google.com/books?id={$item['id']}&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api"; // Google Books APIから本のサムネイルを取得
            unset($item['_token']); // トークン削除
            return view('mypage.index', compact("user", "reviews", "item", "google_books_thumbnail_url"));
        }

        // フォローしている数を取得
        $following = new following();
        $cnt_following = $following->getCount($user_id);

        return view('mypage.index', compact("user", "reviews", "cnt_following"));
    }



    /** ========================
    *    レビューの投稿
    *   ========================
    */
    public function post(ReviewRequest $request)
    {
        $user   = Auth::user();
        $review = new Review();

        if($request->isMethod('post'))
        {
            $form = $request->only([
                                       'google_book_id', // Google Books ID
                                       'title',          // 本のタイトル
                                       'netabare_flag',  // レビューネタバレ
                                       'comment',        // レビュー本文
                                       'thumbnail'       // サムネイル名(Google Books APIの現仕様ではGoogle Books IDと同一)
                                   ]);

            // 投稿実行
            $result = $review->create($form);

            // 投稿成功後の処理
            if($result['result'] == true){
                $id   = $user->id;
                $reviews = $review->getList(null, null, 5, $id);

                $request->flash(); // 『戻る』や事故時の投稿データ消失を防止: セッションに保存

                // TEST
                //var_dump($request);
                //exit();

                return view('mypage.index', ['user' => $user, 'reviews' => $reviews]);
            }
            else {
                     $request->flash();
                     $message = "投稿に失敗しました。ごめんなさい。" .
                                '<a href="' . $_SERVER['HTTP_REFERER'] . '">前に戻る</a>';
                     echo $message;
                     LOG::error("{$message} :" . $result['error']);
                     exit();
            }
        }
        $request->flash();
        return view('mypage.index', ['user' => $user, 'reviews' => $reviews]);

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
        $review_id = (int) $request['review_id'];

        $review = new Review();
        $item = $review->get($review_id);

        $s3_bucket = config('app.img_url'); // s3.yomuyo.net
        $thumbnail_url = "https://{$s3_bucket}/books/{$item->thumbnail}";


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
        $user = Auth::user(); // ログインユーザ情報取得
        $user_id   = $user->id;

        $request = $request->all();
        unset($request['_token']);
        $request['netabare_flag'] = isset($request['netabare_flag'])? $request['netabare_flag'] : false; // ネタばれがあるかを判定
        $review_id = (int) $request['review_id'];

        // レビュー編集実行
        DB::table('reviews')
                            ->where('id',      "=", $review_id)
                            ->where('user_id', "=", $user_id)
                            ->update([
                                'comment'        => $request['comment'],
                                'netabare_flag'  => $request['netabare_flag'],
                                'updated_at'     => Carbon::now()
                          ]);


        // ユーザのレビュー情報取得
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);

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
        $user = Auth::user();
        $user_id = (int) $user->id;
        
        // 対象レコードをログ出力してから削除
        $request = $request->all();
        unset($request['_token']);                                  // トークン削除
        $review_id = (int) $request['review_id'];
        $record = Review::find($review_id);
        $json = json_encode($record, JSON_UNESCAPED_UNICODE);
        DB::table('reviews')->where('user_id', '=', $user_id)
                            ->where('id',      '=', $review_id)
                            ->delete();                             // 削除実行
        $message = "reviewsテーブルのレコードを削除: {$json}";
        LOG::info($message);                                        // ログ出力

        // ユーザ情報取得, レビュー情報を取得して/mypageにリダイレクト
        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);
        return view('mypage.index', compact("user", "reviews"));
    }



}
