@extends('layouts.app')
@section('title', 'ログイン')
@section('content')
    <div class="login-bg">
        <div class="login-bg-text">
            最高の本を伝える。本に出会う。
        </div><!-- login-bg-text -->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Login') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                            SNSアカウントでログイン                       

                            <div class="social-login" align="center">
                                    <div class="col-sm-6 col-md-6 col-lg-6" >
                                        <!-- Facebook Login Button -->
                                        <div class="facebook"><a href="{{ url('auth/redirect/facebook')}}">Facebookでログイン</a></div>
                                        <div class="twitter"><a href="{{ url('auth/redirect/twitter')}}">Twitterでログイン</a></div>
                                    </div>
                            </div><!-- social-login -->
                                <div align="center">- または -</div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-sm-8 col-md-8 col-lg-8 offset-sm-4 offset-md-4 offset-lg-4"> 
                                        <div class="col-sm-8 col-md-8 col-lg-8">
                                        <button type="submit" class="btn btn-primary submit-button">
                                            {{ __('Login') }}
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- login-bg -->

@endsection
