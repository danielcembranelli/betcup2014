$(function() {
    $('form.valida').validate({
        submitHandler: function() {
            $.ajax({
                type: 'POST',
                url: $('form.valida').attr('action'),
                data: $('form.valida').serialize(),
                beforeSend: function() {
                    $('#loading_form').show();
                    $('input[type=submit]').hide();
                },
                success: function(data) {
                    $('#loading_form').fadeOut();
                    $('.form_resposta').html(data['aviso']).hide().slideDown();
                    $('html, body').animate({scrollTop: 0}, 1500);
                    if (parseInt(data['retorno'])) {
                        if (parseInt(data['redireciona']))
                            window.location = data['pagina'];
                    }
                    $('input[type=submit]').show();
                }
            });

        }
    });
});