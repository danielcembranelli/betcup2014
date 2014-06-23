<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Empates - <?php echo $campeonato->campeonato; ?> - BetCup2014</title>
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
                        <h1><i class="glyphicon glyphicon-adjust"></i> Empates - <?php echo $campeonato->campeonato; ?></h1>
                    </div>
                </div>

                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="glyphicon glyphicon-adjust"></i> Empates - <?php echo $campeonato->campeonato; ?></li>
                    </ul>
                </div>

                <div id="alert"></div>
                
                <?php echo form_open('admin/edita_jogos_empates/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                <div class="row">

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo A</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($A['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $A['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $A['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($A['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $A['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($A['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                        <input type="hidden" name="grupoa[]" value="<?php echo $A['times'][0]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <?php if ($A['primeirolivre'] === 1) { ?>
                                                <?php echo $timea; ?>
                                                <input type="hidden" name="grupoa[]" value="<?php echo $A['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <select name="grupoa[]" class="valida" style="width: 150px;">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    for ($i = 0; $i < count($A['times']); $i++) {
                                                        $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $A['times'][$i]))->row(0);
                                                        ?>
                                                        <option value="<?php echo $A['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <?php if ($A['empate'] === 0) { ?>
                                            <td><?php echo $timeb; ?></td>
                                        <input type="hidden" name="grupoa[]" value="<?php echo $A['times'][1]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <select name="grupoa[]" class="valida" style="width: 150px;">
                                                <option value="">Selecione</option>
                                                <?php
                                                for ($i = ($A['primeirolivre'] === 1) ? 1 : 0; $i < count($A['times']); $i++) {
                                                    $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $A['times'][$i]))->row(0);
                                                    ?>
                                                    <option value="<?php echo $A['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo B</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($B['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $B['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $B['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($B['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $B['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($B['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                        <input type="hidden" name="grupob[]" value="<?php echo $B['times'][0]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <?php if ($B['primeirolivre'] === 1) { ?>
                                                <?php echo $timea; ?>
                                                <input type="hidden" name="grupob[]" value="<?php echo $B['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <select name="grupob[]" style="width: 150px;">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    for ($i = 0; $i < count($B['times']); $i++) {
                                                        $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $B['times'][$i]))->row(0);
                                                        ?>
                                                        <option value="<?php echo $B['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <?php if ($B['empate'] === 0) { ?>
                                            <td><?php echo $timeb; ?></td>
                                        <input type="hidden" name="grupob[]" value="<?php echo $A['times'][1]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <select name="grupob[]" style="width: 150px;">
                                                <option value="">Selecione</option>
                                                <?php
                                                for ($i = ($B['primeirolivre'] === 1) ? 1 : 0; $i < count($B['times']); $i++) {
                                                    $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $B['times'][$i]))->row(0);
                                                    ?>
                                                    <option value="<?php echo $B['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo C</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($C['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $C['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $C['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($C['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $C['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($C['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                        <input type="hidden" name="grupoc[]" value="<?php echo $C['times'][0]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <?php if ($C['primeirolivre'] === 1) { ?>
                                                <?php echo $timea; ?>
                                                <input type="hidden" name="grupoc[]" value="<?php echo $C['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <select name="grupoc[]" style="width: 150px;">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    for ($i = 0; $i < count($C['times']); $i++) {
                                                        $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $C['times'][$i]))->row(0);
                                                        ?>
                                                        <option value="<?php echo $C['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <?php if ($C['empate'] === 0) { ?>
                                            <td><?php echo $timeb; ?></td>
                                        <input type="hidden" name="grupoc[]" value="<?php echo $C['times'][1]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <select name="grupoc[]" style="width: 150px;">
                                                <option value="">Selecione</option>
                                                <?php
                                                for ($i = ($C['primeirolivre'] === 1) ? 1 : 0; $i < count($C['times']); $i++) {
                                                    $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $C['times'][$i]))->row(0);
                                                    ?>
                                                    <option value="<?php echo $C['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo D</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($D['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $D['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $D['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($D['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $D['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($D['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                        <input type="hidden" name="grupod[]" value="<?php echo $D['times'][0]; ?>" />
                                    <?php } else { ?>
                                        <td>
                                            <?php if ($D['primeirolivre'] === 1) { ?>
                                                <?php echo $timea; ?>
                                                <input type="hidden" name="grupod[]" value="<?php echo $D['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <select name="grupod[]" style="width: 150px;">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    for ($i = 0; $i < count($D['times']); $i++) {
                                                        $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $D['times'][$i]))->row(0);
                                                        ?>
                                                        <option value="<?php echo $D['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <?php if ($D['empate'] === 0) { ?>
                                            <td><?php echo $timeb; ?></td>
                                    <input type="hidden" name="grupod[]" value="<?php echo $D['times'][1]; ?>" />
                                        <?php } else { ?>
                                            <td>
                                                <select name="grupod[]" style="width: 150px;">
                                                    <option value="">Selecione</option>
                                                    <?php
                                                    for ($i = ($D['primeirolivre'] === 1) ? 1 : 0; $i < count($D['times']); $i++) {
                                                        $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $D['times'][$i]))->row(0);
                                                        ?>
                                                        <option value="<?php echo $D['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo E</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($E['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $E['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $E['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($E['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $E['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($E['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                                <input type="hidden" name="grupoe[]" value="<?php echo $E['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <?php if ($E['primeirolivre'] === 1) { ?>
                                                        <?php echo $timea; ?>
                                                        <input type="hidden" name="grupoe[]" value="<?php echo $E['times'][0]; ?>" />
                                                    <?php } else { ?>
                                                        <select name="grupoe[]" style="width: 150px;">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            for ($i = 0; $i < count($E['times']); $i++) {
                                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $E['times'][$i]))->row(0);
                                                                ?>
                                                                <option value="<?php echo $E['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <?php if ($E['empate'] === 0) { ?>
                                                <td><?php echo $timeb; ?></td>
                                                <input type="hidden" name="grupoe[]" value="<?php echo $E['times'][1]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <select name="grupoe[]" style="width: 150px;">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        for ($i = ($E['primeirolivre'] === 1) ? 1 : 0; $i < count($E['times']); $i++) {
                                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $E['times'][$i]))->row(0);
                                                            ?>
                                                            <option value="<?php echo $E['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo F</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($F['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $F['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $F['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($F['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $F['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($F['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                                <input type="hidden" name="grupof[]" value="<?php echo $F['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <?php if ($F['primeirolivre'] === 1) { ?>
                                                        <?php echo $timea; ?>
                                                        <input type="hidden" name="grupof[]" value="<?php echo $F['times'][0]; ?>" />
                                                    <?php } else { ?>
                                                        <select name="grupof[]" style="width: 150px;">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            for ($i = 0; $i < count($F['times']); $i++) {
                                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $F['times'][$i]))->row(0);
                                                                ?>
                                                                <option value="<?php echo $F['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <?php if ($F['empate'] === 0) { ?>
                                                <td><?php echo $timeb; ?></td>
                                                <input type="hidden" name="grupof[]" value="<?php echo $F['times'][1]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <select name="grupof[]" style="width: 150px;">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        for ($i = ($F['primeirolivre'] === 1) ? 1 : 0; $i < count($F['times']); $i++) {
                                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $F['times'][$i]))->row(0);
                                                            ?>
                                                            <option value="<?php echo $F['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo G</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($G['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $G['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $G['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($G['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $G['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($G['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                                <input type="hidden" name="grupog[]" value="<?php echo $G['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <?php if ($G['primeirolivre'] === 1) { ?>
                                                        <?php echo $timea; ?>
                                                        <input type="hidden" name="grupog[]" value="<?php echo $G['times'][0]; ?>" />
                                                    <?php } else { ?>
                                                        <select name="grupog[]" style="width: 150px;">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            for ($i = 0; $i < count($G['times']); $i++) {
                                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $G['times'][$i]))->row(0);
                                                                ?>
                                                                <option value="<?php echo $G['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <?php if ($G['empate'] === 0) { ?>
                                                <td><?php echo $timeb; ?></td>
                                                <input type="hidden" name="grupog[]" value="<?php echo $G['times'][1]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <select name="grupog[]" style="width: 150px;">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        for ($i = ($G['primeirolivre'] === 1) ? 1 : 0; $i < count($G['times']); $i++) {
                                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $G['times'][$i]))->row(0);
                                                            ?>
                                                            <option value="<?php echo $G['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-sitemap"></i> Grupo H</h3>
                            </div>
                            <div class="box-content">
                                <?php
                                if ($H['empate'] === 0) {
                                    $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $H['times'][0]))->row(0);
                                    $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $H['times'][1]))->row(0);
                                    $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                                } else {
                                    if ($H['primeirolivre'] === 1) {
                                        $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $H['times'][0]))->row(0);
                                        $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                                    }
                                }
                                ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <?php if ($H['empate'] === 0) { ?>
                                                <td><?php echo $timea; ?></td>
                                                <input type="hidden" name="grupoh[]" value="<?php echo $H['times'][0]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <?php if ($H['primeirolivre'] === 1) { ?>
                                                        <?php echo $timea; ?>
                                                        <input type="hidden" name="grupoh[]" value="<?php echo $H['times'][0]; ?>" />
                                                    <?php } else { ?>
                                                        <select name="grupoh[]" style="width: 150px;">
                                                            <option value="">Selecione</option>
                                                            <?php
                                                            for ($i = 0; $i < count($H['times']); $i++) {
                                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $H['times'][$i]))->row(0);
                                                                ?>
                                                                <option value="<?php echo $H['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <?php if ($H['empate'] === 0) { ?>
                                                <td><?php echo $timeb; ?></td>
                                                <input type="hidden" name="grupoh[]" value="<?php echo $H['times'][1]; ?>" />
                                            <?php } else { ?>
                                                <td>
                                                    <select name="grupoh[]" style="width: 150px;">
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        for ($i = ($H['primeirolivre'] === 1) ? 1 : 0; $i < count($H['times']); $i++) {
                                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($this->uri->segment(3), $H['times'][$i]))->row(0);
                                                            ?>
                                                            <option value="<?php echo $H['times'][$i]; ?>"><?php echo $time->time; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div style="width: 100%; float:left; margin-top: 10px;">
                            <button type="submit" class="btn btn-block btn-primary btn-lg">Salvar</button>
                        </div>
                    </div>

                </div>
                </form>

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