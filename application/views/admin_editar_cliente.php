<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Editar - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?> - BetCup2014</title>
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
                        <h1><i class="icon-edit"></i> Editar - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?></h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Editar - <?php echo $cliente->nome; ?> <?php echo $cliente->sobrenome; ?></li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-reorder"></i></h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_cliente/' . $cliente->id, 'class="form-horizontal valida"'); ?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Nome</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="nome" placeholder="Nome" value="<?php echo $cliente->nome; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Sobrenome</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="sobrenome" placeholder="Sobrenome" value="<?php echo $cliente->sobrenome; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Data de Nascimento</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="datanascimento" placeholder="Data de Nascimento" value="<?php echo $cliente->datanascimento; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Endereço</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="endereco" placeholder="Endereço" value="<?php echo $cliente->endereco; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Número</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="numero" placeholder="Número" value="<?php echo $cliente->numero; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Complemento</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="complemento" placeholder="Complemento" value="<?php echo $cliente->complemento; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Bairro</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="bairro" placeholder="Bairro" value="<?php echo $cliente->bairro; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Código Postal</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="codigopostal" placeholder="Código Postal" value="<?php echo $cliente->codigopostal; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Cidade</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="cidade" placeholder="Cidade" value="<?php echo $cliente->cidade; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Estado</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="estado" placeholder="Estado" value="<?php echo $cliente->estado; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Pais</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="pais" placeholder="Pais" value="<?php echo $cliente->pais; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Telefone</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="telefone" placeholder="Telefone" value="<?php echo $cliente->telefone; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Email</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="text" name="email" placeholder="Email" value="<?php echo $cliente->email; ?>" class="form-control valida" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Senha</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <input type="password" name="senha" placeholder="Senha" class="form-control" />
                                        <span class="help-inline">Deixe o campo em branco para manter a mesma senha.</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                        <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Editar</button>
                                    </div>
                                </div>
                                </form>
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
        <script src="<?php echo base_url('flaty/js/validaform.js'); ?>"></script>

    </body>
</html>
