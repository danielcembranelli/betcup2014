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

	$("li.inicio a").addClass("ativo");
	
	$("#slider").easySlider({
		auto: true,
		continuous: true,
		controlsShow: false,
		speed: 800,
		pause: 5000,
	});
	
});
</script>

</head>

<body class="home">

<? include("includes/topo.php"); ?>

<!-- CONTEUDO -->
<section id="geral">
	<div class="ajustaTopo"></div>
	
	<article class="wrap">
		<div id="slideshow-home">
			<div id="slider">
				<ul>
                	<li><img src="images/pics/slideshow/01.jpg" alt="01"></li>
                	<li><img src="images/pics/slideshow/01.jpg" alt="02"></li>
                	<li><img src="images/pics/slideshow/01.jpg" alt="03"></li>
				</ul>
            </div>
			<a class="btn-video" href="#video"><img src="images/buttons/btn-video-inativo.png" alt="btn-video"></a>
		</div>
		
		<div class="mobile">
			<img src="images/pics/slide-mobile.jpg" alt="slide-mobile">
			<a class="video-mobile" href="#video"></a>
		</div>
		
		<p class="txt_c etapas"><img src="images/pics/etapas-de-aposta.png" alt="etapas-de-aposta"></p>
		
	</article>
		
	</div>
	
	<div class="ajustaRodape"></div>
</section>

<!-- end CONTEUDO -->

<? include("includes/rodape.php"); ?>

</body>
</html>