<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

    </head>

    <body class="ranking">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('Fale_conosco')); ?></h1>
                <br>
                <div class="content">


   <?php echo form_open('fale_conosco/enviar', 'id="form-cadastro" class="valida"'); ?>
                        <h3 class="form_resposta"></h3>
                        <fieldset style="width:550px;">
                            <label for="titulo"><?php echo $this->lang->line('Titulo'); ?></label>
                            <select id="titulo" name="titulo">
                                <option value=""><?php echo $this->lang->line('Selecione'); ?></option>
                                <option value="1"><?php echo $this->lang->line('Sr'); ?></option>
                                <option value="2"><?php echo $this->lang->line('Sra'); ?></option>
                            </select>
                            <label for="nome"><?php echo $this->lang->line('Nome'); ?></label>
                            <input type="text" id="nome" name="nome" class="required">
                            <label for="telefone"><?php echo $this->lang->line('Telefone'); ?></label>
                            <input type="tel" id="telefone" name="telefone" class="menor">
                            <label for="email"><?php echo $this->lang->line('Email'); ?></label>
                            <input type="email" id="email" name="email" class="required email">
                            <label for="assunto"><?php echo $this->lang->line('Assunto'); ?></label>
				<input type="text" id="assunto" name="assunto" class="required">
				<label for="mensagem"><?php echo $this->lang->line('Mensagem'); ?></label>
				<textarea id="mensagem" name="mensagem" class="required"></textarea>

                            <span class="block txt_r"><input type="submit" value="<?php echo strtoupper($this->lang->line('enviar')); ?>"></span>
                        </fieldset>
                        
                        <div class="clear"></div>
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