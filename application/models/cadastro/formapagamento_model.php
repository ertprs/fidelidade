<?php

class formapagamento_model extends Model {

    var $_forma_pagamento_id = null;
    var $_nome = null;
    var $_conta_id = null;
    var $_ajuste = null;
    var $_dia_receber = null;
    var $_tempo_receber = null;
    var $_credor_devedor = null;
    var $_taxa_juros = null;
    var $_carencia_especialidade = null;
    var $_carencia_consulta = null;
    var $_carencia_exame = null;
    var $_valor1 = null;
    var $_valor5 = null;
    var $_valor6 = null;
    var $_valor10 = null;
    var $_valor12 = null;
    var $_valor_carteira = null;
    var $_valor_carteira_titular = null;
    var $_valoradcional = null;
    var $_parcelas = null;
    var $_comissao = null;
    var $_qtd_dias = null;
    var $_nome_impressao = null;

    function Formapagamento_model($forma_pagamento_id = null) {
        parent::Model();
        if (isset($forma_pagamento_id)) {
            $this->instanciar($forma_pagamento_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('forma_pagamento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarformarendimento($args = array()) {
        $this->db->select('forma_rendimento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_rendimento');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function carregarformarendimento($formarendimento_id) {
        $this->db->select('forma_rendimento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_rendimento');
        $this->db->where('forma_rendimento_id', $formarendimento_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo($args = array()) {
        $this->db->select('financeiro_grupo_id,
                            nome 
                            ');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('forma_pagamento_id,
                            nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformaRendimentoPaciente() {
        $this->db->select('forma_rendimento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_rendimento');
        $this->db->where("ativo", 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarformaRendimentoPlanoComissao($plano_id) {
        $this->db->select(' frc.forma_rendimento_id,
                            fr.nome as forma, 
                            frc.forma_rendimento_comissao_id,
                            frc.inicio_parcelas,
                            frc.fim_parcelas,
                            frc.plano_id,
                            frc.valor_comissao
                            ');
        $this->db->from('tb_forma_rendimento_comissao frc');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = frc.forma_rendimento_id', 'left');
        $this->db->where("frc.ativo", 't');
        $this->db->where("frc.plano_id", $plano_id);
        $this->db->orderby("forma_rendimento_id, inicio_parcelas");

        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos() {
        $this->db->select('financeiro_grupo_id,
                            nome');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformapagamentonogrupo($financeiro_grupo_id) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id,
                           gf.grupo_formapagamento_id,
                           gf.grupo_id');
        $this->db->from('tb_grupo_formapagamento gf');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->where('gf.ativo', 'true');
        $this->db->where('fp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function buscafaixasparcelas($forma_pagamento_id) {
        $this->db->select('*');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id", $forma_pagamento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_pagamento_id) {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id', "$forma_pagamento_id");
        $return = $this->db->get();
        return $return->result();
    }

    function buscargrupo($financeiro_grupo_id) {
        $this->db->select('financeiro_grupo_id,
                            nome,
                            ajuste');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $this->db->where('financeiro_grupo_id', "$financeiro_grupo_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_pagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $this->db->update('tb_forma_pagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirFormaRendimento($forma_pagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_rendimento_id', $forma_pagamento_id);
        $this->db->update('tb_forma_rendimento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirFormaRendimentoComissao($forma_rendimento_comissao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_rendimento_comissao_id', $forma_rendimento_comissao_id);
        $this->db->update('tb_forma_rendimento_comissao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirparcela($parcela_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('formapagamento_pacela_juros_id', $parcela_id);
        $this->db->update('tb_formapagamento_pacela_juros');
    }

    function excluirformapagamentodogrupo($grupo_formapagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_formapagamento_id', $grupo_formapagamento_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirgrupo($grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_grupo_id', $grupo_id);
        $this->db->update('tb_financeiro_grupo');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_id', $grupo_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarparcelas() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);

        $this->db->set('forma_pagamento_id', $_POST['formapagamento_id']);
        $this->db->set('taxa_juros', $_POST['taxa']);
        $this->db->set('parcelas_inicio', $_POST['parcela_inicio']);
        $this->db->set('parcelas_fim', $_POST['parcela_fim']);
        $this->db->insert('tb_formapagamento_pacela_juros');
    }

    function gravarFormaRendimentoComissao() {

        $this->db->select('forma_rendimento_comissao_id, inicio_parcelas, fim_parcelas');
        $this->db->from('tb_forma_rendimento_comissao');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_rendimento_id', $_POST['forma_rendimento_id']);
        $this->db->where('plano_id', $_POST['plano_id']);
        $this->db->where('inicio_parcelas <=', $_POST['inicio_parcelas']);
        $inicio_parcelas = $_POST['inicio_parcelas'];
        $this->db->where("(fim_parcelas >= $inicio_parcelas or fim_parcelas is null)");
        $this->db->orderby('fim_parcelas');
        $return = $this->db->get()->result();

        $this->db->select('forma_rendimento_comissao_id, inicio_parcelas, fim_parcelas');
        $this->db->from('tb_forma_rendimento_comissao');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_rendimento_id', $_POST['forma_rendimento_id']);
        $this->db->where('plano_id', $_POST['plano_id']);
        $fim_parcelas = $_POST['fim_parcelas'];
        $this->db->where('inicio_parcelas <=', $fim_parcelas);
        $this->db->where("(fim_parcelas >= $fim_parcelas or fim_parcelas is null)");
        $this->db->orderby('fim_parcelas');
        $return2 = $this->db->get()->result();
        // echo '<pre>';
        // var_dump($return2); die;
        // $return;
        if (count($return) > 0) {
            return -10;
        }
        if ($_POST['inicio_parcelas'] > $_POST['fim_parcelas'] && $_POST['fim_parcelas'] > 0) {
            return -11;
        }
        if (count($return2) > 0) {
            return -12;
        }

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);

        $this->db->set('plano_id', $_POST['plano_id']);
        $this->db->set('forma_rendimento_id', $_POST['forma_rendimento_id']);
        $this->db->set('valor_comissao', str_replace(",", ".", str_replace(".", "", $_POST['valor_comissao'])));
        if ($_POST['inicio_parcelas'] > 0) {
            $this->db->set('inicio_parcelas', $_POST['inicio_parcelas']);
        }
        if ($_POST['fim_parcelas'] > 0) {
            $this->db->set('fim_parcelas', $_POST['fim_parcelas']);
        }

        // $this->db->set('fim_parcelas', $_POST['fim_parcelas']);
        $this->db->insert('tb_forma_rendimento_comissao');
    }

    function gravargruponome() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->insert('tb_financeiro_grupo');
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravargrupoadicionar() {
        try {
            $this->db->select('forma_pagamento_id');
            $this->db->from('tb_grupo_formapagamento');
            $this->db->where('forma_pagamento_id', $_POST['formapagamento']);
            $this->db->where('grupo_id ', $_POST['grupo_id']);
            $return = $this->db->get();
            $result = $return->result();


            if (count($result) == 0) {
                /* inicia o mapeamento no banco */
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('ajuste', $_POST['ajuste']);
                $this->db->where('financeiro_grupo_id ', $_POST['grupo_id']);
                $this->db->update('tb_financeiro_grupo');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('forma_pagamento_id', $_POST['formapagamento']);
                $this->db->set('grupo_id ', $_POST['grupo_id']);
                $this->db->insert('tb_grupo_formapagamento');
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('nome_impressao', $_POST['txtNomeimpressao']);


            $parcelas = $_POST['parcelas'];
            if ($_POST['parcelas'] == "" || $_POST['parcelas'] == 0) {
                $parcelas = 1;
            }
//            var_dump($_POST); die;



            if ($_POST['qtd_dias'] == "") {
                $this->db->set('qtd_dias', null);
            } else {
                $this->db->set('qtd_dias', $_POST['qtd_dias']);
            }
            $this->db->set('valor1', str_replace(",", ".", str_replace(".", "", $_POST['valor1'])));
            $this->db->set('valor5', str_replace(",", ".", str_replace(".", "", $_POST['valor5'])));
            $this->db->set('valor6', str_replace(",", ".", str_replace(".", "", $_POST['valor6'])));
            $this->db->set('valor10', str_replace(",", ".", str_replace(".", "", $_POST['valor10'])));
            $this->db->set('valor11', str_replace(",", ".", str_replace(".", "", $_POST['valor11'])));
            $this->db->set('valor12', str_replace(",", ".", str_replace(".", "", $_POST['valor12'])));
            $this->db->set('valor23', str_replace(",", ".", str_replace(".", "", $_POST['valor23'])));
            $this->db->set('valor24', str_replace(",", ".", str_replace(".", "", $_POST['valor24'])));
            $this->db->set('juros', str_replace(",", ".", str_replace(".", "", $_POST['juros'])));
            $this->db->set('multa_atraso', str_replace(",", ".", str_replace(".", "", $_POST['multa_atraso'])));
            $this->db->set('valor_adesao', str_replace(",", ".", str_replace(".", "", $_POST['valor_adesao'])));
            $this->db->set('valor_carteira', str_replace(",", ".", str_replace(".", "", $_POST['valor_carteira'])));
            $this->db->set('valor_carteira_titular', str_replace(",", ".", str_replace(".", "", $_POST['valor_carteira_titular'])));

            if (isset($_POST['taxa_adesao'])) {
                $this->db->set('taxa_adesao', 't');
            } else {
                $this->db->set('taxa_adesao', 'f');
            }

            $this->db->set('consulta_coop', str_replace(",", ".", str_replace(".", "", $_POST['consulta_coop'])));
            $this->db->set('consulta_avulsa', str_replace(",", ".", str_replace(".", "", $_POST['consulta_avulsa'])));
            $this->db->set('comissao', str_replace(",", ".", str_replace(".", "", $_POST['comissao'])));
            $this->db->set('comissao_vendedor_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_mensal'])));
            $this->db->set('comissao_vendedor', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor'])));
            $this->db->set('comissao_gerente_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_gerente_mensal'])));
            $this->db->set('comissao_gerente', str_replace(",", ".", str_replace(".", "", $_POST['comissao_gerente'])));
            $this->db->set('comissao_seguradora', str_replace(",", ".", str_replace(".", "", $_POST['comissao_seguradora'])));

            $this->db->set('comissao_vendedor_externo_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_externo_mensal'])));
            $this->db->set('comissao_vendedor_externo', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_externo'])));
            $this->db->set('comissao_vendedor_pj', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_pj'])));
            $this->db->set('comissao_vendedor_pj_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_pj_mensal'])));

            $this->db->set('valoradcional', str_replace(",", ".", str_replace(".", "", $_POST['valoradcional'])));
            $this->db->set('parcelas', str_replace(".", "", $parcelas));
            $this->db->set('conta_id', $_POST['conta']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformapagamentoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_pagamento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_pagamento_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
//                $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
                $this->db->where('forma_pagamento_id', $forma_pagamento_id);
                $this->db->update('tb_forma_pagamento');
            }
            return $forma_pagamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarformarendimento() {
        try {
            /* inicia o mapeamento no banco */
            $forma_rendimento_id = $_POST['txtcadastrosformarendimentoid'];
            $this->db->set('nome', $_POST['txtNome']);

            if ($_POST['txtcadastrosformarendimentoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_rendimento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_rendimento_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
//                $forma_rendimento_id = $_POST['txtcadastrosformarendimentoid'];
                $this->db->where('forma_rendimento_id', $forma_rendimento_id);
                $this->db->update('tb_forma_rendimento');
            }
            return $forma_rendimento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcarencia() {
        try {
            /* inicia o mapeamento no banco */
            $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            if ($_POST['carencia_exame_mensal'] != '') {
                $this->db->set('carencia_exame_mensal', 't');
            } else {
                $this->db->set('carencia_exame_mensal', 'f');
            }
            if ($_POST['carencia_consulta_mensal'] != '') {
                $this->db->set('carencia_consulta_mensal', 't');
            } else {
                $this->db->set('carencia_consulta_mensal', 'f');
            }
            if ($_POST['carencia_especialidade_mensal'] != '') {
                $this->db->set('carencia_especialidade_mensal', 't');
            } else {
                $this->db->set('carencia_especialidade_mensal', 'f');
            }
            $this->db->set('carencia_exame', $_POST['carencia_exame']);
            $this->db->set('carencia_consulta', $_POST['carencia_consulta']);
            $this->db->set('carencia_especialidade', $_POST['carencia_especialidade']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
//                $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            $this->db->where('forma_pagamento_id', $forma_pagamento_id);
            $this->db->update('tb_forma_pagamento');

            return $forma_pagamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_pagamento_id) {

        if ($forma_pagamento_id != 0) {
            $this->db->select('forma_pagamento_id,
                               nome,
                               valor1, 
                               valor5, 
                               valor6, 
                               valor10, 
                               valor11, 
                               valor12,
                               valor23,
                               valor24,
                               comissao,
                               taxa_adesao,
                               consulta_avulsa,
                               comissao_vendedor_mensal,
                               comissao_vendedor,
                               comissao_gerente_mensal,
                               comissao_gerente,
                               comissao_seguradora,
                               comissao_vendedor_externo_mensal,
                               comissao_vendedor_externo,
                               comissao_vendedor_pj,
                               comissao_vendedor_pj_mensal,
                               carencia_exame_mensal,
                               carencia_consulta_mensal,
                               carencia_especialidade_mensal,
                               carencia_exame,
                               valor_carteira,
                               valor_carteira_titular,
                               multa_atraso, 
                               valor_adesao, 
                               juros, 
                               carencia_consulta, 
                               consulta_coop, 
                               conta_id, 
                               carencia_especialidade, 
                               valoradcional,
                               parcelas,
                               qtd_dias,
                               nome_impressao');
            $this->db->from('tb_forma_pagamento');
            $this->db->where("forma_pagamento_id", $forma_pagamento_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_pagamento_id = $forma_pagamento_id;
            $this->_nome = $return[0]->nome;
            $this->_taxa_adesao = $return[0]->taxa_adesao;
            $this->_consulta_avulsa = $return[0]->consulta_avulsa;
            $this->_consulta_coop = $return[0]->consulta_coop;
            $this->_multa_atraso = $return[0]->multa_atraso;
            $this->_juros = $return[0]->juros;
            $this->_valor_adesao = $return[0]->valor_adesao;
            $this->_carencia_exame = $return[0]->carencia_exame;
            $this->_carencia_consulta = $return[0]->carencia_consulta;
            $this->_carencia_especialidade = $return[0]->carencia_especialidade;
            $this->_carencia_exame_mensal = $return[0]->carencia_exame_mensal;
            $this->_carencia_consulta_mensal = $return[0]->carencia_consulta_mensal;
            $this->_comissao_vendedor_externo_mensal = $return[0]->comissao_vendedor_externo_mensal;
            $this->_comissao_vendedor_externo = $return[0]->comissao_vendedor_externo;
            $this->_comissao_vendedor_pj = $return[0]->comissao_vendedor_pj;
            $this->_comissao_vendedor_pj_mensal = $return[0]->comissao_vendedor_pj_mensal;
            $this->_carencia_especialidade_mensal = $return[0]->carencia_especialidade_mensal;
            $this->_conta_id = $return[0]->conta_id;
            $this->_valor1 = $return[0]->valor1;
            $this->_valor5 = $return[0]->valor5;
            $this->_valor6 = $return[0]->valor6;
            $this->_valor10 = $return[0]->valor10;
            $this->_valor11 = $return[0]->valor11;
            $this->_valor12 = $return[0]->valor12;
            $this->_valor23 = $return[0]->valor23;
            $this->_valor24 = $return[0]->valor24;
            $this->_valor_carteira = $return[0]->valor_carteira;
            $this->_valor_carteira_titular = $return[0]->valor_carteira_titular;
            $this->_valoradcional = $return[0]->valoradcional;
            $this->_parcelas = $return[0]->parcelas;
            $this->_comissao = $return[0]->comissao;
            $this->_comissao_vendedor_mensal = $return[0]->comissao_vendedor_mensal;
            $this->_comissao_vendedor = $return[0]->comissao_vendedor;
            $this->_comissao_gerente_mensal = $return[0]->comissao_gerente_mensal;
            $this->_comissao_gerente = $return[0]->comissao_gerente;
            $this->_comissao_seguradora = $return[0]->comissao_seguradora;
            $this->_qtd_dias = $return[0]->qtd_dias;
            $this->_nome_impressao = $return[0]->nome_impressao;
        } else {
            $this->_forma_pagamento_id = null;
        }
    }

    function listarformapagamentos() {
        $this->db->select('forma_rendimento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_rendimento');
        $this->db->where('ativo', 'true');

        return $this->db->get()->result();
    }

    function gravarprocedimentoplano() {
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');
        $this->db->set('procedimento_convenio_id', $_POST['txtProcedimento']);
        $this->db->set('quantidade', $_POST['qtd']);
        $this->db->set('tempo', $_POST['tempo']);
        $this->db->set('operador_cadastro', $operador);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('formapagamento_id', $_POST['formapagamento_id']);
        $this->db->insert('tb_procedimentos_plano');
    }

    function listarprocedimentosdoplano($formapagamento_id) {
        $this->db->select('fp.nome as forma_pagamento,pt.nome as procedimento,pp.quantidade,pp.tempo,pp.procedimentos_plano_id');
        $this->db->from('tb_procedimentos_plano pp');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pp.formapagamento_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pp.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pp.formapagamento_id', $formapagamento_id);
        $this->db->where('pp.ativo','t');

        return $this->db->get()->result();
    }

    function excluirprocedimentoplano($procedimentos_plano_id) {
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');
        $this->db->set('operador_atualizacao', $operador);
        $this->db->set('data_atualizacao', $horario);
          $this->db->set('ativo','f');
        $this->db->where('procedimentos_plano_id', $procedimentos_plano_id);
        $this->db->update('tb_procedimentos_plano');
    }

}

?>
