

$(function(){
    $('.btn-follow').click(function(event){
        // ページ遷移をキャンセル
        event.stopPropagation();

        // CSRFトークンの取得 
        $.ajaxSetup({
            timeout: 3000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 変数設定
        var CSRF_TOKEN      = $('meta[name="csrf-token"]').attr('content');
        var $this           = $(this);
        var follow_user_id  = $this.parent('.post').data('follow_user_id');
        var login_user_id   = $this.parent('.post').data('login_user_id');

        // Ajax設定 ============================================================================
        $.ajax({
                    type:     'POST',
                    datatype: 'json',
                    url:      '/followAjax',
                    timeout:  3000,
                    data: {
                              _token:         CSRF_TOKEN,       // CSRFトークン
                              follow_user_id: follow_user_id,   // フォロー対象のユーザID
                              login_user_id:  login_user_id     // フォローボタンを押したログインユーザのID
                          }
        })
        // Ajax成功時の処理 ===========================
        .done(function(data){
                    console.log("Ajax Success!");
            
                    // いいねの総数を表示
                    $('.cnt_following').children('span').html(data);

                    // ボタンの文字と色を変更する
                    if($this.children('i').text() === 'フォロー')
                    {
                        $this.children('i').text('フォロー中');
                        $this.children('i').removeClass('btn-primary');
                        $this.children('i').addClass('btn-success');
                    }else{
                        $this.children('i').text('フォロー');
                        $this.children('i').removeClass('btn-success');
                        $this.children('i').addClass('btn-primary');
                    }
                    
        })
        // Ajax通信失敗時の処理 ========================
        .fail(function(data){
                    console.log('Ajax Error');
        });
    });
});


