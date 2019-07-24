
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
class Nivel2 extends BaseController {

    function Nivel2() {
        parent::Controller();
        $this->load->model('cadastro/nivel2_model', 'nivel2');
        $this->load->model('cadastro/nivel1_model', 'nivel1');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/nivel2-lista', $args);

//            $this->carregarView($data);
    }

    function carregarnivel2($nivel2_id) {
        $obj_classe = new nivel2_model($nivel2_id);
        $data['obj'] = $obj_classe;
        $data['nivel1'] = $this->nivel1->listarnivel1();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/nivel2-form', $data);
    }

    function excluir($nivel2_id) {
        $valida = $this->nivel2->excluir($nivel2_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir o Nível';
        } else {
            $data['mensagem'] = 'Erro ao excluir o Nível. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/nivel2");
    }

    function gravar() {
        $nivel2_id = $this->nivel2->gravar();
        if ($nivel2_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Nível 2. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Nível 2.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/nivel2");
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

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */




