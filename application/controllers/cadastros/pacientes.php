<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");

class pacientes extends BaseController {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/indicacao_model', 'indicacao');
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->library('utilitario');
        $this->load->library('email');
        $this->load->library('mensagem');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    public function index() {
        $this->pesquisar();
    }

    public function pesquisar($limite = 50) {
        $data["limite_paginacao"] = $limite;
        $this->loadView('cadastros/pacientes-lista', $data);
    }

    public function pesquisarsubstituir($args = array()) {
        $data['paciente_temp_id'] = $args;
        $this->loadView('cadastros/pacientes-listasubstituir', $data);
    }

    function novo() {
        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();
        $this->loadView('cadastros/paciente-ficha_1', $data);
    }

    function novoalternativo() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();
        $this->loadView('cadastros/paciente-ficha_1alternativo', $data);
    }

    function novodependente() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();

        $this->loadView('cadastros/paciente-fichadependente_1', $data);
    }

    function novodependentealternativo() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();

        $this->loadView('cadastros/paciente-fichadependente', $data);
    }

    function novo2() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $this->loadView('cadastros/paciente-ficha', $data);
    }

    function substituirambulatoriotemp($paciente_id, $paciente_temp_id) {
        $paciente_id = $this->exametemp->substituirpacientetemp($paciente_id, $paciente_temp_id);
        if ($paciente_id == 0) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/exametemp");
    }

    function anexarimagem($paciente_id) {

        $this->load->helper('directory');
        if (!is_dir("./upload/paciente/$paciente_id")) {
            mkdir("./upload/paciente/$paciente_id");
            $destino = "./upload/paciente/$paciente_id";
            chmod($destino, 0777);
        }
//        $data['arquivo_pasta'] = directory_map("/home/sisprod/projetos/clinica/upload/$paciente_id/");
        $data['arquivo_pasta'] = directory_map("./upload/paciente//$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['paciente_id'] = $paciente_id;
        $this->loadView('ambulatorio/importacao-imagempaciente', $data);
    }

    function importarimagem() {
        $paciente_id = $_POST['paciente_id'];
        if (!is_dir("./upload/paciente/$paciente_id")) {
            mkdir("./upload/paciente/$paciente_id");
            $destino = "./upload/paciente/$paciente_id";
            chmod($destino, 0777);
        }

        $config['upload_path'] = "./upload/paciente/" . $paciente_id . "/";
//        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/paciente/" . $paciente_id . "/";
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
        $data['paciente_id'] = $paciente_id;

        redirect(base_url() . "cadastros/pacientes/anexarimagem/$paciente_id");

//        $this->anexarimagem($paciente_id);
    }

    function excluirimagem($paciente_id, $nome) {

        if (!is_dir("./uploadopm/paciente/$paciente_id")) {
            mkdir("./uploadopm/paciente");
            mkdir("./uploadopm/paciente/$paciente_id");
            $destino = "./uploadopm/paciente/$paciente_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/paciente/$paciente_id/$nome";
        $destino = "./uploadopm/paciente/$paciente_id/$nome";
        copy($origem, $destino);
        unlink($origem);

        redirect(base_url() . "cadastros/pacientes/anexarimagem/$paciente_id");

//        $this->anexarimagem($paciente_id);
    }

    function autorizarambulatoriotemp($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetemp($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempconsulta($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempconsulta($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempfisioterapia($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempfisioterapia($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function autorizarambulatoriotempgeral($paciente_id) {

        $resultadoguia = $this->guia->listarguia($paciente_id);
        $ambulatorio_guia_id = $resultadoguia['ambulatorio_guia_id'];
        if ($ambulatorio_guia_id == 0) {
            $ambulatorio_guia_id = $this->guia->gravarguia($paciente_id);
        }
        $teste = $this->exametemp->autorizarpacientetempgeral($paciente_id, $ambulatorio_guia_id);
        if ($teste == 0) {
//            $this->gerardicom($ambulatorio_guia_id);
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } elseif ($teste == -1) {
            $data['mensagem'] = 'Erro ao gravar paciente';
        } elseif ($teste == 2) {
            $data['mensagem'] = 'ERRO: Obrigatório preencher solicitante.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/procedimentoautorizaratendimento/$paciente_id");
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/guia/pesquisar/$paciente_id");
    }

    function procedimentosubstituir($paciente_id, $paciente_temp_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['paciente_temp_id'] = $paciente_temp_id;
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendas($paciente_temp_id);
        $this->loadView('ambulatorio/procedimentosubstituir-form', $data);
    }

    function procedimentoautorizar($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspaciente($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizar-form', $data);
    }

    function procedimentoautorizarconsulta($paciente_id) {
        $data['paciente_id'] = $paciente_id;
        $data['salas'] = $this->exame->listarsalastotal();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspacienteconsulta($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizarconsulta-form', $data);
    }

    function procedimentoautorizarfisioterapia($paciente_id) {
//        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
//        if (count($lista) == 0) {
        $data['paciente_id'] = $paciente_id;
        $data['salas'] = $this->exame->listarsalastotal();
        $data['convenio'] = $this->convenio->listardados();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspacientefisioterapia($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizarfisioterapia-form', $data);
//        } else {
//            $data['mensagem'] = 'Paciente com sessões pendentes.';
//            $this->session->set_flashdata('message', $data['mensagem']);
//            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//        }
    }

    function procedimentoautorizaratendimento($paciente_id) {
        $lista = $this->exame->autorizarsessaofisioterapia($paciente_id);
        $data['paciente_id'] = $paciente_id;
        $data['salas'] = $this->exame->listarsalastotal();
        $data['convenio'] = $this->convenio->listardados();
        $data['medicos'] = $this->operador_m->listarmedicos();
        $data['forma_pagamento'] = $this->guia->formadepagamento();
        $data['paciente'] = $this->paciente->listardados($data['paciente_id']);
        $data['consultasanteriores'] = $this->exametemp->listarconsultaanterior($paciente_id);
        $data['procedimento'] = $this->procedimento->listarprocedimentos();
        $data['exames'] = $this->exametemp->listaragendaspacienteatendimento($paciente_id);
        $this->loadView('ambulatorio/procedimentoautorizaratendimento-form', $data);
    }

    function novosubstituir() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $this->loadView('cadastros/paciente-fichasubstituir', $data);
    }

    function carregar($paciente_id) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        if ($this->session->userdata('cadastro') == 1) {
            $this->loadView('cadastros/paciente-ficha_alternativo', $data);
        } else {
            $this->loadView('cadastros/paciente-ficha', $data);
        }
    }

    function carregardocumentos($paciente_id, $empresa_id = NULL) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        $data['empresa_id'] = $empresa_id;
        $this->loadView('cadastros/paciente-ficha_2', $data);
    }

    function carregardocumentosalternativo($paciente_id) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        $this->loadView('cadastros/paciente-ficha_2alternativo', $data);
    }

    function carregarcontrato($paciente_id, $empresa_id = NULL) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        @$data['empresa_id'] = @$empresa_id;
        $data['forma_pagamento'] = $this->paciente->listaforma_pagamento($obj_paciente->_plano_id);
        // var_dump($data['forma_pagamento']); die;
        $this->loadView('cadastros/paciente-ficha_3', $data);
    }

    function carregartitular($paciente_id) {
        $obj_paciente = new paciente_model($paciente_id);
        $data['obj'] = $obj_paciente;
        $data['idade'] = 1;
        $this->loadView('cadastros/paciente-ficha_4', $data);
    }

    function gravar() {

        if ($paciente_id = $this->paciente->gravar()) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    function gravardocumentos() {

        $paciente_id = $this->paciente->gravardocumentos();
        $situacao = $_POST['situacao'];
        @$empresa_id = @$_POST['empresa_cadastro_id'];
        $paciente_id = $this->paciente->gravar2($paciente_id);
        // $parceiro_id = $_POST['financeiro_parceiro_id'];
        $parceiros = $this->paciente->listarparceirosurl();
        // var_dump($situacao); die;       
        foreach ($parceiros as $key => $value) {
            $retorno_paciente = $this->paciente->listardados($paciente_id);
            $json_paciente = json_encode($retorno_paciente);
            // $fields = array('' => $_POST['body']);
            $url = "http://" . $value->endereco_ip . "/autocomplete/gravarpacientefidelidade";
            // var_dump($url); die;
            $postdata = http_build_query(
                    array(
                        'body' => $json_paciente
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
            // var_dump($result); die;
        }
        if ($situacao == 'Titular') {
            redirect(base_url() . "cadastros/pacientes/carregarcontrato/$paciente_id/$empresa_id");
        } else {
            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
        } 
//        redirect(base_url() . "cadastros/pacientes/carregardocumentos/$paciente_id");
              
    }

    function gravardocumentosalternativo() {

        $paciente_id = $this->paciente->gravardocumentosalternativo();
        $situacao = $_POST['situacao'];
        @$empresa_id = @$_POST['empresa_cadastro_id'];
        
        $paciente_id = $this->paciente->gravar2($paciente_id);
        // $parceiro_id = $_POST['financeiro_parceiro_id'];
        $parceiros = $this->paciente->listarparceirosurl();
//         var_dump($paciente_id); die;
        foreach ($parceiros as $key => $value) {
            $retorno_paciente = $this->paciente->listardados($paciente_id);
            $json_paciente = json_encode($retorno_paciente);

            // $fields = array('' => $_POST['body']);
            $url = "http://" . $value->endereco_ip . "/autocomplete/gravarpacientefidelidade";

            // var_dump($url); die;
            $postdata = http_build_query(
                    array(
                        'body' => $json_paciente
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
            // var_dump($result); die;
        }


        if ($situacao == 'Titular') {
            redirect(base_url() . "cadastros/pacientes/carregarcontrato/$paciente_id/$empresa_id");
        } else {
            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
        }
        
        
//        redirect(base_url() . "cadastros/pacientes/carregardocumentosalternativo/$paciente_id");
        
        
        
    }

    function gravardependente() {
        // echo '<pre>';
        // var_dump($_POST);
        // die;
        $paciente_id = $this->paciente->gravardependente();
        $titular_id = $_POST['txtNomeid'];
        $empresa_p = $this->guia->listarempresa();
        $titular_flag = $empresa_p[0]->titular_flag;
        // echo '<pre>';
        // var_dump($titular_flag);

        $this->paciente->gravardependente2($paciente_id);

        $contrato_id = $this->paciente->listarcontratotitular();

        if ($this->session->userdata('cadastro') == 2) {

            $this->guia->geraparcelasdependente($paciente_id, $contrato_id);
        }

        if ($_POST['financeiro_parceiro_id'] > 0) {

            $parceiro_id = $_POST['financeiro_parceiro_id'];

            $parceiros = $this->paciente->listarparceirosurl($parceiro_id);
            // var_dump($parceiros); die;

            foreach ($parceiros as $key => $value) {
                $retorno_paciente = $this->paciente->listardados($paciente_id);
                if ($titular_flag == 't') {
                    $retorno_paciente[0]->paciente_id = $titular_id;
                }

                // echo '<pre>';
                // var_dump($retorno_paciente); die;
                $json_paciente = json_encode($retorno_paciente);

                // $fields = array('' => $_POST['body']);
                $url = "http://" . $value->endereco_ip . "/autocomplete/gravarpacientefidelidade";
                // var_dump($url); die;
                $postdata = http_build_query(
                        array(
                            'body' => $json_paciente
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
                // var_dump($result); die;
            }
        }


//        var_dump($paciente_id); die;

        redirect(base_url() . "cadastros/pacientes");
    }

    function gravardependentealternativo() {

        $paciente_id = $this->paciente->gravardependentealternativo();
//        var_dump($paciente_id); die;
        $this->paciente->gravardependente2($paciente_id);
//        var_dump($paciente_id); die;

        redirect(base_url() . "cadastros/pacientes");
    }

    function gravar2() {
        $situacao = $_POST['situacao'];
        @$empresa_id = @$_POST['empresa_cadastro_id'];
        $paciente_id = $this->paciente->gravar2();
        // $parceiro_id = $_POST['financeiro_parceiro_id'];
        $parceiros = $this->paciente->listarparceirosurl();
        // var_dump($parceiros); die;

        foreach ($parceiros as $key => $value) {
            $retorno_paciente = $this->paciente->listardados($paciente_id);
            $json_paciente = json_encode($retorno_paciente);

            // $fields = array('' => $_POST['body']);
            $url = "http://" . $value->endereco_ip . "/autocomplete/gravarpacientefidelidade";

            // var_dump($url); die;
            $postdata = http_build_query(
                    array(
                        'body' => $json_paciente
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
            // var_dump($result); die;
        }


        if ($situacao == 'Titular') {
            redirect(base_url() . "cadastros/pacientes/carregarcontrato/$paciente_id/$empresa_id");
        } else {
            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
        }
    }

    function gravar3() {
        $paciente_id = $_POST['paciente_id'];
        $this->paciente->gravar3();

        $this->session->set_flashdata('message', $data['mensagem']);
        $empresa_id = $_POST['empresa_id'];
        if (@$_POST['empresa_cadastro_id'] != "") {
            @$empresa_id = @$_POST['empresa_cadastro_id'];
            redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
        } else {
            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
        }
    }

    function gravar4() {
        $paciente_id = $_POST['paciente_id'];
        $this->paciente->gravar4();

        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
    }

    public function pesquisarprocedimento($args = array()) {
        $this->loadView('cadastros/procedimento-lista');
    }

    public function pesquisarpacientecenso($args = array()) {
        $this->loadView('cadastros/censoprocedimento-lista');
    }

    public function listarpacientecenso($args = array()) {
        $operador = $this->session->userdata('operador_id');

        if ($operador == 100) {
            $data['paciente'] = $this->paciente->relatoriopacientecensosuper();
            $data['demanda'] = $this->paciente->relatoriodemandadiretoria();
            $data['data'] = date("Ydm");
            $this->load->View('cadastros/relatoriodirecao-lista', $data);
        } else {
            $data['paciente'] = $this->paciente->relatoriopacientecenso($operador);
            $data['demanda'] = $this->paciente->relatoriodemandadiretoria();
            $data['data'] = date("Ydm");
            $this->load->View('cadastros/relatoriodirecao-lista', $data);
        }
    }

    function pesquisarbe($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-be');
    }

    function pesquisarbectq($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-bectq');
    }

    function pesquisarbegiah($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-begiah');
    }

    function pesquisarbeapac($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-beapac');
    }

    function pesquisarbeacolhimento($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-beacolhimento');
    }

    function formulariobeacolhimento($args = array()) {
        $this->loadView('cadastros/pacientesformulario-beacolhimento');
    }

    function pesquisarfaturamentohospub($args = array()) {
        $this->loadView('cadastros/faturamentohospub');
    }

    function pesquisarfaturamentohospubinternado($args = array()) {
        $this->loadView('cadastros/faturamentohospubinternado');
    }

    function pesquisarfaturamentohospubetiqueta($args = array()) {
        $this->loadView('cadastros/faturamentohospubetiqueta');
    }

    function pesquisarsamecomparecimento($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-samecomparecimento');
    }

    function pesquisarfaturamentomensal($args = array()) {
        $this->loadView('cadastros/consulta-faturamentomensal');
    }

    function pesquisarcensohospub($args = array()) {
        if ($this->utilitario->autorizar(23, $this->session->userdata('modulo')) == true) {
            $data['clinicas'] = $this->paciente->listarclinicashospub();
            $this->loadView('cadastros/censohospub', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function pesquisarcensohospubstatus($args = array()) {

        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $data['clinicas'] = $this->paciente->listarclinicashospub();
            $this->loadView('cadastros/censohospub_status', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function consultacpf($args = array()) {
        $data['cpf'] = $this->paciente->consultacpf();
        $competencia = str_replace("/", "", $_POST['txtcompetencia']);
        $valida = $this->paciente->verificaproducaomedica($competencia);
        if ($valida == 0) {
            foreach ($data['cpf'] as $value) {
                $cpf = substr($value['IC0CPF'], 1, 12);
                $nome = $value['IC0NOMGUE'];
                $crm = $value['IC0ICR'];
                $this->paciente->consultaprocedimento($cpf, $nome, $competencia, $crm);
            }
        }
        $this->gerarelatoriofaturamento($competencia);
    }

    function consultapacientes() {
        $municipio = '2304400';
        $this->paciente->listapacientes($municipio);
    }

    function gerarelatoriofaturamento($competencia) {
        $data['ponto'] = $this->paciente->listarProcedimentosPontos($competencia);
        $data['lista'] = $this->paciente->listarfaturamentomensal($competencia);
//                echo "<pre>";
//                var_dump($data['lista']);
//                echo "</pre>";
//                die;
        $this->load->View('cadastros/producaomedica', $data);
    }

    function samelistacomparecimento() {
        $data['lista'] = $this->paciente->samelistahospub();
        $this->loadView('cadastros/paciente-samelistacomparecimento', $data);
    }

    function samecomparecimento($registro, $datainternacao) {
        $data['paciente'] = $this->paciente->samehospub($registro, $datainternacao);
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->loadView('cadastros/paciente-samecomparecimento', $data);
    }

    function pesquisabecircunstanciado($args = array()) {
        $this->loadView('cadastros/pacientesconsulta-becircunstaciado');
    }

    function listarcircunstanciado($args = array()) {
        $this->loadView('cadastros/pacientes-relatoriocircunstanciadolista');
    }

    public function impressaocircunstanciado() {
        $data['paciente'] = $this->paciente->conection();
        $this->loadview('cadastros/paciente-becircunstaciado', $data);
    }

    function relatoriocircunstanciado() {
        $id = $this->paciente->gravarcircunstanciado();
        $data['paciente'] = $this->paciente->relatoriobecircunstanciado($id);
        $this->load->view('cadastros/paciente-becircunstaciadoimpressao', $data);
    }

    function impressaorelatoriocircunstanciado($id) {
        $data['paciente'] = $this->paciente->relatoriobecircunstanciado($id);
        $this->load->view('cadastros/paciente-becircunstaciadoimpressao_1', $data);
    }

    function samecomparecimentoimpressao($registro, $datainternacao) {
        $data['paciente'] = $this->paciente->samehospubimpressao($registro, $datainternacao);
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-samecomparecimentoimpressao', $data);
    }

    function faturamentohospubetiqueta() {
        $data['paciente'] = $this->paciente->faturamentohospub();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospubetiqueta', $data);
    }

    function faturamentohospub() {
        $data['paciente'] = $this->paciente->faturamentohospub();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospub', $data);
    }

    function faturamentohospubinternado() {
        $data['paciente'] = $this->paciente->faturamentohospubinternado();
        $data['data'] = date("d/m/Y");
        $data['hora'] = date('H:i:s');
        $this->load->view('cadastros/paciente-faturamentohospubinternado', $data);
    }

    function formularioacolhimento() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-formularioacolhimento', $data);
    }

    function atualizacao() {
        $data = $this->paciente->listaAtualizar();

        foreach ($data as $value) {
            $this->paciente->atualizar($value->be);
        }
        $this->loadView('cadastros/pacientesconsulta-be');
    }

    public function impressaobe() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaobe', $data);
    }

    public function impressaobectq() {
        $data['paciente'] = $this->paciente->conectionctq();
        $this->load->view('cadastros/paciente-formularioacolhimentoctq', $data);
    }

    public function impressaoacolhimento() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaoacolhimento', $data);
    }

    public function impressaobegiah() {
        $data['paciente'] = $this->paciente->conection();
        $this->load->view('cadastros/paciente-impressaobegiah', $data);
    }

    public function impressaoabeapac() {
        $data['paciente'] = $this->paciente->apac();
        $this->load->view('cadastros/paciente-impressaobeapac', $data);
    }

    public function impressaocensohospub() {
        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $clinica = $_POST['txtclinica'];
            $data['paciente'] = $this->paciente->censohospub($clinica);
            $data['leitos'] = $this->paciente->listarleitoshospub($clinica);
            $clinicadescricao = $data['paciente']["0"]["C14NOMEC"];
            $this->paciente->deletarclinicas($clinicadescricao);
            foreach ($data['paciente'] as $value) {
                $this->paciente->gravarcensoclinicas($value);
            }
            $data['procedimentos'] = $this->paciente->listarProcedimentos();
            $data['risco1'] = $this->paciente->listarpacienterisco1();
            $data['risco2'] = $this->paciente->listarpacienterisco2();
            $data['corredor'] = $this->paciente->listarpacientecorredor();
            $capitalfortaleza = $this->paciente->listarpacientemunicipio();
            $data['capitalfortaleza'] = $capitalfortaleza['0']->count;
            $data['procedimentopaciente'] = $this->paciente->listarpacientecenso();
            $data['data'] = date("Ydm");

            $this->load->view('cadastros/impressao-censo', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    public function impressaocensohospubstatus() {
        if ($this->utilitario->autorizar(21, $this->session->userdata('modulo')) == true) {
            $clinica = $_POST['txtclinica'];
            $data['paciente'] = $this->paciente->censohospub($clinica);
            $data['leitos'] = $this->paciente->listarleitoshospub($clinica);
            $data['procedimentos'] = $this->paciente->listarProcedimentos();
            $data['procedimentopaciente'] = $this->paciente->listarpacientecenso();
            $clinicadescricao = $data['paciente']["0"]["C14NOMEC"];
            $pacienteativos = $this->paciente->listarpacienteporclinicas($clinicadescricao);
            foreach ($pacienteativos as $value) {
                $verificador = 0;
                foreach ($data['paciente'] as $item) {

                    if ($value->prontuario == trim($item['IB6REGIST'])) {
                        $verificador = 1;
                    }
                }
                if ($verificador == 0) {
                    $this->paciente->atualizarpacienteporclinicas($value->prontuario);
                }
            }
            $data['data'] = date("Ydm");
            $this->load->view('cadastros/impressao-censostatus', $data);
        } else {
            $data['mensagem'] = 'Usuario sem permissao';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "cadastros/pacientes/pesquisarbe", $data);
        }
    }

    function novademanda() {
        $this->loadView('cadastros/demandasdiretorias-ficha');
    }

    function gravardemanda() {

        if ($this->paciente->gravardemanda()) {
            $data['mensagem'] = 'Demanda gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar demanda';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/listarpacientecenso");
    }

    function atualizardemanda($demanda_id) {

        $this->paciente->atualizardemanda($demanda_id);
        redirect(base_url() . "cadastros/pacientes/listarpacientecenso");
    }

    function gravarpacientecenso() {
        if ($this->paciente->gravarpacientecenso()) {
            $data['mensagem'] = 'Paciente gravado com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao gravar paciente';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/pesquisarpacientecenso");
    }

    function carregarprocedimento($procedimento) {
        $data['procedimento'] = $this->paciente->instanciarprocedimento($procedimento);
        $this->loadView('cadastros/procedimento-ficha', $data);
    }

    function carregarpacientecenso($prontuario = null, $nome = null, $procedimento = null, $procedimentodescricao = null, $unidade = null) {
        $data['prontuario'] = $prontuario;
        $data['nome'] = $nome;
        $data['procedimento'] = $procedimento;
        $data['procedimentodescricao'] = $procedimentodescricao;
        $data['status'] = null;
        $data['unidade'] = $unidade;
        $dados = $this->paciente->instanciarpacientecenso($prontuario);
        if ($dados != null) {
            $data['prontuario'] = $dados['prontuario'];
            $data['nome'] = $dados['nome'];
            $data['procedimento'] = $dados['procedimento'];
            $data['procedimentodescricao'] = $dados['descricao_resumida'];
            $data['status'] = $dados['status'];
        }
        $this->loadView('cadastros/censoprocedimento-ficha', $data);
    }

    function carregarpacientecensostatus($prontuario, $nome = null, $procedimento = null, $procedimentodescricao = null, $unidade = null) {
        $data['prontuario'] = $prontuario;
        $data['nome'] = $nome;
        $data['procedimento'] = $procedimento;
        $data['procedimentodescricao'] = $procedimentodescricao;
        $data['status'] = null;
        $data['unidade'] = $unidade;
        $dados = $this->paciente->instanciarpacientecenso($prontuario);
        if ($dados != null) {
            $data['prontuario'] = $dados['prontuario'];
            $data['nome'] = $dados['nome'];
            $data['procedimento'] = $dados['procedimento'];
            $data['procedimentodescricao'] = $dados['descricao_resumida'];
            $data['status'] = $dados['status'];
        }
        $this->loadView('cadastros/censoprocedimento-fichastatus', $data);
    }

    function atualizaprocedimento() {

        if ($this->paciente->atualizaProcedimentos()) {
            $data['mensagem'] = 'Erro ao gravar procedimento';
        } else {
            $data['mensagem'] = 'Procedimento gravado com sucesso';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/pesquisarprocedimento");
    }

    function gerardicom($guia_id) {
        $exame = $this->exame->listardicom($guia_id);

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

    function novofuncionario($empresa_id) {

        $data['funcionarios'] = $this->paciente->listarfuncionariosempresacadastro($empresa_id);
        $data['quantidade_funcionarios'] = $this->paciente->listarquantidadedefuncionario($empresa_id);
        $data['forma_pagamento'] = $this->paciente->listarformaspagamentos();
        $data['empresa_id'] = $empresa_id;
        $data['paciente'] = $this->paciente->listardados(19468);
        $data['empresa'] = $this->guia->listarempresa();
        $data['contratos'] = $this->paciente->listarcontratocadastroempresa($empresa_id);
        $data['listarpagamentoscontrato'] = $this->paciente->listarpagamentoscontratoempresa($empresa_id);
        $data['listarpagamentosconsultaextra'] = $this->paciente->listarpagamentosconsultaavulsaempresa($empresa_id);
        $data['listarpagamentosconsultacoop'] = $this->paciente->listarpagamentosconsultacoopempresa($empresa_id);
        $data['historicoconsultasrealizadas'] = $this->paciente->listarhistoricoconsultasrealizadasempresa($empresa_id);
        $data['empresapermissao'] = $this->empresa->listarpermissoes();
        $data['permissao'] = $this->empresa->listarpermissoes();
        $contrato_ativo = $this->guia->listarcontratoativoempresa($empresa_id);

        if (count($contrato_ativo) > 0) {
            if ($contrato_ativo[count($contrato_ativo) - 1]->data != "") {
                $paciente_contrato_id = $contrato_ativo[0]->paciente_contrato_id;
                $data_contrato = $contrato_ativo[count($contrato_ativo) - 1]->data;
                $data_cadastro = $contrato_ativo[count($contrato_ativo) - 1]->data_cadastro;
                $qtd_dias = 365;
                if ($qtd_dias == "") {
                    $qtd_dias = 0;
                } else {
                    
                }
                // $data_contrato_year = date('Y-m-d H:i:s', strtotime("+ 1 year", strtotime($data_contrato)));
                //Abaixo soma data de cadastro do contrato com os dias colocados no plano.
                $data_tot_contrato = date('Y-m-d', strtotime("+$qtd_dias days", strtotime($data_cadastro)));
                $data_atual = date("Y-m-d");
                //verificando se a data atual for maior que a data do (contrato+dias do plano) se for maior vai criar um novo contrato.
                if ($data_atual > $data_tot_contrato) {
                    if ($data['permissao'][0]->renovar_contrato_automatico == 't') {
                        $contrato_ativo = $this->guia->gravarnovocontratoanualempresa($paciente_contrato_id, $empresa_id);
                    } else {
                        $contrato_ativo = $this->guia->gravarnovocontratoanualdesativarempresa($paciente_contrato_id, $empresa_id);
                    }
                }
            }
        }

        $this->session->set_flashdata('message', @$data['mensagem']);
        $this->loadView('ambulatorio/empresacadastrodetalhes-lista', $data);
    }

    function carregarfuncionario($empresa_id = NULL) {

        $data['empresa_id'] = $empresa_id;
        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();
        $this->loadView('ambulatorio/empresacadastrodetalhes-form', $data);
    }

    function gravardocumentosfuncionario() {
        $empresa_id = $_POST['empresa_cadastro_id'];
        if ($empresa_id != "") {
            $paciente_id = $this->paciente->gravardocumentosfuncionarioempresa();

            if ($paciente_id == '-1') {
                $data['mensagem'] = 'Erro, Quantidade no plano Atingida.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
            } elseif ($paciente_id == '-2') {
                $data['mensagem'] = 'Erro, Quantidade não cadastrada para esse plano.';
                $this->session->set_flashdata('message', $data['mensagem']);
                redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
            } else {
//                $this->guia->gerarparcelaverificadora($empresa_id);
            }
        } else {
            $paciente_id = $this->paciente->gravardocumentos();
        }
//        redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
        redirect(base_url() . "cadastros/pacientes/carregardocumentos/$paciente_id/$empresa_id");
    }

    function excluirfuncionario($empresa_id = NULL, $paciente_id = NULL) {


        if ($this->paciente->excluirfuncionario($paciente_id) != '-1') {
            $data['mensagem'] = 'Funcionário excluido com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluir funcionário';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/pacientes/novofuncionario/$empresa_id");
    }

    function excluirempresacadastro($empresa_id = NULL) {

        if ($this->paciente->excluirempresacadastro($empresa_id) != '-1') {
            $data['mensagem'] = 'Empresa excluida com sucesso';
        } else {
            $data['mensagem'] = 'Erro ao excluir Empresa';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa/empresacadastrolista");
    }

    function gravarquantidadefuncionarios() {

        $empresa_id = $_POST['empresa_id_qtd'];

        $this->paciente->gravarquantidadefuncionarios();


        redirect(base_url() . " cadastros/pacientes/novofuncionario/$empresa_id");
    }

    function editarquantidade($qtd_funcionarios_empresa_id = NULL, $plano_id = NULL, $empresa_id = NULL) {


        $data['qtd_funcionarios_empresa_id'] = $qtd_funcionarios_empresa_id;
        $data['plano_id'] = $plano_id;
        $data['empresa_id'] = $empresa_id;

        $this->load->View('cadastros/quantidadefuncionarios-form', $data);
    }

    function atualizarquantidadefuncionarios() {

        $empresa_cadastro_id = $_POST['empresa_id'];


        $retorno = $this->paciente->atualizarquantidadefuncionarios();

        $this->paciente->atualizarvalorcontratoempresa($empresa_cadastro_id);

        if ($retorno != '-1') {
            $data['mensagem'] = 'Quantidade editada com sucesso!';
        } else {
            $data['mensagem'] = 'Erro ao alterar quantidade.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao", $data);
    }

    function excluirfuncionarioqtd($qtd_funcionarios_empresa_id) {

        $this->paciente->excluirfuncionarioqtd($qtd_funcionarios_empresa_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function finalizarcadastrodefuncionarios($empresa_id = NULL) {

        $data['empresa_id'] = $empresa_id;
        $data['forma_rendimento'] = $this->paciente->listarformapagamento();
        $this->load->View('cadastros/finalizarcadastrofuncionarios-form', $data);
    }

    function finalizarcadastrofuncionarios() {

        $empresa_id = $_POST['empresa_id'];
        $paciente_contrato_id = $this->paciente->finalizarcadastrofuncionarios();
        $this->guia->gravarparcelacontratoempresa($paciente_contrato_id);
        $this->guia->gerarparcelaverificadora($empresa_id);
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function gravartodospacientesexterno() {
        @$situacao = $_POST['situacao'];
        @$empresa_id = @$_POST['empresa_cadastro_id'];
//        $paciente_id = $this->paciente->gravar2();
        // $parceiro_id = $_POST['financeiro_parceiro_id'];
        $parceiros = $this->paciente->listarparceirosurl();

        $pacientes = $this->paciente->listartodospacientes();

//        echo "<pre>";
//        var_dump($pacientes);
//        echo count($pacientes); 
//        die;

        foreach ($parceiros as $key => $value) {

            foreach ($pacientes as $item) {
                $retorno_paciente = $this->paciente->listardados($item->paciente_id);
                $json_paciente = json_encode($retorno_paciente);

                // $fields = array('' => $_POST['body']);
                $url = "http://" . $value->endereco_ip . "/autocomplete/gravarpacientefidelidade";

//             var_dump($url); die;
                $postdata = http_build_query(
                        array(
                            'body' => $json_paciente
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
                // var_dump($result); die; 
            }
        }


//        if ($situacao == 'Titular') {
//            redirect(base_url() . "cadastros/pacientes/carregarcontrato/$paciente_id/$empresa_id");
//        } else {
//            redirect(base_url() . "emergencia/filaacolhimento/novo/$paciente_id");
//        }
    }

    function novodependentecompleto() {

        $data['idade'] = 0;
        $data['listaLogradouro'] = $this->paciente->listaTipoLogradouro();
        $data['listaconvenio'] = $this->paciente->listaconvenio();
        $data['listarvendedor'] = $this->paciente->listarvendedor();
        $data['parceiros'] = $this->exame->listarparceiros();
        $this->loadView('cadastros/paciente-fichadependente_2', $data);
    }

    function reativarpaciente() {
        $this->paciente->reativarpaciente();

        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function importarlogoempresa() {
        $empresa_id = $_POST['empresa_id'];


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

        $config['upload_path'] = "./upload/empresalogo/" . $empresa_id . "/";
//        $config['upload_path'] = "/home/sisprod/projetos/clinica/upload/paciente/" . $paciente_id . "/";
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
        $data['empresa_id'] = $empresa_id;

        redirect(base_url() . "ambulatorio/empresa/carregarlogoempresa/$empresa_id");

//        $this->anexarimagem($paciente_id);
    }

    function excluirlogoempresa($empresa_id, $nome) {



        if (!is_dir("./uploadopm/empresalogo/$empresa_id")) {
            mkdir("./uploadopm/empresalogo");
            mkdir("./uploadopm/empresalogo/$empresa_id");
            $destino = "./uploadopm/empresalogo/$empresa_id";
            chmod($destino, 0777);
        }

        $origem = "./upload/empresalogo/$empresa_id/$nome";
        $destino = "./uploadopm/empresalogo/$empresa_id/$nome";
        copy($origem, $destino);
        unlink($origem);

        redirect(base_url() . "ambulatorio/empresa/carregarlogoempresa/$empresa_id");
    }

    
    
    function errosgerencianet($args = array()) {
         
        $this->loadView('cadastros/errosgerencianet-lista',  $args);
        
        
    }
    
    function excluirerro($erros_gerencianet_id){
        
        $this->paciente->excluirerro($erros_gerencianet_id);
        redirect(base_url()."cadastros/pacientes/errosgerencianet");
        
        
    }
    
    
    
    

}

?>
