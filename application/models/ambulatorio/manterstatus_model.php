<?php

class manterstatus_model extends Model {

    var $_ambulatorio_cancelamento_id = null;
    var $_descricao = null;

    function Manterstatus_model($ambulatorio_cancelamento_id = null) {
        parent::Model();
        if (isset($ambulatorio_cancelamento_id)) {
            $this->instanciar($ambulatorio_cancelamento_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('status_id,
                            nome');
        $this->db->from('tb_status_parcela');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listartodos() {
        $this->db->select('status_id,
                            nome');
        $this->db->from('tb_status_parcela');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($status_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('status_id', $status_id);
        $this->db->update('tb_status_parcela');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $status_id = $_POST['status_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['status_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_status_parcela');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $status_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $status_id = $_POST['status_id'];
                $this->db->where('status_id', $status_id);
                $this->db->update('tb_status_parcela');
            }
            return $status_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($status_id) {

        if ($status_id != 0) {
            $this->db->select('status_id, nome');
            $this->db->from('tb_status_parcela');
            $this->db->where("status_id", $status_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_status_id = $status_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_status_id = null;
        }
    }

}

?>
