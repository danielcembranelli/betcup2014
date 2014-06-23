<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Cliente - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?> - BetCup2014</title>
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
                        <h1><i class="icon-user"></i> Cliente - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?></h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Cliente - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?></li>
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
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px">Nome</th>
                                            <td><?php echo $cliente->nome; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Sobrenome</th>
                                            <td><?php echo $cliente->sobrenome; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Data de Nascimento</th>
                                            <td><?php echo $cliente->datanascimento; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Endereço</th>
                                            <td><?php echo $cliente->endereco; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Número</th>
                                            <td><?php echo $cliente->numero; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Complemento</th>
                                            <td><?php echo $cliente->complemento; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Bairro</th>
                                            <td><?php echo $cliente->bairro; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Código Postal</th>
                                            <td><?php echo $cliente->codigopostal; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Cidade</th>
                                            <td><?php echo $cliente->cidade; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Estado</th>
                                            <td><?php echo $cliente->estado; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Pais</th>
                                            <td><?php echo $cliente->pais; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Telefone</th>
                                            <td><?php echo $cliente->telefone; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?php echo $cliente->email; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
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
