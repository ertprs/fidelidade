<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta parceiro é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Parceiro extends BaseController {

    function Parceiro() {
        parent::Controller();
        $this->load->model('cadastro/parceiro_model', 'parceiro');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($limite = 10) {
        $data["limite_paginacao"] = $limite;

        $this->loadView('cadastros/parceiro-lista', $data);

//            $this->carregarView($data);
    }

    function carregarparceiro($financeiro_credor_devedor_id) {
        $obj_parceiro = new parceiro_model($financeiro_credor_devedor_id);
        $data['obj'] = $obj_parceiro;
        $data['tipo'] = $this->parceiro->listartipo();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('cadastros/parceiro-form', $data);
    }

    function excluir($financeiro_credor_devedor_id) {
        $valida = $this->parceiro->excluir($financeiro_credor_devedor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Parceiro';
        } else {
            $data['mensagem'] = 'Erro ao excluir a parceiro. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/parceiro");
    }

    function gravar() {
        $exame_parceiro_id = $this->parceiro->gravar();
        if ($exame_parceiro_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Parceiro. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Parceiro.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/parceiro");
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
