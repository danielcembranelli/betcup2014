<?php

error_reporting(E_STRICT);

class Primeira_fase extends CI_Controller {

    function primeira_fase() {
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

    public function premio() {
        $premio = $this->db->query("SELECT * FROM premios WHERE id = ? AND ativo = 1", array($this->uri->segment("3")));
        if ($premio->num_rows == 0)
            redirect('faca_sua_aposta');

        $premio = $premio->row(0);

        if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", $premio->campeonato)->num_rows > 0)
            redirect('premios');

        $data['premio'] = $premio;

        $this->load->library('copa');

        $data['jogos']['a'] = $this->copa->getJogosFasePrimeira('A');
        $data['jogos']['b'] = $this->copa->getJogosFasePrimeira('B');
        $data['jogos']['c'] = $this->copa->getJogosFasePrimeira('C');
        $data['jogos']['d'] = $this->copa->getJogosFasePrimeira('D');
        $data['jogos']['e'] = $this->copa->getJogosFasePrimeira('E');
        $data['jogos']['f'] = $this->copa->getJogosFasePrimeira('F');
        $data['jogos']['g'] = $this->copa->getJogosFasePrimeira('G');
        $data['jogos']['h'] = $this->copa->getJogosFasePrimeira('H');

        $this->load->view('site_primeira_fase', $data);
    }

    public function salvar() {
        header('Content-type: text/json');

        $premio = $this->db->query("SELECT * FROM premios WHERE id = ? AND ativo = 1", array($this->uri->segment("3")));
        if ($premio->num_rows == 0)
            redirect('faca_sua_aposta');

        $premio = $premio->row(0);

        if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", $premio->campeonato)->num_rows > 0)
            redirect('premios');

        $defesa = $_POST['defesa'];

        $this->load->helper('date');
        $this->load->library('copa');

        for ($i = 1; $i <= 48; $i++) {
            if (!in_array($defesa[$i], array('a', 'b', 'e')))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_defesa_invalida'), $this->copa->getGrupoJogoFasePrimeira($i)))));
        }

        if ($this->session->userdata('id_tmp') == null)
            $this->session->set_userdata(array('id_tmp' => uniqid()));

        if ($this->db->query($this->db->insert_string('apostas_tmp', array('premio' => $premio->id, 'campeonato' => $premio->campeonato, 'cliente' => $this->session->userdata('id_tmp'), 'status' => 0, 'fase' => 'primeirafase', 'pontos' => 0, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"))))) {
            $aposta = $this->db->insert_id();

            $fasePrimeira = $this->copa->getFasePrimeira();
            $faseOitavas = $this->copa->getFaseOitavas();
            $faseQuartas = $this->copa->getFaseQuartas();
            $faseSemiFinal = $this->copa->getFaseSemiFinal();
            $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
            $faseFinal = $this->copa->getFaseFinal();

            $qtdPrimeiraFase = $this->copa->getFasePrimeira('count');
            $qtdOitavas = $this->copa->getFaseOitavas('count');
            $qtdQuartas = $this->copa->getFaseQuartas('count');
            $qtdSemiFinal = $this->copa->getFaseSemiFinal('count');
            $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
            $qtdFinal = $this->copa->getFaseFinal('count');

            $contadorJogos = 1;

            for ($i = 0; $i < $qtdPrimeiraFase; $i++) {
                $times = explode(" ", $fasePrimeira[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('aposta' => $aposta, 'fase' => 'primeirafase', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdOitavas; $i++) {
                $times = explode(" ", $faseOitavas[$i]);
                $timea = utf8_encode($times[0]);
                $timeb = utf8_encode($times[1]);
                $datajogo = array('aposta' => $aposta, 'fase' => 'oitavas', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdQuartas; $i++) {
                $times = explode(" ", $faseQuartas[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('aposta' => $aposta, 'fase' => 'quartas', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdSemiFinal; $i++) {
                $times = explode(" ", $faseSemiFinal[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('aposta' => $aposta, 'fase' => 'semifinal', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                $times = explode(" ", $faseTerceiroLugar[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('aposta' => $aposta, 'fase' => 'terceirolugar', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdFinal; $i++) {
                $times = explode(" ", $faseFinal[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('aposta' => $aposta, 'fase' => 'final', 'jogo' => $contadorJogos, 'timea' => $timea, 'timeb' => $timeb, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('apostas_jogos_tmp', $datajogo));
                $contadorJogos++;
            }

            for ($i = 1; $i <= 48; $i++) {
                if ($defesa[$i] == "a")
                    $defesaJogo = "a";
                else if ($defesa[$i] == "b")
                    $defesaJogo = "b";
                else
                    $defesaJogo = "e";

                $this->db->where('jogo', $i)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('defesa' => $defesaJogo));
            }

            /* $A = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'A'));
              $B = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'B'));
              $C = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'C'));
              $D = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'D'));
              $E = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'E'));
              $F = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'F'));
              $G = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'G'));
              $H = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'H'));

              if ($A['empate'] || $B['empate'] || $C['empate'] || $D['empate'] || $E['empate'] || $F['empate'] || $G['empate'] || $H['empate']) {
              $this->db->where('id', $aposta)->update('apostas_tmp', Array('fase' => 'empates'));
              exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_times_empatados'), 'redireciona' => 1, 'pagina' => base_url('primeira_fase/empates/' . $aposta))));
              } */
            
            $grupoA = Array('A1', 'A2', 'A3', 'A4');
            $grupoB = Array('B1', 'B2', 'B3', 'B4');
            $grupoC = Array('C1', 'C2', 'C3', 'C4');
            $grupoD = Array('D1', 'D2', 'D3', 'D4');
            $grupoE = Array('E1', 'E2', 'E3', 'E4');
            $grupoF = Array('F1', 'F2', 'F3', 'F4');
            $grupoG = Array('G1', 'G2', 'G3', 'G4');
            $grupoH = Array('H1', 'H2', 'H3', 'H4');

            if (!in_array($_POST['classificadoA']['A'], $grupoA) || !in_array($_POST['classificadoB']['A'], $grupoA))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'A'))));
            
            if (!in_array($_POST['classificadoA']['B'], $grupoB) || !in_array($_POST['classificadoB']['B'], $grupoB))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'B'))));
            
            if (!in_array($_POST['classificadoA']['C'], $grupoC) || !in_array($_POST['classificadoB']['C'], $grupoC))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'C'))));
            
            if (!in_array($_POST['classificadoA']['D'], $grupoD) || !in_array($_POST['classificadoB']['D'], $grupoD))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'D'))));
            
            if (!in_array($_POST['classificadoA']['E'], $grupoE) || !in_array($_POST['classificadoB']['E'], $grupoE))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'E'))));
            
