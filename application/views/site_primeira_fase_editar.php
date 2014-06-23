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
        $(document).ready(function() {
            
              $('#tab-container').easytabs();
                
              $('#mostrar-todas-dicas').click(function() {
                  
                    var url = window.location.hash;
                    var grupo = url.substr(1);
                    if (grupo === '')
                        grupo = "grupo-a";
                    
                    $('#' + grupo + ' table tbody tr').each(function() {
                        $('td:nth-child(4) .dica a', this).fadeOut('slow', function() {
                            $(this).parent().find('div').fadeIn('slow');
                            $(this).parent().parent().parent().find('td:nth-child(3)').find('label:nth-child(' + $(this).attr('href').substring(1) + ')').find('input').prop('checked', true);
                        });
                    });
                    
                    return false;
                });
                
                $('.dica a').click(function() {
                
                    $(this).fadeOut('slow', function() {
                        $(this).parent().find('div').fadeIn('slow');
                        $(this).parent().parent().parent().find('td:nth-child(3)').find('label:nth-child(' + $(this).attr('href').substring(1) + ')').find('input').prop('checked', true);
                    });
                    
                    return false;
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

                    <?php echo form_open('editar/primeirafase_edita/' . $this->uri->segment("3"), 'id="form-1-fase" class="valida"'); ?>
                    <h3 class="form_resposta"></h3>

                    <div id="tab-container" class='tab-container'>
                        <ul class='etabs'>
                            <li class='tab'><a href="#grupo-a"><?php echo strtoupper($this->lang->line('Grupo')); ?> A</a></li>
                            <li class='tab'><a href="#grupo-b"><?php echo strtoupper($this->lang->line('Grupo')); ?> B</a></li>
                            <li class='tab'><a href="#grupo-c"><?php echo strtoupper($this->lang->line('Grupo')); ?> C</a></li>
                            <li class='tab'><a href="#grupo-d"><?php echo strtoupper($this->lang->line('Grupo')); ?> D</a></li>
                            <li class='tab'><a href="#grupo-e"><?php echo strtoupper($this->lang->line('Grupo')); ?> E</a></li>
                            <li class='tab'><a href="#grupo-f"><?php echo strtoupper($this->lang->line('Grupo')); ?> F</a></li>
                            <li class='tab'><a href="#grupo-g"><?php echo strtoupper($this->lang->line('Grupo')); ?> G</a></li>
                            <li class='tab'><a href="#grupo-h"><?php echo strtoupper($this->lang->line('Grupo')); ?> H</a></li>
                        </ul>

                        <a href="#" id="mostrar-todas-dicas" class="botao-verde" style="float:right; margin-top: -30px;"><?php echo $this->lang->line('Mostrar_todas_as_dicas'); ?></a>
                        
                        <div class="panel-container">

                            <div id="grupo-a">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['a'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-b">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['b'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-c">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['c'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-d">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['d'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-e">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['e'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-f">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['f'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-g">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['g'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                            <div id="grupo-h">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td width="12%"><?php echo $this->lang->line('Data'); ?></td>
                                            <td width="12%"><?php echo $this->lang->line('Hora'); ?></td>
                                            <!-- <td width="20%"><?php echo $this->lang->line('Jogos'); ?></td> -->
                                            <td width="25%"><?php echo $this->lang->line('Jogos_Resultado'); ?></td>
                                            <td width="10%"><?php echo $this->lang->line('Dica'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jogos['h'] as $jogo) {
                                            $j = $this->copa->getInfoJogo(array($aposta->campeonato, $jogo));
                                            $timea = $this->copa->getInfoTime(array($aposta->campeonato, $j->timea));
                                            $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $j->timeb));
                                            $resultado = $apostas_jogos->row($jogo - 1);
                                            $melhor = $this->copa->getMelhorRanking(array($timea->id, $timeb->id));
                                            ?>
                                            <tr>
                                                <td><?php echo $j->data; ?></td>
                                                <td><?php echo $j->hora; ?></td>
                                                <!-- <td><label><img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /></label> X <label><img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" /></label></td> -->
                                                <td>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "a") echo "checked=\"checked\""; ?> value="a">
                                                        <?php echo $timea->time; ?> <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" /> 
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "e") echo "checked=\"checked\""; ?> value="e"> 
                                                        Empate
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="defesa[<?php echo $jogo; ?>]" <?php if ($resultado->defesa == "b") echo "checked=\"checked\""; ?> value="b">
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
                                                                -
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
                            </div>

                        </div>
                    </div>

                    <p class="txt_r"><input type="image" src="<?php echo base_url('assets/pt/images/buttons/btn-salvar.png'); ?>" class="btn-apostar"></p>
                    </form>
                </div>

            </article>

            <div class="ajustaRodape"></div>
        </section>

        <!-- end CONTEUDO -->

        <?php include("site_include_rodape.php"); ?>

    </body>
</html>