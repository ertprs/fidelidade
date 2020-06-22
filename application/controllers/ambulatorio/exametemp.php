<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Exametemp extends BaseController {

    function Exametemp() {
        parent::Controller();
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/parceiro_model', 'parceiro');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/exametemp-lista', $args);

//            $this->carregarView($data);
    }

    function novo() {
        $ambulatorio_pacientetemp_id = $this->exametemp->criar();
        $this->carregarexametemp($ambulatorio_pacientetemp_id);

//            $this->carregarView($data);
    }

    function novopaciente() {
        $data['idade'] = 0;
        $this->loadView('ambulatorio/pacientetemp-form', $data);
    }

    function novopacienteconsulta() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsulta-form', $data);
    }

    function novopacientefisioterapia() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapia-form', $data);
    }

    function novopacienteconsultaencaixe() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempconsultaencaixe-form', $data);
    }

    function novopacienteexameencaixe() {
        $data['idade'] = 0;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempexameencaixe-form', $data);
    }

    function novopacienteencaixegeral() {
        $data['idade'] = 0;
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacientetempencaixegeral-form', $data);
    }

    function novohorarioexameencaixe() {
        $data['idade'] = 0;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempexameencaixe-form', $data);
    }

    function novohorarioencaixegeral() {
        $data['idade'] = 0;
        $data['salas'] = $this->exame->listartodassalas();
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/horariotempencaixegeral-form', $data);
    }

    function novopacientefisioterapiaencaixe() {
        $data['idade'] = 0;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $this->loadView('ambulatorio/pacientetempfisioterapiaencaixe-form', $data);
    }

    function pacienteconsultaencaixe($paciente_id) {
        $data['idade'] = 0;
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $this->loadView('ambulatorio/pacienteconsultaencaixe-form', $data);
    }

    function carregarexametemp($ambulatorio_pacientetemp_id) {
        $obj_exametemp = new exametemp_model($ambulatorio_pacientetemp_id);
        $data['obj'] = $obj_exametemp;
        $data['idade'] = 0;
        $data['contador'] = $this->exametemp->contador($ambulatorio_pacientetemp_id);
        if ($data['contador'] > 0) {
            $data['exames'] = $this->exametemp->listaragendas($ambulatorio_pacientetemp_id);
        }
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/exametemp-form', $data);
    }

    function unificar($paciente_id) {
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/unificar-form', $data);
    }

    function gravarunificar() {
        $pacientetemp_id = $_POST['paciente_id'];

        if ($_POST['txtpaciente'] == '' || $_POST['pacienteid'] == '') {
            $data['mensagem'] = 'Paciente que sera unificado nao informado ou invalido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        } else {
            $verifica = $this->exametemp->gravarunificacao();
            if ($verifica == "-1") {
                $data['mensagem'] = 'Erro ao unificar Paciente. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao unificar Paciente.';
            }
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/unificar/$pacientetemp_id");
        }
    }

    function confirmarpagamentofidelidade($exames_fidelidade_id) {

        $verifica = $this->guia->confirmarpagamentofidelidade($exames_fidelidade_id);
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao unificar Paciente. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao unificar Paciente.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function carregarpacientetempgeral($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendatotalpacientegeral($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarprocedimentosanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarprocedimentoanteriorcontador($pacientetemp_id);


        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetempgeral-form', $data);
    }

    function carregarpacientetemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['contador'] = $this->exametemp->contadorpaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpaciente($pacientetemp_id);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepacientetemp-form', $data);
    }

    function carregarpacienteconsultatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['contador'] = $this->exametemp->contadorconsultapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacienteconsulta($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/consultapacientetemp-form', $data);
    }

    function carregarpacientefisioterapiatemp($pacientetemp_id, $faltou = null) {
        if (isset($faltou)) {
            $data['faltou'] = $faltou;
        }

        $obj_paciente = new paciente_model($pacientetemp_id);
        $data['obj'] = $obj_paciente;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['contador'] = $this->exametemp->contadorfisioterapiapaciente($pacientetemp_id);
        $data['exames'] = $this->exametemp->listaragendatotalpacientefisioterapia($pacientetemp_id);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($pacientetemp_id);
        $data['consultaanteriorcontador'] = $this->exametemp->listarconsultaanteriorcontador($pacientetemp_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapacientetemp-form', $data);
    }

    function carregarexamegeral($agenda_exames_id, $medico_id) {
        $data['medico'] = $medico_id;
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
//
//        if (count($data['exameshorario']) > 0 || count($data['exameshorariofim']) > 0) {
//            
//            $data['mensagem'] = 'Esse medico já tem paciente neste horario:';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral2/$agenda_exames_id/$medico_id");
//            
//        } else {
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
//        }
    }

    function carregarexamegeral2($agenda_exames_id, $medico_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $medico_id;
//        $data['medicos'] = $this->exametemp->listarmedicoconsulta();
        $data['convenio'] = $this->procedimentoplano->listarconveniomedico($medico_id);
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeral-form', $data);
    }

    function carregarexamegeral3($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['medico'] = $this->exametemp->listarmedicoconsulta();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);

//        $horainicio = $data['exames'][0]->inicio;
//        $horafim = $data['exames'][0]->fim;
//
//        $data['exameshorario'] = $this->exametemp->listaragendasexamepacientehorario($horainicio, $horafim, $agenda_exames_id, $medico_id);
//        $data['exameshorariofim'] = $this->exametemp->listaragendasexamepacientehorariofinal($horainicio, $horafim, $agenda_exames_id, $medico_id);
        $this->loadView('ambulatorio/examepacientegeralmedico-form', $data);
    }

    function carregarexame($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['exames'] = $this->exametemp->listaragendasexamepaciente($agenda_exames_id);
        $medico = $data['exames'][0]->medico_agenda;
        $datas = $data['exames'][0]->data;
        $data['valor'] = $this->exametemp->listarvalortotalexames($medico, $datas);
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/examepaciente-form', $data);
    }

    function carregarconsultatemp($agenda_exames_id, $parceiro_id) {
//        $parceiro_ip_concatenado = $parceiro_ip . "/" . $sistema . "/";
        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;
        $data['parceiro_ip'] = $parceiro_id;
        $data['endereco_ip'] = @$endereco;
//        vars_dump(@$endereco);
//        die;
        $data['agenda_exames_id'] = $agenda_exames_id;
        @$convenio = file_get_contents("http://{$endereco}/autocomplete/listarhorarioagendawebconvenio?parceiro_id=$convenio_id");
        $data['convenio'] = json_decode($convenio);
//        var_dump($convenio); die;
        @$consultas = file_get_contents("http://{$endereco}/autocomplete/listarhorarioagendaweb?agenda_exames_id=$agenda_exames_id");
        $data['consultas'] = json_decode($consultas);
        if (count($data['consultas']) == 0) {
            echo '<html>
                              <meta charset = "UTF-8">
        <script type="text/javascript">
        alert("Verifique o endereço do sistema desejado");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
        } else {
            $this->loadView('ambulatorio/consultapaciente-form', $data);
        }
//        echo '<pre>';
//        var_dump($data['consultas']); die;
//        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        //$this->carregarView($data, 'giah/servidor-form');
    }

    function carregarfisioterapiatemp($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['convenio'] = $this->procedimentoplano->listarconvenio();
        $data['consultas'] = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);

        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/fisioterapiapaciente-form', $data);
    }

    function excluir($agenda_exames_id, $ambulatorio_pacientetemp_id) {
        $this->exametemp->excluir($agenda_exames_id);
        $this->carregarexametemp($ambulatorio_pacientetemp_id);
    }

    function excluirexametemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacientetemp($pacientetemp_id);
    }

    function excluirconsultatempgeral($agenda_exames_id, $parceiro_id) {
        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;
        $data['parceiro_ip'] = $parceiro_id;
//        var_dump(@$endereco); die;
        $this->exametemp->excluirexametemp($agenda_exames_id);
        @$cancelar = file_get_contents("http://{$endereco}/autocomplete/excluirconsultaweb?agenda_exames_id=$agenda_exames_id");
//        var_dump(@$cancelar); die;
        echo '<html>
                              <meta charset = "UTF-8">
        <script type="text/javascript">
        alert("Sucesso ao cancelar o atendimento");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
    }

    function excluirconsultatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    function excluirfisioterapiatemp($agenda_exames_id, $pacientetemp_id) {
        $this->exametemp->excluirexametemp($agenda_exames_id);
        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravar() {
        $exametemp_tuss_id = $this->exametemp->gravar();
        if ($exametemp_tuss_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar o Procedimento. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar o Procedimento.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp");
    }

    function excluirpaciente($paciente_id) {
        $pagamento = $this->paciente->listarparcelaiuguexclusaopaciente($paciente_id);
//        var_dump($pagamento); die;
        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

        $this->excluirparceria($paciente_id);

        foreach ($pagamento as $item) {


            Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
            $invoice_id = $item->invoice_id;

            $retorno = Iugu_Invoice::fetch($invoice_id);
            $retorno->cancel();
//            echo '<pre>';
//            var_dump($retorno);
//            die;
            $this->guia->cancelarpagamentoiugu($item->paciente_contrato_parcelas_id);
        }
        $verifica = $this->exametemp->excluirpaciente($paciente_id);
       
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao excluir o Paciente. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao excluir o Paciente.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes");
    }

    function gravartemp() {
        $ambulatorio_pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($ambulatorio_pacientetemp_id);
        $this->carregarexametemp($ambulatorio_pacientetemp_id);
    }

    function gravarpacienteexametemp($agenda_exames_id) {
        $agenda_id = $_POST['agendaid'];
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } elseif (trim($_POST['convenio1']) == "-1") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } elseif (trim($_POST['procedimento1']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar o procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexame/$agenda_id");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetemp($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteexametempgeral($agenda_exames_id) {
        $agenda = $_POST['agendaid'];
        $medico = $_POST['medicoid'];
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } elseif (trim($_POST['convenio1']) == "-1") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio seleionar um convenio.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral/$agenda/$medico");
        } elseif (trim($_POST['procedimento1']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio selecionar um procedimento.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/carregarexamegeral/$agenda/$medico");
        } else {
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetempgeral($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
            }
        }
    }

    function gravarpacienteconsultatemp($agenda_exames_id, $parceiro_id) {
        $data_atual = date("Y-m-d");
        $nome = str_replace(' ', '|||', $_POST['txtNome']);
        $paciente_id = $_POST['txtNomeid'];
        // LISTANDO ALGUMAS INFORMAÇÕES DO BANCO QUE USAREMOS NO DECORRER DA FUNÇÃO
//        echo '<pre>';
//        var_dump($paciente_informacoes[0]->situacao);
//        die;

        $cpf_array = $this->paciente->listardadoscpf($_POST['txtNomeid']);
        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        $cpf = $cpf_array[0]->cpf;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_POST['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        $paciente_informacoes = $this->paciente->listardados($_POST['txtNomeid']);
        if ($paciente_informacoes[0]->situacao == 'Dependente') {
            $dependente = true;
        } else {
            $dependente = false;
        }

        if ($dependente) {
            $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
            $paciente_id = $retorno[0]->paciente_id;
            $paciente_titular_id = $retorno[0]->paciente_id;
            $paciente_dependente_id = $_POST['txtNomeid'];
        } else {
            $paciente_id = $_POST['txtNomeid'];
            $paciente_titular_id = $_POST['txtNomeid'];
            $paciente_dependente_id = null;
        }
//        var_dump($_POST['txtNomeid']);
//        var_dump($paciente_id);
//        die;
//        $paciente_id = $_POST['txtNomeid'];

        $parcelas = $this->guia->listarparcelaspaciente($paciente_id);
        $carencia = $this->guia->listarparcelaspacientecarencia($paciente_id);

        $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_titular_id, $grupo);
        $carencia_exame = $carencia[0]->carencia_exame;
        $carencia_consulta = $carencia[0]->carencia_consulta;
        $carencia_especialidade = $carencia[0]->carencia_especialidade;
        $carencia_exame_mensal = $carencia[0]->carencia_exame_mensal;
        $carencia_consulta_mensal = $carencia[0]->carencia_consulta_mensal;
        $carencia_especialidade_mensal = $carencia[0]->carencia_especialidade_mensal;

        // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
        if ($grupo == 'EXAME') {
            $carencia = (int) $carencia_exame;
            $carencia_mensal = $carencia_exame_mensal;
        } elseif ($grupo == 'CONSULTA') {
            $carencia = (int) $carencia_consulta;
            $carencia_mensal = $carencia_consulta_mensal;
        } elseif ($grupo == 'FISIOTERAPIA' || $grupo == 'ESPECIALIDADE') {
            $carencia = (int) $carencia_especialidade;
            $carencia_mensal = $carencia_especialidade_mensal;
        }

//        var_dump($carencia_mensal); die;
        $parcelas_mensal = $this->guia->listarparcelaspacientemensal($paciente_id);
        if ($carencia_mensal == 't') {
            $listaratendimentomensal = $this->guia->listaratendimentoparceiromensal($paciente_titular_id, $grupo);
//            var_dump($listaratendimentomensal);
//            die;

            if (count($listaratendimentomensal) == 0 && count($parcelas_mensal) > 0) {
                $carencia_mensal_liberada = 't';
            } else {
                $carencia_mensal_liberada = 'f';
            }
        }
        $dias_parcela = 30 * count($parcelas);
        $dias_atendimento = $carencia * count($listaratendimento);
        // Divide o número de dias da parcela pelo de atendimentos. Caso não exista atendimento, iguala a zero para poder entrar na condição abaixo
// Abaixo tem vários var_dumps para saber algumas coisas. Eles são de deus. Eles me fizeram conseguir concluir essa parada
// 
//        echo '<pre>';
//        var_dump($paciente_titular_id);
//        var_dump($grupo);
//        var_dump($carencia);
//        var_dump($dias_parcela);
//        var_dump($dias_atendimento);
//        var_dump($parcelas);
//        var_dump($parcelas_mensal);
//        var_dump($listaratendimento);
//        die;
        // Nesse caso, se o número de dias de parcela que ele tem menos o número de dias de atendimento (carência x numero de atendimentos) que ele tem for maior que a carência
        // o sistema vai gravar. 
        //
        //
        if ($carencia_mensal == 't') {
            if ($carencia_mensal_liberada == 't') {
                $carencia_liberada = 't';
            } else {
                $carencia_liberada = 'f';
            }
        } else {
            if ((($dias_parcela - $dias_atendimento) >= $carencia) && $dias_parcela > 0) {
                // Caso o paciente tenha carência, ele faz o exame de graça, caso não, ele cai na condição abaixo que grava na tabela exames como false
                // Assim ele vai ter que pagar, porem, com um descontro cadastrado já como o valor do procedimento na clinica
                $carencia_liberada = 't';
            } else {
                $carencia_liberada = 'f';
            }
        }


//        $carencia_liberada = 'f';
        // Caso o cliente não tenha carência, o sistema vai buscar consultas avulsas
//        if ($carencia_liberada == 'f') {
//
//            $listarconsultaavulsa = $this->guia->listarconsultaavulsaliberada($paciente_titular_id);
//            if (count($listarconsultaavulsa) > 0) {
//                $consulta_avulsa_id = $listarconsultaavulsa[0]->consultas_avulsas_id;
//                $tipo_consulta = $listarconsultaavulsa[0]->tipo;
//                // Marcando que foi utilizada
//
//                $gravar_utilizacao = $this->guia->utilizarconsultaavulsaliberada($consulta_avulsa_id);
//
//                // Libera a consulta sem necessidade de pagamento adicional
//                $carencia_liberada = 't';
//            } else {
//                $tipo_consulta = '';
//            }
//        } else {
//            $listarconsultaavulsa = array();
//            $tipo_consulta = '';
//        }


        /* Se no fim das contas se tudo der errado, a variável carencia_liberada vai conter a informacao 'f'que irá ser salva na linha da consulta
          no banco, para dessa forma o sistema cobrar o valor do exame ao invés de utilizar da carência */

//        var_dump($listarconsultaavulsa);
//        die;



        if (count($parcelas) > 0) {
            if ($_POST['nascimento'] != '') {
//                var_dump($_POST['nascimento']); die;
                $nascimento = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['nascimento'])));
            } else {
                $nascimento = '';
            }

            $celular = str_replace(' ', '', @$_POST['celular']);
            $telefone = str_replace(' ', '', @$_POST['telefone']);

            $parametro = array(
                'txtNome' => (@$nome != '') ? @$nome : '',
                'convenio' => (@$_POST['convenio'] != '') ? @$_POST['convenio'] : '',
                'telefone' => ($telefone != '') ? $telefone : '',
                'celular' => ($celular != '') ? $celular : '',
                'nascimento' => ($nascimento != '') ? $nascimento : '',
                'cpf' => (@$cpf != '') ? @$cpf : '',
                'carencia_exame' => (@$carencia_exame != '') ? @$carencia_exame : '',
                'carencia_consulta' => (@$carencia_consulta != '') ? @$carencia_consulta : '',
                'carencia_especialidade' => (@$carencia_especialidade != '') ? @$carencia_especialidade : '',
                'observacoes' => (@$_POST['observacoes'] != '') ? @$_POST['observacoes'] : '',
                'agenda_exames_id' => ($agenda_exames_id != '') ? $agenda_exames_id : '',
                'procedimento' => (@$_POST['procedimento'] != '') ? @$_POST['procedimento'] : ''
            );
            // MONTANDO A URL PARA MANDAR NO FILE GET CONTENTS
            $url = "txtNome={$parametro['txtNome']}&convenio="
                    . "{$parametro['convenio']}&agenda_exames_id={$parametro['agenda_exames_id']}"
                    . "&cpf={$parametro['cpf']}"
                    . "&telefone={$parametro['telefone']}"
                    . "&celular={$parametro['celular']}"
                    . "&nascimento={$parametro['nascimento']}"
                    . "&carencia_exame={$parametro['carencia_exame']}"
                    . "&carencia_consulta={$parametro['carencia_consulta']}"
                    . "&carencia_especialidade={$parametro['carencia_especialidade']}"
                    . "&observacoes={$parametro['observacoes']}"
                    . "&procedimento={$parametro['procedimento']}";

