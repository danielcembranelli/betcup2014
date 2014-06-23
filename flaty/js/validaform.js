var avisos = new Array();
avisos['carregando'] = "Carregando...";
avisos['erro'] = "Error, tente novamente!";

$(function() {
    $('form.valida').submit(function() {
        var erro = 0;

        $('input.valida, select.valida, textarea.valida', this).each(function() {
            if ($(this).val() == '') {
                $(this).parent().parent().addClass('has-error');
                erro = 1;
            } else
                $(this).parent().parent().removeClass('has-error');
        });

        if (erro)
            return false;

        var aviso = $('#alert');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                aviso.html('<div class="alert alert-info">' + avisos['carregando'] + '</div>').hide().fadeIn('slow');
            },
            error: function(error) {
                aviso.html('<div class="alert alert-danger">' + avisos['erro'] + '</div>').hide().fadeIn('slow');
            },
            success: function(data) {
                if (parseInt(data['retorno'])) {
                    $('html, body').animate({scrollTop: 0}, 1500);
                    aviso.html('<div class="alert alert-success">' + data['aviso'] + '</div>').hide().fadeIn('slow', function() {
                        window.setTimeout(function() {
                            if (parseInt(data['redireciona']))
                                window.location = data['pagina'];
                        }, 3000);
                    });
                } else {
                    aviso.html('<div class="alert alert-danger">' + data['aviso'] + '</div>').hide().fadeIn('slow');
                    $('html, body').animate({scrollTop: 0}, 1500);
                }
            }
        });

        return false;
    });
});