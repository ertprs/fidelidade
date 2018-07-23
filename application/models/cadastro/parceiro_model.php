<?php

class parceiro_model extends Model {

    var $_financeiro_parceiro_id = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_cadastros_parceiro_id = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_municipio_id = null;
    var $_cep = null;
    var $_cpf = null;

    function Parceiro_model($financeiro_parceiro_id = null) {
        parent::Model();
        if (isset($financeiro_parceiro_id)) {
            $this->instanciar($financeiro_parceiro_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('financeiro_parceiro_id,
                            razao_social,
                            endereco_ip,
                            cnpj,
                            cpf,
                            telefone');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('razao_social ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('cnpj ilike', $args['nome'] . "%");
            $this->db->orwhere('cpf ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listartipo() {
        $this->db->select('tipo_logradouro_id,
                            descricao');
        $this->db->from('tb_tipo_logradouro');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarparceiroendereco($financeiro_parceiro_id) {
        $this->db->select('endereco_ip, convenio_id, financeiro_parceiro_id');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("financeiro_parceiro_id", $financeiro_parceiro_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarparceiroenderecotodos($financeiro_parceiro_id = null) {
        $this->db->select('endereco_ip, convenio_id, financeiro_parceiro_id, razao_social');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("ativo", 't');
        if ($financeiro_parceiro_id != '') {
            $this->db->where("financeiro_parceiro_id", $financeiro_parceiro_id);
        }
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarparceiroenderecoconvenio($financeiro_parceiro_id) {
        $this->db->select('endereco_ip, convenio_id, financeiro_parceiro_id');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("convenio_id", $financeiro_parceiro_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($financeiro_parceiro_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_parceiro_id', $financeiro_parceiro_id);
        $this->db->update('tb_financeiro_parceiro');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $financeiro_parceiro_id = $_POST['txtcadastrosparceiroid'];
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cep', $_POST['txttipo_id']);
            $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['txtCPF'])));
            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ'])));
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['txttipo_id'] != '') {
                $this->db->set('tipo_logradouro_id', $_POST['txttipo_id']);
            }
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('fantasia', $_POST['txtfantasia']);
            $this->db->set('endereco_ip', $_POST['txtendereco_ip']);
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('convenio_id', $_POST['convenio_id']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            
            if ($_POST['txtcadastrosparceiroid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_parceiro');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $financeiro_parceiro_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('financeiro_parceiro_id', $financeiro_parceiro_id);
                $this->db->update('tb_financeiro_parceiro');
            }
            return $financeiro_parceiro_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($financeiro_parceiro_id) {

        if ($financeiro_parceiro_id != 0) {
            $this->db->select('financeiro_parceiro_id, 
                               razao_social,
                               cnpj,
                               cpf,
                               celular,
                               telefone,
                               f.tipo_logradouro_id,
                               logradouro,
                               fantasia,
                               convenio_id,
                               endereco_ip,
                               numero,
                               bairro,
                               complemento,
                               f.municipio_id,
                               c.nome,
                               c.estado,
                               cep');
            $this->db->from('tb_financeiro_parceiro f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->where("financeiro_parceiro_id", $financeiro_parceiro_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_financeiro_parceiro_id = $financeiro_parceiro_id;
            $this->_cnpj = $return[0]->cnpj;
            $this->_cpf = $return[0]->cpf;
            $this->_razao_social = $return[0]->razao_social;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
            $this->_tipo_logradouro_id = $return[0]->tipo_logradouro_id;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_fantasia = $return[0]->fantasia;
            $this->_endereco_ip = $return[0]->endereco_ip;
            $this->_convenio_id = $return[0]->convenio_id;
            $this->_bairro = $return[0]->bairro;
            $this->_complemento = $return[0]->complemento;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_nome = $return[0]->nome;
            $this->_estado = $return[0]->estado;
            $this->_cep = $return[0]->cep;
        } else {
            $this->_financeiro_parceiro_id = null;
        }
    }

}

?>
