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
class Manterstatus extends BaseController {

    function Manterstatus() {
        parent::Controller();
        $this->load->model('ambulatorio/manterstatus_model', 'manterstatus');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }


    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/manterstatus-lista', $args);

//            $this->carregarView($data);
    }


    function carregarstatus($status_id) {
        $obj_status = new manterstatus_model($status_id);
        $data['obj'] = $obj_status;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/status-form', $data);
    }


    function gravar() {
        $status_id = $this->manterstatus->gravar();
        if ($status_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Status. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Status.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/manterstatus");
    }


    function excluir($status_id) {
        $valida = $this->manterstatus->excluir($status_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir o Status';
        } else {
            $data['mensagem'] = 'Erro ao excluir o Status. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/manterstatus");
    }



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
