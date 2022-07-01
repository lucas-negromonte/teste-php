$(document).ready(function(e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    cards();

    function cards() {
        var dados = $(".quick_filter").serialize();

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
    }

    $(document).on("click", "[data-update]", function() {
        // console.log($(this).data('id_professor'));

        if ($(this).data('action') == 'back' || $(this).data('action') == 'next') {
            if ($(this).data('id_professor') == '') {
                alert('professor não encontrado. ');
                return;
            }
        }

        exec($(this));
    });

    $(".quick_filter").change(function() {
        cards();
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

        //  modal
        if (response.modal) {
            var arr = response.modal;
            for (const [key, value] of Object.entries(arr)) {
                $(key).modal(value);
            }
        }
    }
});