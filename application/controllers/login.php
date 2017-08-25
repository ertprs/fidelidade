<?php

class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->model('login_model', 'login');
        $this->load->library('mensagem');
    }

    function index() {
        $this->carregarView();
    }

    function verificasms() {
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);

        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão

        $servicoemail = $this->session->userdata('servicoemail');

        if ($servicoemail == 't') {
            $emailVerificacao = $this->login->verificaemail();
            if (count($emailVerificacao) == 0) {
                $this->login->emailautomatico();
            }
        }

        $servicosms = $this->session->userdata('servicosms');
        
        if ($servicosms == 't') {
//            $verificacoes = $this->login->verificacaosmsdia();
//            if ($verificacoes[0]->total < 3 && ( date("H") == "08" ) ) {
                
                $registro_sms_id = $this->login->criandoregistrosms();

                // verificando o total de mensagens utilizadas do pacote
                $totalUtilizado = (int) $this->login->totalutilizado();
                $totalPacote = (int) $this->login->listarempresapacote();

                if ($totalUtilizado < $totalPacote) {
                    //calculando total disponivel
                    $disponivel = $totalPacote - $totalUtilizado;

                    //INSERINDO EXAMES AGENDADOS PARA O DIA SEGUINTE NA TABELA DE CONTROLE (CONFIRMACAO)
                    $examesAgendados = $this->login->examesagendados();
                    $totalInserido = $this->login->atualizandoagendadostabelasms($examesAgendados, $disponivel);

                    //calculando novo total disponivel
                    $disponivel = $disponivel - $totalInserido;

                    if ($disponivel > 0) {
                        //INSERINDO PACIENTES ATENDIDOS NO DECORRER DO DIA (AGRADECIMENTO)
                        $pacientesDia = $this->login->atendimentos();
                        $totalInserido = $this->login->atualizandoatendidostabelasms($pacientesDia, $disponivel);
                        $disponivel = $disponivel - $totalInserido;
                    }

                    /* So deve executar esse bloco uma vez ao dia */

                    $smsVerificacao = $this->login->verificasms();
                    if (count($smsVerificacao) == 0) {
                        if ($disponivel > 0) {
                            //INSERINDO ANIVERSARIANTES NA TABELA DE CONTROLE (ANIVERSARIANTE)
                            $aniversariantes = $this->login->aniversariantes();
                            $totalInserido = $this->login->atualizandoaniversariantestabelasms($aniversariantes, $disponivel);

                            //calculando novo total disponivel
                            $disponivel = $disponivel - $totalInserido;
                        }

                        if ($disponivel > 0) {
                            //INSERINDO REVISÕES NA TABELA DE CONTROLE (REVISAO)
                            $revisoes = $this->login->revisoes();
                            $totalInserido = $this->login->atualizandorevisoestabelasms($revisoes, $disponivel);
                            $disponivel = $disponivel - $totalInserido;
                        }
                    }
                    /* Fim do Bloco */

                    $this->login->atualizandoregistro($registro_sms_id);
                } 
                else {
                    //Mandar email para o administrador alertando que o pacote foi excedido
//                $config['protocol'] = 'smtp';
//                $config['smtp_host'] = 'ssl://smtp.gmail.com';
//                $config['smtp_port'] = '465';
//                $config['smtp_user'] = 'stgsaude@gmail.com';
//                $config['smtp_pass'] = 'saude123';
//                $config['validate'] = TRUE;
//                $config['mailtype'] = 'html';
//                $config['charset'] = 'utf-8';
//                $config['newline'] = "\r\n";
//                $this->load->library('email');
//                
//                $this->email->initialize($config);
//                $this->email->from($email_empresa, $remetente);
//                $this->email->to($item->cns);
//                $this->email->subject($assunto);
//                $this->email->message($mensagem);
//                $this->email->send();
                }
                // Buscando mensagens  no banco que deverao ser mandadas para o webservice
                $dados = $this->login->listarsms();

                /* ENVIANDO PARA O WEBSERVICE */
                $cliente = new SoapClient(null, array(
                    /*
                     * Certifique-se de ter criado a coluna abaixo no banco IONIC
                     * que está no mesmo servidor do webservice
                     * 
                     * ALTER TABLE sms ADD COLUMN sms_associacao_id integer;
                     *                   
                     */
                    'location' => "http://localhost/webservice/webservice/servidor.php",
                    'uri' => "http://localhost/webservice/webservice/",
                    'trace' => 1
                ));

                try {
                    $resultado = $cliente->__soapCall("recebemensagens", array(
                        "dados" => $dados
                    ));
                } catch (SoapFault $fault) {
                    die("<hr>SOAP Fault: fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
                }
//            var_dump($resultado);die;
                //Salvando o numero de controle recebido pelo WEBSERVICE no banco            
                $this->login->atualizandonumerocontrole($resultado);
//            }
        }
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

        if ($teste1 > 0 || $teste2 > 0) {
            //Pegando somente o numero da versao.
            preg_match('/[0-9].+/', $browserPC[0], $verificanavegador['versao']);

            if (($this->login->autenticar($usuario, $senha, $empresa)) &&
                    ($this->session->userdata('autenticado') == true)) {
                $valuecalculado = 0;

//                $this->verificasms();

                setcookie("TestCookie", $valuecalculado);
                redirect(base_url() . "home", "refresh");
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login002');
                $this->carregarView($data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('Navegador n&atilde;o suportado. Utilize o Firefox (Em caso de IOS. Atualize sua vers&atilde;o).');
            $this->carregarView($data);
        }
    }

    function sair() {
        $this->login->sair();

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

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
