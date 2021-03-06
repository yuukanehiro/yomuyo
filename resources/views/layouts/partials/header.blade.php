<!-- header & grobal navi -->
<nav class="navbar navbar-default" style="background-color: #FFFFFF;">
      <div class="container-fluid">
              <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarEexample2">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                      </button>

                      <a class="navbar-brand"  href="/"><img src="{{ asset('/images/yomuyo_logo.gif') }}"></a>
              </div>
              <div class="collapse navbar-collapse  col-md-6 col-lg-6" id="navbarEexample2">
                      @if(Auth::check())
                            <!-- ログイン中に表示するメニュー -->
                            <ul class="nav navbar-nav">
                                    <li><a href="/#"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">つながる</a></li>
                                    <li><a href="{{ url('/logout') }}"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">ログアウト</a></li>
                                    <li><a href="/mypage"><img src="{{ asset('/images/profile_default_icon.gif') }}">マイページ</a></li>
                            </ul>
                      @else
                            <!-- 非ログインのゲスト用に表示するメニュー -->
                            <ul class="nav navbar-nav">
                                    <li><a href="/register"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">新規登録(無料)</a></li>
                                    <li><a href="/login"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">つながる</a></li>
                                    <li><a href="/login"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">ログイン</a></li>
                                    <li><a href="/mypage"><img src="{{ asset('/images/profile_default_icon.gif') }}">マイページ</a></li>
                            </ul>
                      @endif

              </div>
      </div>
</nav>

    <div class="well well-sm">知って貰いたい本を探して伝えよう！
        <div id="sub-nav">
            <a href="/">
                    <span class="home">トップ</span>
            </a>
            <a href="/ranking">
                    <span class="ranking">ランキング</span>
            </a>
            <a href="/describe">
                    <span class="readme">Yomuyoとは</span>
            </a>
            <!-- 名前の表示 -->
            @if(Auth::check())
                    <p style="text-align: right;">ようこそ！ <b>{{ Auth::user()->name }}</b>さん</p>
            @else 
                    <p style="text-align: right;">ようこそ！ <b>ゲスト</b>さん</p>
            @endif
        </div><!-- sub-nav -->
    </div><!-- well well-sm -->
    





<!-- CSRF 419エラーによる案内 Start -->
@if (Session::has('flash_error_message'))
        <div class="container-fluid alert myAlert alert-warning">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div>{{ Session::get('flash_error_message') }}</div>
                    </div>
                </div>
            </div>
        </div>
@endif
<!-- CSRF 419エラーによる案内 End -->



<div align="center">
  <form action="/book/search" method="POST">
      @csrf
      <h3 class="search">本を探そう</h3>
      <input type="text" name="name" placeholder="本のタイトル・著者名" onfocus="this.placeholder=''" onblur="this.placeholder='本のタイトル・著者名'"/>
      <input type="submit" value="検索" class="submit-button" />

      <!-- エラー表示 Start -->
      @if($errors->any())
      <hr/>
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-sm-12 col-md-12 col-lg-12">
                  <span class="error_mes">
                      @foreach($errors->all() as $message)
                          {{ $message }}
                      @endforeach
                  </span>
              </div><!-- col -->
          </div><!-- row -->
      </div><!-- container -->
      @endif      
      <!-- エラー表示 End -->
  </form>
</div>


<hr/>
