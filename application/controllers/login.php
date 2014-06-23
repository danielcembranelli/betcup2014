<?php

class Login extends CI_Controller {

    function login() {
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
        $this->load->view('site_login');
    }

    public function autenticacao() {
        header('Content-type: text/json');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (empty($email))
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_email_em_branco'))));
        if (empty($senha))
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_senha_em_branco'))));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_email_invalido'), 'redireciona' => 0, 'pagina' => '')));

        $login = $this->db->query("SELECT * FROM clientes WHERE email = ? AND senha = ?", array($email, md5('@#b3tcup2014$' . $senha)));
        if ($login->num_rows == 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_email_senha_invalidos'), 'redireciona' => 0, 'pagina' => '')));

        $login = $login->row();

        if ($login->confirmado == 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_login_confirmar_conta'), 'redireciona' => 0, 'pagina' => '')));

        $this->session->set_userdata(array('logado' => true, 'id' => $login->id, 'nome' => $login->nome, 'sobrenome' => $login->sobrenome, 'email' => $login->email));
        echo json_encode(array('retorno' => 1, 'aviso' => $this->lang->line('aviso_login_login_sucesso'), 'redireciona' => 1, 'pagina' => base_url('faca_sua_aposta')));
    }

}

?>