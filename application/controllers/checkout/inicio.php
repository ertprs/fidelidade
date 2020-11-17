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

                $this->load->View('checkout/checkoutinicial', $data);
        }

        function titular(){
                if(isset($_POST['guardarsessao'])){

                        $p = array(
                                'plano_id' => $_POST['plano_id'],
                                'forma_mes' => $_POST['forma_mes']
                            );
                        
                        $this->session->set_userdata($p);

                }

                $data['plano_id'] = $this->session->userdata('plano_id');
                $data['forma_mes'] = $this->session->userdata('forma_mes');

                $data['cpf'] = $this->session->userdata('cpf_titular');
                $data['nome'] = $this->session->userdata('nome_titular');
                $data['email'] = $this->session->userdata('email_titular');
                $data['celular'] = $this->session->userdata('celular_titular');
                $data['nascimento'] = $this->session->userdata('nascimento_titular');
                $data['sexo'] = $this->session->userdata('sexo_titular');


                $data['planos'] = $this->inicio->listartodosplanos($data['plano_id']);
                $this->load->View('checkout/checkouttitular', $data);
        }

        function endereco(){

                if(isset($_POST['guardarsessaotitular'])){

                        $p = array(
                                'cpf_titular' => $_POST['cpf'],
                                'nome_titular' => $_POST['nome'],
                                'email_titular' => $_POST['email'],
                                'celular_titular' => $_POST['celular'],
                                'nascimento_titular' => $_POST['nascimento'],
                                'sexo_titular' => $_POST['sexo']
                            );
                        
                        $this->session->set_userdata($p);

                }

                $data['plano_id'] = $this->session->userdata('plano_id');
                $data['forma_mes'] = $this->session->userdata('forma_mes');

                $data['cep'] = $this->session->userdata('cep_titular');
                $data['logradouro'] = $this->session->userdata('logradouro_titular');
                $data['numero'] = $this->session->userdata('numero_titular');
                $data['complemento'] = $this->session->userdata('complemento_titular');
                $data['bairro'] = $this->session->userdata('bairro_titular');
                $data['cidade'] = $this->session->userdata('cidade_titular');
                $data['estado'] = $this->session->userdata('estado_titular');

                $data['planos'] = $this->inicio->listartodosplanos($data['plano_id']);
                
                $this->load->View('checkout/checkoutendereco', $data);  
        }

        function pagamento(){

                if(isset($_POST['guardarsessaoendereco'])){

                        $p = array(
                                'cep_titular' => $_POST['cep'],
                                'logradouro_titular' => $_POST['logradouro'],
                                'numero_titular' => $_POST['numero'],
                                'complemento_titular' => $_POST['complemento'],
                                'bairro_titular' => $_POST['bairro'],
                                'cidade_titular' => $_POST['cidade'],
                                'estado_titular' => $_POST['estado']
                            );
                        
                        $this->session->set_userdata($p);

                }

                $data['plano_id'] = $this->session->userdata('plano_id');
                $data['forma_mes'] = $this->session->userdata('forma_mes');

                $data['planos'] = $this->inicio->listartodosplanos($data['plano_id']);
                
                $this->load->View('checkout/checkoutpagamento', $data);  
        }

        function finalizar(){
                $paciente_id = $this->inicio->cadastrarpaciente();

                $contrato = $this->inicio->completarcontrato($paciente_id);

                if($contrato == -1){
                        // Erro Dados apagados
                }else{
                        $this->inicio->auditoriacadastro($paciente_id, 'TITULAR CADASTRO PROPRIO');
                        $this->gravarcartaoclienteiugu($paciente_id, $contrato);

                        $this->session->unset_userdata('cpf_titular');
                        $this->session->unset_userdata('nome_titular');
                        $this->session->unset_userdata('email_titular');
                        $this->session->unset_userdata('celular_titular');
                        $this->session->unset_userdata('nascimento_titular');
                        $this->session->unset_userdata('sexo_titular');
                        $this->session->unset_userdata('cep_titular');
                        $this->session->unset_userdata('logradouro_titular');
                        $this->session->unset_userdata('numero_titular');
                        $this->session->unset_userdata('complemento_titular');
                        $this->session->unset_userdata('bairro_titular');
                        $this->session->unset_userdata('cidade_titular');
                        $this->session->unset_userdata('estado_titular');
                        $this->session->unset_userdata('plano_id');
                        $this->session->unset_userdata('forma_mes');
                }

                redirect(base_url() . "checkout/inicio/agradecimento/");
                // $this->load->View('checkout/agradecimentofinal');  
        }

        function agradecimento(){

                $this->load->View('checkout/agradecimentofinal');
        }

        function gravarcartaoclienteiugu($paciente_id, $contrato_id) {
 
                $ambulatorio_guia_id = $this->inicio->gravarcartaoclienteiugu($paciente_id, $contrato_id);
                if ($ambulatorio_guia_id == "-1") {
                        $data['mensagem'] = 'Erro ao gravar cartão.';
                } else {
                        $data['mensagem'] = 'Sucesso ao gravar cartão.';
                }
                
                }
}
