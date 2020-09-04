<?php

class login_model extends Model {
    /* Método construtor */

    function Login_model($servidor_id = null) {
        parent::Model();
    }

    function autenticarpacienteweb($usuario, $senha) {
        $horario = date("Y-m-d");
        // die;
        $this->db->select('p.paciente_id, p.nome, p.cpf, p.cns, fp.nome as plano');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.cns', $usuario);
        $this->db->where('p.senha_app', md5($senha));
        $this->db->where('p.ativo', 't');
        $this->db->orderby('pc.ativo desc');
        $return = $this->db->get()->result();

        if(count($return) == 0 && is_int($usuario)){
            // die;
            $this->db->select('pc.paciente_contrato_id, p.paciente_id, p.nome, p.cpf, fp.nome as plano');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
            $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
            $this->db->where('pc.paciente_id', $usuario);
            $this->db->where('p.ativo', 't');
            $this->db->where('pc.paciente_contrato_id', $senha);
            $this->db->orderby('pc.paciente_contrato_id desc');
            $return = $this->db->get()->result();
            
        }

        return $return;
    }


    function email_verificacao($usuario) {
        // $horario = date("Y-m-d");
        $this->db->select('p.paciente_id, p.nome, p.cpf, p.cns');
        $this->db->from('tb_paciente p');
        $this->db->where('p.cns', $usuario);
        $this->db->where('p.ativo', 't');
        $return = $this->db->get()->result();
        return $return;
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
        $this->db->select('o.financeiro_parceiro_id,o.razao_social');

        $this->db->from('tb_financeiro_parceiro o');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', md5($senha));

        $return = $this->db->get()->result();

        if (isset($return) && count($return) > 0) {

            $p = array(
                'autenticado'=> true,
                'autenticado_parceiro' => true,
                'financeiro_parceiro_id' => $return[0]->financeiro_parceiro_id,
                'login_parceiro' => $usuario,
                'parceiro' => $return[0]->razao_social
            );

            $this->session->set_userdata($p);
            return true;
        } else {
//            $this->session->sess_destroy();
            return false;
        }
    }

    
     function listarEmpresa(){
        
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.*');
        $this->db->from('tb_empresa e'); 
//        
        $this->db->where('e.empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }
    
    
     function aniversariantes() {
        $dia = date('d');
        $mes = date('m');
        $this->db->select('p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone,
                           p.cns');
        $this->db->from('tb_paciente p');
        $this->db->where('p.ativo', 't');
        $this->db->where("p.cns != ",'');
        $this->db->where("EXTRACT(DAY FROM p.nascimento) = $dia AND EXTRACT(MONTH FROM p.nascimento) = $mes");
        $return = $this->db->get();
        return $return->result();
    }
    
     function atualizandoaniversariantestabelaemail($aniversariantes) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('email_mensagem_aniversario');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->email_mensagem_aniversario; 
        $horario = date('Y-m-d');
       $i  = 0;
        foreach ($aniversariantes as $item) { 
                $this->db->set('paciente_id', $item->paciente_id); 
                $this->db->set('email', $item->cns);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'ANIVERSARIANTE');
                $this->db->set('data', $horario);
                $this->db->insert('tb_email');
                $i++;
 
        }
        return $i;
    }
    
     function verificaemail() {
        $horario = date("Y-m-d");
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_email_registro');
        $this->db->where('data_verificacao', $horario);
        $return = $this->db->get();
        return $return->result();
    }
    
    
      function atualizandoregistro($registro_email_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date('Y-m-d');
        $this->db->select('COUNT(*) as total');
        $this->db->from('tb_email');
        $this->db->where('registrado', 'f');
        $this->db->where('data', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();

        $periodo = date('m/Y');
        $total = ($retorno[0]->total != "") ? $retorno[0]->total : 0;
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('qtde', $total);
        $this->db->set('data_verificacao', $horario);
        $this->db->where('empresa_email_registro_id', $registro_email_id);
        $this->db->update('tb_empresa_email_registro');

        $this->db->set('registrado', 't');
        $this->db->where('data', $horario);
        $this->db->update('tb_email');
    }

     function criandoregistroemail() {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date('Y-m-d');
        $periodo = date('m/Y');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('data_verificacao', $horario);
        $this->db->insert('tb_empresa_email_registro');
        $registro_email = $this->db->insert_id();
        return $registro_email;
        
    }

    
      function listaremail() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("s.*");
        $this->db->from('tb_email s'); 
//        $this->db->where('e.razao_social IS NOT NULL');
        $this->db->where('s.mensagem !=', '');
        $this->db->where('s.enviado', 'f');
        $this->db->where('s.ativo', 't');
        $this->db->where('s.empresa_id', $empresa_id);
        $return = $this->db->get()->result_array();

        $this->db->set('enviado', 't');
        $this->db->where('enviado', 'f');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->update('tb_email');

        return $return;
    }
    
}

?>
