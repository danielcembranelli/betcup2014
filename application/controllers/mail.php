<?php

class Mail extends CI_Controller {

    function mail() {
        parent::__construct();
    }

    public function index() {
            $this->load->helper('phpmailer');
            echo send_email("diegobtrindade@hotmail.com", "a", "m");
    }
    
}

?>