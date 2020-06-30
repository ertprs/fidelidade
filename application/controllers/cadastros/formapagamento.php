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
class Formapagamento extends BaseController {

    function Formapagamento() {
        parent::Controller();
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/formapagamento-lista', $args);
//            $this->carregarView($data);
    }

    function listarformarendimento($args = array()) {

        $this->loadView('cadastros/formarendimento-lista', $args);

//            $this->carregarView($data);
    }

    function grupospagamento($args = array()) {

        $this->loadView('cadastros/grupopagamento-lista', $args);

//            $this->carregarView($data);
    }

    function carregargrupospagamento() {
        $data['conta'] = $this->forma->listarforma();
        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $this->loadView('cadastros/grupopagamento-form', $data);
    }

    function carregarformapagamento($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamento-form', $data);
    }

    function carregarformarendimento($formarendimento_id) {
        $data['conta'] = $this->forma->listarforma();
        $data['lista'] = $this->formapagamento->carregarformarendimento($formarendimento_id);
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formarendimento-form', $data);
    }
    
    function carregarformapagamentocarencia($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamentocarencia-form', $data);
    }

    function carregarformapagamentocomissao($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        $data['forma_rendimento'] = $this->formapagamento->listarformaRendimentoPaciente();
        $data['forma_comissao'] = $this->formapagamento->listarformaRendimentoPlanoComissao($formapagamento_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamentocomissao-form', $data);
    }

    function formapagamentoparcelas($formapagamento_id) {
        $data['formapagamento_id'] = $formapagamento_id;
        $data['formapagamento'] = $this->formapagamento->buscarforma($formapagamento_id);
        $data['faixas_parcelas'] = $this->formapagamento->buscafaixasparcelas($formapagamento_id);
        
        if(count($data['faixas_parcelas']) > 0){
            
            $ind_ultima_parcela = count($data['faixas_parcelas']) - 1;
            $data['ultima_parcela'] = (int) $data['faixas_parcelas'][$ind_ultima_parcela]->parcelas_fim;
            
            foreach ($data['faixas_parcelas'] as $item) {
                $item->parcelas_fim = (int)$item->parcelas_fim;
                if( $data['ultima_parcela'] >= $item->parcelas_fim){
                    continue;
                }
                else {
                    $data['ultima_parcela'] = $item->parcelas_fim;
                }
            }
        } else {
            $data['ultima_parcela'] = 0;
        }
        $this->loadView('cadastros/formapagamentoparcelas-form', $data);
    }
    
    
    function gravarparcelas() {
        $formapagamento_id = $_POST['formapagamento_id'];
        $_POST['taxa'] = str_replace(",", ".", $_POST['taxa']);
        $this->formapagamento->gravarparcelas();
        redirect(base_url() . "cadastros/formapagamento/formapagamentoparcelas/$formapagamento_id");
    }

    function excluir($formapagamento_id) {
        $valida = $this->formapagamento->excluir($formapagamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }
    
    function excluirFormaRendimento($formarendimento_id) {
        $valida = $this->formapagamento->excluirFormaRendimento($formarendimento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/listarformarendimento");
    }
    
    function excluirFormaRendimentoComissao($forma_rendimento_comissao_id, $plano_id) {
        // var_dump($forma_rendimento_comissao_id); die;
        $valida = $this->formapagamento->excluirFormaRendimentoComissao($forma_rendimento_comissao_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/carregarformapagamentocomissao/$plano_id");
    }
    
    function excluirparcela($parcela_id, $formapagamento_id) {
        $this->formapagamento->excluirparcela($parcela_id);
        $this->formapagamentoparcelas($formapagamento_id);
    }

    function anexararquivos($plano_id) {

        $this->load->helper('directory');

        if (!is_dir("./upload/planos")) {
            mkdir("./upload/planos");
            $destino = "./upload/planos";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/planos/$plano_id")) {
            mkdir("./upload/planos/$plano_id");
            $destino = "./upload/planos/$plano_id";
            chmod($destino, 0777);
        }

        $data['arquivo_pasta'] = directory_map("./upload/planos/$plano_id");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['plano_id'] = $plano_id;
        $this->loadView('cadastros/enviararquivosplano', $data);
    }

    function importararquivos($plano_id) {
        // var_dump($_FILES['userfile']); die;

        // $this->load->helper('directory');
        // $plano_id = $_POST['plano_id'];
//        $_FILES['userfile']['name'] = $operador_id . ".jpg";
//        $_FILES['userfile']['type'] = "image/png";
    //    var_dump($_FILES['arquivos']); die;
        // $_FILES['userfile']['name'] = $_FILES['arquivos']['name'];
        // $_FILES['userfile']['type'] = $_FILES['arquivos']['type'];
        // $_FILES['userfile']['tmp_name'] = $_FILES['arquivos']['tmp_name'];
        // $_FILES['userfile']['error'] = $_FILES['arquivos']['error'];
        // $_FILES['userfile']['size'] = $_FILES['arquivos']['size'];

        if (!is_dir("./upload/planos")) {
            mkdir("./upload/planos");
            $destino = "./upload/planos";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/planos/$plano_id")) {
            mkdir("./upload/planos/$plano_id");
            $destino = "./upload/planos/$plano_id";
            chmod($destino, 0777);
        }

        // if (!$arquivo_existe) {
//             var_dump($arquivo_existe); die;
            //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/planos/" . $plano_id . "/";
        $config['allowed_types'] = 'gif|jpg|BMP|bmp|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar|xml|txt';
        $config['max_size'] = '0';
        $config['overwrite'] = false;
        $config['encrypt_name'] = false;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['plano_id'] = $plano_id;


        // var_dump($error);
        // die;
        // }

        redirect(base_url() . "cadastros/formapagamento/anexararquivos/$plano_id");
    }


    function excluirimagem($plano_id, $nome) {

        // if (!is_dir("./uploadopm/planos/$plano_id")) {
        //     mkdir("./uploadopm/planos");
        //     mkdir("./uploadopm/planos/$plano_id");
        //     $destino = "./uploadopm/planos/$plano_id";
        //     chmod($destino, 0777);
        // }

        $origem = "./upload/planos/$plano_id/$nome";
        // $destino = "./uploadopm/paciente/$plano_id/$nome";
        // copy($origem, $destino);
        unlink($origem);

        redirect(base_url() . "cadastros/formapagamento/anexararquivos/$plano_id");

//        $this->anexarimagem($paciente_id);
    }

    function excluirgrupo($grupo_id) {
        $valida = $this->formapagamento->excluirgrupo($grupo_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupospagamento");
    }

    function excluirformapagamentodogrupo($grupo_id, $grupo_formapagamento_id) {
        $valida = $this->formapagamento->excluirformapagamentodogrupo($grupo_formapagamento_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Forma';
        } else {
            $data['mensagem'] = 'Erro ao excluir a formapagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$grupo_id");
    }

    function gravar() {
        $exame_formapagamento_id = $this->formapagamento->gravar();
        if ($exame_formapagamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }

    function gravarformarendimento() {
        $exame_formarendimento_id = $this->formapagamento->gravarformarendimento();
        if ($exame_formarendimento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/listarformarendimento");
    }
    
    function gravarFormaRendimentoComissao($plano_id) {
        $exame_formapagamento_id = $this->formapagamento->gravarFormaRendimentoComissao();
        if ($exame_formapagamento_id == -11) {
            $data['mensagem'] = 'O campo "Até:" deve ser igual ou superior ao "De:" ao cadastrar uma comissão.';
        } elseif ($exame_formapagamento_id == -12) {
            $data['mensagem'] = 'O campo "Até:" deve ser superior ao "Até:" de uma comissão já cadastrada ou inferior ao "De:".';
        } elseif ($exame_formapagamento_id == -10) {
            $data['mensagem'] = 'O campo "De:" deve ser superior ao "Até:" de uma comissão já cadastrada.';
        } elseif ($exame_formapagamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/carregarformapagamentocomissao/$plano_id");
    }
    function gravarcarencia() {
        $exame_formapagamento_id = $this->formapagamento->gravarcarencia();
        if ($exame_formapagamento_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Forma. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Forma.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento");
    }

    function grupoadicionar($financeiro_grupo_id) {
        $data['financeiro_grupo'] = $this->formapagamento->buscargrupo($financeiro_grupo_id);
        $data['forma_pagamento'] = $this->formapagamento->listarforma();
        $data['relatorio'] = $this->formapagamento->listarformapagamentonogrupo($financeiro_grupo_id);
        $this->loadView('cadastros/grupopagamento-adicionar', $data);
    }

    function gravargrupoadicionar() {
        $financeiro_grupo_id = $_POST['grupo_id'];
        if ($this->formapagamento->gravargrupoadicionar()) {
            $data['mensagem'] = 'Forma de Pagamento adicionada com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao adicionar.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$financeiro_grupo_id");
    }


    function gravargruponome() {
        $financeiro_grupo_id = $this->formapagamento->gravargruponome();
        if ($financeiro_grupo_id != false) {
            $data['mensagem'] = 'Grupo criado com sucesso.';
        } else {
            $data['mensagem'] = 'Erro ao criar grupo.';
        }
//        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/formapagamento/grupoadicionar/$financeiro_grupo_id");
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
    
    function cadastrarprocedimentoplano($formapagamento_id){
      $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        $data['forma_rendimento'] = $this->formapagamento->listarformaRendimentoPaciente();
        $data['forma_comissao'] = $this->formapagamento->listarformaRendimentoPlanoComissao($formapagamento_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $data['procedimento'] = $this->procedimentoplano->listarprocedimentosplano();
        @$data['formapagamento_id'] = @$formapagamento_id;
        $data['procedimentopano'] =$this->formapagamento->listarprocedimentosdoplano($formapagamento_id);
        $this->loadView('cadastros/cadastrarprocedimentoplano-form', $data);   
        
    }

    function gravarprocedimentoplano(){
        $this->formapagamento->gravarprocedimentoplano();
           
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }
    
    
    function excluirprocedimentoplano($procedimentos_plano_id){
         $this->formapagamento->excluirprocedimentoplano($procedimentos_plano_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
        
    }
    
    function carregarformapagamentocarenciaespecifica($formapagamento_id) {
        $obj_formapagamento = new formapagamento_model($formapagamento_id);
        $data['obj'] = $obj_formapagamento;
        $data['conta'] = $this->forma->listarforma();
        $data['credor_devedor'] = $this->formapagamento->listarcredordevedor();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/formapagamentocarenciaespecifica-form', $data);
    }
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
