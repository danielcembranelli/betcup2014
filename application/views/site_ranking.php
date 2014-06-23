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
                $("li.ranking a").addClass("ativo");
            });
        </script>

    </head>

    <body class="ranking">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('ranking')); ?></h1>
                <h2><?php echo $this->lang->line('Ranking_aposta'); ?></h2>

                <div class="content">
                    <table id="tb-ranking">
                        <thead>
                            <tr>
                                <td><?php echo strtoupper($this->lang->line('participantes')); ?></td>
                                <td><?php echo strtoupper($this->lang->line('times')); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($apostas->result() as $row) { ?>
                                <tr>
                                    <td><?php echo $row->nome . " " . $row->sobrenome; ?></td>
                                    <td>
                                        <?php
                                        $t = $this->copa->getInfoTime(array($row->campeonato, ($row->defesa == "a") ? $row->timea : $row->timeb));
                                        echo $t->time;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>