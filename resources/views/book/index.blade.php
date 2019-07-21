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

  <h2>現在のレビュー総数 <strong>6本!</strong></h2>
  

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

 <div class="col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>みんなの投稿</h3>
 </div>


@endsection
