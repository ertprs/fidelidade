<?php

class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->model('login_model', 'login');
         $this->load->model('ambulatorio/empresa_model', 'empresa');
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

            if (@$_POST['txtempresa'] == "parceiro") {

                if (($this->login->autenticarparceiro($usuario, $senha)) &&
                        ($this->session->userdata('autenticado_parceiro') == true)) {
                    $valuecalculado = 0;
                    setcookie("TestCookie", $valuecalculado);
                    redirect(base_url() . "home", "refresh");
                } else {

                    $data['mensagem'] = $this->mensagem->getMensagem('login002');
                    $this->carregarView($data);
                }
            } else {

                if (($this->login->autenticar($usuario, $senha, $empresa)) &&
                        ($this->session->userdata('autenticado') == true)) {
                    $valuecalculado = 0;
                    setcookie("TestCookie", $valuecalculado);
                    redirect(base_url() . "home", "refresh");
                } else {
                    $data['mensagem'] = $this->mensagem->getMensagem('login002');
                    $this->carregarView($data);
                }
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
                redirect(base_url() . "verificar/verificarcpf", $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox.');
            redirect(base_url() . "verificar/verificarcpf", $data);
        }
    }
    
       function verificasms() {
        ini_set('display_errors', 1);
        ini_set('display_startup_erros', 1);
        error_reporting(E_ALL);

        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
 
        $empresaPermissoes = $this->login->listarEmpresa();
        $smsVerificacao = $this->login->verificaemail();
        $mensagem = $empresaPermissoes[0]->email_mensagem_aniversario;
        $nome = $empresaPermissoes[0]->nome;
           
        // $servicoemail = $empresaPermissoes[0]->servicoemail;
         if (count($smsVerificacao) == 0) {
            $aniversariantes = $this->login->aniversariantes(); 
            $totalInserido = $this->login->atualizandoaniversariantestabelaemail($aniversariantes); 
         } 
       
          $registro_email_id = $this->login->criandoregistroemail(); 
          $this->login->atualizandoregistro($registro_email_id);
          
            $dados = $this->login->listaremail();
             $this->load->library('email');
            
             if (count($dados) > 0) { 
                 foreach($dados as $item){  
                     if($mensagem != ""){
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.gmail.com';
                        $config['smtp_port'] = '465';
                        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
                        $config['smtp_pass'] = 'aramis*123@';
                        $config['validate'] = TRUE;
                        $config['mailtype'] = 'html';
                        $config['charset'] = 'utf-8';
                        $config['newline'] = "\r\n"; 
                        $this->email->initialize($config); 
                        $this->email->from('equipe2016gcjh@gmail.com',$nome);  
                        $this->email->to($item['email']); 
                        $this->email->subject('Seu Aniversário');
                        $this->email->message($item['mensagem']);
                        $this->email->send(); 
                     }
//        var_dump($this->email->send());
//        die(); 
                 }
                 
             }
          echo 'true';
         
       }
       
       
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
