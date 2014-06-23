<?php

class Ranking extends CI_Controller {

    function ranking() {
        parent::__construct();
        $this->load->helper(array('form'));
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		switch ($lang){
			case "pt":
				$idioma = "pt";
				break;
			case "en":
				$idioma = "en";
				break;        
			default:
				$idioma = "pt";
				break;
		}
        if ($this->session->userdata('idioma') == '')
            $this->session->set_userdata(array('idioma' => $idioma));
        $this->lang->load('site', $this->session->userdata('idioma'));
    }

    public function index() {
        $this->load->library('copa');
        
        $data['apostas'] = $this->db->query("SELECT apostas.campeonato, clientes.nome, clientes.sobrenome, apostas_jogos.timea, apostas_jogos.timeb, apostas_jogos.defesa FROM apostas JOIN clientes ON apostas.cliente = clientes.id JOIN apostas_jogos ON (apostas.id = apostas_jogos.aposta AND apostas_jogos.jogo = '64') WHERE apostas.status = '1' AND apostas.fase = 'finalizado' ORDER BY apostas.posicao ASC");
        
        $this->load->view('site_ranking', $data);
    }

}

?>