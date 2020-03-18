<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");
require_once('./gerencianet/vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

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
        $this->load->model('ambulatorio/empresa_model', 'empresa');
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
                            
        $data['verificar_credor'] = $this->guia->verificarcredordevedorgeral($paciente_id);        
        $data['exames'] = $this->guia->listarexames($paciente_id);
        $contrato_ativo = $this->guia->listarcontratoativo($paciente_id);
        $data['permissao'] = $this->empresa->listarpermissoes();
        
//         echo "<pre>";
        if (count($contrato_ativo) > 0) { 
        
            
            if ($contrato_ativo[count($contrato_ativo) - 1]->data != "") {
                $paciente_contrato_id = $contrato_ativo[0]->paciente_contrato_id;
                $parcelas_pendente = $this->guia->listarparcelaspacientependente($paciente_contrato_id);
                            
                $data_contrato = $contrato_ativo[count($contrato_ativo) - 1]->data;
                $data_cadastro = $contrato_ativo[count($contrato_ativo) - 1]->data_cadastro;
                $qtd_dias = $contrato_ativo[count($contrato_ativo) - 1]->qtd_dias;
                
            
                       
                if ($qtd_dias == "") {
                    $qtd_dias = 0;
                } else {
                    
                }
         
                // $data_contrato_year = date('Y-m-d H:i:s', strtotime("+ 1 year", strtotime($data_contrato)));
                //Abaixo soma data de cadastro do contrato com os dias colocados no plano.
                $data_tot_contrato = date('Y-m-d', strtotime("+$qtd_dias days", strtotime($data_cadastro)));
                $data_atual = date("Y-m-d");
//               print_r($data_tot_contrato);  
//               echo "<br>";
//               print_r($data_atual > $data_tot_contrato);  
//                echo "<br>";
//               print_r($data_contrato);  
               
//               var_dump($data_tot_contrato);die;
//                print_r($data_tot_contrato);
//                echo "***********";
//                  print_r($data_atual);
//                echo "***********";
//                  print_r($qtd_dias);
//                echo "***********";
                //verificando se a data atual for maior que a data do (contrato+dias do plano) se for maior vai criar um novo contrato.
                if ($data_atual > $data_tot_contrato && count($parcelas_pendente) == 0 && ($contrato_ativo[0]->nao_renovar == 'f' || $contrato_ativo[0]->nao_renovar == null)) {
                    if ($data['permissao'][0]->renovar_contrato_automatico == 't') {
                        $contrato_ativo = $this->guia->gravarnovocontratoanual($paciente_contrato_id);
                    } else {
                        $contrato_ativo = $this->guia->gravarnovocontratoanualdesativar($paciente_contrato_id);
                    }
                }
            }
                            
        }
        
//       
//        die;
//       
        $data['titular'] = $this->guia->listartitular($paciente_id);
//      var_dump($data['titular'] ); die;
        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['observacao_paciente'] = $this->guia->listarobservacaocadastro($paciente_id);
        $this->loadView('ambulatorio/guia-lista', $data);
    }

    function novocontrato($paciente_id, $empresa_id = NULL) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['planos'] = $this->formapagamento->listarforma();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $plano_id = $data['paciente'][0]->plano_id;
        $data['forma_pagamento'] = $this->paciente->listaforma_pagamento($plano_id);
        $data['forma_pagamentos'] = $this->formapagamento->listarformapagamentos();
        @$data['empresa_cadastro_id'] = @$empresa_id;
        $this->loadView('ambulatorio/novocontrato-form', $data);
    }

    function relatoriosicov() {
        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriosicov', $data);
    }

    function gerarsicov() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $relatorio = $this->guia->gerarsicov();

//        echo "<pre>";
//        print_r($relatorio);
//        die;

        $empresa = $this->guia->listarempresassicov();
        // Definições de variaveis com informação do banco e afins.  
        $codigo_convenio_banco = $empresa[0]->codigo_convenio_banco;
        $nome_empresa = substr($empresa[0]->razao_social, 0, 20);
        $data_geracao = date("Ymd");
        $sequencial_NSA = $this->guia->gerarnumeroNSA(); // Incrementa um numero a cada arquivo gerado.
        // Definições das variaveis do header
        // Variavel / Tamanho da string
        // Obs: Gerais.
        // Os campos numericos são preenchidos com zero a esquerda e os alfa-numericos com espaço em branco a direita.
        $A = array();
        $A[0] = ''; // Iniciando o indice zero do array;
        $A[1] = 'A'; // string(1); Codigo do Registro, sempre "A"
        $A[2] = '1'; // string(1); Código da Remessa: No caso da gente é Envio, então é 1
        $A[3] = $this->utilitario->preencherDireita($codigo_convenio_banco, 20, ' '); // string(20); Código do convênio (Informado pelo banco e no sistema em Manter Empresa) 
        $A[4] = $this->utilitario->preencherDireita($nome_empresa, 20, ' '); // string(20); Nome da empresa
        $A[5] = '104'; // string(03); Código do Banco. Caixa = 104
        $A[6] = $this->utilitario->preencherDireita('CAIXA', 20, ' '); // string(20); Nome do banco.
        $A[7] = $data_geracao; // string(08);
        $A[8] = $this->utilitario->preencherEsquerda($sequencial_NSA, 6, '0'); // string(06); Numero de Sequencia do arquivo NSA
        $A[9] = '05'; // string(02); Versao do Layout: 04 ou 05. No caso esse é o 05, pois é o E com validação de CPF/CNPJ
        $A[10] = 'DEBITO AUTOMATICO'; // string(17); Tipo de atendimento
        $A[11] = $this->utilitario->preencherDireita('', 52, ' '); // string(52); String vazia

        $header_A = implode($A);
        $body_E = array();

        // echo '<pre>';
        // var_dump($relatorio);
        // die;
        $contador = 0;
        $body_E_con = '';
        $valor_total = 0;
        $num_sequencial = 01;
        foreach ($relatorio as $item) {

            $data_vencimento = date("Ymd", strtotime($item->data));
            $valor_debito = number_format($item->valor, 2, '', '');
            $valor_total = $valor_total + $item->valor;

            if (strlen($item->cpf) > 11) {
                $tipo_iden = 1;
                $cnpj = str_replace('-', '', str_replace('.', '', str_replace('/', '', $item->cpf)));

                $cpf_cnpj = "9" . $cnpj;
            } else {
                $cpf = str_replace('-', '', str_replace('.', '', str_replace('/', '', $item->cpf)));
                $tipo_iden = 2;
                $cpf_cnpj = "0000" . $cpf;
            }

            $E = array();
            $E[0] = ''; // Iniciando o Array;
            $E[1] = 'E'; // string(01); Código do registro = "E"
            $E[2] = $this->utilitario->preencherDireita($item->paciente_id, 25, ' '); // string(25);  Identificação do cliente na Empresa
            $E[3] = $this->utilitario->preencherEsquerda(substr($item->conta_agencia, 0, 4), 4, '0'); // string(04); Agência para débito/crédito
            $conta = $this->utilitario->preencherEsquerda($item->codigo_operacao . $item->conta_numero . $item->conta_digito . "  ", 4, '0'); // Variavel temporaria pra guardar a conta concatenada; no fim tem dois espaços em branco.
            $E[4] = $this->utilitario->preencherEsquerda($conta, 14, '0'); // string(14); Identificação do cliente no Banco
            $E[5] = $data_vencimento; // string(08); Data do vencimento
            $E[6] = $this->utilitario->preencherEsquerda($valor_debito, 15, '0'); // string(15); Valor do débito
            $E[7] = '03'; // string(02); Código da moeda  Real = 03
            $E[8] = $this->utilitario->preencherDireita('Pagamento por debito automatico sistema Fidelidade', 60, ' '); // string(60);  String pra usar a vontade limitando o tamanho, essa informação é só uma observação que apenas retorna para a clinica. O banco não utiliza
            $E[9] = $this->utilitario->preencherEsquerda($item->paciente_id, 6, '0');
            $E[10] = $this->utilitario->preencherDireita('', 8, ' ');
            $E[11] = $this->utilitario->preencherEsquerda($num_sequencial, 6, '0');
            $num_sequencial++;
            $E[12] = '0';
//            $E[9] = $tipo_iden; // string(01); Tipo de identificação: 1 pra CNPJ |  2 pra CPF
//            $E[10] = $cpf_cnpj; // string(15); // CPF ou CNPJ
//            $E[11] = $this->utilitario->preencherDireita('', 4, ' '); // string(04); Reservado para o futuro. Deixar em branco;
//            $E[12] = '0'; // string(01); Tipo de movimento. No nosso caso: Débito normal = 0


            $body_con = implode($E); // Corpo concatenado

            $body_E[] = $body_con; // Adiciona no array. (interessante essa variável pra verificar possiveis problemas nas linhas)
            $body_E_con .= $body_con . "\n"; // Corpo concatenado
            $contador++;

            // echo '<pre>';
            // var_dump($E); 
            // var_dump($body_con); 
            // die;
        }


        $valor_total = number_format($valor_total, 2, '', '');
        $Z = array(); // Footer chamado de Trailler
        $Z[0] = ''; // Iniciando indice zero;
        $Z[1] = 'Z'; // ; string(1) Indicação do que é a linha;
        $contador = $contador + 2; // Tem que contar o Header e o Footer
        $Z[2] = $this->utilitario->preencherEsquerda($contador, 6, '0'); // ;
        $Z[3] = $this->utilitario->preencherEsquerda($valor_total, 17, '0'); // ;                         
        $Z[4] = $this->utilitario->preencherDireita("", 119, ' ');
        $Z[5] = $this->utilitario->preencherEsquerda($num_sequencial, 6, '0');
        $Z[6] = $this->utilitario->preencherEsquerda("", 1, '0');
