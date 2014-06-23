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
	
	$("#form-cadastro").validate({
				submitHandler: function(form) {
					$("#loading_form").show();
					$("input[type='submit']").hide();
					$.post("envia-cadastro.php",$("#form-cadastro").serialize(), function(data){
					
					if(data=='sim'){
						$("#form-cadastro .form_resposta").slideDown();
						$("#form-cadastro input[type='text'], #form-cadastro input[type='tel'], #form-cadastro input[type='email'], #form-cadastro select").val("");
						$("#form-cadastro .form_resposta").delay(7000).slideUp();
						$("#loading_form").fadeOut();
						$("input[type='submit']").show();
					} else {
						$("#form-cadastro .form_erro").slideDown();
						$("#form-cadastro .form_erro").delay(4000).slideUp();
						$("#loading_form").fadeOut();
						$("input[type='submit']").show();
					}
					});
				}
		 });
	
});
</script>

</head>

<body class="cadastro">

<? include("includes/topo.php"); ?>

<!-- CONTEUDO -->
<section id="geral">
	<div class="ajustaTopo"></div>
	<div class="clear"></div>
	
	<article class="wrap">
		
		<h1>CADASTRO</h1>
		<h2>Lorem ipsum dolor sit amet.</h2>
		
		<div class="content">
					
			<form id="form-cadastro" method="post" action="envia-cadastro.php">
				<h3 class="form_resposta">Obrigado! Seu cadastro foi enviado. Em breve você receberá em seu email um link de confirmação.</h3>
				<h3 class="form_erro">Ocorreu um erro. Tente novamente.</h3>
				<fieldset>
					<label for="nome">Nome</label>
					<input type="text" id="nome" name="nome" class="required">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" class="required email">
					<label for="telefone">Telefone</label>
					<input type="tel" id="telefone" name="telefone" class="required menor">
					<label for="celular">Celular</label>
					<input type="tel" id="celular" name="celular" class="required">
					<label for="rg">RG</label>
					<input type="text" id="rg" name="rg" class="required">
				</fieldset>
				<fieldset>
					<label for="endereco">Endereço</label>
					<input type="text" id="endereco" name="endereco" class="required" style="width:300px">
					<label for="complemento">Complemento</label>
					<input type="text" id="complemento" name="complemento" class="required menor">
					<label for="cidade">Cidade</label>
					<input type="text" id="cidade" name="cidade" class="required">
					<label for="estado">Estado</label>
					<select id="estado" name="estado" class="required">
						<option value="">Selecione</option>
						<option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AM">Amazonas</option>
                        <option value="Amapá">Amapá</option>
                        <option value="Bahia">Bahia</option>
                        <option value="Ceará">Ceará</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Espírito Santo">Espírito Santo</option>
                        <option value="Goiás">Goiás</option>
                        <option value="Maranhão">Maranhão</option>
                        <option value="Minas Gerais">Minas Gerais</option>
                        <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                        <option value="Mato Grosso">Mato Grosso</option>
                        <option value="Pará">Pará</option>
                        <option value="Paraíba">Paraíba</option>
                        <option value="Pernambuco">Pernambuco</option>
                        <option value="Piauí">Piauí</option>
                        <option value="Paraná">Paraná</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                        <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                        <option value="Rondônia">Rondônia</option>
                        <option value="Roraima">Roraima</option>
                        <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                        <option value="Santa Catarina">Santa Catarina</option>
                        <option value="Sergipe">Sergipe</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Tocantins">Tocantins</option>
					</select>
					<label for="pais">País</label>
					<input type="text" id="pais" name="pais" class="required menor">
					<span class="block txt_r"><input type="submit" value="ENVIAR"></span>
				</fieldset>
				
				
				<div class="clear"></div>
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