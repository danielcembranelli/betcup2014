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

    <body class="efetuar-pagamento">

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>
            <div class="clear"></div>

            <article class="wrap">

                <h1><?php echo $this->lang->line('Efetuar_pagamento');?></h1>
                <h2><?php echo sprintf($this->lang->line('Aposta_Numero'), strtoupper($aposta->id)); ?> </h2>
                
                


                <div class="content">
                <table>
                <tr>
                	<td>
                <h3 style="padding-top:30px"><?php echo $this->lang->line('Selecione_a_forma_de_pagamento');?></h3>
                
              
                    <form name="_xclick" action="<?php echo base_url('suas_apostas'); ?>" method="post">
                        
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="betcia@betcia.com">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="item_name" value="BetCup2014.com - Aposta: <?php echo $aposta->id; ?>">
                        <input type="hidden" name="amount" value="<?php echo $premio->custo; ?>">
                        
                      <!--<label><input type="radio" checked> <img src="https://www.paypalobjects.com/webstatic/mktg/br/botao-checkout_horizontal_ap.png"></label>-->
                    
		<br>
                        
                        <!--input type="image" src="" border="0" name="submit" alt="Faça pagamentos com o PayPal - é rápido, grátis e seguro!">-->
                        <p></p>
                        
                      <textarea cols="60" rows="6" style="width:400px"><?php echo $this->lang->line(strip_tags('Termo_Aceite'));?></textarea>

<p><label><input name="" type="checkbox" value=""><?php echo $this->lang->line('Aceito_os_Termos_do_Contrato');?></label></p>
<span class="block txt_r"><input type="submit" value="<?php echo $this->lang->line('Finalizar');?>"></span>
                    </form>
                    </td>
                    <td>
                    <h3 style="padding-top:30px"><?php echo $this->lang->line('Detalhes_da_Aposta');?>:</h3>
                    <br>
                
				<p><strong><?php echo $this->lang->line('Premio_Pagamento');?>:</strong>
                <br>
				<span><?php echo $premio->premio; ?></span></p>
				<p>
				<strong><?php echo $this->lang->line('Campeonato_Pagamento');?>:</strong><br>
				<?php echo $campeonato->campeonato; ?></p>
                <!--<p><strong><?php echo $this->lang->line('Valor_Pagamento');?>:</strong><br>
                <span>US$ <?php echo $premio->custo; ?></span></p>
                <p>
                <strong><?php echo $this->lang->line('Status_Pagamento');?>:</strong><br>
                <?
                if ($aposta->status == 0)
                   echo $this->lang->line('Status_Pagamento0');
                else if ($aposta->status == 1)
                   echo $this->lang->line('Status_Pagamento1');
                else if ($aposta->status == 2)
                    echo $this->lang->line('Status_Pagamento2');							
				?></p>-->
                
                    </td>
                    </tr>
                    </table>

                </div>
                


            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>