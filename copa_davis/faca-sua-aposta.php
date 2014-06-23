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
	
	/* $("#form-login").validate({
				submitHandler: function(form) {
					$("#loading_form").show();
					$("input[type='submit']").hide();
					$.post("faca-sua-aposta-premio.php",$("#contato-form").serialize(), function(data){
					
					if(data=='sim'){
						$("#form-login .form_resposta").slideDown();
						$("#form-login input[type='text'], #form-login input[type='password']").val("");
						$("#form-login .form_resposta").delay(5000).slideUp();
						$("#loading_form").fadeOut();
						$("input[type='submit']").show();
					} else {
						$("#form-login .form_erro").slideDown();
						$("#form-login .form_erro").delay(4000).slideUp();
						$("#loading_form").fadeOut();
						$("input[type='submit']").show();
					}
					});
				}
		 }); */
	
});
</script>

</head>

<body class="faca-sua-aposta">

<? include("includes/topo.php"); ?>

<!-- CONTEUDO -->
<section id="geral">
	<div class="ajustaTopo"></div>
	<div class="clear"></div>
	
	<article class="wrap">
		
		<h1>FAÇA SUA APOSTA</h1>
		<h2>Acessar sua conta</h2>
		
		<div class="content">
			
			<h3>Ainda não é cadastrado?</h3>
			<p><a href="cadastro.php" class="no_bg btn-apostar"><img src="images/buttons/btn-cadastrese.png" alt="btn-cadastrese"></a></p>
			
			<hr>
			
			<h3>Caso já tenha efetuado o cadastro, acesse aqui:</h3>
			<form id="form-login" method="post" action="faca-sua-aposta-premio.php">
				<h3 class="form_resposta">Login efetuado com sucesso!</h3>
				<h3 class="form_erro">ERRO DE LOGIN (email ou senha incorretos)! Tente novamente.</h3>
				<label for="email">Email <input type="text" name="email" id="email" class="required email"></label>
				<label for="senha">Senha <input type="password" name="senha" id="senha" class="required"></label>
				<p><a class="mini-link" href="#recuperar-senha">Esqueci a Senha</a> <input class="btn-apostar" type="image" src="images/buttons/btn-entrar.png"></p>
			</form>
			
		</div>
		
	</article>
		
	</div>
	
	<div class="ajustaRodape"></div>
</section>

<!-- end CONTEUDO -->

<? include("includes/rodape.php"); ?>

</body>
</html>