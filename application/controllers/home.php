<?php

class Home extends CI_Controller {

    function home() {
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
				$idioma = "en";
				break;
		}
        if ($this->session->userdata('idioma') == '')
            $this->session->set_userdata(array('idioma' => $idioma));
        $this->lang->load('site', $this->session->userdata('idioma'));
    }

    public function index() {
        if ($this->session->userdata('mostraVideo') == '')
        if($this->agent->is_mobile()=="true"){
            $this->session->set_userdata(array('mostraVideo' => '0'));
        } else {
	        $this->session->set_userdata(array('mostraVideo' => '0'));
	        
        }
        $this->load->view('site_home');
    }

}

?>