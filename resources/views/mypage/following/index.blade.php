@extends('layouts.app')
@section('title', 'マイページ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">こんにちは！<b>{{ $user->name }}</b>さん。</div>
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



<!-- エラー表示 -->
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
<!-- /エラー表示 -->






<div class="container">
        <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header"></div>
                            <div class="card-body">
                                <h2>
                                    <b>{{ $user->name }} さん</b>
                                </h2>
                                {{ $user->comment }}
                                <hr>
                                <a href="{{ $user->website }}" target="_blank"><i class='fas fa-home'></i> {{ $user->website }}</a>
                                <hr>
                                <section class="post" data-follow_user_id="{{ $user->id }}" @if(Auth::check())
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
                                                                @if( isset($user->id) && $user->id !== $login_user->id )
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
                                <a href="/follow/?user_id={{ $user->id }}?user_name={{ $user->name }}&cnt_following={{ $request['cnt_following'] }}">
                                      <div class="cnt_following">フォロー中(<span>{{ $request['cnt_following'] }}</span>)</div>
                                </a>
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















@endsection
