$(document).ready(function(e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var dados = 'id_pedido=123';
    $.ajax({
        url: $("#app").data("url"),
        type: 'POST',
        data: dados,
        dataType: 'json',
        error: function(data) {
            alert('Erro ao consultar, verifique o log');
        },
        success: function(response) {
            ajaxOk(response);
        }
    });


    $(document).on("click", "[data-update]", function() {
        exec($(this));
    });


    function exec(clicked) {
        var dataset = clicked.data();
        $.post(clicked.attr("data-url"), dataset, function(response) {
                ajaxOk(response);
            }, "json")
            .fail(function() {
                alert('Erro ao consultar, verifique o log');
            });
    }

    function ajaxOk(response) {

        // alterar htmls
        if (response.html) {
            var arr = response.html;
            for (const [key, value] of Object.entries(arr)) {
                $(key).html(value);
            }
        }
    }
});