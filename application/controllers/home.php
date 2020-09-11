<?php
require_once APPPATH . 'controllers/base/BaseController.php';
class Home extends BaseController {

	function Home() {
            parent::Controller();
            $this->load->library('mensagem');
            $this->load->model('cadastro/paciente_model', 'paciente');
            $this->load->library('utilitario');
 
	}
	
	function index($mensagem=null) {
            if ($mensagem != null)
            { $data['mensagem'] = $this->mensagem->getMensagem($mensagem); }
            else
            { $data['mensagem'] = null; }
             
            $this->load->view('header', $data);
            $this->load->view('home');
            $this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */