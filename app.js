$(function () {

    $('#form').submit(function () {
        var data = $(this).serialize();
        $('#divInfo').hide()

        desativarForm();
        $.ajax({
            url: 'gerador.php',
            type: 'POST',
            data,
            cache: false,
            success: function (ret) {
                if (!ret.sucesso) {
                    $('#divInfo').removeClass('alert-info').addClass('alert-danger')
                } else {
                    $('#divInfo').removeClass('alert-danger').addClass('alert-info')
                }

                $('#divInfo').text(ret.mensagem).show();
                $('#audio').attr('src', ret.arquivo).show();
            },

            complete: function () {
                desativarForm(false)
            }
        });

        return false;
    });

    function desativarForm(boolDesativar = true) {
        $(':input').prop('disabled', boolDesativar);
        $('.spinner-border').toggle(boolDesativar);
    }
});