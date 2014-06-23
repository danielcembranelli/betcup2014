var avisos = new Array();
avisos['carregando'] = "Carregando...";
avisos['erro'] = "Error, tente novamente!";
$(function() {
    $('a.excluir').click(function() {
        if (confirm($(this).data('aviso'))) {
            var aviso = $('#alert');
            $.ajax({
                url: $(this).data('url'),
                type: 'GET',
                beforeSend: function() {
                    aviso.html('<div class="alert alert-info">' + avisos['carregando'] + '</div>').hide().fadeIn('slow');
                },
                error: function(error) {
                    aviso.html('<div class="alert alert-danger">' + avisos['erro'] + '</div>').hide().fadeIn('slow');
                },
                success: function(data) {
                    if (parseInt(data['retorno'])) {
                        aviso.html('<div class="alert alert-success">' + data['aviso'] + '</div>').hide().fadeIn('slow', function() {
                            if (parseInt(data['redireciona']))
                                window.location = data['pagina'];
                        });
                    } else
                        aviso.html('<div class="alert alert-danger">' + data['aviso'] + '</div>').hide().fadeIn('slow');
                }
            });
        }
        return false;
    });
});