<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $("li.suas-apostas a").addClass("ativo");
            });
        </script>

    </head>

    <body class="suas-apostas">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('acompanhamento_apostas')); ?></h1>
                <h2><?php echo $this->lang->line('selecione_aposta_ver_detalhes'); ?></h2>

                <div class="content">
                    <?php foreach($c_apostas->result() as $row) { ?>
				<?php $total = $row->total;?>
                <?php }?>
                <? if($total>0){?>
                    <?php foreach($apostas->result() as $row) { ?>
                        <div class="aposta">
                            <hgroup>
                                <h5 class="data"><?php echo $row->data; ?></h5>
                                <h3>
                                    <?php
                                    if ($row->fase == "finalizado" && ($row->status == 1 || $row->status == 2)) {
                                        $j = $this->db->query("SELECT timea, timeb, defesa FROM apostas_jogos WHERE aposta = ? AND jogo = 64", $row->id)->row(0);
                                        $t = $this->copa->getInfoTime(array($row->campeonato, ($j->defesa == "a") ? $j->timea : $j->timeb));
                                        echo sprintf($this->lang->line('TIME_CAMPEAO'), strtoupper($t->time));
                                    }
                                    else
                                        echo "-";
                                    ?>
                                </h3>
                            </hgroup>
                            <?php if ($row->fase == "finalizado" && ($row->status == 1 || $row->status == 2)) { ?>
                                <p class="pontos"><?php echo $row->pontos; ?> <?php echo $this->lang->line('pontos'); ?></p>
                                <p class="posicao"><?php echo $row->posicao; ?>º LUGAR</p>
                            <?php } else { ?>
                                <p class="status">
                                    <?php
                                    if ($row->fase != "finalizado")
                                        echo $this->lang->line('Aguardando_finalizar_aposta');
                                    else
                                        echo $this->lang->line('Aguardando_efetuar_pagamento');
                                    ?>
                                </p>
                            <?php } ?>
                            <p class="txt_c">
                                <a href="<?php echo base_url('suas_apostas/ver/' . $row->id); ?>"><?php echo $this->lang->line('Ver'); ?></a>
                                <?php
                                if ($row->fase == "finalizado" && $row->status == 0) {
                                    ?>
                                    <a href="<?php echo base_url('efetuar_pagamento/aposta/' . $row->id); ?>"><?php echo $this->lang->line('Pagar'); ?></a>
                                    <a href="<?php echo base_url('suas_apostas/tornar_gratuita/' . $row->id); ?>" onclick="if(!confirm('<?php echo $this->lang->line('Aviso_tornar_aposta_gratuita'); ?>')) return false;"><?php echo $this->lang->line('Aposta_gratuita'); ?></a>
                                </p><?php } ?>
                        </div>
                    <?php } ?>
                    
                    <?php } else {?>
                    	<br><br><h3><?php echo $this->lang->line('Sem_Aposta'); ?></h3><br><br>
                    <?php } ?>

                </div>

            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>