            if (!in_array($_POST['classificadoA']['F'], $grupoF) || !in_array($_POST['classificadoB']['F'], $grupoF))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'F'))));
            
            if (!in_array($_POST['classificadoA']['G'], $grupoG) || !in_array($_POST['classificadoB']['G'], $grupoG))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'G'))));
            
            if (!in_array($_POST['classificadoA']['H'], $grupoH) || !in_array($_POST['classificadoB']['H'], $grupoH))
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_invalido'), 'H'))));

            if($_POST['classificadoA']['A'] == $_POST['classificadoB']['A'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'A'))));
            
            if($_POST['classificadoA']['B'] == $_POST['classificadoB']['B'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'B'))));
            
            if($_POST['classificadoA']['C'] == $_POST['classificadoB']['C'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'C'))));
            
            if($_POST['classificadoA']['D'] == $_POST['classificadoB']['D'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'D'))));
            
            if($_POST['classificadoA']['E'] == $_POST['classificadoB']['E'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'E'))));
            
            if($_POST['classificadoA']['F'] == $_POST['classificadoB']['F'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'F'))));
            
            if($_POST['classificadoA']['G'] == $_POST['classificadoB']['G'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'G'))));
            
            if($_POST['classificadoA']['H'] == $_POST['classificadoB']['H'])
                exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_primeira_fase_classificado_repetido'), 'H'))));
            
            $faseOitavas = Array($_POST['classificadoA']['A'] . ' ' . $_POST['classificadoB']['B'], $_POST['classificadoA']['C'] . ' ' . $_POST['classificadoB']['D'], $_POST['classificadoA']['B'] . ' ' . $_POST['classificadoB']['A'], $_POST['classificadoA']['D'] . ' ' . $_POST['classificadoB']['C'], $_POST['classificadoA']['E'] . ' ' . $_POST['classificadoB']['F'], $_POST['classificadoA']['G'] . ' ' . $_POST['classificadoB']['H'], $_POST['classificadoA']['F'] . ' ' . $_POST['classificadoB']['E'], $_POST['classificadoA']['H'] . ' ' . $_POST['classificadoB']['G']);
            $qtdOitavas = count($faseOitavas);

            $contadorJogos = 49;

            for ($i = 0; $i < $qtdOitavas; $i++) {
                $times = explode(" ", $faseOitavas[$i]);
                $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
                $contadorJogos++;
            }

            $this->db->where('id', $aposta)->update('apostas_tmp', Array('fase' => 'oitavas'));
            echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('tabela/aposta/' . $aposta)));
        } else {
            echo json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_primeira_fase_erro')));
        }
    }

    public function empates() {
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas_tmp apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1' AND 
            apostas.fase = 'empates'", array($this->uri->segment(3), $this->session->userdata('id_tmp'))
        );
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $aposta = $aposta->row(0);

        $data['aposta'] = $aposta;

        $this->load->library('copa');

        $data['A'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'A'));
        $data['B'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'B'));
        $data['C'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'C'));
        $data['D'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'D'));
        $data['E'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'E'));
        $data['F'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'F'));
        $data['G'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'G'));
        $data['H'] = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'H'));

        $this->load->view('site_empates', $data);
    }

    public function edita_empates() {
        header('Content-type: text/json');

        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas_tmp apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1' AND 
            apostas.fase = 'empates'", array($this->uri->segment(3), $this->session->userdata('id_tmp'))
        );
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $aposta = $aposta->row(0);

        $this->load->library('copa');

        $A = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'A'));
        $B = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'B'));
        $C = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'C'));
        $D = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'D'));
        $E = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'E'));
        $F = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'F'));
        $G = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'G'));
        $H = $this->copa->getEmpatadosApostaFasePrimeira(Array($this->uri->segment(3), 'H'));

        if (!($A['empate'] || $B['empate'] || $C['empate'] || $D['empate'] || $E['empate'] || $F['empate'] || $G['empate'] || $H['empate']))
            redirect('suas_apostas');

        if ($A['empate']) {
            if ($A['primeirolivre']) {
                $ATimea = $A['times'][0];
                unset($A['times'][0]);
                if ($_POST['grupoa'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'A'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoa'][1], $A['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $ATimeb = $_POST['grupoa'][1];
            } else {
                if ($_POST['grupoa'][0] == '' || $_POST['grupoa'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'A'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoa'][0], $A['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoa'][1], $A['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupoa'][0] === $_POST['grupoa'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'A'), 'redireciona' => 0, 'pagina' => '')));
                $ATimea = $_POST['grupoa'][0];
                $ATimeb = $_POST['grupoa'][1];
            }
        } else {
            $ATimea = $A['times'][0];
            $ATimeb = $A['times'][1];
        }

        if ($B['empate']) {
            if ($B['primeirolivre']) {
                $BTimea = $B['times'][0];
                unset($B['times'][0]);
                if ($_POST['grupob'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'B'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupob'][1], $B['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $BTimeb = $_POST['grupob'][1];
            } else {
                if ($_POST['grupob'][0] == '' || $_POST['grupob'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'B'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupob'][0], $B['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupob'][1], $B['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupob'][0] === $_POST['grupob'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'B'), 'redireciona' => 0, 'pagina' => '')));
                $BTimea = $_POST['grupob'][0];
                $BTimeb = $_POST['grupob'][1];
            }
        } else {
            $BTimea = $B['times'][0];
            $BTimeb = $B['times'][1];
        }

        if ($C['empate']) {
            if ($C['primeirolivre']) {
                $CTimea = $C['times'][0];
                unset($C['times'][0]);
                if ($_POST['grupoc'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'C'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoc'][1], $C['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $CTimeb = $_POST['grupoc'][1];
            } else {
                if ($_POST['grupoc'][0] == '' || $_POST['grupoc'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'C'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoc'][0], $C['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoc'][1], $C['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupoc'][0] === $_POST['grupoc'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'C'), 'redireciona' => 0, 'pagina' => '')));
                $CTimea = $_POST['grupoc'][0];
                $CTimeb = $_POST['grupoc'][1];
            }
        } else {
            $CTimea = $C['times'][0];
            $CTimeb = $C['times'][1];
        }

        if ($D['empate']) {
            if ($D['primeirolivre']) {
                $DTimea = $D['times'][0];
                unset($D['times'][0]);
                if ($_POST['grupod'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'D'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupod'][1], $D['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $DTimeb = $_POST['grupod'][1];
            } else {
                if ($_POST['grupod'][0] == '' || $_POST['grupod'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'D'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupod'][0], $D['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupod'][1], $D['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupod'][0] === $_POST['grupod'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'D'), 'redireciona' => 0, 'pagina' => '')));
                $DTimea = $_POST['grupod'][0];
                $DTimeb = $_POST['grupod'][1];
            }
        } else {
            $DTimea = $D['times'][0];
            $DTimeb = $D['times'][1];
        }

        if ($E['empate']) {
            if ($E['primeirolivre']) {
                $ETimea = $E['times'][0];
                unset($E['times'][0]);
                if ($_POST['grupoe'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'E'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoe'][1], $E['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $ETimeb = $_POST['grupoe'][1];
            } else {
                if ($_POST['grupoe'][0] == '' || $_POST['grupoe'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'E'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoe'][0], $E['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoe'][1], $E['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupoe'][0] === $_POST['grupoe'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'E'), 'redireciona' => 0, 'pagina' => '')));
                $ETimea = $_POST['grupoe'][0];
                $ETimeb = $_POST['grupoe'][1];
            }
        } else {
            $ETimea = $E['times'][0];
            $ETimeb = $E['times'][1];
        }

        if ($F['empate']) {
            if ($F['primeirolivre']) {
                $FTimea = $F['times'][0];
                unset($F['times'][0]);
                if ($_POST['grupof'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'F'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupof'][1], $F['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $FTimeb = $_POST['grupof'][1];
            } else {
                if ($_POST['grupof'][0] == '' || $_POST['grupof'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'F'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupof'][0], $F['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupof'][1], $F['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupof'][0] === $_POST['grupof'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'F'), 'redireciona' => 0, 'pagina' => '')));
                $FTimea = $_POST['grupof'][0];
                $FTimeb = $_POST['grupof'][1];
            }
        } else {
            $FTimea = $F['times'][0];
            $FTimeb = $F['times'][1];
        }

        if ($G['empate']) {
            if ($G['primeirolivre']) {
                $GTimea = $G['times'][0];
                unset($G['times'][0]);
                if ($_POST['grupog'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'G'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupog'][1], $G['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $GTimeb = $_POST['grupog'][1];
            } else {
                if ($_POST['grupog'][0] == '' || $_POST['grupog'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'G'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupog'][0], $G['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupog'][1], $G['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupog'][0] === $_POST['grupog'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'G'), 'redireciona' => 0, 'pagina' => '')));
                $GTimea = $_POST['grupog'][0];
                $GTimeb = $_POST['grupog'][1];
            }
        } else {
            $GTimea = $G['times'][0];
            $GTimeb = $G['times'][1];
        }

        if ($H['empate']) {
            if ($H['primeirolivre']) {
                $HTimea = $H['times'][0];
                unset($H['times'][0]);
                if ($_POST['grupoh'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'H'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoh'][1], $H['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                $HTimeb = $_POST['grupoh'][1];
            } else {
                if ($_POST['grupoh'][0] == '' || $_POST['grupoh'][1] == '')
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_selecionar'), 'H'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoh'][0], $H['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if (!in_array($_POST['grupoh'][1], $H['times']))
                    exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_time_nao_permitido'), 'redireciona' => 0, 'pagina' => '')));
                if ($_POST['grupoh'][0] === $_POST['grupoh'][1])
                    exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_time_duplicado'), 'H'), 'redireciona' => 0, 'pagina' => '')));
                $HTimea = $_POST['grupoh'][0];
                $HTimeb = $_POST['grupoh'][1];
            }
        } else {
            $HTimea = $H['times'][0];
            $HTimeb = $H['times'][1];
        }

        $faseOitavas = Array($ATimea . ' ' . $BTimeb, $CTimea . ' ' . $DTimeb, $BTimea . ' ' . $ATimeb, $DTimea . ' ' . $CTimeb, $ETimea . ' ' . $FTimeb, $GTimea . ' ' . $HTimeb, $FTimea . ' ' . $ETimeb, $HTimea . ' ' . $GTimeb);
        $faseQuartas = $this->copa->getFaseQuartas();
        $faseSemiFinal = $this->copa->getFaseSemiFinal();
        $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
        $faseFinal = $this->copa->getFaseFinal();

        $qtdOitavas = count($faseOitavas);
        $qtdQuartas = $this->copa->getFaseQuartas('count');
        $qtdSemiFinal = $this->copa->getFaseSemiFinal('count');
        $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
        $qtdFinal = $this->copa->getFaseFinal('count');

        $contadorJogos = 49;

        for ($i = 0; $i < $qtdOitavas; $i++) {
            $times = explode(" ", $faseOitavas[$i]);
            $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdQuartas; $i++) {
            $times = explode(" ", $faseQuartas[$i]);
            $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdSemiFinal; $i++) {
            $times = explode(" ", $faseSemiFinal[$i]);
            $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
            $times = explode(" ", $faseTerceiroLugar[$i]);
            $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdFinal; $i++) {
            $times = explode(" ", $faseFinal[$i]);
            $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        $this->db->where('id', $this->uri->segment(3))->update('apostas_tmp', Array('fase' => 'oitavas'));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('tabela/aposta/' . $this->uri->segment(3))));
    }

    public function editar() {
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

        $aposta = $aposta->row(0);

        $data['aposta'] = $aposta;

        $data['apostas_jogos'] = $this->db->query("SELECT defesa FROM apostas_jogos_tmp WHERE aposta = ? ORDER BY jogo ASC", $this->uri->segment("3"));

        $this->load->library('copa');

        $data['jogos']['a'] = $this->copa->getJogosFasePrimeira('A');
        $data['jogos']['b'] = $this->copa->getJogosFasePrimeira('B');
        $data['jogos']['c'] = $this->copa->getJogosFasePrimeira('C');
        $data['jogos']['d'] = $this->copa->getJogosFasePrimeira('D');
        $data['jogos']['e'] = $this->copa->getJogosFasePrimeira('E');
        $data['jogos']['f'] = $this->copa->getJogosFasePrimeira('F');
        $data['jogos']['g'] = $this->copa->getJogosFasePrimeira('G');
        $data['jogos']['h'] = $this->copa->getJogosFasePrimeira('H');

        $this->load->view('site_primeira_fase_editar', $data);
    }

    public function edita() {
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

        $aposta = $aposta->row(0);

        $aposta = $this->uri->segment(3);
        $defesa = $_POST['defesa'];

        $this->load->helper('date');
        $this->load->library('copa');

        for ($i = 1; $i <= 48; $i++) {
            if ($defesa[$i] == "a")
                $defesaJogo = "a";
            else if ($defesa[$i] == "b")
                $defesaJogo = "b";
            else
                $defesaJogo = "e";

            $this->db->where('jogo', $i)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('defesa' => $defesaJogo));
        }

        $A = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'A'));
        $B = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'B'));
        $C = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'C'));
        $D = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'D'));
        $E = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'E'));
        $F = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'F'));
        $G = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'G'));
        $H = $this->copa->vencedoresApostaFasePrimeira(Array($aposta, 'H'));

        if ($A['empate'] || $B['empate'] || $C['empate'] || $D['empate'] || $E['empate'] || $F['empate'] || $G['empate'] || $H['empate']) {
            $this->db->where('id', $aposta)->update('apostas_tmp', Array('fase' => 'empates'));
            exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_times_empatados'), 'redireciona' => 1, 'pagina' => base_url('primeira_fase/empates/' . $aposta))));
        }

        $faseOitavas = Array($A['times'][0] . ' ' . $B['times'][1], $C['times'][0] . ' ' . $D['times'][1], $B['times'][0] . ' ' . $A['times'][1], $D['times'][0] . ' ' . $C['times'][1], $E['times'][0] . ' ' . $F['times'][1], $G['times'][0] . ' ' . $H['times'][1], $F['times'][0] . ' ' . $E['times'][1], $H['times'][0] . ' ' . $G['times'][1]);
        $faseQuartas = $this->copa->getFaseQuartas();
        $faseSemiFinal = $this->copa->getFaseSemiFinal();
        $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
        $faseFinal = $this->copa->getFaseFinal();

        $qtdOitavas = count($faseOitavas);
        $qtdQuartas = $this->copa->getFaseQuartas('count');
        $qtdSemiFinal = $this->copa->getFaseSemiFinal('count');
        $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
        $qtdFinal = $this->copa->getFaseFinal('count');

        $contadorJogos = 49;

        for ($i = 0; $i < $qtdOitavas; $i++) {
            $times = explode(" ", $faseOitavas[$i]);
            $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdQuartas; $i++) {
            $times = explode(" ", $faseQuartas[$i]);
            $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdSemiFinal; $i++) {
            $times = explode(" ", $faseSemiFinal[$i]);
            $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
            $times = explode(" ", $faseTerceiroLugar[$i]);
            $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdFinal; $i++) {
            $times = explode(" ", $faseFinal[$i]);
            $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos_tmp', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        $this->db->where('id', $aposta)->update('apostas_tmp', Array('fase' => 'oitavas'));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('tabela/aposta/' . $aposta)));
    }

}

?>