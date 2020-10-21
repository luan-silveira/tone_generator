$(function(){

    $('#form').submit(function(){
        $('#divInfo').hide()
        
        $.post('gerador.php', $(this).serialize(), function(ret){
            if (! ret.sucesso) {
                $('#divInfo').removeClass('alert-info').addClass('alert-danger')
            } else {
                $('#divInfo').removeClass('alert-danger').addClass('alert-info')
            }

            $('#divInfo').text(ret.mensagem).show();
        });

        return false;
    })
});