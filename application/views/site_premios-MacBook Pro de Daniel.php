<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

    </head>

    <body class="premios">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('faca_sua_aposta')); ?></h1>
                <h2><?php echo $this->lang->line('Selecione_premio_desejado'); ?></h2>

                <div class="content">

                    <p>
                        <?php
                        foreach ($premios->result() as $row) {
                            if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", $row->campeonato)->num_rows == 0) {
                                ?>
                                <div class="premio_placar">
                                		<a href="<?php echo base_url($row->modulo.'/premio/' . $row->id); ?>">
                                			<img src="<?php echo base_url('imagens/premios/' . substr($row->foto, 0, -4).'_'.$this->session->userdata('idioma')); ?>.png" alt="<?php echo $row->premio; ?>"></a>
                                            <?php if($row->id==4 || $row->id==6){?>
                                            <p style="width:300px">Acumulado US$ 0,000</p>
                                         <?php } ?>
                               </div>
                                <?php
                            }
                        }
                        ?>
                    </p>

                </div>

            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>