<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");
//require_once("./iugu/test/Iugu.php");

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Guia extends BaseController {

    function Guia() {
        parent::Controller();
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/modelodeclaracao_model', 'modelodeclaracao');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/GExtenso', 'GExtenso');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function anexararquivoscontrato($contrato_id) {

        $this->load->helper('directory');

        if (!is_dir("./upload/contratos")) {
            mkdir("./upload/contratos");
            $destino = "./upload/contratos";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/contratos/$contrato_id")) {
            mkdir("./upload/contratos/$contrato_id");
            $destino = "./upload/contratos/$contrato_id";
            chmod($destino, 0777);
        }

        $data['arquivo_pasta'] = directory_map("./upload/contratos/$contrato_id");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/enviararquivoscontrato', $data);
    }

    function importararquivoscontrato($contrato_id) {
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

        if (!is_dir("./upload/contratos")) {
            mkdir("./upload/contratos");
            $destino = "./upload/contratos";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/contratos/$contrato_id")) {
            mkdir("./upload/contratos/$contrato_id");
            $destino = "./upload/contratos/$contrato_id";
            chmod($destino, 0777);
        }

        // if (!$arquivo_existe) {
//             var_dump($arquivo_existe); die;
            //        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/contratos/" . $contrato_id . "/";
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
        $data['contrato_id'] = $contrato_id;


        // var_dump($error);
        // die;
        // }

        redirect(base_url() . "ambulatorio/guia/anexararquivoscontrato/$contrato_id");
    }


    function excluirarquivoscontrato($contrato_id, $nome) {

        // if (!is_dir("./uploadopm/planos/$plano_id")) {
        //     mkdir("./uploadopm/planos");
        //     mkdir("./uploadopm/planos/$plano_id");
        //     $destino = "./uploadopm/planos/$plano_id";
        //     chmod($destino, 0777);
        // }

        $origem = "./upload/contratos/$contrato_id/$nome";
        // $destino = "./uploadopm/paciente/$plano_id/$nome";
        // copy($origem, $destino);
        unlink($origem);

        redirect(base_url() . "ambulatorio/guia/anexararquivoscontrato/$contrato_id");

//        $this->anexarimagem($paciente_id);
    }

    function pesquisar($paciente_id) {
        $data['exames'] = $this->guia->listarexames($paciente_id);
        $contrato_ativo = $this->guia->listarcontratoativo($paciente_id);
        if (count($contrato_ativo) > 0) {
            if ($contrato_ativo[count($contrato_ativo) - 1]->data != "") {
                $paciente_contrato_id = $contrato_ativo[0]->paciente_contrato_id;
                $data_contrato = $contrato_ativo[count($contrato_ativo) - 1]->data;
                $data_atual = date("Y-m-d");
                //            $data_contrato_year = date('Y-m-d H:i:s', strtotime("+ 1 year", strtotime($data_contrato)));
                if ($data_atual > $data_contrato) {
                    $contrato_ativo = $this->guia->gravarnovocontratoanual($paciente_contrato_id);
                }
            }
        }
//       
        $data['titular'] = $this->guia->listartitular($paciente_id);
//        var_dump($data['titular'] ); die;
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/guia-lista', $data);
    }

    function novocontrato($paciente_id) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['planos'] = $this->formapagamento->listarforma();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $plano_id = $data['paciente'][0]->plano_id;
        $data['forma_pagamento'] = $this->paciente->listaforma_pagamento($plano_id);
        $this->loadView('ambulatorio/novocontrato-form', $data);
    }

    function relatorioinadimplentes() {
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioinadimplentes');
    }

    function gerarelatorioinadimplentes() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatorioinadimplentes();

        $this->load->View('ambulatorio/impressaorelatorioinadimplentes', $data);
    }

    function relatoriocontratosinativos() {
//        $data['empresa'] = $this->guia->listarempresas();
        $data['planos'] = $this->formapagamento->listarforma();
        $data['vencedor'] = $this->operador_m->listarvendedor(1);

        $this->loadView('ambulatorio/relatoriocontratosinativos', $data);
    }

    function relatoriotitularesexcluidos() {
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriotitularesexcluidos');
    }

    function gerarelatoriocontratosinativos() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatoriocontratosinativos();
       
        $this->load->View('ambulatorio/impressaorelatoriocontratosinativos', $data);
    }

    function gerarelatoriotitularesexcluidos() {
//        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
//        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatoriotitularesexcluidos();

        $this->load->View('ambulatorio/impressaorelatoriotitularesexcluidos', $data);
    }

    function relatoriodependentes() {
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriodependentes');
    }

    function gerarelatoriodependentes() {
//        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
//        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatoriodependentes();

        $this->load->View('ambulatorio/impressaorelatoriodependentes', $data);
    }

    function relatoriovendedores() {
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriovendedores');
    }

    function gerarelatoriovendedores() {
//        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
//        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatoriovendedores();

        $this->load->View('ambulatorio/impressaorelatoriovendedores', $data);
    }

    function relatoriocadastro() {
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriocadastro');
    }

    function relatoriocadastroparceiro() {
//        $data['empresa'] = $this->guia->listarempresas();
        $data['listarparceiro'] = $this->paciente->listarparceiros();
        $this->loadView('ambulatorio/relatoriocadastroparceiro', $data);
    }

    function gerarelatoriocadastroparceiro() {
//        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
//        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['parceiro'] = $this->guia->listarparceirorelatorio();
        $data['relatorio'] = $this->guia->relatoriocadastroparceiro();

        $this->load->View('ambulatorio/impressaorelatoriocadastroparceiro', $data);
    }

    function gerarelatoriocadastro() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatoriocadastro();

        $this->load->View('ambulatorio/impressaorelatoriocadastro', $data);
    }

    function acompanhamento($paciente_id) {
        $data['exames'] = $this->guia->listarexames($paciente_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->loadView('ambulatorio/acompanhamento-lista', $data);
    }

    function voz() {
        $this->load->View('ambulatorio/aavoz');
    }

    function gravordevoz() {
        $this->load->View('ambulatorio/aagravadordevoz');
    }

    function impressaoguiaconsultaconvenio($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $exames = $data['exames'];

        $this->load->View('ambulatorio/impressaoguiaconsultaconvenio', $data);
    }

    function chat() {
        $this->loadView('chat/formulario');
    }

    function fala() {
        $data['chamada'] = $this->guia->listarchamadas();
        $this->load->View('ambulatorio/aafala', $data);
    }

    function editarfichaxml($paciente_id, $exames_id) {
        $data['exames_id'] = $exames_id;
        $data['paciente_id'] = $paciente_id;

        $xml = $this->guia->listarfichaxml($exames_id);
        $texto = $this->guia->listarfichatexto($exames_id);


        $string = xml_convert($xml);

        $data['r1'] = substr($string, 86, 3);
        $data['r2'] = substr($string, 110, 3);
        $data['r3'] = substr($string, 134, 3);
        $data['r4'] = substr($string, 158, 3);
        $data['r5'] = substr($string, 182, 3);
        $data['r6'] = substr($string, 206, 3);
        $data['r7'] = substr($string, 230, 3);
        $data['r8'] = substr($string, 254, 3);
        $data['r9'] = substr($string, 278, 3);
        $data['r10'] = substr($string, 303, 3);
        $data['r11'] = substr($string, 329, 3);
        $data['r12'] = substr($string, 355, 3);
        $data['r13'] = substr($string, 381, 3);
        $data['r14'] = substr($string, 407, 3);
        $data['r15'] = substr($string, 433, 3);
        $data['r16'] = substr($string, 459, 3);
        $data['r17'] = substr($string, 485, 3);
        $data['r18'] = substr($string, 511, 3);
        $data['r19'] = substr($string, 537, 3);
        $data['r20'] = substr($string, 563, 3);

        $data['peso'] = $texto[0]->peso;
        $data['txtp9'] = $texto[0]->txtp9;
        $data['txtp19'] = $texto[0]->txtp19;
        $data['txtp20'] = $texto[0]->txtp20;
        $data['obs'] = $texto[0]->obs;

        $this->loadView('ambulatorio/fichaeditar-xml-form', $data);
    }

    function gravareditarfichaxml($paciente_id, $exames_id) {
        $this->guia->gravareditarfichaxml($exames_id);
        $this->pesquisar($paciente_id);
    }

    function fichaxml($paciente_id, $guia_id, $exames_id) {
        $data['exames_id'] = $exames_id;
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $teste = $this->guia->listarfichatexto($exames_id);
        if (isset($teste[0]->agenda_exames_id)) {
            $this->gravarfichaxml($paciente_id, $guia_id, $exames_id);
        } else {
            $this->loadView('ambulatorio/ficha-xml-form', $data);
        }
    }

    function gravarfichaxml($paciente_id, $guia_id, $exames_id) {
        $this->guia->gravarfichaxml($exames_id);
        $xml = $this->guia->listarfichaxml($exames_id);
        $texto = $this->guia->listarfichatexto($exames_id);


        $string = xml_convert($xml);

        $data['r1'] = substr($string, 86, 3);
        $data['r2'] = substr($string, 110, 3);
        $data['r3'] = substr($string, 134, 3);
        $data['r4'] = substr($string, 158, 3);
        $data['r5'] = substr($string, 182, 3);
        $data['r6'] = substr($string, 206, 3);
        $data['r7'] = substr($string, 230, 3);
        $data['r8'] = substr($string, 254, 3);
        $data['r9'] = substr($string, 278, 3);
        $data['r10'] = substr($string, 303, 3);
        $data['r11'] = substr($string, 329, 3);
        $data['r12'] = substr($string, 355, 3);
        $data['r13'] = substr($string, 381, 3);
        $data['r14'] = substr($string, 407, 3);
        $data['r15'] = substr($string, 433, 3);
        $data['r16'] = substr($string, 459, 3);
        $data['r17'] = substr($string, 485, 3);
        $data['r18'] = substr($string, 511, 3);
        $data['r19'] = substr($string, 537, 3);
        $data['r20'] = substr($string, 563, 3);

        $data['peso'] = $texto[0]->peso;
        $data['txtp9'] = $texto[0]->txtp9;
        $data['txtp19'] = $texto[0]->txtp19;
        $data['txtp20'] = $texto[0]->txtp20;
        $data['obs'] = $texto[0]->obs;


        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $dinheiro = $data['exame'][0]->dinheiro;

        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == "t") {
                $valor_total = $valor_total + ($item->valor_total);
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {

            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }
//        var_dump($data['r1'] ,$data['r2'] , $data['r3'] , $data['r4'], $data['r5'] , $data['r6'] , $data['r7'] , $data['r8'], $data['r9'] , $data['r10'],$data['r11'],$data['r12'],$data['r13'],$data['r14'],$data['r15'],$data['r16'],$data['r17'],$data['r18'],$data['r19'],$data['r20']);
//        die;

        $this->load->view('ambulatorio/impressaoficharm', $data);
//        $this->load->view('ambulatorio/impressaoficharm-verso');
    }

    function impressaoficha($paciente_contrato_id) {
        $this->load->plugin('mpdf');
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarparcelas($paciente_contrato_id);
        $data['dependente'] = $this->guia->listardependentes($paciente_contrato_id);

        $data['emissao'] = date("d-m-Y");
        foreach ($data['exame'] as $value) {
            if ($value->taxa_adesao == 't')
                $data['adesao'] = $value->data;
        }

        if ($data['empresa'][0]->modelo_carteira == 1) {
            $this->load->View('ambulatorio/impressaoficharonaldo', $data);
        } elseif ($data['empresa'][0]->modelo_carteira == 2) {
            $filename = 'cartão.pdf';
            $cabecalho = '';
            $rodape = '';
//            $html = $this->load->View('ambulatorio/impressaocarteiradez', $data, true);
            $this->load->View('ambulatorio/impressaocarteiradez', $data);
//            pdf($html, $filename, $cabecalho, $rodape);
        }

///////////////////////////////////////////////////////////////////////////////////////////////        
        // $this->load->View('ambulatorio/impressaoficharonaldo', $data);
    }

    function impressaocarteira($paciente_id, $contrato_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['paciente'] = $this->guia->listarpacientecarteira($paciente_id);
        $data['titular_id'] = $contrato_id;

            $this->load->View('ambulatorio/impressaoficharonaldo', $data);

///////////////////////////////////////////////////////////////////////////////////////////////        
        // $this->load->View('ambulatorio/impressaoficharonaldo', $data);
    }

    function impressaoorcamento($orcamento) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exames'] = $this->guia->listarexamesorcamento($orcamento);
        $this->load->View('ambulatorio/impressaoorcamento', $data);
    }

    function impressaofichaconvenio($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $convenioid = $data['exame'][0]->convenio_id;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguiaconvenio($guia_id, $convenioid);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == "t") {
                $valor_total = $valor_total + ($item->valor_total);
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }
        if ($data['empresa'][0]->impressao_tipo == 1) {//HUMANA        
            if ($grupo == "RX" || $grupo == "US" || $grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaus', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografia', $data);
            }
            if ($grupo == "DENSITOMETRIA") {
                $this->load->View('ambulatorio/impressaofichadensitometria', $data);
            }
            if ($grupo == "RM") {
                $this->load->View('ambulatorio/impressaoficharm', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 2) {//PROIMAGEM 
            //criar codigo de barras (inicio)
            foreach ($exames as $value) {
                if (!is_dir("./upload/barcodeimg/")) {
                    mkdir("./upload/barcodeimg/");
                    chmod("./upload/barcodeimg/", 0777);
                }
                if (!is_dir("./upload/barcodeimg/$value->paciente_id/")) {
                    mkdir("./upload/barcodeimg/$value->paciente_id/");
                    chmod("./upload/barcodeimg/$value->paciente_id/", 0777);
                }
                $this->utilitario->barcode($value->agenda_exames_id, "./upload/barcodeimg/$value->paciente_id/$value->agenda_exames_id.png", $size = "20", "horizontal", "code128", true, 1);
            }
            // criar codigo de barras (fim)

            if ($grupo == "RX" || $grupo == "US" || $grupo == "RM" || $grupo == "DENSITOMETRIA" || $grupo == "TOMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichausproimagem', $data);
            }
            if ($grupo == "MAMOGRAFIA") {
                $this->load->View('ambulatorio/impressaofichamamografiaproimagem', $data);
            }
        }

/////////////////////////////////////////////////////////////////////////////////
        elseif ($data['empresa'][0]->impressao_tipo == 3) {//CLINICAS PACAJUS
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsulta', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaoficharonaldo', $data);
                }
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 4) {//  CLINICAS FISIOCLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultafisioclinica', $data);
            } else {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaofichafisioclinicaparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaofichafisioclinica', $data);
                }
            }
        }

