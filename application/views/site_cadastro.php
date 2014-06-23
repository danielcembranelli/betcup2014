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

    <body class="cadastro">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo strtoupper($this->lang->line('cadastro')); ?></h1>
                <h2><?php echo strtoupper($this->lang->line('cadastro_sub')); ?></h2>

                <div class="content">

                    <?php echo form_open('cadastro/salvar', 'id="form-cadastro" class="valida"'); ?>
                        <h3 class="form_resposta"></h3>
                        <fieldset>
                            <label for="titulo"><?php echo $this->lang->line('Titulo'); ?></label>
                            <select id="titulo" name="titulo">
                                <option value=""><?php echo $this->lang->line('Selecione'); ?></option>
                                <option value="1"><?php echo $this->lang->line('Sr'); ?></option>
                                <option value="2"><?php echo $this->lang->line('Sra'); ?></option>
                            </select>
                            <label for="nome"><?php echo $this->lang->line('Nome'); ?></label>
                            <input type="text" id="nome" name="nome" class="required">
                            <label for="sobrenome"><?php echo $this->lang->line('Sobrenome'); ?></label>
                            <input type="text" id="sobrenome" name="sobrenome">
                            <label for="datanascimento"><?php echo $this->lang->line('Data_Nascimento'); ?></label>
                            <input type="text" id="datanascimento" name="datanascimento">
                            <label for="telefone"><?php echo $this->lang->line('Telefone'); ?></label>
                            <input type="tel" id="telefone" name="telefone" class="menor">
                            <label for="email"><?php echo $this->lang->line('Email'); ?></label>
                            <input type="email" id="email" name="email" class="required email">
                            <label for="senha"><?php echo $this->lang->line('Senha'); ?></label>
                            <input type="password" id="senha" name="senha" class="required">
                            <label for="confirmarsenha"><?php echo $this->lang->line('Confirmar_Senha'); ?></label>
                            <input type="password" id="confirmarsenha" name="confirmarsenha" class="required">
                        </fieldset>
                        <fieldset>
                            <label for="codigopostal"><?php echo $this->lang->line('Codigo_Postal'); ?></label>
                            <input type="text" id="codigopostal" name="codigopostal">
                            <label for="endereco"><?php echo $this->lang->line('Endereco'); ?></label>
                            <input type="text" id="endereco" name="endereco" style="width:300px">
                            <label for="numero"><?php echo $this->lang->line('Numero'); ?></label>
                            <input type="text" id="numero" name="numero">
                            <label for="complemento"><?php echo $this->lang->line('Complemento'); ?></label>
                            <input type="text" id="complemento" name="complemento" class="menor">
                            <label for="bairro"><?php echo $this->lang->line('Bairro'); ?></label>
                            <input type="text" id="bairro" name="bairro">
                            <label for="cidade"><?php echo $this->lang->line('Cidade'); ?></label>
                            <input type="text" id="cidade" name="cidade">
                            <label for="estado"><?php echo $this->lang->line('Estado'); ?></label>
                            <input type="text" id="estado" name="estado">
                            <label for="pais"><?php echo $this->lang->line('Pais'); ?></label>
                            <input type="text" id="pais" name="pais" class="required menor">
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