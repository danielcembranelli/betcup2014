<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Campeonatos - BetCup2014</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/font-awesome/css/font-awesome.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty-responsive.css'); ?>">

        <link rel="shortcut icon" href="<?php echo base_url('flaty/img/favicon.png'); ?>">
    </head>
    <body>

        <?php require_once("admin_include_menu_top.php"); ?>

        <div class="container" id="main-container">

            <?php require_once("admin_include_menu_left.php"); ?>

            <div id="main-content">
                <div class="page-title">
                    <div>
                        <h1><i class="icon-sitemap"></i> Campeonatos</h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Campeonatos</li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i></h3>
                            </div>
                            <div class="box-content">
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Campeonato</th>
                                            <th>Fase</th>
                                            <th>Campeão</th>
                                            <th style="width: 350px">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($query->result() as $row) { ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->campeonato; ?></td>
                                                <td>
                                                    <?php
                                                    $fases = Array("primeirafase" => "Primeira Fase", "oitavas" => "Oitavas de Final", "quartas" => "Quartas de Final", "semifinal" => "Semi Final", "terceirolugar" => "Disputa 3&#186; lugar", "final" => "Final", "empates" => "Empates da Primeira Fase");
                                                    echo $fases[$row->fase];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row->fase == "final") {
                                                        $j = $this->db->query("SELECT * FROM jogos WHERE campeonato = ? AND fase = ? AND jogo = '64'", array($row->id, $row->fase))->row(0);
                                                        if ($j->defesa == "a") {
                                                            $t = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", array($row->id, $j->timea))->row(0);
                                                            echo "<img src='" . base_url('imagens/times/' . $t->foto . '') . "' title='" . $t->time . "' alt='" . $t->time . "' />";
                                                        } else if ($j->defesa == "b") {
                                                            $t = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", array($row->id, $j->timeb))->row(0);
                                                            echo "<img src='" . base_url('imagens/times/' . $t->foto . '') . "' title='" . $t->time . "' alt='" . $t->time . "' />";
                                                        }
                                                        else
                                                            echo "-";
                                                    }
                                                    else
                                                        echo "-";
                                                    ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/times_campeonato/' . $row->id); ?>"><i class="icon-group"></i> Times</a>
                                                    <a class="btn btn-yellow btn-sm" href="<?php echo base_url('admin/chaves_campeonato/' . $row->id); ?>"><i class="icon-key"></i> Chaves</a>
                                                    <a class="btn btn-inverse btn-sm" href="<?php echo base_url('admin/jogos_campeonato/' . $row->id); ?>"><i class="icon-gamepad"></i> Jogos</a>
                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/editar_campeonato/' . $row->id); ?>"><i class="icon-edit"></i> Editar</a>
                                                    <a class="btn btn-danger btn-sm excluir" href="#" data-url="<?php echo base_url('admin/excluir_campeonato/' . $row->id); ?>" data-aviso="Tem certeza que deseja excluir esse Campeonato?"><i class="icon-trash"></i> Excluir</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php require_once("admin_include_footer.php"); ?>

                <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
            </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('flaty/assets/jquery/jquery-2.0.3.min.js'); ?>"><\/script>')</script>
        <script src="<?php echo base_url('flaty/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/nicescroll/jquery.nicescroll.min.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/jquery-cookie/jquery.cookie.js'); ?>"></script>

        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.resize.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.pie.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.stack.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.crosshair.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/flot/jquery.flot.tooltip.min.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/sparkline/jquery.sparkline.min.js'); ?>"></script>

        <script src="<?php echo base_url('flaty/js/flaty.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/js/excluir.js'); ?>"></script>

    </body>
</html>