/////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 5) {// COT CLINICA
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultacot', $data);
            }
            if ($grupo == "FISIOTERAPIA") {
                $this->load->View('ambulatorio/impressaofichafisioterapia', $data);
            }
            if ($data['exame'][0]->tipo == "EXAME") {
                if ($dinheiro == "t") {
                    $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
                } else {
                    $this->load->View('ambulatorio/impressaoficharonaldo', $data);
                }
            }
        }

/////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 6) {// CLINICA dez
            if ($grupo == "CONSULTA") {
                $this->load->View('ambulatorio/impressaofichaconsultadez', $data);
            }
            if ($data['exame'][0]->tipo == "EXAME") {
                $this->load->View('ambulatorio/impressaofichaexamedez', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 7) {// CLINICA MED
            $this->load->View('ambulatorio/impressaofichamed', $data);
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 8) {// RONALDO
            if ($dinheiro == "t") {
                $this->load->View('ambulatorio/impressaoficharonaldoparticular', $data);
            } else {
                $this->load->View('ambulatorio/impressaoficharonaldo', $data);
            }
        }

////////////////////////////////////////////////////////////////////////////////        
        elseif ($data['empresa'][0]->impressao_tipo == 9) {//CLINICA SAO PAULO
            $this->load->View('ambulatorio/impressaofichaconsultasaopaulo', $data);
        }
    }

    function impressaoetiiqueta($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $data['exame'] = $this->guia->listarexame($exames_id);
        $grupo = $data['exame'][0]->grupo;
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $data['empresa'] = $this->guia->listarempresa($guia_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->load->View('ambulatorio/impressaoetiquetaexame', $data);
    }

    function impressaoetiquetaunica($paciente_id, $guia_id, $exames_id) {
        $data['emissao'] = date("d-m-Y");
        $data['exame'] = $this->guia->listarexame($exames_id);
        $data['empresa'] = $this->guia->listarempresa($guia_id);
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $this->load->View('ambulatorio/impressaoetiquetaunica', $data);
    }

    function teste() {
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/20/");
        $this->load->View('ambulatorio/teste-lista', $data);

//            $this->carregarView($data);
    }

    function anexarimagem($guia_id) {

        $this->load->helper('directory');
        if (!is_dir("./upload/guia/$guia_id")) {
            mkdir("./upload/guia/$guia_id");
            $destino = "./upload/guia/$guia_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/guia/$guia_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/importacao-imagemguia', $data);
    }

    function importarimagem() {
        $guia_id = $_POST['guia_id'];
        if (!is_dir("./upload/guia/$guia_id")) {
            mkdir("./upload/guia/$guia_id");
            $destino = "./upload/guia/$guia_id";
            chmod($destino, 0777);
        }

        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/guia/" . $guia_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt';
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
        $data['guia_id'] = $guia_id;
        $this->anexarimagem($guia_id);
    }

    function excluirimagem($guia_id, $nome) {

        if (!is_dir("./uploadopm/guia/$guia_id")) {
            mkdir("./uploadopm/guia");
            mkdir("./uploadopm/guia/$guia_id");
            $destino = "./uploadopm/guia/$guia_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/guia/$guia_id/$nome";
        $destino = "./uploadopm/guia/$guia_id/$nome";
        copy($origem, $destino);
        unlink($origem);
        $this->anexarimagem($guia_id);
    }

    function galeria($exame_id) {
        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/$exame_id/");
        $data['exame_id'] = $exame_id;
        $this->load->View('ambulatorio/galeria-lista', $data);

//            $this->carregarView($data);
    }

    function teste2() {
        $teste1 = $_POST['teste'];
//        $teste2 = $_POST['teste'];
//        $teste3 = $_POST['teste'];
//        $teste4 = $_POST['teste'];
        var_dump($teste1);
//        var_dump($teste2);
//        var_dump($teste3);
//        var_dump($teste4);
        die;
        $this->load->View('ambulatorio/teste-lista');

//            $this->carregarView($data);
    }

    function carregarsala($ambulatorio_guia_id) {
        $obj_guia = new sala_model($ambulatorio_guia_id);
        $data['obj'] = $obj_guia;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function excluir($paciente_id, $contrato_id) {
        if ($this->guia->excluir($paciente_id, $contrato_id)) {
            $mensagem = 'Sucesso ao excluir a dependente';
        } else {
            $mensagem = 'Erro ao excluir a dependente. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listardependentes/$paciente_id/$contrato_id");
    }

    function confirmarpagamento($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

//        var_dump($valor); die;
        if ($this->guia->confirmarpagamento($paciente_contrato_parcelas_id)) {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function confirmarpagamentoconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id) {

//        var_dump($valor); die;
        $tipo = $this->guia->confirmarpagamentoconsultaavulsa($consultas_avulsas_id, $paciente_id);
        // var_dump($tipo); die;
        if ($tipo != '') {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        if($tipo == 'CONSULTA EXTRA'){
            redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id");
        }else{
            redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultacoop/$paciente_id/$contrato_id");
        }
        
    }

    function cancelaragendamentocartao($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

//        var_dump($valor); die;
        if ($this->guia->cancelaragendamentocartao($paciente_contrato_parcelas_id, $contrato_id)) {
            $mensagem = 'Sucesso ao cancelar agendamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function alterardatapagamento($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['paciente_contrato_parcelas_id'] = $paciente_contrato_parcelas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarparcelaalterardata($paciente_contrato_parcelas_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/alterardatapagamento-form', $data);
    }

    function alterardatapagamentoconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['consultas_avulsas_id'] = $consultas_avulsas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listaralterardataconsultaavulsa($consultas_avulsas_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/alterardatapagamentoconsultaavulsa-form', $data);
    }

    function alterarobservacao($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['paciente_contrato_parcelas_id'] = $paciente_contrato_parcelas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarparcelaobservacao($paciente_contrato_parcelas_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/alterarobservacaopagamento-form', $data);
    }

    function auditoriaparcela($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {
        
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['paciente_contrato_parcelas_id'] = $paciente_contrato_parcelas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarparcelaauditoria($paciente_contrato_parcelas_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/auditoriaparcela', $data);

    }

    function alterarobservacaoavulso($paciente_id, $contrato_id, $consulta_avulsa_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['consulta_avulsa_id'] = $consulta_avulsa_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarconsultaavulsaobservacao($consulta_avulsa_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/alterarobservacaopagamentoavulso-form', $data);
    }

    function reenviaremail($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $empresa = $this->guia->listarempresa();
        $pagamento = $this->guia->listarparcelareenviaremail($paciente_contrato_parcelas_id);
        $email = $pagamento[0]->cns;
        $url = $pagamento[0]->url;
        $nome_emp = $empresa[0]->nome;
        $data = date("d/m/Y", strtotime($pagamento[0]->data));
//        var_dump($pagamento);
//        die;
        $assunto = "$nome_emp referente a: $data";
        $mensagem = "Aqui está o link para o pagamento da parcela referente a: $data <br> Link: $url "
                . "<br>"
                . "<br>"
                . "<br>"
                . "<br>"
                . "Obs: Email automático. Por favor não responder";


        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'stgsaude@gmail.com';
        $config['smtp_pass'] = 'saude1234';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->email->initialize($config);
        if (@$empresa[0]->email != '') {
            $this->email->from($empresa[0]->email, $empresa[0]->nome);
        } else {
            $this->email->from('soudez@gmail.com', $nome_emp);
        }
//        var_dump($assunto); die;
        $this->email->to($email);
        $this->email->subject($assunto);
        $this->email->message($mensagem);
        $teste = '';
        if ($this->email->send()) {
            $alert = "Email enviado com sucesso";
        } else {
            $alert = "Envio de Email malsucedido";
        }
//        var_dump($teste); die;
        $this->session->set_flashdata('message', $alert);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gravaralterarobservacao($paciente_contrato_parcelas_id, $paciente_id, $contrato_id) {

        $this->guia->gravaralterarobservacao($paciente_contrato_parcelas_id);
//        $alert = "Observacao";
//        $this->session->set_flashdata('message', $alert);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaralterarobservacaoavulsa($consulta_avulsa_id, $paciente_id, $contrato_id) {

        $this->guia->gravaralterarobservacaoavulsa($consulta_avulsa_id);
//        $alert = "Observacao";
//        $this->session->set_flashdata('message', $alert);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaralterardatapagamento($paciente_contrato_parcelas_id, $paciente_id, $contrato_id) {
        $pagamento_iugu_old = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
        $data_antiga = $pagamento_iugu_old[0]->data;
        $observacao = $pagamento_iugu_old[0]->observacao;
//        var_dump($data_antiga); die;
        $this->guia->gravaralterardatapagamento($paciente_contrato_parcelas_id);

        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($paciente_contrato_parcelas_id);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        if ($key != '') {
            $cliente = $this->paciente->listardados($paciente_id);
//            $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
            $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
            $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
            $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

            $pagamento = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
            $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($paciente_contrato_parcelas_id);
            $data_nova = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data'])));
            $data = date('d/m/Y', strtotime($pagamento[0]->data));
            if (strtotime($data_nova) > strtotime($data_antiga) && isset($_POST['juros'])) {
                $data1 = new DateTime($data_nova);
                $data2 = new DateTime($data_antiga);
                $intervalo = $data1->diff($data2);
                $dias = $intervalo->days;


                $juros_dia = ($pagamento[0]->juros / 100) * $pagamento[0]->valor;

                $multa_atraso = $pagamento[0]->multa_atraso;

                $valor = round($pagamento[0]->valor + $multa_atraso + ($juros_dia * $dias), 2) * 100;
            } else {
                $valor = $pagamento[0]->valor * 100;
            }
            $valor_gravar = $valor / 100;

//            echo '<pre>';
//            var_dump($data_nova);
//            var_dump($data_antiga);
//            var_dump($juros_dia);
//            var_dump($_POST['juros']);
//            var_dump($valor_gravar);
//            die;
            $observacao = $observacao . " Multa Atraso: " . number_format($multa_atraso, 2, ',', '.') . " Juros: "
                    . number_format($juros_dia * $dias, 2, ',', '.') . " $dias Dias ";
            $this->guia->gravarnovovalorparcela($paciente_contrato_parcelas_id, $valor_gravar, $observacao);
            $description = $empresa[0]->nome . " - " . $pagamento[0]->plano;

//            var_dump($pagamento_iugu);
//            die;
            $this->guia->cancelarpagamentoiugu($paciente_contrato_parcelas_id);
            Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
            if ($pagamento_iugu[0]->invoice_id != '') {
                $invoice = Iugu_Invoice::fetch($pagamento_iugu[0]->invoice_id);
                $invoice->cancel();





                $gerar = Iugu_Invoice::create(Array(
                            "email" => $cliente[0]->cns,
                            "due_date" => $data,
                            "items" => Array(
                                Array(
                                    "description" => $description,
                                    "quantity" => "1",
                                    "price_cents" => $valor
                                )
                            ),
                            "payer" => Array(
                                "cpf_cnpj" => $cliente[0]->cpf,
                                "name" => $cliente[0]->nome,
                                "phone_prefix" => $prefixo,
                                "phone" => $celular_s_prefixo,
                                "email" => $cliente[0]->cns,
                                "address" => Array(
                                    "street" => $cliente[0]->logradouro,
                                    "number" => $cliente[0]->numero,
                                    "city" => $cliente[0]->cidade_desc,
                                    "state" => $codigoUF,
                                    "district" => $cliente[0]->bairro,
                                    "country" => "Brasil",
                                    "zip_code" => $cliente[0]->cep,
                                    "complement" => $cliente[0]->complemento
                                )
                            )
                ));

                if (count($gerar["errors"]) > 0) {
                    $mensagem = 'Erro ao gerar cobrança. Verifique as informações no cadastro do paciente';
//            foreach ($gerar["errors"] as $item) {
////                echo $item;
//                
//            }
//                echo '<pre>';
//                var_dump($gerar);
//                die;
                } else {

                    $gravar = $this->guia->gravarintegracaoiugu($gerar["secure_url"], $gerar["id"], $paciente_contrato_parcelas_id);
                    $mensagem = 'Data alterada com sucesso';
                }
            }
        }


        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravaralterardatapagamentoconsultaavulsa($consulta_avulsa_id, $paciente_id, $contrato_id) {

        $this->guia->gravaralterardataconsultaavulsa($consulta_avulsa_id);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        if ($key != '') {
            $cliente = $this->paciente->listardados($paciente_id);

            $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
            $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
            $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);


            $pagamento_iugu = $this->paciente->listarpagamentosconsultaavulsaalterardata($consulta_avulsa_id);
            $data = date('d/m/Y', strtotime($pagamento_iugu[0]->data));

            $valor = $pagamento_iugu[0]->valor * 100;

            $description = $empresa[0]->nome . " - CONSULTA " . $pagamento_iugu[0]->tipo;

//            var_dump($pagamento_iugu);
//            die;
            Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
            if ($pagamento_iugu[0]->invoice_id != '') {
                $invoice = Iugu_Invoice::fetch($pagamento_iugu[0]->invoice_id);
                $invoice->cancel();

                $gerar = Iugu_Invoice::create(Array(
                            "email" => $cliente[0]->cns,
                            "due_date" => $data,
                            "items" => Array(
                                Array(
                                    "description" => $description,
                                    "quantity" => "1",
                                    "price_cents" => $valor
                                )
                            ),
                            "payer" => Array(
                                "cpf_cnpj" => $cliente[0]->cpf,
                                "name" => $cliente[0]->nome,
                                "phone_prefix" => $prefixo,
                                "phone" => $celular_s_prefixo,
                                "email" => $cliente[0]->cns,
                                "address" => Array(
                                    "street" => $cliente[0]->logradouro,
                                    "number" => $cliente[0]->numero,
                                    "city" => $cliente[0]->cidade_desc,
                                    "state" => $codigoUF,
                                    "district" => $cliente[0]->bairro,
                                    "country" => "Brasil",
                                    "zip_code" => $cliente[0]->cep,
                                    "complement" => $cliente[0]->complemento
                                )
                            )
                ));

                if (count($gerar["errors"]) > 0) {
                    $mensagem = 'Erro ao gerar cobrança. Verifique as informações no cadastro do paciente';
//            foreach ($gerar["errors"] as $item) {
////                echo $item;
//                
//            }
//                echo '<pre>';
//                var_dump($gerar);
//                die;
                } else {

                    $gravar = $this->guia->gravarintegracaoiuguconsultaavulsaalterardata($gerar["secure_url"], $gerar["id"], $consulta_avulsa_id);
                    $mensagem = 'Data alterada com sucesso';
                }
            }
        }


        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gerartodosiugu($paciente_id, $contrato_id) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa


        $pagamento = $this->paciente->listarpagamentoscontratoparcelaiugutodos($contrato_id);

        $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
//        echo '<pre>';
//        var_dump($pagamento);
//        die;
        foreach ($pagamento as $value) {
            $valor = $value->valor * 100;
            $data = date('d/m/Y', strtotime($value->data));
//        var_dump($prefixo); 
//        var_dump($celular_s_prefixo); 
            $description = $empresa[0]->nome . " - " . $value->plano;



            $gerar = Iugu_Invoice::create(Array(
                        "email" => $cliente[0]->cns,
                        "due_date" => $data,
                        "items" => Array(
                            Array(
                                "description" => $description,
                                "quantity" => "1",
                                "price_cents" => $valor
                            )
                        ),
                        "payer" => Array(
                            "cpf_cnpj" => $cpfcnpj,
                            "name" => $cliente[0]->nome,
                            "phone_prefix" => $prefixo,
                            "phone" => $celular_s_prefixo,
                            "email" => $cliente[0]->cns,
                            "address" => Array(
                                "street" => $cliente[0]->logradouro,
                                "number" => $cliente[0]->numero,
                                "city" => $cliente[0]->cidade_desc,
                                "state" => $codigoUF,
                                "district" => $cliente[0]->bairro,
                                "country" => "Brasil",
                                "zip_code" => $cliente[0]->cep,
                                "complement" => $cliente[0]->complemento
                            )
                        )
            ));

            if (count($gerar["errors"]) > 0) {
                $mensagem = 'Erro ao gerar pagamento: \n';
                foreach ($gerar["errors"] as $key => $item) {
//                var_dump($item[0]);
//                if(){
//                    
//                }
                    $mensagem = $mensagem . "$key $item[0]" . '\n';
                }

                break;
//                echo '<pre>';
//                var_dump($gerar);
//                die;
            } else {

                $gravar = $this->guia->gravarintegracaoiugu($gerar["secure_url"], $gerar["id"], $value->paciente_contrato_parcelas_id);
                $mensagem = 'Cobrança gerada com sucesso';
            }
        }

//        echo '<pre>';
//        die;
        //GERANDO A COBRANÇA
//        echo '<pre>';
//        var_dump($gerar);
//        die;
//        echo $mensagem;
//        die;
//        $this->session->set_flashdata('message', $mensagem);
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gerarpagamentoiugu($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {
        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

        $pagamento = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($paciente_contrato_parcelas_id);
        $valor = $pagamento[0]->valor * 100;
        $data = date('d/m/Y', strtotime($pagamento[0]->data));
//        var_dump($prefixo); 
//        var_dump($celular_s_prefixo); 
        $description = $empresa[0]->nome . " - " . $pagamento[0]->plano;
//        echo '<pre>';
        $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
//        var_dump($cpfcnpj); 
//        die;

        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
//        die;
        //GERANDO A COBRANÇA
        if (count($pagamento_iugu) == 0) {

            $gerar = Iugu_Invoice::create(Array(
                        "email" => $cliente[0]->cns,
                        "due_date" => $data,
                        "items" => Array(
                            Array(
                                "description" => $description,
                                "quantity" => "1",
                                "price_cents" => $valor
                            )
                        ),
                        "payer" => Array(
                            "cpf_cnpj" => $cpfcnpj,
                            "name" => $cliente[0]->nome,
                            "phone_prefix" => $prefixo,
                            "phone" => $celular_s_prefixo,
                            "email" => $cliente[0]->cns,
                            "address" => Array(
                                "street" => $cliente[0]->logradouro,
                                "number" => $cliente[0]->numero,
                                "city" => $cliente[0]->cidade_desc,
                                "state" => $codigoUF,
                                "district" => $cliente[0]->bairro,
                                "country" => "Brasil",
                                "zip_code" => $cliente[0]->cep,
                                "complement" => $cliente[0]->complemento
                            )
                        )
            ));

       echo '<pre>';
       print_r($gerar);
       die;
            if (count($gerar["errors"]) > 0) {
                $mensagem = 'Erro ao gerar pagamento: \n';
                foreach ($gerar["errors"] as $key => $item) {
//                var_dump($item[0]);
//                if(){
//                    
//                }
                    $mensagem = $mensagem . "$key $item[0]" . '\n';
                }
//                echo '<pre>';
//                var_dump($gerar);
//                die;
            } else {

                $gravar = $this->guia->gravarintegracaoiugu($gerar["secure_url"], $gerar["id"], $paciente_contrato_parcelas_id);
                $mensagem = 'Cobrança gerada com sucesso';
            }
        } else {
            $mensagem = 'Cobrança já gerada';
        }

//        echo $mensagem;
//        die;
//        $this->session->set_flashdata('message', $mensagem);
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gerarpagamentoiugucartao($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

        $pagamento = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($paciente_contrato_parcelas_id);
        $valor = $pagamento[0]->valor * 100;
        $data = date('d/m/Y', strtotime($pagamento[0]->data));
//        var_dump($prefixo); 
//        var_dump($celular_s_prefixo); 
        $description = $empresa[0]->nome . " - " . $pagamento[0]->plano;
//        echo '<pre>';
        $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
//        var_dump($cpfcnpj); 
//        die;

        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
//        die;
        //GERANDO A COBRANÇA
        if (count($pagamento_iugu) == 0) {

            $payment_token = Iugu_PaymentToken::create(Array(
                        'method' => 'credit_card',
                        'data' => Array(
                            'number' => '4111111111111111',
                            'verification_value' => '123',
                            'first_name' => 'Joao',
                            'last_name' => 'Silva',
                            'month' => '12',
                            'year' => date('Y'),
                        ),
                            )
            );

            $gerar = Iugu_Charge::create(
                            Array(
                                'token' => $payment_token,
                                "email" => $cliente[0]->cns,
                                'items' => Array(
                                    Array(
                                        "description" => $description,
                                        "quantity" => "1",
                                        "price_cents" => $valor
                                    )
                                ),
                                "payer" => Array(
                                    "cpf_cnpj" => $cpfcnpj,
                                    "name" => $cliente[0]->nome,
                                    "phone_prefix" => $prefixo,
                                    "phone" => $celular_s_prefixo,
                                    "email" => $cliente[0]->cns,
                                    "address" => Array(
                                        "street" => $cliente[0]->logradouro,
                                        "number" => $cliente[0]->numero,
                                        "city" => $cliente[0]->cidade_desc,
                                        "state" => $codigoUF,
                                        "district" => $cliente[0]->bairro,
                                        "country" => "Brasil",
                                        "zip_code" => $cliente[0]->cep,
                                        "complement" => $cliente[0]->complemento
                                    )
                                )
                            )
            );

            echo '<pre>';
            var_dump($payment_token);
            var_dump($gerar);
            die;

//        echo '<pre>';
//        var_dump($gerar);
//        die;
            if (count($gerar["errors"]) > 0) {
                $mensagem = 'Erro ao gerar pagamento: \n';
                foreach ($gerar["errors"] as $key => $item) {
//                var_dump($item[0]);
//                if(){
//                    
//                }
                    $mensagem = $mensagem . "$key $item[0]" . '\n';
                }
//                echo '<pre>';
//                var_dump($gerar);
//                die;
            } else {

                $gravar = $this->guia->gravarintegracaoiugu($gerar["url"], $gerar["invoice_id"], $paciente_contrato_parcelas_id);
                $mensagem = 'Cobrança gerada com sucesso';
            }
        } else {
            $mensagem = 'Cobrança já gerada';
        }

//        echo $mensagem;
//        die;
//        $this->session->set_flashdata('message', $mensagem);
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gerarpagamentoiuguconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id, $tipo) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

        $pagamento = $this->paciente->listarpagamentoscontratoconsultaavulsa($consultas_avulsas_id);
        $pagamento_iugu = $this->paciente->listarpagamentoscontratoconsultaavulsaiugu($consultas_avulsas_id);
        $valor = $pagamento[0]->valor * 100;
        $data = date('d/m/Y', strtotime($pagamento[0]->data));
//        var_dump($prefixo); 
//        var_dump($celular_s_prefixo); 
        if ($tipo == 'EXTRA') {
            $description = 'CONSULTA EXTRA';
        } else {
            $description = 'CONSULTA COPARTICIPAÇÃO';
        }

//        echo '<pre>';
//        var_dump($valor); 
//        die;
        $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);

        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
//        die;
        //GERANDO A COBRANÇA
        if ($pagamento_iugu[0]->invoice_id == '') {

            $gerar = Iugu_Invoice::create(Array(
                        "email" => $cliente[0]->cns,
                        "due_date" => $data,
                        "items" => Array(
                            Array(
                                "description" => $description,
                                "quantity" => "1",
                                "price_cents" => $valor
                            )
                        ),
                        "payer" => Array(
                            "cpf_cnpj" => $cpfcnpj,
                            "name" => $cliente[0]->nome,
                            "phone_prefix" => $prefixo,
                            "phone" => $celular_s_prefixo,
                            "email" => $cliente[0]->cns,
                            "address" => Array(
                                "street" => $cliente[0]->logradouro,
                                "number" => $cliente[0]->numero,
                                "city" => $cliente[0]->cidade_desc,
                                "state" => $codigoUF,
                                "district" => $cliente[0]->bairro,
                                "country" => "Brasil",
                                "zip_code" => $cliente[0]->cep,
                                "complement" => $cliente[0]->complemento
                            )
                        )
            ));

//        echo '<pre>';
//        var_dump($gerar);
//        die;
            if (count($gerar["errors"]) > 0) {
                $mensagem = 'Erro ao gerar pagamento: \n';
                foreach ($gerar["errors"] as $key => $item) {
                    $mensagem = $mensagem . "$key $item[0]" . '\n';
                }
//                echo '<pre>';
//                var_dump($gerar);
//                die;
            } else {

                $gravar = $this->guia->gravarintegracaoiuguconsultaavulsa($gerar["secure_url"], $gerar["id"], $consultas_avulsas_id);
                $mensagem = 'Cobrança gerada com sucesso';
            }
        } else {
            $mensagem = 'Cobrança já gerada';
        }

//        echo $mensagem;
//        die;
//        $this->session->set_flashdata('message', $mensagem);
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        if ($tipo == 'EXTRA') {
            redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id");
        } else {
            redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultacoop/$paciente_id/$contrato_id");
        }
    }

    function apagarpagamentoiugu($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

        $pagamento = $this->paciente->listarpagamentoscontratoparcelaapagariugu($paciente_contrato_parcelas_id);
//        echo '<pre>';
//        var_dump($prefixo); 
//        var_dump($celular_s_prefixo); 


        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
//      APAGAR COBRANÇA
        $invoice = Iugu_Invoice::fetch($pagamento[0]->invoice_id);
//        $invoice->cancel();
        echo '<pre>';
        var_dump($invoice);
        die;
//        die;
        //GERANDO A COBRANÇA
//        var_dump($gerar);
//        die;
        if (count($gerar["errors"]) > 0) {
            foreach ($gerar["errors"] as $item) {
//                echo $item;
                $mensagem = 'Erro ao gerar cobrança. Verifique as informações no cadastro do paciente';
            }
        } else {

            $gravar = $this->guia->gravarintegracaoiugu($gerar["url"], $gerar["pdf"], $gerar["invoice_id"], $paciente_contrato_parcelas_id);
            $mensagem = 'Cobrança gerada com sucesso';
        }



//        echo $mensagem;
//        die;
//        $this->session->set_flashdata('message', $mensagem);
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gravarconsultaavulsa($paciente_id, $contrato_id) {
        $ambulatorio_guia_id = $this->guia->gravarconsultaavulsa($paciente_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar consulta avulsa.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar consulta avulsa.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id");
    }

    function gravarconsultacoop($paciente_id, $contrato_id) {
        $ambulatorio_guia_id = $this->guia->gravarconsultacoop($paciente_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar consulta coop.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar consulta coop.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultacoop/$paciente_id/$contrato_id");
    }

    function gravarnovaparcelacontrato($paciente_id, $contrato_id) {
        $ambulatorio_guia_id = $this->guia->gravarnovaparcelacontrato($paciente_id, $contrato_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar consulta avulsa.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar consulta avulsa.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gravarcartaoclienteiugu($paciente_id, $contrato_id) {

//        echo '<pre>';
//        var_dump($_POST);
//        die;
        if (isset($_POST['deletarBoleto'])) {
            // Deleta os boletos futuros para na função seguinte as parcelas serem associadas ao cartão

            $pagamentos_cancelar = $this->guia->listarcancelarparcelaiugu($paciente_id, $contrato_id);
            $empresa = $this->guia->listarempresa();
            $key = $empresa[0]->iugu_token;
            Iugu::setApiKey($key);
            foreach ($pagamentos_cancelar as $item) {
                $invoice = Iugu_Invoice::fetch($item->invoice_id);
                $invoice->cancel();
            }
        }

        $ambulatorio_guia_id = $this->guia->gravarcartaoclienteiugu($paciente_id, $contrato_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar cartão.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar cartão.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function excluircontrato($paciente_id, $contrato_id) {
//   

        $ambulatorio_guia_id = $this->guia->excluircontrato($paciente_id, $contrato_id);

        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function excluircontratoadmin($paciente_id, $contrato_id) {
//        var_dump($contrato_id); die;


        $ambulatorio_guia_id = $this->guia->excluircontratoadmin($paciente_id, $contrato_id);

        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function ativarcontrato($paciente_id, $contrato_id) {
//        var_dump($contrato_id); die;
        $ambulatorio_guia_id = $this->guia->ativarcontrato($paciente_id, $contrato_id);

        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function excluirparcelacontrato($paciente_id, $contrato_id, $parcela_id) {

        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($parcela_id);

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;

//        var_dump($pagamento_iugu);
//        die;
        if ($key != '' && count($pagamento_iugu) > 0) {
            if ($pagamento_iugu[0]->invoice_id != '') {
                Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
                $retorno = Iugu_Invoice::fetch($pagamento_iugu[0]->invoice_id);
                $retorno->cancel();
            }
        }
//        die('morreu');
        $ambulatorio_guia_id = $this->guia->excluirparcelacontrato($paciente_id, $contrato_id, $parcela_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao excluir parcela';
        } else {
            $data['mensagem'] = 'Sucesso ao excluir parcela.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function excluirconsultaavulsa($paciente_id, $contrato_id, $consulta_id) {
        $ambulatorio_guia_id = $this->guia->excluirconsultaavulsa($consulta_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar consulta avulsa.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar consulta avulsa.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id");
    }

    function gravar($paciente_id) {
        $ambulatorio_guia_id = $this->guia->gravar($paciente_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Sala. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Sala.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $this->novo($data);
    }

    function gravarplano() {
        $paciente_id = $_POST['txtpaciente'];
        $paciente = $this->guia->gravarplano($paciente_id);
        $paciente_contrato_id = $this->guia->gravarplanoparcelas($paciente_id);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id/$paciente_contrato_id");
    }

    function novocontratovalor($paciente_id, $paciente_contrato_id) {
        $data['planos'] = $this->formapagamento->listarforma();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['paciente_contrato_id'] = $paciente_contrato_id;

        $plano_id = $data['paciente'][0]->plano_id;
        $data['plano_id'] = $plano_id;
        $data['forma_pagamento'] = $this->paciente->listaforma_pagamento($plano_id);
        $this->load->View('ambulatorio/novocontratovalor-form', $data);
    }

    function gravarplanovalor() {
        $paciente_id = $_POST['txtpaciente'];
        $ambulatorio_guia_id = $this->guia->gravarvalorplano($paciente_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a contrato. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a contrato.';
        }

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravardependentes() {
        $paciente_id = $_POST['txtpaciente_id'];
        $contrato_id = $_POST['txtcontrato_id'];
        $ambulatorio_guia_id = $this->guia->gravardependentes($paciente_id, $contrato_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a dependente. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a dependente.';
        }
        redirect(base_url() . "ambulatorio/guia/listardependentes/$paciente_id/$contrato_id");
    }

    function fecharcaixa() {
        $caixa = $this->guia->fecharcaixa();
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar caixa. Opera&ccedil;&atilde;o cancelada.';
        } elseif ($caixa == 10) {
            $data['mensagem'] = 'Erro ao fechar caixa. Forma de pagamento não configurada corretamente.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar caixa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
    }

    function fecharmedico() {
        $caixa = $this->guia->fecharmedico();
        if ($caixa == "-1") {
            $data['mensagem'] = 'Erro ao fechar caixa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao fechar caixa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
    }

    function gravarprocedimentos() {
        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['medico1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novo/$paciente_id");
            }
        } else {
            $medico_id = $_POST['crm1'];
            $paciente_id = $_POST['txtpaciente_id'];
            $resultadoguia = $this->guia->listarguia($paciente_id);
            if ($_POST['medicoagenda'] != '') {
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
                $this->guia->gravarexames($ambulatorio_guia, $medico_id);
            }
            redirect(base_url() . "ambulatorio/guia/novo/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarprocedimentosgeral() {

        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id");
            }
        } else {
            $medico_id = $_POST['crm1'];
            $resultadoguia = $this->guia->listarguia($paciente_id);
            if ($_POST['medicoagenda'] != '') {
//        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
//            $this->gerardicom($ambulatorio_guia);
                $tipo = $this->guia->verificaexamemedicamento($_POST['procedimento1']);
                if (($tipo == 'EXAME' || $tipo == 'MEDICAMENTO') && $medico_id == '') {
                    $data['mensagem'] = 'ERRO: Obrigatório preencher solicitante.';
                    $this->session->set_flashdata('message', $data['mensagem']);
                } else {
                    $this->guia->gravaratendimemto($ambulatorio_guia, $medico_id);
                }
            }
//        $this->novo($paciente_id, $ambulatorio_guia);
            redirect(base_url() . "ambulatorio/guia/novoatendimento/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarorcamento() {

        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['procedimento1'] == '' || $_POST['convenio1'] == '-1' || $_POST['qtde1'] == '') {
            $data['mensagem'] = 'Informe o convenio, o procedimento e a quantidade.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id");
        } else {
            $resultadoorcamento = $this->guia->listarorcamento($paciente_id);
            //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            if ($resultadoorcamento == null) {
                $ambulatorio_orcamento = $this->guia->gravarorcamento($paciente_id);
            } else {
                $ambulatorio_orcamento = $resultadoorcamento['ambulatorio_orcamento_id'];
            }
            //            $this->gerardicom($ambulatorio_guia);
            $this->guia->gravarorcamentoitem($ambulatorio_orcamento);
            //        $this->novo($paciente_id, $ambulatorio_guia);
            redirect(base_url() . "ambulatorio/guia/orcamento/$paciente_id/$ambulatorio_orcamento");
        }
    }

    function gravarprocedimentosconsulta() {

        $paciente_id = $_POST['txtpaciente_id'];

        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['qtde1'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {

            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id");
            }
        } else {
            $resultadoguia = $this->guia->listarguia($paciente_id);
            if ($_POST['medicoagenda'] != '') {
                //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                if ($resultadoguia == null) {
                    $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                } else {
                    $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                }
                $this->guia->gravarconsulta($ambulatorio_guia);
            }
            //        $this->gerardicom($ambulatorio_guia);
            $this->session->set_flashdata('message', $data['mensagem']);
            //        $this->novo($paciente_id, $ambulatorio_guia);
            redirect(base_url() . "ambulatorio/guia/novoconsulta/$paciente_id/$ambulatorio_guia");
        }
    }

    function gravarprocedimentosfisioterapia() {

        $i = 1;
        $paciente_id = $_POST['txtpaciente_id'];
        if ($_POST['sala1'] == '' || $_POST['medicoagenda'] == '' || $_POST['convenio1'] == -1 || $_POST['procedimento1'] == '') {
            $data['mensagem'] = 'Insira os campos obrigatorios.';
            $this->session->set_flashdata('message', $data['mensagem']);
            if (isset($_POST['guia_id'])) {
                $guia_id = $_POST['guia_id'];
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$guia_id");
            } else {
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id");
            }
        } else {
            $resultadoguia = $this->guia->listarguia($paciente_id);

            //verifica se existem sessões abertas
            $retorno = $this->guia->verificasessoesabertas($_POST['procedimento1'], $_POST['txtpaciente_id']);

            if ($retorno == false) {
                if ($_POST['medicoagenda'] != '') {
                    //        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                    if ($resultadoguia == null) {
                        $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
                    } else {
                        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                    }
                    $this->guia->gravarfisioterapia($ambulatorio_guia);
                }
                //        $this->gerardicom($ambulatorio_guia);
                //            $this->session->set_flashdata('message', $data['mensagem']);
                //        $this->novo($paciente_id, $ambulatorio_guia);
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia/$messagem/$i");
            } else {
                $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
                $messagem = 'Não autorizado, existem sessões abertas para essa especialidade';
                $this->session->set_flashdata('message', $messagem);
                redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia");
            }
        }
    }

    function gravarprocedimentospsicologia() {
        $i = 1;
        $paciente_id = $_POST['txtpaciente_id'];
        $resultadoguia = $this->guia->listarguia($paciente_id);
        if ($_POST['medicoagenda'] != '') {
//        $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            if ($resultadoguia == null) {
                $ambulatorio_guia = $this->guia->gravarguia($paciente_id);
            } else {
                $ambulatorio_guia = $resultadoguia['ambulatorio_guia_id'];
            }
            $this->guia->gravarpsicologia($ambulatorio_guia);
        }
//        $this->gerardicom($ambulatorio_guia);
        $this->session->set_flashdata('message', $data['mensagem']);
//        $this->novo($paciente_id, $ambulatorio_guia);
        redirect(base_url() . "ambulatorio/guia/novofisioterapia/$paciente_id/$ambulatorio_guia/$messagem/$i");
    }

    function gravarprocedimentosfaturamento() {

        $guia_id = $_POST['txtguia_id'];
        $paciente_id = $_POST['txtpaciente_id'];
        $this->guia->gravarexamesfaturamento();
        redirect(base_url() . "ambulatorio/exame/faturarguia/$guia_id/$paciente_id");
    }

    function editarexames() {
        $paciente_id = $_POST['txtpaciente_id'];
        $ambulatorio_guia_id = $this->guia->editarexames();
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Dados. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Dados.';
        }
        $this->pesquisar($paciente_id);
    }

    function editarexame($paciente_id, $guia_id, $ambulatorio_guia_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['operadores'] = $this->operador_m->listaroperadores();
        $data['salas'] = $this->guia->listarsalas();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['selecionado'] = $this->guia->editarexamesselect($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/editarexame-form', $data);
    }

    function valorexames() {
        $paciente_id = $_POST['txtpaciente_id'];
        $ambulatorio_guia_id = $this->guia->valorexames();
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Dados. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Dados.';
        }
        $this->pesquisar($paciente_id);
    }

    function valorexame($paciente_id, $guia_id, $ambulatorio_guia_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['guia_id'] = $guia_id;
        $this->loadView('ambulatorio/valorexame-form', $data);
    }

    function orcamento($paciente_id, $ambulatorio_orcamento_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listarorcamentos($paciente_id);
        $data['ambulatorio_orcamento_id'] = $ambulatorio_orcamento_id;
        $this->loadView('ambulatorio/orcamento-form', $data);
    }

    function listardependentes($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
//        echo "<pre>";
//        var_dump($data['lista']); die;
        $data['listacadastro'] = $this->paciente->listardependentescontrato($contrato_id);
        $data['contrato_id'] = $paciente_id;
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function listarpagamentos($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontrato($contrato_id);
        $data['listarpagamentosconsultaextra'] = $this->paciente->listarpagamentosconsultaavulsa($paciente_id);
        $data['listarpagamentosconsultacoop'] = $this->paciente->listarpagamentosconsultacoop($paciente_id);
        $data['historicoconsultasrealizadas'] = $this->paciente->listarhistoricoconsultasrealizadas($contrato_id);
//        echo "<pre>";
//        var_dump($data['historicoconsultasrealizadas']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/guiapagamento-form', $data);
    }

    function listarpagamentosconsultaavulsa($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentosconsultaavulsa($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/guiaconsultaavulsapagamento-form', $data);
    }

    function listarpagamentosconsultacoop($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentosconsultacoop($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/guiaconsultacooppagamento-form', $data);
    }

    function criarconsultacoop($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentosconsultacoop($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/criarconsultacooppagamento-form', $data);
    }

    function criarconsultaavulsa($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentosconsultaavulsa($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/criarconsultaavulsapagamento-form', $data);
    }

    function criarparcelacontrato($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentosconsultaavulsa($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/criarparcelacontrato-form', $data);
    }

    function pagamentocartaoiugu($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['cartao'] = $this->paciente->listarcartaocliente($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/pagamentocartaoiugu-form', $data);
    }

    function integracaoiugu($paciente_id, $contrato_id) {
        header('Access-Control-Allow-Origin: *');
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontrato($contrato_id);
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/integracaoiugu-form', $data);
    }

    function novoconsulta($paciente_id, $ambulatorio_guia_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);

        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiaconsulta-form', $data);
    }

    function novofisioterapia($paciente_id, $ambulatorio_guia_id = null, $i = null) {
//        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
//        if (count($lista) == 0) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);

        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiafisioterapia-form', $data);
//        } else {
//            $data['mensagem'] = 'Paciente com sessões pendentes.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//        }
    }

    function novoatendimento($paciente_id, $ambulatorio_guia_id = null) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['salas'] = $this->guia->listarsalas();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['grupo_pagamento'] = $this->formapagamento->listargrupos();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaraexamespaciente($ambulatorio_guia_id);

        $data['x'] = 0;
        foreach ($data['exames'] as $value) {
            $teste = $this->exametemp->verificaprocedimentosemformapagamento($value->procedimento_tuss_id);
            if (empty($teste)) {
                $data['x'] ++;
            }
        }

        $data['contador'] = $this->exametemp->contadorexamespaciente($ambulatorio_guia_id);
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $this->loadView('ambulatorio/guiaatendimento-form', $data);
    }

    function faturar($agenda_exames_id, $procedimento_convenio_id) {
        $data['forma_pagamento'] = $this->guia->formadepagamentoprocedimento($procedimento_convenio_id);
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturar-form', $data);
    }

    function faturarconvenio($agenda_exames_id) {
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturarconvenio-form', $data);
    }

    function alterardata($agenda_exames_id) {
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/alterardata-form', $data);
    }

    function gravaralterardata($agenda_exames_id) {
        $this->guia->gravaralterardata($agenda_exames_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function faturamentodetalhes($agenda_exames_id) {
        $data['exame'] = $this->guia->listarexame($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturamentodetalhe-form', $data);
    }

    function gravarfaturar($agenda_exames_id) {
        $this->guia->gravarfaturamento($agenda_exames_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/faturar-form', $data);
    }

    function gravarfaturado() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamento();
            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoconvenio() {

        $this->guia->gravarfaturamentoconvenio();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function gravarfaturamentodetalhe() {

        $this->guia->gravarfaturamentodetalhe();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function faturarguia($guia_id, $financeiro_grupo_id = null) {
        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->guia->formadepagamentoguia($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['exame1'] = $this->guia->listarexameguia($guia_id);
            $data['exame2'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturarguia-form', $data);
    }

    function faturarguias($guia_id) {
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['exame'] = $this->guia->listarexameguia($guia_id);
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturarguiaconvenio-form', $data);
    }

    function faturarguiacaixa($guia_id, $financeiro_grupo_id = null) {

        if (isset($financeiro_grupo_id)) {
            $data['forma_pagamento'] = $this->guia->formadepagamentoguia($guia_id, $financeiro_grupo_id);
            $data['exame'] = $this->guia->listarexameguianaofaturadoforma($guia_id, $financeiro_grupo_id);
        } else {
            $data['forma_pagamento'] = $this->guia->formadepagamento();
            $data['exame1'] = $this->guia->listarexameguia($guia_id);
            $data['exame2'] = $this->guia->listarexameguiaforma($guia_id, $financeiro_grupo_id);
            $data['exame'][0]->total = $data['exame1'][0]->total - $data['exame2'][0]->total;
        }

        $data['financeiro_grupo_id'] = $financeiro_grupo_id;
        $data['paciente'] = $this->guia->listarexameguiacaixa($guia_id);
        $data['guia_id'] = $guia_id;
        $data['valor'] = 0.00;
        $this->load->View('ambulatorio/faturarguiacaixa-form', $data);
    }

    function faturarfinanceiro() {
        $this->load->View('ambulatorio/faturarguia-form', $data);
    }

    function gravarfaturadoguia() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamentototal();
            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoguiaconvenio() {

        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $ambulatorio_guia_id = $this->guia->gravarfaturamentototalconvenio();
            if ($ambulatorio_guia_id == "-1") {
                $data['mensagem'] = 'Erro ao gravar faturamento. Opera&ccedil;&atilde;o cancelada.';
            } else {
                $data['mensagem'] = 'Sucesso ao gravar faturamento.';
            }

            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function gravarfaturadoguiacaixa() {

        $guia_id = $_POST['guia_id'];
        $exame = $_POST['exame'];
        $paciente = $_POST['paciente'];
        $resulta = $_POST['valortotal'];
        if ($resulta == "0.00") {
            $this->guia->gravarfaturamentototalnaofaturado();
            redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente");
        } else {
            $this->load->View('ambulatorio/erro');
        }
    }

    function relatorioexame() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconferencia', $data);
    }

    function relatorioexamesala() {
        $data['salas'] = $this->sala->listarsalas();
        $this->loadView('ambulatorio/relatorioexamesala', $data);
    }

    function relatoriopacieneteexame() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriopacienteconvenioexame', $data);
    }

    function gerarelatorioexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['procedimentos'] = $_POST['procedimentos'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $medicos = $_POST['medico'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        if ($_POST['procedimentos'] != '0') {
            $data['procedimentos'] = $this->guia->selecionarprocedimentos($_POST['procedimentos']);
        }
        $data['relatorio'] = $this->guia->relatorioexamesconferencia();
        $this->load->View('ambulatorio/impressaorelatorioconferencia', $data);
    }

    function gerarelatorioexamesala() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['salas'] = $_POST['salas'];
        if ($_POST['salas'] != '0') {
            $data['sala'] = $this->sala->listarsala($_POST['salas']);
        }
        $data['relatorio'] = $this->guia->relatorioexamesala();

        $this->load->View('ambulatorio/impressaorelatorioexamesala', $data);
    }

    function gerarelatoriogeralsintetico() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->load->View('ambulatorio/impressaorelatoriogeralsintetico', $data);
    }

    function relatorioexamech() {
        $data['grupo'] = $this->guia->listargrupo();
        $data['procedimentos'] = $this->guia->listarprocedimentos();
        $data['convenio'] = $this->convenio->listardados();
        $data['classificacao'] = $this->guia->listarclassificacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconferenciach', $data);
    }

    function gerarelatorioexamech() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamescontador();
        $data['relatorio'] = $this->guia->relatorioexames();
        $this->load->View('ambulatorio/impressaorelatorioconferenciach', $data);
    }

    function relatoriocancelamento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocancelamento', $data);
    }

    function relatoriotempoesperaexame() {

        $this->loadView('ambulatorio/relatoriotempoesperaexame');
    }

    function relatoriotemposalaespera() {

        $this->loadView('ambulatorio/relatoriotemposalaespera');
    }

    function gerarelatoriotempoesperaexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->gerarelatoriotempoesperaexame();
        $this->load->View('ambulatorio/impressaorelatoriotempoesperaexame', $data);
    }

    function gerarelatoriotemposalaespera() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        } else {
            $data['convenios'] = 0;
        }
        $data['listar'] = $this->exame->gerarelatoriotemposalaespera();
        $this->load->View('ambulatorio/impressaorelatoriotemposalaespera', $data);
    }

    function gerarelatoriocancelamento() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatoriocancelamentocontador();
        $data['relatorio'] = $this->guia->relatoriocancelamento();
        $this->load->View('ambulatorio/impressaorelatoriocancelamento', $data);
    }

    function gerarelatoriopacienteconvenioexame() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatorioexames();
        $this->load->View('ambulatorio/impressaorelatoriopacienteconvenioexame', $data);
    }

    function relatoriogrupo() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupo', $data);
    }

    function relatoriogrupoanalitico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupoanalitico', $data);
    }

    function relatoriogrupoprocedimento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioexamegrupoprocedimento', $data);
    }

    function relatoriogrupoprocedimentomedico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriogrupoprocedimentomedico', $data);
    }

    function gerarelatoriogrupo() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupo();
        $this->load->View('ambulatorio/impressaorelatoriogrupo', $data);
    }

    function gerarelatoriogrupoprocedimento() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupoprocedimento();
        $this->load->View('ambulatorio/impressaorelatoriogrupoprocedimento', $data);
    }

    function gerarelatoriogrupoprocedimentomedico() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['relatorio'] = $this->guia->relatoriogrupoprocedimentomedico();
        $this->load->View('ambulatorio/impressaorelatoriogrupoprocedimento', $data);
    }

    function gerarelatoriogrupoanalitico() {
        $data['conveniotipo'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $data['contador'] = $this->guia->relatorioexamesgrupocontador();
        $data['relatorio'] = $this->guia->relatorioexamesgrupoanalitico();
        $this->load->View('ambulatorio/impressaorelatoriogrupoanalitico', $data);
    }

    function relatoriofaturamentorm() {
        $data['convenio'] = $this->convenio->listardados();
        $this->loadView('ambulatorio/relatorioexamefaturamentorm', $data);
    }

    function gerarelatoriofaturamentorm() {
        $data['convenio'] = $_POST['convenio'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['contador'] = $this->guia->relatorioexamesfaturamentormcontador();
        $data['relatorio'] = $this->guia->relatorioexamesfaturamentorm();
        $this->load->View('ambulatorio/impressaorelatoriofaturamentorm', $data);
    }

    function relatoriogeralconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriogeralconvenio', $data);
    }

    function gerarelatoriogeralconvenio() {
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }

        $data['contador'] = $this->guia->relatoriogeralconveniocontador();
        $data['relatorio'] = $this->guia->relatoriogeralconvenio();

        $this->load->View('ambulatorio/impressaorelatoriogeralconvenio', $data);
    }

    function relatorioresumogeral() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioresumogeral', $data);
    }

    function gerarelatorioresumogeral() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['medico'] = $this->guia->relatorioresumogeral();
        $data['medicorecebido'] = $this->guia->relatorioresumogeralmedico();
        $data['convenio'] = $this->guia->relatorioresumogeralconvenio();
        $data['convenios'] = $this->convenio->listardados();

        $this->load->View('ambulatorio/impressaorelatorioresumogeral', $data);
    }

    function relatoriomedicosolicitante() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitante', $data);
    }

    function gerarelatoriomedicosolicitante() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontador();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitante();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitante', $data);
    }

    function relatoriomedicosolicitantexmedico() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitantexmedico', $data);
    }

    function gerarelatoriomedicosolicitantexmedico() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorxmedico();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitantexmedico();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitantexmedico', $data);
    }

    function relatoriomedicosolicitantexmedicoindicado() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicosolicitantexmedicoindicado', $data);
    }

    function gerarelatoriomedicosolicitantexmedicoindicado() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorxmedicoindicado();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitantexmedicoindicado();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitantexmedico', $data);
    }

    function relatoriolaudopalavra() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriolaudopalavra', $data);
    }

    function gerarelatoriolaudopalavra() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['palavra'] = $_POST['palavra'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriolaudopalavracontador();
        $data['relatorio'] = $this->guia->relatoriolaudopalavra();
        $this->load->View('ambulatorio/impressaorelatoriolaudopalavra', $data);
    }

    function relatoriomedicosolicitanterm() {
        $data['medicos'] = $this->operador_m->listarmedicossolicitante();
        $this->loadView('ambulatorio/relatoriomedicosolicitanterm', $data);
    }

    function gerarelatoriomedicosolicitanterm() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['contador'] = $this->guia->relatoriomedicosolicitantecontadorrm();
        $data['relatorio'] = $this->guia->relatoriomedicosolicitanterm();
        $this->load->View('ambulatorio/impressaorelatoriomedicosolicitanterm', $data);
    }

    function relatoriomedicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconvenio', $data);
    }

    function relatoriorecepcaomedicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriorecepcaomedicoconvenio', $data);
    }

    function relatorioconvenioquantidade() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioconvenioquantidade', $data);
    }

    function relatorioaniversariante() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioaniversariante', $data);
    }

    function relatorioconveniovalor() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioconveniovalor', $data);
    }

    function relatorioconsultaconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioconsultaconvenio', $data);
    }

    function relatoriomedicoconveniorm() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $this->loadView('ambulatorio/relatoriomedicoconveniorm', $data);
    }

    function gerarelatoriomedicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriomedicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconvenio', $data);
    }

    function gerarelatoriorecepcaomedicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriomedicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriorecepcaomedicoconvenio', $data);
    }

    function relatoriotecnicoconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriotecnicoconvenio', $data);
    }

    function relatorioindicacao() {
        $data['indicacao'] = $this->paciente->listaindicacao();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorioindicacao', $data);
    }

    function relatorionotafiscal() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatorionotafiscal', $data);
    }

    function relatoriovalormedio() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriovalormedio', $data);
    }

    function relatoriocomissao() {
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $this->loadView('ambulatorio/relatoriocomissao', $data);
    }

    function relatoriocomissaorepresentante() {
        $data['listarvendedor'] = $this->operador_m->listarRepresentantevendasrelatorio();
        $this->loadView('ambulatorio/relatoriocomissaorepresentante', $data);
    }

    function relatoriocomissaovendedor() {
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $this->loadView('ambulatorio/relatoriocomissaovendedor', $data);
    }

    function relatoriocomissaogerente() {
        $data['listarvendedor'] = $this->operador_m->listargerentevendasrelatorio();
        $this->loadView('ambulatorio/relatoriocomissaogerente', $data);
    }

    function relatoriocomissaoseguradora() {
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $this->loadView('ambulatorio/relatoriocomissaoseguradora', $data);
    }

    function gerarelatoriotecnicoconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $tecnicos = $_POST['tecnicos'];
        $data['verificatecnicos'] = $_POST['tecnicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['tecnico'] = $this->operador_m->listarCada($tecnicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriotecnicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriotecnicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriotecnicoconvenio', $data);
    }

    function gerarelatorioindicacao() {

        if ($_POST['indicacao'] != '0') {
            $data['indicacao'] = $this->guia->listacadaindicacao($_POST['indicacao']);
        } else {
            $data['indicacao'] = '0';
        }
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatorioindicacao();
        $data['consolidado'] = $this->guia->relatorioindicacaoconsolidado();
        $this->load->View('ambulatorio/impressaorelatorioindicacao', $data);
    }

    function gerarelatorionotafiscal() {

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatorionotafiscal();
        $this->load->View('ambulatorio/impressaorelatorionotafiscal', $data);
    }

    function gerarelatoriovalormedio() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriovalormedio();
        $data['convenio'] = $this->guia->relatoriovalormedioconvenio();
        $this->load->View('ambulatorio/impressaorelatoriovalormedio', $data);
    }

    function gerarelatoriocomissao() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissao();
        $data['relatorio_forma'] = $this->guia->relatoriocomissaoContadorForma();
        // echo '<pre>';
        // var_dump($data['relatorio_forma']); die;
        $this->load->View('ambulatorio/impressaorelatoriocomissao', $data);
    }

    function gerarelatoriocomissaorepresentante() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaorepresentante();
        // $data['relatorio_forma'] = $this->guia->relatoriocomissaoContadorForma();
        // echo '<pre>';
        // var_dump($data['relatorio']); die;
        $this->load->View('ambulatorio/impressaorelatoriocomissaorepresentante', $data);
    }

    function gerarelatoriocomissaoseguradora() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaoseguradora();
        $this->load->View('ambulatorio/impressaorelatoriocomissaoseguradora', $data);
    }

    function gerarelatoriocomissaovendedor() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
