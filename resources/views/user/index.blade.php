@extends('layouts.app')
@section('title', 'ユーザレビュー')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                        <!-- 名前の表示 -->
                        @if(Auth::check())
                                <p style="text-align: right;">ようこそ！ <b>{{ Auth::user()->name }}</b>さん</p>
                        @else 
                                <p style="text-align: right;">ようこそ！ <b>ゲスト</b>さん</p>
                        @endif
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    読んだ本を探して感想を伝えよう！
                    <hr/> 

                    <div align="center">
                      <form action="/book/search" method="POST">
                          @csrf
                          著者・タイトル
                          <input type="text" name="name" placeholder="本のタイトル・著者名"/>
                          <input type="submit" value="検索" class="submit-button" />
                          @if($errors->has('name'))
                            <tr><th><td><span class="error_mes">{{ $errors->first('name') }}</span></td></tr>
                          @endif
                      </form>
                    </div><!--center -->
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
</div>



<!-- エラー表示 Start -->
@if($errors->any())
 <div class="container">
     <div class="row justify-content-center">
         <div class="col-sm-12 col-md-12 col-lg-12">
             <ul class="error_mes">
                 @foreach($errors->all() as $message)
                     <li>{{ $message }}</li>
                 @endforeach
             </ul>
         </div><!-- col -->
     </div><!-- row -->
 </div><!-- container -->
@endif
<!-- エラー表示 End -->



<div class="container">
        <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header"></div>
                            <div class="card-body">
                                <h2><b>{{ $reviews[0]->user_name }}</b></h2>
                                {{ $reviews[0]->user_comment }}
                                <hr>
                                <a href="{{ $reviews[0]->user_website }}" target="_blank"><i class='fas fa-home'></i> {{ $reviews[0]->user_website }}</a>
                                <hr>
                                <section class="post" data-follow_user_id="{{ $reviews[0]->user_id }}" @if(Auth::check())
                                                                                                            data-login_user_id="{{ Auth::id() }}">
                                                                                                        @else
                                                                                                            >
                                                                                                            <!-- ログインしてなければ新規登録ページへリダイレクト -->
                                                                                                            <script>
                                                                                                                $(function(){
                                                                                                                    $('.btn-follow').click(function(){
                                                                                                                        location.assign('/register');
                                                                                                                        return false;
                                                                                                                    });
                                                                                                                });
                                                                                                            </script>
                                                                                                        @endif
                                                            <!-- ログインしているかつ、ログインしているユーザのページじゃない場合に、
                                                                 フォローボタンは出現する
                                                            -->
                                                            @if(Auth::check() == true)
                                                                @if( isset($reviews[0]->user_id) && $reviews[0]->user_id !== Auth::user()->id )
                                                                <div class="btn-follow">
                                                                        @if(isset($following_flag) && $following_flag == true)
                                                                            <i class="btn btn-success">フォロー中</i>
                                                                        @else
                                                                            <i class="btn btn-primary">フォロー</i>
                                                                        @endif
                                                                </div><!-- btn-follow -->
                                                                @endif
                                                            @endif
                                                
                                                

                                <!-- <a href="#" class="btn btn-primary">メッセージを送る</a> -->
                                <hr>
                                <a href="/follow/?user_id={{ $reviews[0]->user_id }}&user_name={{ $reviews[0]->user_name }}&cnt_following={{ $cnt_following }}"><div class="cnt_following">フォロー中(<span>{{ $cnt_following }}</span>)</div></a>
                                フォロワー(n)
                                レビュー(n) 
                                つぶやき(n)
                                </section>
                            </div><!-- card-body -->
                        </div><!-- card-header -->
                    </div><!-- card -->

                </div><!-- col -->
        </div><!-- row -->
</div><!-- container -->




<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"></div>
                    <div class="card-body">
                        <h2><b>{{ $reviews[0]->user_name }}</b> さんの投稿・レビュー</h2>

                        @if($reviews->isEmpty() == true)
                            <p><strong>まだ{{ $reviews[0]->user_name }}さんの投稿はありません。</strong></p>
                            <hr/>
                            <p>
                                   {{ $reviews[0]->user_name }}さんが大好きな本をみんなに伝えてみませんか。<br/>
                                   伝えたい本を検索して、ぜひ素晴らしさを教えてください。
                            </p>
                        @endif

                        @foreach($reviews as $review)
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="innerbox" >
                                        <a href="/book/search?name={{ str_limit($review->book_title, $limit = 28, $end = '...') }}">
                                              <h3 class="card-title">{{ $review->book_title }}</h3>
                                        </a>
                                        <div align="right">

                                            <section class="post" data-review_id="{{ $review->id }}" @if(Auth::check())
                                                                                                            data-login_user_id="{{ Auth::id() }}">
                                                                                                        @else
                                                                                                            >
                                                                                                            <script>
                                                                                                                $(function(){
                                                                                                                    $('.btn-nice').click(function(){
                                                                                                                        location.assign('/register');
                                                                                                                        return false;
                                                                                                                    });
                                                                                                                });
                                                                                                            </script>
                                                                                                        @endif
                                                <div class="btn-nice" >
                                                        @if( isset($review->id) )
                                                            <i class="fa-heart far active"></i><span>{{ $review->cnt_nices }}</span>
                                                        @else
                                                            <i class="fa-heart far"></i><span>{{ $review->cnt_nices }}</span>
                                                        @endif
                                                </div>
                                            </section>
                                                <a href="/comment/?id={{ $review->id }}&google_book_id={{ $review->google_book_id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}">
                                                        <span style="font-size: 1.2rem;">コメント({{ $review->cnt_comments }})</span>
                                                </a>
                                            </div><!--align -->

                                        <hr/>
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <a href="/book/detail?id={{ $review->google_book_id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}&google_book_id={{ $review->google_book_id }}">
                                                        <img class="img-thumbnail" src="https://s3.yomuyo.net/books/{{ $review->thumbnail }}" alt="{{ $review->book_title }}">
                                                </a>
                                            </div>

                                            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                      
                                                      {!! nl2br(e( $review->comment )) !!}
                                                      <hr/>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- innerbos -->
                                </div><!--col -->
                            </div><!-- row -->
                        @endforeach
                        <hr/>

                    </div><!--card-body -->
                </div><!--card-header -->
            </div><!--card -->
        </div><!--col -->

 
            <div class="innerbox">
                  {{ $reviews->appends(request()->input())->links() }}
            </div>

    </div><!--row -->
</div><!--container -->
@endsection
