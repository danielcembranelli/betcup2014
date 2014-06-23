<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Jogos - <?php echo $campeonato->campeonato; ?> - BetCup2014</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/font-awesome/css/font-awesome.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/css/flaty-responsive.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('flaty/css/screen.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('flaty/assets/bootstrap-datepicker/css/datepicker.css'); ?>">

        <link rel="shortcut icon" href="<?php echo base_url('flaty/img/favicon.png'); ?>">
    </head>
    <body>

        <?php require_once("admin_include_menu_top.php"); ?>

        <div class="container" id="main-container">

            <?php require_once("admin_include_menu_left.php"); ?>

            <div id="main-content">
                <div class="page-title">
                    <div>
                        <h1><i class="icon-sitemap"></i> Jogos - <?php echo $campeonato->campeonato; ?></h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="home.php">In&iacute;cio</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Jogos - <?php echo $campeonato->campeonato; ?></li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue active" data-box="fase-primeira-fase">
                            <p>Primeira Fase</p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue" data-box="fase-oitavas-final">
                            <p>Oitavas de Final</p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue" data-box="fase-quartas-final">
                            <p>Quartas de Final</p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue" data-box="fase-semi-final">
                            <p>Semifinal</p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue" data-box="fase-terceiro-lugar">
                            <p>Disputa 3&#186; lugar</p>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a class="box-menu tile tile-light-blue" data-box="fase-final">
                            <p>Final</p>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="alert"></div>

                        <div class="box" id="fase-primeira-fase">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Primeira Fase</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:80px">Jogo</th>
                                            <th style="width:80px">Grupo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Defesa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($fasePrimeira->result() as $row) {
                                            if ($filtro >= 1) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = $row->timea;
                                                $timeb = $row->timeb;
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <td><?php echo $row->titulo; ?></td>
                                                <?php if ($filtro >= 1) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 1) { ?>
                                                    <td>
                                                        <input type="radio" name="defesa[<?php echo $row->jogo; ?>]" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" name="defesa[<?php echo $row->jogo; ?>]" value="e" <?php if ($row->defesa == "e") echo "checked=\"checked\""; ?> /> Empate 
                                                        <input type="radio" name="defesa[<?php echo $row->jogo; ?>]" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="8" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="primeirafase" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="box" id="fase-oitavas-final">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Oitavas de Final</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:80px">Jogo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($faseOitavas->result() as $row) {
                                            if ($filtro >= 2) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = substr($row->timea, 0, -1) . " DO GRUPO " . substr($row->timea, -1);
                                                $timeb = substr($row->timeb, 0, -1) . " DO GRUPO " . substr($row->timeb, -1);
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <?php if ($filtro >= 2) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 2) { ?>
                                                    <td>
                                                        <input type="radio" name="defesa[<?php echo $row->jogo; ?>]" class="defesa" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" name="defesa[<?php echo $row->jogo; ?>]" class="defesa" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="oitavas" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="box" id="fase-quartas-final">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Quartas de Final</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:80px">Jogo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($faseQuartas->result() as $row) {
                                            if ($filtro >= 3) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = "VENCEDOR DO JOGO " . substr($row->timea, -2);
                                                $timeb = "VENCEDOR DO JOGO " . substr($row->timeb, -2);
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <?php if ($filtro >= 3) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 3) { ?>
                                                    <td>
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="quartas" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="box" id="fase-semi-final">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Semifinal</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:150px">Jogo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($faseSemiFinal->result() as $row) {
                                            if ($filtro >= 4) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = "VENCEDOR DO JOGO " . substr($row->timea, -2);
                                                $timeb = "VENCEDOR DO JOGO " . substr($row->timeb, -2);
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <?php if ($filtro >= 4) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 4) { ?>
                                                    <td>
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="semifinal" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="box" id="fase-terceiro-lugar">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Disputa 3&#186; lugar</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:80px">Jogo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($faseTerceiroLugar->result() as $row) {
                                            if ($filtro >= 5) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = "PERDEDOR DO JOGO " . substr($row->timea, -2);
                                                $timeb = "PERDEDOR DO JOGO " . substr($row->timeb, -2);
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <?php if ($filtro >= 5) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 5) { ?>
                                                    <td>
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="terceirolugar" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>

                        <div class="box" id="fase-final">
                            <div class="box-title">
                                <h3><i class="icon-table"></i> Final</h3>
                            </div>
                            <div class="box-content">
                                <?php echo form_open('admin/edita_jogos/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                                <table class="table table-striped table-hover fill-head">
                                    <thead>
                                        <tr>
                                            <th style="width:120px">Data</th>
                                            <th style="width:80px">Hora</th>
                                            <th style="width:80px">Jogo</th>
                                            <th style="width:150px">Jogos</th>
                                            <th>Pontos</th>
                                            <th>Local</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($faseFinal->result() as $row) {
                                            if ($filtro >= 5) {
                                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timea))->row(0);
                                                $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE chaves.campeonato = ? AND chave = ?", Array($this->uri->segment(3), $row->timeb))->row(0);
                                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' />";
                                                $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' />";
                                            } else {
                                                $timea = "VENCEDOR DO JOGO " . substr($row->timea, -2);
                                                $timeb = "VENCEDOR DO JOGO " . substr($row->timeb, -2);
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Data" name="data[<?php echo $row->jogo; ?>]" value="<?php if ($row->data != "00/00/0000") echo $row->data; ?>" class="form-control input-sm data" />
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Hora" name="hora[<?php echo $row->jogo; ?>]" value="<?php echo $row->hora; ?>" class="form-control input-sm hora" size="3" />
                                                </td>
                                                <td>Jogo <?php echo $row->jogo; ?></td>
                                                <?php if ($filtro >= 5) { ?>
                                                    <td>
                                                        <?php echo $timea; ?> x <?php echo $timeb; ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Pontos" name="pontos[<?php echo $row->jogo; ?>]" value="<?php echo $row->pontos; ?>" class="form-control input-sm" size="2" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td><?php echo $timea; ?> x <?php echo $timeb; ?></td>
                                                    <td>-</td>
                                                <?php } ?>
                                                <td>
                                                    <input type="text" placeholder="Local" name="local[<?php echo $row->jogo; ?>]" value="<?php echo $row->local; ?>" class="form-control input-sm" size="10" />
                                                </td>
                                                <?php if ($filtro >= 5) { ?>
                                                    <td>
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="a" <?php if ($row->defesa == "a") echo "checked=\"checked\""; ?> /> <?php echo $timea; ?> 
                                                        <input type="radio" class="defesa" name="defesa[<?php echo $row->jogo; ?>]" value="b" <?php if ($row->defesa == "b") echo "checked=\"checked\""; ?> /> <?php echo $timeb; ?> 
                                                    </td>
                                                <?php } else { ?>
                                                    <td>-</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7" class="left">
                                                <div class="col-sm-9 col-lg-10 controls">
                                                    <input type="hidden" name="fase" value="final" >
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icon-ok"></i> Salvar</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        <script src="<?php echo base_url('flaty/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/assets/maskedinput/js/maskedinput.js'); ?>"></script>

        <script src="<?php echo base_url('flaty/js/flaty.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/js/validaform.js'); ?>"></script>
        <script src="<?php echo base_url('flaty/js/jogoscampeonatos.js'); ?>" type="text/javascript"></script>

        <script type="text/javascript">
            $(function() {
                var faseAtual = "<?php echo $campeonato->fase; ?>";
                if (faseAtual === "oitavas")
                    $('a[data-box=fase-oitavas-final]').click();
                else if (faseAtual === "quartas")
                    $('a[data-box=fase-quartas-final]').click();
                else if (faseAtual === "semifinal")
                    $('a[data-box=fase-semi-final]').click();
                else if (faseAtual === "terceirolugar")
                    $('a[data-box=fase-terceiro-lugar]').click();
                else if (faseAtual === "final")
                    $('a[data-box=fase-final]').click();
            });
        </script>

    </body>
</html>