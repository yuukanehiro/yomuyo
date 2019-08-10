@extends('layouts.app')
@section('title', 'マイページ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">こんにちは！<b>{{ $user->name  }}</b>さん。</div>
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
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                @if(isset($item["id"]))
                    <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
                        <div class="card flex-card col-sm-6 col-md-3 col-lg-3" >
                            @if( isset($google_books_thumbnail_url) )
                                 <div align="center">
                                           <a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" >
                                                 <img class="img-thumbnail" src="{{ $google_books_thumbnail_url }}" alt="{{ $item["title"] }}">
                                           </a>
                                 </div>
                            @else
                                  <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
                            @endif
                                  <div class="card-body">
                                      @if(isset($item["title"]))
                                            <a href="/book/search?name={{ str_limit($item["title"], $limit = 20, $end = '...') }}"><h4 class="card-title">{{ $item["title"] }}</h4></a>
                                      @else
                                            <h4 class="card-title">タイトルなし</h4>
                                      @endif
                                      <a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" class="btn btn-primary">Amazonで購入</a>
                                  </div><!-- card-body -->
           </div><!-- card flex-card -->

        <div class="card col-sm-12 col-md-8 col-sm-8" style="margin-left: 5px; ">
          <h2><strong>『{{ $item["title"] }} 』</strong>の感想を投稿</h2>

          <div class="row">
            <div class="col-lg-12">
              <form action="/mypage/post" method="POST">
                  @csrf
                  <input type="hidden" name="google_book_id" value="{{ $item["id"] }}">
                  <input type="hidden" name="title" value="{{ $item["title"] }}">
                  <input type="hidden" name="thumbnail" value="{{ $item["thumbnail"] }}">
                  <strong class="choice">全体的な評価</strong>

                  <div class="textarea">
                    <label>
                      <textarea name="comment" class="form-control" rows="10" cols="200" id="focusedInput" placeholder="ここに感想を書いてください。"/>{{ old('comment') }}</textarea>
                      <input type="checkbox" name="netabare_flag" >ネタばれ<span style="font-size: 12px;">(ネタばれが含まれる感想はチェックをお願いします。)</span>
                    </label>
                  </div
                    <div class="submmit" align="center">
                      <label>
                        <button type="submit" class="btn btn-primary submit-button">投稿する</button>
                      </label>
                    </div>
              </form>
            </div>
          </div>
        </div>



                </div><!--card-header-->
            </div><!-- card -->
        </div><!-- col -->
    </div><!-- row -->
</div><!--container -->
@endif








<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"></div>
                    <div class="card-body">
                        <h2><b>{{ $user->name }}</b> さんの投稿 一覧</h2>

                        @if($reviews->isEmpty() == true)
                            <p><strong>まだ{{ $user->name }}さんの投稿はありません。</strong></p>
                            <hr/>
                            <p>
                                   {{ $user->name }}さんが大好きな本をみんなに伝えてみませんか。<br/>
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
                                                                                                                        location.assign('./register');
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

                                        <div align="right">
                                            <a href="/mypage/review/edit?review_id={{ $review->id }}">
                                                  <button type="button" class="btn btn-success">編集する</button>
                                            </a>
                                          　<a href="/mypage/review/del?review_id={{ $review->id }}">
                                                  <button type="button" class="btn btn-danger">削除する</button>
                                            </a>
                                        </div>
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
