<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Empresa extends BaseController {

    function Empresa() {
        parent::Controller();
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('app_model', 'app');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/empresa-lista', $args);

//            $this->carregarView($data);
    }

    function listarpesquisaSatisfacao() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/pesquisasatisfacao-lista');
    }

    function solicitacaoagendamento() {
//        $data['guia_id'] = $this->guia->verificaodeclaracao();
//        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/solicitacaoagendamento-lista');
    }

    function carregarempresa($exame_empresa_id) {
        $obj_empresa = new empresa_model($exame_empresa_id);
        $data['obj'] = $obj_empresa;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/empresa-form', $data);
    }

    function excluir($exame_empresa_id) {
        if ($this->procedimento->excluir($exame_empresa_id)) {
            $mensagem = 'Sucesso ao excluir a Empresa';
        } else {
            $mensagem = 'Erro ao excluir a empresa. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function listarpostsblog() {
    //        $data['guia_id'] = $this->guia->verificaodeclaracao();
    //        $data['impressao'] = $this->empresa->listarconfiguracaoimpressao();
    //        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarpostsblog-lista');
    }

    function carregarpostsblog($posts_blog_id) {
        $data['posts_blog_id'] = $posts_blog_id;
        $data['post'] = $this->empresa->carregarlistarpostsblog($posts_blog_id);
        $data['planos'] = $this->empresa->listarplanos();
//        var_dump($data['impressao']); die;
        $this->loadView('ambulatorio/configurarpostsblog-form', $data);
    }

    function gravarpostsblog() {
    //        var_dump($_POST); die;
        $posts_blog_id = $_POST['posts_blog_id'];
        if ($this->empresa->gravarpostsblog($posts_blog_id)) {
            $mensagem = 'Sucesso ao gravar informativo';
        } else {
            $mensagem = 'Erro ao gravar informativo. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->enviarNotificacao('Um novo informativo foi publicado!', $_POST['plano_id']);
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarpostsblog");
    }

    function enviarNotificacao($mensagem, $plano_id){
        $resposta = $this->app->buscarHashDispositivoPaciente($plano_id);    
        $headers = array();
        // echo '<pre>';
        // var_dump($resposta); 
        // die;
        if(count($resposta) > 0){
            $hash = '';
            $hash_array = array();
            foreach ($resposta as $key => $value) {
                $hash_array[] = $value->hash;
            }
            $hash = json_encode($hash_array);
            
            $url = 'https://onesignal.com/api/v1/notifications';
            $headers[] = 'Content-Type: application/json; charset=utf-8';
            $headers[] = 'Authorization: Basic ZTVmZTU2NjEtZDU1My00NzQzLTllZTYtMzFkMjJlMmEzZWZi';
            $ch = curl_init();
            $body = '{
                "app_id": "13964cbb-2421-4e58-b040-0ad8f2b2e9fa",
                "include_player_ids": '. $hash .',
                "data": {"foo": "bar"},
                "contents": {"en": "'. "$mensagem" .'"}
            }';
            // var_dump($body);
            // die;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);
            // var_dump($result); die;
            curl_close($ch);
            
            return true;
        }else{
            return false;
        }

    }


    function excluirpostsblog($posts_blog_id) {
        //        var_dump($_POST); die;
        if ($this->empresa->excluirpostsblog($posts_blog_id)) {
            $mensagem = 'Sucesso ao excluir post do blog';
        } else {
            $mensagem = 'Erro ao gravar post do blog. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/listarpostsblog");
    }

    function confirmarsolicitacaoagendamento($solicitacao_id) {
//        var_dump($_POST); die;
        if ($this->empresa->confirmarsolicitacaoagendamento($solicitacao_id)) {
            $mensagem = 'Sucesso ao confirmar agendamento';
        } else {
            $mensagem = 'Erro ao gravar post do blog. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/solicitacaoagendamento");
    }

    function excluirsolicitacaoagendamento($solicitacao_id) {
//        var_dump($_POST); die;
        if ($this->empresa->excluirsolicitacaoagendamento($solicitacao_id)) {
            $mensagem = 'Sucesso ao excluir agendamento';
        } else {
            $mensagem = 'Erro ao gravar post do blog. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/solicitacaoagendamento");
    }

    function gravar() {
        $empresa_id = $this->empresa->gravar();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Empresa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);

        if (@$_POST['empresacadastro'] == 'sim') {
            
            redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
        } else {
            redirect(base_url() . "ambulatorio/empresa");
        }
    }

    function ativar($exame_empresa_id) {
        $this->empresa->ativar($exame_empresa_id);
        $data['mensagem'] = 'Sucesso ao ativar a Empresa.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    function empresacadastrolista($args = array()) {
        $this->loadView('ambulatorio/empresacadastro-lista', $args);
    }

    function carregarempresacadastro($empresa_id = NULL) {

        $data['empresa'] = $this->empresa->listardadosempresacadastro($empresa_id);
         
        $this->loadView('ambulatorio/empresacadastro-form', $data);
    }
    
    function carregarlogoempresa($empresa_id){
        $this->load->helper('directory');
         
        if (!is_dir("./upload/empresalogo")) {
            mkdir("./upload/empresalogo");
            $destino = "./upload/empresalogo";
            chmod($destino, 0777);
        }
        
        if (!is_dir("./upload/empresalogo/$empresa_id")) {
            mkdir("./upload/empresalogo/$empresa_id");
            $destino = "./upload/empresalogo/$empresa_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("./upload/empresalogo/$empresa_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['empresa_id'] = $empresa_id;
//        $this->loadView('ambulatorio/importacao-imagempaciente', $data);
        
        
        $this->loadView('ambulatorio/empresacadastrologo-form',$data);
        
    }

    function carregarlogoempresacheckout($empresa_id){
        $this->load->helper('directory');
         
        if (!is_dir("./upload/empresalogocheckout")) {
            mkdir("./upload/empresalogocheckout");
            $destino = "./upload/empresalogocheckout";
            chmod($destino, 0777);
        }
        

        $data['arquivo_pasta'] = directory_map("./upload/empresalogocheckout/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['empresa_id'] = $empresa_id;

        $this->loadView('ambulatorio/empresacadastrologocheckout-form',$data);
        
    }
    function gravarempresacadastro() {
        $empresa_id = $this->empresa->gravarempresacadastro();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Empresa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Empresa.';
            $this->guia->criarcredordevedorempresa($empresa_id);
        }

        // if($this->session->userdata('perfil_id') == 5){
        //     $this->session->set_flashdata('message', $data['mensagem']); 
        //     redirect(base_url() . "ambulatorio/empresa/empresacadastrolista");
        // }
            $this->session->set_flashdata('message', $data['mensagem']); 
            redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id"); 
  
    }

    
    
    function configuraremail($empresa_id) {
        $data['empresa_id'] = $empresa_id;
        $data['mensagem'] = $this->empresa->listarinformacaoemail($empresa_id);
        $this->loadView('ambulatorio/empresaemail-form', $data);
    }
      function gravarconfiguracaoemail() {
        $empresa_id = $this->empresa->gravarconfiguracaoemail();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao salvar configurações do serviço de Email.';
        } else {
            $data['mensagem'] = 'Configuração de Email efetuada com sucesso.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
