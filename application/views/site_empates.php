<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

        <script type="text/javascript" src="<?php echo base_url('assets/todos/js/form.js'); ?>"></script>

    </head>

    <body class="empates">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('faca_sua_aposta')); ?></h1>
                <h2><?php echo $this->lang->line('Primeira_Fase'); ?></h2>

                <div class="content">

                    <?php echo form_open('primeira_fase/edita_empates/' . $this->uri->segment(3), 'class="form-horizontal valida"'); ?>
                    <h3 class="form_resposta"></h3>

                    <div class="caixa-empates">
                        <?php
                        if ($A['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $A['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $A['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($A['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $A['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo A</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $A['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $A['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($B['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $B['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $B['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($B['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $B['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo B</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $B['times'][$i]))->row(0);
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
                                <input type="hidden" name="grupob[]" value="<?php echo $B['times'][1]; ?>" />
                            <?php } else { ?>
                                <td>
                                    <select name="grupob[]" style="width: 150px;">
                                        <option value="">Selecione</option>
                                        <?php
                                        for ($i = ($B['primeirolivre'] === 1) ? 1 : 0; $i < count($B['times']); $i++) {
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $B['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($C['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $C['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $C['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($C['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $C['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo C</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $C['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $C['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($D['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $D['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $D['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($D['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $D['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo D</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $D['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $D['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($E['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $E['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $E['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($E['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $E['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo E</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $E['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $E['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($F['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $F['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $F['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($F['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $F['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo F</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $F['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $F['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($G['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $G['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $G['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($G['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $G['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo G</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $G['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $G['times'][$i]))->row(0);
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

                    <div class="caixa-empates">
                        <?php
                        if ($H['empate'] === 0) {
                            $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $H['times'][0]))->row(0);
                            $chaveB = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $H['times'][1]))->row(0);
                            $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            $timeb = "<img src='" . base_url('imagens/times/' . $chaveB->foto . '') . "' title='" . $chaveB->time . "' alt='" . $chaveB->time . "' /> - " . $chaveB->time;
                        } else {
                            if ($H['primeirolivre'] === 1) {
                                $chaveA = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $H['times'][0]))->row(0);
                                $timea = "<img src='" . base_url('imagens/times/' . $chaveA->foto . '') . "' title='" . $chaveA->time . "' alt='" . $chaveA->time . "' /> - " . $chaveA->time;
                            }
                        }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Grupo H</th>
                                </tr>
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
                                                $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $H['times'][$i]))->row(0);
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
                                            $time = $this->db->query("SELECT times.time, times.foto FROM chaves JOIN times ON chaves.time = times.id WHERE campeonato = ? AND chave = ?", Array($aposta->campeonato, $H['times'][$i]))->row(0);
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
                    
                    <div>
                        <input class="btn-apostar" type="image" src="<?php echo base_url('assets/pt/images/buttons/btn-salvar.png'); ?>" />
                    </div>
                    </form>
                </div>

            </article>

            <div class="ajustaRodape"></div>
        </section>

        <!-- end CONTEUDO -->

        <?php include("site_include_rodape.php"); ?>

    </body>
</html>