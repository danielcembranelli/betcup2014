$(function() {

    $('.dica a').click(function() {
        $(this).fadeOut('slow', function() {
            $(this).parent().find('div').fadeIn('slow');
        });
        return false;
    });

    $('select').each(function() {
        if ($(this).find('option').length === 3)
            $(this).prop('disabled', false);
        else
            $(this).prop('disabled', 'disabled');
    });

    $('select').change(function() {
        var timea = $.trim($(this).parent().parent().find('label:eq(0)').html().split('>')[0] + '>');
        var timeb = $.trim($(this).parent().parent().find('label:eq(1)').html().split('>')[0] + '>');
        var jogo = $(this).attr('name').match(/\[([0-9]*)\]/)[1];

        if(jogo === '64') {
            var nDefesaBold = ($(this).val() === 'a') ? '1' : '2';
            var nDefesaNormal = ($(this).val() === 'a') ? '2' : '1';
            $("#jogo-64 label:nth-child("+nDefesaBold+")").css('font-weight', 'bold');
            $("#jogo-64 label:nth-child("+nDefesaNormal+")").css('font-weight', 'normal');
        }

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

        if ($(this).val() === '') {
            verificaTimes = true;
            while (verificaTimes) {
                verificaJogo = jogos[verificaJogo][1];

                var verificaTimea = $.trim($('#jogo-' + verificaJogo).find('label:eq(0)').html().split('>')[0] + '>');
                var verificaTimeb = $.trim($('#jogo-' + verificaJogo).find('label:eq(1)').html().split('>')[0] + '>');

                if (verificaTimea === timea || verificaTimea === timeb || verificaTimeb === timea || verificaTimeb === timeb)
                    $('#jogo-' + verificaJogo).find('label:eq(' + jogos[jogoAnterior][0] + ')').html('-');

                $('select[name="defesa[' + verificaJogo + ']"] option').each(function() {
                    if ($(this).html() === $(timea).attr('alt') || $(this).html() === $(timeb).attr('alt'))
                        $(this).remove();
                });

                if (verificaJogo === 64) {
                    var i;
                    if (jogoAnterior === 61)
                        i = 0;
                    else
                        i = 1;

                    verificaTimea = $.trim($('#jogo-63').find('label:eq(0)').html().split('>')[0] + '>');
                    verificaTimeb = $.trim($('#jogo-63').find('label:eq(1)').html().split('>')[0] + '>');

                    if (verificaTimea === timea || verificaTimea === timeb || verificaTimeb === timea || verificaTimeb === timeb)
                        $('#jogo-63').find('label:eq(' + i + ')').html('-');

                    $('select[name="defesa[63]"] option').each(function() {
                        if ($(this).html() === $(timea).attr('alt') || $(this).html() === $(timeb).attr('alt'))
                            $(this).remove();
                    });

                    verificaTimes = false;
                }
                jogoAnterior = verificaJogo;
            }

            $('select').each(function() {
                if ($(this).find('option').length === 3)
                    $(this).prop('disabled', false);
                else
                    $(this).prop('disabled', 'disabled');
            });
        } else {
            var html, option;

            verificaTimes = true;
            while (verificaTimes) {
                verificaJogo = jogos[verificaJogo][1];

                var verificaTimea = $.trim($('#jogo-' + verificaJogo).find('label:eq(0)').html().split('>')[0] + '>');
                var verificaTimeb = $.trim($('#jogo-' + verificaJogo).find('label:eq(1)').html().split('>')[0] + '>');

                if (verificaTimea === timea || verificaTimea === timeb || verificaTimeb === timea || verificaTimeb === timeb)
                    $('#jogo-' + verificaJogo).find('label:eq(' + jogos[jogoAnterior][0] + ')').html('-');

                $('select[name="defesa[' + verificaJogo + ']"] option').each(function() {
                    if ($(this).html() === $(timea).attr('alt') || $(this).html() === $(timeb).attr('alt'))
                        $(this).remove();
                });

                if (verificaJogo === 64) {
                    verificaTimea = $.trim($('#jogo-63').find('label:eq(0)').html().split('>')[0] + '>');
                    verificaTimeb = $.trim($('#jogo-63').find('label:eq(1)').html().split('>')[0] + '>');

                    if (jogoAnterior === 61) {
                        if (verificaTimea === timea || verificaTimea === timeb)
                            $('#jogo-63').find('label:eq(0)').html('-');
                    } else {
                        if (verificaTimeb === timea || verificaTimeb === timeb)
                            $('#jogo-63').find('label:eq(1)').html('-');
                    }

                    $('select[name="defesa[63]"] option').each(function() {
                        if ($(this).html() === $(timea).attr('alt') || $(this).html() === $(timeb).attr('alt'))
                            $(this).remove();
                    });

                    verificaTimes = false;
                }
                jogoAnterior = verificaJogo;
            }
            
            var valor = (jogos[jogo][0] === 0) ? 'a' : 'b', time;
            if ($(this).val() === "a") {
                time = timea;
                option = '<option value="' + valor + '">' + $(timea).attr('alt') + '</option>';
            } else {
                time = timeb;
                option = '<option value="' + valor + '">' + $(timeb).attr('alt') + '</option>';
            }

            if (jogos[jogo][0] === 0) {
                $('select[name="defesa[' + jogos[jogo][1] + ']"] option:eq(0)').after(option);
                html = time; // + ' <input type="text" name="golsa[' + jogos[jogo][1] + ']" maxlength="2">';
            } else {
                $('select[name="defesa[' + jogos[jogo][1] + ']"]').append(option);
                html = time; // + ' <input type="text" name="golsb[' + jogos[jogo][1] + ']" maxlength="2">';
            }
            
            $('#jogo-' + jogos[jogo][1]).find('label:eq(' + jogos[jogo][0] + ')').html((jogo === '61' || jogo === '62') ? html + ' ' + $(html).attr('alt') : html);

            if (jogo === '61' || jogo === '62') {

                if ($(this).val() === "a") {
                    time = timeb;
                    option = '<option value="' + valor + '">' + $(timeb).attr('alt') + '</option>';
                } else {
                    time = timea;
                    option = '<option value="' + valor + '">' + $(timea).attr('alt') + '</option>';
                }

                if (jogos[jogo][0] === 0) {
                    $('select[name="defesa[63]"] option:eq(0)').after(option);
                    html = time; // + ' <input type="text" name="golsa[63]" maxlength="2">';
                } else {
                    $('select[name="defesa[63]"]').append(option);
                    html = time; // + ' <input type="text" name="golsb[63]" maxlength="2">';
                }

                $('#jogo-63').find('label:eq(' + jogos[jogo][0] + ')').html(html + ' ' + $(html).attr('alt'));
            }

            $('select').each(function() {
                if ($(this).find('option').length === 3)
                    $(this).prop('disabled', false);
                else
                    $(this).prop('disabled', 'disabled');
            });
        }

    });

});