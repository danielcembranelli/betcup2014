<?php

class Esqueceu_senha extends CI_Controller {

    function esqueceu_senha() {
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
        if ($this->session->userdata('logado'))
            redirect('premios');
        $this->load->view('site_esqueceu_senha');
    }

    public function enviar() {
        header('Content-type: text/json');

        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_cliente_email_invalido'), 'redireciona' => 0, 'pagina' => '')));

        $cliente = $this->db->query("SELECT * FROM clientes WHERE email = ?", $email)->row(0);

        if (@$cliente->email == '')
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_email_nao_cadastrado'), 'redireciona' => 0, 'pagina' => '')));

        $token = uniqid();

        if ($this->db->where('id', $cliente->id)->update('clientes', array('token' => $token))) {
            $a = "BetCup2014 - Redefinição de Senha";
            $m = '<a href="' . base_url('esqueceu_senha/token/' . $token) . '">' . base_url('esqueceu_senha/token/' . $token) . '</a>';
            $this->load->helper('phpmailer');
            send_email($email, $a, $m);
            $json = array('retorno' => 1, 'aviso' => $this->lang->line('aviso_email_enviado_redefinicao_de_senha'), 'redireciona' => 0, 'pagina' => '');
        }
        echo json_encode($json);
    }

    public function token() {
        if ($this->session->userdata('logado'))
            redirect('home');

        $cliente = $this->db->query("SELECT * FROM clientes WHERE token = ?", $this->uri->segment("3"));
        if ($cliente->num_rows == 0)
            redirect('home');

        $this->load->view('site_alterar_senha');
    }

    public function editar_senha() {
        header('Content-type: text/json');

        $token = $this->uri->segment("3");

        $cliente = $this->db->query("SELECT * FROM clientes WHERE token = ?", $token);
        if ($cliente->num_rows == 0)
            redirect('home');

        $cliente = $cliente->row(0);

        $senha = $_POST['senha'];
        $confirmarsenha = $_POST['confirmarsenha'];

        if ($senha == '')
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_senha_em_branco'), 'redireciona' => 0, 'pagina' => '')));

        if ($senha != $confirmarsenha)
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_senhas_diferentes'), 'redireciona' => 0, 'pagina' => '')));

        $token = uniqid();
        
        if ($this->db->where('id', $cliente->id)->update('clientes', array('senha' => md5('@#b3tcup2014$' . $senha), 'token' => $token)))
            exit(json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_senha_editada_com_sucesso'), 'redireciona' => 1, 'pagina' => base_url('login'))));
    }

}

?>