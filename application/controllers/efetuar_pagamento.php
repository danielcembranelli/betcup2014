<?php

class Efetuar_pagamento extends CI_Controller {

    function efetuar_pagamento() {
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
        redirect('suas_apostas');
    }
    
    public function aposta() {
        $data['aposta'] = $this->db->query("SELECT * FROM apostas WHERE id = ? AND cliente = ? AND status = '0'", array($this->uri->segment("3"), $this->session->userdata('id')))->row(0);
		$data['premio'] = $this->db->query("SELECT * FROM premios WHERE id = ?", array($data['aposta']->premio))->row(0);
		$data['campeonato'] = $this->db->query("SELECT * FROM campeonatos WHERE id = ?", array($data['aposta']->campeonato))->row(0);
        //$data['aposta'] = $this->db->query("SELECT apostas.id, premios.premio, campeonatos.campeonato, DATE_FORMAT(premios.datacadastro, '%d/%m/%Y') AS data, apostas.status FROM apostas JOIN premios ON apostas.premio = premios.id JOIN campeonatos ON apostas.campeonato = campeonatos.id WHERE apostas.cliente = ? ORDER BY apostas.id DESC", array($this->uri->segment("3"), $this->session->userdata('id')))->row(0); 
        if($data['aposta']->id == null)
            redirect('suas_apostas');
            
        $this->load->view('site_efetuar_pagamento', $data);
    }

}

?>