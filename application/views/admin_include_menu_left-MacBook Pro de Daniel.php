<div id="sidebar" class="navbar-collapse collapse">
    <ul class="nav nav-list">
        <li>
            <form target="#" method="GET" class="search-form">
                <span class="search-pan">
                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input type="text" name="search" placeholder="Buscar ..." autocomplete="off" />
                </span>
            </form>
        </li>

        <li <?php if (in_array($this->uri->segment(2), array('home'))) echo 'class="active"'; ?>>
            <a href="admin/home">
                <i class="icon-home"></i>
                <span>In&iacute;cio</span>
            </a>
        </li>
        <li <?php if (in_array($this->uri->segment(2), array('campeonatos', 'novo_campeonato', 'editar_campeonato', 'times_campeonato', 'novo_time', 'chaves_campeonato', 'jogos_campeonato', 'primeira_fase_empates'))) echo 'class="active"'; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-sitemap"></i>
                <span>Campeonatos</span>
                <b class="arrow icon-angle-right"></b>
            </a>
            <ul class="submenu">
                <li <?php if (in_array($this->uri->segment(2), array('novo_campeonato'))) echo 'class="active"'; ?>><?php echo anchor('admin/novo_campeonato', 'Cadastrar Campeonato'); ?></li>
                <li <?php if (in_array($this->uri->segment(2), array('campeonatos'))) echo 'class="active"'; ?>><?php echo anchor('admin/campeonatos', 'Gerenciar Campeonatos'); ?></li>
            </ul>
        </li>
        <li <?php if (in_array($this->uri->segment(2), array('premios', 'novo_premio', 'editar_premio'))) echo 'class="active"'; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-trophy"></i>
                <span>Pr&ecirc;mios</span>
                <b class="arrow icon-angle-right"></b>
            </a>
            <ul class="submenu">
                <li <?php if (in_array($this->uri->segment(2), array('novo_premio'))) echo 'class="active"'; ?>><?php echo anchor('admin/novo_premio', 'Cadastrar Pr&ecirc;mio'); ?></li>
                <li <?php if (in_array($this->uri->segment(2), array('premios'))) echo 'class="active"'; ?>><?php echo anchor('admin/premios', 'Gerenciar Pr&ecirc;mios'); ?></li>
            </ul>
        </li>
        <li <?php if (in_array($this->uri->segment(2), array('clientes', 'ver_cliente', 'editar_cliente', 'apostas'))) echo 'class="active"'; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span>Clientes</span>
                <b class="arrow icon-angle-right"></b>
            </a>
            <ul class="submenu">
                <li <?php if (in_array($this->uri->segment(2), array('clientes', 'ver_cliente', 'editar_cliente', 'apostas'))) echo 'class="active"'; ?>><?php echo anchor('admin/clientes', 'Gerenciar Clientes'); ?></li>
            </ul>
        </li>
        <li <?php if (in_array($this->uri->segment(2), array('relatorio_apostadores'))) echo 'class="active"'; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-dollar"></i>
                <span>Financeiro</span>
                <b class="arrow icon-angle-right"></b>
            </a>
            <ul class="submenu">
                <li <?php if (in_array($this->uri->segment(2), array('relatorio_apostadores'))) echo 'class="active"'; ?>><?php echo anchor('admin/relatorio_apostadores', 'Relat&oacute;rio de Apostadores'); ?></li>
            </ul>
        </li>
        <li <?php if (in_array($this->uri->segment(2), array('noticias', 'nova_noticia'))) echo 'class="active"'; ?>>
            <a href="#" class="dropdown-toggle">
                <i class="icon-file-text-alt"></i>
                <span>Not&iacute;cias</span>
                <b class="arrow icon-angle-right"></b>
            </a>
            <ul class="submenu">
                <li <?php if (in_array($this->uri->segment(2), array('nova_noticia'))) echo 'class="active"'; ?>><?php echo anchor('admin/nova_noticia', 'Cadastrar Not&iacute;cia'); ?></li>
                <li <?php if (in_array($this->uri->segment(2), array('noticias'))) echo 'class="active"'; ?>><?php echo anchor('admin/noticias', 'Gerenciar Not&iacute;cias'); ?></li>
            </ul>
        </li>
    </ul>

    <div id="sidebar-collapse" class="visible-lg">
        <i class="icon-double-angle-left"></i>
    </div>
</div>