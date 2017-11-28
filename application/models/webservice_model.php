<?php

class webservice_model extends Model {

    function Webservice_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
    }

    function listardadosempresa() {
        $this->db->select('e.razao_social,
                            e.celular,
                            e.telefone,
                            e.bairro,
                            e.logradouro,
                            e.numero,
                           m.nome as municipio, 
                           m.estado');
        $this->db->from('tb_empresa e');
        $this->db->where('e.ativo', 'true');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');;
        $return = $this->db->get();
        return $return->result();
    }

    function listarlocaisatendimento() {
        $this->db->select('p.*, m.nome as municipio, m.estado');
        $this->db->from('tb_parceiro p');
        $this->db->where('p.ativo', 'true');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function autenticarusuario($usuario, $senha) {
        $this->db->select('p.usuario, p.paciente_id');
        $this->db->from('tb_paciente p');
        $this->db->where('p.usuario', $usuario);
        $this->db->where('p.senha', md5($senha));
        $this->db->where('p.ativo', 'true');
        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }
}

?>
