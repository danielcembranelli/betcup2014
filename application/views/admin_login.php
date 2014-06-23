<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>BetCup2014 - Admin</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/font-awesome/css/font-awesome.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty-responsive.css'); ?>">

        <link rel="shortcut icon" href="<?php echo base_url('flaty/img/favicon.png'); ?>">
    </head>
    <body class="login-page">

        <div class="login-wrapper">
            <?php echo form_open('admin/autenticacao'); ?>
            <h3>Entre na sua conta</h3>
            <hr/>
            <div id="alert"></div>
            <div class="form-group">
                <div class="controls">
                    <input type="text" name="usuario" placeholder="Nome de Usu&aacute;rio" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <input type="password" name="senha" placeholder="Senha" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary form-control">Entrar</button>
                </div>
            </div>
            <hr/>
        </form>

    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url('flaty/assets/jquery/jquery-2.0.3.min.js'); ?>"><\/script>')</script>
    <script src="<?php echo base_url('flaty/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('flaty/js/login.js'); ?>"></script>

</body>
</html>