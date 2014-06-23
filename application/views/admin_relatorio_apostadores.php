<!DOCTYPE html>
<html>
    <head>
        <meta charset="iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Relat&oacute;rio de Apostadores - BetCup2014</title>
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
                        <h1><i class="icon-dollar"></i> Relat&oacute;rio de Apostadores</h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="icon-home"></i> Relat&oacute;rio de Apostadores</li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-bar-chart"></i> Relat&oacute;rio Mensal</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/busca_relatorio_apostas', 'id="form-relatorio-apostas" class="form-horizontal"'); ?>
                                <div class="form-group">
                                    <label class="col-sm-2 col-lg-1 control-label">M&ecirc;s/Ano</label>
                                    <div class="col-sm-10 col-lg-11 controls">
                                        <select name="mesano" class="form-control" tabindex="1">
                                            <?php foreach ($mesano->result() as $row) { ?>
                                                <option value="<?php echo $row->data; ?>"><?php echo $row->data; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2 col-lg-11 col-lg-offset-1">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Atualizar</button>
                                    </div>
                                </div>
                                </form>
                                <div id="relatorio-mensal" style="margin-top:20px; position:relative; height: 290px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-bar-chart"></i> Total de Apostas (<?php echo ($apostas['pendentes'] + $apostas['pagas'] + $apostas['canceladas']); ?>)</h3>
                            </div>
                            <div class="box-content">
                                <div id="grafico_apostadores" class="chart"></div>
                                <div id="total-pendentes" style="display: none"><?php echo $apostas['pendentes']; ?></div>
                                <div id="total-pagas" style="display: none"><?php echo $apostas['pagas']; ?></div>
                                <div id="total-canceladas" style="display: none"><?php echo $apostas['canceladas']; ?></div>
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

        <script type="text/javascript">
            $(function() {

                $('#form-relatorio-apostas').submit(function() {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(data) {
                            
                            var placeholder = $("#relatorio-mensal");

                            if ($(placeholder).size() == 0)
                                return;


                            var chartColours = ['#edc240', '#88bbc8', '#ed7a53'];
                            //graph options
                            var options = {
                                grid: {
                                    show: true,
                                    aboveData: true,
                                    color: "#3f3f3f",
                                    labelMargin: 5,
                                    axisMargin: 0,
                                    borderWidth: 0,
                                    borderColor: null,
                                    minBorderMargin: 5,
                                    clickable: true,
                                    hoverable: true,
                                    autoHighlight: true,
                                    mouseActiveRadius: 20
                                },
                                series: {
                                    grow: {active: true, stepMode: "linear", steps: 50, stepDelay: true},
                                    lines: {show: true, fill: false, lineWidth: 3, steps: false},
                                    points: {show: true, radius: 4, symbol: "circle", fill: true, borderColor: "#fff"}
                                },
                                legend: {
                                    position: "ne",
                                    margin: [0, -25],
                                    noColumns: 0,
                                    labelBoxBorderColor: null,
                                    labelFormatter: function(label, series) {
                                        return label + '&nbsp;&nbsp;';
                                    }
                                },
                                yaxis: {min: 0},
                                xaxis: {ticks: 11, tickDecimals: 0},
                                colors: chartColours,
                                shadowSize: 1,
                                tooltip: true, //activate tooltip
                                tooltipOpts: {
                                    content: "%s : %y.0",
                                    defaultTheme: false,
                                    shifts: {
                                        x: -30,
                                        y: -50
                                    }
                                }
                            };
                            $.plot(placeholder, [
                                {
                                    label: "Pendentes",
                                    data: pendentes,
                                    lines: {fillColor: "#fff8f2"},
                                    points: {fillColor: "#fff"}
                                },
                                {
                                    label: "Pagas",
                                    data: pagas,
                                    lines: {fillColor: "#f2f7f9"},
                                    points: {fillColor: "#fff"}
                                },
                                {
                                    label: "Canceladas",
                                    data: canceladas,
                                    lines: {fillColor: "#fff8f2"},
                                    points: {fillColor: "#fff"}
                                }

                            ], options);

                        }
                    });
                    return false;
                }).submit();
                
                var graphData = [];
                graphData[0] = {label: "Pendentes (" + $('#total-pendentes').html() + ")", data: $('#total-pendentes').html()}
                graphData[1] = {label: "Pagas (" + $('#total-pagas').html() + ")", data: $('#total-pagas').html()}
                graphData[2] = {label: "Canceladas (" + $('#total-canceladas').html() + ")", data: $('#total-canceladas').html()}
                var series = graphData.length;
                $.plot($("#grafico_apostadores"), graphData, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 1,
                                formatter: function(label, series) {
                                    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                                },
                                background: {
                                    opacity: 0.8
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });

            });
        </script>

    </body>
</html>