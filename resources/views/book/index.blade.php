@extends('layouts.top')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
  <!-- <h1><small>Yomuyo -自分を変えた一冊を共有しよう-</small></h1> -->
  <h2 class="top-title">Yomuyo -自分を変えた一冊を共有しよう-</h2>
 </div>

 <div class="top_image col-sm-12 col-md-8 col-lg-8">
  <img src="{{ asset('/images/19212klzds_TP_V.jpg') }}">
  <p>最高の本を伝える<br/>
  新しい本に出会う</p>

  <h2>現在のレビュー総数 <strong>{{ $count }}本!</strong></h2>
  

 </div>



            <div id="toppage-login" class="col-sm-12 col-md-4 col-lg-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                       @csrf

                       SNSアカウントでログイン

                       <div class="social-login" align="center">
                                   <!-- Facebook Login Button -->
                                   <div class="facebook"><a href="{{ url('auth/redirect/facebook')}}">Facebookでログイン</a></div>
                                   <div class="twitter"><a href="{{ url('auth/redirect/twitter')}}">Twitterでログイン</a></div>
                       </div><!-- social-login -->
                        <div align="center">- または -</div>
                        <div class="form-group row">
                            <label for="email" >{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row">
                            <label for="password" >{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
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


 <div class="col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>みんなが読んでる本</h3>
 </div>

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
    @foreach($items as $item)

   <?php
      //var_dump($item);
      //exit();
   ?>

   <div class="card flex-card col-sm-6 col-md-3" >
      @if(isset($item->thumbnail) )
        <div align="center"><a href="/book/detail?id={{ $item->google_book_id }}&thumbnail={{ $item->thumbnail }}&title={{ $item->book_title }}"><img class="img-thumbnail" src="http://s3.yomuyo.net/books/{{ $item->thumbnail }}" alt="{{ $item->book_title }}"></a></div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      @if(isset($item->book_title))
        <a href="/book/search?name={{ str_limit($item->book_title, $limit = 28, $end = '...') }}"><h4 class="card-title">{{ str_limit($item->book_title, $limit = 28, $end = '...') }}</h4></a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="/home?id={$item->thumbnail&title={{ str_limit($item->book_title, $limit = 28, $end = '...') }}, $limit = 16, $end = '') }}" class="btn btn-primary">登録</a> <a href="https://www.amazon.co.jp/s?k={{ $item->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->


    @endforeach
  </div><!-- /.flex-container -->




 <div class="col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>みんなの投稿</h3>
 </div>
 @foreach($items as $item)
 <div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="well well-lg">
       {{ $item->netabare_flag  }}     
    </div>

   </div>
 </div><!-- row -->



 @endforeach




@endsection
