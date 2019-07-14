<!-- header & grobal navi -->
<nav class="navbar navbar-default" style="background-color: #FFFFFF;">
  <div class="container-fluid">
  <div class="navbar-header">
   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarEexample2">
   <span class="sr-only">Toggle navigation</span>
   <span class="icon-bar"></span>
   <span class="icon-bar"></span>
   </button>

   <a class="navbar-brand" href="/"><img src="{{ asset('/images/yomuyo_logo.gif') }}"></a>
  </div>
  <div class="collapse navbar-collapse" id="navbarEexample2">
   <ul class="nav navbar-nav">
    <li><a href="/register"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">新規登録(無料)</a></li>
    <li><a href="/login"><img src="{{ asset('/images/profile_default_icon_sample.gif') }}">ログイン</a></li>
    <li><a href="/login"><img src="{{ asset('/images/profile_default_icon.gif') }}">マイページ</a></li>
   </ul>
  </div>
  </div>
</nav>

<div class="well well-sm">知って貰いたい本を探して伝えよう！</div>

<div align="center">
  <form action="/book/search" method="POST">
   {{ csrf_field() }}
   著者・タイトル
   <input type="text" name="name" />
   <input type="submit" value="検索" />
   @if($errors->has('name'))
     <tr><th><td><span class="error_mes">{{ $errors->first('name') }}</span></td></tr>
   @endif
  </form>
</div>

<hr/>
