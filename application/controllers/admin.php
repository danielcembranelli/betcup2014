<?php

error_reporting(E_STRICT);

class Admin extends CI_Controller {

    function admin() {
        parent::__construct();
        $this->load->helper(array('form'));
        if (!$this->session->userdata('admin_logado') && !in_array(uri_string(), array('admin/index', 'admin/autenticacao')))
            redirect('admin/index');
    }

    public function index() {
        if ($this->session->userdata('admin_logado'))
            redirect('admin/home');
        $this->load->view('admin_login');
    }

    public function autenticacao() {
        header('Content-type: text/json');

        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if (empty($usuario))
            exit(json_encode(array('retorno' => 0, 'aviso' => 'Nome de Usuário inválido')));
        if (empty($senha))
            exit(json_encode(array('retorno' => 0, 'aviso' => 'Senha inválida')));

        $login = $this->db->query("SELECT * FROM admin WHERE login = ? AND senha = ?", array($usuario, md5('@#b3tcup2014$' . $senha)));
        if ($login->num_rows == 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => 'Nome de Usuário / Senha inválidos', 'redireciona' => 0, 'pagina' => '')));

        $login = $login->row();

        $this->session->set_userdata(array('admin_logado' => true, 'admin_id' => $login->id, 'admin_nome' => $login->nome, 'admin_login' => $login->login));
        echo json_encode(array('retorno' => 1, 'aviso' => 'Login efetuado com sucesso!'));
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('admin/index');
    }

    public function home() {
        $this->load->view('admin_home');
    }

    public function times_campeonato() {

        $this->load->library('pagination');

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Última';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url('admin/times_campeonato/' . $this->uri->segment(3));
        $config['total_rows'] = $this->db->where('campeonato', $this->uri->segment(3))->get('times')->num_rows;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        
        $this->pagination->initialize($config);
        
        $data['campeonato'] = $this->db->query("SELECT * FROM campeonatos WHERE id = ?", $this->uri->segment(3))->row(0);
        $data['query'] = $this->db->limit($config['per_page'], (is_null($this->uri->segment("4"))) ? 0 : $this->uri->segment("4"))->order_by('time', 'DESC')->where('campeonato', $this->uri->segment(3))->get('times');
        $this->load->view('admin_times', $data);
    }

    public function novo_time() {
        $data['campeonato'] = $this->db->query("SELECT * FROM campeonatos WHERE id = ?", $this->uri->segment(3))->row(0);
        $this->load->view('admin_novo_time', $data);
    }

    public function insere_time() {
        header('Content-type: text/json');
        $this->load->helper('date');

        $campeonato = $this->uri->segment(3);
        $ranking = $_POST['ranking'];
        $time = $_POST['time'];
        $descricao = $_POST['descricao'];

        if (!is_numeric($ranking) || $ranking < 1)
            exit(json_encode(array('retorno' => 0, 'aviso' => 'O campo Ranking tem que ser um número válido', 'redireciona' => 0, 'pagina' => '')));
        if ($this->db->query("SELECT * FROM times WHERE campeonato = ? AND ranking = ?", array($campeonato, $ranking))->num_rows > 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => 'Já existe um time com essa posição no Ranking', 'redireciona' => 0, 'pagina' => '')));

        $config['upload_path'] = './imagens/times/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto'))
            $foto = $this->upload->data();
        else
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->upload->display_errors(), 'redireciona' => 0, 'pagina' => '')));

        if ($this->db->query($this->db->insert_string('times', array('campeonato' => $campeonato, 'ranking' => $ranking, 'time' => $time, 'foto' => $foto['file_name'], 'descricao' => $descricao, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s")))))
            $json = array('retorno' => 1, 'aviso' => utf8_encode('Time cadastrado com sucesso!'), 'redireciona' => 1, 'pagina' => base_url('admin/times_campeonato/' . $campeonato));
        else
            $json = array('retorno' => 0, 'aviso' => utf8_encode('Erro ao cadastrar Time'), 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function editar_time() {
        $data['query'] = $this->db->where('id', $this->uri->segment(3))->get('times')->row(0);
        if (empty($data['query']->id))
            redirect('admin/times');
        $data['campeonato'] = $this->db->query("SELECT * FROM campeonatos WHERE id = ?", $data['query']->campeonato)->row(0);
        $this->load->view('admin_editar_time', $data);
    }

    public function edita_time() {
        header('Content-type: text/json');
        $this->load->helper('date');

        $ranking = $_POST['ranking'];
        $time = $_POST['time'];
        $descricao = $_POST['descricao'];

        if (!is_numeric($ranking) || $ranking < 1)
            exit(json_encode(array('retorno' => 0, 'aviso' => 'O campo Ranking tem que ser um número válido', 'redireciona' => 0, 'pagina' => '')));
        if ($this->db->query("SELECT * FROM times WHERE campeonato = ? AND id <> ? AND ranking = ?", array($this->uri->segment(4), $this->uri->segment(3), $ranking))->num_rows > 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => 'Já existe um time com essa posição no Ranking', 'redireciona' => 0, 'pagina' => '')));

        $data = array(
            'ranking' => $ranking,
            'time' => $time,
            'descricao' => $descricao,
            'dataeditado' => mdate("%Y-%m-%d %H:%i:%s")
        );

        if (!empty($_FILES['foto'])) {
            $config['upload_path'] = './imagens/times/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data();
                $data['foto'] = $foto['file_name'];
                $time = $this->db->where('id', $this->uri->segment(3))->get('times')->row(0);
                @unlink('./imagens/times/' . $time->foto);
            }
            else
                exit(json_encode(array('retorno' => 0, 'aviso' => $this->upload->display_errors(), 'redireciona' => 0, 'pagina' => '')));
        }

        if ($this->db->where('id', $this->uri->segment(3))->update('times', $data))
            $json = array('retorno' => 1, 'aviso' => 'Time editado com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/times_campeonato/' . $this->uri->segment(4)));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao editar Time', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function excluir_time() {
        header('Content-type: text/json');
        $this->db->where('id', $this->uri->segment(3));
        if ($this->db->delete('times'))
            $json = array('retorno' => 1, 'aviso' => 'Time excluído com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/times_campeonato/' . $this->uri->segment(4)));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao excluir Time', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function campeonatos() {
        $this->load->library('pagination');

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Última';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url('admin/campeonatos');
        $config['total_rows'] = $this->db->get('campeonatos')->num_rows;
        $config['per_page'] = 10;

        $this->pagination->initialize($config);

        $data['query'] = $this->db->limit($config['per_page'], (is_null($this->uri->segment("3"))) ? 0 : $this->uri->segment("3"))->order_by('id', 'DESC')->get('campeonatos');
        $this->load->view('admin_campeonatos', $data);
    }

    public function novo_campeonato() {
        $this->load->view('admin_novo_campeonato');
    }

    public function insere_campeonato() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $this->load->library('copa');

        $campeonato = $_POST['campeonato'];

        if ($this->db->query($this->db->insert_string('campeonatos', array('campeonato' => $campeonato, 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"))))) {
            $campeonato = $this->db->insert_id();
            $json = array('retorno' => 1, 'aviso' => 'Campeonato cadastrado com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/campeonatos'));

            $chaves = $this->copa->getChaves();
            $fasePrimeira = $this->copa->getFasePrimeira();
            $faseOitavas = $this->copa->getFaseOitavas();
            $faseQuartas = $this->copa->getFaseQuartas();
            $faseSemiFinal = $this->copa->getFaseSemiFinal();
            $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
            $faseFinal = $this->copa->getFaseFinal();

            $qtdChaves = $this->copa->getChaves('count');
            $qtdPrimeiraFase = $this->copa->getFasePrimeira('count');
            $qtdOitavas = $this->copa->getFaseOitavas('count');
            $qtdQuartas = $this->copa->getFaseQuartas('count');
            $qtdSemiFinal = $this->copa->getFaseSemiFinal('count');
            $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
            $qtdFinal = $this->copa->getFaseFinal('count');

            for ($i = 0; $i < $qtdChaves; $i++)
                $this->db->query($this->db->insert_string('chaves', array('campeonato' => $campeonato, 'chave' => $chaves[$i], 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"))));

            $contadorJogos = 1;

            for ($i = 0; $i < $qtdPrimeiraFase; $i++) {
                $times = explode(" ", $fasePrimeira[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'primeirafase', 'jogo' => $contadorJogos, 'titulo' => 'Grupo ' . $timea[0], 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdOitavas; $i++) {
                $times = explode(" ", $faseOitavas[$i]);
                $timea = utf8_encode($times[0]);
                $timeb = utf8_encode($times[1]);
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'oitavas', 'jogo' => $contadorJogos, 'titulo' => '', 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdQuartas; $i++) {
                $times = explode(" ", $faseQuartas[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'quartas', 'jogo' => $contadorJogos, 'titulo' => '', 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdSemiFinal; $i++) {
                $times = explode(" ", $faseSemiFinal[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'semifinal', 'jogo' => $contadorJogos, 'titulo' => '', 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                $times = explode(" ", $faseTerceiroLugar[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'terceirolugar', 'jogo' => $contadorJogos, 'titulo' => '', 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }

            for ($i = 0; $i < $qtdFinal; $i++) {
                $times = explode(" ", $faseFinal[$i]);
                $timea = $times[0];
                $timeb = $times[1];
                $datajogo = array('campeonato' => $campeonato, 'fase' => 'final', 'jogo' => $contadorJogos, 'titulo' => '', 'timea' => $timea, 'timeb' => $timeb, 'datacriado' => mdate("%Y-%m-%d %H:%i:%s"));
                $this->db->query($this->db->insert_string('jogos', $datajogo));
                $contadorJogos++;
            }
        }
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao cadastrar Campeonato', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function chaves_campeonato() {
        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');
        $data['chaves'] = $this->db->order_by("chave", "ASC")->where('campeonato', $this->uri->segment(3))->get('chaves');
        $data['jogos'] = $this->db->order_by("id", "ASC")->where('fase', 'primeirafase')->where('campeonato', $this->uri->segment(3))->get('jogos');
        $this->load->view('admin_chaves_campeonato', $data);
    }

    public function edita_chaves() {
        header('Content-type: text/json');
        $this->load->helper('date');

        $chaves = $_POST['times'];

        foreach (array_count_values($chaves) as $time => $quantidade)
            if ($quantidade > 1)
                exit(json_encode(array('retorno' => 0, 'aviso' => utf8_encode('Existem chaves com times duplicados, verifique e tente novamente.'), 'redireciona' => 0, 'pagina' => '')));

        foreach ($chaves as $chave => $time)
            $this->db->where('chave', $chave)->where('campeonato', $this->uri->segment(3))->update('chaves', Array('time' => $time, 'dataeditado' => mdate("%Y-%m-%d %H:%i:%s")));

        echo json_encode(array('retorno' => 1, 'aviso' => utf8_encode('Chaves editada com sucesso!'), 'redireciona' => 1, 'pagina' => base_url('admin/chaves_campeonato/' . $this->uri->segment(3))));
    }

    public function jogos_campeonato() {
        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');

        if ($data['campeonato']->fase == "empates")
            redirect('admin/primeira_fase_empates/' . $this->uri->segment(3));

        $data['fasePrimeira'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'primeirafase' ORDER BY jogo ASC", $this->uri->segment(3));
        $data['faseOitavas'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'oitavas' ORDER BY jogo ASC", $this->uri->segment(3));
        $data['faseQuartas'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'quartas' ORDER BY jogo ASC", $this->uri->segment(3));
        $data['faseSemiFinal'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'semifinal' ORDER BY jogo ASC", $this->uri->segment(3));
        $data['faseTerceiroLugar'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'terceirolugar' ORDER BY jogo ASC", $this->uri->segment(3));
        $data['faseFinal'] = $this->db->query("SELECT *, date_format(datajogo, '%d/%m/%Y') as data, date_format(datajogo, '%H:%i') as hora FROM jogos WHERE campeonato = ? AND fase = 'final' ORDER BY jogo ASC", $this->uri->segment(3));

        if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", array($this->uri->segment(3)))->num_rows > 0) {
            $data['filtro'] = 0;
        } else {
            if ($data['campeonato']->fase == "primeirafase")
                $data['filtro'] = 1;
            if ($data['campeonato']->fase == "oitavas")
                $data['filtro'] = 2;
            if ($data['campeonato']->fase == "quartas")
                $data['filtro'] = 3;
            if ($data['campeonato']->fase == "semifinal")
                $data['filtro'] = 4;
            if ($data['campeonato']->fase == "terceirolugar")
                $data['filtro'] = 5;
            if ($data['campeonato']->fase == "final")
                $data['filtro'] = 6;
        }

        $this->load->view('admin_jogos_campeonato', $data);
    }

    public function edita_jogos() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $this->load->library(Array('copa', 'data'));

        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');

        if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", array($this->uri->segment(3)))->num_rows > 0) {
            $filtro = 0;
        } else {
            if ($data['campeonato']->fase == "primeirafase")
                $filtro = 1;
            if ($data['campeonato']->fase == "oitavas")
                $filtro = 2;
            if ($data['campeonato']->fase == "quartas")
                $filtro = 3;
            if ($data['campeonato']->fase == "semifinal")
                $filtro = 4;
            if ($data['campeonato']->fase == "terceirolugar")
                $filtro = 5;
            if ($data['campeonato']->fase == "final")
                $filtro = 6;
        }

        $fase = $_POST['fase'];

        $datas = $_POST['data'];
        $horas = $_POST['hora'];
        $locais = $_POST['local'];

        foreach ($datas as $jogo => $data_)
            $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('datajogo' => $this->data->toUS($datas[$jogo]) . " " . $horas[$jogo], 'local' => $locais[$jogo], 'dataeditado' => mdate("%Y-%m-%d %H:%i:%s")));

        $pontos = $_POST['pontos'];
        $defesas = $_POST['defesa'];
        $penaltis = $_POST['penaltis'];

        if ($fase == "primeirafase" && $filtro >= 1) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '3' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND apostas_jogos.jogo = jogos.jogo AND apostas_jogos.defesa = jogos.defesa AND jogos.fase = 'primeirafase' AND apostas_jogos.fase = 'primeirafase' AND jogos.defesa IS NOT NULL AND jogos.defesa <> ''", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }

            if ($this->db->query("SELECT * FROM jogos WHERE fase = 'primeirafase' AND campeonato = ? AND defesa = ''", array($this->uri->segment(3)))->num_rows == 0) {

                $A = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'A'));
                $B = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'B'));
                $C = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'C'));
                $D = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'D'));
                $E = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'E'));
                $F = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'F'));
                $G = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'G'));
                $H = $this->copa->vencedoresFasePrimeira(Array($this->uri->segment(3), 'H'));

                if ($A['empate'] || $B['empate'] || $C['empate'] || $D['empate'] || $E['empate'] || $F['empate'] || $G['empate'] || $H['empate']) {
                    $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'empates'));
                    exit(json_encode(array('retorno' => 1, 'aviso' => utf8_encode('Existem times com resultados empatados, ser&aacute; necess&aacute;rio editar manualmente... voc&ecirc; est&aacute; sendo redirecionado...'), 'redireciona' => 1, 'pagina' => base_url('admin/primeira_fase_empates/' . $this->uri->segment(3)))));
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
                    $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdQuartas; $i++) {
                    $times = explode(" ", $faseQuartas[$i]);
                    $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdSemiFinal; $i++) {
                    $times = explode(" ", $faseSemiFinal[$i]);
                    $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                    $times = explode(" ", $faseTerceiroLugar[$i]);
                    $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdFinal; $i++) {
                    $times = explode(" ", $faseFinal[$i]);
                    $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'oitavas'));
            }
        } else if ($fase == "oitavas" && $filtro >= 2) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo], 'defesapenalti' => $penaltis[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '4' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'oitavas' AND apostas_jogos.fase = 'oitavas' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timea, jogos.timeb), IF(jogos.defesa = 'a', jogos.timea, jogos.timeb)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timea, apostas_jogos.timeb), IF(apostas_jogos.defesa = 'a', apostas_jogos.timea, apostas_jogos.timeb)))", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }

            if ($this->db->query("SELECT * FROM jogos WHERE fase = 'oitavas' AND campeonato = ? AND defesa = ''", array($this->uri->segment(3)))->num_rows == 0) {

                $J49 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 49));
                $J50 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 50));
                $J51 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 51));
                $J52 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 52));
                $J53 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 53));
                $J54 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 54));
                $J55 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 55));
                $J56 = $this->copa->vencedoresFaseOitavas(Array($this->uri->segment(3), 56));

                $faseQuartas = Array($J49 . ' ' . $J50, $J53 . ' ' . $J54, $J51 . ' ' . $J52, $J55 . ' ' . $J56);
                $faseSemiFinal = $this->copa->getFaseSemiFinal();
                $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
                $faseFinal = $this->copa->getFaseFinal();

                $qtdQuartas = count($faseQuartas);
                $qtdSemiFinal = $this->copa->getFaseSemiFinal('count');
                $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
                $qtdFinal = $this->copa->getFaseFinal('count');

                $contadorJogos = 57;

                for ($i = 0; $i < $qtdQuartas; $i++) {
                    $times = explode(" ", $faseQuartas[$i]);
                    $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdSemiFinal; $i++) {
                    $times = explode(" ", $faseSemiFinal[$i]);
                    $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                    $times = explode(" ", $faseTerceiroLugar[$i]);
                    $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdFinal; $i++) {
                    $times = explode(" ", $faseFinal[$i]);
                    $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'quartas'));
            }
        } else if ($fase == "quartas" && $filtro >= 3) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo], 'defesapenalti' => $penaltis[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '6' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'quartas' AND apostas_jogos.fase = 'quartas' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timea, jogos.timeb), IF(jogos.defesa = 'a', jogos.timea, jogos.timeb)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timea, apostas_jogos.timeb), IF(apostas_jogos.defesa = 'a', apostas_jogos.timea, apostas_jogos.timeb)))", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }

            if ($this->db->query("SELECT * FROM jogos WHERE fase = 'quartas' AND campeonato = ? AND defesa = ''", array($this->uri->segment(3)))->num_rows == 0) {

                $J57 = $this->copa->vencedoresFaseQuartas(Array($this->uri->segment(3), 57));
                $J58 = $this->copa->vencedoresFaseQuartas(Array($this->uri->segment(3), 58));
                $J59 = $this->copa->vencedoresFaseQuartas(Array($this->uri->segment(3), 59));
                $J60 = $this->copa->vencedoresFaseQuartas(Array($this->uri->segment(3), 60));

                $faseSemiFinal = Array($J57 . ' ' . $J58, $J59 . ' ' . $J60);
                $faseTerceiroLugar = $this->copa->getFaseTerceiroLugar();
                $faseFinal = $this->copa->getFaseFinal();

                $qtdSemiFinal = count($faseSemiFinal);
                $qtdTerceiroLugar = $this->copa->getFaseTerceiroLugar('count');
                $qtdFinal = $this->copa->getFaseFinal('count');

                $contadorJogos = 61;

                for ($i = 0; $i < $qtdSemiFinal; $i++) {
                    $times = explode(" ", $faseSemiFinal[$i]);
                    $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                    $times = explode(" ", $faseTerceiroLugar[$i]);
                    $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdFinal; $i++) {
                    $times = explode(" ", $faseFinal[$i]);
                    $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'semifinal'));
            }
        } else if ($fase == "semifinal" && $filtro >= 4) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo], 'defesapenalti' => $penaltis[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '8' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'semifinal' AND apostas_jogos.fase = 'semifinal' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timea, jogos.timeb), IF(jogos.defesa = 'a', jogos.timea, jogos.timeb)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timea, apostas_jogos.timeb), IF(apostas_jogos.defesa = 'a', apostas_jogos.timea, apostas_jogos.timeb)))", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }

            if ($this->db->query("SELECT * FROM jogos WHERE fase = 'semifinal' AND campeonato = ? AND defesa = ''", array($this->uri->segment(3)))->num_rows == 0) {

                $P61 = $this->copa->perdedoresFaseSemiFinal(Array($this->uri->segment(3), 61));
                $P62 = $this->copa->perdedoresFaseSemiFinal(Array($this->uri->segment(3), 62));
                $V61 = $this->copa->vencedoresFaseSemiFinal(Array($this->uri->segment(3), 61));
                $V62 = $this->copa->vencedoresFaseSemiFinal(Array($this->uri->segment(3), 62));

                $faseTerceiroLugar = Array($P61 . ' ' . $P62);
                $faseFinal = Array($V61 . ' ' . $V62);

                $qtdTerceiroLugar = count($faseTerceiroLugar);
                $qtdFinal = count($faseFinal);

                $contadorJogos = 63;

                for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
                    $times = explode(" ", $faseTerceiroLugar[$i]);
                    $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                for ($i = 0; $i < $qtdFinal; $i++) {
                    $times = explode(" ", $faseFinal[$i]);
                    $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
                    $contadorJogos++;
                }

                $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'terceirolugar'));
            }
        } else if ($fase == "terceirolugar" && $filtro >= 5) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo], 'defesapenalti' => $penaltis[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '5' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'terceirolugar' AND apostas_jogos.fase = 'terceirolugar' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timea, jogos.timeb), IF(jogos.defesa = 'a', jogos.timea, jogos.timeb)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timea, apostas_jogos.timeb), IF(apostas_jogos.defesa = 'a', apostas_jogos.timea, apostas_jogos.timeb)))", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }

            if ($this->db->query("SELECT * FROM jogos WHERE fase = 'terceirolugar' AND campeonato = ? AND defesa = ''", array($this->uri->segment(3)))->num_rows == 0)
                $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'final'));
        } else if ($fase == "final" && $filtro >= 5) {

            foreach ($pontos as $jogo => $ponto)
                $this->db->where('jogo', $jogo)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('pontos' => $pontos[$jogo], 'defesa' => $defesas[$jogo], 'defesapenalti' => $penaltis[$jogo]));

            if ($this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '0' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'final' AND apostas_jogos.fase = 'final' AND jogos.defesa IS NOT NULL AND jogos.defesa <> ''", array($this->uri->segment(3), $this->uri->segment(3)))) {
                $this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = '10' WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'final' AND apostas_jogos.fase = 'final' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timea, jogos.timeb), IF(jogos.defesa = 'a', jogos.timea, jogos.timeb)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timea, apostas_jogos.timeb), IF(apostas_jogos.defesa = 'a', apostas_jogos.timea, apostas_jogos.timeb)))", array($this->uri->segment(3), $this->uri->segment(3)));
                $this->db->query("UPDATE apostas, apostas_jogos, jogos SET apostas_jogos.pontos = apostas_jogos.pontos+7 WHERE apostas.campeonato = ? AND jogos.campeonato = ? AND apostas.id = apostas_jogos.aposta AND jogos.fase = 'final' AND apostas_jogos.fase = 'final' AND jogos.defesa IS NOT NULL AND jogos.defesa <> '' AND (IF(jogos.defesa = 'p', IF(jogos.defesapenalti = 'a', jogos.timeb, jogos.timea), IF(jogos.defesa = 'a', jogos.timeb, jogos.timea)) = IF(apostas_jogos.defesa = 'p', IF(apostas_jogos.defesapenalti = 'a', apostas_jogos.timeb, apostas_jogos.timea), IF(apostas_jogos.defesa = 'a', apostas_jogos.timeb, apostas_jogos.timea)))", array($this->uri->segment(3), $this->uri->segment(3)));
                $this->db->query("UPDATE apostas, apostas_jogos SET apostas.pontos = (SELECT SUM(pontos) FROM apostas_jogos WHERE apostas_jogos.aposta = apostas.id)WHERE apostas.campeonato = ? AND apostas.id = apostas_jogos.aposta", array($this->uri->segment(3)));
            }
        }

        echo json_encode(array('retorno' => 1, 'aviso' => utf8_encode('Jogos editado com sucesso!'), 'redireciona' => 1, 'pagina' => base_url('admin/jogos_campeonato/' . $this->uri->segment(3))));
    }

    public function primeira_fase_empates() {
        $this->load->library('copa');

        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');

        if ($this->db->query("SELECT * FROM chaves WHERE campeonato = ? AND time = '0'", array($this->uri->segment(3)))->num_rows > 0) {
            $data['filtro'] = 0;
        } else {
            if ($data['campeonato']->fase == "primeirafase")
                $data['filtro'] = 1;
            if ($data['campeonato']->fase == "oitavas")
                $data['filtro'] = 2;
            if ($data['campeonato']->fase == "quartas")
                $data['filtro'] = 3;
            if ($data['campeonato']->fase == "semifinal")
                $data['filtro'] = 4;
            if ($data['campeonato']->fase == "terceirolugar")
                $data['filtro'] = 5;
            if ($data['campeonato']->fase == "final")
                $data['filtro'] = 6;
        }

        if ($data['campeonato']->fase != "empates")
            redirect('admin/campeonatos');

        $data['A'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'A'));
        $data['B'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'B'));
        $data['C'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'C'));
        $data['D'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'D'));
        $data['E'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'E'));
        $data['F'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'F'));
        $data['G'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'G'));
        $data['H'] = $this->copa->getEmpatadosFasePrimeira(Array($this->uri->segment(3), 'H'));

        $this->load->view('admin_primeira_fase_empates', $data);
    }

    public function edita_jogos_empates() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $this->load->library(Array('copa', 'data'));

        $A = $_POST['grupoa'];
        $B = $_POST['grupob'];
        $C = $_POST['grupoc'];
        $D = $_POST['grupod'];
        $E = $_POST['grupoe'];
        $F = $_POST['grupof'];
        $G = $_POST['grupog'];
        $H = $_POST['grupoh'];

        $faseOitavas = Array($A[0] . ' ' . $B[1], $C[0] . ' ' . $D[1], $B[0] . ' ' . $A[1], $D[0] . ' ' . $C[1], $E[0] . ' ' . $F[1], $G[0] . ' ' . $H[1], $F[0] . ' ' . $E[1], $H[0] . ' ' . $G[1]);
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
            $this->db->where('fase', 'oitavas')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdQuartas; $i++) {
            $times = explode(" ", $faseQuartas[$i]);
            $this->db->where('fase', 'quartas')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdSemiFinal; $i++) {
            $times = explode(" ", $faseSemiFinal[$i]);
            $this->db->where('fase', 'semifinal')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdTerceiroLugar; $i++) {
            $times = explode(" ", $faseTerceiroLugar[$i]);
            $this->db->where('fase', 'terceirolugar')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
            $contadorJogos++;
        }

        for ($i = 0; $i < $qtdFinal; $i++) {
            $times = explode(" ", $faseFinal[$i]);
            $this->db->where('fase', 'final')->where('jogo', $contadorJogos)->where('campeonato', $this->uri->segment(3))->update('jogos', Array('timea' => $times[0], 'timeb' => $times[1], 'pontos' => '0', 'defesa' => ''));
            $contadorJogos++;
        }

        $this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('fase' => 'oitavas'));
        echo json_encode(array('retorno' => 1, 'aviso' => utf8_encode('Jogos editado com sucesso!'), 'redireciona' => 1, 'pagina' => base_url('admin/jogos_campeonato/' . $this->uri->segment(3))));
    }

    public function editar_campeonato() {
        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');

        $this->load->view('admin_editar_campeonato', $data);
    }

    public function edita_campeonato() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $data['campeonato'] = $this->db->where('id', $this->uri->segment(3))->get('campeonatos')->row(0);
        if (empty($data['campeonato']->id))
            redirect('admin/campeonatos');

        if ($this->db->where('id', $this->uri->segment(3))->update('campeonatos', Array('campeonato' => $_POST['campeonato'], 'dataeditado' => mdate("%Y-%m-%d %H:%i:%s"))))
            $json = array('retorno' => 1, 'aviso' => utf8_encode('Campeonato editado com sucesso!'), 'redireciona' => 1, 'pagina' => base_url('admin/campeonatos'));
        else
            $json = array('retorno' => 0, 'aviso' => utf8_encode('Erro ao editar Campeonato'), 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function excluir_campeonato() {
        header('Content-type: text/json');
        if ($this->db->where('id', $this->uri->segment(3))->delete('campeonatos')) {
            $this->db->where('campeonato', $this->uri->segment(3))->delete('chaves');
            $this->db->where('campeonato', $this->uri->segment(3))->delete('jogos');
            $json = array('retorno' => 1, 'aviso' => 'Campeonato excluído com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/campeonatos'));
        }
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao excluir Campeonato', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function premios() {
        $this->load->library('pagination');

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Última';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url('admin/premios');
        $config['total_rows'] = $this->db->get('premios')->num_rows;
        $config['per_page'] = 10;

        $this->pagination->initialize($config);

        $data['premios'] = $this->db->limit($config['per_page'], (is_null($this->uri->segment("3"))) ? 0 : $this->uri->segment("3"))->order_by('premios.id', 'DESC')->join('campeonatos', 'premios.campeonato = campeonatos.id')->select('premios.id, premios.ativo, campeonatos.campeonato, premios.premio, premios.foto')->get('premios');
        $this->load->view('admin_premios', $data);
    }

    public function novo_premio() {
        $data['campeonatos'] = $this->db->order_by('id', 'DESC')->get('campeonatos');
        $this->load->view('admin_novo_premio', $data);
    }

    public function insere_premio() {
        header('Content-type: text/json');
        $this->load->helper('date');

        $config['upload_path'] = './imagens/premios/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto'))
            $foto = $this->upload->data();
        else
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->upload->display_errors(), 'redireciona' => 0, 'pagina' => '')));

        if ($this->db->query($this->db->insert_string('premios', Array('ativo' => ($_POST['ativo']) ? 1 : 0, 'campeonato' => $_POST['campeonato'], 'premio' => $_POST['premio'], 'foto' => $foto['file_name'], 'datacadastro' => mdate("%Y-%m-%d %H:%i:%s")))))
            $json = array('retorno' => 1, 'aviso' => 'Prêmio cadastrado com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/premios'));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao cadastrar Prêmio', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function editar_premio() {
        $data['premio'] = $this->db->where('id', $this->uri->segment(3))->get('premios')->row(0);
        $data['campeonatos'] = $this->db->order_by('id', 'DESC')->get('campeonatos');
        $this->load->view('admin_editar_premio', $data);
    }

    public function edita_premio() {
        header('Content-type: text/json');
        $this->load->helper('date');

        $data = array('ativo' => ($_POST['ativo']) ? 1 : 0, 'campeonato' => $_POST['campeonato'], 'premio' => $_POST['premio'], 'dataeditado' => mdate("%Y-%m-%d %H:%i:%s"));

        if (!empty($_FILES['foto'])) {
            $config['upload_path'] = './imagens/premios/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data();
                $data['foto'] = $foto['file_name'];
                $premio = $this->db->where('id', $this->uri->segment(3))->get('premios')->row(0);
                @unlink('./imagens/premios/' . $premio->foto);
            }
            else
                exit(json_encode(array('retorno' => 0, 'aviso' => $this->upload->display_errors(), 'redireciona' => 0, 'pagina' => '')));
        }

        if ($this->db->where('id', $this->uri->segment(3))->update('premios', $data))
            $json = array('retorno' => 1, 'aviso' => 'Prêmio editado com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/premios'));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao editar Prêmio', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function excluir_premio() {
        header('Content-type: text/json');
        if ($this->db->where('id', $this->uri->segment(3))->delete('premios'))
            $json = array('retorno' => 1, 'aviso' => 'Prêmio excluído com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/premios'));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao excluir Prêmio', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function clientes() {
        $this->load->library('pagination');

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'Primeira';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Última';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url('admin/clientes');
        $config['total_rows'] = $this->db->get('clientes')->num_rows;
        $config['per_page'] = 10;

        $this->pagination->initialize($config);

        $data['clientes'] = $this->db->limit($config['per_page'], (is_null($this->uri->segment("3"))) ? 0 : $this->uri->segment("3"))->order_by('clientes.id', 'DESC')->select('clientes.id, clientes.nome, clientes.sobrenome, clientes.email')->get('clientes');
        $this->load->view('admin_clientes', $data);
    }

    public function ver_cliente() {
        $data['cliente'] = $this->db->query("SELECT *, DATE_FORMAT(datanascimento, '%d/%m/%Y') AS datanascimento FROM clientes WHERE id = ?", $this->uri->segment("3"))->row(0);
        $this->load->view('admin_ver_cliente', $data);
    }

    public function apostas() {
        $data['cliente'] = $this->db->query("SELECT * FROM clientes WHERE id = ?", $this->uri->segment("3"))->row(0);
        $data['apostas'] = $this->db->query("SELECT apostas.id, premios.premio, campeonatos.campeonato, DATE_FORMAT(premios.datacadastro, '%d/%m/%Y') AS data, apostas.status FROM apostas JOIN premios ON apostas.premio = premios.id JOIN campeonatos ON apostas.campeonato = campeonatos.id WHERE apostas.cliente = ? ORDER BY apostas.id DESC", $this->uri->segment("3"));
        $this->load->view('admin_apostas', $data);
    }

    public function editar_cliente() {
        $data['cliente'] = $this->db->query("SELECT *, DATE_FORMAT(datanascimento, '%d/%m/%Y') AS datanascimento FROM clientes WHERE id = ?", $this->uri->segment("3"))->row(0);
        $this->load->view('admin_editar_cliente', $data);
    }

    public function edita_cliente() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $this->load->library('data');

        $data = array(
            'nome' => $_POST['nome'],
            'sobrenome' => $_POST['sobrenome'],
            'datanascimento' => $this->data->toUS($_POST['datanascimento']),
            'endereco' => $_POST['endereco'],
            'numero' => $_POST['numero'],
            'complemento' => $_POST['complemento'],
            'bairro' => $_POST['bairro'],
            'codigopostal' => $_POST['codigopostal'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado'],
            'pais' => $_POST['pais'],
            'telefone' => $_POST['telefone'],
            'email' => $_POST['email'],
            'dataeditado' => mdate("%Y-%m-%d %H:%i:%s")
        );

        if ($_POST['senha'] != '')
            $data['senha'] = md5('@#b3tcup2014$' . $_POST['senha']);

        if ($this->db->where('id', $this->uri->segment(3))->update('clientes', $data))
            $json = array('retorno' => 1, 'aviso' => utf8_encode('Cliente editado com sucesso!'), 'redireciona' => 0, 'pagina' => '');
        else
            $json = array('retorno' => 0, 'aviso' => utf8_encode('Erro ao editar Cliente'), 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function excluir_cliente() {
        header('Content-type: text/json');
        if ($this->db->where('id', $this->uri->segment(3))->delete('clientes'))
            $json = array('retorno' => 1, 'aviso' => 'Cliente excluído com sucesso!', 'redireciona' => 1, 'pagina' => base_url('admin/clientes'));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao excluir Cliente', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function cancelar_aposta() {
        header('Content-type: text/json');
        if ($this->db->where('id', $this->uri->segment(3))->update('apostas', array('status' => 2)))
            $json = array('retorno' => 1, 'aviso' => 'Aposta cancelada com sucesso', 'redireciona' => 1, 'pagina' => base_url('admin/apostas/' . $this->uri->segment(3)));
        else
            $json = array('retorno' => 0, 'aviso' => 'Erro ao cancelar Aposta', 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

    public function relatorio_apostadores() {
        $data['mesano'] = $this->db->query("SELECT DATE_FORMAT(datacadastro, '%m/%Y') AS data FROM apostas WHERE 1 GROUP BY MONTH(datacadastro), YEAR(datacadastro) ORDER BY datacadastro DESC");
        $data['apostas']['pendentes'] = $this->db->query("SELECT * FROM apostas WHERE status = 0")->num_rows;
        $data['apostas']['pagas'] = $this->db->query("SELECT * FROM apostas WHERE status = 1")->num_rows;
        $data['apostas']['canceladas'] = $this->db->query("SELECT * FROM apostas WHERE status = 2")->num_rows;
        $this->load->view('admin_relatorio_apostadores', $data);
    }

    public function busca_relatorio_apostas() {
        header('Content-type: text/javascript');

        $mesAno = explode("/", $_POST['mesano']);
        $mes = $mesAno[0];
        $ano = $mesAno[1];

        $jsPendentes = "";
        $jsPagas = "";
        $jsCanceladas = "";

        $apostas = $this->db->query("SELECT DATE_FORMAT(datacadastro, '%d') AS dia FROM apostas WHERE MONTH(datacadastro) = '" . $mes . "' AND YEAR(datacadastro) = '" . $ano . "' GROUP BY DAY(datacadastro), MONTH(datacadastro), YEAR(datacadastro) ORDER BY datacadastro ASC");
        foreach ($apostas->result() as $row) {

            $pendentes = $this->db->query("SELECT * FROM apostas WHERE status = '0' AND DAY(datacadastro) = '" . $row->dia . "' AND MONTH(datacadastro) = '" . $mes . "' AND YEAR(datacadastro) = '" . $ano . "'")->num_rows;
            if ($pendentes > 0)
                $jsPendentes .= "[" . $row->dia . ", " . $pendentes . "], ";

            $pagas = $this->db->query("SELECT * FROM apostas WHERE status = '1' AND DAY(datacadastro) = '" . $row->dia . "' AND MONTH(datacadastro) = '" . $mes . "' AND YEAR(datacadastro) = '" . $ano . "'")->num_rows;
            if ($pagas > 0)
                $jsPagas .= "[" . $row->dia . ", " . $pagas . "], ";

            $canceladas = $this->db->query("SELECT * FROM apostas WHERE status = '2' AND DAY(datacadastro) = '" . $row->dia . "' AND MONTH(datacadastro) = '" . $mes . "' AND YEAR(datacadastro) = '" . $ano . "'")->num_rows;
            if ($canceladas > 0)
                $jsCanceladas .= "[" . $row->dia . ", " . $canceladas . "], ";
        }

        echo "var pendentes = [" . $jsPendentes . "]; var pagas = [" . $jsPagas . "]; var canceladas = [" . $jsCanceladas . "];";
    }

}

?>