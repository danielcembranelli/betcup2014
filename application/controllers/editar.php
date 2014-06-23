<?php

error_reporting(E_STRICT);

class Editar extends CI_Controller {

    function editar() {
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

    public function primeirafase() {
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id'))
        );
        
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $aposta = $aposta->row(0);

        $data['aposta'] = $aposta;

        $data['apostas_jogos'] = $this->db->query("SELECT defesa FROM apostas_jogos WHERE aposta = ? ORDER BY jogo ASC", $this->uri->segment("3"));

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
    
    public function primeirafase_edita() {
        header('Content-type: text/json');
        
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id'))
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

            $this->db->where('jogo', $i)->where('aposta', $aposta)->update('apostas_jogos', Array('defesa' => $defesaJogo));
        }

        $A = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'A'));
        $B = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'B'));
        $C = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'C'));
        $D = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'D'));
        $E = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'E'));
        $F = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'F'));
        $G = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'G'));
        $H = $this->copa->vencedoresApostaFasePrimeira_Editar(Array($aposta, 'H'));

        if ($A['empate'] || $B['empate'] || $C['empate'] || $D['empate'] || $E['empate'] || $F['empate'] || $G['empate'] || $H['empate']) {
            $this->db->where('id', $aposta)->update('apostas', Array('fase' => 'empates'));
            exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_times_empatados'), 'redireciona' => 1, 'pagina' => base_url('editar/empates/' . $aposta))));
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
            $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdQuartas; $i++) {
            $times = explode(" ", $faseQuartas[$i]);
            $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdSemiFinal; $i++) {
            $times = explode(" ", $faseSemiFinal[$i]);
            $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
            $times = explode(" ", $faseTerceiroLugar[$i]);
            $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdFinal; $i++) {
            $times = explode(" ", $faseFinal[$i]);
            $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('aposta', $aposta)->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        $this->db->where('id', $aposta)->update('apostas', Array('fase' => 'oitavas'));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('editar/tabela/' . $aposta)));
    }
    
    public function empates() {
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1' AND 
            apostas.fase = 'empates'", array($this->uri->segment(3), $this->session->userdata('id'))
        );
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $aposta = $aposta->row(0);

        $data['aposta'] = $aposta;

        $this->load->library('copa');

        $data['A'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'A'));
        $data['B'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'B'));
        $data['C'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'C'));
        $data['D'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'D'));
        $data['E'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'E'));
        $data['F'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'F'));
        $data['G'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'G'));
        $data['H'] = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'H'));

        $this->load->view('site_editar_empates', $data);
    }
    
    public function empates_edita() {
        header('Content-type: text/json');

        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1' AND 
            apostas.fase = 'empates'", array($this->uri->segment(3), $this->session->userdata('id'))
        );
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $aposta = $aposta->row(0);

        $this->load->library('copa');

        $A = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'A'));
        $B = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'B'));
        $C = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'C'));
        $D = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'D'));
        $E = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'E'));
        $F = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'F'));
        $G = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'G'));
        $H = $this->copa->getEmpatadosApostaFasePrimeira_Editar(Array($this->uri->segment(3), 'H'));

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
            $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdQuartas; $i++) {
            $times = explode(" ", $faseQuartas[$i]);
            $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdSemiFinal; $i++) {
            $times = explode(" ", $faseSemiFinal[$i]);
            $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
            $times = explode(" ", $faseTerceiroLugar[$i]);
            $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdFinal; $i++) {
            $times = explode(" ", $faseFinal[$i]);
            $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('aposta', $this->uri->segment(3))->update('apostas_jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'defesa' => ''));
            $contadorJogos++;
        }

        $this->db->where('id', $this->uri->segment(3))->update('apostas', Array('fase' => 'oitavas'));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_primeira_fase_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('editar/tabela/' . $this->uri->segment(3))));
    }
    
    public function tabela() {
        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id'))
        );
        
        if ($aposta->num_rows <= 0)
            redirect('suas_apostas');

        $this->load->library('copa');

        $data['aposta'] = $this->db->query("SELECT * FROM apostas WHERE id = ?", $this->uri->segment("3"))->row(0);
        $data['jogo']['49'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '49'", $this->uri->segment("3"))->row(0);
        $data['jogo']['50'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '50'", $this->uri->segment("3"))->row(0);
        $data['jogo']['51'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '51'", $this->uri->segment("3"))->row(0);
        $data['jogo']['52'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '52'", $this->uri->segment("3"))->row(0);
        $data['jogo']['53'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '53'", $this->uri->segment("3"))->row(0);
        $data['jogo']['54'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '54'", $this->uri->segment("3"))->row(0);
        $data['jogo']['55'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '55'", $this->uri->segment("3"))->row(0);
        $data['jogo']['56'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '56'", $this->uri->segment("3"))->row(0);
        
        $this->load->view('site_editar_tabela', $data);
    }

    public function tabela_edita() {
        header('Content-type: text/json');

        $aposta = $this->db->query("
            SELECT apostas.*, premios.ativo 
            FROM apostas 
            JOIN premios ON apostas.premio = premios.id 
            WHERE apostas.id = ? AND 
            apostas.cliente = ? AND 
            apostas.status <> '2' AND 
            premios.ativo = '1'", array($this->uri->segment(3), $this->session->userdata('id'))
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
        
        $defesa = $_POST['defesa'];

        for ($i = 49; $i <= 64; $i++) {
            if (!in_array($defesa[$i], array('a', 'b')))
                exit(json_encode(array('retorno' => 1, 'aviso' => sprintf($this->lang->line('aviso_tabela_defesa'), $fasesJogos[$i]), 'redireciona' => 0, 'pagina' => '')));
        }

        $this->load->library('copa');

        $data['aposta'] = $this->db->query("SELECT * FROM apostas WHERE id = ?", $this->uri->segment("3"))->row(0);
        $data['jogo']['49'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '49'", $this->uri->segment("3"))->row(0);
        $data['jogo']['50'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '50'", $this->uri->segment("3"))->row(0);
        $data['jogo']['51'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '51'", $this->uri->segment("3"))->row(0);
        $data['jogo']['52'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '52'", $this->uri->segment("3"))->row(0);
        $data['jogo']['53'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '53'", $this->uri->segment("3"))->row(0);
        $data['jogo']['54'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '54'", $this->uri->segment("3"))->row(0);
        $data['jogo']['55'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '55'", $this->uri->segment("3"))->row(0);
        $data['jogo']['56'] = $this->db->query("SELECT * FROM apostas_jogos WHERE aposta = ? AND fase = 'oitavas' AND jogo = '56'", $this->uri->segment("3"))->row(0);

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
            $this->db->where('jogo', $i)->where('aposta', $this->uri->segment("3"))->update('apostas_jogos', array('defesa' => $defesa[$i]));

        for ($i = 57; $i <= 64; $i++)
            $this->db->where('jogo', $i)->where('aposta', $this->uri->segment("3"))->update('apostas_jogos', array('timea' => $jogo[$i]['timea'], 'timeb' => $jogo[$i]['timeb'], 'defesa' => $jogo[$i]['defesa']));

        $this->db->where('id', $this->uri->segment("3"))->update('apostas', Array('fase' => 'finalizado'));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_tabela_aposta_sucesso'), 'redireciona' => 1, 'pagina' => base_url('suas_apostas')));
    }
    
}
?>
