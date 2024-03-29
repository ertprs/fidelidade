<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta entrada é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Nota extends BaseController {

    function Nota() {
        parent::Controller();
        $this->load->model('estoque/entrada_model', 'entrada');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('estoque/nota_model', 'nota');
        $this->load->model('estoque/entrada_nota_model', 'entrada_nota');
        $this->load->model('estoque/cliente_model', 'cliente');
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

        $this->loadView('estoque/nota-lista', $args);

//            $this->carregarView($data);
    }

    function carregarnota($estoque_nota_id) {
        
        $obj_nota = new nota_model($estoque_nota_id);
        $data['obj'] = $obj_nota;
        $data['sub'] = $this->nota->listararmazem();

        $this->loadView('estoque/nota-form', $data);
    }
    
    function alimentarnota($estoque_nota_id) {        
        
        $data['nota'] = $this->nota->listarnota($estoque_nota_id);
        $nota_fiscal = $data['nota'][0]->nota_fiscal;
        $data['notafiscal'] = $this->nota->listarnotafiscal($nota_fiscal);
        
        $this->loadView('estoque/alimentarnota-form', $data);
    }

//    function carregarfracionamento($estoque_entrada_id) {
//        // $data['obj'] = $obj_entrada;
//        $data['sub'] = $this->entrada->listararmazem();
//        $data['produtos'] = $this->entrada->listarprodutosfracionamento();
//        //$this->carregarView($data, 'giah/servidor-form');
//        $this->loadView('estoque/fracionamento-form', $data);
//    }
//
    function relatorionotas() {
        $data['armazem'] = $this->entrada->listararmazem();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('estoque/relatorionotas', $data);
    }
//
//    function gerarelatoriosaldoarmazem() {
//        $armazem = $_POST['armazem'];
//        $estoque_fornecedor_id = $_POST['txtfornecedor'];
//        $estoque_produto_id = $_POST['txtproduto'];
//        if ($armazem == 0) {
//            $data['armazem'] = 0;
//        } else {
//            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
//        }
//        if ($estoque_fornecedor_id == '') {
//            $data['fornecedor'] = 0;
//        } else {
//            $data['fornecedor'] = $this->entrada->listarfornecedorcada($estoque_fornecedor_id);
//        }
//        if ($estoque_produto_id == '') {
//            $data['produto'] = 0;
//        } else {
//            $data['produto'] = $this->entrada->listarprodutocada($estoque_produto_id);
//        }
//
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatoriosaldoarmazemcontador();
//        $data['relatorio'] = $this->entrada->relatoriosaldoarmazem();
//        $this->load->View('estoque/impressaorelatoriosaldoarmazem', $data);
//    }
//
//    function relatoriosaldo() {
//        $data['armazem'] = $this->entrada->listararmazem();
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatoriosaldo', $data);
//    }
//    
//    function relatoriosaldoproduto() {
//        $data['armazem'] = $this->entrada->listararmazem();
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatoriosaldoprodutos', $data);
//    }
//
//    function gerarelatoriosaldo() {
//        $armazem = $_POST['armazem'];
//        $estoque_fornecedor_id = $_POST['txtfornecedor'];
//        $estoque_produto_id = $_POST['txtproduto'];
//        if ($armazem == 0) {
//            $data['armazem'] = 0;
//        } else {
//            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
//        }
//        if ($estoque_fornecedor_id == '') {
//            $data['fornecedor'] = 0;
//        } else {
//            $data['fornecedor'] = $this->entrada->listarfornecedorcada($estoque_fornecedor_id);
//        }
//        if ($estoque_produto_id == '') {
//            $data['produto'] = 0;
//        } else {
//            $data['produto'] = $this->entrada->listarprodutocada($estoque_produto_id);
//        }
//
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatoriosaldocontador();
//        $data['relatorio'] = $this->entrada->relatoriosaldo();
//        $this->load->View('estoque/impressaorelatoriosaldo', $data);
//    }
//    
    function gerarelatorionotas() {
        $armazem = $_POST['armazem'];
        $estoque_fornecedor_id = $_POST['txtfornecedor'];
        $estoque_nota_id = $_POST['txtnota'];
//        var_dump($_POST);die;
        if ($armazem == 0) {
            $data['armazem'] = 0;
        } else {
            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
        }
        if ($estoque_fornecedor_id == '') {
            $data['fornecedor'] = 0;
        } else {
            $data['fornecedor'] = $this->entrada->listarfornecedorcada($estoque_fornecedor_id);
        }
        if ($estoque_nota_id == '') {
            $data['nota'] = 0;
        } else {
            $data['nota'] = $this->nota->listarnotacada($estoque_nota_id);
        }

        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->nota->relatorionotas();
        $this->load->View('estoque/impressaorelatorionotas', $data);
    }

//    function relatoriominimo() {
//        $data['armazem'] = $this->entrada->listararmazem();
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatoriominimo', $data);
//    }
//
//    function gerarelatoriominimo() {
//        $armazem = $_POST['armazem'];
//        if ($armazem == 0) {
//            $data['armazem'] = 0;
//        } else {
//            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
//        }
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatoriominimoarmazemcontador();
//        $data['relatorio'] = $this->entrada->relatoriominimoarmazem();
//        $this->load->View('estoque/impressaorelatoriominimo', $data);
//    }
//
//    function relatorioprodutos() {
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatorioprodutos', $data);
//    }
//
//    function gerarelatorioprodutos() {
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatorioprodutocontador();
//        $data['relatorio'] = $this->entrada->relatorioproduto();
//        $this->load->View('estoque/impressaorelatorioprodutos', $data);
//    }
//
//    function relatoriofornecedores() {
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatoriofornecedores', $data);
//    }
//
//    function gerarelatoriofornecedores() {
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatoriofornecedorescontador();
//        $data['relatorio'] = $this->entrada->relatoriofornecedores();
//        $this->load->View('estoque/impressaorelatoriofornecedores', $data);
//    }
//
//    function relatorioentradaarmazem() {
//        $data['armazem'] = $this->entrada->listararmazem();
//        $data['empresa'] = $this->guia->listarempresas();
//        $this->loadView('estoque/relatorioentradaarmazem', $data);
//    }
//
//    function gerarelatorioentradaarmazem() {
//        $armazem = $_POST['armazem'];
//        $estoque_fornecedor_id = $_POST['txtfornecedor'];
//        $estoque_produto_id = $_POST['txtproduto'];
//        $data['txtdata_inicio'] = date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_inicio']) ) );
//        $data['txtdata_fim'] = date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_fim']) ) );
//        if ($armazem == 0) {
//            $data['armazem'] = 0;
//        } else {
//            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
//        }
//        if ($estoque_fornecedor_id == '') {
//            $data['fornecedor'] = 0;
//        } else {
//            $data['fornecedor'] = $this->entrada->listarfornecedorcada($estoque_fornecedor_id);
//        }
//        if ($estoque_produto_id == '') {
//            $data['produto'] = 0;
//        } else {
//            $data['produto'] = $this->entrada->listarprodutocada($estoque_produto_id);
//        }
//
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatorioentradaarmazemcontador();
//        $data['relatorio'] = $this->entrada->relatorioentradaarmazem();
//        $this->load->View('estoque/impressaorelatorioentradaarmazem', $data);
//    }
//
//    function relatoriosaidaarmazem() {
//        $data['armazem'] = $this->entrada->listararmazem();
//        $data['empresa'] = $this->guia->listarempresas();
//        $data['cliente'] = $this->cliente->listarclientes();
//        $this->loadView('estoque/relatoriosaidaarmazem', $data);
//    }
//
//    function gerarelatoriosaidaarmazem() {
//        $armazem = $_POST['armazem'];
//        $data['txtdata_inicio'] = date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_inicio']) ) );
//        $data['txtdata_fim'] = date("Y-m-d", strtotime ( str_replace('/','-', $_POST['txtdata_fim']) ) );
//        $estoque_fornecedor_id = $_POST['txtfornecedor'];
//        $estoque_produto_id = $_POST['txtproduto'];
//        if ($armazem == 0) {
//            $data['armazem'] = 0;
//        } else {
//            $data['armazem'] = $this->entrada->listararmazemcada($armazem);
//        }
//        if ($estoque_fornecedor_id == '') {
//            $data['fornecedor'] = 0;
//        } else {
//            $data['fornecedor'] = $this->entrada->listarfornecedorcada($estoque_fornecedor_id);
//        }
//        if ($estoque_produto_id == '') {
//            $data['produto'] = 0;
//        } else {
//            $data['produto'] = $this->entrada->listarprodutocada($estoque_produto_id);
//        }
//
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
//        $data['contador'] = $this->entrada->relatoriosaidaarmazemcontador();
//        $data['relatorio'] = $this->entrada->relatoriosaidaarmazem();
//        $data['relatorioconsolidado'] = $this->entrada->relatoriosaidaarmazemconsolidado();
//        $this->load->View('estoque/impressaorelatoriosaidaarmazem', $data);
//    }

    function excluir($estoque_nota_id, $nota_fiscal) {
        $valida = $this->nota->excluir($estoque_nota_id, $nota_fiscal);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Nota';
        } else {
            $data['mensagem'] = 'Erro ao excluir a Nota. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/nota");
    }

    function gravar() {
        $estoque_nota_id = $this->nota->gravar();
        if ($estoque_nota_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Nota. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Nota.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/nota/alimentarnota/$estoque_nota_id");
    }
    
    function finalizarnota($estoque_nota_id, $nota_fiscal) {
        
//        var_dump($estoque_nota_id);die;
        $retorno = $this->nota->finalizarnota($nota_fiscal, $estoque_nota_id);
        if ($retorno == "-1") {
            $data['mensagem'] = 'Erro ao finalizar a Nota. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao finalizar a Nota.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/nota/notaspagar/$estoque_nota_id/$nota_fiscal");
    }
    
    function notaspagar($estoque_nota_id, $nota_fiscal) {
//        $obj_contaspagar = new contaspagar_model($financeiro_contaspagar_id);
//        $data['obj'] = $obj_contaspagar;
        $data['conta'] = $this->forma->listarformaempresa();
        $data['tipo'] = $this->tipo->listartipo();
        $data['classe'] = $this->classe->listarclasse();
        $data['empresas'] = $this->exame->listarempresas();
        $data['estoque_nota_id'] = $estoque_nota_id;
        $data['nota_fiscal'] = $nota_fiscal;
        $this->loadView('estoque/notaspagar-form', $data);
    }
//
//    function gravarfracionamento() {
//        if($_POST['quantidade'] > 0 || $_POST['quantidade_entrada'] > 0){
//            $exame_entrada_id = $this->entrada->gravarfracionamento();
//            if ($exame_entrada_id == "-1") {
//                $data['mensagem'] = 'Erro ao gravar a Entrada. Opera&ccedil;&atilde;o cancelada.';
//            } else {
//                $data['mensagem'] = 'Sucesso ao gravar a Entrada.';
//            }
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "estoque/entrada");  
//        }else{
//            if($_POST['quantidade'] > 0){
//                $data['mensagem'] = 'A quantidade a ser fracionada deve ser maior que zero';
//            }else{
//                $data['mensagem'] = 'A quantidade de entrada deve ser maior que zero';
//            }
//            
//
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "estoque/entrada/carregarfracionamento/0");  
//        }
//        
//    }
//
//    private function carregarView($data = null, $view = null) {
//        if (!isset($data)) {
//            $data['mensagem'] = '';
//        }
//
//        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
//            $this->load->view('header', $data);
//            if ($view != null) {
//                $this->load->view($view, $data);
//            } else {
//                $this->load->view('giah/servidor-lista', $data);
//            }
//        } else {
//            $data['mensagem'] = $this->mensagem->getMensagem('login005');
//            $this->load->view('header', $data);
//            $this->load->view('home');
//        }
//        $this->load->view('footer');
//    }
// 
//    function anexarimagementrada($estoque_entrada_id) {
//
//        $this->load->helper('directory');
//        $data['arquivo_pasta'] = directory_map("./upload/entradadenota/$estoque_entrada_id/");
////        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
//        if ($data['arquivo_pasta'] != false) {
//            sort($data['arquivo_pasta']);
//        }
//        $data['estoque_entrada_id'] = $estoque_entrada_id;
//        $this->loadView('estoque/importacao-imagementrada', $data);
//    }
//
//    function importarimagementrada() {
//        $estoque_entrada_id = $_POST['paciente_id'];
////        $data = $_FILES['userfile'];
////        var_dump($data);
////        die;
//        if (!is_dir("./upload/entradadenota/$estoque_entrada_id")) {
//            mkdir("./upload/entradadenota/$estoque_entrada_id");
//            $destino = "./upload/entradadenota/$estoque_entrada_id";
//            chmod($destino, 0777);
//        }
//
////        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
//        $config['upload_path'] = "./upload/entradadenota/" . $estoque_entrada_id . "/";
//        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
//        $config['max_size'] = '0';
//        $config['overwrite'] = FALSE;
//        $config['encrypt_name'] = FALSE;
//        $this->load->library('upload', $config);
//
//        if (!$this->upload->do_upload()) {
//            $error = array('error' => $this->upload->display_errors());
//        } else {
//            $error = null;
//            $data = array('upload_data' => $this->upload->data());
//        }
//        $data['estoque_entrada_id'] = $estoque_entrada_id;
//        $this->anexarimagementrada($estoque_entrada_id);
//    }
//    
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
