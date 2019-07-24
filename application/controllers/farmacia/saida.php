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
class Saida extends BaseController {

    function Saida() {
        parent::Controller();
        $this->load->model('farmacia/saida_model', 'saida');
        $this->load->model('farmacia/tipo_model', 'tipo');
        $this->load->model('farmacia/produto_model', 'produto');
         $this->load->model('farmacia/armazem_model', 'armazem');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarsaida($farmacia_saida_id) {

        $data['farmacia_saida_id'] = $farmacia_saida_id;
        $data['nome'] = $this->saida->saidanome($farmacia_saida_id);

        $data['produto'] = $this->saida->listarprodutos($farmacia_saida_id);
        $data['contador'] = $this->saida->contador($farmacia_saida_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->saida->listarsaidas($farmacia_saida_id);
        }
        $this->loadView('farmacia/saidaitens-form', $data);
    }

    function pesquisar($args = array()) {

        $this->loadView('farmacia/saida-lista', $args);

//            $this->carregarView($data);
    }

    function saidapaciente($internacao_id) {
        $data['internacao_id'] = $internacao_id;
        $data['produtossaida'] = $this->saida->listarprodutositemsaidafarmacia($internacao_id);
//        echo '<pre>';
//        var_dump($data['produtos']); die;
        $data['lista'] = $this->saida->listasaidapacienteprescricao($internacao_id);

        $this->loadView('farmacia/saida-pacientelista', $data);

//            $this->carregarView($data);
    }

    function excluirsaida($farmacia_saida_id, $internacao_id, $internacao_prescricao_id) {
        $this->saida->excluirsaida($farmacia_saida_id, $internacao_prescricao_id);

        redirect(base_url() . "farmacia/saida/saidapaciente/$internacao_id");
    }

    function gravarsaidapaciente($internacao_id) {

//        var_dump($_POST); die;
        
//        $contador = $this->saida->gravarsaidaitenspaciente($internacao_id);
        $return = $this->saida->gravarsaidaitenspaciente($internacao_id);
//        $this->loadView('farmacia/saida-pacientelista', $data);
//        if($return != false){
//           
//        }
//            $this->carregarView($data);
        redirect(base_url() . "farmacia/saida/saidapaciente/$internacao_id");
    }

    
    
    
    
    
    function saida_produto($args = array())
    {
         $this->loadView('farmacia/saidaproduto-lista', $args);
    }
    
    
    
     function carregarsaidaproduto($farmacia_entrada_id) {
//        $obj_entrada = new entrada_model($farmacia_entrada_id);
//        $data['obj'] = $obj_entrada;
 
        
        //$this->carregarView($data, 'giah/servidor-form');
         $data['produtos']=$this->produto->listarprodutos_saida();
         
         $data['tipo_saida']=$this->tipo->tipo_saida();
         
         
         
        $this->loadView('farmacia/saidaproduto-form',$data);
    }
    
    
    
    function gravarsaida_produto(){
        
      $exame_saida_id= $this->saida->gravarsaida_produto();
         if ($exame_saida_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Saída. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Saída.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
          redirect(base_url() . "farmacia/saida/saida_produto");
        
        
        
    }
    
    
    
    
    
     function carregarsaida_produto($farmacia_saida_produto_id=NULL) {
//        $obj_entrada = new entrada_model($farmacia_entrada_id);
//        $data['obj'] = $obj_entrada;
//        $data['sub'] = $this->entrada->listararmazem();
//        $data['unidade'] = $this->entrada->listarunidade();
//        
        
        //$this->carregarView($data, 'giah/servidor-form');
         
        $data['armazem']=$this->armazem->listararmazem();
        $data['tipo_saida']=$this->tipo->tipo_saida();
        $data['produtos']=$this->produto->listarprodutos_saida();
        $data['dados'] = $this->saida->carregarentrada_produto($farmacia_saida_produto_id);
        $this->loadView('farmacia/saidaproduto-form',$data);
    }
    
    
    
    function excluirsaida_produto($farmacia_saida_produto_id=NULL){
        
      $exame_saida_id =  $this->saida->excluirsaida_produto($farmacia_saida_produto_id);
        if ($exame_saida_id == "-1") {
            $data['mensagem'] = 'Erro ao Excluir a Saída. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao Excluir a Entrada.';
        }
           $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "farmacia/saida/saida_produto");
        
    }
    
 
    
      function pesquisarsaida_produto($args = array()) {

        $this->loadView('farmacia/saidaproduto-lista', $args);
 
 
    }

    
    
  function anexarimagemsaida($farmacia_saida_produto_id) {

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/saidadenota/$farmacia_saida_produto_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['farmacia_saida_produto_id'] = $farmacia_saida_produto_id;
        $this->loadView('farmacia/importacao-imagemsaida', $data);
    }

    function importarimagemsaida() {
        $farmacia_saida_produto_id = @$_POST['farmacia_saida_produto_id'];
//        $data = $_FILES['userfile'];
//        var_dump($data);
//        die;
        if (!is_dir("./upload/saidadenota/$farmacia_saida_produto_id")) {
            mkdir("./upload/saidadenota/$farmacia_saida_produto_id");
            $destino = "./upload/saidadenota/$farmacia_saida_produto_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/saidadenota/" . $farmacia_saida_produto_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['farmacia_saida_produto_id'] = $farmacia_saida_produto_id;
        $this->anexarimagemsaida($farmacia_saida_produto_id);
    }
    
    
    
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
