$(function () {
    $("#makeShort").submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation;
        var error_message = '';

        $(".messages").empty();


        if ($("#origin_url").val() == '') {
            error_message = 'Надо вставить ссылку в это поле'
            $("<p class='errors'>" + error_message + "</p>").prependTo($(".messages"));
            $("#origin_url").css("border-color", "#cc0000")
        } else {
            error_message = '';
            $(".messages").empty();
            $("#origin_url").css("border-color", "")
        }

        if (error_message !== '') {
            return false;
        }

        var th = $(this);
        $.ajax({
            url: "/shortlink",
            method: "post",
            dataType: "json",
            data: th.serialize(),
            success: function (r) {
                if (r.code == 200){
                    $("#success").empty();

                    $("#origin_url").val('');

                    $("<input type='text' name='result' class='success_input' id='result'>").prependTo($("#success"));
                    $("#result").val(r.shortlink);

                    $("#success").append("<a class='success_bth'>Copy</a>");

                    activationCopy()

                } else if(r.code == 500){
                    $("<p class='errors'>что-то сломалось на сервере</p>").prependTo($(".messages"));

                }
            }
        })
        return false;



    })

    function activationCopy(){
        $(".success_bth").on('click',function () {

            var copyText = document.getElementById("result");
            copyText.select();
            document.execCommand("copy");
            // alert("Copied the text: " + copyText.value);
        })

    }


})