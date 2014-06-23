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

                <h1>Efetuar pagamento</h1>
                <h2>Aposta #<?php echo $aposta->id; ?> </h2>
                
                


                <div class="content">
                <h3 style="padding-top:30px">Selecione a forma de pagamento:</h3>
                
              
                    <form name="_xclick" action="https://www.paypal.com/br/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="betcia@betcia.com">
                        <input type="hidden" name="currency_code" value="BRL">
                        <input type="hidden" name="item_name" value="BetCup2014.com - Aposta: <?php echo $aposta->id; ?>">
                        <input type="hidden" name="amount" value="10.00">
                        
                      <label><input type="radio" checked> <img src="https://www.paypalobjects.com/webstatic/mktg/br/botao-checkout_horizontal_ap.png"></label>
                        <br>
                        <input type="radio" name="cards" id="visa"><label for="visa"><img src="images/icons/cards/1384823605_visa.png" alt="1384823605_visa" width="64"></label>
			          <br>
			          <input type="radio" name="cards" id="master"><label for="master"><img src="images/icons/cards/1384823380_mastercard.png" alt="1384823380_mastercard" width="64"></label>
		<br>
				<input type="radio" name="cards" id="union"><label for="union"><img src="images/icons/cards/1384823536_western_union.png" alt="1384823536_western_union" width="64"></label>
                        
                        <!--input type="image" src="" border="0" name="submit" alt="Faça pagamentos com o PayPal - é rápido, grátis e seguro!">-->
                        <p></p>
                        
                      <textarea cols="60" rows="6" style="width:400px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in eleifend magna, eu congue odio. Quisque nibh nibh, rutrum quis ultricies et, ultrices vitae sem. Nam accumsan tellus lorem, vel varius magna faucibus vel. Vivamus malesuada ornare tortor sit amet condimentum. Nullam pulvinar consectetur ipsum vel molestie. Nulla congue neque pretium dui congue, id faucibus orci accumsan. Mauris sit amet urna lacinia sem vulputate dictum ut ac sapien. In sollicitudin urna enim, quis aliquet odio vulputate quis. Suspendisse consequat vehicula augue vel varius. In et ornare elit. Morbi condimentum quam a aliquet vehicula. Sed aliquet sodales dui, fermentum tempor dolor adipiscing at. Suspendisse ullamcorper rutrum turpis id iaculis. Sed et vehicula est. Donec feugiat elit arcu, et tincidunt orci vulputate ultrices. Suspendisse euismod enim at nisi laoreet varius.

Suspendisse hendrerit sem justo, eget faucibus turpis blandit eget. Sed quis congue tortor. Pellentesque nec commodo dolor, vitae viverra velit. Cras vestibulum vel velit sed eleifend. Pellentesque id nibh libero. Aliquam consequat lacinia faucibus. Nullam et arcu in neque varius tempus. Donec ut velit nunc. Integer a imperdiet libero. Praesent vel elit quis nulla interdum commodo sit amet nec libero. Donec semper fringilla condimentum. Cras quis sagittis felis. Quisque sagittis lectus leo, non molestie ante sollicitudin vitae. Ut pretium volutpat lacus, volutpat ornare velit ornare vitae. Nunc luctus lectus purus, quis iaculis mauris rutrum sed.

Proin eleifend rutrum sapien at porttitor. Sed non varius sapien. Curabitur ac nulla vulputate, fermentum tortor ac, vestibulum felis. Sed eu sapien sed dui vehicula eleifend non ac velit. Sed non metus vitae odio tincidunt aliquet. Pellentesque sit amet odio vitae neque pretium venenatis in quis libero. Quisque massa ipsum, ultricies sed pretium in, ultrices ut enim. Mauris condimentum arcu nibh. Vivamus dolor nisl, consectetur vitae facilisis id, ultrices ut erat. Nullam consequat nibh placerat venenatis iaculis. </textarea>

<p><label><input name="" type="checkbox" value="">Aceito os Termos do Contrato</label></p>
<span class="block txt_r"><input type="submit" value="Finalizar"></span>
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