//        var_dump($_POST); die;
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaovendedor();
        // $data['relatorio_forma'] = $this->guia->relatoriocomissaovendedorFormaRend();
        // echo '<pre>'; 
        // var_dump($data['relatorio_forma']);
        // die;
        $this->load->View('ambulatorio/impressaorelatoriocomissaovendedor', $data);
    }

    function gerarelatoriocomissaogerente() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
//        var_dump($_POST); die;
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaogerente();
        $this->load->View('ambulatorio/impressaorelatoriocomissaogerente', $data);
    }

//    function gerarelatoriocomissaoseguradora() {
//        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
//        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
////        var_dump($_POST); die;
//        $data['vendedor'] = $this->guia->listarvendedor($_POST['seguradora']);
//        $data['relatorio'] = $this->guia->relatoriocomissaoseguradora();
//        $this->load->View('ambulatorio/impressaorelatoriocomissaoseguradora', $data);
//    }

    function relatoriotecnicoconveniosintetico() {
        $data['convenio'] = $this->convenio->listardados();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriotecnicoconveniosintetico', $data);
    }

    function gerarelatoriotecnicoconveniosintetico() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $tecnicos = $_POST['tecnicos'];
        $data['verificatecnicos'] = $_POST['tecnicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['tecnico'] = $this->operador_m->listarCada($tecnicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriotecnicoconveniocontador();
        $data['relatorio'] = $this->guia->relatoriotecnicoconvenio();
        $this->load->View('ambulatorio/impressaorelatoriotecnicoconveniosintetico', $data);
    }

    function gerarelatorioconvenioquantidade() {
        $database = date("d-m-Y");
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $atendidos = $this->guia->relatorioconvenioexamesatendidos();
            $naoatendidos = $this->guia->relatorioconvenioexamesnaoatendidos();
            $atendidosdatafim = $this->guia->relatorioconvenioexamesatendidosdatafim();
            $naoatendidosdatafim = $this->guia->relatorioconvenioexamesnaoatendidosdatafim();
            $data['atendidos'] = count($atendidos) + count($atendidosdatafim);
            $data['naoatendidos'] = count($naoatendidos) + count($naoatendidosdatafim);
        } else {
            $atendidos = $this->guia->relatorioconvenioexamesatendidos2();
            $data['atendidos'] = count($atendidos);
            $naoatendidos = $this->guia->relatorioconvenioexamesnaoatendidos2();
            $data['naoatendidos'] = count($naoatendidos);
        }
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $consultasatendidos = $this->guia->relatorioconvenioconsultasatendidos();
            $consultasnaoatendidos = $this->guia->relatorioconvenioconsultasnaoatendidos();
            $consultasatendidosdatafim = $this->guia->relatorioconvenioconsultasatendidosdatafim();
            $consultasnaoatendidosdatafim = $this->guia->relatorioconvenioconsultasnaoatendidosdatafim();
            $data['consultasatendidos'] = count($consultasatendidos) + count($consultasatendidosdatafim);
            $data['consultasnaoatendidos'] = count($consultasnaoatendidos) + count($consultasnaoatendidosdatafim);
        } else {
            $consultasatendidos = $this->guia->relatorioconvenioconsultasatendidos2();
            $data['consultasatendidos'] = count($consultasatendidos);
            $consultasnaoatendidos = $this->guia->relatorioconvenioconsultasnaoatendidos2();
            $data['consultasnaoatendidos'] = count($consultasnaoatendidos);
        }
        $this->load->View('ambulatorio/impressaorelatorioconvenioquantidadeconsolidado', $data);
    }

    function gerarelatorioconveniovalor() {
        $database = date("Y-m-d");
        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $data['atendidos'] = $this->guia->relatorioconvenioexamesatendidos();
            $data['naoatendidos'] = $this->guia->relatorioconvenioexamesnaoatendidos();
            $data['atendidosdatafim'] = $this->guia->relatorioconvenioexamesatendidosdatafim();
            $data['naoatendidosdatafim'] = $this->guia->relatorioconvenioexamesnaoatendidosdatafim();
        } else {
            $data['atendidos'] = $this->guia->relatorioconvenioexamesatendidos2();
            $data['naoatendidos'] = $this->guia->relatorioconvenioexamesnaoatendidos2();
        }
        if ((strtotime($datainicio) < strtotime($database)) && (strtotime($datafim) > strtotime($database))) {
            $data['consultasatendidos'] = $this->guia->relatorioconvenioconsultasatendidos();
            $data['consultasnaoatendidos'] = $this->guia->relatorioconvenioconsultasnaoatendidos();
            $data['consultasatendidosdatafim'] = $this->guia->relatorioconvenioconsultasatendidosdatafim();
            $data['consultasnaoatendidosdatafim'] = $this->guia->relatorioconvenioconsultasnaoatendidosdatafim();
        } else {
            $data['consultasatendidos'] = $this->guia->relatorioconvenioconsultasatendidos2();
            $data['consultasnaoatendidos'] = $this->guia->relatorioconvenioconsultasnaoatendidos2();
        }
        $this->load->View('ambulatorio/impressaorelatorioconveniovalor', $data);
    }

    function gerarelatorioconsultaconvenio() {

        $data['listarconvenio'] = $this->convenio->listardadosconvenios();
        if ($_POST['convenio'] != '') {
            $data['convenios'] = $this->guia->listardados($_POST['convenio']);
        }
        $medicos = $_POST['medicos'];
        $data['verificamedico'] = $_POST['medicos'];
        $data['convenio'] = $_POST['convenio'];
        $data['grupo'] = $_POST['grupo'];
        $data['medico'] = $this->operador_m->listarCada($medicos);

        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatorioconsultaconveniocontador();
        $data['relatorio'] = $this->guia->relatorioconsultaconvenio();
        $this->load->View('ambulatorio/impressaorelatorioconsultaconvenio', $data);
    }

    function gerarelatoriomedicoconveniorm() {
        $medicos = $_POST['medicos'];
        $data['medico'] = $this->operador_m->listarCada($medicos);
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $data['contador'] = $this->guia->relatoriomedicoconveniocontadorrm();
        $data['relatorio'] = $this->guia->relatoriomedicoconveniorm();
        $data['revisor'] = $this->guia->relatoriomedicoconveniormrevisor();
        $data['revisada'] = $this->guia->relatoriomedicoconveniormrevisada();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconveniofinanceirorm', $data);
    }

    function gerarelatorioaniversariantes() {
        if (!($_POST["txtdata_inicio"] == "")) {
            $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);

            $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
            $data['relatorio'] = $this->guia->relatorioaniversariantes();
            $this->load->View('ambulatorio/impressaorelatorioaniversariantes', $data);
        } else {
            $data['mensagem'] = 'Insira um mês válido.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "/ambulatorio/guia/relatorioaniversariante");
        }
    }

    function escolherdeclaracao($paciente_id, $guia_id, $exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $data['exames_id'] = $exames_id;
        $data['modelos'] = $this->modelodeclaracao->listarmodelo();
        $this->loadView('ambulatorio/escolhermodelo', $data);
    }

    function impressaodeclaracao($paciente_id, $guia_id, $exames_id) {
        $this->load->plugin('mpdf');
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarexame($exames_id);
        $data['exames'] = $this->guia->listarexamesguia($guia_id);
        $data['modelo'] = $this->modelodeclaracao->buscarmodelo($_POST['modelo']);
        $exames = $data['exames'];
        $valor_total = 0;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);

        $dataFuturo = date("Y-m-d");

        $this->load->View('ambulatorio/impressaodeclaracao', $data);
    }

    function impressaodeclaracaoguia($guia_id) {
        $this->load->plugin('mpdf');
        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $this->guia->gravardeclaracaoguia($guia_id);
        $data['exame'] = $this->guia->listarexamesguia($guia_id);

        $filename = "declaracao.pdf";
        $cabecalho = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr></table>";
        $rodape = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
        $html = $this->load->view('ambulatorio/impressaodeclaracaoguia', $data, true);
        pdf($html, $filename, $cabecalho, $rodape);
        $this->load->View('impressaodeclaracaoguia', $data);
    }

    function reciboounota($paciente_id, $guia_id, $exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['guia_id'] = $guia_id;
        $data['exames_id'] = $exames_id;
        $this->loadView('ambulatorio/reciboounota', $data);
    }

    function reciboounotaindicador() {
//        var_dump($_POST['escolha']);die;
        $paciente_id = $_POST['paciente_id'];
        $guia_id = $_POST['guia_id'];
        $exames_id = $_POST['exames_id'];

        if ($_POST['escolha'] == 'R') {
            $this->impressaorecibo($paciente_id, $guia_id, $exames_id);
        } else {
            
        }
    }

    function impressaorecibo($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $pagamento = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
        $data['pagamento'] = $pagamento;
        // var_dump($pagamento); die;
        $valor_total = 0;

        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($pagamento[0]->valor, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            // if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            // }
        }

        $dataFuturo = date("Y-m-d");

//        $this->load->View('ambulatorio/impressaorecibomed', $data);
        $this->load->View('ambulatorio/impressaorecibo', $data);
    }

    function relatoriomedicoconveniofinanceiro() {
        $data['convenio'] = $this->convenio->listardados();
        $data['grupoconvenio'] = $this->grupoconvenio->listargrupoconvenios();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconveniofinanceiro', $data);
    }

    function relatoriomedicoconvenioprevisaofinanceiro() {
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriomedicoconvenioprevisaofinanceiro', $data);
    }

    function relatorioatendenteconvenio() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $data['tecnicos'] = $this->operador_m->listartecnicos();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatorioatendenteconvenio', $data);
    }

    function gerarelatoriomedicoconveniofinanceiro() {
        $medicos = $_POST['medicos'];
        $data['clinica'] = $_POST['clinica'];
        $data['solicitante'] = $_POST['solicitante'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['contador'] = $this->guia->relatoriomedicoconveniocontadorfinanceiro();
        $data['relatorio'] = $this->guia->relatoriomedicoconveniofinanceiro();
        $data['relatoriogeral'] = $this->guia->relatoriomedicoconveniofinanceirotodos();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconveniofinanceiro', $data);
    }

    function gerarelatoriomedicoconvenioprevisaofinanceiro() {
        $medicos = $_POST['medicos'];
        $data['clinica'] = $_POST['clinica'];
        $data['solicitante'] = $_POST['solicitante'];
        if ($medicos != 0) {
            $data['medico'] = $this->operador_m->listarCada($medicos);
        } else {
            $data['medico'] = 0;
        }
//        var_dump($data['medico']);
//        die;
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriomedicoconvenioprevisaofinanceiro();
        $this->load->View('ambulatorio/impressaorelatoriomedicoconvenioprevisaofinanceiro', $data);
    }

    function gerarelatorioatendenteconvenio() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->gerarelatorioatendenteconvenio();
        $this->load->View('ambulatorio/impressaorelatorioatendenteconvenio', $data);
    }

    function relatoriogruporm() {
        $this->loadView('ambulatorio/relatoriorm');
    }

    function gerarelatoriogruporm() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatoriogrupo();
        $data['contador'] = $this->guia->relatoriogrupocontador();
        $this->load->View('ambulatorio/impressaorelatoriorm', $data);
    }

    function verificado($agenda_exames_id) {
        $data['verificado'] = $this->guia->verificado($agenda_exames_id);
        $this->load->View('ambulatorio/verificado-form', $data);
    }

    function graficovalormedio($procedimento, $valor, $txtdata_inicio, $txtdata_fim) {
//        var_dump($txtdata_inicio);
//        var_dump($txtdata_fim);
//        die;
        $data['grafico'] = $this->guia->relatoriograficoalormedio($procedimento);
        $data['valor'] = $valor;
        $data['txtdata_inicio'] = $txtdata_inicio;
        $data['txtdata_fim'] = $txtdata_fim;
        $data['procedimento'] = $procedimento;
        $this->load->View('ambulatorio/graficovalormedio', $data);
    }

    function entregaexame($paciente_id, $agenda_exames_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->guia->listarpaciente($paciente_id);
        $data['agenda_exames_id'] = $agenda_exames_id;
        $this->load->View('ambulatorio/exameentregue-form', $data);
    }

    function guiaobservacao($guia_id) {
        $data['guia_id'] = $this->guia->verificaobservacao($guia_id);
        $this->load->View('ambulatorio/guiaobservacao-form', $data);
    }

    function guiaconvenio($guia_id) {
        $data['guia_id'] = $this->guia->guiaconvenio($guia_id);
        $this->load->View('ambulatorio/guiaconvenio-form', $data);
    }

    function guiadeclaracao($guia_id) {
        $data['guia_id'] = $this->guia->verificaodeclaracao($guia_id);
        $this->load->View('ambulatorio/guiadeclaracao-form', $data);
    }

    function vizualizarobservacao($agenda_exame_id) {
        $data['agenda_exame_id'] = $agenda_exame_id;
        $data['observacao'] = $this->guia->vizualizarobservacoes($agenda_exame_id);
        $this->load->View('ambulatorio/vizualizarobservacao-form', $data);
    }

    function vizualizarpreparo($tuss_id) {
        $data['preparo'] = $this->guia->vizualizarpreparo($tuss_id);
        $this->load->View('ambulatorio/vizualizarpreparo-form', $data);
    }

    function vizualizarpreparoconvenio($convenio_id) {
        $data['preparo'] = $this->guia->vizualizarpreparoconvenio($convenio_id);
        $this->load->View('ambulatorio/vizualizarpreparo-form', $data);
    }

    function gravarentregaexame() {
        $agenda_exames_id = $_POST['agenda_exames_id'];
        $this->guia->gravarentregaexame($agenda_exames_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarobservacaoguia($guia_id) {
        $this->guia->gravarobservacaoguia($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravarguiaconvenio($guia_id) {
        $this->guia->gravarguiaconvenio($guia_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function recebidoresultado($paciente_id, $agenda_exames_id) {
        $this->guia->recebidoresultado($agenda_exames_id);
        redirect(base_url() . "ambulatorio/guia/acompanhamento/$paciente_id");
    }

    function cancelarrecebidoresultado($paciente_id, $agenda_exames_id) {
        $this->guia->cancelarrecebidoresultado($agenda_exames_id);
        redirect(base_url() . "ambulatorio/guia/acompanhamento/$paciente_id");
    }

    function gravarverificado($agenda_exame_id) {
        $this->guia->gravarverificado($agenda_exame_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function valoralterado($agenda_exames_id) {
        $data['alterado'] = $this->guia->valoralterado($agenda_exames_id);
        $this->load->View('ambulatorio/valoralterado-form', $data);
    }

    function relatoriocaixa() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixa', $data);
    }

    function relatoriocaixafaturado() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixafaturado', $data);
    }

    function relatoriovalorprocedimento() {
        $data['convenio'] = $this->convenio->listardados();
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriovalorprocedimento', $data);
    }

    function gerarrelatoriovalorprocedimento() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriovalorprocedimento();
        $data['contador'] = $this->guia->relatoriovalorprocedimentocontador();
        $this->loadView('ambulatorio/ajustarvalorprocedimento', $data);
    }

    function gravarnovovalorprocedimento() {
        $ambulatorio_guia_id = $this->guia->gravarnovovalorprocedimento();
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar valor. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar valor.';
        }

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/relatoriovalorprocedimento", $data);
    }

    function relatoriocaixacartao() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixacartao', $data);
    }

    function relatoriocaixacartaoconsolidado() {
        $data['operadores'] = $this->operador_m->listartecnicos();
        $data['empresa'] = $this->guia->listarempresas();
        $data['grupos'] = $this->procedimento->listargrupos();
        $this->loadView('ambulatorio/relatoriocaixacartaoconsolidado', $data);
    }

    function gerarelatoriocaixacartaoconsolidado() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixa();
        $data['contador'] = $this->guia->relatoriocaixacontador();
        $this->load->View('ambulatorio/impressaorelatoriocaixacartaoconsolidado', $data);
    }

    function relatoriophmetria() {
        $this->loadView('ambulatorio/relatoriophmetria');
    }

    function gerarelatoriocaixa() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixa();
        $data['caixa'] = $this->caixa->listarsangriacaixa();
        $data['contador'] = $this->guia->relatoriocaixacontador();
        $data['formapagamento'] = $this->formapagamento->listarforma();
        $this->load->View('ambulatorio/impressaorelatoriocaixa', $data);
    }

    function gerarelatoriocaixafaturado() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixafaturado();
        $data['contador'] = $this->guia->relatoriocaixacontadorfaturado();
        $this->load->View('ambulatorio/impressaorelatoriocaixafaturado', $data);
    }

    function gerarelatoriocaixacartao() {
        $data['operador'] = $_POST['operador'];
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['grupo'] = $_POST['grupo'];
        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);
        $data['relatorio'] = $this->guia->relatoriocaixa();
        $data['contador'] = $this->guia->relatoriocaixacontador();
        $this->load->View('ambulatorio/impressaorelatoriocaixacartao', $data);
    }

    function gerarelatoriophmetria() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['relatorio'] = $this->guia->relatoriophmetria();
        $data['contador'] = $this->guia->relatoriophmetriacontador();
        $this->load->View('ambulatorio/impressaorelatoriophmetria', $data);
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

    function gerardicom($guia_id) {
        $exame = $this->exame->listardicom($guia_id);
        var_dump($guia_id);
        echo 'okk';
        var_dump($exame);
        echo 'okk';
        die;
        $grupo = $exame[0]->grupo;
        if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
            $grupo = 'CR';
        }
        if ($grupo == 'RM') {
            $grupo = 'MR';
        }
        $data['titulo'] = "AETITLE";
        $data['data'] = str_replace("-", "", date("Y-m-d"));
        $data['hora'] = str_replace(":", "", date("H:i:s"));
        $data['tipo'] = $grupo;
        $data['tecnico'] = $exame[0]->tecnico;
        $data['procedimento'] = $exame[0]->procedimento;
        $data['procedimento_tuss_id'] = $exame[0]->codigo;
        $data['procedimento_tuss_id_solicitado'] = $exame[0]->codigo;
        $data['procedimento_solicitado'] = $exame[0]->procedimento;
        $data['identificador_id'] = $guia_id;
        $data['pedido_id'] = $guia_id;
        $data['solicitante'] = $exame[0]->convenio;
        $data['referencia'] = "";
        $data['paciente_id'] = $exame[0]->paciente_id;
        $data['paciente'] = $exame[0]->paciente;
        $data['nascimento'] = str_replace("-", "", $exame[0]->nascimento);
        $data['sexo'] = $exame[0]->sexo;
        $this->exame->gravardicom($data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
