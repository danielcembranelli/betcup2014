<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $campeonato->campeonato; ?> - Times - BetCup2014</title>
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
                        <h1><i class="icon-group"></i> <?php echo $campeonato->campeonato; ?> - Times</h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="<?php echo base_url('admin'); ?>">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/campeonatos'); ?>"><?php echo $campeonato->campeonato; ?></a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Times</li>
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
                                <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/novo_time/' . $campeonato->id); ?>" style="margin-bottom: 10px;"><i class="icon-ok"></i> Adicionar</a>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th style="width: 100px">Ranking</th>
                                            <th style="width: 200px">Foto</th>
                                            <th>Time</th>
                                            <th style="width: 250px">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($query->result() as $row) { ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->ranking; ?></td>
                                                <td><img src="<?php echo base_url('imagens/times/' . $row->foto . ''); ?>" alt="<?php echo $row->time; ?>"></td>
                                                <td><?php echo $row->time; ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/editar_time/' . $row->id); ?>"><i class="icon-edit"></i> Editar</a>
                                                    <a class="btn btn-danger btn-sm excluir" href="#" data-url="<?php echo base_url('admin/excluir_time/' . $row->id . '/' . $campeonato->id); ?>" data-aviso="Tem certeza que deseja excluir esse Time?"><i class="icon-trash"></i> Excluir</a>
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