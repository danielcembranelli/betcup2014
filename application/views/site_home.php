<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BETCUP 2014</title>

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="robots" content="follow">

        <?php include("site_include_head.php"); ?>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.fancybox-media').attr('rel', 'media-gallery').fancybox({
                    openEffect: 'none',
                    closeEffect: 'none',
                    prevEffect: 'none',
                    nextEffect: 'none',
                    arrows: false,
                    helpers: {
                        media: {},
                        buttons: {}
                    }
                })<?php if($this->session->userdata('mostraVideo')) { ?>.click();<?php } else { echo ";"; } $this->session->set_userdata(array('mostraVideo' => '0')); ?>

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

        <?php include("site_include_topo.php"); ?>

        <!-- CONTEUDO -->
        <section id="geral">
            <div class="ajustaTopo"></div>

            <article class="wrap">
                <div id="slideshow-home">
                    <div id="slider">
                        <ul>
                            <li><a href="<?php echo base_url('faca_sua_aposta'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/pics/slideshow/01.jpg'); ?>" alt="01"></a></li>
                            <li><a href="<?php echo base_url('faca_sua_aposta'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/pics/slideshow/03.jpg'); ?>" alt="03"></a></li>
                            <li><a href="<?php echo base_url('faca_sua_aposta'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/pics/slideshow/02.jpg'); ?>" alt="02"></a></li>

                        </ul>
                    </div>
                   <!-- <a class="btn-video fancybox-media" href="http://vimeo.com/89100887"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-video-inativo.png'); ?>" alt="btn-video"></a>-->
                </div>

                <div class="mobile">
                    <img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/pics/slide-mobile.jpg'); ?>" alt="slide-mobile">
                    <a class="video-mobile fancybox-media" href="http://vimeo.com/89100887"></a>
                </div>

                <p class="txt_c etapas"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/pics/etapas-de-aposta.png'); ?>" alt="etapas-de-aposta"></p>

            </article>

        </div>

        <div class="ajustaRodape"></div>
    </section>

    <!-- end CONTEUDO -->

    <?php include("site_include_rodape.php"); ?>

</body>
</html>