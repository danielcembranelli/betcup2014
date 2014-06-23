<?php

class Premios extends CI_Controller {

    function premios() {
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
        if ($this->session->userdata('logado')) {
            $aposta_tmp = $this->db->query("SELECT * FROM apostas_tmp WHERE cliente = ?", array($this->session->userdata('id_tmp')));
            foreach ($aposta_tmp->result() as $row) {
                $this->db->query($this->db->insert_string('apostas', array('premio' => $row->premio, 'campeonato' => $row->campeonato, 'cliente' => $this->session->userdata('id'), 'status' => $row->status, 'fase' => $row->fase, 'pontos' => $row->pontos, 'datacadastro' => $row->datacadastro)));
                $id_aposta = $this->db->insert_id();

                $apostas_jogos_tmp = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? ORDER BY jogo ASC", array($row->id));
                foreach ($apostas_jogos_tmp->result() as $row_two)
                    $this->db->query($this->db->insert_string('apostas_jogos', array('aposta' => $id_aposta, 'fase' => $row_two->fase, 'jogo' => $row_two->jogo, 'timea' => $row_two->timea, 'timeb' => $row_two->timeb, 'defesa' => $row_two->defesa, 'defesapenalti' => $row_two->defesapenalti, 'pontos' => $row_two->pontos, 'datacadastro' => $row_two->datacadastro)));

                $this->db->where('id', $row->id)->delete('apostas_tmp');
                $this->db->where('aposta', $row->id)->delete('apostas_jogos_tmp');
                redirect(base_url('efetuar_pagamento/aposta/' . $id_aposta));
            }
        }
        
        $data['premios'] = $this->db->query("SELECT * FROM premios WHERE ativo = 1");
        $this->load->view('site_premios', $data);
    }

}

?>