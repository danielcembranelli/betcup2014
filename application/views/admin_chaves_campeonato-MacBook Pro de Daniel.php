<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Chaves - <?php echo $campeonato->campeonato; ?> - BetCup2014</title>
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
                        <h1><i class="icon-key"></i> Chaves - <?php echo $campeonato->campeonato; ?></h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Chaves - <?php echo $campeonato->campeonato; ?></li>
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
                                <?php echo form_open('admin/edita_chaves/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                    <table class="table table-striped table-hover fill-head">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center; width:100px">Chave</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($chaves->result() as $row) {
                                                $times = $this->db->query("SELECT * FROM times WHERE campeonato = ? ORDER BY time ASC", $this->uri->segment(3));
                                                ?>
                                                <tr>
                                                    <td align="center" class="chave"><?php echo $row->chave; ?></td>
                                                    <td>
                                                        <div class="col-sm-9 col-lg-10 controls">
                                                            <select name="times[<?php echo $row->chave; ?>]" class="form-control times" tabindex="1">
                                                                <option value="">Selecione</option>
                                                                <?php
                                                                foreach ($times->result() as $row_) {
                                                                    ?>
                                                                    <option value="<?php echo $row_->id; ?>" data-foto="<?php echo $row_->foto; ?>" <?php if ($row_->id == $row->time) echo "selected=\"selected\""; ?>><?php echo $row_->time; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="foto-<?php echo $row->chave; ?>"></div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="2" style="text-align:left">
                                                    <div class="col-sm-9 col-lg-10 controls">
                                                        <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-table"></i></h3>
                            </div>
                            <div class="box-content">
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; width:50px">Jogo</th>
                                            <th style="text-align:center;">Primeira Fase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($jogos->result() as $row) {
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="center">
                                                    <span class="<?php echo $row->timea; ?>"><?php echo $row->timea; ?></span> x <span class="<?php echo $row->timeb; ?>"><?php echo $row->timeb; ?></span>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
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
        <script src="<?php echo base_url('flaty/js/validaform.js'); ?>"></script>

        <script type="text/javascript">
            $(function() {
                $('.times').each(function() {

                    var time = $(this).find('option:selected').html();
                    var foto = $(this).find('option:selected').data('foto');
                    var chave = $(this).parent().parent().parent().find('td.chave').html();

                    if (time != 'Selecione')
                        $('#foto-' + chave).html('<img src="<?php echo base_url('imagens/times/'); ?>' + foto + '" alt="' + time + '">');
                    if (time != 'Selecione')
                        $('.' + chave).html('<img src="<?php echo base_url('imagens/times/'); ?>' + foto + '" alt="' + time + '">');

                });

                $('.times').change(function() {
                    var time = $(this).find('option:selected').html();
                    var foto = $(this).find('option:selected').data('foto');
                    var chave = $(this).parent().parent().parent().find('td.chave').html();

                    $('#foto-' + chave).html('<img src="<?php echo base_url('imagens/times/'); ?>' + foto + '" alt="' + time + '">');
                    $('.' + chave).html('<img src="<?php echo base_url('imagens/times/'); ?>' + foto + '" alt="' + time + '">');

                    return false;
                });

            });
        </script>
    </body>
</html>