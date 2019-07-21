@extends('layouts.app')

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
                    </div>

                </div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    読んだ本を探して感想を伝えよう！

                    <hr/>

                    <div align="center">
                    aaa 
                    </div>

                </div>




            </div>
        </div>
    </div>
</div>






@endsection
