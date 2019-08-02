<?php

class login_model extends Model {
    /* Método construtor */

    function Login_model($servidor_id = null) {
        parent::Model();
    }

    function autenticar($usuario, $senha, $empresa) {
        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                p.nome as perfil,
                                a.modulo_id'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', md5($senha));
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();

        $this->db->select('empresa_id,
                            nome,
                            internacao,
                            cadastro
                            ');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa);
        $retorno = $this->db->get()->result();

        if (count($retorno) > 0) {
            $empresanome = $retorno[0]->nome;
            $internacao = $retorno[0]->internacao;
            $cadastro = $retorno[0]->cadastro;
        } else {
            $empresanome = "";
            $internacao = false;
            $cadastro = "";
        }

        if (isset($return) && count($return) > 0) {
            $modulo[] = null;
            foreach ($return as $value) {
                if (isset($value->modulo_id)) {
                    $modulo[] = $value->modulo_id;
                }
            }
            $p = array(
                'autenticado' => true,
                'operador_id' => $return[0]->operador_id,
                'login' => $usuario,
                'perfil_id' => $return[0]->perfil_id,
                'perfil' => $return[0]->perfil,
                'modulo' => $modulo,
                'internacao' => $internacao,
                'empresa_id' => $empresa,
                'cadastro' => $cadastro,
                'empresa' => $empresanome
            );
            $this->session->set_userdata($p);
            return true;
        } else {
            $this->session->sess_destroy();
            return false;
        }
    }

    function listar() {

        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $this->db->where('cadastroempresa', null);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function autenticarparceiro($usuario, $senha) {
        $this->db->select('o.financeiro_parceiro_id');

        $this->db->from('tb_financeiro_parceiro o');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', md5($senha));

        $return = $this->db->get()->result();

        if (isset($return) && count($return) > 0) {

            $p = array(
                'autenticado_parceiro' => true,
                'financeiro_parceiro_id' => $return[0]->financeiro_parceiro_id,
                'login_parceiro' => $usuario
            );

            $this->session->set_userdata($p);
            return true;
        } else {
//            $this->session->sess_destroy();
            return false;
        }
    }

    

}

?>
