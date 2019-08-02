<?php

class Login extends Controller {
  
    function Login() {
        parent::Controller();
        $this->load->model('login_model', 'login');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
    }

    function index() {

        $this->carregarView();
    }

    function autenticar() {
        $usuario = $_POST['txtLogin'];
        $senha = $_POST['txtSenha'];
        $empresa = $_POST['txtempresa'];

        //Pegando o nome e versao do navegador
        preg_match('/Firefox.+/', $_SERVER['HTTP_USER_AGENT'], $browserPC);
        preg_match('/FxiOS.+/', $_SERVER['HTTP_USER_AGENT'], $browserIOS);
        $teste1 = count($browserPC);
        $teste2 = count($browserIOS);

        if ($teste1 > 0 || $teste2 > 0 || true) {
            //Pegando somente o numero da versao.
            preg_match('/[0-9].+/', $browserPC[0], $verificanavegador['versao']);

            if (($this->login->autenticar($usuario, $senha, $empresa)) &&
                    ($this->session->userdata('autenticado') == true)) {
                $valuecalculado = 0;
                setcookie("TestCookie", $valuecalculado);
                redirect(base_url() . "home", "refresh");
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login002');
                $this->carregarView($data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox.');
            $this->carregarView($data);
        }
    }

    function sair() {
        $this->session->sess_destroy();
        $data['mensagem'] = $this->mensagem->getMensagem('login003');
        $this->carregarView($data);
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }
        $data['empresa'] = $this->login->listar();
        $this->load->view('login', $data);
    }
    
      function autenticarparceiro() {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
    

        //Pegando o nome e versao do navegador
        preg_match('/Firefox.+/', $_SERVER['HTTP_USER_AGENT'], $browserPC);
        preg_match('/FxiOS.+/', $_SERVER['HTTP_USER_AGENT'], $browserIOS);
        $teste1 = count($browserPC);
        $teste2 = count($browserIOS);

        if ($teste1 > 0 || $teste2 > 0 || true) {
            
            //Pegando somente o numero da versao.
            preg_match('/[0-9].+/', $browserPC[0], $verificanavegador['versao']);

            if (($this->login->autenticarparceiro($usuario, $senha)) &&
                    ($this->session->userdata('autenticado_parceiro') == true)) {
//                $valuecalculado = 0;
//                setcookie("TestCookie", $valuecalculado);
              redirect(base_url() . "verificar/verificarcpf");
//               var_dump($senha);die;
            } else {                
                $data['mensagem'] = "erro";
                redirect(base_url() . "verificar/verificarcpf",$data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox.');
           redirect(base_url() . "verificar/verificarcpf",$data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
