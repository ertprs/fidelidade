<?php
require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");
require_once('./gerencianet/vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class Inicio extends BaseController {

	function Inicio() {
            parent::Controller();

            $this->load->model('checkout/inicio_model', 'inicio');

            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('pagination');
            $this->load->library('validation');
 
	}
	
	function index() {
                $this->pesquisar();
            }

        function pesquisar(){
                $data['planos'] = $this->inicio->listartodosplanos();

                // echo '<pre>';
                // print_r($data['planos']);

                $this->load->View('checkout/checkoutinicial', $data);
        }

        function titular(){
                $data['planos'] = $this->inicio->listartodosplanos($_POST['plano_id']);
                
                $this->load->View('checkout/checkouttitular', $data);
        }

        function endereco(){
                // echo '<pre>';
                // print_r($_POST);
                // die;
                $data['planos'] = $this->inicio->listartodosplanos($_POST['plano_id']);
                
                $this->load->View('checkout/checkoutendereco', $data);  
        }
}
