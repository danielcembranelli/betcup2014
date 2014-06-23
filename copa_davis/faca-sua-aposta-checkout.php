<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>BETCUP 2014</title>

<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="follow">

<? include("includes/head.php"); ?>

<script type="text/javascript">
$(document).ready(function() {
	
});
</script>

</head>

<body class="primeira-fase">

<? include("includes/topo.php"); ?>

<!-- CONTEUDO -->
<section id="geral">
	<div class="ajustaTopo"></div>
	<div class="clear"></div>
	
	<article class="wrap">
		
		<h1>FAÇA SUA APOSTA</h1>
		<h2>CHECKOUT</h2>
		
		<div class="content">
		
			<h3 style="padding-top:30px">Selecione a forma de pagamento:</h3>
			<form id="form-checkout" method="post" action="envia-checkout.php">
				<input type="radio" name="cards" id="visa"><label for="visa"><img src="images/icons/cards/1384823605_visa.png" alt="1384823605_visa" width="64"></label>
				<input type="radio" name="cards" id="master"><label for="master"><img src="images/icons/cards/1384823380_mastercard.png" alt="1384823380_mastercard" width="64"></label>
				<input type="radio" name="cards" id="paypal"><label for="paypal"><img src="images/icons/cards/1384823572_paypal.png" alt="1384823572_paypal" width="64"></label>
				<input type="radio" name="cards" id="union"><label for="union"><img src="images/icons/cards/1384823536_western_union.png" alt="1384823536_western_union" width="64"></label>
				<span class="block txt_r"><input type="submit" value="Prosseguir"></span>
			</form>
			<hr>
			<p class="txt_c"><a class="mini-link" href="history.back();">Voltar</a></p>
			
		</div>
		
	</article>
			
	<div class="ajustaRodape"></div>
</section>

<!-- end CONTEUDO -->

<? include("includes/rodape.php"); ?>

</body>
</html>