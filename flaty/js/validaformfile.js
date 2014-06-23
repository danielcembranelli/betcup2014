var avisos = new Array();
avisos['carregando'] = "Carregando...";
avisos['erro'] = "Error, tente novamente!";

$(document).ready(function() {

    var options = {
        dataType: 'json',
        beforeSend: function() {
            $("#progress").show();
            $("#bar").width('0%');
            $("#percent").html("0%");
            $('#alert').html('<div class="alert alert-info">' + avisos['carregando'] + '</div>').hide().fadeIn('slow');
        },
        uploadProgress: function(event, position, total, percentComplete) {
            $("#bar").width(percentComplete + '%');
            $("#percent").html(percentComplete + '%');
        },
        success: function() {
            $("#bar").width('100%');
            $("#percent").html('100%');
        },
        complete: function(data) {
            if (parseInt(data.responseJSON['retorno'])) {
                $('#alert').html('<div class="alert alert-success">' + data.responseJSON['aviso'] + '</div>').hide().fadeIn('slow', function() {
                    if (parseInt(data.responseJSON['redireciona']))
                        window.location = data.responseJSON['pagina'];
                });
            } else
                $('#alert').html('<div class="alert alert-danger">' + data.responseJSON['aviso'] + '</div>').hide().fadeIn('slow');
        },
        error: function() {
            $('#alert').html('<div class="alert alert-danger">' + avisos['erro'] + '</div>').hide().fadeIn('slow');
        }
    };

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

        $('form.valida').ajaxSubmit(options);

        return false;
    });

});