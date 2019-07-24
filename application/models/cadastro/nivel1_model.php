<?php

class nivel1_model extends Model {

    var $_financeiro_classe_id = null;
    var $_descricao = null;
    var $_tipo_id = null;

    function Nivel1_model($financeiro_classe_id = null) {
        parent::Model();
        if (isset($financeiro_classe_id)) {
            $this->instanciar($financeiro_classe_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('n.nivel1_id,
                            n.descricao
                            ');
        $this->db->from('tb_nivel1 n');        
        $this->db->where('n.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('n.descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarclasse() {
        $this->db->select('financeiro_classe_id as classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function listarnivel1() {
        $this->db->select('nivel1_id,
                            descricao');
        $this->db->from('tb_nivel1');
        $this->db->where('ativo', 'true');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarclasse($classe_id) {
        $this->db->select('financeiro_classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('financeiro_classe_id', $classe_id);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarclasserelatorio($classe) {
        $this->db->select('financeiro_classe_id,
                            descricao');
        $this->db->from('tb_financeiro_classe');
        $this->db->where('descricao', $classe);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclasses($parametro) {
        $this->db->select(' financeiro_classe_id as classe_id,                           
                            descricao as classe');
        $this->db->from('tb_financeiro_classe ');
        $this->db->where("ativo", 't');
        $this->db->where('tipo_id', $parametro);
        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclassessaida($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.tipo_entradas_saida_id', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompleteclassessaidadescricao($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }
    function listarautocompleteclassessaidadescricaotodos() {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
//        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteclasse($parametro) {
        $this->db->select(' c.financeiro_classe_id as classe_id,                           
                            c.descricao as classe');
        $this->db->from('tb_financeiro_classe c');
        $this->db->join('tb_tipo_entradas_saida t', 't.tipo_entradas_saida_id = c.tipo_id');
        $this->db->where("c.ativo", 't');
        $this->db->where('t.descricao', $parametro);
        $this->db->orderby("c.descricao");
//        $this->db->orderby("descricao");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($nivel1) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('nivel1_id', $nivel1);
                $this->db->update('tb_nivel1');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $nivel1 = $_POST['txtcadastrosnivel1id'];
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosnivel1id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_nivel1');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $nivel1 = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_tipo_id = $_POST['txtcadastrosnivel1id'];
                $this->db->where('nivel1_id', $nivel1);
                $this->db->update('tb_nivel1');
            }
            return $nivel1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($nivel1_id) {

        if ($nivel1_id != 0) {
            $this->db->select('nivel1_id, descricao');
            $this->db->from('tb_nivel1');
            $this->db->where("nivel1_id", $nivel1_id);
            $query = $this->db->get();
            $return = $query->result();            
            $this->_descricao = $return[0]->descricao;
            $this->_nivel1_id = $nivel1_id;
        } else {
            $this->_nivel1_id = null;
        }
    }

}
