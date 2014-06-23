<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Pallazo Royalle</title>

<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="follow">

<? include("includes/head.php"); ?>

<script type="text/javascript">
$(document).ready(function() {

	$("li.contato a").addClass("ativo");
	
	$("#contato-form").validate({
			submitHandler: function(form) {
				$("#loading_form").show();
				$("input[type='image']").hide();
				$.post("envia.php",$("#contato-form").serialize(), function(data){
				
				
				if(data=='sim'){
					$("#contato-form .form_resposta").slideDown();
					$("#contato-form input[type='text'], #contato-form input[type='email'], #contato-form input[type='tel'], #contato-form textarea").val("");
					$("#contato-form .form_resposta").delay(3000).slideUp();
					$("#loading_form").fadeOut();
					$("input[type='image']").show();
				} else {
					$("#contato-form .form_erro").slideDown();
					$("#contato-form .form_erro").delay(3000).slideUp();
					$("#loading_form").fadeOut();
					$("input[type='image']").show();
				}
				
				});
			}
	 });
	
});
</script>

</head>

<body>

<? include("includes/topo.php"); ?>

<!-- CONTEUDO -->
<section id="geral" class="home">
	<article>
		
		<img src="images/pics/predio-casal.png" alt="predio-casal">
		
		<div class="form">
			<h5>Entre em contato através do formulário abaixo e retornaremos o mais breve possível, ou ligue para <small>(11)</small> <strong>4266-0610</strong>.</h5>
			<form id="contato-form" action="envia.php" method="post">
				<h3 class="form_resposta">OBRIGADO! Recebemos seu contato e em breve retornaremos.</h3>
				<h3 class="form_erro">ERRO DE ENVIO! Tente novamente.</h3>
				<label for="nome">NOME</label>
				<input type="text" id="nome" name="nome" class="required">
				<label for="email">EMAIL</label>
				<input type="email" id="email" name="email" class="required email">
				<label for="telefone">TELEFONE</label>
				<input type="tel" id="telefone" name="telefone" class="required menor">
				<label for="assunto">ASSUNTO</label>
				<input type="text" id="assunto" name="assunto" class="required">
				<label for="mensagem">MENSAGEM</label>
				<textarea id="mensagem" name="mensagem" class="required"></textarea>
				<input type="image" src="images/buttons/send.png">
			</form>
		</div>
						
	</article>
	
	<div class="compensa-rodape"></div>
</section>

<!-- end CONTEUDO -->

<? include("includes/rodape.php"); ?>


</body>
</html>