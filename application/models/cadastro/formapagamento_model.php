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
    var $_valoradcional = null;
    var $_parcelas = null;
    var $_comissao = null;

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


            $parcelas = $_POST['parcelas'];
            if ($_POST['parcelas'] == "" || $_POST['parcelas'] == 0) {
                $parcelas = 1;
            }
//            var_dump($_POST); die;

            
            $this->db->set('valor1', str_replace(",", ".", str_replace(".", "", $_POST['valor1'])));
            $this->db->set('valor5', str_replace(",", ".", str_replace(".", "", $_POST['valor5'])));
            $this->db->set('valor6', str_replace(",", ".", str_replace(".", "", $_POST['valor6'])));
            $this->db->set('valor10', str_replace(",", ".", str_replace(".", "", $_POST['valor10'])));
            $this->db->set('valor12', str_replace(",", ".", str_replace(".", "", $_POST['valor12'])));

            $this->db->set('comissao', str_replace(",", ".", str_replace(".", "", $_POST['comissao'])));
            $this->db->set('comissao_vendedor_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor_mensal'])));
            $this->db->set('comissao_vendedor', str_replace(",", ".", str_replace(".", "", $_POST['comissao_vendedor'])));
            $this->db->set('comissao_gerente_mensal', str_replace(",", ".", str_replace(".", "", $_POST['comissao_gerente_mensal'])));
            $this->db->set('comissao_gerente', str_replace(",", ".", str_replace(".", "", $_POST['comissao_gerente'])));
            $this->db->set('comissao_seguradora', str_replace(",", ".", str_replace(".", "", $_POST['comissao_seguradora'])));

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
                               valor12,
                               comissao,
                               comissao_vendedor_mensal,
                               comissao_vendedor,
                               comissao_gerente_mensal,
                               comissao_gerente,
                               comissao_seguradora,
                               carencia_exame_mensal,
                               carencia_consulta_mensal,
                               carencia_especialidade_mensal,
                               carencia_exame, 
                               carencia_consulta, 
                               conta_id, 
                               carencia_especialidade, 
                               valoradcional,
                               parcelas');
            $this->db->from('tb_forma_pagamento');
            $this->db->where("forma_pagamento_id", $forma_pagamento_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_pagamento_id = $forma_pagamento_id;
            $this->_nome = $return[0]->nome;
            $this->_carencia_exame = $return[0]->carencia_exame;
            $this->_carencia_consulta = $return[0]->carencia_consulta;
            $this->_carencia_especialidade = $return[0]->carencia_especialidade;
            $this->_carencia_exame_mensal = $return[0]->carencia_exame_mensal;
            $this->_carencia_consulta_mensal = $return[0]->carencia_consulta_mensal;
            $this->_carencia_especialidade_mensal = $return[0]->carencia_especialidade_mensal;
            $this->_conta_id = $return[0]->conta_id;
            $this->_valor1 = $return[0]->valor1;
            $this->_valor5 = $return[0]->valor5;
            $this->_valor6 = $return[0]->valor6;
            $this->_valor10 = $return[0]->valor10;
            $this->_valor12 = $return[0]->valor12;
            $this->_valoradcional = $return[0]->valoradcional;
            $this->_parcelas = $return[0]->parcelas;
            $this->_comissao = $return[0]->comissao;
            $this->_comissao_vendedor_mensal = $return[0]->comissao_vendedor_mensal;
            $this->_comissao_vendedor = $return[0]->comissao_vendedor;
            $this->_comissao_gerente_mensal = $return[0]->comissao_gerente_mensal;
            $this->_comissao_gerente = $return[0]->comissao_gerente;
            $this->_comissao_seguradora = $return[0]->comissao_seguradora;
        } else {
            $this->_forma_pagamento_id = null;
        }
    }

}

?>
