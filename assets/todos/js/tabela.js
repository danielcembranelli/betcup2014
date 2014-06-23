$(function() {

    $('input[type=radio]').click(function() {

        if($(this).val() === "a") {
            if($.trim($(this).parent().parent().find('label:eq(1) span').html()) === "-")
                return false;
        } else {
            if($.trim($(this).parent().parent().find('label:eq(0) span').html()) === "-")
                return false;
        }

        var tipo = $(this).parent().attr('class');
        var jogo = $(this).attr('name').match(/\[([0-9]*)\]/)[1];

        var timea = $.trim($(this).parent().parent().find('label:eq(0) span').html());
        var timeb = $.trim($(this).parent().parent().find('label:eq(1) span').html());
        
        var jogos = new Array();
        jogos[49] = [0, 57];
        jogos[50] = [1, 57];
        jogos[51] = [0, 59];
        jogos[52] = [1, 59];
        jogos[53] = [0, 58];
        jogos[54] = [1, 58];
        jogos[55] = [0, 60];
        jogos[56] = [1, 60];
        jogos[57] = [0, 61];
        jogos[58] = [1, 61];
        jogos[59] = [0, 62];
        jogos[60] = [1, 62];
        jogos[61] = [0, 64];
        jogos[62] = [1, 64];

        var jogoAnterior = verificaJogo = jogo;

        var html, option;

        verificaTimes = true;
        while (verificaTimes) {
            verificaJogo = jogos[verificaJogo][1];

            var verificaTimea = $.trim($('#jogo-' + verificaJogo).find('label:eq(0) span').html());
            var verificaTimeb = $.trim($('#jogo-' + verificaJogo).find('label:eq(1) span').html());

            if (verificaTimea === timea || verificaTimea === timeb || verificaTimeb === timea || verificaTimeb === timeb) {
                $('#jogo-' + verificaJogo).find('label:eq(' + jogos[jogoAnterior][0] + ') span').html('-');
            }
            
            if (verificaJogo === 64) {
                verificaTimea = $.trim($('#jogo-63').find('label:eq(0) span').html());
                verificaTimeb = $.trim($('#jogo-63').find('label:eq(1) span').html());

                if (jogoAnterior === 61) {
                    if (verificaTimea === timea || verificaTimea === timeb)
                        $('#jogo-63').find('label:eq(0) span').html('-');
                } else {
                    if (verificaTimeb === timea || verificaTimeb === timeb)
                        $('#jogo-63').find('label:eq(1) span').html('-');
                }
                
                verificaTimes = false;
            }
            jogoAnterior = verificaJogo;
        }
        
        if ($(this).val() === "a") {
            time = timea;
        } else {
            time = timeb;
        }
        
        $('#jogo-' + jogos[jogo][1]).find('label:eq(' + jogos[jogo][0] + ') span').html(time);
        
        if (jogo === '61' || jogo === '62') {            
            if ($(this).val() === "a") {
                time = timeb;
            } else {
                time = timea;
            }
            $('#jogo-63').find('label:eq(' + jogos[jogo][0] + ') span').html(time);
        }

        $('table tbody tr td').each(function() {
            $(this).find('div').each(function() {
                var timea = $.trim($(this).find('label:eq(0) span').html());
                var timeb = $.trim($(this).find('label:eq(1) span').html());
                
                if(timea === "-" || timeb === "-") {
                    $(this).find('label:eq(0) input').prop('checked', false);
                    $(this).find('label:eq(1) input').prop('checked', false);
                }
            });
        });
        
    });

});