<?php

class inicio_model extends Model {


    function listartodosplanos($plano_id = 0){
        $this->db->select("forma_pagamento_id, nome, nome_impressao, valor1, valor5, 
        valor6, valor10, valor11, valor12, valor23, valor24, valor_carteira_titular, valor_carteira, 
        valor_adesao, valoradcional, parcelas, (valor_adesao + valor_carteira_titular) as valortotal", false);
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->where('valor_adesao >', 0);
        $this->db->orderby('nome_impressao');
        if($plano_id > 0){
            $this->db->where('forma_pagamento_id', $plano_id); 
        }
        return $this->db->get()->result();
    }

    function cadastrarpaciente(){

        $this->db->select('municipio_id');
        $this->db->from('tb_municipio');
        $this->db->where('estado', $this->session->userdata('estado_titular'));
        $this->db->where('nome', $this->session->userdata('cidade_titular'));
        $cod = $this->db->get()->result();

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        // $operador_id = $this->session->userdata('operador_id');

        $this->db->set('nome', $this->session->userdata('nome_titular'));
        $this->db->set('cns', $this->session->userdata('email_titular'));
        $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $this->session->userdata('cpf_titular'))));
        $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $this->session->userdata('nascimento_titular')))));
        $this->db->set('sexo', $this->session->userdata('sexo_titular'));
        $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $this->session->userdata('celular_titular')))));

        $this->db->set('cep', $this->session->userdata('cep_titular'));
        $this->db->set('logradouro', $this->session->userdata('logradouro_titular'));
        $this->db->set('numero', $this->session->userdata('numero_titular'));
        $this->db->set('bairro', $this->session->userdata('bairro_titular'));
        $this->db->set('complemento', $this->session->userdata('complemento_titular'));
        
        $this->db->set('municipio_id', $cod[0]->municipio_id);
        $this->db->set('convenio_id', $this->session->userdata('plano_id'));

        $this->db->set('empresa_id', null);
        $this->db->set('assinou_contrato', 'f');
        $this->db->set('situacao', 'Titular');
        $this->db->set('data_cadastro', $data);
        $this->db->set('operador_cadastro', 0);
        $this->db->insert('tb_paciente');

        $paciente_id = $this->db->insert_id();

        $this->db->select('empresa_id');
        $this->db->from('tb_empresa');
        $empresa = $this->db->get()->result();

            $this->db->set('nao_renovar', 'f');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('plano_id', $this->session->userdata('plano_id'));
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', 0);
            $this->db->set('empresa_id',$empresa[0]->empresa_id);
            $this->db->insert('tb_paciente_contrato');


        return $paciente_id;
    }

    function completarcontrato($paciente_id){
        $horario = date("Y-m-d H:i:s");


        $this->db->select('*');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $this->session->userdata('plano_id'));
        $plano_contrato = $this->db->get()->result();


        $this->db->select('paciente_contrato_id, pc.plano_id, fp.taxa_adesao, fp.valor_adesao');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('pc.ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

        $paciente_contrato_id = $return[0]->paciente_contrato_id;

        if($this->session->userdata('forma_mes') == 24){
            $ajuste = $plano_contrato[0]->valor24;
        }else if($this->session->userdata('forma_mes') == 23){
            $ajuste = $plano_contrato[0]->valor23;
        }else if($this->session->userdata('forma_mes') == 12){
            $ajuste = $plano_contrato[0]->valor12;
        }else if($this->session->userdata('forma_mes') == 11){
            $ajuste = $plano_contrato[0]->valor11;
        }else if($this->session->userdata('forma_mes') == 10){
            $ajuste = $plano_contrato[0]->valor10;
        }else if($this->session->userdata('forma_mes') == 5){
            $ajuste = $plano_contrato[0]->valor5;
        }else if($this->session->userdata('forma_mes') == 1){
            $ajuste = $plano_contrato[0]->valor1;
        }

        $parcelas = (int) $this->session->userdata('forma_mes');

        $parcela_ajust = $parcelas . " x " . $ajuste;
        $this->db->set('parcelas', $parcela_ajust);
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->update('tb_paciente_contrato');


        $mes = 1;
        $dia = $_POST['vencimento'];
        if ((int) $_POST['vencimento'] < 10) {
            $dia = str_replace('0', '', $dia);
            $dia = "0" . $dia;
        }

        $data_post = date('Y-m-d');
        $data_adesao = date('Y-m-d');

        $data_receber = date("Y-m-$dia", strtotime($data_post));
        if (date("d", strtotime($data_receber)) == '31') {
            $data_receber = date("Y-m-30", strtotime($data_receber));
        }
        $mes_atual = date("m");
        $ano_atual = date("Y");
        if (date("Y", strtotime($data_receber)) < '2000' && date("m", strtotime($data_receber)) == '12') {
            $data_receber = date("$ano_atual-$mes_atual-d", strtotime($data_receber));
        }


        if ($data_receber < $data_post) {
            if (date("d", strtotime($data_receber)) == '30' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-2 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                // if ((int) $_POST['pularmes'] > 0) {
                //     $quantidade_meses = (int) $_POST['pularmes'];
                //     $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                // }
                $b = 2;
            } elseif (date("d", strtotime($data_receber)) == '29' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-1 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                // if ((int) $_POST['pularmes'] > 0) {
                //     $quantidade_meses = (int) $_POST['pularmes'];
                //     $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                // }
                $b = 1;
            } else {
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                // if ((int) @$_POST['pularmes'] > 0) {
                //     $quantidade_meses = (int) $_POST['pularmes'];
                //     $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                // }
                $b = 0;
            }
        } else {
            // if ((int) $_POST['pularmes'] > 0) {
            //     $quantidade_meses = (int) $_POST['pularmes'];
            //     $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
            // }
        }

        $this->db->set('razao_social', $this->session->userdata('nome_titular'));
        $this->db->set('cep', $this->session->userdata('cep_titular'));
        $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $this->session->userdata('cpf_titular'))));
        $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $this->session->userdata('celular_titular')))));
        $this->db->set('logradouro', $this->session->userdata('logradouro_titular'));
        $this->db->set('numero', $this->session->userdata('numero_titular'));
        $this->db->set('bairro', $this->session->userdata('bairro_titular'));
        $this->db->set('complemento', $this->session->userdata('complemento_titular'));
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 0);
        $this->db->insert('tb_financeiro_credor_devedor');
        $financeiro_credor_devedor_id = $this->db->insert_id();


        if ($paciente_id != "") {
            $this->db->set('credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');
        }


        if ($return[0]->taxa_adesao == 't') {
            $adesao_post = $plano_contrato[0]->valor_adesao;
            $this->db->set('adesao_digitada', $data_adesao);
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
            $this->db->set('parcela', 0);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->set('data', $data_adesao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', 0);
            $this->db->insert('tb_paciente_contrato_parcelas');
        }


        for ($i = 1; $i <= $parcelas; $i++) {

            $this->db->set('adesao_digitada', $data_adesao);
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
            $this->db->set('operador_cadastro', 0);
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
                    $this->db->set('operador_cadastro', 0);
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
                    $this->db->set('operador_cadastro', 0);
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

        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('paciente_contrato_id', $paciente_contrato_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 0);
        $this->db->insert('tb_paciente_contrato_dependente');


        $this->db->select('');
        $this->db->from('tb_paciente_contrato_parcelas');
        $this->db->where('paciente_contrato_id',$paciente_contrato_id);
        $parcelas_criadas = $this->db->get()->result();
        
        if($return[0]->taxa_adesao == "t"){
            $parcelas = $parcelas + 1;
        }
        if(count($parcelas_criadas) == $parcelas){
             return $paciente_contrato_id;
        }else{
             $this->db->where('paciente_id',$paciente_id);
             $this->db->delete('tb_paciente');
            
             return -1;
            
        }

    }


    function auditoriacadastro($paciente, $acao){
      
        $horario = date("Y-m-d H:i:s");
        $hora = date("H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('acao', $acao); 
        if(isset($_POST)){
          $this->db->set('json', json_encode($_POST));
        }
        $this->db->set('paciente_id', $paciente);
        $this->db->set('operador_cadastro', 0);
        $this->db->set('data_cadastro', $horario);
        $this->db->insert('tb_auditoria_cadastro');

    }


    function gravarcartaoclienteiugu($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = 0;

            $this->db->select('cp.paciente_contrato_parcelas_id');
            $this->db->from('tb_paciente_contrato_parcelas cp');
            $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
            $this->db->where("cp.paciente_contrato_id", $contrato_id);
            $this->db->where("cpi.paciente_contrato_parcelas_id is null"); // Pega apenas os que ainda não estão no IUGU
            $this->db->where("cp.ativo", 't');
            $this->db->where("cp.excluido", 'f');
            $return = $this->db->get()->result();

            foreach ($return as $item) {
                $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                    SET data_cartao_iugu = data, data_cartao_cadastro = '$horario', operador_cartao_cadastro = $operador_id
                    WHERE paciente_contrato_parcelas_id = $item->paciente_contrato_parcelas_id;
                    --AND taxa_adesao = false;";

                $this->db->query($sql);
            }

            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('card_number', str_replace(" ", "", $_POST['numero_cartao']));
            $this->db->set('card_csv', $_POST['cvv']);
            $this->db->set('mes', substr($_POST['validade'], 0, 2));
            $this->db->set('ano', substr($_POST['validade'], 3,4));
            $this->db->set('first_name', $_POST['nome_cartao']);
            $this->db->set('last_name', NULL);

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_cartao_credito');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }


}