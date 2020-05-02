<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';


class paciente_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;
    var $_paciente_indicacao_id = null;
    var $_cns = null;
    var $_nascimento = null;
    var $_descricaoconvenio = null;
    var $_idade = null;
    var $_cpf = null;
    var $_documento = null;
    var $_orgao = null;
    var $_estado_id_expedidor = null;
    var $_titulo_eleitor = null;
    var $_raca_cor = null;
    var $_sexo = null;
    var $_estado_civil = null;
    var $_nomepai = null;
    var $_nomemae = null;
    var $_celular = null;
    var $_telefone = null;
    var $_telefoneresp = null;
    var $_tipoLogradouro = null;
    var $_rua = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_estado_id = null;
    var $_cidade = null;
    var $_cep = null;
    var $_observacao = null;
    var $__convenio = null;
    var $_cidade_nome = null;
    var $_data_emissao = null;
    var $_cbo_ocupacao_id = null;
    var $_cbo_nome = null;
    var $_indicacao = null;
    var $_situacao = null;
    var $_cpfresp = null;
    var $_outro_documento = null;
    var $_snumero_documento = null;
    var $_plano_id = null;
    var $_vendedor = null;
    var $_financeiro = null;
    var $_ligacao = null;
    var $_cpffinanceiro = null;

    function Paciente_model($paciente_id = null) {
        parent::Model();
        if (isset($paciente_id)) {
            $this->instanciar($paciente_id);
        }
    }

    function contador() {

        $this->db->select();
        $this->db->from('tb_paciente');
        $this->db->where('nome', $_POST['nome']);
        $this->db->where('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
        $this->db->where('nome_mae', $_POST['nome_mae']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorcpf() {
        $this->db->select();
        $this->db->from('tb_paciente');
        $this->db->where('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $perfil_id = $this->session->userdata('perfil_id');
        $operador_id = $this->session->userdata('operador_id');
        // var_dump($perfil_id);die;
        $this->db->from('tb_paciente p')
                ->join('tb_municipio', 'tb_municipio.municipio_id = p.municipio_id', 'left')
                ->select('p.*, tb_municipio.nome as ciade, tb_municipio.estado')
                ->where("(p.ativo ='true' or p.reativar = 't' )");
        if ($perfil_id == 6) {
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = p.vendedor', 'left');
            $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
        }
        if ($perfil_id == 5) {
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = p.vendedor', 'left');
            // $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
        }
        if ($args) {
            if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
                $this->db->where('paciente_id', $args['prontuario']);
//                $this->db->where('ativo', 'true');
            } elseif (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', '%' . $args['nome'] . '%');
//                $this->db->where('ativo', 'true');
                $this->db->orwhere('p.nome_mae ilike', '%' . $args['nome'] . '%');
                $this->db->where('p.ativo', 'true');
                $this->db->orwhere('p.celular ilike', '%' . $args['nome'] . '%');
                $this->db->where('p.ativo', 'true');
                $this->db->orwhere('p.telefone ilike', '%' . $args['nome'] . '%');
                $this->db->where('p.ativo', 'true');
                $this->db->orwhere('p.cpf ilike', '%' . $args['nome'] . '%');
                $this->db->where('p.ativo', 'true');
            } elseif (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
                $this->db->where('p.nascimento', $args['nascimento']);
                $this->db->where('p.ativo', 'true');
            }
        }
        if ($perfil_id == 6) {
            $this->db->where('go.ativo', 'true');
            $this->db->where('ro.ativo', 'true');
            $this->db->where('ro.representante_id', $operador_id);
        }
        if ($perfil_id == 5) {
            $this->db->where('go.ativo', 'true');
            // $this->db->whe]re('ro.ativo', 'true');
            $this->db->where('go.gerente_id', $operador_id);
        }

        return $this->db;
    }

    function listardados($paciente_id) {
        $this->db->select('pc.pago_todos_iugu,p.empresa_id,op.nome as vendedor_nome,tp.tipo_logradouro_id as codigo_logradouro,co.nome as nome_convenio, pc.plano_id, co.convenio_id as convenio,tp.descricao,p.*,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge, fr.nome as pagamento,p.cpf,p.data_cadastro');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = p.vendedor', 'left');
        $this->db->where("p.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarbairros() {
        $this->db->select('bairro');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 't');
        $this->db->where('bairro !=', ' ');
        $this->db->groupby('bairro');
        $this->db->orderby('bairro');
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function listardadoscartao($paciente_id) {
        $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,co.nome as nome_convenio, pc.plano_id, co.convenio_id as convenio,tp.descricao,p.*,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->where("p.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarhistoricoconsultasrealizadas($contrato_id) {
        $this->db->select('cp.data');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.excluido", 'f');
        $this->db->orderby("data");
        $return = $this->db->get()->result();
        if (count($return) > 0) {
            // Traz o período em que este contrato vai estar em vigor
            $dt_inicio = $return[0]->data;
            $dt_fim = $return[count($return) - 1]->data;

            $this->db->select('ae.*,p.telefone,p.celular, p.nome as paciente, fp.fantasia as parceiro');
            $this->db->from('tb_exames_fidelidade ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_fidelidade_id', 'left');
            $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = ae.parceiro_id', 'left');
            // Busca as consultas dos pacientes que pertencem a esse contrato no periodo em que o contrato está em vigor
            $this->db->where("ae.paciente_fidelidade_id IN (
                SELECT paciente_id FROM ponto.tb_paciente_contrato_dependente pcd WHERE ativo = 't' AND paciente_contrato_id = {$contrato_id}
            )");
            $this->db->where("ae.data >=", $dt_inicio);
            $this->db->where("ae.data <=", $dt_fim);

            $return = $this->db->get();
            return $return->result();
        } else {
            return array();
        }
    }

    function listardadoscpf($paciente_id) {
        $this->db->select('p.cpf');
        $this->db->from('tb_paciente p');
        $this->db->where("p.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listardependentescontrato($contrato_id) {

        $this->db->select('o.nome as operador_ultima_impressao,p.nome, p.nascimento, p.paciente_id, situacao,contador_impressao,data_ultima_impressao,pcd.paciente_contrato_dependente_id,fp.valoradcional');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato pt','pt.paciente_contrato_id = pcd.paciente_contrato_id','left');
        $this->db->join('tb_forma_pagamento fp','fp.forma_pagamento_id = pt.plano_id','left');
        $this->db->join('tb_operador o', 'o.operador_id = pcd.ultimo_operador_impressao', 'left');
        $this->db->where("pcd.paciente_contrato_id", $contrato_id);
        $this->db->where("pcd.ativo", "t");
        $this->db->order_by('situacao', 'desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontrato($contrato_id) {
        $this->db->select('valor, pc.ativo as contrato,
                            cp.data, 
                            cp.ativo, 
                            cp.manual,
                            cp.debito,
                            pc.paciente_id,
                            cp.observacao,
                            cpi.pdf, 
                            url, 
                            invoice_id, 
                            cp.taxa_adesao,
                            cp.data_cartao_iugu, 
                            cp.pago_cartao, 
                            cpi.status,cpi.codigo_lr,
                            cp.paciente_contrato_id, 
                            cp.paciente_contrato_parcelas_id,
                            paciente_contrato_parcelas_iugu_id,
                            p.credor_devedor_id,
                            p.empresa_id,
                            cp.empresa_iugu,
                            pc.pago_todos_iugu,
                            gpi.link as link_gerencianet,
                            gpi.pdf as pdf_gerencianet,
                            gpi.charge_id,
                            gpi.carne,
                            gpi.link_carne,
                            gpi.cover_carne,
                            gpi.pdf_carnet,
                            gpi.pdf_cover_carne,
                            gpi.carnet_id,
                            gpi.num_carne,
                            cp.paciente_dependente_id
                            ');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet gpi', 'gpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.excluido", 'f');
//        $this->db->where('cp.parcela_verificadora', null);
        $this->db->orderby("data");
        $return = $this->db->get()->result();
        return $return;
    }

    function listarpagamentoscontratoparcela($paciente_contrato_parcelas_id) {
        $this->db->select('valor, data, cp.ativo, paciente_contrato_parcelas_id, fp.nome as plano, multa_atraso, juros, observacao');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentosconsultaavulsaalterardata($consulta_avulsa_id) {

        $this->db->select('valor, data, cp.ativo, consultas_avulsas_id, observacao, invoice_id, tipo');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->where("consultas_avulsas_id", $consulta_avulsa_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoconsultaavulsa($consultas_avulsas_id) {
        $this->db->select('*');
        $this->db->from('tb_consultas_avulsas ');
        $this->db->where("consultas_avulsas_id", $consultas_avulsas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoconsultaavulsaiugu($consultas_avulsas_id) {
        $this->db->select('invoice_id');
        $this->db->from('tb_consultas_avulsas ');
        $this->db->where("consultas_avulsas_id", $consultas_avulsas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelaiugu($paciente_contrato_parcelas_id) {
        $this->db->select('invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas_iugu cp');
        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelaiugutodos($contrato_id) {
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.taxa_adesao", 'f');
        $this->db->where("invoice_id is null");
        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugucartao() {
        $data = date("Y-m-d");
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, pc.paciente_contrato_id, fp.nome as plano, pc.paciente_id, cp.data_cartao_iugu');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.data_cartao_iugu <=", $data);
        $this->db->where("(cp.data_envio_iugu < '$data'  or  cp.data_envio_iugu is null)");
        $this->db->where("pc.ativo", 't');
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f'); 
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugucartaocliente($paciente_id) {
        $data = date("Y-m-d");
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, pc.paciente_contrato_id, fp.nome as plano, pc.paciente_id, cp.data_cartao_iugu');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.data_cartao_iugu <=", $data);
        $this->db->where("(cp.data_envio_iugu < '$data'  or  cp.data_envio_iugu is null)");
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("pc.ativo", 't');
        $this->db->where("cp.excluido", 'f');
//      $this->db->where("invoice_id is null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiuguexcluidos() {
        $data = date("Y-m-t");

        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("(pc.ativo = false OR p.ativo = false)");
        $this->db->where("cp.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugupendentes() {
        $data = date("Y-m-t");

        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.data <=", $data);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->where("pc.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugupendentescliente($paciente_id) {
        $data = date("Y-m-t");
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        // $this->db->where("cp.data <=", $data);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->where("pc.ativo", 't');
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("p.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugupendentesconsultaavulsa() {
        $data = date("Y-m-t");

        $this->db->select('cp.invoice_id, cp.tipo, consultas_avulsas_id, cp.valor, cp.paciente_id');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->join('tb_paciente p', 'p.paciente_id = cp.paciente_id', 'left');
//        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->where("cp.data <=", $data);
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("cp.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiugupendentesconsultaavulsacliente($paciente_id) {
        $data = date("Y-m-t");

        $this->db->select('cp.invoice_id, cp.tipo, consultas_avulsas_id, cp.valor, cp.paciente_id');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->join('tb_paciente p', 'p.paciente_id = cp.paciente_id', 'left');
//        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        // $this->db->where("cp.data <=", $data);
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("p.paciente_id", $paciente_id);
        $this->db->where("cp.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiuguexclusaocontrato($contrato_id) {
        $data = date("Y-m-d");

        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("pc.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaiuguexclusaopaciente($paciente_id) {
        $data = date("Y-m-d");

        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("pc.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarcartaocliente($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_paciente_cartao_credito cp');
        $this->db->where("paciente_id", $paciente_id);
        $this->db->where("ativo", 't');
//        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarcontadebitocliente($paciente_id) {
        $this->db->select('cd.*');
        $this->db->from('tb_paciente_conta_debito cd');
        $this->db->where("cd.paciente_id", $paciente_id);
        $this->db->where("cd.ativo", 't');
//        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarcartaoclienteautocomplete($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_paciente_cartao_credito cp');
        $this->db->where("paciente_id", $paciente_id);
        $this->db->where("ativo", 't');
//        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentosconsultaavulsa($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->where("paciente_id", $paciente_id);
        $this->db->where("excluido", 'f');
        $this->db->where("tipo", 'EXTRA');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparceiros() {
        $this->db->select('fantasia, financeiro_parceiro_id');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparceirosurl() {
        $this->db->select('endereco_ip,enderecomed_ip,parceriamed_id, financeiro_parceiro_id');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("ativo", 't');
        $this->db->where("(endereco_ip is not null or enderecomed_ip  is not null )");
        // $this->db->where("financeiro_parceiro_id ", $parceiro_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentosconsultacoop($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->where("paciente_id", $paciente_id);
        $this->db->where("excluido", 'f');
        $this->db->where("tipo", 'COOP');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelaapagariugu($paciente_contrato_parcelas_id) {
        $this->db->select('url, pdf, invoice_id, paciente_contrato_parcelas_id');
        $this->db->from('tb_paciente_contrato_parcelas_iugu cpi');
        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->where("ativo", 't');
//        $this->db->where("excluido", 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listardependentes() {
        $this->db->select('*');
        $this->db->from('tb_paciente');
        $this->db->where("situacao", "Dependente");
        $this->db->where("ativo", "t");
//        $this->db->where("status", "t");
        $this->db->where("paciente_id NOT IN (
            SELECT paciente_id FROM ponto.tb_paciente_contrato_dependente WHERE ativo = 't'
        )");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarEnderecoTitular($paciente_id) {

        $this->db->select('p2.paciente_id as titular_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato pc','pc.paciente_contrato_id = pcd.paciente_contrato_id','left');
        $this->db->join('tb_paciente p2','p2.paciente_id = pc.paciente_id','left'); 
        $this->db->where("pcd.paciente_id", $paciente_id);
        $this->db->where("pcd.ativo", "t");
        $this->db->where("pc.ativo", "t");
        $this->db->where("pc.excluido", "f");
        $this->db->where('p.situacao','Dependente'); 
        $return = $this->db->get()->result();
        // var_dump($return); die;
        return $return;
    }
    
    function listarCidades($parametro = null) {
        $this->db->select('municipio_id,
                           nome,estado');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $this->db->from('tb_municipio');
        $return = $this->db->get();

        return $return->result();
    }

    private function instanciar($paciente_id) {
        if ($paciente_id != 0) {

            $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,co.convenio_id as convenio, pc.plano_id, co.nome as descricaoconvenio,cbo.descricao as cbo_nome, tp.descricao,p.*, c.nome as cidade_desc,c.municipio_id as cidade_cod,
                pcd.pessoa_juridica,
                fp.razao_social as parceiro,p.logradouro,p.numero,p.cns,p.reativar,p.credor_devedor_id

                ');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
            $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
            $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = p.parceiro_id', 'left');
            $this->db->where("p.paciente_id", $paciente_id);
            $this->db->orderby("pc.paciente_contrato_id desc");
            $query = $this->db->get();
            $return = $query->result();
            $this->_paciente_id = $paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_cns = $return[0]->cns;
            if (isset($return[0]->nascimento)) {
                $this->_nascimento = $return[0]->nascimento;
            }
            $this->_rendimentos = $return[0]->rendimentos;
            $this->_idade = $return[0]->idade;
            $this->_cbo_nome = $return[0]->cbo_nome;
            $this->_cbo_ocupacao_id = $return[0]->profissao;
            $this->_documento = $return[0]->rg;
            $this->_estado_id_expedidor = $return[0]->uf_rg;
            $this->_titulo_eleitor = $return[0]->titulo_eleitor;
            $this->_raca_cor = $return[0]->raca_cor;
            $this->_sexo = $return[0]->sexo;
            $this->_pessoa_juridica = $return[0]->pessoa_juridica;
            $this->_estado_civil = $return[0]->estado_civil_id;
            $this->_nomepai = $return[0]->nome_pai;
            $this->_nomemae = $return[0]->nome_mae;
            $this->_forma_rendimento_id = $return[0]->forma_rendimento_id;
            $this->_celular = $return[0]->celular;
            $this->_financeiro_parceiro_id = $return[0]->financeiro_parceiro_id;
            $this->_parceiro_id = $return[0]->parceiro_id;
            $this->_codigo_paciente = $return[0]->codigo_paciente;
            $this->_telefone = $return[0]->telefone;
            $this->_telefoneresp = $return[0]->telefoneresp;
            $this->_nomeresp = $return[0]->nomeresp;
            $this->_tipoLogradouro = $return[0]->codigo_logradouro;
            $this->_numero = $return[0]->numero;
            $this->_endereco = $return[0]->logradouro;
            $this->_uf_rg = $return[0]->uf_rg;
            $this->_bairro = $return[0]->bairro;
            $this->_numeroresp = $return[0]->numeroresp;
            $this->_enderecoresp = $return[0]->logradouroresp;
            $this->_bairroresp = $return[0]->bairroresp;
            $this->_cidade = $return[0]->municipio_id;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_complementoresp = $return[0]->complementoresp;
            $this->_complemento = $return[0]->complemento;
            $this->_cidade_nome = $return[0]->cidade_desc;
            $this->_convenio = $return[0]->convenio;
            $this->_descricaoconvenio = $return[0]->descricaoconvenio;
            $this->_convenionumero = $return[0]->convenionumero;
            $this->_data_emissao = $return[0]->data_emissao;
            $this->_indicacao = $return[0]->indicacao;
            $this->_situacao = $return[0]->situacao;
            $this->_outro_documento = $return[0]->outro_documento;
            $this->_numero_documento = $return[0]->numero_documento;
            $this->_cpfresp = $return[0]->cpfresp;
            $this->_plano_id = $return[0]->plano_id;
            $this->_vendedor = $return[0]->vendedor;
            $this->_cpf_responsavel_flag = $return[0]->cpf_responsavel_flag;
            $this->_codigo_paciente = $return[0]->codigo_paciente;
            $this->_parceiro = $return[0]->parceiro;
            $this->_ligacao = $return[0]->ligacao;
            $this->_financeiro = $return[0]->financeiro;
            $this->_cpffinanceiro = $return[0]->cpffinanceiro;
            $this->_cns = $return[0]->cns;
            $this->_reativar = $return[0]->reativar;
            $this->_credor_devedor_id = $return[0]->credor_devedor_id;
            $this->_usuario_app = $return[0]->usuario_app;
            $this->_senha_app = $return[0]->senha_app;
        }
    }

    function listaforma_pagamento($plano_id) {

        $teste = (int) $plano_id;

        $this->db->select('valor1, valor5 , valor6, valor10, valor11, valor12,,valor23,valor24, valor_adesao');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $teste);
        $return = $this->db->get();
        return $return->result();
    }

    function listaTipoLogradouro() {

        $this->db->select('tipo_logradouro_id, descricao');
        $this->db->from('tb_tipo_logradouro');
        $this->db->orderby('tipo_logradouro_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaconvenio() {

        $this->db->select('convenio_id, nome as descricao');
        $this->db->from('tb_convenio');
        $this->db->orderby('convenio_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarIndicacao() {
        $perfil_id = $this->session->userdata('perfil_id');
        $operador_id = $this->session->userdata('operador_id');
        $vendedores = array(7);
        
        $this->db->select('operador_id, nome');
        $this->db->from('tb_operador');
        $this->db->orderby('nome');
        $this->db->where_in('perfil_id', $vendedores);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        

        return $return->result();
    }

    function listarvendedor() {
        $perfil_id = $this->session->userdata('perfil_id');
        $operador_id = $this->session->userdata('operador_id');
        $vendedores = array(4,7, 8, 9);
        if ($perfil_id == 6) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 4);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            $this->db->where('ro.ativo', 't');
            $this->db->where('ro.representante_id', $operador_id);

            $return = $this->db->get();
        } elseif ($perfil_id == 5) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            // $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 4);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            // $this->db->where('ro.ativo', 't');
            $this->db->where('go.gerente_id', $operador_id);
            $return = $this->db->get();
        } else {
            $this->db->select('operador_id, nome');
            $this->db->from('tb_operador');
            $this->db->orderby('nome');
            $this->db->where_in('perfil_id', $vendedores);
            $this->db->where('ativo', 't');
            $return = $this->db->get();
        }

        return $return->result();
    }
    
    function listarvendedorexterno() {
        $perfil_id = $this->session->userdata('perfil_id');
        $operador_id = $this->session->userdata('operador_id');
        //$vendedores = array(4, 8, 9);
        if ($perfil_id == 6) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 8);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            $this->db->where('ro.ativo', 't');
            $this->db->where('ro.representante_id', $operador_id);

            $return = $this->db->get();
        } elseif ($perfil_id == 5) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            // $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 8);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            // $this->db->where('ro.ativo', 't');
            $this->db->where('go.gerente_id', $operador_id);
            $return = $this->db->get();
        } else {
            $this->db->select('operador_id, nome');
            $this->db->from('tb_operador');
            $this->db->orderby('nome');
            $this->db->where('perfil_id',8);
            $this->db->where('ativo', 't');
            $return = $this->db->get();
        }

        return $return->result();
    }

    function listarvendedorexternopj() {
        $perfil_id = $this->session->userdata('perfil_id');
        $operador_id = $this->session->userdata('operador_id');
        //$vendedores = array(4, 8, 9);
        if ($perfil_id == 6) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 9);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            $this->db->where('ro.ativo', 't');
            $this->db->where('ro.representante_id', $operador_id);

            $return = $this->db->get();
        } elseif ($perfil_id == 5) {
            $this->db->select('o.operador_id, o.nome');
            $this->db->from('tb_operador o');
            $this->db->join('tb_ambulatorio_gerente_operador go', 'go.operador_id = o.operador_id', 'left');
            // $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = go.gerente_id', 'left');
            $this->db->orderby('nome');
            $this->db->where('o.perfil_id', 9);
            $this->db->where('o.ativo', 't');
            $this->db->where('go.ativo', 't');
            // $this->db->where('ro.ativo', 't');
            $this->db->where('go.gerente_id', $operador_id);
            $return = $this->db->get();
        } else {
            $this->db->select('operador_id, nome');
            $this->db->from('tb_operador');
            $this->db->orderby('nome');
            $this->db->where('perfil_id',9);
            $this->db->where('ativo', 't');
            $return = $this->db->get();
        }

        return $return->result();
    }

    function listaindicacao() {

        $this->db->select('paciente_indicacao_id, nome');
        $this->db->from('tb_paciente_indicacao');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listacadaindicacao($paciente_indicacao_id) {

        $this->db->select('paciente_indicacao_id, nome');
        $this->db->from('tb_paciente_indicacao');
        $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravar() {

        try {
            if ($_POST['txtcbo'] != $_POST['txtcbohidden']) {
                $this->db->select('cbo_ocupacao_id');
                $this->db->from('tb_cbo_ocupacao');
                $this->db->orderby('cbo_ocupacao_id desc');
                $this->db->limit(1);
                $ultimaprofissao = $this->db->get()->result();
//                var_dump($ultimaprofissao); die;
                $last_id = $ultimaprofissao[0]->cbo_ocupacao_id + 1;

                $this->db->set('cbo_ocupacao_id', $last_id);
                $this->db->set('descricao', $_POST['txtcbo']);
                $this->db->insert('tb_cbo_ocupacao');
                $ocupacao_id = $last_id;

                $this->db->set('profissao', $ocupacao_id);
            } elseif ($_POST['txtcboID'] != "") {
                $this->db->set('profissao', $_POST['txtcboID']);
            }

            $this->db->set('nome', $_POST['nome']);
//            $nascimento = $_POST['nascimento'];
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
//            if ($_POST['data_emissao'] != '') {
//                $this->db->set('data_emissao', $_POST['data_emissao']);
//            }
            if ($_POST['indicacao'] != '') {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            if ($_POST['forma_rendimento_id'] != '') {
                $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
            }
            $this->db->set('sexo', $_POST['sexo']);

            if ($_POST['estado_civil_id'] != '') {
                $this->db->set('estado_civil_id', $_POST['estado_civil_id']);
            }
            $this->db->set('nome_pai', $_POST['nome_pai']);
            $this->db->set('nome_mae', $_POST['nome_mae']);
            if ($_POST['tipo_logradouro'] != '') {
                $this->db->set('tipo_logradouro', $_POST['tipo_logradouro']);
            }
            $this->db->set('logradouro', $_POST['endereco']);

            $this->db->set('numero', $_POST['numero']);
            $this->db->set('situacao', $_POST['situacao']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            if ($_POST['financeiro_parceiro_id'] != '') {
                $this->db->set('parceiro_id', $_POST['financeiro_parceiro_id']);
            }
            $this->db->set('cep', $_POST['cep']);

            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            }
            if ($_POST['data_emissao'] != '') {
                $this->db->set('data_emissao', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_emissao']))));
            }
             
            if ($_POST['cns'] != '') {
                $this->db->set('cns', $_POST['cns']);
            }
   
            if (isset($_POST['cpfresp'])) {
                $this->db->set('cpfresp', 't');
            } else {
                $this->db->set('cpfresp', 'f');
            }
            if (isset($_POST['financeiro'])) {
                $this->db->set('financeiro', $_POST['financeiro']);
            }
            if (isset($_POST['cpffinanceiro'])) {
                $this->db->set('cpffinanceiro', $_POST['cpffinanceiro']);
            }
            if (isset($_POST['cod_pac'])) {
                $this->db->set('codigo_paciente', $_POST['cod_pac']);
            }
            if (isset($_POST['ligacao'])) {
                $this->db->set('ligacao', $_POST['ligacao']);
            }
            $this->db->set('outro_documento', $_POST['outro_documento']);
            $this->db->set('numero_documento', $_POST['numero_documento']);
            $this->db->set('rg', $_POST['rg']);
            $this->db->set('uf_rg', $_POST['uf_rg']);

            $this->db->set('cns', $_POST['txtUsuario']);
            
            if($_POST['txtSenha'] != ''){
                $this->db->set('senha_app', md5($_POST['txtSenha']));
            }

            $this->db->set('rendimentos', str_replace(",", ".", str_replace(".", "", $_POST['rendimentos'])));

            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));


            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if (isset($_POST['reativar'])) {
                $this->db->set('reativar', 't');
            } else {
                $this->db->set('reativar', 'f');
            }

            if (isset($_POST['credor_devedor_id'])) {
                if ($_POST['credor_devedor_id'] != "") {
                    $this->db->set('credor_devedor_id', $_POST['credor_devedor_id']);
                } else {
                    $this->db->set('credor_devedor_id', null);
                }
            }


            if ($_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();

                $situacao = $_POST['situacao'];
                if ($situacao == 'Titular') {
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('plano_id', $_POST['plano']);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato');
                }
            } else { // update
                $paciente_id = $_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('situacao', $_POST['situacao']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
//                var_dump($_POST); die;
                if ($_POST['pessoajuridica'] == 'SIM') {
                    $this->db->set('pessoa_juridica', 't');
                }

                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente_contrato_dependente');
            }

            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravardocumentos() {

        try {
            $this->db->select('consulta_avulsa, consulta_coop');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $_POST['plano']);
            $consulta_avulsa = $this->db->get()->result();
//            var_dump($consulta_avulsa); die;
            if ($_POST['txtcboID'] == "") {
                $this->db->select('cbo_ocupacao_id');
                $this->db->from('tb_cbo_ocupacao');
                $this->db->orderby('cbo_ocupacao_id desc');
                $this->db->limit(1);
                $ultimaprofissao = $this->db->get()->result();
//                var_dump($ultimaprofissao); die;
                $last_id = $ultimaprofissao[0]->cbo_ocupacao_id + 1;

                $this->db->set('cbo_ocupacao_id', $last_id);
                $this->db->set('descricao', $_POST['txtcbo']);
                $this->db->insert('tb_cbo_ocupacao');
                $ocupacao_id = $last_id;

                $this->db->set('profissao', $ocupacao_id);
            } elseif ($_POST['txtcboID'] != "") {
                $this->db->set('profissao', $_POST['txtcboID']);
            }

            $this->db->set('nome', $_POST['nome']);

            $this->db->set('codigo_paciente', $_POST['cod_pac']);
            if ($_POST['parceiro_id'] != '') {
                $this->db->set('parceiro_id', $_POST['parceiro_id']);
            }

            if (@$_POST['indicacao_id'] > 0) {
                $this->db->set('indicacao_id', $_POST['indicacao_id']);
            }

            if ($_POST['forma_rendimento_id'] != '') {
                $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
            }

            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
//            if ($_POST['financeiro_parceiro_id'] != '') {
//                $this->db->set('financeiro_parceiro_id', $_POST['financeiro_parceiro_id']);
//            }
            if (count($consulta_avulsa) > 0) {
                $this->db->set('consulta_avulsa', $consulta_avulsa[0]->consulta_avulsa);
                $this->db->set('consulta_coop', $consulta_avulsa[0]->consulta_coop);
            }
//            if ($_POST['data_emissao'] != '') {
//                $this->db->set('data_emissao', $_POST['data_emissao']);
//            }
            if ($_POST['indicacao'] != '') {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            $this->db->set('sexo', $_POST['sexo']);

            if ($_POST['estado_civil_id'] != '') {
                $this->db->set('estado_civil_id', $_POST['estado_civil_id']);
            }
            $this->db->set('nome_pai', $_POST['nome_pai']);
            $this->db->set('nome_mae', $_POST['nome_mae']);
            if ($_POST['tipo_logradouro'] != '') {
                $this->db->set('tipo_logradouro', $_POST['tipo_logradouro']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('convenio_id', $_POST['plano']);
            $this->db->set('numero', $_POST['numero']);
            if ($_POST['vendedor'] != '') {
                $this->db->set('vendedor', $_POST['vendedor']);
            }
            $this->db->set('situacao', $_POST['situacao']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }

            if (@$_POST['empresa_cadastro_id'] != '') {
                $this->db->set('empresa_id', @$_POST['empresa_cadastro_id']);
            } else {
                $this->db->set('empresa_id', null);
            }

            if (isset($_POST['reativar'])) {
                $this->db->set('reativar', 't');
            } else {
                $this->db->set('reativar', 'f');
            }

//            if ($_POST['txtcboID'] != '') {
//                $this->db->set('profissao', $_POST['txtcboID']);
//            }
            $this->db->set('cep', $_POST['cep']);

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();

                $situacao = $_POST['situacao'];
                if ($situacao == 'Titular') {
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    if (isset($_POST['nao_renovar'])) {
                        $this->db->set('nao_renovar', 't');
                    } else {
                        $this->db->set('nao_renovar', 'f');
                    }
                    if ($_POST['forma_rendimento_id'] != '') {
                        $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
                    }
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('plano_id', $_POST['plano']);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato');
                }
            } else { // update
                $paciente_id = $_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravardocumentosalternativo() {

        try {
            $this->db->select('consulta_avulsa, consulta_coop');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $_POST['plano']);
            $consulta_avulsa = $this->db->get()->result();
//            var_dump($consulta_avulsa); die;
            if ($_POST['txtcboID'] == "") {
                $this->db->select('cbo_ocupacao_id');
                $this->db->from('tb_cbo_ocupacao');
                $this->db->orderby('cbo_ocupacao_id desc');
                $this->db->limit(1);
                $ultimaprofissao = $this->db->get()->result();
//                var_dump($ultimaprofissao); die;
                $last_id = $ultimaprofissao[0]->cbo_ocupacao_id + 1;

                $this->db->set('cbo_ocupacao_id', $last_id);
                $this->db->set('descricao', $_POST['txtcbo']);
                $this->db->insert('tb_cbo_ocupacao');
                $ocupacao_id = $last_id;

                $this->db->set('profissao', $ocupacao_id);
            } elseif ($_POST['txtcboID'] != "") {
                $this->db->set('profissao', $_POST['txtcboID']);
            }

            $this->db->set('nome', $_POST['nome']);

            $this->db->set('codigo_paciente', $_POST['cod_pac']);
            $this->db->set('financeiro', $_POST['financeiro']);
            $this->db->set('cpffinanceiro', $_POST['cpffinanceiro']);
            $this->db->set('ligacao', $_POST['ligacao']);
            if ($_POST['parceiro_id'] != '') {
                $this->db->set('parceiro_id', $_POST['parceiro_id']);
            }

            if ($_POST['forma_rendimento_id'] != '') {
                $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
            }

            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
//            if ($_POST['financeiro_parceiro_id'] != '') {
//                $this->db->set('financeiro_parceiro_id', $_POST['financeiro_parceiro_id']);
//            }
            if (count($consulta_avulsa) > 0) {
                $this->db->set('consulta_avulsa', $consulta_avulsa[0]->consulta_avulsa);
                $this->db->set('consulta_coop', $consulta_avulsa[0]->consulta_coop);
            }
//            if ($_POST['data_emissao'] != '') {
//                $this->db->set('data_emissao', $_POST['data_emissao']);
//            }
            if ($_POST['indicacao'] != '') {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            $this->db->set('sexo', $_POST['sexo']);

            if ($_POST['estado_civil_id'] != '') {
                $this->db->set('estado_civil_id', $_POST['estado_civil_id']);
            }
            $this->db->set('nome_pai', $_POST['nome_pai']);
            $this->db->set('nome_mae', $_POST['nome_mae']);
            if ($_POST['tipo_logradouro'] != '') {
                $this->db->set('tipo_logradouro', $_POST['tipo_logradouro']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('convenio_id', $_POST['plano']);
            $this->db->set('numero', $_POST['numero']);
            if ($_POST['vendedor'] != '') {
                $this->db->set('vendedor', $_POST['vendedor']);
            }
            $this->db->set('situacao', $_POST['situacao']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }

//            if ($_POST['txtcboID'] != '') {
//                $this->db->set('profissao', $_POST['txtcboID']);
//            }
            $this->db->set('cep', $_POST['cep']);

            if (isset($_POST['reativar'])) {
                $this->db->set('reativar', 't');
            } else {
                $this->db->set('reativar', 'f');
            }

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();

                $situacao = $_POST['situacao'];
                if ($situacao == 'Titular') {
                    if ($_POST['forma_rendimento_id'] != '') {
                        $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
                    }
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('plano_id', $_POST['plano']);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato');
                }
            } else { // update
                $paciente_id = $_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravardependente() {

        try {

            $this->db->set('nome', $_POST['nome']);
            if (@$_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            }
            if (@$_POST['financeiro_parceiro_id'] != '') {
                $this->db->set('parceiro_id', $_POST['financeiro_parceiro_id']);
            }

            if (isset($_POST['cpf_responsavel'])) {
                $this->db->set('cpf_responsavel_flag', 't');
            } else {
                $this->db->set('cpf_responsavel_flag', 'f');
            }

            if (@$_POST['cod_pac'] != '') {
                $this->db->set('codigo_paciente', $_POST['cod_pac']);
            }
            if (@$_POST['rg'] != '') {
                $this->db->set('rg', $_POST['rg']);
            }
            if (@$_POST['logradouro'] != '') {
                $this->db->set('logradouro', $_POST['logradouro']);
            }

            if (@$_POST['numero'] != '') {
                $this->db->set('numero', "23");
            }


            if (@$_POST['bairro'] != '') {
                $this->db->set('bairro', $_POST['bairro']);
            }

            if (@$_POST['municipio_id'] != '') {

                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            if (@$_POST['cep'] != '') {
                $this->db->set('cep', $_POST['cep']);
            }
            if (@$_POST['email'] != '') {
                $this->db->set('cns', $_POST['email']);
            }
             if (@$_POST['forma_rendimento_id'] != '') {
                $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
            }

            if (isset($_POST['reativar'])) {
                $this->db->set('reativar', 't');
            } else {
                $this->db->set('reativar', 'f');
            }

            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
 
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
 
            $this->db->set('sexo', $_POST['sexo']);
            $this->db->set('situacao', 'Dependente');
            if (isset($_POST['reativar'])) {
                $this->db->set('reativar', 't');
            } else {
                $this->db->set('reativar', 'f');
            }
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if (@$_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();
            } else { // update
                $paciente_id = @$_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravardependentealternativo() {

        try {

            $this->db->set('nome', $_POST['nome']);

            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
//            $nascimento = $_POST['nascimento'];
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
//            if ($_POST['data_emissao'] != '') {
//                $this->db->set('data_emissao', $_POST['data_emissao']);
//            }
            $this->db->set('sexo', $_POST['sexo']);
            $this->db->set('situacao', 'Dependente');

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();
            } else { // update
                $paciente_id = $_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar2($paciente_id = NULL) {

        try {

            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            }

            if (isset($_POST['cpf_responsavel'])) {
                $this->db->set('cpf_responsavel_flag', 't');
            } else {
                $this->db->set('cpf_responsavel_flag', 'f');
            }

            if ($_POST['data_emissao'] != '') {
                $this->db->set('data_emissao', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_emissao']))));
            }
            $this->db->set('cns', $_POST['cns']);
            if (isset($_POST['cpfresp'])) {
                $this->db->set('cpfresp', 't');
            } else {
                $this->db->set('cpfresp', 'f');
            }
            
            if(isset($_POST['rendimentos']) && $_POST['rendimentos'] != ""){
              $this->db->set('rendimentos', str_replace(",", ".", str_replace(".", "", $_POST['rendimentos'])));
            }
             if(isset($_POST['outro_documento']) && $_POST['outro_documento'] != ""){
               $this->db->set('outro_documento', $_POST['outro_documento']);
             }
             if(isset($_POST['numero_documento']) && $_POST['numero_documento'] != ""){
               $this->db->set('numero_documento', $_POST['numero_documento']);
             }             
            $this->db->set('rg', $_POST['rg']);
            $this->db->set('uf_rg', $_POST['uf_rg']);
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['paciente_id'] != "") {
                $paciente_id = $_POST['paciente_id'];
            } else {
                
            }

            $this->db->set('data_atualizacao', $data);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar3() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('paciente_contrato_id, pc.plano_id, fp.taxa_adesao, fp.valor_adesao');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->where('pc.ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

//        echo '<pre>';
//        var_dump($_POST);
//        die;
        $paciente_contrato_id = $return[0]->paciente_contrato_id;



//        $ajuste = $return[0]->ajuste;
        $ajuste = substr(@$_POST['checkboxvalor1'], 3, 5);
        $parcelas = substr(@$_POST['checkboxvalor1'], 0, 2);

        $parcelas = (int) $parcelas;

        $parcela_ajust = $parcelas . " x " . $ajuste;

        $this->db->set('parcelas', $parcela_ajust);
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->update('tb_paciente_contrato');

        $mes = 1;
        $dia = @$_POST['vencimentoparcela'];
        if ((int) @$_POST['vencimentoparcela'] < 10) {
            $dia = str_replace('0', '', $dia);
            $dia = "0" . $dia;
        }


        $data_post = date("Y-m-d", strtotime(str_replace('/', '-', @$_POST['adesao'])));
        $data_adesao = date("Y-m-d", strtotime(str_replace('/', '-', @$_POST['adesao'])));



        $data_receber = date("Y-m-$dia", strtotime($data_post));
        if (date("d", strtotime($data_receber)) == '31') {
            $data_receber = date("Y-m-30", strtotime($data_receber));
        }
        $mes_atual = date("m");
        $ano_atual = date("Y");
        if (date("Y", strtotime($data_receber)) < '2000' && date("m", strtotime($data_receber)) == '12') {
            $data_receber = date("$ano_atual-$mes_atual-d", strtotime($data_receber));
        }
//        var_dump($dia); die;



        if ($data_receber < $data_post) {
            if (date("d", strtotime($data_receber)) == '30' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-2 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) $_POST['pularmes'] > 0) {
//            echo 'uhasuhdasd';
                    $quantidade_meses = (int) $_POST['pularmes'];
//           var_dump($data_receber); die;
                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 2;
            } elseif (date("d", strtotime($data_receber)) == '29' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-1 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) $_POST['pularmes'] > 0) {

                    $quantidade_meses = (int) $_POST['pularmes'];

                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 1;
            } else {
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) @$_POST['pularmes'] > 0) {

                    $quantidade_meses = (int) $_POST['pularmes'];

                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 0;
            }
        } else {

            if ((int) $_POST['pularmes'] > 0) {

                $quantidade_meses = (int) $_POST['pularmes'];

                $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
            }
        }



//        echo '<pre>';
//        var_dump($quantidade_meses);
//        var_dump($data_adesao);
//        var_dump($data_receber);
//        die;
        $this->db->set('razao_social', $_POST['nome']);
        $this->db->set('cep', $_POST['cep']);
        if ($_POST['cpf'] != '') {
            $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
        } else {
            $this->db->set('cpf', null);
        }
        $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
        $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
        if ($_POST['tipo_logradouro'] != '') {
            $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
        }
        if ($_POST['municipio_id'] != '') {
            $this->db->set('municipio_id', $_POST['municipio_id']);
        }
        $this->db->set('logradouro', $_POST['endereco']);
        $this->db->set('numero', $_POST['numero']);
        $this->db->set('bairro', $_POST['bairro']);
        $this->db->set('complemento', $_POST['complemento']);
//        $horario = date("Y-m-d H:i:s");
//        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_financeiro_credor_devedor');
        $financeiro_credor_devedor_id = $this->db->insert_id();


        if ($_POST['paciente_id'] != "") {
            $this->db->where('paciente_id', $_POST['paciente_id']);
            $this->db->set('credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->update('tb_paciente');
        }

        $data_atual = date("d/m/Y");
//        $data_adesao = date("Y-m-d");
//        echo '<pre>';
//        var_dump($return[0]->taxa_adesao); die;


        if (@$_POST['empresa_cadastro_id'] == "") { 
            if ($return[0]->taxa_adesao == 't') {
                $adesao_post = str_replace(",", ".", str_replace(".", "", @$_POST['valor_adesao']));
                $this->db->set('adesao_digitada', @$_POST['adesao']);
                if ($adesao_post >= 0) {
                    $this->db->set('valor', $adesao_post);
                } else {
                    $this->db->set('valor', $ajuste);
                }
                $this->db->set('taxa_adesao', 't');
                if ($adesao_post == 0.00 || $ajuste == 0.00) {
                    $this->db->set('ativo', 'f');
                    $this->db->set('manual', 't');
                }
                // $this->db->set('valor', $ajuste);
                $this->db->set('parcela', 0);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
                $this->db->set('data', $data_adesao);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_parcelas');
            }
        }


        for ($i = 1; $i <= $parcelas; $i++) {

            $this->db->set('adesao_digitada', $_POST['adesao']);
            $this->db->set('valor', $ajuste);
            if ($ajuste == 0.00) {
                $this->db->set('ativo', 'f');
                $this->db->set('manual', 't');
            }
            $this->db->set('parcela', $i);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->set('data', $data_receber);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_parcelas');
            //$mes++;
            if (date("m", strtotime($data_receber)) == '01' && date("d", strtotime($data_receber)) > 28 && $i < $parcelas) {


                if (date("d", strtotime($data_receber)) == '30') {


                    $data_receber = date("Y-m-d", strtotime("-2 days", strtotime($data_receber)));
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    $this->db->set('valor', $ajuste);
                    if ($ajuste == 0.00) {
                        $this->db->set('ativo', 'f');
                        $this->db->set('manual', 't');
                    }
                    $this->db->set('parcela', $i);
                    $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                    $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
                    $this->db->set('data', $data_receber);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato_parcelas');
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    $data_receber = date("Y-m-d", strtotime("+2 days", strtotime($data_receber)));
                } elseif (date("d", strtotime($data_receber)) == '29') {
                    $data_receber = date("Y-m-d", strtotime("-1 days", strtotime($data_receber)));
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    $this->db->set('valor', $ajuste);
                    if ($ajuste == 0.00) {
                        $this->db->set('ativo', 'f');
                        $this->db->set('manual', 't');
                    }
                    $this->db->set('parcela', $i);
                    $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                    $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
                    $this->db->set('data', $data_receber);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato_parcelas');
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    $data_receber = date("Y-m-d", strtotime("+1 days", strtotime($data_receber)));
                }
                $i++;
            } else {

                $data_receber = date("Y-m-d", strtotime("+$mes month", strtotime($data_receber)));
                if (@$b > 0) {
                    $data_receber = date("Y-m-d", strtotime("+$b days", strtotime($data_receber)));
                    @$b = 0;
                }
            }
        }
        if (@$_POST['pessoajuridica'] == 'SIM') {
            $this->db->set('pessoa_juridica', 't');
        }
        $this->db->set('paciente_id', $_POST['paciente_id']);
        $this->db->set('paciente_contrato_id', $paciente_contrato_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_contrato_dependente');
        $erro = $this->db->_error_message();



        if (trim($erro) != "") // erro de banco
            return -1;
    }

    function gravar4() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');


        $this->db->select('paciente_contrato_id, plano_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_id', $_POST['txtNomeid']);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

        $paciente_contrato_id = $return[0]->paciente_contrato_id;

        $this->db->select('parcelas, valoradcional');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $return[0]->plano_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $retorno = $query->result();

        $this->db->select('paciente_contrato_dependente_id');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $this->db->where('pessoa_juridica', 'f');
        $query = $this->db->get();
        $resultado = $query->result();

        $total = count($resultado);
        $valor = $retorno[0]->valoradcional;
        if ($total < $retorno[0]->parcelas) {

            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_dependente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        }else {

            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_dependente');

            $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                SET valor = valor + '$valor'
                 WHERE paciente_contrato_id = $paciente_contrato_id";
            $this->db->query($sql);

//            $this->db->set('ativo', 'f');
//            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
//            $this->db->update('tb_paciente_contrato_parcelas');
        }
    }

    function gravardependente2($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        // var_dump($paciente_id); die;

        $this->db->select('paciente_contrato_id, plano_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_id', $_POST['txtNomeid']);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

        $paciente_contrato_id = $return[0]->paciente_contrato_id;

        $this->db->select('parcelas, valoradcional');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $return[0]->plano_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $retorno = $query->result();

        $this->db->select('paciente_contrato_dependente_id');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $this->db->where('pessoa_juridica', 'f');
        $query = $this->db->get();
        $resultado = $query->result();
       
        $total = count($resultado);
        $valor = $retorno[0]->valoradcional;
        if ($total < $retorno[0]->parcelas) {

            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_dependente');
            
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            }else {
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_dependente');
                
            if ($this->session->userdata('cadastro') == 2) {
                
            } else {
               
                $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                SET valor = valor + '$valor'
                 WHERE paciente_contrato_id = $paciente_contrato_id";
                $this->db->query($sql);
            }
//            $this->db->set('ativo', 'f');
//            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
//            $this->db->update('tb_paciente_contrato_parcelas');
        }
    }

    function gravarpacientetemp() {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', substr($_POST['nascimento'], 6, 4) . '-' . substr($_POST['nascimento'], 3, 2) . '-' . substr($_POST['nascimento'], 0, 2));
            }
            if ($_POST['idade'] != '') {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;
            $this->db->set('data_cadastro', $dataatual);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente');
            $paciente_id = $this->db->insert_id();
            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Método criado para atender uma necessidade temporária
     * @author Vicente Armando
     * classe_model@return <type>
     */
    function gravarPaciente() {
        try {
            $this->db->set('nome', $_POST['nome_paciente']);
            if ($_POST['idade'] == '')
                $this->db->set('idade', null);
            else
                $this->db->set('idade', $_POST['idade']);
            $this->db->set('idade_tipo', $_POST['idadeTipo']);
            $this->db->set('sexo', $_POST['sexo_paciente']);
            $this->db->set('nome_mae', $_POST['mae_paciente']);
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['tel_paciente']))));
            $this->db->set('logradouro', $_POST['end_paciente']);
            $this->db->set('peso', $_POST['peso_paciente']);
            $this->db->set('cns', $_POST['sus_paciente']);
            $this->db->set('profissao', $_POST['profissao_paciente']);
            $this->db->set('bairro', $_POST['bairro_paciente']);
            if ($_POST['municipio_id_paciente'] != null)
                $this->db->set('municipio_id', $_POST['municipio_id_paciente']);
            else
                $this->db->set('municipio_id', null);
            $this->db->set('cep', $_POST['cep_paciente']);

            if ($_POST['id_paciente'] == "") {// insert
                $this->db->insert('tb_temp_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $temp_paciente_id = $this->db->insert_id();
            }
            else { // update
                $temp_paciente_id = $_POST['id_paciente'];
                $this->db->where('temp_paciente_id', $temp_paciente_id);
                $this->db->update('tb_temp_paciente');
            }
            return $temp_paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravardemanda() {
        try {
            $this->db->set('demanda', $_POST['txtDemanda']);
            $this->db->set('diretoria', $_POST['txtDiretoria']);
            $this->db->set('ativo', 'true');
            $data = date("Ymd");
            $this->db->set('diretoria_data', $data);
            $this->db->insert('tb_censo_demanda_diretoria');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function deletarclinicas($clinica) {
        $this->db->where('unidade', $clinica);
        $this->db->delete('tb_censo_clinicas');
    }

    function gravarcensoclinicas($args = array()) {
        try {
            $this->db->set('nome', $args['IB6NOME']);
            $this->db->set('municipio', $args['ID4DESCRICAO']);
            $this->db->set('unidade', $args['C14NOMEC']);
            $this->db->insert('tb_censo_clinicas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function atualizardemanda($demanda_id) {
        $this->db->set('ativo', 'false');
        $data = date("Ymd");
        $this->db->set('fechamento_data', $data);
        $this->db->where('censo_demanda_diretoria', $demanda_id);
        $this->db->update('tb_censo_demanda_diretoria');
        return true;
    }

    function gravarpacientecenso() {
        try {
            $verificador = $this->instanciarpacientecenso($_POST['txtProntuario']);
            $this->db->set('prontuario', $_POST['txtProntuario']);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('procedimento', $_POST['txtProcedimento']);
            $this->db->set('descricao_resumida', $_POST['txtDescricaoResumida']);
            $this->db->set('status', $_POST['txtStatus']);
            $this->db->set('unidade', $_POST['txtunidade']);
            if ($_POST['txtvalida'] == 1) {
                $this->db->set('diretoria', $_POST['txtDiretoria']);
                $this->db->set('ativo', 'true');
            }
            $data = date("Ymd");
            $this->db->set('diretoria_data', $data);


            if ($verificador == null) {// insert
                $this->db->insert('tb_censo_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    return true;
            }
            else { // update
                $this->db->where('prontuario', $_POST['txtProntuario']);
                $this->db->update('tb_censo_paciente');
                return true;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function consultarprocedimento($args = array()) {
        $this->db->from('tb_procedimento')
                ->select('"tb_procedimento".*');
        if ($args) {
            if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
                $this->db->where('tb_procedimento.procedimento', $args['procedimento']);
            }
        }
        return $this->db;
    }

    function consultarpacientecenso($args = array()) {
        $this->db->from('tb_censo_paciente')
                ->select('"tb_censo_paciente".*');
        if ($args) {
            if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
                $this->db->where('tb_censo_paciente.prontuario', $args['prontuario']);
            }
        }
        return $this->db;
    }

    function instanciarpacientecenso($prontuario) {

        $this->db->from('tb_censo_paciente')
                ->select('"tb_censo_paciente".*');
        $this->db->where('tb_censo_paciente.prontuario', $prontuario);
        // $this->db->where('tb_censo_paciente.nome', $prontuario);
        $retorno = $this->db->get();
        $testes = $retorno->row_array();
        return $testes;
    }

    function listarpacienteporclinicas($clinica) {
        $clinica = trim($clinica);
        $this->db->from('tb_censo_paciente')
                ->select('"tb_censo_paciente".*');
        $this->db->where('unidade', $clinica);
        $this->db->where('tb_censo_paciente.ativo', 'true');
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function listarpacienterisco1() {
        $this->db->from('tb_censo_clinicas')
                ->select();
        $this->db->where('unidade', 'EIXO AMARELO - RISCO I   ');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarpacienterisco2() {
        $this->db->from('tb_censo_clinicas')
                ->select();
        $this->db->where('unidade', 'EIXO VERDE- RISCO 2      ');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarpacientecorredor() {
        $this->db->from('tb_censo_clinicas')
                ->select();
        $this->db->where('unidade ilike', 'EIXO AZUL%');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarpacientemunicipio() {
        $sql = "SELECT count(*)
              FROM ijf.tb_censo_clinicas
            where municipio = 'FORTALEZA                               '
            and (unidade ilike '%EIXO AZUL%'
            or unidade = 'EIXO AMARELO - RISCO I   '
            or unidade = 'EIXO VERDE- RISCO 2      ')
            ";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function atualizarpacienteporclinicas($prontuario) {
        $this->db->set('ativo', 'false');
        $this->db->where('prontuario', $prontuario);
        $this->db->update('tb_censo_paciente');
    }

    function instanciarprocedimento($procedimento) {
        $this->db->from('tb_procedimento')
                ->select('"tb_procedimento".*');
        $this->db->where('tb_procedimento.procedimento', $procedimento);
        $retorno = $this->db->get();
        $testes = $retorno->row_array();
        return $testes;
    }

    function listarCBO() {

        $this->db->select('cbo_grupo_id, descricao');
        $this->db->from('tb_cbo');
        $return = $this->db->get();
        return $return->result();
    }

    function listarProcedimentos() {
        $this->db->select();
        $this->db->from('tb_procedimento');
        $return = $this->db->get();
        return $return->result();
    }

    function listarProcedimentosPontos($competencia) {
        $this->db->select();
        $this->db->from('tb_emergencia_procedimento_sia_pontos');
        $this->db->where('competencia', $competencia);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientecenso() {
        $this->db->select();
        $this->db->from('tb_censo_paciente');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriopacientecenso($operador) {
        $this->db->select('p.descricao_resumida, p.procedimento, p.nome, d.descricao,
                p.prontuario, p.status, p.diretoria, p.diretoria_data, p.unidade');
        $this->db->from('tb_censo_paciente p');
        $this->db->where('p.diretoria', $operador);
        $this->db->where('p.ativo', 'true');
        $this->db->join('tb_censo_diretoria d', 'p.diretoria = d.codigo', 'left');
        $this->db->orderby('p.diretoria_data', 'asc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriopacientecensosuper() {
        $this->db->select('p.descricao_resumida, p.procedimento, p.nome, d.descricao,
                p.prontuario, p.status, p.diretoria, p.diretoria_data, p.unidade');
        $this->db->from('tb_censo_paciente p');
        $this->db->where('p.ativo', 'true');
        $this->db->join('tb_censo_diretoria d', 'p.diretoria = d.codigo', 'left');
        $this->db->orderby('p.diretoria_data', 'asc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriobecircunstanciado($id) {
        $this->db->select();
        $this->db->from('tb_emergencia_relatoriocircuntanciado');
        $this->db->where('relatoriocircuntanciado_id', $id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarrelatoriobecircunstanciado($args = array()) {
        $this->db->from('tb_emergencia_relatoriocircuntanciado er')
                ->select();
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('er.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('er.be ilike', $args['nome'], 'left');
                $this->db->orwhere('er.diretoria ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function gravarcircunstanciado() {
        try {
            $this->db->set('be', trim($_POST['txtbe']));
            $this->db->set('nome', $_POST['txtnome']);
            $this->db->set('data_nascimento', $_POST['txtnascimento']);
            $this->db->set('nome_mae', $_POST['txtmae']);
            $this->db->set('endereco', $_POST['txtendereco']);
            $this->db->set('ao', $_POST['txtAO']);
            $this->db->set('caro', $_POST['txtCARO']);
            $this->db->set('solicitante', $_POST['txtsolicitante']);
            $this->db->set('diretoria', $_POST['txtdiretoria']);
            $this->db->set('numero', $_POST['txtcpf']);
            $data = date("Ymd");
            $this->db->set('data', $data);


            $this->db->insert('tb_emergencia_relatoriocircuntanciado');
            $id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else
                return $id;
            return $id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function relatoriodemandadiretoria() {
        $this->db->select('dd.demanda, d.descricao, dd.censo_demanda_diretoria');
        $this->db->from('tb_censo_demanda_diretoria dd');
        $this->db->where('dd.ativo', 'true');
        $this->db->join('tb_censo_diretoria d', 'dd.diretoria = d.codigo', 'left');
        $this->db->orderby('censo_demanda_diretoria', 'asc');
        $return = $this->db->get();
        return $return->result();
    }

    function atualizaProcedimentos() {
        $procedimento = $_POST['txtProcedimento'];
        $txtDescricaoResumida = $_POST['txtDescricaoResumida'];
        $sql = "update ijf.tb_procedimento set descricao_resumida = '$txtDescricaoResumida' where procedimento = $procedimento";
        $this->db->query($sql);
    }

    function conection() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['be'] = $_POST['txtbe'];
            $pront = ($Obj->impressaobe($aParam));
//                $aParam['be']= $_POST['txtbe'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
            $this->db->select();
            $this->db->from('tb_emergencia_behospub');
            $this->db->where('be', $pront['N54NUMBOLET']);
            $return = $this->db->count_all_results();
            //var_dump($return);


            $args['nome'] = $pront['C54IDENTIFIC'];
            $args['be'] = $pront['N54NUMBOLET'];
            $args['nome_mae'] = $pront['C54MAE'];
            $data = substr($pront['D54NASC'], 0, 8);
            if ($data == "        ") {
                $pront['D54NASC'] = null;
            }
            $args['data_nascimento'] = $pront['D54NASC'];
            $args['sexo'] = $pront['C54SEXO'];
            $args['responsavel'] = $pront['C54RESP'];
            $args['endereco'] = $pront['C54END'] . " " . $pront['C54NUMERO'];
            $args['fone'] = $pront['C54TEL'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['codigo_ibge'] = $pront['C54MUN'];
            $args['estado'] = $pront['C54UF'];
            $args['idade'] = $pront['I54IDADE'];
            $args['bairro'] = $pront['C54BAIRRO'];
            $args['data_abertura'] = $pront['D54INTER'];
            $args['hora_abertura'] = $pront['C54HINTER'];
            $args['documento'] = $pront['C54CPFPAC'];
            $args['caso_policial'] = $pront['C54CASOPOL'];
            $args['trauma'] = $pront['C54TRAUMA'];
            $args['acidente_trabalho'] = $pront['C54ACIDTRAB'];
            $args['ambulancia'] = $pront['C54AMBULAN'];
            $args['motivo_atendimento'] = $pront['C54MOTATEND'];
            $args['motivo_atendimento_descricao'] = $pront['C56DESCRICAO'];
            $args['complemento'] = $pront['C54COMPLEM'];
            $data = substr($pront['D54ALTA'], 0, 8);
            if ($data == "        ") {
                $pront['D54ALTA'] = null;
            }
            $args['data_alta'] = $pront['D54ALTA'];
            $args['hora_alta'] = $pront['C54HALTA'];
            $args['cpf_medico_alta'] = $pront['C54CPFALTA'];
            $args['cid'] = $pront['C54CID10'];
            $args['setor_entrada'] = $pront['C54SETOR_ENT'];
            $args['setor_alta'] = $pront['C54SETOR_SAI'];
            $args['motivo_alta'] = $pront['C54MOTIVO'];
            $args['tipo_motivo_alta'] = $pront['C54TIPALTA'];


            if ($return == '0') {
                $this->db->insert('tb_emergencia_behospub', $args);
                $id = $this->db->insert_id();
                $args['behospub_id'] = $id;

                return $args;
            } elseif ($return == '1') {
                $this->db->where('be', $pront['N54NUMBOLET']);
                $this->db->update('tb_emergencia_behospub', $args);

                $this->db->select();
                $this->db->from('tb_emergencia_behospub');
                $this->db->where('be', $pront['N54NUMBOLET']);
                $retorno = $this->db->get();
                $teste = $retorno->row_array();

                return $teste;
            }
//                $erro = $this->db->_error_message();
//                if (trim($erro) != "") { // erro de banco
//                    var_dump($erro);
//                }
            //var_dump($pront);
            //$nume = $pront["N54NUMBOLET"];
            //var_dump($nume);
            // echo "_______________________________________";
            //$string_xml = $Obj->getPaciente('000080', $opBuscaBe);
            //$xml = new ConvertXml();
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getDadosPaciente('80',$opBuscaBe));
            //$aResult = ($Obj->getPacienteInternado('99990084'));
            //$aResult = $xml->xml2array($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = $xml->$Obj->getPaciente('000080', $opBuscaBe);
            //print_r ($Obj->getPaciente('80',$opBuscaBe));
            //print_r ($Obj->getBpaiConteudo('000080'));
            //print_r ($Obj->getBEInfo('000080'));
            //print_r ($Obj->getProntuarioBe('000080'));
            //var_dump($aResult);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function conectionctq() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['be'] = $_POST['txtbe'];
            $pront = ($Obj->impressaobe($aParam));
//            $aParam['be'] = $_POST['txtbe'];
//            $pront = ($Obj->testeijf($aParam));
//            echo "<pre>";
//            var_dump($pront);
//            echo "</pre>";
//            die;
            $this->db->select();
            $this->db->from('tb_emergencia_behospub');
            $this->db->where('be', $pront['N54NUMBOLET']);
            $return = $this->db->count_all_results();
            //var_dump($return);


            $args['nome'] = $pront['C54IDENTIFIC'];
            $args['be'] = $pront['N54NUMBOLET'];
            $args['nome_mae'] = $pront['C54MAE'];
            $data = substr($pront['D54NASC'], 0, 8);
            if ($data == "        ") {
                $pront['D54NASC'] = null;
            }
            $args['data_nascimento'] = $pront['D54NASC'];
            $args['sexo'] = $pront['C54SEXO'];
            $args['responsavel'] = $pront['C54RESP'];
            $args['endereco'] = $pront['C54END'] . " " . $pront['C54NUMERO'];
            $args['fone'] = $pront['C54TEL'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['codigo_ibge'] = $pront['C54MUN'];
            $args['estado'] = $pront['C54UF'];
            $args['idade'] = $pront['I54IDADE'];
            $args['bairro'] = $pront['C54BAIRRO'];
            $args['data_abertura'] = $pront['D54INTER'];
            $args['hora_abertura'] = $pront['C54HINTER'];
            $args['documento'] = $pront['C54CPFPAC'];
            $args['caso_policial'] = $pront['C54CASOPOL'];
            $args['trauma'] = $pront['C54TRAUMA'];
            $args['acidente_trabalho'] = $pront['C54ACIDTRAB'];
            $args['ambulancia'] = $pront['C54AMBULAN'];
            $args['motivo_atendimento'] = $pront['C54MOTATEND'];
            $args['motivo_atendimento_descricao'] = $pront['C56DESCRICAO'];
            $args['complemento'] = $pront['C54COMPLEM'];
            $data = substr($pront['D54ALTA'], 0, 8);
            if ($data == "        ") {
                $pront['D54ALTA'] = null;
            }
            $args['data_alta'] = $pront['D54ALTA'];
            $args['hora_alta'] = $pront['C54HALTA'];
            $args['cpf_medico_alta'] = $pront['C54CPFALTA'];
            $args['cid'] = $pront['C54CID10'];
            $args['setor_entrada'] = $pront['C54SETOR_ENT'];
            $args['setor_alta'] = $pront['C54SETOR_SAI'];
            $args['motivo_alta'] = $pront['C54MOTIVO'];
            $args['tipo_motivo_alta'] = $pront['C54TIPALTA'];


            if ($return == '0') {
                $this->db->insert('tb_emergencia_behospub', $args);
                $id = $this->db->insert_id();
                $args['behospub_id'] = $id;

                return $args;
            } elseif ($return == '1') {
                $this->db->where('be', $pront['N54NUMBOLET']);
                $this->db->update('tb_emergencia_behospub', $args);

                $this->db->select();
                $this->db->from('tb_emergencia_behospub');
                $this->db->where('be', $pront['N54NUMBOLET']);
                $retorno = $this->db->get();
                $teste = $retorno->row_array();

                return $teste;
            }
//                $erro = $this->db->_error_message();
//                if (trim($erro) != "") { // erro de banco
//                    var_dump($erro);
//                }
            //var_dump($pront);
            //$nume = $pront["N54NUMBOLET"];
            //var_dump($nume);
            // echo "_______________________________________";
            //$string_xml = $Obj->getPaciente('000080', $opBuscaBe);
            //$xml = new ConvertXml();
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getDadosPaciente('80',$opBuscaBe));
            //$aResult = ($Obj->getPacienteInternado('99990084'));
            //$aResult = $xml->xml2array($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = $xml->$Obj->getPaciente('000080', $opBuscaBe);
            //print_r ($Obj->getPaciente('80',$opBuscaBe));
            //print_r ($Obj->getBpaiConteudo('000080'));
            //print_r ($Obj->getBEInfo('000080'));
            //print_r ($Obj->getProntuarioBe('000080'));
            //var_dump($aResult);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function listarclinicashospub() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['clinica'] = 0;
            $pront = ($Obj->listarclinicas($aParam));
//                $aParam['be']= $_POST['txtclinica'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                $aParam['clinica']= '028';
//                $pront = ($Obj->censohospubdiretoria($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;

            return $pront;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function listarleitoshospub($clinica) {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['clinica'] = $clinica;
            $pront = ($Obj->listarleitos($aParam));
//                $aParam['be']= $_POST['txtclinica'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
//                $aParam['clinica']= 0;
//                $pront = ($Obj->listarclinicas($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;

            return $pront;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function censohospub($clinica) {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['clinica'] = $clinica;
            $pront = ($Obj->censohospub($aParam));
//                $aParam['be']= $_POST['txtclinica'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
//                $aParam['clinica']= $_POST['txtclinica'];
//                $pront = ($Obj->censohospub($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;


            return $pront;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function faturamentohospub() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));

            $aParam['PRONTUARIO'] = $_POST['txtprontuario'];
            $pront = ($Obj->faturamentohospub($aParam));
//                $aParam['be']= $_POST['txtprontuario'];
//                $pront = ($Obj->testeijf($aParam));
//                var_dump($pront);
//                die;
            $this->db->select();
            $this->db->from('tb_emergencia_internacaohospub');
            $this->db->where('prontuario', $pront['IB6REGIST']);
            $return = $this->db->count_all_results();
            //var_dump($return);


            $args['prontuario'] = $pront['IB6REGIST'];
            $args['codigo_ibge'] = $pront['IB6MUNICIP'];
            $args['data_abertura'] = $pront['D15INTER'];
            $data = substr($pront['D15ALTA'], 0, 8);
            if ($data == "        ") {
                $pront['D15ALTA'] = null;
            }
            $args['data_fechamento'] = $pront['D15ALTA'];
            $args['endereco'] = $pront['IB6LOGRAD'];
            $data = substr($pront['IB6DTNASC'], 0, 8);
            if ($data == "        ") {
                $pront['IB6DTNASC'] = null;
            }
            $args['data_nascimento'] = $pront['IB6DTNASC'];
            $args['nome'] = $pront['IB6NOME'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['fone'] = $pront['IB6TELEF'];
            $args['sexo'] = $pront['IB6SEXO'];
            $args['nome_pai'] = $pront['IB6PAI'];
            $args['estado'] = $pront['IB6UF'];
            $args['nome_mae'] = $pront['IB6MAE'];
            $args['bairro'] = $pront['IB6BAIRRO'];
            $args['aih'] = $pront['N15AIH'];
            $args['nacionalidade'] = $pront['IC6DESCR'];
            $args['documento'] = $pront['IB6CPFPAC'];
            $args['clinica'] = $pront['C15CODCLIN'];
            $args['leito'] = $pront['C15CODLEITO'];
            $args['naturalidade'] = $pront['IB6NATURAL'];
            $args['be'] = $pront['N15NUMBOLET'];
            $args['cep'] = $pront['IB6CEP'];
            if ($return == '0') {
                $this->db->insert('tb_emergencia_internacaohospub', $args);

                return $args;
            } elseif ($return == '1') {
                $this->db->where('prontuario', $pront['IB6REGIST']);
                $this->db->update('tb_emergencia_internacaohospub', $args);

                return $args;
            }
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function faturamentohospubinternado() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));

            $aParam['PRONTUARIO'] = $_POST['txtprontuario'];
            $pront = ($Obj->faturamentohospubinternado($aParam));
//                $aParam['be']= $_POST['txtprontuario'];
//                $pront = ($Obj->testeijf($aParam));
//                var_dump($pront);
//                die;
            $this->db->select();
            $this->db->from('tb_emergencia_internacaohospub');
            $this->db->where('prontuario', $pront['IB6REGIST']);
            $return = $this->db->count_all_results();
            //var_dump($return);


            $args['prontuario'] = $pront['IB6REGIST'];
            $args['codigo_ibge'] = $pront['IB6MUNICIP'];
            $args['data_abertura'] = $pront['D02INTER'];
            $args['data_fechamento'] = null;
            $args['endereco'] = $pront['IB6LOGRAD'];
            $data = substr($pront['IB6DTNASC'], 0, 8);
            if ($data == "        ") {
                $pront['IB6DTNASC'] = null;
            }
            $args['data_nascimento'] = $pront['IB6DTNASC'];
            $args['nome'] = $pront['IB6NOME'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['fone'] = $pront['IB6TELEF'];
            $args['sexo'] = $pront['IB6SEXO'];
            $args['nome_pai'] = $pront['IB6PAI'];
            $args['estado'] = $pront['IB6UF'];
            $args['nome_mae'] = $pront['IB6MAE'];
            $args['bairro'] = $pront['IB6BAIRRO'];
            $args['aih'] = $pront['N02AIH'];
            $args['nacionalidade'] = $pront['IC6DESCR'];
            $args['documento'] = $pront['IB6CPFPAC'];
            $args['clinica'] = $pront['C02CODCLIN'];
            $args['leito'] = $pront['C02CODLEITO'];
            $args['naturalidade'] = $pront['IB6NATURAL'];
            $args['be'] = $pront['N02NUMBOLET'];
            $args['cep'] = $pront['IB6CEP'];
            if ($return == '0') {
                $this->db->insert('tb_emergencia_internacaohospub', $args);

                return $args;
            } elseif ($return == '1') {
                $this->db->where('prontuario', $pront['IB6REGIST']);
                $this->db->update('tb_emergencia_internacaohospub', $args);

                return $args;
            }
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function samehospubimpressao($registro, $datainternacao) {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));

            $aParam['PRONTUARIO'] = $registro;
            $aParam['DATAINTERNACAO'] = $datainternacao;
            $pront = ($Obj->samehospub($aParam));



            $this->db->select();
            $this->db->from('tb_emergencia_samehospub');
            $this->db->where('prontuario', $pront['IB6REGIST']);
            $this->db->where('data_internacao', $datainternacao);
            $return = $this->db->count_all_results();
            $operador_id = ($this->session->userdata('operador_id'));
            if ($return == '0') {
//                  $Obj =  new SoapClient(null,array(
//                  'location' => 'http://172.30.40.252/webservice/hospub',
//                  'uri' => 'http://172.30.40.252/webservice/hospub',
//                  'trace' =>  1,
//                  'exceptions' => 0));
//
//                $aParam['PRONTUARIO']= $registro;
//                $pront = ($Obj->samehospub($aParam));
                //var_dump($pront);
//                $aParam['be']= $_POST['txtprontuario'];
//                $pront = ($Obj->testeijf($aParam));
//                var_dump($pront);
//                die;



                $args['prontuario'] = $pront['IB6REGIST'];
                $data = substr($pront['IB6DTNASC'], 0, 8);
                if ($data == "        ") {
                    $pront['IB6DTNASC'] = null;
                }
                $args['data_nascimento'] = substr($pront['IB6DTNASC'], 0, 4) . "-" . substr($pront['IB6DTNASC'], 4, 2) . "-" . substr($pront['IB6DTNASC'], 6, 2);
                $args['nome'] = $pront['IB6NOME'];
                $args['sexo'] = $pront['IB6SEXO'];
                $args['nome_mae'] = $pront['IB6MAE'];
                $args['nome_pai'] = $pront['IB6PAI'];
                $args['data_internacao'] = $pront['D15INTER'];
                $data = substr($pront['D15ALTA'], 0, 8);
                if ($data == "        ") {
                    $pront['D15ALTA'] = null;
                }
                $args['data_alta'] = $pront['D15ALTA'];
                $args['be'] = $pront['N15NUMBOLET'];
                $args['descricao'] = $_POST['txtDescricao'];
                $args['hora_internacao'] = $pront['C15HINTER'];
                $args['hora_alta'] = $pront['C15HALTA'];
                $args['motivo'] = $pront['C15MOTIVO'];
                $args['motivoestado'] = $pront['C15ESTADO'];
                $args['crm'] = $pront['IC0ICR'];
                $args['medico'] = $pront['IC0NOME'];
                $data = substr($pront['D54INTER'], 0, 8);
                if (($data == "        ") || ($data == " 9999999")) {
                    $pront['D54INTER'] = null;
                }
                $args['data_abertura'] = $pront['D54INTER'];
                $args['hora_abertura'] = $pront['C54HINTER'];
                $args['operador_id'] = $operador_id;
                $inserir = $args;
                $inserir['data_nascimento'] = $pront['IB6DTNASC'];
                $this->db->insert('tb_emergencia_samehospub', $inserir);


                return $args;
            } elseif ($return == '1') {
                $this->db->select();
                $this->db->from('tb_emergencia_samehospub');
                $this->db->where('prontuario', $pront['IB6REGIST']);
                $this->db->where('data_internacao', $datainternacao);
                $retorno = $this->db->get();
                $teste = $retorno->row_array();
                $teste['operador_id'] = $operador_id;
                $teste['descricao'] = $_POST['txtDescricao'];
                $this->db->where('prontuario', $pront['IB6REGIST']);
                $this->db->where('data_internacao', $datainternacao);
                $this->db->update('tb_emergencia_samehospub', $teste);
                return $teste;
            }
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function samehospub($registro, $datainternacao) {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['PRONTUARIO'] = $registro;
            $aParam['DATAINTERNACAO'] = $datainternacao;
            $pront = ($Obj->samehospub($aParam));
//                $aParam['be']= $_POST['txtprontuario'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
            $this->db->select();
            $this->db->from('tb_emergencia_samehospub');
            $this->db->where('prontuario', $pront['IB6REGIST']);
            $this->db->where('data_internacao', $datainternacao);
            $return = $this->db->count_all_results();




            $args['prontuario'] = $pront['IB6REGIST'];
            $data = substr($pront['IB6DTNASC'], 0, 8);
            if ($data == "        ") {
                $pront['IB6DTNASC'] = null;
            }
            $args['data_nascimento'] = substr($pront['IB6DTNASC'], 0, 4) . "-" . substr($pront['IB6DTNASC'], 4, 2) . "-" . substr($pront['IB6DTNASC'], 6, 2);
            $args['nome'] = $pront['IB6NOME'];
            $args['sexo'] = $pront['IB6SEXO'];
            $args['nome_mae'] = $pront['IB6MAE'];
            $args['nome_pai'] = $pront['IB6PAI'];
            $args['data_internacao'] = $pront['D15INTER'];
            $data = substr($pront['D15ALTA'], 0, 8);
            if ($data == "        ") {
                $pront['D15ALTA'] = null;
            }
            $args['data_alta'] = $pront['D15ALTA'];
            $args['be'] = $pront['N15NUMBOLET'];
            $args['hora_internacao'] = $pront['C15HINTER'];
            $args['hora_alta'] = $pront['C15HALTA'];
            $args['motivo'] = $pront['C15MOTIVO'];
            $args['motivoestado'] = $pront['C15ESTADO'];
            $args['crm'] = $pront['IC0ICR'];
            $args['medico'] = $pront['IC0NOME'];
            $args['data_abertura'] = $pront['D54INTER'];
            $args['hora_abertura'] = $pront['C54HINTER'];
            $args['descricao'] = null;

            if ($return == '1') {
                $this->db->select();
                $this->db->from('tb_emergencia_samehospub');
                $this->db->where('prontuario', $pront['IB6REGIST']);
                $this->db->where('data_internacao', $datainternacao);
                $retorno = $this->db->get();
                $temp = $retorno->row_array();
                $args['descricao'] = $temp['descricao'];
            }

            return $args;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function atualizar($be) {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['be'] = $be;
            $pront = ($Obj->testeijf($aParam));

            $args['nome'] = $pront['C54IDENTIFIC'];
            $args['be'] = $pront['N54NUMBOLET'];
            $args['nome_mae'] = $pront['C54MAE'];
            $data = substr($pront['D54NASC'], 0, 8);
            if ($data == "        ") {
                $pront['D54NASC'] = null;
            }
            $args['data_nascimento'] = $pront['D54NASC'];
            $args['sexo'] = $pront['C54SEXO'];
            $args['responsavel'] = $pront['C54RESP'];
            $args['endereco'] = $pront['C54END'] . " " . $pront['C54NUMERO'];
            $args['fone'] = $pront['C54TEL'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['codigo_ibge'] = $pront['C54MUN'];
            $args['estado'] = $pront['C54UF'];
            $args['idade'] = $pront['I54IDADE'];
            $args['bairro'] = $pront['C54BAIRRO'];
            $args['data_abertura'] = $pront['D54INTER'];
            $args['hora_abertura'] = $pront['C54HINTER'];
            $args['documento'] = $pront['C54CPFPAC'];
            $args['caso_policial'] = $pront['C54CASOPOL'];
            $args['trauma'] = $pront['C54TRAUMA'];
            $args['acidente_trabalho'] = $pront['C54ACIDTRAB'];
            $args['ambulancia'] = $pront['C54AMBULAN'];
            $args['motivo_atendimento'] = $pront['C54MOTATEND'];
            $args['motivo_atendimento_descricao'] = $pront['C56DESCRICAO'];
            $args['complemento'] = $pront['C54COMPLEM'];
            $data = substr($pront['D54ALTA'], 0, 8);
            if ($data == "        ") {
                $pront['D54ALTA'] = null;
            }
            $args['data_alta'] = $pront['D54ALTA'];
            $args['hora_alta'] = $pront['C54HALTA'];
            $args['cpf_medico_alta'] = $pront['C54CPFALTA'];
            $args['cid'] = $pront['C54CID10'];
            $args['setor_entrada'] = $pront['C54SETOR_ENT'];
            $args['setor_alta'] = $pront['C54SETOR_SAI'];



            $this->db->where('be', $pront['N54NUMBOLET']);
            $this->db->update('tb_emergencia_behospub', $args);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function listaAtualizar() {

        $this->db->select();
        $this->db->from('tb_emergencia_behospub');
        return $this->db->get()->result();


        return $retorno;
    }

    function listarProcedimento($parametro = null) {
        $this->db->select('co_procedimento,
                            no_procedimento');
        if ($parametro != null) {
            $this->db->where('co_procedimento ilike', $parametro . "%");
            $this->db->orwhere('no_procedimento ilike', $parametro . "%");
        }
        $return = $this->db->get('tb_emergencia_procedimentos');
        return $return->result();
    }

    function apac() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));


            $aParam['be'] = $_POST['txtbe'];
            $pront = ($Obj->impressaobe($aParam));
//                $aParam['be']= $_POST['txtbe'];
//                $pront = ($Obj->testeijf($aParam));
//                var_dump($pront);
//                die;
            $this->db->select();
            $this->db->from('tb_emergencia_tomografiahospub');
            $this->db->where('be', $pront['N54NUMBOLET']);
            $return = $this->db->count_all_results();
            //var_dump($return);


            $args['nome'] = $pront['C54IDENTIFIC'];
            $args['be'] = $pront['N54NUMBOLET'];
            $args['nome_mae'] = $pront['C54MAE'];
            $data = substr($pront['D54NASC'], 0, 8);
            if ($data == "        ") {
                $pront['D54NASC'] = null;
            }
            $args['data_nascimento'] = $pront['D54NASC'];
            $args['sexo'] = $pront['C54SEXO'];
            $args['responsavel'] = $pront['C54RESP'];
            $args['endereco'] = $pront['C54END'] . " " . $pront['C54NUMERO'];
            $args['fone'] = $pront['C54TEL'];
            $args['municipio'] = $pront['ID4DESCRICAO'];
            $args['codigo_ibge'] = $pront['C54MUN'];
            $args['estado'] = $pront['C54UF'];
            $args['idade'] = $pront['I54IDADE'];
            $args['bairro'] = $pront['C54BAIRRO'];
            $args['data_abertura'] = $pront['D54INTER'];
            $args['hora_abertura'] = $pront['C54HINTER'];
            $args['documento'] = $pront['C54CPFPAC'];
            $args['motivo_atendimento'] = $pront['C54MOTATEND'];
            $args['motivo_atendimento_descricao'] = $pront['C56DESCRICAO'];
            $args['complemento'] = $pront['C54COMPLEM'];
            $args['co_procedimento'] = $_POST['txtcodigo'];
            $args['no_procedimento'] = $_POST['txtdescricao'];



            if ($return == '0') {
                $this->db->insert('tb_emergencia_tomografiahospub', $args);

                return $args;
            } elseif ($return == '1') {
                $this->db->where('be', $pront['N54NUMBOLET']);
                $this->db->update('tb_emergencia_tomografiahospub', $args);

                return $args;
            }
//                $erro = $this->db->_error_message();
//                if (trim($erro) != "") { // erro de banco
//                    var_dump($erro);
//                }
            //var_dump($pront);
            //$nume = $pront["N54NUMBOLET"];
            //var_dump($nume);
            // echo "_______________________________________";
            //$string_xml = $Obj->getPaciente('000080', $opBuscaBe);
            //$xml = new ConvertXml();
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = ($Obj->getDadosPaciente('80',$opBuscaBe));
            //$aResult = ($Obj->getPacienteInternado('99990084'));
            //$aResult = $xml->xml2array($Obj->getPaciente('000080', $opBuscaBe));
            //$aResult = $xml->$Obj->getPaciente('000080', $opBuscaBe);
            //print_r ($Obj->getPaciente('80',$opBuscaBe));
            //print_r ($Obj->getBpaiConteudo('000080'));
            //print_r ($Obj->getBEInfo('000080'));
            //print_r ($Obj->getProntuarioBe('000080'));
            //var_dump($aResult);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function listarPacientes($parametro = null) {
        $this->db->select('nome,
                           be,
                           idade,
                           data_nascimento as nascimento');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
            $this->db->orwhere('be ilike', "%" . $parametro . "%");
        }
        $this->db->from('tb_emergencia_behospub');
        $return = $this->db->get();

        return $return->result();
    }

    function consultacpf() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));
            $aParam['be'] = 'S';
            $pront = ($Obj->consultacpfhospub($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
            return $pront;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function verificaproducaomedica($competencia) {


        $this->db->select();
        $this->db->from('tb_emergencia_faturamentomedico');
        $this->db->where('competencia', "$competencia");
        $return = $this->db->get()->row_array();
        if ($return == null) {
            return 0;
        } else {
            return 1;
        }
    }

    function consultaprocedimento($cpf, $nome, $competencia, $crm) {

        $Obj = new SoapClient(null, array(
            'location' => 'http://172.30.40.252/webservice/hospub',
            'uri' => 'http://172.30.40.252/webservice/hospub',
            'trace' => 1,
            'exceptions' => 0));

        $aParam['cpf'] = $cpf;
        $aParam['competencia'] = $competencia;
        $pront = ($Obj->consultaproducaohospub($aParam));
        if ($pront != null) {
            foreach ($pront as $value) {
                $args['procedimento'] = trim($value['N57PROCAMB']);
                $args['cpf'] = trim($value['C57CPFMED']);
                $args['nome'] = trim($nome);
                $args['crm'] = trim($crm);
                $args['competencia'] = trim($competencia);
                //var_dump($value['C57CPFMED']);
                $this->db->insert('tb_emergencia_faturamentomedico', $args);
            }
        }
    }

    function listarfaturamentomensal($competencia) {
        $this->db->select();
        $this->db->from('tb_emergencia_faturamentomedico');
        $this->db->orderby('nome');
        $this->db->orderby('procedimento');
        $this->db->where('competencia', "$competencia");
        $return = $this->db->get();
        return $return->result();
    }

    function samelistahospub() {


        $Obj = new SoapClient(null, array(
            'location' => 'http://172.30.40.252/webservice/hospub',
            'uri' => 'http://172.30.40.252/webservice/hospub',
            'trace' => 1,
            'exceptions' => 0));


        $aParam['PRONTUARIO'] = $_POST['txtprontuario'];
        $pront = ($Obj->samehospublista($aParam));
//                $aParam['be']= $_POST['txtprontuario'];
//                $pront = ($Obj->testeijf($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;


        return $pront;
    }

    function consultacodigomunicipio() {
        try {

            $Obj = new SoapClient(null, array(
                'location' => 'http://172.30.40.252/webservice/hospub',
                'uri' => 'http://172.30.40.252/webservice/hospub',
                'trace' => 1,
                'exceptions' => 0));
            $aParam['be'] = 'S';
            $pront = ($Obj->consultacodigomunicipio($aParam));
//                echo "<pre>";
//                var_dump($pront);
//                echo "</pre>";
//                die;
            return $pront;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    function listapacientes($municipio) {

        $Obj = new SoapClient(null, array(
            'location' => 'http://172.30.40.252/webservice/hospub',
            'uri' => 'http://172.30.40.252/webservice/hospub',
            'trace' => 1,
            'exceptions' => 0));

        $aParam['municipio'] = $municipio;
        $pront = ($Obj->consultapacientes($aParam));
        var_dump($pront);
        die;
        if ($pront != null) {
            foreach ($pront as $value) {
                echo "<pre>";
                var_dump($pront);
                echo "</pre>";
                die;
                $args['procedimento'] = trim($value['N57PROCAMB']);
                $args['cpf'] = trim($value['C57CPFMED']);
                $args['nome'] = trim($nome);
                $args['crm'] = trim($crm);
                $args['competencia'] = trim($competencia);
                //var_dump($value['C57CPFMED']);
                $this->db->insert('tb_emergencia_faturamentomedico', $args);
            }
        }
    }

    function listarfuncionariosempresacadastro($empresa_id = NULL) {
        $this->db->select('fp.forma_pagamento_id,pc.paciente_contrato_id,p.nome as paciente, fp.nome as forma_pagamento,p.paciente_id,fp.valor1,fp.valor6,fp.valor12,fp.valor5,fp.valor10,fp.valor11');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.empresa_id', $empresa_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('p.empresa_id is not null');
        $this->db->orderby('fp.nome,p.nome');
        return $this->db->get()->result();
    }

    function excluirfuncionario($paciente_id) {

        try {
            $this->db->set('ativo', 'f');
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');
            return 0;
        } catch (Exception $ex) {
            return -1;
        }
    }

    function somarparcelasdefuncionarios($paciente_id = NULL) {
        $this->db->select('pcp.valor,pcp.parcela');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('pcp.excluido', 'f');
        $this->db->where('pcp.empresa_iugu', 'f');
        $this->db->where('pcp.ativo', 't');
        $this->db->where('p.paciente_id', $paciente_id);
        return $this->db->get()->result();
    }

    function excluirempresacadastro($empresa_id = NULL) {
        $horario = date("Y-m-d H:i:s");
        try {
 
            $this->db->select('pc.paciente_contrato_id,p.paciente_id');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
            $this->db->where('p.empresa_id', $empresa_id);
            $this->db->where('p.ativo', 't');
            $return = $this->db->get()->result();

            foreach ($return as $item) {
                $this->db->where('paciente_contrato_id', $item->paciente_contrato_id);
                $this->db->set('ativo_admin', 'f');
                $this->db->set('excluido', 't');
                $this->db->update('tb_paciente_contrato');

                $this->db->where('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', null);
                $this->db->update('tb_paciente');
            }

            $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('ativo', 'f');
            $this->db->where('empresa_cadastro_id', $empresa_id);
            $this->db->update('tb_empresa_cadastro');

            return 0;
        } catch (Exception $ex) {
            return -1;
        }
    }

    function listarparcelaspacienteempresacadastro($empresa_id) {

        $this->db->select('p.paciente_id,pcp.paciente_contrato_parcelas_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id');
        $this->db->where('p.ativo', 't');
        $this->db->where('pcp.excluido', 'f');
        $this->db->where('pcp.ativo', 't');
        $this->db->where('p.empresa_id', $empresa_id);
        $this->db->where('pc.ativo', 't');
        return $this->db->get()->result();
    }

    function listarformaspagamentos() {

        $this->db->select('');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function listarpagamentosplano($parametro) {
        $this->db->select('');
        $this->db->from('tb_forma_pagamento p');
        $this->db->where("p.ativo", 't');
        if (@$parametro != "") {
            $this->db->where('p.forma_pagamento_id', @$parametro);
        }


//        $this->db->orderby("descricao");
        return $return = $this->db->get()->result();
    }

    function gravarquantidadefuncionarios() {

 
        $horario = date("Y-m-d H:i:s");
        $ajuste = substr($_POST['checkboxvalor1'], 3, 5);
        $parcelas = substr($_POST['checkboxvalor1'], 0, 2);
        $parcelas = (int) $parcelas;
        $this->db->set('parcelas', $parcelas);
        $this->db->set('forma_pagamento_id', $_POST['plano']);
        $this->db->set('qtd_funcionarios', $_POST['qtd']);
        $this->db->set('valor', $ajuste);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('empresa_id', $_POST['empresa_id_qtd']);
        $this->db->set('operador_cadastro', $this->session->userdata('operador_id'));
        $this->db->insert('tb_qtd_funcionarios_empresa');
    }

    function listarquantidadedefuncionario($empresa_id) {
        $this->db->select('qf.qtd_funcionarios_empresa_id,qf.valor,qf.qtd_funcionarios,fp.nome as plano,qf.parcelas,qf.forma_pagamento_id');
        $this->db->from('tb_qtd_funcionarios_empresa qf');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = qf.forma_pagamento_id', 'left');
        $this->db->where('qf.ativo', 't');
        $this->db->where('empresa_id', $empresa_id);
        return $this->db->get()->result();
    }

    function atualizarquantidadefuncionarios() {


        $this->db->select('');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id');
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('pc.plano_id', $_POST['plano_id']);
        $this->db->where('p.empresa_id', $_POST['empresa_id']);

        $quantidade = $this->db->get()->result();


        if (@$_POST['quantidade_fun'] >= count($quantidade)) {
            
        } else {

            return -1;
        }




        $horario = date("Y-m-d H:i:s");
        $this->db->where('qtd_funcionarios_empresa_id', $_POST['qtd_funcionarios_empresa_id']);
        $this->db->set('qtd_funcionarios', $_POST['quantidade_fun']);
        $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
        $this->db->set('data_atualizacao', $horario);
        $this->db->update('tb_qtd_funcionarios_empresa');
    }

    function excluirfuncionarioqtd($qtd_funcionarios_empresa_id) {

        $horario = date("Y-m-d H:i:s");
        $this->db->where('qtd_funcionarios_empresa_id', $qtd_funcionarios_empresa_id);
        $this->db->set('ativo', 'f');
        $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
        $this->db->set('data_atualizacao', $horario);
        $this->db->update('tb_qtd_funcionarios_empresa');
    }

    function listarpagamentoscontratoparcelaiuguempresa($paciente_contrato_parcelas_id) {
        $this->db->select('valor, data, cp.ativo, paciente_contrato_parcelas_id, fp.nome as plano, fp.multa_atraso, fp.juros, cp.observacao');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
//        $this->db->where('');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadosempresa($empresa_id) {

        $this->db->select('e.*,m.codigo_ibge');
        $this->db->from('tb_empresa e');
        $this->db->join("tb_municipio m", 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        return $this->db->get()->result();
    }

    function listarpagamentoscontratoempresa($empresa_id) {
        $this->db->select('valor, pc.ativo as contrato,
                            cp.data, 
                            cp.ativo, 
                            cp.manual,
                            cp.debito,
                            pc.paciente_id,
                            cp.observacao,
                            pdf, 
                            url, 
                            invoice_id, 
                            cp.taxa_adesao,
                            cp.data_cartao_iugu, 
                            cp.pago_cartao, 
                            cpi.status,cpi.codigo_lr,
                            cp.paciente_contrato_id, 
                            cp.paciente_contrato_parcelas_id,
                            paciente_contrato_parcelas_iugu_id,
                            p.credor_devedor_id,
                            p.empresa_id,
                            cp.empresa_iugu
                            ');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
//        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where('p.empresa_id', $empresa_id);
        $this->db->where('p.ativo', 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where('cp.ativo', 't');
        $this->db->where('pc.ativo', 't');
        $this->db->where('cp.parcela_verificadora', null);
        $this->db->orderby("data");
        $return = $this->db->get()->result();
//        echo "<pre>";
//        var_dump($return); die;
        return $return;
    }

    function listarpagamentosconsultaavulsaempresa($empresa_id) {
        $this->db->select('cp.*,pc.paciente_contrato_id,p.empresa_id');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->join('tb_paciente p', 'p.paciente_id = cp.paciente_id');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id');
        $this->db->where('pc.ativo', 't');
        $this->db->where("p.empresa_id", $empresa_id);
        $this->db->where("cp.excluido", 'f');
        $this->db->where("tipo", 'EXTRA');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentosconsultacoopempresa($empresa_id) {
        $this->db->select('cp.*,pc.paciente_contrato_id,p.empresa_id');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->join('tb_paciente p', 'p.paciente_id = cp.paciente_id');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id');
        $this->db->where("p.empresa_id", $empresa_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("tipo", 'COOP');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarhistoricoconsultasrealizadasempresa($empresa_id) {
        $this->db->select('cp.data');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id');
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.empresa_id', $empresa_id);
//        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.excluido", 'f');
        $this->db->orderby("data");



        $return = $this->db->get()->result();
        if (count($return) > 0) {
            // Traz o período em que este contrato vai estar em vigor
            $dt_inicio = $return[0]->data;
            $dt_fim = $return[count($return) - 1]->data;

            $this->db->select('ae.*,p.telefone,p.celular, p.nome as paciente, fp.fantasia as parceiro');
            $this->db->from('tb_exames_fidelidade ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_fidelidade_id', 'left');
            $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = ae.parceiro_id', 'left');
            // Busca as consultas dos pacientes que pertencem a esse contrato no periodo em que o contrato está em vigor
            $this->db->where("ae.paciente_fidelidade_id IN (
                SELECT pcd.paciente_id FROM ponto.tb_paciente_contrato_dependente pcd
                INNER JOIN ponto.tb_paciente_contrato pc 
                ON pcd.paciente_contrato_id = pc.paciente_contrato_id
                INNER JOIN ponto.tb_paciente p 
                ON p.paciente_id = pc.paciente_id
                
 WHERE pcd.ativo = 't'  AND pc.ativo='t' AND p.empresa_id = {$empresa_id}
            )");
            $this->db->where("ae.data >=", $dt_inicio);
            $this->db->where("ae.data <=", $dt_fim);

            $return = $this->db->get();
            return $return->result();
        } else {
            return array();
        }
    }

    function salvargravadotodosiugu($contrato_id = NULL) {
        $this->db->set('pago_todos_iugu', 't');
        $this->db->where('paciente_contrato_id', $contrato_id);
        $this->db->update('tb_paciente_contrato');
    }

    function verificarsepagouemiugu($contrato_id) {

        $this->db->select('');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_contrato_id', $contrato_id);

        return $this->db->get()->result();
    }

    function gravardocumentosfuncionarioempresa() {

        try {

            $this->db->select('');
            $this->db->from('tb_qtd_funcionarios_empresa');
            $this->db->where('empresa_id', $_POST['empresa_cadastro_id']);
            $this->db->where('ativo', 't');
            $this->db->where('forma_pagamento_id', $_POST['plano']);
            $retorno = $this->db->get()->result();


            $this->db->select('');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id');
            $this->db->where('pc.ativo', 't');
            $this->db->where('p.ativo', 't');
            $this->db->where('empresa_id', $_POST['empresa_cadastro_id']);
            $this->db->where('plano_id', @$retorno[0]->forma_pagamento_id);
            $quantidade = $this->db->get()->result();



            if (count($retorno) <= 0) {
                return -2;
            } else {
                
            }

            if ($retorno[0]->qtd_funcionarios > count($quantidade)) {
                
            } else {
                return -1;
            }



            $this->db->select('consulta_avulsa, consulta_coop');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $_POST['plano']);
            $consulta_avulsa = $this->db->get()->result();
//            var_dump($consulta_avulsa); die;
            if ($_POST['txtcboID'] == "") {
                $this->db->select('cbo_ocupacao_id');
                $this->db->from('tb_cbo_ocupacao');
                $this->db->orderby('cbo_ocupacao_id desc');
                $this->db->limit(1);
                $ultimaprofissao = $this->db->get()->result();
//                var_dump($ultimaprofissao); die;
                $last_id = $ultimaprofissao[0]->cbo_ocupacao_id + 1;

                $this->db->set('cbo_ocupacao_id', $last_id);
                $this->db->set('descricao', $_POST['txtcbo']);
                $this->db->insert('tb_cbo_ocupacao');
                $ocupacao_id = $last_id;

                $this->db->set('profissao', $ocupacao_id);
            } elseif ($_POST['txtcboID'] != "") {
                $this->db->set('profissao', $_POST['txtcboID']);
            }

            $this->db->set('nome', $_POST['nome']);

            $this->db->set('codigo_paciente', @$_POST['cod_pac']);
            if ($_POST['parceiro_id'] != '') {
                $this->db->set('parceiro_id', $_POST['parceiro_id']);
            }

            if (@$_POST['forma_rendimento_id'] != '') {
                $this->db->set('forma_rendimento_id', @$_POST['forma_rendimento_id']);
            }

            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
//            if ($_POST['financeiro_parceiro_id'] != '') {
//                $this->db->set('financeiro_parceiro_id', $_POST['financeiro_parceiro_id']);
//            }
            if (count($consulta_avulsa) > 0) {
                $this->db->set('consulta_avulsa', $consulta_avulsa[0]->consulta_avulsa);
                $this->db->set('consulta_coop', $consulta_avulsa[0]->consulta_coop);
            }
//            if ($_POST['data_emissao'] != '') {
//                $this->db->set('data_emissao', $_POST['data_emissao']);
//            }
            if ($_POST['indicacao'] != '') {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            $this->db->set('sexo', $_POST['sexo']);

            if ($_POST['estado_civil_id'] != '') {
                $this->db->set('estado_civil_id', $_POST['estado_civil_id']);
            }
            $this->db->set('nome_pai', $_POST['nome_pai']);
            $this->db->set('nome_mae', $_POST['nome_mae']);
            if ($_POST['tipo_logradouro'] != '') {
                $this->db->set('tipo_logradouro', $_POST['tipo_logradouro']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('convenio_id', $_POST['plano']);
            $this->db->set('numero', $_POST['numero']);
            if (@$_POST['vendedor'] != '') {
                $this->db->set('vendedor', @$_POST['vendedor']);
            }
            $this->db->set('situacao', $_POST['situacao']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }

            if (@$_POST['empresa_cadastro_id'] != '') {
                $this->db->set('empresa_id', @$_POST['empresa_cadastro_id']);
            } else {
                $this->db->set('empresa_id', null);
            }


            $this->db->set('cep', $_POST['cep']);

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            $dia = substr($horario, 8, 2);
            $mes = substr($horario, 5, 2);
            $ano = substr($horario, 0, 4);
            $dataatual = $dia . '/' . $mes . '/' . $ano;

            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['paciente_id'] == "") {// insert
                $this->db->set('data_cadastro', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $paciente_id = $this->db->insert_id();

                $situacao = $_POST['situacao'];
                if ($situacao == 'Titular') {
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('plano_id', $_POST['plano']);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_paciente_contrato');
                    $paciente_contrato_id = $this->db->insert_id();

//                    $dia_menos_um = date('d') - 1;
//                    $data_verificadora = date('Y-m-' . $dia_menos_um . '');
////          echo $data_verificadora;die; 
//                    $this->db->set('valor', 0.00);
//                    $this->db->set('parcela', null);
//                    $this->db->set('paciente_contrato_id', $paciente_contrato_id);
////            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
//                    $this->db->set('data', $data_verificadora);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->set('parcela_verificadora', 't');
//                    $this->db->insert('tb_paciente_contrato_parcelas');
                }
            } else { // update
                $paciente_id = $_POST['paciente_id'];
                $this->db->set('data_atualizacao', $data);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarformapagamento() {
        $this->db->select('');
        $this->db->from('tb_forma_rendimento');
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function finalizarcadastrofuncionarios($paciente_id = NULL) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $this->db->set('paciente_id', $_POST['txtpaciente']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if (@$_POST['forma_rendimento'] != "") {
                $this->db->set('forma_rendimento_id', @$_POST['forma_rendimento']);
            }
            if (@$_POST['vendedor'] != "") {
                $this->db->set('vendedor_id', @$_POST['vendedor']);
            }
            $this->db->set('empresa_cadastro_id', $_POST['empresa_id']);
            $this->db->insert('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            $paciente_contrato_id = $this->db->insert_id();
            return $paciente_contrato_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarcontratocadastroempresa($empresa_id) {

        $this->db->select('');
        $this->db->from('tb_paciente_contrato p');
        $this->db->where('empresa_cadastro_id', $empresa_id);
        $this->db->where('ativo_admin', 't');

        return $this->db->get()->result();
    }

    function listarpagamentoscontratoempresacontrato($contrato_id) {
        $this->db->select('valor, pc.ativo as contrato,
                            cp.data, 
                            cp.ativo, 
                            cp.manual,
                            cp.debito,
                            pc.paciente_id,
                            cp.observacao,
                            pdf, 
                            url, 
                            invoice_id, 
                            cp.taxa_adesao,
                            cp.data_cartao_iugu, 
                            cp.pago_cartao, 
                            cpi.status,cpi.codigo_lr,
                            cp.paciente_contrato_id, 
                            cp.paciente_contrato_parcelas_id,
                            paciente_contrato_parcelas_iugu_id, 
                            cp.empresa_iugu,
                            fr.nome as forma_pagamento
                            ');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_rendimento fr','fr.forma_rendimento_id = pc.forma_rendimento_id','left');
//        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
//        $this->db->where('p.empresa_id', $empresa_id); 
        $this->db->where("cp.excluido", 'f');
//        $this->db->where('cp.ativo', 't');
//        $this->db->where('pc.ativo', 't');
        $this->db->where('cp.parcela_verificadora', 'f');
        $this->db->orderby("data");
        $return = $this->db->get()->result();
//        echo "<pre>";
//        var_dump($return); die;
        return $return;
    }

    function listarpagamentoscontratoiuguempresa($contrato_id) {
        $this->db->select('valor, cp.data, cp.ativo, paciente_contrato_parcelas_id, cp.observacao');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
//        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
//        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->where('cp.paciente_contrato_id', $contrato_id);
        $this->db->where('pc.ativo', 't');
//        $this->db->where('p.ativo', 't');
//        $this->db->where('');
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelasempresa() {


        $data = date("Y-m-t");
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.data <=", $data);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->where("pc.ativo", 't');
        $this->db->where("cpi.empresa_id is not null");
//      $this->db->where("p.ativo", 't');
        $this->db->where("cpi.invoice_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function atualizarvalorcontratoempresa($empresa_cadastro_id) {
        $valor_total = 0;
        $this->db->select('qf.qtd_funcionarios_empresa_id,qf.valor,qf.qtd_funcionarios,fp.nome as plano,qf.parcelas,qf.forma_pagamento_id');
        $this->db->from('tb_qtd_funcionarios_empresa qf');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = qf.forma_pagamento_id', 'left');
        $this->db->where('qf.ativo', 't');
        $this->db->where('empresa_id', $empresa_cadastro_id);
        $return2 = $this->db->get()->result();
        foreach ($return2 as $item) {
            $valor_total += $item->valor * $item->parcelas * $item->qtd_funcionarios;
        }
//        echo "<pre>";
//        print_r($valor_total);
//        die;

        $this->db->select('pcp.paciente_contrato_parcelas_id');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->where('pcp.ativo', 't');
        $this->db->where('pcp.excluido', 'f');
        $this->db->where('pc.ativo', 't');
        $this->db->where('pc.empresa_cadastro_id', $empresa_cadastro_id);
        $return = $this->db->get()->result();

        $this->db->set('valor', $valor_total);
        $this->db->where('paciente_contrato_parcelas_id', $return[0]->paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
    }

    function listartodospacientes() {
        $this->db->select('paciente_id');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function listarpagamentoscontratoparcelagerencianet($paciente_contrato_parcelas_id) {
        $this->db->select('charge_id');
        $this->db->from('tb_paciente_contrato_parcelas_gerencianet cp');
        $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelagerencianettodos($contrato_id) {
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano,cpi.charge_id,cpi.link,cp.parcela,cp.paciente_dependente_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.taxa_adesao", 'f');
//        $this->db->where("charge_id is null");        
//        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelaGN($paciente_contrato_parcelas_id) {
        $this->db->select('cp.valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, fp.multa_atraso, fp.juros, cp.observacao,pg.charge_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet pg', 'pg.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelagerncianetpendentes() {
        $data = date("Y-m-t");
        $this->db->select('valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano, pc.paciente_id, cpi.charge_id,cpi.carne,cpi.carnet_id,cpi.num_carne');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.data <=", $data);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->where("pc.ativo", 't');
        $this->db->where("p.ativo", 't');
        $this->db->where("cpi.charge_id is not null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoconsultaavulsaGN($consultas_avulsas_id) {
        $this->db->select('*');
        $this->db->from('tb_consultas_avulsas ');
        $this->db->where("consultas_avulsas_id", $consultas_avulsas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelagerencianetcarne($contrato_id) {
        $this->db->select('cp.valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano,cpi.charge_id,cpi.link,cp.parcela');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.taxa_adesao", 'f');
        $this->db->where('cp.parcela > 0');
//        $this->db->where("charge_id is null");        
//        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarpagamentoscontratoparcelagerencianetcarneupdate($contrato_id, $valor) {
        $this->db->select('cp.valor, cp.data, cp.ativo, cp.paciente_contrato_parcelas_id, fp.nome as plano,cpi.charge_id,cpi.link,cp.parcela');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_gerencianet cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $contrato_id);
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.excluido", 'f');
        $this->db->where("cp.taxa_adesao", 'f');
        $this->db->where("charge_id is null");
        $this->db->where("cp.valor", $valor);
//        $this->db->where("cp.data_cartao_iugu is null");
        $this->db->orderby("cp.data");
        $return = $this->db->get();
        return $return->result();
    }

    function listarcontratotitular() {
        $this->db->select('paciente_contrato_id, plano_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_id', $_POST['txtNomeid']);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $return = $query->result();
        $paciente_contrato_id = $return[0]->paciente_contrato_id;
        return $paciente_contrato_id;
    }

    function reativarpaciente() {
        $operador = $this->session->userdata('operador_id');
        $horario = date('Y-m-d H:i:s');
        $this->db->set('ativo', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador);
        $this->db->update('tb_paciente');
    }

    function listardadospaciente($paciente_id) {
        $this->db->select('cbo.descricao,p.logradouro,p.complemento, p.nascimento,p.cep,p.telefone,p.celular,p.numero,p.bairro,p.nome,p.estado_civil_id,p.rg,p.cpf,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge, p.tipo_logradouro, tl.descricao as logro');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_tipo_logradouro tl', 'p.tipo_logradouro = tl.tipo_logradouro_id', 'left');
        $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
        $this->db->where('paciente_id', $paciente_id);
        return $this->db->get()->result();
    }

    function listaridcontrato($paciente_id) {
        $this->db->select('paciente_contrato_id, data_cadastro, paciente_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function listaridcontrato2($paciente_id) {
        $this->db->select('paciente_contrato_id, data_cadastro, paciente_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_contrato_id', $paciente_id);
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function listaridcontrato_dependente($paciente_id) {
        $this->db->select('paciente_contrato_id');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function gravarerrogerencianet($paciente_id, $contrato_id, $message, $code_error) {
        $operador = $this->session->userdata('operador_id');
        $horario = date('Y-m-d H:i:s');
        $this->db->set('operador_cadastro', $operador);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('code_erro', $code_error);
        $this->db->set('paciente_contrato_id', $contrato_id);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('mensagem', $message);
        $this->db->insert('tb_erros_gerencianet');
    }

    function listarerros($args = array()) {

        $this->db->select('p.nome as paciente, eg.mensagem,eg.code_erro,eg.erros_gerencianet_id,eg.data_cadastro');
        $this->db->from('tb_erros_gerencianet eg');
        $this->db->join('tb_paciente p', 'p.paciente_id = eg.paciente_id', 'left');
        $this->db->where('eg.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', '%' . $args['nome'] . '%');
        }
        return $this->db;
    }

    function excluirerro($erros_gerencianet_id) {
        $operador = $this->session->userdata('operador_id');
        $horario = date('Y-m-d H:i:s');
        $this->db->set('operador_atualizacao', $operador);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->where('erros_gerencianet_id', $erros_gerencianet_id);
        $this->db->update('tb_erros_gerencianet');
    }

    function contadorcpfautocomplete($cpf, $paciente_id) {
        $this->db->select();
        $this->db->from('tb_paciente');
        $this->db->where('cpf', str_replace("-", "", str_replace(".", "", $cpf)));
        $this->db->where('ativo', 't');
        if ($paciente_id > 0) {
            $this->db->where('paciente_id !=', $paciente_id);
        }
        $this->db->where('cpf_responsavel_flag', 'f');
        $return = $this->db->count_all_results();
        return $return;
    }
    
    
    
    function listarenviosiugucard($args = array()) {
        $this->db->select('eg.data_cadastro,pc.valor,pc.paciente_contrato_id,p.nome as paciente,eg.envio_iugu_card_id,pc.data_cartao_iugu as data,p.paciente_id,eg.paciente_contrato_parcelas_id');
        $this->db->from('tb_envio_iugu_card eg'); 
        $this->db->join('tb_paciente_contrato_parcelas pc','pc.paciente_contrato_parcelas_id = eg.paciente_contrato_parcelas_id','left');      
        $this->db->join('tb_paciente_contrato pct','pct.paciente_contrato_id = pc.paciente_contrato_id','left');
        $this->db->join('tb_paciente p','p.paciente_id = pct.paciente_id','left');
        $this->db->where('eg.ativo', 't');   
        $this->db->groupby('eg.envio_iugu_card_id,eg.data_cadastro,pc.valor,pc.paciente_contrato_id,p.nome,pc.data_cartao_iugu,p.paciente_id');      
        $this->db->order_by('eg.data_cadastro','desc');    
         
        if (isset($args['data']) && strlen($args['data']) > 0) {   
             $this->db->where('eg.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))) . " 00:00:00");
             $this->db->where('eg.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))) . " 23:59:59");
        }else{
             //$this->db->where('eg.data_cadastro >=',date('Y-m-d') . " 00:00:00");
           // $this->db->where('eg.data_cadastro <=',date('Y-m-d')  . " 23:59:59");
        }
        
        if (isset($args['nome']) && strlen($args['nome']) > 0) {   
             $this->db->where('p.nome ilike',"%".$args['nome']."%");             
        } 
        
        if (isset($args['numero_cliente']) && strlen($args['numero_cliente']) > 0) {   
             $this->db->where('p.paciente_id',$args['numero_cliente']);             
        } 
        
        
        if (isset($args['numero_contrato']) && strlen($args['numero_contrato']) > 0) {   
             $this->db->where('pc.paciente_contrato_id',$args['numero_contrato']);             
        } 
        return $this->db;
    }
    
    
    function excluirenvioiugu($envio_iugu_card_id) {
        $operador = $this->session->userdata('operador_id');
        $horario = date('Y-m-d H:i:s');
        $this->db->set('operador_atualizacao', $operador);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->where('envio_iugu_card_id', $envio_iugu_card_id);
        $this->db->update('tb_envio_iugu_card');
    }

    
    function listarprecadastro($args = array()){    
        
        $this->db->select('pc.nome,pc.cpf,pc.telefone,pc.precadastro_id,pc.nome as forma_pagamento,op.nome as vendedor');
        $this->db->from('tb_precadastro pc');
        $this->db->join('tb_forma_pagamento fp','fp.forma_pagamento_id = pc.plano_id',"left"); 
        $this->db->join('tb_operador op','op.operador_id = pc.vendedor','left');
        $this->db->where('pc.ativo','t');
        return $this->db;
        
    }
    
    
    function dadosvendedor($vendedor_id=NULL){
        $this->db->select('nome,operador_id');
        $this->db->from('tb_operador');
        if ($vendedor_id == "") {
            $this->db->where('operador_id',$this->session->userdata('operador_id')); 
        }else{
             $this->db->where('operador_id',$vendedor_id); 
        }
       
       return  $this->db->get()->result();        
    }
    
    function gravarprecadastro(){
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');
        
        if ($_POST['precadastro_id'] != "") {
            $this->db->set('nome', $_POST['nome']);
            if (str_replace("-", "", str_replace(".", "", $_POST['cpf'])) != "") {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            }
            if (str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))) != "") {
                $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            }
            if ($_POST['plano'] != "") {
                $this->db->set('plano_id', $_POST['plano']);
            }
            $this->db->set('vendedor', $_POST['vendedor']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador);
            $this->db->where('precadastro_id', $_POST['precadastro_id']);
            $this->db->update('tb_precadastro');
            return $_POST['precadastro_id'];
        }else{
            
        
        $this->db->set('nome', $_POST['nome']);

        if (str_replace("-", "", str_replace(".", "", $_POST['cpf'])) != "") {
            $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
        }
        if (str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))) != "") {
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
        }
        if ($_POST['plano'] != "") {
            $this->db->set('plano_id',$_POST['plano']);     
        }

        $this->db->set('vendedor',$_POST['vendedor']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador);
        $this->db->insert('tb_precadastro');
        
        
        
         return $this->db->insert_id();
        }
       
        
    }
    
    
    function excluirprecadastro($precadastro_id){
        $horario = date('Y-m-d H:i:s');
        $operdador = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operdador);
        $this->db->where('precadastro_id',$precadastro_id);
        $this->db->update('tb_precadastro');
        
        
    }
    
    
    function listardadosprecadastro($precadastro_id){
       $this->db->select('');
       $this->db->from('tb_precadastro');
       $this->db->where('precadastro_id',$precadastro_id);
       return $this->db->get()->result(); 
    }
    
    function atualizarformarendimentodependete($contrato_id){
        $this->db->select('p2.forma_rendimento_id,p.paciente_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato pc','pc.paciente_contrato_id = pcd.paciente_contrato_id','left');
        $this->db->join('tb_paciente p2','p2.paciente_id = pc.paciente_id','left'); 
        $this->db->where("pcd.paciente_contrato_id", $contrato_id);
        $this->db->where("pcd.ativo", "t");
        $this->db->where("pc.ativo", "t");
        $this->db->where("pc.excluido", "f");
        $this->db->where('p.situacao','Dependente'); 
        $return = $this->db->get()->result();
        foreach($return as $value){
            $this->db->where('paciente_id',$value->paciente_id);
            $this->db->set('forma_rendimento_id',$value->forma_rendimento_id);
            $this->db->update('tb_paciente'); 
        }  
    }
    
    function listarparcelaspagas($contrato_id){  
        $this->db->select('valor, data, cp.ativo, paciente_contrato_parcelas_id, fp.nome as plano, multa_atraso, juros, observacao');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = cp.paciente_contrato_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->orderby("data");
        $this->db->where('cp.excluido','f');
        $this->db->where('cp.ativo','f');
        $return = $this->db->get();
        return $return->result();
         
    }
    
    
    function listarformaredimento($forma_pagemento=NULL){
        
        $this->db->select('');
        $this->db->from('tb_forma_rendimento');
        $this->db->where('forma_rendimento_id',$_POST['forma_pagamento']); 
        return $this->db->get()->result();
        
    }
    
    
    function listadadosempresacadastro($empresa_id){        
        $this->db->select('e.*,m.codigo_ibge');
        $this->db->from('tb_empresa_cadastro e');
        $this->db->join("tb_municipio m", 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_cadastro_id', $empresa_id);
        return $this->db->get()->result();
    }
    
    function listarvoucherconsultaavulsa($paciente_id) {
        $this->db->select('vc.voucher_consulta_id,vc.data,vc.horario,vc.confirmado,vc.horario_uso, vc.gratuito');
        $this->db->from('tb_consultas_avulsas cp');
        $this->db->join('tb_voucher_consulta vc','vc.consulta_avulsa_id = cp.consultas_avulsas_id','left');
        $this->db->where("cp.paciente_id", $paciente_id);
        $this->db->where("cp.excluido", 'f');
        $this->db->where("vc.ativo", 't');
        $this->db->where("cp.tipo", 'EXTRA');        
        if($this->session->userdata('financeiro_parceiro_id') != ""){
           $this->db->where("vc.parceiro_id", $this->session->userdata('financeiro_parceiro_id'));  
        }
        $this->db->orderby("vc.data_cadastro desc");
        $return = $this->db->get();
        return $return->result();
    }
    
}

?>
