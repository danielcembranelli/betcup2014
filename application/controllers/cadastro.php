<?php

class Cadastro extends CI_Controller {

    function cadastro() {
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
        $this->load->view('site_cadastro');
    }

    public function salvar() {
        header('Content-type: text/json');
        $this->load->helper('date');
        $this->load->library('data');
        
//        if(isset($_POST['nome']))
//            exit(json_encode(array('retorno' => 0, 'aviso' => sprintf($this->lang->line('aviso_cliente_campo_obrigatorio'), $this->lang->line('Nome')), 'redireciona' => 0, 'pagina' => '')));
        
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_cliente_email_invalido'), 'redireciona' => 0, 'pagina' => '')));
        
        if ($this->db->query("SELECT * FROM clientes WHERE email = ?", $_POST['email'])->num_rows > 0)
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_cliente_email_duplicado'), 'redireciona' => 0, 'pagina' => '')));
        
        if($_POST['senha'] != $_POST['confirmarsenha'])
            exit(json_encode(array('retorno' => 0, 'aviso' => $this->lang->line('aviso_senhas_diferentes'), 'redireciona' => 0, 'pagina' => '')));
        
        $chave = uniqid();
        
        $dataCadastro = Array('titulo' => ($_POST['titulo'] == 1) ? 1 : 2, 
            'nome' => $_POST['nome'], 
            'sobrenome' => $_POST['sobrenome'], 
            'datanascimento' => $this->data->toUS($_POST['datanascimento']), 
            'telefone' => $_POST['telefone'], 
            'email' => trim($_POST['email']), 
            'senha' => md5('@#b3tcup2014$' . $_POST['senha']), 
            'codigopostal' => $_POST['codigopostal'], 
            'endereco' => $_POST['endereco'], 
            'numero' => $_POST['numero'], 
            'complemento' => $_POST['complemento'], 
            'bairro' => $_POST['bairro'], 
            'cidade' => $_POST['cidade'], 
            'estado' => $_POST['estado'], 
            'pais' => $_POST['pais'], 
            'confirmado' => 1, 
            'chave' => $chave, 
            'datacadastro' => mdate("%Y-%m-%d %H:%i:%s"));

        if ($this->db->query($this->db->insert_string('clientes', $dataCadastro))) {
            /*
             * Metodo antigo para confirmar a conta.
            $a = "BetCup2014 - Confirmação de Cadastro";
            $m = '<a href="' .base_url('confirmacao/chave/' . $chave). '">' .base_url('confirmacao/chave/' . $chave). '</a>';
            $this->load->helper('phpmailer');
            send_email($_POST['email'], $a, $m);
            $json = array('retorno' => 1, 'aviso' => $this->lang->line('aviso_cliente_cadastrado_com_sucesso'), 'redireciona' => 0, 'pagina' => '');
             */
            
            $login = $this->db->query("SELECT * FROM clientes WHERE id = ?", $this->db->insert_id())->row(0);
            $this->session->set_userdata(array('logado' => true, 'id' => $login->id, 'nome' => $login->nome, 'sobrenome' => $login->sobrenome, 'email' => $login->email));
            $json =  array('retorno' => 1, 'aviso' => $this->lang->line('aviso_login_login_sucesso'), 'redireciona' => 1, 'pagina' => base_url('faca_sua_aposta'));
        } else
            $json = array('retorno' => 0, 'aviso' => $this->lang->line('aviso_cliente_erro_ao_cadastrar'), 'redireciona' => 0, 'pagina' => '');

        echo json_encode($json);
    }

}

?>