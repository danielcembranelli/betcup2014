<?php

class Conecta extends CI_Controller {

    function Conecta() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('conecta') == '')
            $this->session->set_userdata(array('conecta' => true));

        redirect('home');
    }

}

?>