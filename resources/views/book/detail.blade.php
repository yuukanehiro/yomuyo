@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')


      <!-- Google Books Thumnail取得 -->
      @php
          $thumbnail = "https://books.google.com/books?id=".$item["id"]."&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api";
      @endphp

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
      <div class="card flex-card col-xs-12 col-sm-6 col-md-3 col-lg-3" >
        @if(isset($item["thumbnail"]) )
            <div align="center">
              <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumbnail }}&title={{ $item["title"] }}">
                    <img class="img-thumbnail" src="{{ $thumbnail }}&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api" alt="{{ $item["title"] }}">
              </a>
            </div>
        @else
          <div align="center">
                  <img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像">
          </div>
        @endif
          <div class="card-body">
        @if(isset($item["title"]))
            <a href="/book/search?name={{ str_limit($item["title"], $limit = 20, $end = '...') }}">
                  <h4 class="card-title">{{ $item["title"] }}</h4>
            </a>
        @else
            <h4 class="card-title">タイトルなし</h4>
        @endif
        <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumbnail }}&title={{ $item["title"] }}" class="btn btn-primary">登録</a>
            　<a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" class="btn btn-default">Amazonで購入</a>
              <hr/>
          </div><!-- card-body -->
     </div><!-- card flex-card -->


     <div class="card col-sm-6 col-md-9 col-sm-9" >

           <h2>みんなの感想・レビュー</h2>  
           @if($reviews->isEmpty() == false)
               <div class="row row-eq-height">
                   @foreach($reviews as $review)
                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                           <div class="innerbox">
                           <img src="{{ asset('/images/profile_default_icon.gif') }}"> {{ $review->user_name }} さん
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
                                                <i class="fa-heart far active"></i><span>({{ $review->cnt_nices }})</span>
                                            @else
                                                <i class="fa-heart far"></i><span>({{ $review->cnt_nices }})</span>
                                            @endif
                                    </div>
                                </section>
                                    <a href="/comment/?id={{ $review->id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}">
                                            <span style="font-size: 1.2rem;">コメント({{ $review->cnt_comments }})</span>
                                    </a>
                            </div><!--align -->
                            <hr/>
                            {{ $review->comment }}
                               <hr/>
                               <div class="row">
                                     <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                         <a href="/book/detail?id={{ $review->google_book_id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}">
                                               <img class="img-thumbnail" src="https://s3.yomuyo.net/books/{{ $review->thumbnail }}" alt="{{ $review->book_title }}">
                                         </a>
                                     </div>
                                     <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                         <a href="/book/search?name={{ str_limit($review->book_title, $limit = 28, $end = '...') }}">
                                               <h4 class="card-title">{{ str_limit($review->book_title, $limit = 38, $end = '...') }}</h4>
                                         </a>
                                         <hr/>
                                         <a href="/mypage?id={{ $review->google_book_id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}" class="btn btn-primary">登録</a>
                                         
                                         <a href="https://www.amazon.co.jp/s?k={{ $review->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
                                     </div>
                               </div><!-- row -->
                               <hr/>
                               <form action="/comment/create" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $review->id }}">
                                    <input type="hidden" name="title" value="{{ $review->book_title }}">
                                    <input type="hidden" name="thumbnail" value="{{ $review->thumbnail }}">
                                    <div class="form-group">
                                                <textarea name="res" rows="2" class="form-control" style="font-size: 18px;" placeholder="ここにコメントを書いてください。"></textarea>
                                        </div>
                                        <div class="form-group">
                                                <button type="submit" class="btn btn-primary" >コメントする</button>
                                   </div>
                               </form>
                           </div><!-- innerbox -->
                        </div><!--col -->
                   @endforeach
                   <div class="card col-sm-12 col-md-12 col-sm-12" >
                           <div class="innerbox col-xs-12 col-sm-12 col-md-12 col-lg-12"">
                                    {{ $reviews->appends(request()->input())->links() }}
                           </div>
                   </div>
                   

           @else
               <h3>
                     <p>まだ投稿はありません。</p>
                     <p>あなたの感想をみんなに伝えてください。</p>
                     <p>
                         <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumbnail }}&title={{ $item["title"] }}" class="btn btn-primary">この本の感想を投稿する</a>
                     </p>
               </h3>
               </div><!-- row -->
           @endif

      </div><!--card -->
  </div><!-- flex-container -->

@endsection

