<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

        <script type="text/javascript" src="<?php echo base_url('assets/todos/js/tabela.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/todos/js/form.js'); ?>"></script>

        <!--[if lt IE 8]>
        <script src="<?php echo base_url('assets/pt/js/aviso_ie7.js'); ?>" type="text/javascript"></script>
        <![endif]-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#tab-container').easytabs();
            });
        </script>

    </head>

    <body class="oitavas">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo "Davis Cup 2014";//strtoupper($this->lang->line('faca_sua_aposta')); ?></h1>
                <h2><?php echo "Grupo Mundial 2014";//strtoupper($this->lang->line('oitavas_final')); ?></h2>

                <div class="content-davis">

                    <?php echo form_open('tabela/salvar/' . $this->uri->segment("3"), 'id="form-oitavas" class="valida"'); ?>
                    <h3 class="form_resposta"></h3>

                    <table id="tb-oitavas">
                        <thead>
                            <tr>
                                <td>
    First Round<?php //echo $this->lang->line('Oitavas'); ?></td>
                                <td><?php echo $this->lang->line('Quartas'); ?></td>
                                <td><?php echo $this->lang->line('Semifinais'); ?></td>
                                <td><?php echo $this->lang->line('Finais'); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div id="jogo-49" class="oitavas-01">
                                        <?php
										
										//print_r($jogo[49]);
										$aposta->campeonato = '2';
                                        $j = $this->copa->getInfoJogo(array(2, 49));
                                        $timea = $this->copa->getInfoTime(array(2, $jogo[49]->timea));
                                        $timeb = $this->copa->getInfoTime(array(2, $jogo[49]->timeb));
                                        ?>
                                        <label class="txt_r">
                                            <?php echo $timea->time; ?> 
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[49]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <?php echo $timeb->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[49]" id="radio2" value="b">
                                        </label>
                                        
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                        
                                    </div>
                                    <div id="jogo-50" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 50));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[50]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[50]->timeb));
                                        ?>
                                        <label class="txt_r">
                                            <?php echo $timea->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[50]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <?php echo $timeb->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[50]" id="radio" value="b">
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    <div id="jogo-51" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 51));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[51]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[51]->timeb));
                                        ?>
                                        <label class="txt_r">
                                                <input type="radio" name="defesa[51]" id="radio" value="a">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <?php echo $timea->time; ?>
                                        </label>
                                        <label class="txt_r">
                                                <input type="radio" name="defesa[51]" id="radio" value="b">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <?php echo $timeb->time; ?>
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    <div id="jogo-52" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 52));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[52]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[52]->timeb));
                                        ?>
                                        <label class="txt_r">
                                                <input type="radio" name="defesa[52]" id="radio" value="a">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <?php echo $timea->time; ?>
                                        </label>
                                        <label class="txt_r">
                                                <input type="radio" name="defesa[52]" id="radio" value="b">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <?php echo $timeb->time; ?>
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <br>
                                    
                                    <div id="jogo-53" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 53));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[53]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[53]->timeb));
                                        ?>
                                        <label class="txt_r">
                                            <?php echo $timea->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[53]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <?php echo $timeb->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[53]" id="radio" value="b">
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    <div id="jogo-54" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 54));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[54]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[54]->timeb));
                                        ?>
                                        <label class="txt_r">
                                            <?php echo $timea->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[54]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <?php echo $timeb->time; ?>
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <input type="radio" name="defesa[54]" id="radio" value="b">
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                     <div id="jogo-55" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 55));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[55]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[55]->timeb));
                                        ?>
                                        <label class="txt_r">
                                                <input type="radio" name="defesa[55]" id="radio" value="a">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <?php echo $timea->time; ?>
                                        </label>
                                        <label class="txt_r">
                                            
                                                <input type="radio" name="defesa[55]" id="radio" value="b">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <?php echo $timeb->time; ?>
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    <div id="jogo-56" class="oitavas-01">
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 56));
                                        $timea = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[56]->timea));
                                        $timeb = $this->copa->getInfoTime(array($aposta->campeonato, $jogo[56]->timeb));
                                        ?>
                                        <label class="txt_r">
                                            
                                                <input type="radio" name="defesa[56]" id="radio" value="a">
                                            <span>
                                            <img src="<?php echo base_url('imagens/times/' . $timea->foto); ?>" alt="<?php echo $timea->time; ?>" title="<?php echo $timea->time; ?>" />
                                            </span>
                                            <?php echo $timea->time; ?>
                                        </label>
                                        <label class="txt_r">
                                            <input type="radio" name="defesa[56]" id="radio" value="b">
                                            <span>
                                                <img src="<?php echo base_url('imagens/times/' . $timeb->foto); ?>" alt="<?php echo $timeb->time; ?>" title="<?php echo $timeb->time; ?>" />
                                            </span>
                                            <?php echo $timeb->time; ?>
                                        </label>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                </td>
                                <td>
                                    <div id="jogo-57" class="quartas">
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[57]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[57]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 57));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                   
                                    
                                    <div id="jogo-58" class="b70">
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[58]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[58]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 58));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                     <div id="jogo-59" class="quartas davis-quarta-3">
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[59]" id="radio" value="a">
                                        </label>
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[59]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 59));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                       <div id="jogo-60" class="b70">
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[60]" id="radio" value="a">
                                        </label>
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[60]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 60));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                </td>
                                <td>
                                    <div id="jogo-61" class="semifinais davis-semi-1">
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[61]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[61]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 61));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    
                                      <div id="jogo-62" class="semifinais davis-semi-2">
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[62]" id="radio" value="a">
                                        </label>
                                        <label class="txt_l">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[62]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 62));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                </td>
                                <td>
                                    <h4>1º e 2º</h4>
                                    <div id="jogo-64" class="finais davis-final-1">
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[64]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[64]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 64));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>

                                    
                                    <div id="jogo-63" class="terceiro b70 davis-final-2">
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[63]" id="radio" value="a">
                                        </label>
                                        <label class="txt_r">
                                            <span>
                                                -
                                            </span>
                                            <input type="radio" name="defesa[63]" id="radio" value="b">
                                        </label>
                                        <?php
                                        $j = $this->copa->getInfoJogo(array($aposta->campeonato, 63));
                                        ?>
                                        <p><a href="#"class="vtip" title="<?php echo $j->data . " - " . $j->hora; ?></br><?php echo $j->local; ?>">
                                        	 <img src="<?php echo base_url('imagens/campo.png'); ?>" />
                                             </a></p>
                                    </div>
                                    <h4>3º e 4º</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="txt_r">
                        <input type="image" src="<?php echo base_url('assets/pt/images/buttons/btn-salvar.png'); ?>" class="btn-apostar vtip" title="Registrar Aposta!">
                    </p>

                    </form>
                </div>

            </article>

            <div class="ajustaRodape"></div>
        </section>

        <!-- end CONTEUDO -->

        <?php include("site_include_rodape.php"); ?>

    </body>
</html>