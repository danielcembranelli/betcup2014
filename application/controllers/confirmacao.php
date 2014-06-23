<?php

class Confirmacao extends CI_Controller {

    function confirmacao() {
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
        redirect('home');
    }

    public function chave() {
        if($this->session->userdata('logado'))
            redirect('home');
            
        $cliente = $this->db->query("SELECT * FROM clientes WHERE chave = ?", $this->uri->segment("3"));
        if ($cliente->num_rows == 0)
            redirect('home');

        $cliente = $cliente->row();
        
        if ($cliente->confirmado == 0)
            $this->db->where('id', $cliente->id)->update('clientes', array('confirmado' => 1));

        $this->load->view('site_confirmacao');
    }

}

?>