<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

        <script type="text/javascript" src="<?php echo base_url('assets/todos/js/form.js'); ?>"></script>

        <script type="text/javascript">
            var f = 0;
            
            function atualizaGrid(grupo) {
                var f = 1;

                var time1 = $.trim($('#'+grupo+' table tbody tr:nth-child(1) td:nth-child(4) label:nth-child(1) img').attr('title'));
                var time2 = $.trim($('#'+grupo+' table tbody tr:nth-child(1) td:nth-child(4) label:nth-child(3) img').attr('title'));
                var time3 = $.trim($('#'+grupo+' table tbody tr:nth-child(2) td:nth-child(4) label:nth-child(1) img').attr('title'));
                var time4 = $.trim($('#'+grupo+' table tbody tr:nth-child(2) td:nth-child(4) label:nth-child(3) img').attr('title'));

                var fotoTime1 = $.trim($('#'+grupo+' table tbody tr:nth-child(1) td:nth-child(4) label:nth-child(1) img').attr('src'));
                var fotoTime2 = $.trim($('#'+grupo+' table tbody tr:nth-child(1) td:nth-child(4) label:nth-child(3) img').attr('src'));
                var fotoTime3 = $.trim($('#'+grupo+' table tbody tr:nth-child(2) td:nth-child(4) label:nth-child(1) img').attr('src'));
                var fotoTime4 = $.trim($('#'+grupo+' table tbody tr:nth-child(2) td:nth-child(4) label:nth-child(3) img').attr('src'));

                var pontos1 = 0;
                var pontos2 = 0;
                var pontos3 = 0;
                var pontos4 = 0;

                var i = 1;
                while (i <= 6) {
                    j = 1;
                    while (j <= 3) {
                        if (j !== 2) {
                            var lb = $('#'+grupo+' table tbody tr:nth-child(' + i + ') td:nth-child(4) label:nth-child(' + j + ') input[type=radio]').is(':checked');
                            var time = $('#'+grupo+' table tbody tr:nth-child(' + i + ') td:nth-child(4) label:nth-child(' + j + ') img').attr('title');
                            if (lb === true && time === time1)
                                pontos1++;
                            if (lb === true && time === time2)
                                pontos2++;
                            if (lb === true && time === time3)
                                pontos3++;
                            if (lb === true && time === time4)
                                pontos4++;
                        }
                        j++;
                    }

                    if ($('#'+grupo+' table tbody tr:nth-child(' + i + ') td:nth-child(4) label:nth-child(1) input[type=radio]').is(':checked') === false &&
                            $('#'+grupo+' table tbody tr:nth-child(' + i + ') td:nth-child(4) label:nth-child(2) input[type=radio]').is(':checked') === false &&
                            $('#'+grupo+' table tbody tr:nth-child(' + i + ') td:nth-child(4) label:nth-child(3) input[type=radio]').is(':checked') === false)
                        f = 0;

                    i++;
                }

                if (f) {
                    
                    var times = {"times": [{
                                "time": time1,
                                "foto": fotoTime1,
                                "pontos": pontos1
                            }, {
                                "time": time2,
                                "foto": fotoTime2,
                                "pontos": pontos2
                            }, {
                                "time": time3,
                                "foto": fotoTime3,
                                "pontos": pontos3
                            }, {
                                "time": time4,
                                "foto": fotoTime4,
                                "pontos": pontos4
                            }]};
                    
                    var sortTimes = times['times'];
                    
                    sortTimes.sort(function(a, b) {
                        if (a.pontos < b.pontos)
                            return -1;
                        if (a.pontos > b.pontos)
                            return 1;
                        return 0;
                    });
                    
                    var idGrid = grupo.split('-')[1];
                    
                    $('#' + idGrid + '1').html('<img src="'+sortTimes[3]['foto']+'" alt="'+sortTimes[3]['time']+'" title="'+sortTimes[3]['time']+'" />');
                    $('#' + idGrid + '2').html('<img src="'+sortTimes[2]['foto']+'" alt="'+sortTimes[2]['time']+'" title="'+sortTimes[2]['time']+'" />');
                   
                   idGrid = idGrid.toUpperCase();
                   
                    var foto1 = (sortTimes[3]['foto'].substring(sortTimes[3]['foto'].lastIndexOf('/')+1));
                    var foto2 = (sortTimes[2]['foto'].substring(sortTimes[2]['foto'].lastIndexOf('/')+1));
                    
                    $('select[name="classificadoA['+idGrid+']"] option:selected').removeAttr('selected');
                    $('select[name="classificadoB['+idGrid+']"] option:selected').removeAttr('selected');
                    
                    $('select[name="classificadoA['+idGrid+']"] option[foto="'+foto1+'"]').prop('selected', true);
                    $('select[name="classificadoB['+idGrid+']"] option[foto="'+foto2+'"]').prop('selected', true);

                }
            }

            $(document).ready(function() {
            
                $('#tab-container').easytabs();

                $('#mostrar-todas-dicas').click(function() {

                    var url = window.location.hash;
                    var grupo = url.substr(1);
                    if (grupo === '')
                        grupo = "grupo-a";

                    $('#' + grupo + ' table tbody tr').each(function() {
                        $('td:nth-child(5) .dica a', this).fadeOut('slow', function() {
                            $(this).parent().find('div').fadeIn('slow');
                            $(this).parent().parent().parent().find('td:nth-child(4)').find('label:nth-child(' + $(this).attr('href').substring(1) + ')').find('input').prop('checked', true);
                            atualizaGrid(grupo);
                        });
                    });
                    
                    return false;
                });

                $('.dica a').click(function() {

                    $(this).fadeOut('slow', function() {
                        $(this).parent().find('div').fadeIn('slow');
                        $(this).parent().parent().parent().find('td:nth-child(4)').find('label:nth-child(' + $(this).attr('href').substring(1) + ')').find('input').prop('checked', true);
                        atualizaGrid($(this).parent().parent().parent().parent().parent().parent().attr('id'));
                    });
                    
                    return false;
                });

                $('.btn-proxima-fase').click(function() {
                    f = 1;

                    $('.panel-container div table tbody tr td:nth-child(4)').each(function() {
                        if ($('label:nth-child(1) input[type=radio]', this).is(':checked') === false &&
                                $('label:nth-child(2) input[type=radio]', this).is(':checked') === false &&
                                $('label:nth-child(3) input[type=radio]', this).is(':checked') === false) {
                            var grupo = $(this).parent().parent().parent().parent().attr('id');
                            window.location = '#' + grupo;
							//alert('Você precisa preencher as apostas do Grupo para avançar');
                            f = 0;
                            return false;
					    }
                    
					});

					
					
                    if (f) {
                        $(this).fadeOut('slow');
                        $('.btn-apostar').fadeIn('slow');
                    }
					
                    return false;
                });

                $('input[type=radio]').click(function() {
                   atualizaGrid($(this).parent().parent().parent().parent().parent().parent().attr('id'));
                });

                $('.classificadoA').change(function() {
                    var fotoGrid = $(this).find(':selected').attr('foto');
                    var nameGrid = $(this).attr('name').match(/\[([a-zA-Z]*)\]/)[1].toLowerCase();
                    var htmlGrid = '<img src="<?php echo base_url('imagens/times'); ?>/' + fotoGrid + '" />';
                    $('#' + nameGrid + '1').html(htmlGrid);
                });
                
                $('.classificadoB').change(function() {
                    var fotoGrid = $(this).find(':selected').attr('foto');
                    var nameGrid = $(this).attr('name').match(/\[([a-zA-Z]*)\]/)[1].toLowerCase();
                    var htmlGrid = '<img src="<?php echo base_url('imagens/times'); ?>/' + fotoGrid + '" />';
                    $('#' + nameGrid + '2').html(htmlGrid);
                });

            });
        </script>

    </head>

    <body class="primeira-fase">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('faca_sua_aposta')); ?></h1>
                <h2><?php echo $this->lang->line('Primeira_Fase'); ?></h2>

                <div class="content">

                    <?php echo form_open('primeira_fase/salvar/' . $this->uri->segment("3"), 'id="form-1-fase" class="valida"'); ?>
                    <h3 class="form_resposta"></h3>

                    <div id="tab-container" class='tab-container'>
                    
                        <ul class='etabs'>
                            <li class='tab'><a href="#grupo-a" class="vtip" title="Escolher Resultados do Grupo A"><?php echo strtoupper($this->lang->line('Grupo')); ?> A</a></li>
                            <li class='tab'><a href="#grupo-b" class="vtip" title="Escolher Resultados do Grupo B"><?php echo strtoupper($this->lang->line('Grupo')); ?> B</a></li>
                            <li class='tab'><a href="#grupo-c" class="vtip" title="Escolher Resultados do Grupo C"><?php echo strtoupper($this->lang->line('Grupo')); ?> C</a></li>
                            <li class='tab'><a href="#grupo-d" class="vtip" title="Escolher Resultados do Grupo D"><?php echo strtoupper($this->lang->line('Grupo')); ?> D</a></li>
                            <li class='tab'><a href="#grupo-e" class="vtip" title="Escolher Resultados do Grupo E"><?php echo strtoupper($this->lang->line('Grupo')); ?> E</a></li>
                            <li class='tab'><a href="#grupo-f" class="vtip" title="Escolher Resultados do Grupo F"><?php echo strtoupper($this->lang->line('Grupo')); ?> F</a></li>
                            <li class='tab'><a href="#grupo-g" class="vtip" title="Escolher Resultados do Grupo G"><?php echo strtoupper($this->lang->line('Grupo')); ?> G</a></li>
                            <li class='tab'><a href="#grupo-h" class="vtip" title="Escolher Resultados do Grupo H"><?php echo strtoupper($this->lang->line('Grupo')); ?> H</a></li>
                        </ul>
						
                        <a href="#" id="mostrar-todas-dicas" class="botao-verde" title="Sugestão de resultado para todos os jogos" style="float:right; margin-top: -30px;"><?php echo $this->lang->line('Mostrar_todas_as_dicas'); ?></a>

                        <div class="panel-container">
                            <div id="grupo-a">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['a'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>

                                                    <label class="TimeA vtip" title="Ganhador!">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE vtip" title="Empate!">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB vtip" title="Ganhador!">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde vtip" title="Exibir Sugestão de Jogo"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('A');
                                        ?>
                                        <tr>
                                        <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[A]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[A]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-b">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['b'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('B');
                                        ?>
                                         <tr>
                                         <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[B]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[B]"  class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-c">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['c'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('C');
                                        ?>
                                         <tr>
                                        <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[C]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[C]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-d">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['d'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('D');
                                        ?>
                                         <tr>
                                         <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[D]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[D]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-e">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['e'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('E');
                                        ?>
                                         <tr>
                                         <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[E]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[E]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-f">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['f'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('F');
                                        ?>
                                         <tr>
                                         <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[F]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[F]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-g">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['g'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('G');
                                        ?>
                                         <tr>
                                        <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[G]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[G]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>

                            <div id="grupo-h">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <td width="15%"><?php echo $this->lang->line('Cidade'); ?></td>
                                            <td width="55%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['h'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($premio->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($premio->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($premio->campeonato, $j->timeb));
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <td><?php echo $j->local; ?></td>
                                                <!-- <td>
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    X
                                                    <label>
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                    </label>
                                                </td> -->
                                                <td>
                                                    <label class="TimeA">                                                        
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="a">
                                                    </label>
                                                    <label class="TimeE">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="e">
                                                    </label>
                                                    <label class="TimeB">
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" value="b">
                                                        <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /> <?php echo $timeb->time; ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="dica">
                                                        <a href="#<?php echo $melhor; ?>" class="botao-verde"><?php echo $this->lang->line('Mostrar'); ?></a>
                                                        <div class="dica-time" style="display: none;">
                                                            <?php if ($melhor == 1) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                                            <?php } elseif ($melhor == 3) { ?>
                                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                                            <?php } else { ?>
                                                                <?php echo $this->lang->line('Empate'); ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <thead>
                                        <?php
                                        $time = $this->copa->getChavesGrupo('H');
                                        ?>
                                         <tr>
                                        <td colspan="4">
                                       <?php echo $this->lang->line('Aviso_Jogo');?>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><?php echo $this->lang->line('1Classificado');?></td>
                                            <td width="10%">
                                                <select name="classificadoA[H]" class="classificadoA">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                            <td width="10%"><?php echo $this->lang->line('2Classificado');?></td>
                                            <td width="15%">
                                                <select name="classificadoB[H]" class="classificadoB">
                                                    <option value="<?php echo $time[0]->chave; ?>" foto="<?php echo $time[0]->foto; ?>"><?php echo $time[0]->time; ?></option>
                                                    <option value="<?php echo $time[1]->chave; ?>" foto="<?php echo $time[1]->foto; ?>"><?php echo $time[1]->time; ?></option>
                                                    <option value="<?php echo $time[2]->chave; ?>" foto="<?php echo $time[2]->foto; ?>"><?php echo $time[2]->time; ?></option>
                                                    <option value="<?php echo $time[3]->chave; ?>" foto="<?php echo $time[3]->foto; ?>"><?php echo $time[3]->time; ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                            </div>
                            <p class="txt_r"><input type="image" src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-proxima-fase.png'); ?>" class="btn-proxima-fase"></p>
                        </div>
                    </div>
                    <p class="txt_c">
                    <table id="t3" style="border:none; margin-left: 350px;">
                        <tbody>
                            <tr>
                                <td style="display: table-cell;" id="a1" class="rtxt">1A</td>
                                <td rowspan="8" style="width:150px; background: url('http://esportes.terra.com.br/infograficos/simulador-copa-do-mundo-2014/simulador/wc2010-00.png') no-repeat scroll 50% center / 140px 168px rgba(0, 0, 0, 0);">                <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>                        
                                </td>
                                <td style="display: table-cell;" id="b1" class="ltxt">1B</td></tr>
                            <tr>
                                <td style="display: table-cell;" id="b2" class="rtxt">2B</td>
                                <td style="display: table-cell;" id="a2" class="ltxt">2A</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="c1" class="rtxt">1C</td>
                                <td style="display: table-cell;" id="d1" class="ltxt">1D</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="d2" class="rtxt">2D</td>
                                <td style="display: table-cell;" id="c2" class="ltxt">2C</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="e1" class="rtxt">1E</td>
                                <td style="display: table-cell;" id="f1" class="ltxt">1F</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="f2" class="rtxt">2F</td>
                                <td style="display: table-cell;" id="e2" class="ltxt">2E</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="g1" class="rtxt">1G</td>
                                <td style="display: table-cell;" id="h1" class="ltxt">1H</td>
                            </tr>
                            <tr>
                                <td style="display: table-cell;" id="h2" class="rtxt">2H</td>
                                <td style="display: table-cell;" id="g2" class="ltxt">2G</td>
                            </tr>
                        </tbody>
                    </table>
                    </p>

                    <p class="txt_r"><input type="image" src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-salvar.png'); ?>" class="btn-apostar" style="display: none;"></p>
                </div>

                </form>
            </article>

            <div class="ajustaRodape"></div>
        </section>

        <!-- end CONTEUDO -->

        <?php include("site_include_rodape.php"); ?>

    </body>
</html>