//        
//            $Z[4] = $this->utilitario->preencherEsquerda("000", 17, '0'); // ;                       
//        $Z[5] = $this->utilitario->preencherDireita("", 109, ' ');


        ; // ;
        $footer_Z = implode($Z);

        $string_geral = '';
        $string_geral = $header_A . "\n" . $body_E_con . $footer_Z;
        // echo '<pre>';
        // var_dump($body_E); 
        // die;
        if (!is_dir("./upload/SICOV")) {
            mkdir("./upload/SICOV");
            $destino = "./upload/SICOV";
            chmod($destino, 0777);
        }
        $data_Mes = date("m"); // Definindo a variavel pro nome do arquivo
        if (count($relatorio) > 0) {
            $data_Mes = date("m", strtotime($relatorio[0]->data)); // Associando o primeiro item do array.
        }
        $nome_arquivo = "COV" . $data_Mes . $contador;
        $fp = fopen("./upload/SICOV/$nome_arquivo.txt", "w+"); // Abre o arquivo para escrever com o ponteiro no inicio
        $escreve = fwrite($fp, $string_geral);

        unlink("./upload/SICOV/$nome_arquivo.zip");
        // Apagar o arquivo primeiro
        $zip = new ZipArchive;
        $this->load->helper('directory');
        $zip->open("./upload/SICOV/$nome_arquivo.zip", ZipArchive::CREATE);
        $zip->addFile("./upload/SICOV/$nome_arquivo.txt", "$nome_arquivo.txt");
        $zip->close();
        unlink("./upload/SICOV/$nome_arquivo.txt");

        if (count($relatorio) > 0) {
            $messagem = "Arquivo gerado com sucesso";
        } else {
            $messagem = "Não foram encontradas cobranças para gerar o arquivo";
        }

        $this->session->set_flashdata('message', $messagem);
        redirect(base_url() . "ambulatorio/guia/relatoriosicov");
        // $this->load->View('ambulatorio/impressaorelatorioinadimplentes', $data);
    }

    function downloadTXT($nome_arquivo) {

        $arquivo = file_get_contents("./upload/SICOV/$nome_arquivo");

        // $string = 'Test download string';

        header('Content-type: text/plain');
        header('Content-Length: ' . strlen($arquivo));
        header("Content-Disposition: attachment; filename=$nome_arquivo");

        echo $arquivo;
    }

    function relatorioinadimplentes() {
//        $data['empresa'] = $this->guia->listarempresas();
        $data['bairros'] = $this->paciente->listarbairros();
        
        $data['forma_rendimento'] = $this->paciente->listarformapagamento();
        $data['planos'] = $this->guia->listarplanos();
                            

        $this->loadView('ambulatorio/relatorioinadimplentes', $data);
    }

    function gerarelatorioinadimplentes() {
        $this->load->plugin('mpdf'); 
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatorioinadimplentes();
        $data['ordenar'] = $_POST['ordenar'];
        $data['parcelas'] = $_POST['parcelas'];
        
     
        if ($_POST['forma_pagamento'] != "") {
           $data['forma']  = $this->paciente->listarformaredimento($_POST['forma_pagamento']);  
        }else{
            $data['forma'] = Array();
        }  
        if ($_POST['gerar'] == "pdf") {

            $filename = "relatorio.pdf";
            $cabecalho = "";
            $rodape = ""; 
            $html = $this->load->View('ambulatorio/impressaorelatorioinadimplentes', $data, true); 
            pdf($html, $filename, $cabecalho, $rodape);
        }

        if ($_POST['gerar'] == "planilha") {

            $nome_arquivo = "relatorio";
            $html = $this->load->View('ambulatorio/impressaorelatorioinadimplentes', $data, true);

            $filename = "Relatorio ";
            // Configurações header para forçar o download
            header("Content-type: application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header("Content-Description: PHP Generated Data");
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        }

        $this->load->View('ambulatorio/impressaorelatorioinadimplentes', $data);
    }

    function relatorioadimplentes() {
        $data['bairros'] = $this->paciente->listarbairros();
        $data['planos'] = $this->guia->listarplanos();
        $data['forma_rendimento'] = $this->paciente->listarformapagamento();                            
        $this->loadView('ambulatorio/relatorioadimplentes', $data);
    }

    function gerarelatorioadimplentes() {
        $this->load->plugin('mpdf');
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $data['relatorio'] = $this->guia->relatorioadimplentes(); 
        $data['ordenar'] = $_POST['ordenar']; 
        
        if ($_POST['forma_pagamento'] != "") {
           $data['forma']  = $this->paciente->listarformaredimento($_POST['forma_pagamento']);  
        }else{
            $data['forma'] = Array();
        }  
        
        if ($_POST['gerar'] == "pdf") { 
            $filename = "relatorio.pdf";
            $cabecalho = "";
            $rodape = ""; 
            $html = $this->load->View('ambulatorio/impressaorelatorioadimplentes', $data, true); 
            pdf($html, $filename, $cabecalho, $rodape);
        }

        if ($_POST['gerar'] == "planilha") { 
            $nome_arquivo = "relatorio";
            $html = $this->load->View('ambulatorio/impressaorelatorioadimplentes', $data, true); 
            $filename = "Relatorio ";
            // Configurações header para forçar o download
            header("Content-type: application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header("Content-Description: PHP Generated Data");
            // Envia o conteúdo do arquivo
            echo $html;
            exit;
        }
        
        $this->load->View('ambulatorio/impressaorelatorioadimplentes', $data);
    }

    function relatoriocontratosinativos() {
//        $data['empresa'] = $this->guia->listarempresas();
        $data['planos'] = $this->formapagamento->listarforma();
        $data['vencedor'] = $this->operador_m->listarvendedor(1);
        $data['forma']  = $this->formapagamento->listarformaRendimentoPaciente();
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

    function impressaoficha($paciente_contrato_id = NULL) {
        $this->load->plugin('mpdf');
        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['exame'] = $this->guia->listarparcelas($paciente_contrato_id);
        $data['paciente'] = $this->guia->listarinformacoesContrato($paciente_contrato_id);
        $data['dependente'] = $this->guia->listardependentes($paciente_contrato_id);
        $data['titular_id'] = @$data['paciente'][0]->paciente_id;

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
        // } elseif ($data['empresa'][0]->modelo_carteira == 3) {
        //     $this->load->View('ambulatorio/impressaofichaamma', $data);
        // }
        }else{}

///////////////////////////////////////////////////////////////////////////////////////////////        
        // $this->load->View('ambulatorio/impressaoficharonaldo', $data);
    }

    function impressaocarteira($paciente_id, $contrato_id, $paciente_contrato_dependente_id = NULL, $paciente_titular = NULL) {

        $empresa_id = $this->session->userdata('empresa_id');
        $data['empresa'] = $this->guia->listarempresa($empresa_id);
        $data['permissao'] = $this->empresa->listarpermissoes();
        $data['dependente'] = $this->guia->listardependentes($contrato_id);

        if ($data['permissao'][0]->carteira_padao_2 == 't') {
            $data['paciente'] = $this->guia->listarpacientecarteirapadrao2($paciente_id);
        } elseif ($data['permissao'][0]->carteira_padao_3 == 't' || $data['permissao'][0]->carteira_padao_4 == 't') {
            $data['paciente'] = $this->guia->listarpacientecarteirapadrao3($paciente_id);
        } else {
            $data['paciente'] = $this->guia->listarpacientecarteira($paciente_id);
        }

        $data['contrato'] = $this->guia->listarinformacoesContrato($contrato_id);
        $this->guia->addimpressao($contrato_id, $paciente_id, $paciente_contrato_dependente_id);
        // var_dump($data['contrato']); die;
        $data['titular_id'] = $data['contrato'][0]->paciente_id;
        $paciente_id = @$data['paciente'][0]->paciente_id;


//        echo $paciente_titular;
//        die;
        if (@$data['paciente'][0]->situacao == 'Titular') {
            $this->guia->confirmarpagamentocarteira($paciente_id, $contrato_id, $paciente_id);
        } else {
            $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
            $paciente_dependete_id = @$retorno[0]->paciente_id;
            $titular_id = @$retorno[0]->titular_id;
            $this->guia->confirmarpagamentocarteira($paciente_dependete_id, $contrato_id, $paciente_titular);
        }

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

    function confirmarpagamento($paciente_id, $contrato_id, $paciente_contrato_parcelas_id, $depende_id = NULL) {
        $this->guia->verificarcredordevedorgeral($paciente_id);
        if ($this->guia->confirmarpagamento($paciente_contrato_parcelas_id, $paciente_id, $depende_id)) {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function confirmarpagamentoconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id) {
        $data['verificar_credor'] = $this->guia->verificarcredordevedorgeral($paciente_id);
//        var_dump($valor); die;
        $tipo = $this->guia->confirmarpagamentoconsultaavulsa($consultas_avulsas_id, $paciente_id);
        // var_dump($tipo); die;
        if ($tipo != '') {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        if ($tipo == 'CONSULTA EXTRA') {
            redirect(base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id");
        } else {
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


        $gerado_todos_iugu = $this->paciente->salvargravadotodosiugu($contrato_id);
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

    function gravardebitoconta($paciente_id, $contrato_id) {


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

        $ambulatorio_guia_id = $this->guia->gravardebitoconta($paciente_id, $contrato_id);
        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar conta.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar conta.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
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

    function excluirparcelacontrato($paciente_id, $contrato_id, $parcela_id, $carnet_id = NULL, $num_carne = NULL) {

        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($parcela_id);
        $pagamento_gerencianet = $this->paciente->listarpagamentoscontratoparcelagerencianet($parcela_id);
        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;


        $client_id = $empresa[0]->client_id; //ache a o seu client_id no site em API e selecione sua Aplicação
        $client_secret = $empresa[0]->client_secret; //ache a o seu client_secret no site em API e selecione sua Aplicação
//        var_dump($pagamento_iugu);
//        die;
        if ($key != '' && count($pagamento_iugu) > 0) {
            if ($pagamento_iugu[0]->invoice_id != '') {
                Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
                $retorno = Iugu_Invoice::fetch($pagamento_iugu[0]->invoice_id);
                $retorno->cancel();
            }
        }

        if ($client_id != "" && $client_secret != "" && count($pagamento_gerencianet) > 0) {
            $options = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];

            if ($num_carne != "" && $num_carne != NULL) {
                $params = ['id' => $carnet_id, 'parcel' => $num_carne];
                try {
                    $api = new Gerencianet($options);
                    $response = $api->cancelParcel($params, []);
//                    print_r($response);
                    $data['mensagem'] = 'Sucesso ao excluir parcela.';
                } catch (GerencianetException $e) {
//                    print_r($e->code);
//                    print_r($e->error);
//                    print_r($e->errorDescription);
                    $data['mensagem'] = 'Erro ao excluir parcela';
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            } else {


                $params = [
                    'id' => $pagamento_gerencianet[0]->charge_id
                ];

                try {
                    $api = new Gerencianet($options);
                    $charge = $api->cancelCharge($params, []);
//                    print_r($charge);
                    $data['mensagem'] = 'Sucesso ao excluir parcela.';
                } catch (GerencianetException $e) {
//                    print_r($e->code);
//                    print_r($e->error);
//                    print_r($e->errorDescription);
                    $data['mensagem'] = 'Erro ao excluir parcela';
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            }
        }


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

        $pagamento_gerencianet = $this->paciente->listarpagamentoscontratoconsultaavulsaGN($consulta_id);
        $empresa = $this->guia->listarempresa();


//        var_dump($pagamento_gerencianet);die;

        $client_id = $empresa[0]->client_id; //ache a o seu client_id no site em API e selecione sua Aplicação
        $client_secret = $empresa[0]->client_secret; //ache a o seu client_secret no site em API e selecione sua Aplicação
//        var_dump($pagamento_iugu);
//        die;

        if ($client_id != "" && $client_secret != "" && count($pagamento_gerencianet) > 0) {

            $options = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];

            $params = [
                'id' => $pagamento_gerencianet[0]->charge_id_GN
            ];

            try {
                $api = new Gerencianet($options);
                $charge = $api->cancelCharge($params, []);
                print_r($charge);
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }

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

    function excluirconsultaavulsaguia($paciente_id, $contrato_id, $consulta_id) {

        $pagamento_gerencianet = $this->paciente->listarpagamentoscontratoconsultaavulsaGN($consulta_id);
        $empresa = $this->guia->listarempresa();
//        var_dump($pagamento_gerencianet);die;

        $client_id = $empresa[0]->client_id; //ache a o seu client_id no site em API e selecione sua Aplicação
        $client_secret = $empresa[0]->client_secret; //ache a o seu client_secret no site em API e selecione sua Aplicação
//        var_dump($pagamento_iugu);
//        die;

        if ($client_id != "" && $client_secret != "" && count($pagamento_gerencianet) > 0) {
            $options = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];

            $params = [
                'id' => $pagamento_gerencianet[0]->charge_id_GN
            ];

            try {
                $api = new Gerencianet($options);
                $charge = $api->cancelCharge($params, []);
                print_r($charge);
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }


        $ambulatorio_guia_id = $this->guia->excluirconsultaavulsa($consulta_id);
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
        @$empresa_cadastro_id = @$_POST['empresa_cadastro_id'];
        $paciente = $this->guia->gravarplano($paciente_id, $empresa_cadastro_id);
        $paciente_contrato_id = $this->guia->gravarplanoparcelas($paciente_id);
//        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id/$paciente_contrato_id");
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
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
        if ($this->session->userdata('cadastro') == 2) {
            $dependente_id = $_POST['dependente'];
            $this->guia->geraparcelasdependente($dependente_id, $contrato_id);
        }
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
        $data['contrato_id'] = $contrato_id;
        $data['empresa_permissao'] = $this->empresa->listarpermissoes();
        $this->loadView('ambulatorio/guia-form', $data);
    }

    function listarpagamentos($paciente_id, $contrato_id) {
           $data['empresapermissao'] = $this->empresa->listarpermissoes();
        if ($data['empresapermissao'][0]->forma_dependente != "t") {
              $this->paciente->atualizarformarendimentodependete($contrato_id);
        }  
        
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['verificarsepagouemiugu'] = $this->paciente->verificarsepagouemiugu($contrato_id);
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontrato($contrato_id);
        $data['listarpagamentosconsultaextra'] = $this->paciente->listarpagamentosconsultaavulsa($paciente_id);
        $data['listarpagamentosconsultacoop'] = $this->paciente->listarpagamentosconsultacoop($paciente_id);
        $data['historicoconsultasrealizadas'] = $this->paciente->listarhistoricoconsultasrealizadas($contrato_id);                           
     
        $data['contrato_id'] = $contrato_id;
        $data['verificar_credor'] = $this->guia->verificarcredordevedorgeral($paciente_id);
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
        $data['empresapermissao'] = $this->empresa->listarpermissoes();
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
        $data['empresapermissao'] = $this->empresa->listarpermissoes();
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

    function pagamentodebitoconta($paciente_id, $contrato_id) {
        $data['paciente_id'] = $paciente_id;
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['lista'] = $this->paciente->listardependentes();
        $data['empresa'] = $this->guia->listarempresa();
        $data['conta'] = $this->paciente->listarcontadebitocliente($paciente_id);
//        var_dump($data['listarpagamentoscontrato']); die;
        $data['contrato_id'] = $contrato_id;
        $this->loadView('ambulatorio/pagamentodebitoconta-form', $data);
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

    function relatoriocomissaoexterno() {
        $data['listarvendedor'] = $this->paciente->listarvendedorexterno();
        $this->loadView('ambulatorio/relatoriocomissaoexterno', $data);
    }

    function relatoriocomissaoexternomensal() {
        $data['listarvendedor'] = $this->paciente->listarvendedorexterno();
        $this->loadView('ambulatorio/relatoriocomissaoexternomensal', $data);
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

    function gerarelatoriocomissaoexterno() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaoexterno();
        $data['relatorio_forma'] = $this->guia->relatoriocomissaoContadorFormaExterno();
        // echo '<pre>';
        // var_dump($data['relatorio_forma']); die;
        $this->load->View('ambulatorio/impressaorelatoriocomissaoexterno', $data);
    }

    function gerarelatoriocomissaoexternomensal() {
        $data['txtdatainicio'] = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data['txtdatafim'] = str_replace("/", "-", $_POST['txtdata_fim']);
//        var_dump($_POST); die;
        $data['vendedor'] = $this->guia->listarvendedor($_POST['vendedor']);
        $data['relatorio'] = $this->guia->relatoriocomissaoexternomensal();
        // $data['relatorio_forma'] = $this->guia->relatoriocomissaovendedorFormaRend();
        // echo '<pre>'; 
        // var_dump($data['relatorio_forma']);
        // die;
        $this->load->View('ambulatorio/impressaorelatoriocomissaoexternomensal', $data);
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
            $data['empresa'] = $this->guia->listarempresaporid($_POST['empresa']);
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

    function relatoriosicovoptante() {

        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/relatoriosicovoptante', $data);
    }

    function gerarsicovoptante() {
        $data['txtdata_inicio'] = $_POST['txtdata_inicio'];
        $data['txtdata_fim'] = $_POST['txtdata_fim'];
        $relatorio = $this->guia->gerarsicovoptante();
                            
//        echo "<pre>";
//        
//        print_r($relatorio);
//        die;
        
        
        $origem_ind = "./upload/SICOVoptante";
        if ($_POST['apagar'] == 1) {
            delete_files($origem_ind);
        } else {            
        }
        $empresa = $this->guia->listarempresassicov();
        // Definições de variaveis com informação do banco e afins.  
        $codigo_convenio_banco = $empresa[0]->codigo_convenio_banco;
        $nome_empresa = substr($empresa[0]->razao_social, 0, 20);
        $data_geracao = date("Ymd");
        $sequencial_NSA = $this->guia->gerarnumeroNSA(); // Incrementa um numero a cada arquivo gerado.
        // Definições das variaveis do header
        // Variavel / Tamanho da string
        // Obs: Gerais.
        // Os campos numericos são preenchidos com zero a esquerda e os alfa-numericos com espaço em branco a direita.
        $A = array();
        $A[0] = ''; // Iniciando o indice zero do array;
        $A[1] = 'A'; // string(1); Codigo do Registro, sempre "A"
        $A[2] = '1'; // string(1); Código da Remessa: No caso da gente é Envio, então é 1
        $A[3] = $this->utilitario->preencherDireita($codigo_convenio_banco, 20, ' '); // string(20); Código do convênio (Informado pelo banco e no sistema em Manter Empresa) 
        $A[4] = $this->utilitario->preencherDireita($nome_empresa, 20, ' '); // string(20); Nome da empresa
        $A[5] = '104'; // string(03); Código do Banco. Caixa = 104
        $A[6] = $this->utilitario->preencherDireita('CAIXA', 20, ' '); // string(20); Nome do banco.
        $A[7] = $data_geracao; // string(08);
        $A[8] = $this->utilitario->preencherEsquerda($sequencial_NSA, 6, '0'); // string(06); Numero de Sequencia do arquivo NSA
        $A[9] = '05'; // string(02); Versao do Layout: 04 ou 05. No caso esse é o 05, pois é o E com validação de CPF/CNPJ
        $A[10] = 'DEBITO AUTOMATICO'; // string(17); Tipo de atendimento
        $A[11] = $this->utilitario->preencherDireita('', 52, ' '); // string(52); String vazia
        $header_A = implode($A);
        $body_E = array();
        $contador = 0;
        $body_E_con = '';
        $valor_total = 0;
        $num_sequencial = 01;
        foreach ($relatorio as $item) {
            if (strlen($item->cpf) > 11) {
                $tipo_iden = 1;
                $cnpj = str_replace('-', '', str_replace('.', '', str_replace('/', '', $item->cpf)));

                $cpf_cnpj = "9" . $cnpj;
            } else {
                $cpf = str_replace('-', '', str_replace('.', '', str_replace('/', '', $item->cpf)));
                $tipo_iden = 2;
                $cpf_cnpj = "0000" . $cpf;
            }
            $E = array();
            $E[0] = ''; // Iniciando o Array;
            $E[1] = 'E'; // string(01); Código do registro = "E"
            $E[2] = $this->utilitario->preencherDireita($item->paciente_id, 25, ' '); // string(25);  Identificação do cliente na Empresa          
            $E[3] = $this->utilitario->preencherEsquerda(substr($item->conta_agencia, 0, 4), 4, '0'); // string(04); Agência para débito/crédito
            $conta = $item->codigo_operacao . $item->conta_numero . $item->conta_digito . "  "; // Variavel temporaria pra guardar a conta concatenada; no fim tem dois espaços em branco.
            $E[4] = $this->utilitario->preencherEsquerda($conta, 14, '0'); // string(14); Identificação do cliente no Banco
            $E[5] = $this->utilitario->preencherDireita('', 8, ' '); // string(08); Data do vencimento
            $E[6] = $this->utilitario->preencherDireita('', 15, ' '); // string(15); Valor do débito
            $E[7] = $this->utilitario->preencherDireita('', 2, ' '); // string(02); Código da moeda  Real = 03
            $E[8] = $this->utilitario->preencherDireita('', 60, ' '); // string(60);  String pra usar a vontade limitando o tamanho, essa informação é só uma observação que apenas retorna para a clinica. O banco não utiliza
            $E[9] = $this->utilitario->preencherEsquerda($item->paciente_id, 6, '0'); // string(06) Número do Agendamento Cliente
            $E[10] = $this->utilitario->preencherDireita('', 8, ' '); //string(08) Reservado para o futuro ("filler")
            $E[11] = $this->utilitario->preencherEsquerda($num_sequencial, 6, '0'); //string(06) Número Sequencial do Registro
            $num_sequencial++;
            $E[12] = '5'; // string(01); Tipo de movimento. No nosso caso: Cadastro de OPTANTES = 5 
            $body_con = implode($E); // Corpo concatenado
            $body_E[] = $body_con; // Adiciona no array. (interessante essa variável pra verificar possiveis problemas nas linhas)
            $body_E_con .= $body_con . "\n"; // Corpo concatenado
            $contador++;
        }
                            
        $valor_total = number_format($valor_total, 2, '', '');
        $Z = array(); // Footer chamado de Trailler
        $Z[0] = ''; // Iniciando indice zero;
        $Z[1] = 'Z'; // ; string(1) Indicação do que é a linha;
        $contador = $contador + 2; // Tem que contar o Header e o Footer
        $Z[2] = $this->utilitario->preencherEsquerda($contador, 6, '0'); // ;
        $Z[3] = $this->utilitario->preencherEsquerda($valor_total, 17, '0'); // ;                         
        $Z[4] = $this->utilitario->preencherDireita("", 119, ' ');
        $Z[5] = $this->utilitario->preencherEsquerda($num_sequencial, 6, '0');
        $Z[6] = $this->utilitario->preencherEsquerda("", 1, '0');
                            
        $footer_Z = implode($Z);
        $string_geral = '';
        $string_geral = $header_A . "\n" . $body_E_con . $footer_Z;
        if (!is_dir("./upload/SICOVoptante")) {
            mkdir("./upload/SICOVoptante");
            $destino = "./upload/SICOVoptante";
            chmod($destino, 0777);
        }
        $data_Mes = date("m"); // Definindo a variavel pro nome do arquivo
        if (count($relatorio) > 0) {
            $data_Mes = date("m", strtotime($relatorio[0]->data)); // Associando o primeiro item do array.
        }
        $nome_arquivo = "ArqOptante" . $data_Mes . $contador;
        $fp = fopen("./upload/SICOVoptante/$nome_arquivo.txt", "w+"); // Abre o arquivo para escrever com o ponteiro no inicio
        $escreve = fwrite($fp, $string_geral);

        unlink("./upload/SICOVoptante/$nome_arquivo.zip");
        // Apagar o arquivo primeiro
        $zip = new ZipArchive;
        $this->load->helper('directory');
        $zip->open("./upload/SICOVoptante/$nome_arquivo.zip", ZipArchive::CREATE);
        $zip->addFile("./upload/SICOVoptante/$nome_arquivo.txt", "$nome_arquivo.txt");
        $zip->close();
        unlink("./upload/SICOVoptante/$nome_arquivo.txt");

        if (count($relatorio) > 0) {
            $messagem = "Arquivo gerado com sucesso";
        } else {
            $messagem = "Não foram encontradas cobranças para gerar o arquivo";
        }

        $this->session->set_flashdata('message', $messagem);
        redirect(base_url() . "ambulatorio/guia/relatoriosicovoptante");
    }

    function downloadTXToptante($nome_arquivo) {

        $arquivo = file_get_contents("./upload/SICOVoptante/$nome_arquivo");
        header('Content-type: text/plain');
        header('Content-Length: ' . strlen($arquivo));
        header("Content-Disposition: attachment; filename=$nome_arquivo");
        echo $arquivo;
    }

    function editarnumerocontrato($paciente_contrato_id) {

        $data['contrato'] = $this->guia->listarcontrato($paciente_contrato_id);
        $this->loadView('ambulatorio/contrato-form', $data);
    }

    function atualizarnumerocontrato($paciente_id, $paciente_contrato_id) {

        $verificar = $this->guia->atualizarcontrato($paciente_id, $paciente_contrato_id);
        $data_contrato = $_POST['data_contrato'];


        if ($verificar != -1) {
            $messagem = "Contrato alterado com sucesso!";
        } else {

            $messagem = "Erro ao alterar contrato.!";
        }

        $this->session->set_flashdata('message', $messagem);
        redirect(base_url() . "ambulatorio/guia/listardependentes/$paciente_id/$paciente_contrato_id");


//        else {
//
//            $messagem2 = "Não foi possível alterar numero, número já existente";
//            $this->session->set_flashdata('message', $messagem2);
//            redirect(base_url() . "ambulatorio/guia/editarnumerocontrato/$paciente_id");
//        }
    }

    function alterarpagamento($paciente_id, $contrato_id, $paciente_contrato_parcelas_id, $dependente_id = NULL) {
                            
        if ($dependente_id != "" && $this->session->userdata('cadastro') == 2 && $dependente_id != $paciente_id) {
            $paciente_id = $dependente_id;
        }
                            
        $data['paciente_contrato_parcelas_id'] = $paciente_contrato_parcelas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarparcelaalterardata($paciente_contrato_parcelas_id);
        $data['contas'] = $this->guia->listarcontas();
        $data['verificar_credor'] = $this->guia->verificarcredordevedorgeral($paciente_id);
        $this->load->View('ambulatorio/alterarpagamento-form', $data);
    }

    function gravaralterarpagamentodata($paciente_contrato_parcelas_id, $paciente_id, $contrato_id) {


        $pagamento_iugu_old = $this->paciente->listarpagamentoscontratoparcela($paciente_contrato_parcelas_id);
        $data_antiga = $pagamento_iugu_old[0]->data;
        $observacao = $pagamento_iugu_old[0]->observacao;

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
    }

    function gravaralterarpagamento($paciente_contrato_parcelas_id, $paciente_id, $contrato_id) {
        // chamando na propria tela  a função alterando a data 
        $teste2 = $this->gravaralterarpagamentodata($paciente_contrato_parcelas_id, $paciente_id, $contrato_id);
         // chamando uma função existente confirmando o pagamento;
        //botei essa $paciente_id duas vezes para que quando for dependente pegar o credor devedor do dependente
        if ($this->guia->confirmarpagamento($paciente_contrato_parcelas_id, $paciente_id, $paciente_id)) {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function alterarpagamentoconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id) {
        $data['consultas_avulsas_id'] = $consultas_avulsas_id;
        $data['paciente_id'] = $paciente_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarpagamentoscontratoconsultaavulsa($consultas_avulsas_id);
        $data['contas'] = $this->guia->listarcontas();
        $this->load->View('ambulatorio/alterarpagamentoavulsas-form', $data);
    }

    function gravaralterarpagamentoavulsas($consultas_avulsas_id, $paciente_id, $contrato_id) {
        $this->guia->alterardatapagamentoavulsa($consultas_avulsas_id);
        if ($this->guia->confirmarpagamentoconsultaavulsa($consultas_avulsas_id, $paciente_id)) {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function importararquivoretorno() {

        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('ambulatorio/importararquivoretorno', $data);
    }

    function importararquivoretornoenviar() {
        $chave_pasta = $this->session->userdata('empresa_id');

        $nome = $_FILES['arquivo']['name'];
        $nome_arq = $_FILES['arquivo'];
                            

        if (!is_dir("./upload/retornoimportados")) {
            mkdir("./upload/retornoimportados");
            $destino = "./upload/retornoimportados";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/retornoimportados/$chave_pasta")) {
            mkdir("./upload/retornoimportados/$chave_pasta");
            $destino = "./upload/retornoimportados/$chave_pasta";
            chmod($destino, 0777);
        }





        $configuracao = array(
            'upload_path' => './upload/retornoimportados/' . $chave_pasta . '',
            'allowed_types' => 'txt',
            'file_name' => $nome,
            'max_size' => '0'
        );

        $this->load->library('upload');
        $this->upload->initialize($configuracao);

        if ($this->upload->do_upload('arquivo'))
            $data['mensagem'] = 'Arquivo salvo com sucesso.';
        else
            $erro = $this->upload->display_errors();
        $data['mensagem'] = 'Erro';




        if (!is_dir("./upload/retornoimportados/todos")) {
            mkdir("./upload/retornoimportados/todos");
            $destino_todos = "./upload/retornoimportados/todos";
            chmod($destino_todos, 0777);
        }

        if (!is_dir("./upload/retornoimportados/todos/$chave_pasta")) {
            mkdir("./upload/retornoimportados/todos/$chave_pasta");
            $destino_todos = "./upload/retornoimportados/todos/$chave_pasta";
            chmod($destino_todos, 0777);
        }


        $configuracao2 = array(
            'upload_path' => './upload/retornoimportados/todos/' . $chave_pasta . '',
            'allowed_types' => 'txt',
            'file_name' => $nome,
            'max_size' => '0'
        );


        $this->upload->initialize($configuracao2);

        if ($this->upload->do_upload('arquivo'))
            $data['mensagem'] = 'Arquivo salvo com sucesso.';
        else
            $erro = $this->upload->display_errors();
        $data['mensagem'] = 'Erro';
                            
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function lerarquivoretornoimportado($nome_arquivo = NULL) {

        $chave_pasta = $this->session->userdata('empresa_id');                            
        $arquivo6 = fopen('./upload/retornoimportados/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        // Lê o conteúdo do arquivo  
        //criando a tabela onde vai mostrar as informações AQUI É PARA CONTAR QUANTAS PARCELAS TEM NO AQUIVO DE CADA PACIENTE
        while (!feof($arquivo6)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo6, 1024);
            $codigo_retornno =  substr($linha, 67, 2);
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z" && $codigo_retornno == "00") {
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                @$contador_parcelas{$paciente_id} ++;
            }
        }
        fclose($arquivo6);                   
        // Abre o Arquvio no Modo r (para leitura)
        $arquivo = fopen('./upload/retornoimportados/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        // Lê o conteúdo do arquivo 
        //criando a tabela onde vai mostrar as informações
        while (!feof($arquivo)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo, 1024);            
            $paciente_id = substr($linha, 1, 25);
            $codigo_retornno =  substr($linha, 67, 2);           
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z" && $codigo_retornno == "00") {
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                echo $paciente_id;                            
                //fazendo a consulta de acordo com o numero do paciente do arquivo 
                $data['lista_paciente'] = $this->guia->listarpacienteimportado($paciente_id);             
                $data['confirmacao_parcelas'] = $this->guia->confirmaparcelaimportada($paciente_id);

            }
        }
        fclose($arquivo);  
        
    if (!unlink('./upload/retornoimportados/' . $chave_pasta . '/' . $nome_arquivo . '')) {    
        
    }
        
         redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function downloadTXToptanteimportado($nome_arquivo = NULL) {
        $chave_pasta = $this->session->userdata('empresa_id');
        $arquivo = file_get_contents("./upload/retornoimportados/todos/$chave_pasta/$nome_arquivo");
        header('Content-type: text/plain');
        header('Content-Length: ' . strlen($arquivo));
        header("Content-Disposition: attachment; filename=$nome_arquivo");
        echo $arquivo;
    }

    function gerarpagamentoiuguempresacadastro($empresa_id = NULL, $contrato_id) {

//        $retorno_parcelas = $this->paciente->listarparcelaspacienteempresacadastro($empresa_id);
        $retorno_parcelas = $this->paciente->listarpagamentoscontratoiuguempresa($contrato_id);

//        foreach ($retorno_parcelas as $item) {
//        @$pagamento = $this->paciente->listarpagamentoscontratoparcelaiuguempresa($item->paciente_contrato_parcelas_id);

        @$pagamento = $this->paciente->listarpagamentoscontratoiuguempresa($contrato_id);

        @$valor += $pagamento[0]->valor;
//        }


        $valor = $valor * 100;

//        echo "<pre>";
//        print_r($retorno_parcelas);
//        die;

        $empresa1 = $this->paciente->listardadosempresa($empresa_id);

//  echo "<pre>";
//  print_r($empresa1);
//        $celular = preg_replace('/[^\d]+/', '', $empresa[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $empresa1[0]->celular), 2, 50);
        @$prefixo = substr(preg_replace('/[^\d]+/', '', $empresa1[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($empresa1[0]->codigo_ibge);
//
        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
//
//        $pagamento = $this->paciente->listarpagamentoscontratoparcela($item->paciente_contrato_parcelas_id);
//        
//        
//        $pagamento_iugu = $this->paciente->listarpagamentoscontratoparcelaiugu($item->paciente_contrato_parcelas_id);
//        $valor = $pagamento[0]->valor * 100;
        $data = date('d/m/Y', strtotime($pagamento[0]->data));
////        var_dump($prefixo); 
////        var_dump($celular_s_prefixo); 
        $description = $empresa[0]->nome;
////        echo '<pre>';
        $cpfcnpj = str_replace('/', '', $empresa1[0]->cnpj);
////        var_dump($cpfcnpj); 
////        die;
//
        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastra nas configurações da empresa
////        die;
//        //GERANDO A COBRANÇA
//        if (count($pagamento_iugu) == 0) {
//
        $gerar = Iugu_Invoice::create(Array(
                    "email" => $empresa1[0]->email,
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
                        "name" => $empresa1[0]->nome,
                        "phone_prefix" => @$prefixo,
                        "phone" => $celular_s_prefixo,
                        "email" => $empresa1[0]->email,
                        "address" => Array(
                            "street" => $empresa1[0]->logradouro,
                            "number" => $empresa1[0]->numero,
                            "city" => $empresa1[0]->municipio_id,
                            "state" => $codigoUF,
                            "district" => $empresa1[0]->bairro,
                            "country" => "Brasil",
                            "zip_code" => $empresa1[0]->cep,
                            "complement" => $empresa1[0]->complemento
                        )
                    )
        ));

//        echo '<pre>';
//        var_dump($gerar);
//        die;
        if (count($gerar["errors"]) > 0) {

            $mensagem = 'Erro ao gerar pagamento: \n';
//                   
//                
            foreach ($gerar["errors"] as $key => $item) {
////                var_dump($item[0]);
////                if(){
////                    
////                }
//                    $mensagem .= $empresa1[0]->nome.'\n';

                $mensagem = $mensagem . "$key $item[0]" . '\n';
            }
////                echo '<pre>';
////                var_dump($gerar);
////                die;
        } else {
//            echo "<pre>";
//            print_r($retorno_parcelas);    
//            foreach ($retorno_parcelas as $item) {
            $gravar = $this->guia->gravarintegracaoiuguempresacadastro($gerar["secure_url"], $gerar["id"], $retorno_parcelas[0]->paciente_contrato_parcelas_id, $empresa_id);
            $this->guia->pagamentoiuguempresa($retorno_parcelas[0]->paciente_contrato_parcelas_id, $empresa_id);
//            }


            $mensagem = 'Cobrança gerada com sucesso';
        }
//        } else {
//            
////            $mensagem = 'Cobrança já gerada';
//            
//        }
//
////        echo $mensagem;
////        die;
//        $this->session->set_flashdata('message', $mensagem);
//        
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
//        

        $this->session->set_flashdata('message', $mensagem);

        redirect(base_url() . "cadastros/pacientes/novofuncionario/" . $empresa_id);


//        $this->session->set_flashdata('message', $mensagem);
//        
//          redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
    }

    function excluirparcelacontratoempresa($paciente_id, $contrato_id, $parcela_id, $empresa_id = NULL) {

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
            $mensagem = 'Erro ao excluir parcela';
        } else {
            $mensagem = 'Sucesso ao excluir parcela.';
        }
        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "seguranca/operador/pesquisarrecepcao"); 
        redirect(base_url() . "cadastros/pacientes/novofuncionario/" . $empresa_id);
    }

    function gerarpagamentoiuguempresa($paciente_id, $contrato_id, $paciente_contrato_parcelas_id, $empresa_id = NULL) {

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
        redirect(base_url() . "cadastros/pacientes/novofuncionario/" . $empresa_id);
    }

    function novocontratocadastro($paciente_id, $empresa_id = NULL, $plano_id = NULL) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['planos'] = $this->formapagamento->listarforma();
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['plano_id'] = @$plano_id;
//        $plano_id = $data['paciente'][0]->plano_id;
//        $data['forma_pagamento'] = $this->paciente->listaforma_pagamento($plano_id);
//        $data['forma_pagamentos'] = $this->formapagamento->listarformapagamentos();
        @$data['empresa_cadastro_id'] = @$empresa_id;

        $this->load->View('ambulatorio/novocontratoempresa-form', $data);
    }

    function verarquivoimportado($nome_arquivo = NULL) {
        $chave_pasta = $this->session->userdata('empresa_id');
        $arquivo6 = fopen('./upload/retornoimportados/todos/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        // Lê o conteúdo do arquivo  
        //criando a tabela onde vai mostrar as informações AQUI É PARA CONTAR QUANTAS PARCELAS TEM NO AQUIVO DE CADA PACIENTE
        while (!feof($arquivo6)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo6, 1024);
              $codigo_retornno =  substr($linha, 67, 2);
                            
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z" && $codigo_retornno == "00") {
                if (!(substr($linha, 0, 1) == 'F' || substr($linha, 0, 1) == '' || substr($linha, 0, 1) == 'B')) {
                     echo "<meta charset='utf-8'><h1>Arquivo inválido</h1>";
                     return;
                }
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                @$contador_parcelas{$paciente_id} ++;
            }
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z" && $codigo_retornno != "00") {                   
                if (!(substr($linha, 0, 1) == 'F' || substr($linha, 0, 1) == '' || substr($linha, 0, 1) == 'B')) {
                     echo "<meta charset='utf-8'><h1>Arquivo inválido</h1>";
                     return;
                }           
                $paciente_id = substr($linha, 1, 25);
                $Array[$paciente_id][] = $codigo_retornno;
            }
        }

        fclose($arquivo6);

                            
//abrindo novamente
        $arquivo2 = fopen('./upload/retornoimportados/todos/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        echo "<style>tr:nth-child(2n+2) {
    background: #ecf0f1;
}tr{
font-family:arial;
}
table tr:hover td{
	background-color:#2f3542;
        
 } 
 
#naoachado{
color:red;
}

table tr:hover  #naoachado{
 color:white; 
}

#achado{
color:green;
}
table tr:hover  #achado{
 color:white; 
}

table tr:hover  #achadoERRO{
 color:white; 
}

</style><meta charset='utf-8'>"
        . "<table  border=1 cellspacing=0 cellpadding=2 bordercolor='666633' width=100%>  "
        . "<tr><th>Matrícula</th><th>Nome</th><th>Quantidade de Parcelas Pagas</th></tr>";
        @$teste = 1;
        $totalparcelas = 0;
        while (!feof($arquivo2)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo2, 1024);

            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z") {
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                   $codigo_retornno =  substr($linha, 67, 2);                            
//////////////////fazendo a consulta de acordo com o numero do paciente do arquivo
                $data['lista_paciente2'] = $this->guia->listarpacienteimportadopagos($paciente_id);
                            
////////////////para não dublicar os pacientes achados
                if (!(@$verificar2{$data['lista_paciente2'][0]->paciente_id} == 1)) {                
                     if (@$data['lista_paciente2'][0]->paciente_id != "" && $codigo_retornno == "00") {
                        echo "<tr><td><b  id='achado' >" . @$data['lista_paciente2'][0]->paciente_id . "</b></td>"
                        . "<td><b id='achado'  >" . @$data['lista_paciente2'][0]->paciente . "</b></td>"
                        . "<td><b id='achado'  >" . @$contador_parcelas{$paciente_id} . "</b></td></tr>";                         
                        @$verificar2{$data['lista_paciente2'][0]->paciente_id} ++;
                        @$totalpacientes++;
                        @$totalparcelas += @$contador_parcelas{$paciente_id};
                    } 
                }
                            
            }
            
            
        }
        echo " <tr><th colspan='2'>Quantidade de Pacientes:" . @$totalpacientes . "</th><th>Total Parcelas:" . @$totalparcelas . "</th></tr></table>";
// Fecha arquivo aberto
        fclose($arquivo2);
        
////////////////////////////////////////////////     
//PARCELAS COM ERRO
//abrindo novamente
         $totalcomerro = 0;
        $arquivo4= fopen('./upload/retornoimportados/todos/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        echo " <meta charset='utf-8'>";
        echo "<hr>";
        echo "<table  border=1 cellspacing=0 cellpadding=2 bordercolor='666633' width=50%> ";
        echo "<tr><th colspan='2'>Parcelas com erros</th><th colspan='2'>Código do erro</th></tr>";
        while (!feof($arquivo4)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo4, 1024);
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z") {
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                $codigo_retornno =  substr($linha, 67, 2);
                            
                //fazendo a consulta de acordo com o numero do paciente do arquivo
              $data['lista_paciente3'] = $this->guia->listarpacienteimportadopagos($paciente_id);                
              if(@$data['lista_paciente3'][0]->paciente_id != "" && $codigo_retornno != "00"){ 
                     if (@$cont4{$data['lista_paciente3'][0]->paciente_id} == 0) { 
                         $totalcomerro++;
                            
                       echo "<tr><td><b  id='achadoERRO' >" . @$data['lista_paciente3'][0]->paciente_id . "</b></td>"
                        . "<td><b id='achadoERRO'  >" . @$data['lista_paciente3'][0]->paciente . "</b></td>"
                        . "<td><b id='achadoERRO'  > ";
                       foreach($Array as $item => $value){ 
                           $contvirgula = 0;
                           if ($item == $paciente_id) {
                            foreach($value as $code){
                                $contvirgula++;
                                echo $code;
                                if (count($value) > $contvirgula) {
                                    echo " , ";                                    
                                }                             
                              }
                           }                           
                       }
                       echo " </b></td></tr>"; 
                       @$cont4{$data['lista_paciente3'][0]->paciente_id}++;
                  }                                               
              }
                            
            }
        }
        echo "<tr><td colspan='1'>Total</td><td colspan='2'>".$totalcomerro."</td></tr>";
        echo " </table>";
        // Fecha arquivo aberto
        fclose($arquivo4);                          
////////////////////////////////////////////       
//abrindo novamente
        $arquivo3 = fopen('./upload/retornoimportados/todos/' . $chave_pasta . '/' . $nome_arquivo . '', 'r');
        echo " <meta charset='utf-8'>";
        
          
        echo "<table  border=1 cellspacing=0 cellpadding=2 bordercolor='666633' width=50%>  ";
        echo "<br>";
        echo "<tr><th colspan='2'>Matrículas não encontradas</th></tr>";
        while (!feof($arquivo3)) {
            //Mostra uma linha do arquivo 
            $linha = fgets($arquivo3, 1024);
            if (substr($linha, 0, 1) != "A" && substr($linha, 0, 1) != "Z") {
                //pegando uma coluna especifica com o substr
                $paciente_id = substr($linha, 1, 25);
                //fazendo a consulta de acordo com o numero do paciente do arquivo
                $data['lista_paciente3'] = $this->guia->listarpacienteimportadopagos($paciente_id);
                if (!(@$verificar3{$data['lista_paciente3'][0]->paciente_id} == 1)) {
                    if (!(@$data['lista_paciente3'][0]->paciente_id != "")) {
                          echo "<tr><td><b  id='naoachado' style='' >" . @ $paciente_id = substr($linha, 1, 25) . "</b></td><td><b  id='naoachado' >Matrícula Não Encontrada</b></td></tr>";
                    }  
                } 
            }
        }
        echo " </table>";
        // Fecha arquivo aberto
        fclose($arquivo3);
        
                            
    }

    function cancelarparcela($paciente_id = NULL, $contrato_id = NULL, $paciente_contrato_parcelas_id = NULL) {


        $this->guia->cancelarparcela($paciente_id, $contrato_id, $paciente_contrato_parcelas_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluircontratoempresaadmin($contrato_id) {

        $ambulatorio_guia_id = $this->guia->excluircontratoempresaadmin($contrato_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluircontratoempresa($contrato_id) {
//   

        $ambulatorio_guia_id = $this->guia->excluircontratoempresa($contrato_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function ativarcontratoempresa($contrato_id) {
//        var_dump($contrato_id); die;
        $ambulatorio_guia_id = $this->guia->ativarcontratoempresa($contrato_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function listarpagamentosempresa($paciente_contrato_id = NULL, $empresa_cadastro_id = NULL) {

        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontratoempresacontrato($paciente_contrato_id);
        $data['empresa_cadastro_id'] = $empresa_cadastro_id;
        $data['empresapermissao'] = $this->empresa->listarpermissoes();
        $data['contrato_id'] = $paciente_contrato_id;
        $this->loadView('ambulatorio/guiapagamentoempresacadastro-form', $data);
    }

    function alterardatapagamentoempresacadastro($contrato_id, $paciente_contrato_parcelas_id) {
//        var_dump($paciente_contrato_parcelas_id); die;
        $data['paciente_contrato_parcelas_id'] = $paciente_contrato_parcelas_id;
        $data['contrato_id'] = $contrato_id;
        $data['pagamento'] = $this->guia->listarparcelaalterardata($paciente_contrato_parcelas_id);
//        var_dump($data['pagamento']); die;
        $this->load->View('ambulatorio/alterardatapagamento-form', $data);
    }

    function excluirparcelacontratoempresacadastro($parcela_id, $empresa_cadastro_id) {




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

        $ambulatorio_guia_id = $this->guia->excluirparcelacontratoempresacadastro($parcela_id);

//        echo  "<pre>";
//         
//        echo $parcela_id;
//        print_r($pagamento_iugu);die;


        if ($ambulatorio_guia_id == "-1") {
            $data['mensagem'] = 'Erro ao excluir parcela';
        } else {
            $data['mensagem'] = 'Sucesso ao excluir parcela.';
        }

        $data['paciente_id'] = $paciente_id;
        $data['ambulatorio_guia_id'] = $ambulatorio_guia_id;
//        $data['procedimento'] = $this->procedimento->listarprocedimentos();

        redirect(base_url() . "ambulatorio/guia/listarpagamentosempresa/$contrato_id/$empresa_cadastro_id");
    }

    function listarimpressoescarteria($paciente_contrato_dependente_id) {

        $data['impressoes'] = $this->guia->listarimpressoescarteira($paciente_contrato_dependente_id);
        $this->load->View('ambulatorio/impressoescarteira', $data);
    }

    function alterarplano() {
        $paciente_id = $_POST['paciente_id'];
        @$empresa_cadastro_id = @$_POST['empresa_cadastro_id'];
        $plano_id = $_POST['plano'];

        $verificar = $this->guia->verificarempresaplano($empresa_cadastro_id, $plano_id);



        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function cancelarparcelaempresa($paciente_contrato_parcelas_id = NULL) {
        $this->guia->cancelarparcelaempresa($paciente_contrato_parcelas_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function confirmarpagamentoempresa($paciente_contrato_parcelas_id, $empresa_cadastro_id) {

        $res = $this->guia->funcionariosempresa($empresa_cadastro_id);

        foreach ($res as $item) {
            $this->guia->confirmarparcelaverificadora($item->paciente_contrato_id);
        }


        if ($this->guia->confirmarpagamentoautomaticoiuguempresa($paciente_contrato_parcelas_id)) {
            $mensagem = 'Sucesso ao confirmar pagamento';
        } else {
            $mensagem = 'Erro ao confirmar pagamento. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    public function gerarpagamentogerencianet($paciente_id, $contrato_id, $paciente_contrato_parcelas_id, $dependente_id = NULL) {


        $cliente = $this->paciente->listardados($paciente_id);



        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
        $email = $cliente[0]->cns;


//        print_r($cliente);;

        $empresa = $this->guia->listarempresa();
        $empresa[0]->client_id;

        $empresa[0]->client_secret;


        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            $mensagem = "Client ID ou Client Secret não cadastradas.";
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
            return;
        }

        $pagamento = $this->paciente->listarpagamentoscontratoparcelaGN($paciente_contrato_parcelas_id);



        $data_vencimento = $pagamento[0]->data;
        $paciente = $cliente[0]->nome;
        $cpf = $cliente[0]->cpf;
//        $cpf = "2121";
//        echo "<pre>";
//        print_r($pagamento);
//        die;


        if ($cliente[0]->celular != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        } elseif ($cliente[0]->telefone != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->telefone);
        } else {
            $telefone = "";
        }

        $nome_produto = "Parcela";
        $quantidade = '1';
        $valor = $pagamento[0]->valor * 100;
        $data_nascimento = $cliente[0]->nascimento;
        if ($telefone == "") {
            $mensagem = "Erro, Telefone ou Celular do cliente não cadastrados.";
        } elseif ($data_nascimento == "") {
            $mensagem .= "Data de nascimento,";
        } elseif ($cpf == "") {
            $mensagem .= "Erro, CPF do cliente não cadastrado.";
        } elseif ($paciente == "") {
            $mensagem .= "Erro, Nome do paciente não cadastrado";
        } elseif ($pagamento[0]->valor < 5 || $pagamento[0]->valor == "") {
            $mensagem .= "Erro, Valor tem que ser Maior ou Igual a R$ 5,00";
        } elseif (@$data_vencimento < date('Y-m-d')) {
            $mensagem .= "Erro, Data de vencimento é inferior a data de hoje!";
        } else {

            $options = [
                'client_id' => $empresa[0]->client_id, // insira seu Client_Id, conforme o ambiente (Des ou Prod)
                'client_secret' => $empresa[0]->client_secret, // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];
            $item_1 = [
                'name' => 'Parcela', // nome do item, produto ou serviço
                'amount' => 1, // quantidade
                'value' => $valor, // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
            ];
//        $item_2 = [
//            'name' => 'Item 2', // nome do item, produto ou serviço
//            'amount' => 2, // quantidade
//            'value' => 500 // valor (2000 = R$ 20,00)
//        ];

            $items = [
                $item_1
            ];

//        $metadata = ['notification_url' => ''];

            $body = [
                'items' => $items
//                ,
//            'metadata' => $metadata
            ];

            if ($pagamento[0]->charge_id == "" || $pagamento[0]->charge_id == 0 || $pagamento[0]->charge_id == null) {

                try {
                    $api = new Gerencianet($options);
                    $charge = $api->createCharge([], $body);
                    echo "<pre>";
                    print_r($charge);

                    $gravar = $this->guia->gravarintegracaogerencianet($charge['data']['charge_id'], $paciente_contrato_parcelas_id, $charge['data']['link'], $charge['data']['pdf']['charge'], $charge['data']['status']);
                } catch (GerencianetException $e) {
                    print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);
                    $mensagem = "Erro, entre em contato com Suporte!";
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            }


            if ($pagamento[0]->charge_id == "" || $pagamento[0]->charge_id == 0 || $pagamento[0]->charge_id == null) {
                $charge_id = $charge['data']['charge_id'];
            } else {
                $charge_id = $pagamento[0]->charge_id;
            }


            $params = [
                'id' => $charge_id
            ];

            $customer = [
                'name' => $paciente, // nome do cliente
                'cpf' => $cpf, // cpf válido do cliente
                'phone_number' => $telefone, // telefone do cliente
                'birth' => $data_nascimento, // data de aniversario do cliente
                'email' => $email
            ];

            $bankingBillet = [
                'expire_at' => $data_vencimento, // data de vencimento do boleto (formato: YYYY-MM-DD)
                'customer' => $customer
            ];

            $payment = [
                'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
            ];

            $body = [
                'payment' => $payment
            ];


            try {
                $api = new Gerencianet($options);
                $charge = $api->payCharge($params, $body);
//                 echo "<pre>";
//                 print_r($charge); 
//                 die;
                $mensagem = 'Cobrança gerada com sucesso!';
                $this->guia->atualizarintegracaogerencianet($charge['data']['charge_id'], $paciente_contrato_parcelas_id, $charge['data']['link'], $charge['data']['pdf']['charge'], $charge['data']['status']);
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
                if (@$e->errorDescription['property'] == "/payment/banking_billet/customer/phone_number") {
                    $erro = ", Telefone inválido!";
                } elseif ($e->errorDescription == ", Cpf (11111111111) inválido") {

                    $erro = $e->errorDescription;
                } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/email") {
                    $erro = ", Email inválido!";
                } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/cpf") {
                    $erro = ", CPF inválido!";
                } else {
                    $erro = "";
                }
                $mensagem = "Erro" . @$erro;
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }



        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    public function reenviaremailgerencianet($paciente_id, $contrato_id, $charge_id) {
        $cliente = $this->paciente->listardados($paciente_id);

        $email = $cliente[0]->cns;


        $empresa = $this->guia->listarempresa();
        $empresa[0]->client_id;



        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            
        } else {

            $clientId = $empresa[0]->client_id; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
            $clientSecret = $empresa[0]->client_secret;
            // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

            $options = [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];

// $charge_id refere-se ao ID da transação ("charge_id")
            $params = [
                'id' => $charge_id
            ];

            $body = [
                'email' => $email
            ];

            try {
                $api = new Gerencianet($options);
                $response = $api->resendBillet($params, $body);

                $mensagem = "Sucesso ao Re-enviar Email Gerencianet";
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);

                $mensagem = "Erro ao Re-enviar Email Gerencianet";
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }


        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function gerartodosgerencianet($paciente_id, $contrato_id) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
        $email = $cliente[0]->cns;

        $empresa = $this->guia->listarempresa();

        $empresa[0]->client_id;

        $empresa[0]->client_secret;

        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            $mensagem = "Client ID ou Client Secret não cadastradas.";
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
            return;
        }

        $paciente = $cliente[0]->nome;
        $cpf = $cliente[0]->cpf;

        if ($cliente[0]->celular != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        } elseif ($cliente[0]->telefone != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->telefone);
        } else {
            $telefone = "";
        }



        $pagamento = $this->paciente->listarpagamentoscontratoparcelagerencianettodos($contrato_id);


//        echo "<pre>";
//        print_r($pagamento);die;

        $data_nascimento = $cliente[0]->nascimento;

        if ($telefone == "") {
            $mensagem = "Erro, Telefone ou Celular do cliente não cadastrados.";
        } elseif ($data_nascimento == "") {
            $mensagem .= "Data de nascimento,";
        } elseif ($cpf == "") {
            $mensagem .= "Erro, CPF do cliente não cadastrado.";
        } elseif ($paciente == "") {
            $mensagem .= "Erro, Nome do paciente não cadastrado";
        } else {

            foreach ($pagamento as $value) {

                if ($this->session->userdata('cadastro') == 2) {
                    if ($value->paciente_dependente_id != "") {
                        $cliente = $this->paciente->listardados($value->paciente_dependente_id);
                    } else {
                        $cliente = $this->paciente->listardados($paciente_id);
                    }


                    $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
                    $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
                    $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
                    $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
                    $email = $cliente[0]->cns;
                    $data_nascimento = $cliente[0]->nascimento;

                    $paciente = $cliente[0]->nome;
                    $cpf = $cliente[0]->cpf;

                    if ($cliente[0]->celular != "") {
                        $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
                    } elseif ($cliente[0]->telefone != "") {
                        $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->telefone);
                    } else {
                        $telefone = "";
                    }

                    if ($telefone == "") {
                        $mensagem = "Erro, Telefone ou Celular do cliente não cadastrados.";
                        continue;
                    } elseif ($data_nascimento == "") {
                        $mensagem .= "Data de nascimento,";
                        continue;
                    } elseif ($cpf == "") {
                        $mensagem .= "Erro, CPF do cliente não cadastrado.";
                        continue;
                    } elseif ($paciente == "") {
                        $mensagem .= "Erro, Nome do paciente não cadastrado";
                        continue;
                    }
//                        echo $paciente;      
                }


                $data_vencimento = $value->data;

                if ($value->valor < 5 || $value->valor == "") {
                    $mensagem = "Erro, Valor tem que ser Maior ou Igual a R$ 5,00";
                } elseif ($data_vencimento < date('Y-m-d')) {
                    $mensagem = "Erro, Data de vencimento é inferior a data de hoje!";
                } else {
                    $nome_produto = "Parcela";
                    $quantidade = '1';
                    $valor = $value->valor * 100;

                    $options = [
                        'client_id' => $empresa[0]->client_id, // insira seu Client_Id, conforme o ambiente (Des ou Prod)
                        'client_secret' => $empresa[0]->client_secret, // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
                        'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
                    ];
                    $item_1 = [
                        'name' => 'Parcela', // nome do item, produto ou serviço
                        'amount' => 1, // quantidade
                        'value' => $valor, // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
                    ];
//        $item_2 = [
//            'name' => 'Item 2', // nome do item, produto ou serviço
//            'amount' => 2, // quantidade
//            'value' => 500 // valor (2000 = R$ 20,00)
//        ];

                    $items = [
                        $item_1
                    ];

//        $metadata = ['notification_url' => ''];

                    $body = [
                        'items' => $items
//                ,
//            'metadata' => $metadata
                    ];

                    if ($value->charge_id == "" || $value->charge_id == 0 || $value->charge_id == null) {

                        try {
                            $api = new Gerencianet($options);
                            $charge = $api->createCharge([], $body);
                            echo "<pre>";
                            print_r($charge);

                            $gravar = $this->guia->gravarintegracaogerencianet($charge['data']['charge_id'], $value->paciente_contrato_parcelas_id);
                        } catch (GerencianetException $e) {
                            print_r($e->code);
                            print_r($e->error);
                            print_r($e->errorDescription);
                            $mensagem = "Erro, entre em contato com Suporte!";
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }
                    }
                    if ($value->charge_id == "" || $value->charge_id == 0 || $value->charge_id == null) {
                        $charge_id = $charge['data']['charge_id'];
                    } else {
                        $charge_id = $value->charge_id;
                    }

                    $params = [
                        'id' => $charge_id
                    ];


                    $customer = [
                        'name' => $paciente, // nome do cliente
                        'cpf' => $cpf, // cpf válido do cliente
                        'phone_number' => $telefone, // telefone do cliente
//                        'birth' => $data_nascimento, // data de aniversario do cliente
                        'email' => $email
                    ];

                    $bankingBillet = [
                        'expire_at' => $data_vencimento, // data de vencimento do boleto (formato: YYYY-MM-DD)
                        'customer' => $customer
                    ];

                    $payment = [
                        'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
                    ];

                    $body = [
                        'payment' => $payment
                    ];

                    try {
                        $api = new Gerencianet($options);
                        $charge = $api->payCharge($params, $body);
//                 echo "<pre>";
//                 print_r($charge); die;
                        $gravar = $this->guia->atualizarintegracaogerencianet($charge['data']['charge_id'], $value->paciente_contrato_parcelas_id, $charge['data']['link'], $charge['data']['pdf']['charge']);
                        $mensagem = 'Cobrança gerada com sucesso';
                    } catch (GerencianetException $e) {
//                        print_r($e->code);
//                        print_r($e->error);
//                        print_r($e->errorDescription);

                        if (@$e->errorDescription['property'] == "/payment/banking_billet/customer/phone_number") {
                            $erro = ", Telefone inválido!";
                        } elseif ($e->errorDescription == ", Cpf (11111111111) inválido") {

                            $erro = $e->errorDescription;
                        } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/email") {
                            $erro = ", Email inválido!";
                        } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/cpf") {
                            $erro = ", CPF inválido!";
                        } else {
                            $erro = "";
                        }

                        $mensagem = "Erro" . @$erro;


//                        die;
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
            }
//            die;
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

    function gerarpagamentogerencianetconsultaavulsa($paciente_id, $contrato_id, $consultas_avulsas_id, $tipo = NULL) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
        $email = $cliente[0]->cns;

//        print_r($cliente);;

        $empresa = $this->guia->listarempresa();
        $empresa[0]->client_id;

        $empresa[0]->client_secret;

        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            $mensagem = "Client ID ou Client Secret não cadastradas.";
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
            return;
        }

        $pagamento = $this->paciente->listarpagamentoscontratoconsultaavulsaGN($consultas_avulsas_id);

        $data_vencimento = $pagamento[0]->data;
        $paciente = $cliente[0]->nome;
        $cpf = $cliente[0]->cpf;

//        echo "<pre>";
//        print_r($pagamento);die;


        if ($cliente[0]->celular != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        } elseif ($cliente[0]->telefone != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->telefone);
        } else {
            $telefone = "";
        }

        $nome_produto = "Parcela";
        $quantidade = '1';
        $valor = $pagamento[0]->valor * 100;
        $data_nascimento = $cliente[0]->nascimento;

        if ($telefone == "") {
            $mensagem = "Erro, Telefone ou Celular do cliente não cadastrados.";
        } elseif ($data_nascimento == "") {
            $mensagem .= "Data de nascimento,";
        } elseif ($cpf == "") {
            $mensagem .= "Erro, CPF do cliente não cadastrado.";
        } elseif ($paciente == "") {
            $mensagem .= "Erro, Nome do paciente não cadastrado";
        } elseif ($pagamento[0]->valor < 5 || $pagamento[0]->valor == "") {
            $mensagem .= "Erro, Valor tem que ser Maior ou Igual a R$ 5,00";
        } elseif (@$data_vencimento < date('Y-m-d')) {
            $mensagem .= "Erro, Data de vencimento é inferior a data de hoje!";
        } else {


            $options = [
                'client_id' => $empresa[0]->client_id, // insira seu Client_Id, conforme o ambiente (Des ou Prod)
                'client_secret' => $empresa[0]->client_secret, // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];
            $item_1 = [
                'name' => 'Parcela', // nome do item, produto ou serviço
                'amount' => 1, // quantidade
                'value' => $valor, // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
            ];
//        $item_2 = [
//            'name' => 'Item 2', // nome do item, produto ou serviço
//            'amount' => 2, // quantidade
//            'value' => 500 // valor (2000 = R$ 20,00)
//        ];

            $items = [
                $item_1
            ];

//        $metadata = ['notification_url' => ''];

            $body = [
                'items' => $items
//                ,
//            'metadata' => $metadata
            ];

            if ($pagamento[0]->charge_id_GN == "" || $pagamento[0]->charge_id_GN == 0 || $pagamento[0]->charge_id_GN == null) {

                try {
                    $api = new Gerencianet($options);
                    $charge = $api->createCharge([], $body);
                    echo "<pre>";
                    print_r($charge);


                    $gravar = $this->guia->gravarintegracaogerencianetconsultaavulsaalterardata($charge['data']['charge_id'], $consultas_avulsas_id, $charge['data']['link'], $charge['data']['pdf']['charge'], $charge['data']['status']);
                } catch (GerencianetException $e) {
                    print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);
                    $mensagem = "Erro, entre em contato com Suporte!";
                } catch (Exception $e) {
                    print_r($e->getMessage());
                }
            }


            if ($pagamento[0]->charge_id_GN == "" || $pagamento[0]->charge_id_GN == 0 || $pagamento[0]->charge_id_GN == null) {
                $charge_id = $charge['data']['charge_id'];
            } else {
                $charge_id = $pagamento[0]->charge_id_GN;
            }


            $params = [
                'id' => $charge_id
            ];

            $customer = [
                'name' => $paciente, // nome do cliente
                'cpf' => $cpf, // cpf válido do cliente
                'phone_number' => $telefone, // telefone do cliente
                'birth' => $data_nascimento, // data de aniversario do cliente
                'email' => $email
            ];

            $bankingBillet = [
                'expire_at' => $data_vencimento, // data de vencimento do boleto (formato: YYYY-MM-DD)
                'customer' => $customer
            ];

            $payment = [
                'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
            ];

            $body = [
                'payment' => $payment
            ];

            try {
                $api = new Gerencianet($options);
                $charge = $api->payCharge($params, $body);
                echo "<pre>";
                print_r($charge);

                $mensagem = 'Cobrança gerada com sucesso!';
                echo$charge['data']['charge_id'];
                $this->guia->gravarintegracaogerencianetconsultaavulsaalterardata($charge['data']['charge_id'], $consultas_avulsas_id, $charge['data']['link'], $charge['data']['pdf']['charge'], $charge['data']['status']);
//                die;
            } catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);


                if (@$e->errorDescription['property'] == "/payment/banking_billet/customer/phone_number") {
                    $erro = ", Telefone inválido!";
                } elseif ($e->errorDescription == ", Cpf (11111111111) inválido") {

                    $erro = $e->errorDescription;
                } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/email") {
                    $erro = ", Email inválido!";
                } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/cpf") {
                    $erro = ", CPF inválido!";
                } else {
                    $erro = "";
                }

                $mensagem = "Erro" . @$erro;
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }


        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function listarinfo($paciente_id = NULL, $addcolum = NULL) {
        $financeiro_parceiro_id = $this->session->userdata('financeiro_parceiro_id');
        $data['lista'] = $this->guia->listarinformacoes($paciente_id);
        $data['parceiro'] = $this->guia->listarparceiro($financeiro_parceiro_id);
        $data['addcolum'] = @$addcolum;
        $this->load->View('ambulatorio/informacoesverificar-lista', $data);
    }

    function listarautorizacao($args = array()) {

        $this->loadView('ambulatorio/telautorizacao-lista', $args);

//            $this->carregarView($data);
    }

    function autorizarprocedimento($paciente_verificados_id) {
        $this->guia->autorizarprocedimento($paciente_verificados_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirautorizarprocedimento($paciente_verificados_id) {
        $this->guia->excluirautorizarprocedimento($paciente_verificados_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gerarcarnegerencianet($paciente_id, $contrato_id) {

        $cliente = $this->paciente->listardados($paciente_id);
        $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
        $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
        $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
        $email = $cliente[0]->cns;
        $empresa = $this->guia->listarempresa();
        $empresa[0]->client_id;
        $empresa[0]->client_secret;

        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            $mensagem = "Client ID ou Client Secret não cadastradas.";
            $this->session->set_flashdata('message', $mensagem);
            redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
            return;
        }

        $clientId = $empresa[0]->client_id;
        $clientSecret = $empresa[0]->client_secret;

        $paciente = $cliente[0]->nome;
        $cpf = $cliente[0]->cpf;

        if ($cliente[0]->celular != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
        } elseif ($cliente[0]->telefone != "") {
            $telefone = preg_replace('/[^\d]+/', '', $cliente[0]->telefone);
        } else {
            $telefone = "";
        }
        $pagamento = $this->paciente->listarpagamentoscontratoparcelagerencianetcarne($contrato_id);
//        echo "<pre>";
//        print_r($pagamento);
        foreach ($pagamento as $item) {
            @$contvalor{$item->valor} ++;
//            echo @$contvalor{$item->valor};
//            echo '<br>';
        }

        foreach ($pagamento as $item2) {
            if (@$contvalor2{$item2->valor} > 0) { // se o valor for pegador uma vez ele não entra na condição pois para gerar o carnê é preciso somente do valor(uma vez), quantidade(uma vez)
            } else {
                @$contvalor{$item2->valor} . " - ";
                @$contvalor2{$item2->valor} ++;

                if ($contvalor{$item2->valor} > 12) { //se a parcela for maior que 12 (o gerencianet só aceita 12) irá entrar na condição.
                    $quantidade_div = $contvalor{$item2->valor} - 12; //pega a quantidade total diminui 12, e gera um carne com o resultado.
                    $carnes[] = array('quantidade' => 12, 'valor' => $item2->valor, 'data' => $item2->data);
                    $carnes[] = array('quantidade' => $quantidade_div, 'valor' => $item2->valor, 'data' => $item2->data);
                } else {
                    $carnes[] = array('quantidade' => $contvalor{$item2->valor}, 'valor' => $item2->valor, 'data' => $item2->data);
                }
            }
        }

        $data_nascimento = $cliente[0]->nascimento;

        if ($telefone == "") {
            $mensagem = "Erro, Telefone ou Celular do cliente não cadastrados.";
        } elseif ($data_nascimento == "") {
            $mensagem .= "Data de nascimento,";
        } elseif ($cpf == "") {
            $mensagem .= "Erro, CPF do cliente não cadastrado.";
        } elseif ($paciente == "") {
            $mensagem .= "Erro, Nome do paciente não cadastrado";
        } else {
//            $data_vencimento = $pagamento[0]->data;
//            $quantidade_parcelas = count($pagamento);
//            $preco_parcela = $pagamento[0]->valor * 100;

            foreach ($carnes as $value) {
                @$qtd{$value['quantidade']} = @$value['quantidade'];
//sistema atual de carne só funciona com 23 e 24 parcelas
                if ($value['quantidade'] == 12) {
                    @$qtd_f = @$qtd{$value['quantidade']};
                } else {
                    @$qtd_f = @$qtd{$value['quantidade']} + 1;
                }
                if (@$validade_q{$value['valor']} >= 1) { // $validade_q{$value['valor']} é um contador 
                    $validade{$value['data']} = date("Y-m-d", strtotime("+$qtd_f month", strtotime($value['data'])));
                    $datavv = $validade{$value['data']};
                } else {
                    $validade{$value['data']} = date("Y-m-d", strtotime("+0 month", strtotime($value['data'])));
                    $datavv = $validade{$value['data']};
                    @$validade_q{$value['valor']} ++;
                }
                $datavv = $validade{$value['data']};


                if ($value['valor'] < 5 || $value['valor'] == "") {
                    $mensagem = "Erro, Valor tem que ser Maior ou Igual a R$ 5,00";
                } elseif ($value['data'] < date('Y-m-d')) {
                    $mensagem = "Erro, Data de vencimento é inferior a data de hoje! Parcela com data:" . $value['data'];
                } else {
                    $options = [
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
                    ];

                    $item_1 = [
                        'name' => 'Parcela', // nome do item, produto ou serviço
                        'amount' => 1, // quantidade
                        'value' => $value['valor'] * 100 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
                    ];

//                   echo $value['valor'];

                    $items = [
                        $item_1
                            // ,
                            // $item_2
                    ];



                    if ($email == "") {
                        $customer = [
                            'name' => $paciente, // nome do cliente
                            'cpf' => $cpf, // cpf do cliente
                            'phone_number' => $telefone  // telefone do cliente               
                        ];
                    } else {
                        $customer = [
                            'name' => $paciente, // nome do cliente
                            'cpf' => $cpf, // cpf do cliente
                            'phone_number' => $telefone, // telefone do cliente
                            'email' => $email
                        ];
                    }



                    $body = [
                        'items' => $items,
                        'customer' => $customer,
                        'expire_at' => $datavv, // data de vencimento da primeira parcela do carnê
                        'repeats' => $value['quantidade'], // número de parcelas do carnê
                        'split_items' => false
                    ];

                    try {
                        $api = new Gerencianet($options);
                        $carnet = $api->createCarnet([], $body);
//                        echo "<pre>";
//                    print_r($carnet);
                        @$ci = 0;
                        foreach ($carnet['data']['charges'] as $item) {
                            @$ci++;
                            $url = $item['url'];
                            $pdf = $item['pdf']['charge'];
                            $link_carne = $carnet['data']['link'];
                            $cover_carne = $carnet['data']['cover'];
                            $pdf_carnet = $carnet['data']['pdf']['carnet'];
                            $pdf_cover_carne = $carnet['data']['pdf']['cover'];
                            $carnet_id = $carnet['data']['carnet_id'];
                            $pagamentoupdate = $this->paciente->listarpagamentoscontratoparcelagerencianetcarneupdate($contrato_id, $value['valor']);

//                            print_r($pagamentoupdate);
//                            die;
                            $gravar = $this->guia->gravarintegracaogerencianet($item['charge_id'], $pagamentoupdate[0]->paciente_contrato_parcelas_id);
                            $this->guia->atualizarintegracaogerencianetcarne($item['charge_id'], $pagamentoupdate[0]->paciente_contrato_parcelas_id, $url, $pdf, $link_carne, $cover_carne, $pdf_carnet, $pdf_cover_carne, $carnet_id, $ci);
                        }
                    } catch (GerencianetException $e) {
                        $messageErrorDefault = 'Ocorreu um erro ao tentar realizar a sua requisição. Entre em contato com o proprietário.';
//                        print_r($e->code);echo "<br>";
//                       print_r($e->error);echo "<br>";
//                       print_r($e->errorDescription);die;
                        @$property = $e->errorDescription['message'];



//                        if (@$e->errorDescription['property'] == "/payment/banking_billet/customer/phone_number") {
//                            $erro = ", Telefone inválido!";
//                        } elseif ($e->errorDescription == ",Cpf (11111111111) inválido") {
//
//                            $erro = $e->errorDescription;
//                        } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/email") {
//                            $erro = ", Email inválido!";
//                        } elseif (@$e->errorDescription['property'] == "/payment/banking_billet/customer/cpf") {
//                            $erro = ", CPF inválido!";
//                        } else {
//                            $erro = " , ".$e->errorDescription['property'];
//                        }
//                        $mensagem = "Erro" . @$erro;


                        switch ($e->code) {
                            case 3500000:
                                $message = 'Erro interno do servidor.';
                                break;
                            case 3500001:
                                $message = $messageErrorDefault;
                                break;
                            case 3500002:
                                $message = $messageErrorDefault;
                                break;
                            case 3500007:
                                $message = 'O tipo de pagamento informado não está disponível.';
                                break;
                            case 3500008:
                                $message = 'Requisição não autorizada.';
                                break;
                            case 3500010:
                                $message = $messageErrorDefault;
                                break;
                            case 3500016:
                                $message = 'A transação deve possuir um cliente antes de ser paga.';
                                break;
                            case 3500021:
                                $message = 'Não é permitido parcelamento para assinaturas.';
                                break;
                            case 3500030:
                                $message = 'Esta transação já possui uma forma de pagamento definida.';
                                break;
                            case 3500034:
                                $message = $e->errorDescription['message'];
//				if($property == 'items' || $property == 'customer')
//				{
//					$message = $messageErrorDefault;
//					$messageAdmin = 'O campo ' . $this->getFieldName($property) . ' não está preenchido corretamente: ';
//				}
//				elseif(strpos($property, 'instructions/') !== false || strpos($property, 'message') !== false || strpos($property, 'interest') !== false || strpos($property, 'fine') !== false)
//				{
//					$message = $messageErrorDefault;
//					$messageAdmin = $this->getFieldName($property);
//				}
//				else{
//					$message = 'O campo ' . $this->getFieldName($property) . ' não está preenchido corretamente: ';
//				}
                                break;
                            case 3500036:
                                $message = 'A forma de pagamento da transação não é boleto bancário.';
                                break;
                            case 3500042:
                                $message = $messageErrorDefault;
                                $messageAdmin = 'O parâmetro [data] deve ser um JSON.';
                                break;
                            case 3500044:
                                $message = 'A transação não pode ser paga. Entre em contato com o vendedor.';
                                break;
                            case 4600002:
                                $message = $messageErrorDefault;
                                break;
                            case 4600012:
                                $message = 'Ocorreu um erro ao tentar realizar o pagamento: ' . @$property;
                                break;
                            case 4600022:
                                $message = $messageErrorDefault;
                                break;
                            case 4600026:
                                $message = 'cpf inválido';
                                break;
                            case 4600029:
                                $message = 'pedido já existe';
                                break;
                            case 4600032:
                                $message = $messageErrorDefault;
                                break;
                            case 4600035:
                                $message = 'Serviço indisponível para a conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
                                break;
                            case 4600037:
                                $message = 'O valor da emissão é superior ao limite operacional da conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
                                break;
                            case 4600073:
                                $message = 'O telefone informado não é válido.';
                                break;
                            case 4600111:
                                $message = 'valor de cada parcela deve ser igual ou maior que R$5,00';
                                break;
                            case 4600142:
                                $message = 'Transação não processada por conter incoerência nos dados cadastrais.';
                                break;
                            case 4600148:
                                $message = 'já existe um pagamento cadastrado para este identificador.';
                                break;
                            case 4600196:
                                $message = $messageErrorDefault;
                                break;
                            case 4600204:
                                $message = 'cpf deve ter 11 dígitos';
                                break;
                            case 4600209:
                                $message = 'Limite de emissões diárias excedido. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
                                break;
                            case 4600210:
                                $message = 'não é possível emitir três emissões idênticas. Por favor, entre em contato com nosso suporte para orientações sobre o uso correto dos serviços Gerencianet.';
                                break;
                            case 4600212:
                                $message = 'Número de telefone já associado a outro CPF. Não é possível cadastrar o mesmo telefone para mais de um CPF.';
                                break;
                            case 4600222:
                                $message = 'Recebedor e cliente não podem ser a mesma pessoa.';
                                break;
                            case 4600219:
                                $message = 'Ocorreu um erro ao validar seus dados: ' . @$property;
                                break;
                            case 4600224:
                                $message = $messageErrorDefault;
                                break;
                            case 4600254:
                                $message = 'identificador da recorrência não foi encontrado';
                                break;
                            case 4600257:
                                $message = 'pagamento recorrente já executado';
                                break;
                            case 4600329:
                                $message = 'código de segurança deve ter três digitos';
                                break;
                            case 4699999:
                                $message = 'falha inesperada';
                                break;
                            default:
                                $message = $messageErrorDefault;
                                break;
                        }

                        $this->paciente->gravarerrogerencianet($paciente_id, $contrato_id, $message, $e->code);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }
            }
        }

        if (@$message == "") {
            @$message = "Sucesso ao gerar Carnês";
        }

//        die;
        $this->session->set_flashdata('message', $message);
//        redirect(base_url() . "ambulatorio/guia/relatoriocaixa", $data);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    public function reenviaremailgerencianetcarne($paciente_id, $contrato_id, $carnet_id) {
        $cliente = $this->paciente->listardados($paciente_id);

        $email = $cliente[0]->cns;


        $empresa = $this->guia->listarempresa();
        $empresa[0]->client_id;



        if ($empresa[0]->client_id == "" || $empresa[0]->client_secret == "") {
            
        } else {


            $clientId = $empresa[0]->client_id; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
            $clientSecret = $empresa[0]->client_secret;
            // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

            $options = [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
            ];

// $carnet_id refere-se ao ID do carnê desejado
            $params = [
                'id' => $carnet_id
            ];

            $body = [
                'email' => $email
            ];

            try {
                $api = new Gerencianet($options);
                $response = $api->resendCarnet($params, $body);
//                print_r($response);

                $mensagem = "Sucesso ao Re-enviar Email Gerencianet";
            } catch (GerencianetException $e) {
//                print_r($e->code);
//                print_r($e->error);
//                print_r($e->errorDescription);
                $mensagem = "Erro ao Re-enviar Email Gerencianet";
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }


        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/guia/listarpagamentos/$paciente_id/$contrato_id");
    }

    function listarlinkscarne($contrato_id) {
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontrato($contrato_id);

        $this->load->View('ambulatorio/linkscane-lista', $data);
    }

    function gravarobservacaopaciente($paciente_id) {

        $this->guia->gravarobservacaocontrato($paciente_id);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function excluirobservacao($observacao_contrato_id) {
        $this->guia->excluirobservacao($observacao_contrato_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function impressaodeclaracaopaciente($paciente_id) {

        $this->load->helper('directory');
        $empresa_id = $this->session->userdata('empresa_id');

        if (!is_dir("./upload/empresalogo")) {
            mkdir("./upload/empresalogo");
            $destino = "./upload/empresalogo";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/empresalogo/$empresa_id")) {
            mkdir("./upload/empresalogo/$empresa_id");
            $destino = "./upload/empresalogo/$empresa_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("./upload/empresalogo/$empresa_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['empresa_id'] = $empresa_id;

        $data['empresa'] = $this->empresa->listardadosempresacadastro($empresa_id);
        //var_dump($data['empresa']); die;

        $data['paciente'] = $this->paciente->listardadospaciente($paciente_id);
        $data['paciente_id'] = $paciente_id;
        // if($data['empresa'][0]->tipo_declaracao == 2){
        //     $this->load->View('ambulatorio/impressaodeclaracaopacientemodelo2', $data);
        // }else{
        //     $this->load->View('ambulatorio/impressaodeclaracaopaciente', $data);
        // }
        $this->load->View('ambulatorio/impressaodeclaracaopaciente', $data);
       
    }

    
     function impressaorecibocontrato($contrato_id,$paciente_id) {
        $empresa_id =  $this->session->userdata('empresa_id');
         
        $data['empresa'] = $this->guia->listarempresa($empresa_id);                   
        $data['pagamentos'] = $this->paciente->listarparcelaspagas($contrato_id); 
        $data['paciente'] = $this->paciente->listardados($paciente_id); 
        $this->load->View('ambulatorio/impressaorecibocontrato', $data); 
    }
    
    function relatorioprevisaorecebimento() { 
        $this->loadView('ambulatorio/relatorioprevisaorecebimento');
    }
    
    
      function gerarelatorioprevisaorecebimento() { 
        $empresa_id =  $this->session->userdata('empresa_id'); 
        $data['empresa'] = $this->guia->listarempresa($empresa_id); 
        $data['relatorio'] = $this->guia->relatorioprevisaorecebimento();
        $data['consultaavulsas'] = $this->guia->recebimentoconsultaavulsa();
        $data['consultacoop'] = $this->guia->recebimentoconsultacoop();
        $this->load->View('ambulatorio/impressaorelatorioprevisaorecebimento', $data);
    }
    
    function excluircontratodependente($paciente_id, $paciente_contrato_dependente_id) {
        if ($this->guia->excluircontratodependente($paciente_id, $paciente_contrato_dependente_id)) {
            $mensagem = 'Sucesso ao excluir a dependente';
        } else {
            $mensagem = 'Erro ao excluir a dependente. Opera&ccedil;&atilde;o cancelada.';
        } 
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }
    
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
