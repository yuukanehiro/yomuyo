<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="/css/sticky-footer.css" rel="stylesheet" media="screen">

    <!-- Facebook Login -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v3.3&appId=2424318574469139&autoLogAppEvents=1"></script>

</head>
<body>
<!-- ヘッダー -->
@include('layouts.partials.header')

<div class="container">

  <div class="row" id="content">
  <div class="col-md-12">
  <!-- コンテンツ -->
  @yield('content')
  </div>
  </div>

</div>


<!-- フッター -->
@include('layouts.partials.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
