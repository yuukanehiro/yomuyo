@extends('layouts.top')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
           <h2 class="top-title">Yomuyo -自分を変えた1冊を共有しよう-</h2>
 </div>

 <div class="top_image col-sm-12 col-md-8 col-lg-8">
     <img src="{{ asset('/images/19212klzds_TP_V.jpg') }}">
     <p>
            <span style="font-size: 4rem;">最</span>高の本を伝える。<br/>
            <span style="font-size: 4rem;">本</span>に出会う。
     </p>
     <h2 style="height: 10%;">現在のレビュー総数 <strong>{{ $count }}本!</strong></h2>
 </div><!-- top_image col-->



            <div id="toppage-login" class="col-sm-12 col-md-4 col-lg-4" >
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                       @csrf
                       SNSアカウントでログイン
                       <div class="social-login" align="center">
                                   <!-- Facebook Login Button -->
                                   <div class="facebook">
                                           <a href="{{ url('auth/redirect/facebook')}}">Facebookでログイン</a>
                                   </div>
                                   <div class="twitter">
                                           <a href="{{ url('auth/redirect/twitter')}}">Twitterでログイン</a>
                                   </div>
                       </div><!-- social-login -->
                        <div align="center">- または -</div>
                        <div class="form-group row" align="center">
                            <label for="email" >{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row" align="center">
                            <label for="password" >{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row" align="center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember" style="font-size: 10px;">
                                        {{ __('Remember Me') }}
                                    </label>

                                   <label>
                                       <button type="submit" class="btn btn-primary submit-button">
                                       {{ __('Login') }}
                                       </button>
                                   </label>

                                   <a class="btn btn-link" href="{{ route('password.request') }}">
                                       {{ __('Forgot Your Password?') }}
                                   </a>
                                </div>
                        </div>
                    </form>
               </div><!-- card-body -->
            </div><!-- toppage-login -->


 <div class="top-title col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>みんなが読んでる本 <br/><img src="{{ asset('/images/ranking_r1.gif')  }}">デイリーランキング　<a href="#">もっとみる</a></h2>
 </div>

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
    @php $i = 1; @endphp
    @foreach($items as $item)

   <div class="card flex-card col-sm-6 col-md-2" >
      @if(isset($item->thumbnail) )
        <div align="center">
          <a href="/book/detail?id={{ $item->google_book_id }}&thumbnail={{ $item->thumbnail }}&title={{ $item->book_title }}">
                <span class="rank_num">{{ $i }}</span>
                         <img class="img-thumbnail" src="https://s3.yomuyo.net/books/{{ $item->thumbnail }}" alt="{{ $item->book_title }}">
          </a>
        </div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      <?php
          //var_dump($item);
          //exit();
      ?>
      @if(isset($item->book_title))
        <a href="/book/search?name={{ str_limit($item->book_title, $limit = 28, $end = '...') }}">
              <h4 class="card-title">{{ str_limit($item->book_title, $limit = 28, $end = '...') }}</h4>
        </a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="/mypage?id={$item->thumbnail&title={{ str_limit($item->book_title, $limit = 28, $end = '...') }}, $limit = 16, $end = '') }}" class="btn btn-primary">登録</a>
        　<a href="https://www.amazon.co.jp/s?k={{ $item->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->
      @php $i++ @endphp
    @endforeach
    <hr/>
  </div><!-- /.flex-container -->


 <div class="container col-sm-12 col-md-12 col-lg-12">

  <h2>みんなの投稿</h2>

  <div class="row row-eq-height">
  @foreach($reviews as $review)
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" >
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
               <a href="/home?id={$review->thumbnail&title={{ str_limit($review->book_title, $limit = 28, $end = '...') }}, $limit = 16, $end = '') }}" class="btn btn-primary">登録</a> <a href="https://www.amazon.co.jp/s?k={{ $review->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
             </div>
           </div><!-- row -->
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
    </div>
  @endforeach

 
  </div><!-- row -->
    <div class="innerbox">
            {{ $reviews->links() }}
    </div>

 </div><!-- container -->


@endsection
