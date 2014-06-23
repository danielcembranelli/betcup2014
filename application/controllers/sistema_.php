<?php

class Sistema extends CI_Controller {

    function Sistema() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('sistema') == '')
            $this->session->set_userdata(array('sistema' => true));

        redirect('home');
    }

}

?>