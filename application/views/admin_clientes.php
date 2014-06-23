<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Clientes - BetCup2014</title>
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
                        <h1><i class="icon-user"></i> Clientes</h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Clientes</li>
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
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th style="width: 300px">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clientes->result() as $row) { ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->nome; ?> <?php echo $row->sobrenome; ?></td>
                                                <td><?php echo $row->email; ?></td>
                                                <td>
                                                    <a class="btn btn-magenta btn-sm" href="<?php echo base_url('admin/ver_cliente/' . $row->id); ?>"><i class="glyphicon glyphicon-eye-open"></i> Ver</a>
                                                    <a class="btn btn-lime btn-sm" href="<?php echo base_url('admin/apostas/' . $row->id); ?>"><i class="glyphicon glyphicon-check"></i> Apostas</a>
                                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/editar_cliente/' . $row->id); ?>"><i class="icon-edit"></i> Editar</a>
                                                    <a class="btn btn-danger btn-sm excluir" href="#" data-url="<?php echo base_url('admin/excluir_cliente/' . $row->id); ?>" data-aviso="Tem certeza que deseja excluir esse Cliente?"><i class="icon-trash"></i> Excluir</a>
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