//            echo '<pre>';
//            var_dump($url);
//            die;


            if (trim($_POST['txtNome']) == "") {
                $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
            } else {

                // MANDANDO A CONSULTA PARA O SERVER
                $consultas = file_get_contents("http://{$endereco}/autocomplete/gravarhorarioagendawebconvenio?{$url}");
                $retorno_obj = json_decode($consultas);
//                var_dump($consultas); die;
                $paciente_parceiro_id = $retorno_obj[0]->paciente_id;
                $data = $retorno_obj[0]->data;
//                var_dump($data);
//                var_dump($paciente_parceiro_id);
//                die;
                if ($consultas != ' 0') {
//                    $gravaratendimento = $this->guia->gravaratendimentoparceiro($parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data, $grupo, $paciente_titular_id, $carencia_liberada, $tipo_consulta);
                    echo '<html>
        <meta charset = "UTF-8">
        <script type="text/javascript">
        alert("Operação Efetuada Com Sucesso");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
                } else {
                    echo '<html>
        <meta charset = "UTF-8">
        <script type="text/javascript">
        alert("Erro ao gravar consulta. Paciente Inexistente no Parceiro");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
                }

//            $data['medico'] = $this->exametemp->listarmedicoconsulta();
//            $paciente_id = $this->exametemp->gravarpacienteconsultas($agenda_exames_id);
//            redirect(base_url() . "ambulatorio/exame/listarmultifuncaoconsulta");
//        die;
                // DEFININDO OS PARAMETROS PARA MANDAR NA URL
            }
        } else {
            echo '<html>
        <meta charset = "UTF-8">
        <script type="text/javascript">
        alert("Erro ao gravar consulta. Problemas de pagamento no cliente");
        window.onunload = fechaEstaAtualizaAntiga;
        function fechaEstaAtualizaAntiga() {
            window.opener.location.reload();
            }
        window.close();
            </script>
            </html>';
        }
        // Realiza a gravação da consulta caso o teste seja verdadeiro 
    }

    function gravarpacientefisioterapiatemp($agenda_exames_id) {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {

            $data['medico'] = $this->exametemp->listarmedicoconsulta();

            if (isset($_POST['sessao'])) {
                $data['agenda_selecionada'] = $this->exametemp->listaagendafisioterapia($agenda_exames_id);
                $data['horarios_livres'] = $this->exametemp->listadisponibilidadefisioterapia($data['agenda_selecionada'][0]);

                $tothorarios = count($data['horarios_livres']);
                if ($_POST['sessao'] == '' || $_POST['sessao'] == null || $_POST['sessao'] == 0) {
                    $_POST['sessao'] = 1;
                }

                $_POST['sessao'] = (int) $_POST['sessao'];

                if ($tothorarios < $_POST['sessao']) {
                    $data['mensagem'] = "Não há horarios suficientes na agenda para o numero de sessoes escolhido";
                    $this->session->set_flashdata('message', $data['mensagem']);
                    redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
                }

                for ($i = 0; $i < $_POST['sessao']; $i++) {
                    $paciente_id = $this->exametemp->gravarpacientefisioterapia($data['horarios_livres'][$i]->agenda_exames_id);
                }

                $this->carregarpacientefisioterapiatemp($paciente_id);
            } else {
                $paciente_id = $this->exametemp->gravarpacientefisioterapia($agenda_exames_id);
                $this->carregarpacientefisioterapiatemp($paciente_id);
            }
        }
    }

    function reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        $this->carregarpacientetemp($paciente_id);
    }

    function reservartempgeral($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        $paciente_id = $this->exametemp->reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data);
        $this->carregarpacientetempgeral($paciente_id);
    }

    function reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        $this->carregarpacienteconsultatemp($paciente_id);
    }

    function reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        $paciente_id = $this->exametemp->reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data);
        $this->carregarpacientefisioterapiatemp($paciente_id);
    }

    function gravarpacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarexames($pacientetemp_id);
        $this->carregarpacientetemp($pacientetemp_id);
    }

    function gravarpacientetempgeral() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarpacienteexistentegeral($pacientetemp_id);
        $this->carregarpacientetempgeral($pacientetemp_id);
    }

    function gravarconsultapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarconsultaspacienteexistente($pacientetemp_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    function gravarfisioterapiapacientetemp() {

        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravarfisioterapiapacienteexistente($pacientetemp_id);
        $this->carregarpacientefisioterapiatemp($pacientetemp_id);
    }

    function gravarpaciente() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
        } else {
            $agenda_exames_id = $_POST['horarios'];
            $paciente_id = $this->exametemp->gravarpacienteexames($agenda_exames_id);
            if ($paciente_id != 0) {
                $this->carregarpacientetemp($paciente_id);
            } else {
                $data['mensagem'] = 'Erro ao marcar exame o horario esta oculpado.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
            }
        }
    }

    function gravarpacienteconsulta() {
        if ((trim($_POST['txtNome']) == "") || (trim($_POST['convenio']) == "0")) {
            $mensagem = 'Erro ao marcar consulta é obrigatorio nome do Paciente e Convenio.';
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarconsultas($pacientetemp_id);
            $this->carregarpacienteconsultatemp($pacientetemp_id);
        }
    }

    function gravarpacientefisioterapia() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacientefisioterapia");
        } else {
            $pacientetemp_id = $this->paciente->gravarpacientetemp();
            $this->exametemp->gravarfisioterapia($pacientetemp_id);
            $this->carregarpacientefisioterapiatemp($pacientetemp_id);
        }
    }

    function gravarpacienteconsultaencaixe() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->exametemp->gravarconsultasencaixe();

            //enviar email
            $texto = "Consulta agendada para o dia " . $_POST['data_ficha'] . ", com início às " . $_POST['horarios'] . ".";
            $email = $this->laudo->email($pacientetemp_id);
            if (isset($email)) {
                $this->email($email, $texto);
            }
            //fim eviafr email

            $this->carregarpacienteconsultatemp($pacientetemp_id);
        }
    }

    function email($email, $texto) {
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $this->email->initialize($config);

        $this->email->from('equipe2016gcjh@gmail.com', 'STG Saúde');
        $this->email->to($email);
        $this->email->subject('Consulta Agendada');
        $this->email->message($texto);
        $this->email->send();
//    echo $this->email->print_debugger();
    }

    function gravarpacienteexameencaixe() {
        if (trim($_POST['txtNome']) == "" || $_POST['convenio1'] == "-1") {
            $data['mensagem'] = 'Erro. Obrigatório Convenio e nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "ambulatorio/exametemp/novopaciente");
            redirect(base_url() . "ambulatorio/exametemp/novopacienteexameencaixe");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixe();
            $this->carregarpacientetemp($pacientetemp_id);
        }
    }

    function gravarpacienteencaixegeral() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteencaixegeral");
        } else {
            $pacientetemp_id = $this->exametemp->gravarexameencaixegeral();
            redirect(base_url() . "ambulatorio/exametemp/carregarpacientetempgeral/$pacientetemp_id");
        }
    }

    function gravarhorarioexameencaixe() {
        $this->exametemp->gravarhorarioencaixe();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncao");
    }

    function gravarhorarioexameencaixegeral() {
        $this->exametemp->gravarhorarioencaixegeral();
        redirect(base_url() . "ambulatorio/exame/listarmultifuncaogeral");
    }

    function gravarpacientefisioterapiaencaixe() {
        if (trim($_POST['txtNome']) == "") {
            $data['mensagem'] = 'Erro ao marcar consulta é obrigatorio nome do Paciente.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/exametemp/novopacienteconsulta");
        } else {
            $pacientetemp_id = $this->exametemp->gravarfisioterapiaencaixe();
            $this->carregarpacientefisioterapiatemp($pacientetemp_id);
        }
    }

    function gravapacienteconsultaencaixe() {
        $pacientetemp_id = $_POST['txtpaciente_id'];
        $this->exametemp->gravaconsultasencaixe($pacientetemp_id);
        $this->carregarpacienteconsultatemp($pacientetemp_id);
    }

    private
            function carregarView($data = null, $view = null) {
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

    function excluirparceria($paciente_id){
         $retorno_paciente = $this->paciente->listardados($paciente_id);
         $cpf = $retorno_paciente[0]->cpf;
         $parceiro_id = $retorno_paciente[0]->parceiro_id;        
         $parceiros = $this->paciente->listarparceirosporid($parceiro_id);
         $endereco = $parceiros[0]->endereco_ip;
       if($endereco != ""){
         $url = "http://" . $endereco . "/autocomplete/excluirparceriafidelidade";
         
         $postdata = http_build_query(
                    array(
                        'cpf' => $cpf,
                        'parceriamed_id' => $parceiro_id
                    )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
            ));
         
          $context = stream_context_create($opts);
           
              $result = file_get_contents($url, false, $context);
     }
   //      print_r($result); 
    }
    
    
    
}

/* End of file welcome.php */
    /* Location: ./system/application/controllers/welcome.php */
    