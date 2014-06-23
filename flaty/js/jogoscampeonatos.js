$(function() {
    $(".hora").mask("99:99");
    $('.data').mask("99/99/9999");
    $('.data').datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Ter&ccedil;a', 'Quarta', 'Quinta', 'Sexta', 'S&aacute;bado', 'Domingo'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'S&aacute;b', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Pr&oacute;ximo',
        prevText: 'Anterior'
    });

    $('.box-menu').click(function() {
        var idFase = $(this).data('box');
        $('.box-menu').each(function() {
            $('#' + $(this).data('box')).hide();
            $(this).removeClass('active');
        });
        $('#' + idFase).fadeIn('slow');
        $(this).addClass('active');
    });

    $('.defesa').click(function() {
        if ($(this).val() === "penalti") {
            $(this).parent().parent().find('td.penaltis-vazio').hide();
            $(this).parent().parent().find('td.penaltis').show();
        } else {
            $(this).parent().parent().find('td.penaltis').hide();
            $(this).parent().parent().find('td.penaltis-vazio').show();
        }
    });
});