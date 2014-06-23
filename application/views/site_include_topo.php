<!-- AVISO IE -->
<div id="avisoie">
    <div class="avisoie-content">
        <a class="avisoie-firefox" title="<?php echo $this->lang->line('avisoie_firefox'); ?>" href="http://br.mozdev.org/download/" target="_blank"><?php echo $this->lang->line('avisoie_firefox'); ?></a>
        <a class="avisoie-chrome" title="<?php echo $this->lang->line('avisoie_chrome'); ?>" href="http://www.google.com/chrome?hl=pt-BR" target="_blank"><?php echo $this->lang->line('avisoie_chrome'); ?></a>
    </div>
</div>
<!-- end AVISO IE -->

<div id="loading_form"><h3><?php echo strtoupper($this->lang->line('enviando')); ?></h3><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/gifs/loading.gif'); ?>" alt="loading"></div>

<!-- TOPO -->
<header id="topo">
    <div class="wrap">
        <a id="logo" href="<?php echo base_url('home'); ?>" title="Início"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/logos/logo-betcup2014.png'); ?>" alt="logo-betcup2014"></a>
        <div class="login-topo">
            <?php if($this->session->userdata('logado')) { ?>
                <?php echo sprintf($this->lang->line('Bem_vindo_usuario'), $this->session->userdata('nome'). ' ' . $this->session->userdata('sobrenome')); ?> | <a href="<?php echo base_url('sair'); ?>" id="btn-login"><?php echo $this->lang->line('Sair'); ?></a>
            <?php } else { ?>
                <a href="<?php echo base_url('cadastro'); ?>"><?php echo $this->lang->line('Cadastre_se'); ?></a> | <a href="<?php echo base_url('login'); ?>" id="btn-login"><?php echo $this->lang->line('Fazer_Login'); ?></a>
            <?php } ?>
        </div>
        <nav id="menu-topo">
            <ul>
                <li class="inicio"><a href="<?php echo base_url('home'); ?>"><?php echo $this->lang->line('Inicio'); ?></a></li>
                <li class="ranking"><a href="<?php echo base_url('como_apostar'); ?>"><?php echo $this->lang->line('Como_Apostar'); ?></a></li>
                <li class="suas-apostas"><a href="<?php echo base_url('suas_apostas'); ?>"><?php echo $this->lang->line('Suas_Apostas'); ?></a></li>
                <!--li class="consultar-times"><a href="<?php echo base_url('consultar_time'); ?>"><?php echo $this->lang->line('Consultar_Times'); ?></a></li>-->
            </ul>
        </nav>
        <div id="idioma">
            <h4><?php echo $this->lang->line('Alterar_idioma'); ?></h4>
            <a id="btn-language" href="javascript:void(0);"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-language.png'); ?>" alt="btn-language"></a>
            <ul id="idiomas">
                <li><a href="<?php echo base_url('idioma/seleciona/pt'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/icons/flags/BR.png'); ?>" alt="BR"> <?php echo $this->lang->line('Portugues'); ?></a></li>
                <li><a href="<?php echo base_url('idioma/seleciona/en'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/icons/flags/GB.png'); ?>" alt="btn-language"> <?php echo $this->lang->line('Ingles'); ?></a></li>
                <li><a href="<?php echo base_url('idioma/seleciona/es'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/icons/flags/ES.png'); ?>" alt="btn-language"> <?php echo $this->lang->line('Espanhol'); ?></a></li>
            </ul>
        </div>
        <a class="btn-apostar" href="<?php echo base_url('faca_sua_aposta'); ?>"><img src="<?php echo base_url('assets/' . $this->session->userdata('idioma') . '/images/buttons/btn-faca-sua-aposta.png'); ?>" alt="btn-faca-sua-aposta"></a>
    </div>
</header>
<!-- end TOPO -->

