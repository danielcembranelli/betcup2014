<?php

class Tabela extends CI_Controller {

    function tabela() {
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
        redirect('faca_sua_aposta');
    }

    public function aposta() {
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas_tmp apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id_tmp'))
        );
        
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $this->load->library('copa');

        $data['aposta'] = $this->db->query("SELECT * FROM apostas_tmp WHERE id = ?", $this->uri->segment("3"))->row(0);
        $data['jogo']['49'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '49'", $this->uri->segment("3"))->row(0);
        $data['jogo']['50'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '50'", $this->uri->segment("3"))->row(0);
        $data['jogo']['51'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '51'", $this->uri->segment("3"))->row(0);
        $data['jogo']['52'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '52'", $this->uri->segment("3"))->row(0);
        $data['jogo']['53'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '53'", $this->uri->segment("3"))->row(0);
        $data['jogo']['54'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '54'", $this->uri->segment("3"))->row(0);
        $data['jogo']['55'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '55'", $this->uri->segment("3"))->row(0);
        $data['jogo']['56'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '56'", $this->uri->segment("3"))->row(0);
        
        $this->load->view('site_tabela', $data);
    }

    public function salvar() {
        header('Content-type: text/json');

        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas_tmp apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id_tmp'))
        );
        
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');
        
        $fasesJogos = Array(
            49 => $this->lang->line('Oitavas'),
            50 => $this->lang->line('Oitavas'),
            51 => $this->lang->line('Oitavas'),
            52 => $this->lang->line('Oitavas'),
            53 => $this->lang->line('Oitavas'),
            54 => $this->lang->line('Oitavas'),
            55 => $this->lang->line('Oitavas'),
            56 => $this->lang->line('Oitavas'),
            57 => $this->lang->line('Quartas'),
            58 => $this->lang->line('Quartas'),
            59 => $this->lang->line('Quartas'),
            60 => $this->lang->line('Quartas'),
            61 => $this->lang->line('Semifinais'),
            62 => $this->lang->line('Semifinais'),
            63 => $this->lang->line('Finais'),
            64 => $this->lang->line('Finais')
        );
        
        @$defesa = $_POST['defesa'];

        for ($i = 49; $i <= 64; $i++) {
            if (!in_array(@$defesa[$i], array('a', 'b')))
                exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_tabela_defesa'), $fasesJogos[$i]), 'redireciona' => 0, 'pagina' => '')));
        }

        $this->load->library('copa');

        $data['aposta'] = $this->db->query("SELECT * FROM apostas_tmp WHERE id = ?", $this->uri->segment("3"))->row(0);
        $data['jogo']['49'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '49'", $this->uri->segment("3"))->row(0);
        $data['jogo']['50'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '50'", $this->uri->segment("3"))->row(0);
        $data['jogo']['51'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '51'", $this->uri->segment("3"))->row(0);
        $data['jogo']['52'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '52'", $this->uri->segment("3"))->row(0);
        $data['jogo']['53'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '53'", $this->uri->segment("3"))->row(0);
        $data['jogo']['54'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '54'", $this->uri->segment("3"))->row(0);
        $data['jogo']['55'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '55'", $this->uri->segment("3"))->row(0);
        $data['jogo']['56'] = $this->db->query("SELECT * FROM apostas_jogos_tmp WHERE aposta = ? AND fase = 'oitavas' AND jogo = '56'", $this->uri->segment("3"))->row(0);

        $jogo[49]['defesa'] = $defesa[49];
        $jogo[50]['defesa'] = $defesa[50];
        $jogo[51]['defesa'] = $defesa[51];
        $jogo[52]['defesa'] = $defesa[52];
        $jogo[53]['defesa'] = $defesa[53];
        $jogo[54]['defesa'] = $defesa[54];
        $jogo[55]['defesa'] = $defesa[55];
        $jogo[56]['defesa'] = $defesa[56];

        $jogo[57] = array('timea' => ($defesa[49] == 'a') ? $data['jogo']['49']->timea : $data['jogo']['49']->timeb, 'timeb' => ($defesa[50] == 'a') ? $data['jogo']['50']->timea : $data['jogo']['50']->timeb);
        $jogo[58] = array('timea' => ($defesa[53] == 'a') ? $data['jogo']['53']->timea : $data['jogo']['53']->timeb, 'timeb' => ($defesa[54] == 'a') ? $data['jogo']['54']->timea : $data['jogo']['54']->timeb);
        $jogo[59] = array('timea' => ($defesa[51] == 'a') ? $data['jogo']['51']->timea : $data['jogo']['51']->timeb, 'timeb' => ($defesa[52] == 'a') ? $data['jogo']['52']->timea : $data['jogo']['52']->timeb);
        $jogo[60] = array('timea' => ($defesa[55] == 'a') ? $data['jogo']['55']->timea : $data['jogo']['55']->timeb, 'timeb' => ($defesa[56] == 'a') ? $data['jogo']['56']->timea : $data['jogo']['56']->timeb);
        $jogo[57]['defesa'] = $defesa[57];
        $jogo[58]['defesa'] = $defesa[58];
        $jogo[59]['defesa'] = $defesa[59];
        $jogo[60]['defesa'] = $defesa[60];

        $jogo[61] = array('timea' => ($defesa[57] == 'a') ? $jogo[57]['timea'] : $jogo[57]['timeb'], 'timeb' => ($defesa[58] == 'a') ? $jogo[58]['timea'] : $jogo[58]['timeb']);
        $jogo[62] = array('timea' => ($defesa[59] == 'a') ? $jogo[59]['timea'] : $jogo[59]['timeb'], 'timeb' => ($defesa[60] == 'a') ? $jogo[60]['timea'] : $jogo[60]['timeb']);
        $jogo[61]['defesa'] = $defesa[61];
        $jogo[62]['defesa'] = $defesa[62];

        $jogo[63] = array('timea' => ($defesa[61] == 'a') ? $jogo[61]['timeb'] : $jogo[61]['timea'], 'timeb' => ($defesa[62] == 'a') ? $jogo[62]['timeb'] : $jogo[62]['timea']);
        $jogo[63]['defesa'] = $defesa[63];

        $jogo[64] = array('timea' => ($defesa[61] == 'a') ? $jogo[61]['timea'] : $jogo[61]['timeb'], 'timeb' => ($defesa[62] == 'a') ? $jogo[62]['timea'] : $jogo[62]['timeb']);
        $jogo[64]['defesa'] = $defesa[64];

        for ($i = 49; $i <= 56; $i++)
            $this->db->where('jogo', $i)->where('aposta', $this->uri->segment("3"))->update('apostas_jogos_tmp', array('defesa' => $defesa[$i]));

        for ($i = 57; $i <= 64; $i++)
            $this->db->where('jogo', $i)->where('aposta', $this->uri->segment("3"))->update('apostas_jogos_tmp', array('timea' => $jogo[$i]['timea'], 'timeb' => $jogo[$i]['timeb'], 'defesa' => $jogo[$i]['defesa']));

        $this->db->where('id', $this->uri->segment("3"))->update('apostas_tmp', Array('fase' => 'finalizado'));
        
        if (!$this->session->userdata('logado')) {
            $this->session->set_userdata(array('aviso' => true, 'mensagem' => 'Efetue o login ou cadastre-se para efetuar o pagamento da sua aposta.'));
        }
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_tabela_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('suas_apostas')));
    }

}

?>