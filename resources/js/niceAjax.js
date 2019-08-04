$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(".button-nice").click(function(e){
        e.preventDefault(); //デフォルトアクションを抑止
        
        $.ajax({
            type: "POST",
            ur:  "/nices/firstOrNew",
        });

})











