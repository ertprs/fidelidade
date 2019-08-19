<?php

class empresa_model extends Model {

    var $_empresa_id = null;
    var $_nome = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_municipio_id = null;
    var $_cep = null;
    var $_cnes = null;
    var $_cadastro = null;
    var $_banco = null;
    var $_alterar_contrato = null;
    var $_confirm_outra_data = null;
    var $_financeiro_maior_zero = null;
    var $_carteira_padao_1 = null;
    var $_carteira_padao_2 = null;
    var $_carteira_padao_3 = null;
    var $_carteira_padao_4 = null;
    var $_cadastro_empresa_flag = null;
    var $_excluir_entrada_saidas = null;
    var $_renovar_contrato_automatico = null;

    function Empresa_model($exame_empresa_id = null) {
        parent::Model();
        if (isset($exame_empresa_id)) {
            $this->instanciar($exame_empresa_id);
        }
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome,
                            razao_social,
                            cnpj');
        $this->db->from('tb_empresa');
//        $this->db->where('cadastroempresa is null'); 
        $this->db->where('empresa_id', $empresa_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarempresas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome, tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresa($empresa_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome, tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->where('exame_empresa_id', $empresa_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($exame_empresa_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_empresa_id', $exame_empresa_id);
        $this->db->update('tb_exame_empresa');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cep', $_POST['CEP']);
            $this->db->set('banco', $_POST['banco']);
            $this->db->set('cadastro', $_POST['cadastro']);
            $this->db->set('cnes', $_POST['txtCNES']);
            $this->db->set('codigo_convenio_banco', $_POST['codigo_convenio_banco']);
            if (@$_POST['tipo_carencia']) {
                $this->db->set('tipo_carencia', $_POST['tipo_carencia']);
            }

            if (isset($_POST['titular_flag'])) {
                $this->db->set('titular_flag', 't');
            } else {
                $this->db->set('titular_flag', 'f');
            }

            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ']))));
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            if ($_POST['modelo_carteira'] != '') {
                $this->db->set('modelo_carteira', $_POST['modelo_carteira']);
            }


            if (isset($_POST['confirm_outra_data'])) {
                $this->db->set('confirm_outra_data', 't');
            } else {
                $this->db->set('confirm_outra_data', 'f');
            }

            if (isset($_POST['alterar_contrato'])) {
                $this->db->set('alterar_contrato', 't');
            } else {
                $this->db->set('alterar_contrato', 'f');
            }

            if (isset($_POST['financeiro_maior_zero'])) {
                $this->db->set('financeiro_maior_zero', 't');
            } else {
                $this->db->set('financeiro_maior_zero', 'f');
            }

            if (isset($_POST['carteira_padao_1'])) {
                $this->db->set('carteira_padao_1', 't');
            } else {
                $this->db->set('carteira_padao_1', 'f');
            }


            if (isset($_POST['carteira_padao_2'])) {
                $this->db->set('carteira_padao_2', 't');
            } else {
                $this->db->set('carteira_padao_2', 'f');
            }

            if (isset($_POST['carteira_padao_3'])) {
                $this->db->set('carteira_padao_3', 't');
            } else {
                $this->db->set('carteira_padao_3', 'f');
            }

            if (isset($_POST['carteira_padao_4'])) {
                $this->db->set('carteira_padao_4', 't');
            } else {
                $this->db->set('carteira_padao_4', 'f');
            }
            if (isset($_POST['carteira_padao_5'])) {
                $this->db->set('carteira_padao_5', 't');
            } else {
                $this->db->set('carteira_padao_5', 'f');
            }

            if ($_POST['client_id'] != "") {
                $this->db->set('client_id', $_POST['client_id']);
            } else {
                $this->db->set('client_id', null);
            }

            if ($_POST['client_secret'] != "") {
                $this->db->set('client_secret', $_POST['client_secret']);
            } else {
                $this->db->set('client_secret', null);
            }


            $this->db->set('iugu_token', $_POST['iugu_token']);
            $this->db->set('email', $_POST['email']);

            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);

            if (isset($_POST['modificar_verificar'])) {
                $this->db->set('modificar_verificar', 't');
            } else {
                $this->db->set('modificar_verificar', 'f');
            }

            if (@$_POST['empresacadastro'] == 'sim') {
                $this->db->set('cadastroempresa', 't');
            } else {
                $this->db->set('cadastroempresa', null);
            }

            if (isset($_POST['cadastro_empresa_flag'])) {
                $this->db->set('cadastro_empresa_flag', 't');
            } else {
                $this->db->set('cadastro_empresa_flag', 'f');
            }


            if (isset($_POST['excluir_entrada_saida'])) {
                $this->db->set('excluir_entrada_saida', 't');
            } else {
                $this->db->set('excluir_entrada_saida', 'f');
            }

            if (isset($_POST['renovar_contrato_automatico'])) {
                $this->db->set('renovar_contrato_automatico', 't');
            } else {
                $this->db->set('renovar_contrato_automatico', 'f');
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtempresaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $empresa_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $empresa_id = $_POST['txtempresaid'];
                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa');
            }
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($empresa_id) {

        if ($empresa_id != 0) {
            $this->db->select('empresa_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               cep,
                               modelo_carteira,
                               logradouro,
                               numero,
                               iugu_token,
                               email,
                               cadastro,
                               titular_flag,
                               tipo_carencia,
                               bairro,
                               f.banco,
                               cnes,
                               codigo_convenio_banco,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep,
                               f.alterar_contrato,
                               f.confirm_outra_data,
                               f.financeiro_maior_zero,
                               f.carteira_padao_1,
                               f.carteira_padao_2,
                               f.cadastro_empresa_flag,
                               f.excluir_entrada_saida,
                               f.renovar_contrato_automatico,
                               f.carteira_padao_3,
                               f.carteira_padao_4,
                               f.client_id,
                               f.client_secret,
                               f.carteira_padao_5,
                               f.modificar_verificar');
            $this->db->from('tb_empresa f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->where("empresa_id", $empresa_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_empresa_id = $empresa_id;
            $this->_nome = $return[0]->nome;
            $this->_cnpj = $return[0]->cnpj;
            $this->_razao_social = $return[0]->razao_social;
            $this->_iugu_token = $return[0]->iugu_token;
            $this->_celular = $return[0]->celular;
            $this->_codigo_convenio_banco = $return[0]->codigo_convenio_banco;
            $this->_tipo_carencia = $return[0]->tipo_carencia;
            $this->_titular_flag = $return[0]->titular_flag;
            $this->_telefone = $return[0]->telefone;
            $this->_cep = $return[0]->cep;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_bairro = $return[0]->bairro;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_municipio = $return[0]->municipio;
            $this->_modelo_carteira = $return[0]->modelo_carteira;
            $this->_nome = $return[0]->nome;
            $this->_email = $return[0]->email;
            $this->_estado = $return[0]->estado;
            $this->_cep = $return[0]->cep;
            $this->_cnes = $return[0]->cnes;
            $this->_banco = $return[0]->banco;
            $this->_cadastro = $return[0]->cadastro;
            $this->_alterar_contrato = $return[0]->alterar_contrato;
            $this->_confirm_outra_data = $return[0]->confirm_outra_data;
            $this->_financeiro_maior_zero = $return[0]->financeiro_maior_zero;
            $this->_carteira_padao_1 = $return[0]->carteira_padao_1;
            $this->_carteira_padao_2 = $return[0]->carteira_padao_2;
            $this->_cadastro_empresa_flag = $return[0]->cadastro_empresa_flag;
            $this->_excluir_entrada_saida = $return[0]->excluir_entrada_saida;
            $this->_renovar_contrato_automatico = $return[0]->renovar_contrato_automatico;
            $this->_carteira_padao_3 = $return[0]->carteira_padao_3;
            $this->_carteira_padao_4 = $return[0]->carteira_padao_4;
            $this->_carteira_padao_5 = $return[0]->carteira_padao_5;
            $this->_client_id = $return[0]->client_id;
            $this->_client_secret = $return[0]->client_secret;
            $this->_modificar_verificar = $return[0]->modificar_verificar;
        } else {
            $this->_empresa_id = null;
        }
    }

    function listarpermissoes() {
        $this->db->select('');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
        return $this->db->get()->result();
    }

    function listarempresalogada() {

        $this->db->select('');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
        return $this->db->get()->result();
    }

    function listarempresacadatro($args = array()) {

        $this->db->select('e.*');
        $this->db->from('tb_empresa e');
        $this->db->where('cadastroempresa', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        $this->db->where('e.ativo', 't');

        return $this->db;
    }

    function listardadosempresacadastro($empresa_id = NULL) {

        $this->db->select('empresa_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               cep,
                               modelo_carteira,
                               logradouro,
                               numero,
                               iugu_token,
                               email,
                               cadastro,
                               tipo_carencia,
                               bairro,
                               f.banco,
                               cnes,
                               codigo_convenio_banco,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep,
                               f.alterar_contrato,
                               f.confirm_outra_data,
                               f.financeiro_maior_zero,
                               f.carteira_padao_1,
                               f.carteira_padao_2,
                               f.cadastro_empresa_flag');
        $this->db->from('tb_empresa f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        return $this->db->get()->result();
    }

    function listarempresasprocedimento() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');

        $return = $this->db->get();
        return $return->result();
    }
    
     function listarpermissoesaleatorio() {
        $this->db->select('');
        $this->db->from('tb_empresa');
//        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
        $this->db->limit(1);
        $this->db->where('ativo','t');
        return $this->db->get()->result();
    }

}

?>
