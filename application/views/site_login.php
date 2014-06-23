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

        <?php
        if ($this->session->userdata('aviso')) {
            ?>
        <script type="text/javascript">
            $(function() {
                $('.form_resposta').html('<?php echo $this->session->userdata('mensagem'); ?>').hide().slideDown();
            })
        </script>
        <?php
        $this->session->set_userdata(array('aviso' => false, 'mensagem' => ''));
        }
        ?>

    </head>

    <body class="faca-sua-aposta">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('faca_sua_aposta')); ?></h1>
                <h2><?php echo $this->lang->line('Acessar_sua_conta'); ?></h2>

                <div class="content">

                    <h3><?php echo $this->lang->line('Ainda_nao_e_cadastrado'); ?></h3>
                    <p><a href="<?php echo base_url('cadastro'); ?>" class="no_bg btn-apostar"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-cadastrese.png'); ?>" alt="btn-cadastrese"></a></p>

                    <hr>

                    <h3><?php echo $this->lang->line('aviso_efetuado_cadastro'); ?></h3>
                    <?php echo form_open('login/autenticacao', 'id="form-login" class="valida"'); ?>
                    <h3 class="form_resposta"></h3>
                    <label for="email"><?php echo $this->lang->line('Email'); ?> <input type="text" name="email" id="email" class="required email"></label>
                    <label for="senha"><?php echo $this->lang->line('Senha'); ?> <input type="password" name="senha" id="senha" class="required"></label>
                    <p><a class="mini-link" href="<?php echo base_url('esqueceu_senha'); ?>"><?php echo $this->lang->line('Esqueci_senha'); ?></a> <input class="btn-apostar" type="image" src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-entrar.png'); ?>"></p>
                    </form>

                </div>

            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>