

$(".btn-nice").click(function(event){
    // ページ遷移をキャンセル
    event.stopPropagation();

    // Ajax
    $.ajax({
                type:     'POST',
                datatype: 'json',
                url:      '/nice/create',
                timeout:  10000,
                data: {

                      }
    })
    .done(function(data){ //ajaxの通信に成功した場合
                alert("success!");
                console.log(data['status']);
                console.log(data['message']);
        $("#example").html(data['status']+' '+data['message']);
    })
    .fail(function(data){ //ajaxの通信に失敗した場合
        alert("error!");
    });
});



