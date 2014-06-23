<?php

class Idioma extends CI_Controller {

    function idioma() {
        parent::__construct();
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
        redirect(base_url('home'));
    }

	public function seleciona() {
		$this->session->set_userdata(array('idioma' => $this->uri->segment("3")));
		redirect(base_url('home'));
	}
	
}

?>