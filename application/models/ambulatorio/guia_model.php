<?php

class guia_model extends Model {

    var $_ambulatorio_guia_id = null;
    var $_nome = null;

    function guia_model($ambulatorio_guia_id = null) {
        parent::Model();
        if (isset($ambulatorio_guia_id)) {
            $this->instanciar($ambulatorio_guia_id);
        }
    }

    function listarpaciente($paciente_id) {

        $this->db->select('nome,
                            telefone
                            ');
        $this->db->from('tb_paciente');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacienteAPI($paciente_contrato_id) {

        $this->db->select('
                            pcp.ativo as pagamento_pendente,
                            pcp.data,
                            pcp.valor,
                            pcpi.url as link_boleto');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente_contrato_parcelas_iugu pcpi', 'pcpi.paciente_contrato_parcelas_id = pcp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_contrato_id);
        // $this->db->where("pcp.ativo", 'f');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientecpf($cpf = NULL, $paciente_id = NULL, $nome = NULL) {
        try {
            if ($cpf == "" && $paciente_id == "" && $nome == "") {
                
            } else {

                $this->db->select('pc.paciente_contrato_id,tp.tipo_logradouro_id as codigo_logradouro,co.nome as nome_convenio, pc.plano_id, co.convenio_id as convenio,tp.descricao,p.*,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge');
                $this->db->from('tb_paciente p');
                $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
                $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
                $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
                $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');

                if ($cpf != "") {
                    $this->db->where("cpf", $cpf);
                } elseif ($nome != "") {
                    $this->db->where('p.nome ilike', "%" . $nome . "%");
                } else {
                    $this->db->where("p.paciente_id", $paciente_id);
                }

                $this->db->where("p.ativo", 't');
                $this->db->where("pc.ativo", 't');
                $return = $this->db->get()->result();



                return $return;
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarpacientepacienteidantigo($paciente_antigo_id) {

        $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,co.nome as nome_convenio, pc.plano_id, co.convenio_id as convenio,tp.descricao,p.*,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->where("p.paciente_id", $paciente_antigo_id);
        // $this->db->where("p.ativo", 't');
        $return = $this->db->get()->result();
        return $return;
    }

    function listarpacientes($parametro = null) {

        $this->db->select('paciente_id,
                            nome');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 't');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($paciente_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->where("ag.paciente_id", $paciente_id);
        $this->db->orderby('ag.ambulatorio_guia_id', 'desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientecarteira($paciente_id) {

        $this->db->select('p.paciente_id,
                            p.nascimento,
                            p.situacao,
                            p.nome ');
        $this->db->from('tb_paciente p');
        $this->db->where("p.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioinadimplentes() {
        
        $this->db->select('p.nome,
                            p.logradouro,
                            p.numero,
                            p.complemento,
                            p.bairro,
                            p.celular,
                            p.telefone,
                            p.paciente_id,
                            pcp.data,
                            pcp.valor,
                            pcp.manual,
                            pcp.data_cartao_iugu,
                            pcp.debito,
                            pcp.empresa_iugu,
                            p.paciente_id,
                            p.cpf,
                            fr.nome as forma_pagamento,
                            pc.plano_id');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_rendimento fr','fr.forma_rendimento_id = p.forma_rendimento_id','left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.ativo', 'true');
        $this->db->where('pcp.excluido', 'false');
         
        if (@$_POST['bairro'] != '') {
            $this->db->where('p.bairro', @$_POST['bairro']);
        }
        
//        if ($_POST['forma_pagamento'] == 'manual') {
//            $this->db->where('pcp.manual', 't');
//        } else if ($_POST['forma_pagamento'] == 'cartao') {
//            $this->db->where('pcp.data_cartao_iugu is not null');
//        } else if ($_POST['forma_pagamento'] == 'debito') {
//            $this->db->where('pcp.debito', 't');
//        } else if ($_POST['forma_pagamento'] == 'boleto_emp') {
//            $this->db->where('pcp.empresa_iugu', 't');
//        } else if ($_POST['forma_pagamento'] == 'boleto') {
//            $this->db->where("(pcp.manual is null or  pcp.manual = 'f'  )");
//            $this->db->where('pcp.data_cartao_iugu is null');
//            $this->db->where("(pcp.debito is null or  pcp.debito = 'f'  )");
//            $this->db->where("(pcp.empresa_iugu is null or  pcp.empresa_iugu = 'f'  )");
//        } else {
//            
//        }
        
         if ($_POST['forma_pagamento'] != ""){
             $this->db->where('p.forma_rendimento_id',$_POST['forma_pagamento']); 
         }
         if ($_POST['plano_id'] != ""){
             $this->db->where('pc.plano_id',$_POST['plano_id']); 
         } 
        $this->db->where('pcp.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('pcp.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['ordenar'] == 'order_nome') {
            $this->db->orderby('p.nome');
            $this->db->orderby('p.bairro');
            $this->db->orderby('pcp.data');
        }

        if ($_POST['ordenar'] == 'order_bairro') {
            $this->db->orderby('p.bairro');
            $this->db->orderby('p.nome');
            $this->db->orderby('pcp.data');
        }



//        $this->db->group_by('p.paciente_id');
//        $this->db->order_by('p.paciente_id', 'desc');



        $return = $this->db->get();
        return $return->result();
    }

    function gerarsicov() {
        $this->db->select('p.nome,
                            p.logradouro,
                            p.numero,
                            p.complemento,
                            p.bairro,
                            p.celular,
                            p.telefone,
                            p.cpf,
                            p.paciente_id,
                            p.telefone,
                            pcd.conta_agencia,
                            pcd.codigo_operacao,
                            pcd.conta_numero,
                            pcd.conta_digito,
                            pcp.paciente_contrato_parcelas_id,
                            pcp.data,
                            pcp.valor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_conta_debito pcd', 'p.paciente_id = pcd.paciente_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.ativo', 'true'); //Não pago
        $this->db->where('pcp.excluido', 'false');
        $this->db->where('pcd.ativo', 'true');
        $this->db->where('pcp.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('pcp.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioadimplentes() {
        $this->db->select('p.nome,
                            p.logradouro,
                            p.numero,
                            p.complemento,
                            p.bairro,
                            p.celular,
                            p.telefone,
                            pcp.data,
                            pcp.valor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.ativo', 'false');
        $this->db->where('pcp.excluido', 'false');
        if (@$_POST['bairro'] != '') {
            $this->db->where('p.bairro', @$_POST['bairro']);
        }
        
        
//        if ($_POST['forma_pagamento'] == 'manual') {
//            $this->db->where('pcp.manual', 't');
//        } else if ($_POST['forma_pagamento'] == 'cartao') {
//            $this->db->where('pcp.data_cartao_iugu is not null');
//        } else if ($_POST['forma_pagamento'] == 'debito') {
//            $this->db->where('pcp.debito', 't');
//        } else if ($_POST['forma_pagamento'] == 'boleto_emp') {
//            $this->db->where('pcp.empresa_iugu', 't');
//        } else if ($_POST['forma_pagamento'] == 'boleto') {
//            $this->db->where("(pcp.manual is null or  pcp.manual = 'f'  )");
//            $this->db->where('pcp.data_cartao_iugu is null');
//            $this->db->where("(pcp.debito is null or  pcp.debito = 'f'  )");
//            $this->db->where("(pcp.empresa_iugu is null or  pcp.empresa_iugu = 'f'  )");
//        } else {
//            
//        }
        
        
        if ($_POST['forma_pagamento'] != ""){
            $this->db->where('p.forma_rendimento_id',$_POST['forma_pagamento']); 
        }
        if ($_POST['plano_id'] != ""){
            $this->db->where('pc.plano_id',$_POST['plano_id']); 
        }   
        if ($_POST['ordenar'] == 'order_nome') {
            $this->db->orderby('p.nome');
            $this->db->orderby('p.bairro');
            $this->db->orderby('pcp.data');
        }

        if ($_POST['ordenar'] == 'order_bairro') {
            $this->db->orderby('p.bairro');
            $this->db->orderby('p.nome');
            $this->db->orderby('pcp.data');
        }
 
        
        $this->db->where('pcp.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('pcp.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocontratosinativos() {
        $this->db->select('p.nome,
                            pc.paciente_contrato_id,
                            fp.nome as plano,
                            o.nome as operador,
                            op.nome as vendedor,
                            pc.data_atualizacao,
                            pc.data_cadastro,
                            p.telefone,
                            p.celular');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pc.operador_atualizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = p.vendedor', 'left');
        $this->db->where('p.ativo', 'true');
        if ($_POST['tipobusca'] == "I") {
            $this->db->where('pc.ativo', 'f');
        }
        if ($_POST['tipobusca'] == "A") {
            $this->db->where('pc.ativo', 't');
        }
//        if ($_POST['plano'] > 0) {
//            $this->db->where('pc.plano_id', $_POST['plano']);
//        }

        if (count(@$_POST['plano']) != 0) {
            foreach (@$_POST['plano'] as $value) {
                if ($value == 0) {
                    
                } else {
                    if (count(@$_POST['plano']) != 0) {
                        $plano = $_POST['plano'];
                        $this->db->where_in('pc.plano_id', $plano);
                    }
                }
            }
        }

//        if ($_POST['vencedor'] > 0) {
//            $this->db->where('p.vendedor', $_POST['vencedor']);
//        }

        if (count(@$_POST['vencedor']) != 0) {
            foreach (@$_POST['vencedor'] as $value) {
                if ($value == 0) {
                    
                } else {
                    if (count(@$_POST['vencedor']) != 0) {
                        $vencedor = $_POST['vencedor'];
                        $this->db->where_in('p.vendedor', $vencedor);
                    }
                }
            }
        }
        
        if (!empty($_POST['forma_rendimento'])) {
            $this->db->where('pc.forma_rendimento_id',$_POST['forma_rendimento']);
        }
 
        if ($_POST['tipodata'] == "E" && $_POST['tipobusca'] == "I") {
            $this->db->where('pc.data_atualizacao >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
            $this->db->where('pc.data_atualizacao <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        } else {
            $this->db->where('pc.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
            $this->db->where('pc.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        }
        $this->db->orderby('p.nome');
        $this->db->orderby('pc.paciente_contrato_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriotitularesexcluidos() {
        $this->db->select('p.nome,
                           p.cpf,
                           p.sexo,
                           p.celular,
                           p.telefone,
                           p.nascimento,
                           p.data_exclusao,
                           o.nome as operador');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_operador o', 'o.operador_id = p.operador_exclusao', 'left');
        $this->db->where('p.ativo', 'false');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatoriotitularsemcontrato(){

        // SELECT * FROM teste WHERE teste_id NOT IN(select teste_id from nova);
        $sql = "SELECT pc.paciente_id, p.nome as paciente, o.nome as operador_cadastro, v.nome as vendedor, pc.data_atualizacao FROM ponto.tb_paciente_contrato pc
        LEFT JOIN ponto.tb_paciente p ON pc.paciente_id = p.paciente_id
        LEFT JOIN ponto.tb_operador o ON o.operador_id = pc.operador_cadastro
        LEFT JOIN ponto.tb_operador v ON v.operador_id = pc.vendedor_id
                WHERE pc.ativo = false
                AND pc.paciente_id is not null 
                AND pc.paciente_id NOT IN(SELECT paciente_id FROM ponto.tb_paciente_contrato pcc WHERE pcc.ativo = true and pcc.paciente_id is not null)
                ORDER BY pc.data_atualizacao desc";

        return $this->db->query($sql)->result(); 
    }


    function relatoriovendedores() {
        $this->db->select('o.operador_id, o.nome');
        $this->db->from('tb_operador o');
        $this->db->where('o.ativo', 'true');
        $this->db->where('o.perfil_id', '4');
//        $this->db->where('pc.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
//        $this->db->where('pc.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
//        $this->db->groupby('pc.paciente_contrato_id,p2.nome,p.nome,fp.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

//    function relatoriovendedores() {
//        $this->db->select('o.operador_id, o.nome');
//        $this->db->from('tb_operador o');
//        $this->db->where('o.ativo', 'true');
//        $this->db->where('o.perfil_id', '4');
////        $this->db->where('pc.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
////        $this->db->where('pc.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
////        $this->db->groupby('pc.paciente_contrato_id,p2.nome,p.nome,fp.nome');
//        $this->db->orderby('o.nome');
//        $return = $this->db->get();
//        return $return->result();
//    }

    function relatoriodependentes() {
        $this->db->select('p.nome,
                           p2.situacao,
                           p2.nome as dependente,
                           pc.paciente_contrato_id,
                           fp.nome as plano');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p2', 'p2.paciente_id = pcd.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('p2.ativo', 'true');
        $this->db->where('p2.situacao !=', 'Titular');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcd.ativo', 'true');
//        $this->db->where('pc.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
//        $this->db->where('pc.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
//        $this->db->groupby('pc.paciente_contrato_id,p2.nome,p.nome,fp.nome');
        $this->db->orderby('pc.paciente_contrato_id,p2.nome,p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocadastro() {
        $this->db->select('p.nome,
                            p.paciente_id,
                            p.cpf,
                            p.nascimento,
                            p.logradouro,
                            p.situacao,
                            p.numero,
                            fp.nome as convenio,
                            p.data_cadastro,
                            p.convenio_id,
                            m.nome as municipio,
                            p.rg,
                            p.telefone,
                            p.celular');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = p.convenio_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('p.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('p.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocadastroparceiro() {
        $this->db->select('p.nome,
                            p.paciente_id,
                            p.cpf,
                            p.nascimento,
                            p.logradouro,
                            p.situacao,
                            p.numero,
                            fp.nome as convenio,
                            p.data_cadastro,
                            p.convenio_id,
                            m.nome as municipio,
                            p.rg');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = p.convenio_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('p.parceiro_id ', $_POST['parceiro_id']);
//        $this->db->where('p.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexames($paciente_id) {

        $this->db->select('pc.paciente_contrato_id,
                            fp.nome as plano,
                            p.situacao,
                            pc.ativo,
                            fp.nome as plano,
                            fp.valor_carteira as valor,
                            fp.valor_carteira_titular as valor_carteira_titular,
                            fp.conta_id,
                            pc.data_cadastro,
                            fp.forma_pagamento_id');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("pc.ativo_admin", 't');
        $this->db->orderby('pc.paciente_contrato_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcontratoativo($paciente_id) { 
        $this->db->select('pc.paciente_contrato_id,
                            fp.nome as plano,
                            pc.ativo,
                            cp.data,
                            fp.nome as plano,
                            pc.data_cadastro,
                            fp.qtd_dias,
                            pc.nao_renovar,
                            p.nome as paciente
                            ');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas cp', 'cp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("pc.ativo", 't');
        $this->db->orderby('cp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listartitular($paciente_id) {

        $this->db->select('p.paciente_id,
                            pc.paciente_contrato_id,
                            p.nome,
                            pcd.paciente_contrato_dependente_id');
        $this->db->from('tb_paciente_contrato_dependente pcd');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcd.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->where('pcd.ativo', 't');
        $this->db->where("pcd.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarparceirorelatorio() {
        $this->db->select('fantasia, financeiro_parceiro_id');
        $this->db->from('tb_financeiro_parceiro');
        $this->db->where("financeiro_parceiro_id", $_POST['parceiro_id']);
        $return = $this->db->get()->result();
        return $return[0]->fantasia;
    }

    function listarparcelas($paciente_contrato_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            pcp.parcela,
                            pcp.data,
                            pcp.taxa_adesao,
                            m.nome as municipio,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pcp.paciente_contrato_id", $paciente_contrato_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacoesContrato($paciente_contrato_id) {

        $this->db->select('pc.paciente_contrato_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            p.nascimento,
                            m.nome as municipio,
                            p.nome,
                            fp.nome as plano,
                            pc.data_cadastro,
                            p.cpf,
                            fp.qtd_dias,
                            p.rg,
                            p.empresa_id,
                            e.razao_social as empresa_cadastro,
                            fp.nome_impressao');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = p.empresa_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
        // $this->db->where("pc.ativo", 't');
        // $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacoesContratodepedente($depende_id){
        $this->db->select('paciente_contrato_id');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_id', $depende_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaobservacao($paciente_contrato_parcelas_id) {

        $this->db->select('pcp.paciente_contrato_id,
                            pcp.paciente_contrato_parcelas_id,
                            pcp.parcela,
                            pcp.observacao,
                            pcp.data,
                            pcp.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaauditoria($paciente_contrato_parcelas_id) {

        $this->db->select('pcp.paciente_contrato_id,
                            pcp.paciente_contrato_parcelas_id,
                            pcp.parcela,
                            o.nome as operador_cartao_cadastro,
                            o2.nome as operador_cartao_exclusao,
                            o3.nome as operador_cadastro,
                            o4.nome as operador_atualizacao,
                            pcp.data_cadastro,
                            pcp.data_atualizacao,
                            pcp.data_cartao_cadastro,
                            pcp.data_cartao_exclusao,
                            pcp.observacao,
                            pcp.data,
                            pcp.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_operador o', 'o.operador_id = pcp.operador_cartao_cadastro', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = pcp.operador_cartao_exclusao', 'left');
        $this->db->join('tb_operador o3', 'o3.operador_id = pcp.operador_cadastro', 'left');
        $this->db->join('tb_operador o4', 'o4.operador_id = pcp.operador_atualizacao', 'left');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaavulsaobservacao($consulta_avulsa_id) {

        $this->db->select('ca.observacao, ca.utilizada');
        $this->db->from('tb_consultas_avulsas ca');
        $this->db->where("ca.consultas_avulsas_id", $consulta_avulsa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarvoucherconsultaavulsa($consulta_avulsa_id) {

        $this->db->select('vc.data,
                            vc.horario,
                            vc.parceiro_id,
                               fp.logradouro,
                            fp.numero,
                            fp.bairro,
                            m.nome as municipio,
                            fp.razao_social as parceiro,
                            vc.data_cadastro,
                            vc.gratuito');
        $this->db->from('tb_voucher_consulta vc');
        $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = vc.parceiro_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = fp.municipio_id', 'left');
        $this->db->where("vc.ativo", 't');
        $this->db->where("vc.consulta_avulsa_id", $consulta_avulsa_id);
        $this->db->orderby("vc.data_cadastro desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaalterardata($paciente_contrato_parcelas_id) {

        $this->db->select('pcp.paciente_contrato_id,
                            pcp.paciente_contrato_parcelas_id,
                            pcp.parcela,
                            pcp.data,
                            pcp.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listaralterardataconsultaavulsa($consultas_avulsas_id) {

        $this->db->select('pcp.consultas_avulsas_id,
                            pcp.data,
                            pcp.data_cadastro');
        $this->db->from('tb_consultas_avulsas pcp');
        $this->db->where("pcp.consultas_avulsas_id", $consultas_avulsas_id);
//        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelareenviaremail($paciente_contrato_parcelas_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            pcpi.url,
                            pcp.data,
                            p.paciente_id,
                            p.cns');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato_parcelas_iugu pcpi', 'pcpi.paciente_contrato_parcelas_id = pcp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaconfirmarpagamento($paciente_contrato_parcelas_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            pcp.parcela,
                            pcp.data,
                            p.credor_devedor_id as financeiro_credor_devedor_id,
                            m.nome as municipio,
                            fcd.razao_social as credor,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            fp.conta_id,
                            pc.data_cadastro,
                            p.empresa_id,
                            pcp.financeiro_credor_devedor_id as financeiro_credor_devedor_id_dependente,
                            pcp.paciente_dependente_id,
                            pcp.taxa_adesao');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaconfirmarpagamentogatilhoiugu($invoice_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            pcp.parcela,
                            pcp.data,
                            pcp.financeiro_credor_devedor_id,
                            m.nome as municipio,
                            fcd.razao_social as credor,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            fp.conta_id,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato_parcelas_iugu pcpi', 'pcpi.paciente_contrato_parcelas_id = pcp.paciente_contrato_parcelas_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pcpi.invoice_id", $invoice_id);
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaconfirmarpagamentoconsultaavulsa($paciente_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            p.consulta_avulsa,
                            pcp.parcela,
                            pcp.data,
                            pcp.financeiro_credor_devedor_id,
                            m.nome as municipio,
                            fcd.razao_social as credor,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            fp.conta_id,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_id);
        $this->db->where("pc.ativo", 't');
//        $this->db->where("pcp.ativo", 't');
        $this->db->where("pcp.financeiro_credor_devedor_id is not null");
        $this->db->orderby('pcp.parcela');
        // $this->db->limit(1);

        $return = $this->db->get();
        return $return->result();
    }

    function listardependentes($paciente_contrato_id) {

        $this->db->select('initcap(p.nome) as paciente,p.situacao,p.cpf, fp.nome as contrato');
        $this->db->from('tb_paciente_contrato_dependente pcd');
        $this->db->join('tb_paciente p', 'p.paciente_id = pcd.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcd.paciente_contrato_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pcd.paciente_contrato_id", $paciente_contrato_id);
        $this->db->orderby('p.situacao desc');
        $this->db->where('pcd.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacientedependente($paciente_id) {

        $this->db->select('pcd.paciente_id,pc.paciente_id as titular_id,pc.paciente_contrato_id');
        $this->db->from('tb_paciente_contrato_dependente pcd');
        $this->db->join('tb_paciente_contrato pc', 'pcd.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->where("pcd.paciente_id", $paciente_id);
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcd.ativo", 't');
//        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspaciente($paciente_contrato_id) {

        $this->db->select('
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_contrato_id);
        $this->db->where("pcp.ativo", 'f');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacientetotal($paciente_titular_id, $contrato_id = NULL, $dependente = NULL) {
        $data = date("Y-m-d");
        $this->db->select(' pcp.paciente_contrato_id,
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');


        if ($this->session->userdata('cadastro') == 2 && $dependente == true) {
            $this->db->where('pcp.paciente_dependente_id', $paciente_titular_id);
            $this->db->where('pc.paciente_contrato_id', $contrato_id);
        } else {
            $this->db->where("pc.paciente_id", $paciente_titular_id);
        }


        $this->db->where("pcp.data <=", $data);
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacienteprevistas($paciente_contrato_id) {

        $this->db->select('
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_contrato_id);
        $this->db->where("pcp.data <=", date("Y-m-d"));
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacientemensal($paciente_contrato_id) {
        $data = date("m");
        $data_year = date("Y");
//        var_dump($data); die;
        $this->db->select('
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_contrato_id);
        $this->db->where("pcp.ativo", 'f');
        $this->db->where("Extract(Month From pcp.data) = $data");
        $this->db->where("Extract(Year From pcp.data) = $data_year");
        $this->db->where("pc.ativo", 't');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspacientecarencia($paciente_id) {

        $this->db->select('fp.carencia_especialidade,fp.carencia_consulta,fp.carencia_exame, carencia_exame_mensal,carencia_consulta_mensal,carencia_especialidade_mensal');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarobservacoes($agenda_exame_id) {
        $this->db->select('entregue_observacao');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarpreparo($tuss_id) {
        $this->db->select('texto');
        $this->db->from('tb_tuss');
        $this->db->where('tuss_id', $tuss_id);
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarpreparoconvenio($convenio_id) {
        $this->db->select('observacao as texto');
        $this->db->from('tb_convenio');
        $this->db->where('convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarchamadas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ac.ambulatorio_chamada_id,
                            ac.descricao,
                            p.nome as paciente,
                            es.nome_chamada as sala,
                            es.nome as nome_sala');
        $this->db->from('tb_ambulatorio_chamada ac');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ac.sala_id', 'left');
        $this->db->where('ac.empresa_id', $empresa_id);
        $this->db->where("ac.ativo", 'true');
        $this->db->limit(1);
        $query = $this->db->get();
        $return = $query->result();

        $ambulatorio_chamada_id = $return[0]->ambulatorio_chamada_id;

        $this->db->set('ativo', 'f');
        $this->db->where('ambulatorio_chamada_id', $ambulatorio_chamada_id);
        $this->db->update('tb_ambulatorio_chamada');


        return $return;
    }

    function relatorioexamesconferencia() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            pc.qtdech,
                            pc.valorch,
                            ae.paciente_id,
                            o.nome as medico,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.grupo,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['faturamento'] != "0") {
            $this->db->where("ae.faturado", $_POST['faturamento']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "" && $_POST['tipo'] != "-1") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao in (2,3)");
        }
        if ($_POST['tipo'] == "-1") {
            $this->db->where("tu.classificacao in (1,2)");
        }
        if ($_POST['raca_cor'] != "0" && $_POST['raca_cor'] != "-1") {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['raca_cor'] == "-1") {
            $this->db->where('p.raca_cor !=', '5');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
            $this->db->where('pt.grupo !=', 'TOMOGRAFIA');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('c.convenio_id');
        if ($_POST['classificacao'] == "0") {
            $this->db->orderby('ae.guia_id');
            $this->db->orderby('ae.data');
            $this->db->orderby('p.nome');
        } else {
            $this->db->orderby('p.nome');
            $this->db->orderby('ae.guia_id');
            $this->db->orderby('ae.data');
        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesala() {

        $this->db->select('an.nome, count(an.nome) as quantidade, sum(ae.valor_total) as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['salas'] != "0") {
            $this->db->where("ae.agenda_exames_nome_id", $_POST['salas']);
        }
        $this->db->groupby('an.nome');
        $this->db->orderby('an.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexames() {

        $this->db->select('p.paciente_id,
                            p.nome as paciente,
                            p.data_cadastro,
                            c.nome as convenio,
                            p.nascimento');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->where("p.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("p.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("p.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        $this->db->orderby('c.convenio_id');
        $this->db->orderby('p.nome');
        $this->db->orderby('p.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamescontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocancelamento() {

        $this->db->select('ac.agenda_exames_id,
                            ac.data_cadastro as data,
                            ac.operador_cadastro,
                            o.nome as operador,
                            c.nome as convenio,
                            ac.paciente_id,
                            ae.data_autorizacao,
                            ac.observacao_cancelamento,
                            p.nome as paciente,
                            ac.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.grupo,
                            ca.descricao,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_ambulatorio_atendimentos_cancelamento ac');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = ac.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ac.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_ambulatorio_cancelamento ca', 'ca.ambulatorio_cancelamento_id = ac.ambulatorio_cancelamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ac.operador_cadastro', 'left');
        $this->db->where("ac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ac.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('c.convenio_id');
        $this->db->orderby('ac.data_cadastro');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocancelamentocontador() {

        $this->db->select('ac.agenda_exames_id');
        $this->db->from('tb_ambulatorio_atendimentos_cancelamento ac');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ac.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ac.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriovalorprocedimento() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.valor,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
        $this->db->where("ae.procedimento_tuss_id", $_POST['procedimento1']);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalorprocedimentocontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
        $this->db->where("ae.procedimento_tuss_id", $_POST['procedimento1']);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioexamesgrupo() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoprocedimento() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoprocedimentoacompanhamento() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogrupoprocedimentomedico() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medico'] != "0") {
            $this->db->where("al.medico_parecer1", $_POST['medico']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoanalitico() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            ae.quantidade,
	    p.nome,
	    pt.nome as procedimento,
            ae.valor_total as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ae.data');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupocontador() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] != "0") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioexamesfaturamentorm() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesfaturamentormcontador() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriogeralconvenio() {

        $this->db->select('c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        // $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralconvenio() {

        $this->db->select('c.nome as convenio,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogeralconveniocontador() {

        $this->db->select('c.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitante() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontador() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitantexmedico() {

        $this->db->select('o.nome as medicosolicitante,
            os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            ae.valor_total as valor,
            al.situacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorxmedico() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitantexmedicoindicado() {

        $this->db->select('o.nome as medicosolicitante,
            os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            ae.valor_total as valor,
            al.situacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.indicado', 't');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorxmedicoindicado() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.indicado', 't');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriolaudopalavra() {

        $this->db->select('os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            p.telefone,
            tl.descricao as tipologradouro,
            p.logradouro,
            p.numero,
            p.complemento,
            p.bairro,
            p.nascimento,
            p.sexo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tipo_logradouro tl', 'tl.tipo_logradouro_id = p.tipo_logradouro', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.texto ilike', "%" . $_POST['palavra'] . "%");
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriolaudopalavracontador() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.texto ilike', "%" . $_POST['palavra'] . "%");
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitanterm() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('pt.grupo', 'RM');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorrm() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('pt.grupo', 'RM');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            ae.valor_total,
            pc.procedimento_tuss_id,
            al.medico_parecer1,
            pt.perc_medico,
            pt.grupo,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:01");
        $this->db->where("ae.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->orderby('c.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:01");
        $this->db->where("ae.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriotecnicoconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.data,
            pt.grupo,
            o.nome as tecnico,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioindicacao() {

        $this->db->select('p.nome as paciente,
            pi.nome as indicacao');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');

        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('pi.nome');
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorionotafiscal() {
        $inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $sql = "SELECT distinct(g.ambulatorio_guia_id ),  p.nome as paciente FROM ponto.tb_ambulatorio_guia g 
JOIN ponto.tb_agenda_exames ae ON ae.guia_id = g.ambulatorio_guia_id 
JOIN ponto.tb_paciente p ON p.paciente_id = g.paciente_id 
WHERE g.nota_fiscal = true AND ae.empresa_id = '1' 
AND ae.data >= '$inicio' AND ae.data <= '$fim'
ORDER BY p.nome";
        return $return = $this->db->query($sql)->result();
    }

    function relatorioindicacaoconsolidado() {

        $this->db->select('pi.nome as indicacao,
            count(pi.nome) as quantidade');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');
        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('pi.nome');
        $this->db->orderby('pi.nome');
//        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalormedio() {

        $this->db->select('pt.nome as procedimento,
                            count(pt.nome) as quantidade,
                            sum(valortotal) as valor,');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarvendedor() {

        $this->db->select('nome');
        $this->db->from('tb_operador');
        $this->db->where('operador_id', @$_POST['vendedor']);
        $return = $this->db->get()->result();
        if (count($return) > 0) {
            return $return[0]->nome;
        } else {
            return '';
        }
    }   

    function relatoriocomissao() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao,
                            fp.comissao_vendedor,
                            fp.comissao_gerente,
                            fp.comissao_seguradora,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        // $this->db->orderby('fr.nome, p.nome');
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoexterno() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao_vendedor_externo as comissao,
                            fp.comissao_vendedor_externo as comissao_vendedor,
                            fp.comissao_vendedor_externo,
                            fp.comissao_gerente,
                            fp.comissao_seguradora,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        // $this->db->orderby('fr.nome, p.nome');
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoexternoindicacao() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao_vendedor_externo as comissao,
                            fp.comissao_vendedor_externo as comissao_vendedor,
                            fp.comissao_vendedor_externo,
                            fp.comissao_gerente,
                            fp.comissao_seguradora,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.indicacao_id', 'left');
        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.indicacao_id IS NOT NULL', NULL);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        // $this->db->orderby('fr.nome, p.nome');
        $this->db->orderby('vendedor');
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaorepresentante() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.nome as paciente,
                            fp.comissao,
                            pc.ativo,
                            pc.data_cadastro,
                            ago.gerente_id,
                            ro.representante_id,
                            fp.comissao_gerente_mensal,
                            o3.nome as representante,
                            o2.nome as vendedor,
                            o.nome as gerente');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_ambulatorio_gerente_operador ago', 'ago.operador_id = p.vendedor', 'left');
        $this->db->join('tb_ambulatorio_representante_operador ro', 'ro.gerente_id = ago.gerente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ago.gerente_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = p.vendedor', 'left');
        $this->db->join('tb_operador o3', 'o3.operador_id = ro.representante_id', 'left');
        $this->db->where('pc.excluido', 'false');
        // $this->db->where('pc.ativo', 'false');
        $this->db->where('pc.ativo_admin', 'true');
        $this->db->where('p.ativo', 'true');
        $this->db->where('ro.representante_id', $_POST['vendedor']);
        $this->db->where('ago.ativo', 'true');
        $this->db->where('ro.ativo', 'true');
        // $this->db->where('ago.ativo', 't');
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->orderby('ro.representante_id');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoContadorForma() {

        $this->db->select('pc.plano_id, p.forma_rendimento_id, count(p.forma_rendimento_id) as contador');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('p.forma_rendimento_id is not null');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->groupby('pc.plano_id, p.forma_rendimento_id');
        $this->db->orderby('p.forma_rendimento_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoContadorFormaExterno() {

        $this->db->select('pc.plano_id, p.forma_rendimento_id, count(p.forma_rendimento_id) as contador');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('p.forma_rendimento_id is not null');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->groupby('pc.plano_id, p.forma_rendimento_id');
        $this->db->orderby('p.forma_rendimento_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoContadorFormaExternoindicacao() {

        $this->db->select('pc.plano_id, p.forma_rendimento_id, count(p.forma_rendimento_id) as contador');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('p.forma_rendimento_id is not null');
        //$this->db->where('p.vendedor', $_POST['vendedor']);
        // Se algum dia for preciso fazer com que o relatório mostre todos os vendedores ao não colocar o filtro
        // É necessário se atentar ao fato de quê a lógica por trás da comissão não olha para mais de um vendedor
        // ao mesmo tempo, sendo assim, vai ser preciso refazer uma parte.
        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->groupby('pc.plano_id, p.forma_rendimento_id');
        $this->db->orderby('p.forma_rendimento_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaovendedor() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao,
                            pcp.ativo,
                            pcp.valor,
                            pcp.data,
                            fp.comissao_vendedor_mensal,
                            fp.comissao_gerente_mensal,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        $this->db->where("pcp.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pcp.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoexternomensal() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao,
                            pcp.ativo,
                            pcp.valor,
                            pcp.data,
                            fp.comissao_vendedor_externo_mensal as comissao_vendedor_mensal,
                            fp.comissao_gerente_mensal,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.vendedor', $_POST['vendedor']);
        $this->db->where("pcp.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pcp.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoexternomensaindicacao() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.forma_rendimento_id,
                            fr.nome as forma_rendimento,
                            p.nome as paciente,
                            fp.comissao,
                            pcp.ativo,
                            pcp.valor,
                            pcp.data,
                            fp.comissao_vendedor_externo_mensal as comissao_vendedor_mensal,
                            fp.comissao_gerente_mensal,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_forma_rendimento fr', 'fr.forma_rendimento_id = p.forma_rendimento_id', 'left');
        //$this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.indicacao_id', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcp.excluido', 'false');
        $this->db->where('p.indicacao_id IS NOT NULL', NULL);
        $this->db->where("pcp.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pcp.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('vendedor');
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function vendedorComissaoFormaRend($contador, $plano_id, $forma_pagamento_id) {

        $this->db->select('forma_rendimento_comissao_id, inicio_parcelas, fim_parcelas, valor_comissao');
        $this->db->from('tb_forma_rendimento_comissao');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_rendimento_id', $forma_pagamento_id);
        $this->db->where('plano_id', $plano_id);
        $this->db->where('inicio_parcelas <=', $contador);
        // $fim_parcelas = $_POST['inicio_parcelas'];
        $this->db->where("(fim_parcelas >= $contador or fim_parcelas is null)");
        $this->db->orderby('fim_parcelas desc');
        $return = $this->db->get()->result();
        return $return;
    }

    function relatoriocomissaogerente() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.nome as paciente,
                            fp.comissao,
                            pcp.ativo,
                            pcp.data,
                            pcp.valor,
                            fp.comissao_gerente_mensal,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_ambulatorio_gerente_operador ago', 'ago.operador_id = p.vendedor', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ago.gerente_id', 'left');
        $this->db->where('pc.excluido', 'false');
        $this->db->where('ago.gerente_id', $_POST['vendedor']);
        $this->db->where('ago.ativo', 't');
        $this->db->where("pcp.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pcp.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocomissaoseguradora() {

        $this->db->select('pc.paciente_id,
                            pc.plano_id,
                            fp.nome as plano,
                            p.nome as paciente,
                            fp.comissao,
                            pc.data_cadastro as data,
                            fp.comissao_seguradora,
                            o.nome as vendedor');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = p.vendedor', 'left');
        $this->db->where('pc.excluido', 'false');
        if ($_POST['seguradora'] != '') {
            $this->db->where('p.vendedor', $_POST['seguradora']);
        }

        $this->db->where("pc.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pc.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->orderby('p.nome');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalormedioconvenio() {

        $this->db->select('pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            c.nome as convenio,
                            pc.valortotal');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('c.convenio_id');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriograficoalormedio($procedimento) {

        $this->db->select('pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            c.nome as convenio,
                            pc.valortotal');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_procedimento_convenio pc', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pt.procedimento_tuss_id', $procedimento);
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriograficovalormedio2($procedimento, $convenio, $txtdata_inicio, $txtdata_fim) {

        $txtdatainicio = str_replace("-", "/", $txtdata_inicio);
        $txtdatafim = str_replace("-", "/", $txtdata_fim);
//        var_dump($txtdatainicio);
//        var_dump($txtdatafim);
//        die;
        $this->db->select('count(pt.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", $txtdatainicio);
        $this->db->where("ae.data <=", $txtdatafim);
        $this->db->where('pt.procedimento_tuss_id', $procedimento);
        $this->db->where('c.nome', $convenio);
        $this->db->groupby('pt.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        $result = $return->result();

        if (isset($result[0]->quantidade)) {
            $qua = $result[0]->quantidade;
            $quantidade = (int) $qua;
        } else {
            $quantidade = 0;
        }
        return $quantidade;

//        $quantidade = count($result);
//        $this->db->select('pt.nome as procedimento,
//                            pt.procedimento_tuss_id,
//                            c.nome as convenio,
//                            pc.valortotal');
//        $this->db->from('tb_convenio c');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.convenio_id = c.convenio_id', 'left');
//        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pt.procedimento_tuss_id', $procedimento);
//        $this->db->where('c.nome', $convenio);
//        $this->db->orderby('c.nome');
//        $return = $this->db->get();
//        $result=$return->result();
//        $quantidade=  count($result);
//        return $quantidade;
    }

    function relatoriotecnicoconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriotecnicoconveniosintetico() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.data,
            pt.grupo,
            o.nome as tecnico,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('e.tecnico_realizador');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriotecnicoconveniocontadorsintetico() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));
        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidos() {
        $data = date("d/m/Y");
        $empresa_id = $this->session->userdata('empresa_id');
        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidosdatafim() {
        $data = date("d/m/Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconsultaconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            pt.grupo,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconsultaconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconveniorm() {
        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioaniversariantes() {


        try {
            $mes = $_POST['txtdata_inicio'];
            if ($mes < 0) {
                $mes = $mes * -1;
            }

            $sql = "SELECT m.nome as municipio,p.logradouro,p.numero,p.bairro,p.nome as paciente, p.nascimento , p.celular , p.telefone from ponto.tb_paciente p
                left join ponto.tb_convenio c on c.convenio_id = p.convenio_id
                 left join ponto.tb_municipio m on m.municipio_id = p.municipio_id
                Where Extract(Month From p.nascimento) = $mes order by Extract(Day From p.nascimento)";

            return $this->db->query($sql)->result();
        } catch (Exception $ex) {
            return -1;
        }
    }

    function relatoriomedicoconveniocontadorrm() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function percentualmedico($procedimentopercentual, $medicopercentual) {

        $this->db->select('valor');
        $this->db->from('tb_procedimento_percentual_medico');
        $this->db->where('procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('medico', $medicopercentual);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function percentualmedicoconvenio($procedimentopercentual, $medicopercentual) {

        $this->db->select('mc.valor');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('mc.medico', $medicopercentual);
        $this->db->where('mc.ativo', 'true');
        $return = $this->db->get();

//        var_dump($return->result());
//        die;
        return $return->result();
    }

    function relatoriomedicoconveniofinanceiro() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            pc.procedimento_convenio_id,
            ae.autorizacao,
            ae.data,
            op.operador_id,
            ae.valor_total,
            pc.procedimento_tuss_id,
            al.medico_parecer1,
            pt.perc_medico,
            al.situacao as situacaolaudo,
            tu.classificacao,
            o.nome as revisor,
            pt.percentual,
            op.nome as medico,
            ops.nome as medicosolicitante,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniofinanceirotodos() {

        $this->db->select('sum(ae.valor_total)as valor,
            sum(ae.quantidade) as quantidade,
            op.nome as medico');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('op.nome');
        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconvenioprevisaofinanceiro() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,            
            ae.valor_total,
            pc.procedimento_tuss_id,
            pc.procedimento_convenio_id,
            al.medico_parecer1,
            pt.perc_medico,
            al.situacao as situacaolaudo,
            tu.classificacao,
            o.nome as revisor,
            pt.percentual,
            op.nome as medico,
            ops.nome as medicosolicitante,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeral() {

        $this->db->select('op.nome as medico,
                           sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('op.nome');
        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralmedico() {

        $this->db->select('op.nome as medico,
                           ae.valor_total,
                           pt.perc_medico,
                           pt.procedimento_tuss_id,
                           al.medico_parecer1,
                           pt.percentual');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ppm.ativo', 'true');
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatorioatendenteconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            ae.valor_total,
            pc.procedimento_tuss_id,
            op.nome as atendente,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('al.situacao', 'FINALIZADO');

        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['txttecnico'] != "") {
            $this->db->where("op.operador_id", $_POST['txttecnico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniocontadorfinanceiro() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriogrupo() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            f.nome as forma_pagamento,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where("pt.grupo", $_POST['grupo']);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogrupocontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where("pt.grupo", $_POST['grupo']);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocaixa() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.verificado,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            ae.autorizacao,
                            ae.operador_autorizacao,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            pt.descricao as procedimento,
                            pt.codigo,
                            ae.desconto,
                            ae.parcelas1,
                            ae.parcelas2,
                            ae.parcelas3,
                            ae.parcelas4');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->orderby('ae.operador_autorizacao');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixafaturado() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.verificado,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.forma_pagamento4,
                            ae.valor4,
                            ae.autorizacao,
                            ae.operador_autorizacao,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_faturamento', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->orderby('ae.operador_faturamento');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function valoralterado($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            pt.codigo,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            ae.editarvalor_total,
                            ae.editarforma_pagamento,
                            o.nome,
                            op.nome as usuario_antigo,
                            ae.editarquantidade,
                            f.nome as forma');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.editarprocedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.editarforma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_editar', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamentoantigo', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificado($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.valor_total,
                            f.nome as forma');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaobservacao($guia_id) {

        $this->db->select('ambulatorio_guia_id,
                            nota_fiscal,
                            recibo,
                            observacoes');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function guiaconvenio($guia_id) {

        $this->db->select('guiaconvenio,
            ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaodeclaracao($guia_id) {

        $this->db->select('ambulatorio_guia_id,
                            declaracao');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocaixacontadorfaturado() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_faturamento', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriophmetria() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            f.nome as forma_pagamento,
                            pt.descricao as procedimento,
                            o.nome as medicosolicitante,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('pt.grupo', 'RX');
        $this->db->where('pc.convenio_id', '38');
        $this->db->orderby('o.nome');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriophmetriacontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('pt.grupo', 'RX');
        $this->db->where('pc.convenio_id', '38');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconveniormrevisor() {

        $this->db->select('o.nome as revisor,
            count(o.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniormrevisada() {

        $this->db->select('o.nome as revisor,
            count(o.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer2', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravardeclaracaoguia($guia_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('declaracao', $_POST['declaracao']);
            $this->db->set('operador_declaracao', $operador_id);
            $this->db->set('data_declaracao', $horario);
            $this->db->where('ambulatorio_guia_id', $guia_id);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaratendimentoparceiro($parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data_atendimento, $grupo, $paciente_titular_id, $carencia_liberada, $tipo_consulta) {
        try {
            /* inicia o mapeamento no banco */
//            var_dump($carencia_liberada); die;
            $data = date("Y-m-d");
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('paciente_fidelidade_id', $_POST['txtNomeid']);
            $this->db->set('paciente_parceiro_id', $paciente_parceiro_id);
            $this->db->set('paciente_titular_id', $paciente_titular_id);
            $this->db->set('carencia_liberada', $carencia_liberada);
            $this->db->set('parceiro_id', $parceiro_gravar_id);

            if ($tipo_consulta != '') {
                $this->db->set('consulta_tipo', $tipo_consulta);
                $this->db->set('consulta_avulsa', 't');
            }
            $this->db->set('data', $data);
            $this->db->set('grupo', $grupo);
            $this->db->set('data_atendimento', $data_atendimento);
            $this->db->set('procedimento_convenio_id', $_POST['procedimento']);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_exames_fidelidade');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaratendimentoparceiroweb($paciente_id, $parceiro_id, $valor, $procedimento, $parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data_atendimento, $grupo, $paciente_titular_id, $carencia_liberada, $tipo_consulta) {
        try {
            /* inicia o mapeamento no banco */
//            var_dump($carencia_liberada); die;
            $data = date("Y-m-d");
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('paciente_fidelidade_id', $paciente_id);
            $this->db->set('paciente_parceiro_id', $paciente_parceiro_id);
            $this->db->set('paciente_titular_id', $paciente_titular_id);
            $this->db->set('carencia_liberada', $carencia_liberada);
            $this->db->set('parceiro_id', $parceiro_gravar_id);
            $this->db->set('parceiro_convenio_id', $parceiro_id);
            $this->db->set('valor', $valor);
            if ($tipo_consulta != '') {
                $this->db->set('consulta_tipo', $tipo_consulta);
                $this->db->set('consulta_avulsa', 't');
            }
            $this->db->set('data', $data);
            $this->db->set('grupo', $grupo);
            $this->db->set('data_atendimento', $data_atendimento);
            $this->db->set('procedimento_convenio_id', $procedimento);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_exames_fidelidade');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaratendimentoparceiro($paciente_id, $grupo) {
        $this->db->select('ef.paciente_fidelidade_id');
        $this->db->from('tb_exames_fidelidade ef');
        $this->db->where("ef.paciente_titular_id", $paciente_id);
        $this->db->where("ef.grupo", $grupo);
        $this->db->where("ef.carencia_liberada", 't');
        $this->db->where("ef.consulta_avulsa", 'f');

        $return = $this->db->get();
        return $return->result();
    }

    function listaratendimentoparceiromensal($paciente_id, $grupo) {
        $data = date("m");
        $data_year = date("Y");
        $this->db->select('ef.paciente_fidelidade_id');
        $this->db->from('tb_exames_fidelidade ef');
        $this->db->where("ef.paciente_titular_id", $paciente_id);
        $this->db->where("Extract(Month From ef.data) = $data");
        $this->db->where("Extract(Year From ef.data) = $data_year");
        $this->db->where("ef.grupo", $grupo);
        $this->db->where("ef.carencia_liberada", 't');
        $this->db->where("ef.consulta_avulsa", 'f');

        $return = $this->db->get();
        return $return->result();
    }

    function listaratendimentoagendaexames($paciente_titular_id, $agenda_exames_id) {
//        $data = date("m");
//        $data_year = date("Y");
        $this->db->select('ef.paciente_fidelidade_id');
        $this->db->from('tb_exames_fidelidade ef');
        $this->db->where("ef.paciente_titular_id", $paciente_titular_id);
        $this->db->where("ef.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaavulsaliberada($paciente_id) {


        $this->db->select('consultas_avulsas_id, ef.paciente_id, tipo, data');
        $this->db->from('tb_consultas_avulsas ef');
        $this->db->where("ef.paciente_id", $paciente_id);
        $this->db->where("ef.excluido", 'f');
        $this->db->where("ef.utilizada", 'f');
        $this->db->where("ef.ativo", 'f');
        $this->db->orderby('ef.data');
        $return = $this->db->get();
        return $return->result();
    }

    function utilizarconsultaavulsaliberada($consulta_avulsa_id) {
        $data = date("Y-m-d");

        $this->db->set('data_utilizada', $data);
        $this->db->set('utilizada', 't');
        $this->db->where("consultas_avulsas_id", $consulta_avulsa_id);
        $this->db->update('tb_consultas_avulsas');

        return true;
    }

    function listarexamesguia($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            pt.procedimento_tuss_id,
                            ae.data,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.valor_total,
                            es.nome as agenda,
                            ae.guia_id,
                            ae.paciente_id,
                            ae.quantidade,
                            ae.data_autorizacao,
                            p.nome as paciente,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            p.sexo,
                            es.nome as sala,
                            c.nome as convenio,
                            ae.autorizacao,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pc.convenio_id,
                            ae.data_realizacao as horafimexame,
                            l.data_atualizacao as horafimconsulta,
                            c.dinheiro,
                            ge.guiaconvenio,
                            ae.guiaconvenio as guiaexame,
                            p.convenionumero,
                            pt.codigo,
                            ope.nome as medicoagenda,
                            ope.conselho,
                            ope.cbo_ocupacao_id,
                            c.codigoidentificador,
                            c.registroans,
                            m.estado,
                            m.nome as municipio,
                            ge.declaracao,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ge', 'ge.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.forma_pagamento');
        $this->db->orderby('ae.forma_pagamento2');
        $this->db->orderby('ae.forma_pagamento3');
        $this->db->orderby('ae.forma_pagamento4');
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesorcamento($orcamento) {

        $this->db->select('oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            o.nome as operador,
                            oi.valor_total,
                            oi.quantidade,
                            oi.valor,
                            p.nome as paciente,
                            p.sexo,
                            oi.orcamento_id,
                            c.nome as convenio,
                            pc.convenio_id,
                            c.dinheiro,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = oi.operador_cadastro', 'left');
        $this->db->where("oi.orcamento_id", $orcamento);
        $this->db->orderby('oi.ambulatorio_orcamento_item_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguiaconvenio($guia_id, $convenioid) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.valor_total,
                            es.nome as agenda,
                            ae.guia_id,
                            ae.paciente_id,
                            ae.quantidade,
                            ae.data_atualizacao,
                            ae.data_autorizacao,
                            p.nome as paciente,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            p.sexo,
                            es.nome as sala,
                            c.nome as convenio,
                            ae.autorizacao,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pc.convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("c.convenio_id", $convenioid);
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexame($exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            pi.nome as indicacao,
                            es.nome as agenda,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.tipo,
                            ae.data_atualizacao,
                            ae.data_realizacao,
                            ae.paciente_id,
                            ae.data_entrega,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            ae.autorizacao,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            ae.desconto,
                            ae.data_autorizacao,
                            ae.agrupador_fisioterapia,
                            ae.numero_sessao,
                            ae.observacoes,
                            ae.qtde_sessao,
                            ae.texto,
                            o.nome as medicosolicitante,
                            op.nome as atendente,
                            opm.nome as medico,
                            opf.nome as atendente_fatura,
                            ex.exames_id,
                            fp.nome as formadepagamento,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            ep.logradouro,
                            ep.razao_social,
                            ep.cnpj,
                            ep.numero,
                            ep.telefone as telefoneempresa,
                            ep.celular as celularempresa,
                            ep.bairro,
                            ep.razao_social,
                            es.nome as sala,
                            ae.cid,
                            p.logradouro as logradouro_paciente,
                            p.numero as numero_paciente,
                            p.complemento as complemento_paciente,
                            p.bairro as bairro_paciente,
                            p.raca_cor,
                            cid.no_cid,
                            c.convenio_id,
                            c.nome as convenio,
                            ag.data_cadastro as data_guia,
                            p.nascimento,
                            p.celular,
                            p.telefone,
                            c.dinheiro,
                            ae.diabetes,
                            ae.hipertensao,
                            cbo.descricao as profissaos,
                            pt.perc_medico,
                            m.nome as municipio,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames ex', 'ex.agenda_exames_id =ae.agenda_exames_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador opm', 'opm.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador opf', 'opf.operador_id = ae.operador_faturamento', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = ae.cid', 'left');
        $this->db->where("ae.agenda_exames_id", $exames_id);
        $this->db->where("ae.cancelada", "f");
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguia($guia_id) {

        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaforma($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("guia_id", $guia_id);
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguianaofaturado($guia_id) {

        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("faturado", 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguianaofaturadoforma($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum(ae.valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.faturado", 'f');
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiacaixa($guia_id) {

        $this->db->select('paciente_id,
                            agenda_exames_id');
        $this->db->from('tb_agenda_exames');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listar2($args = array()) {
        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames e', 'e.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->orderby('ag.data_cadastro');
        $this->db->where("ag.paciente_id", $args['paciente']);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamento() {
        $this->db->select('forma_pagamento_id,
                            nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentoprocedimento($procedimento_convenio_id) {
        $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_procedimento_convenio_pagamento pp');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();

        if (empty($retorno)) {
            $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
            $this->db->from('tb_forma_pagamento fp');
            $this->db->orderby('fp.nome');
            $return = $this->db->get();
            return $return->result();
        } else {
            return $retorno;
        }
    }

    function formadepagamentoguia($guia_id, $financeiro_grupo_id) {

        $this->db->select('distinct(fp.nome),
                           fp.forma_pagamento_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function verificamedico($crm) {
        $this->db->select();
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarmedico($crm) {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarmedicos($parametro = null) {
        $this->db->select('operador_id,
                            nome,
                            conselho');
        $this->db->from('tb_operador');
        $this->db->where('ativo', 't');
        $this->db->where('medico', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
            $this->db->orwhere('conselho ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarguia($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarorcamento($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_orcamento_id');
        $this->db->from('tb_ambulatorio_orcamento');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->row_array();
    }

    function excluir($paciente_id, $contrato_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $paciente_contrato_id = $contrato_id;

        $this->db->set('excluido', 't');
        $this->db->where('paciente_dependente_id', $paciente_id);
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->update('tb_paciente_contrato_parcelas');

        $this->db->select('paciente_contrato_id, plano_id');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

        $this->db->select('parcelas, valoradcional');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $return[0]->plano_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $retorno = $query->result();

        $this->db->select('paciente_contrato_dependente_id');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $this->db->where('pessoa_juridica', 'f');
        $query = $this->db->get();
        $resultado = $query->result();
//        echo '<pre>';
//        var_dump($retorno);
//        die;

        $total = count($resultado);
        $valor = $retorno[0]->valoradcional;

        if ($valor == "") {
            $valor = 0;
        }

        if ($this->session->userdata('cadastro') == 2) {
            
        } else { 
            if ($total > $retorno[0]->parcelas) {
                $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                SET valor = valor - '$valor'
                 WHERE paciente_contrato_id = $paciente_contrato_id ";
                $this->db->query($sql);
            }
        }


        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('ativo', 't');
        $this->db->update('tb_paciente_contrato_dependente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function confirmarpagamento($paciente_contrato_parcelas_id, $paciente_id, $depende_id = NULL) {
 
        if ($this->session->userdata('cadastro') == 2 && $depende_id != "") {
            $paciente_id = $depende_id;
        }

        $info_paciente = $this->listarinforpaciente($paciente_id);
        $parcela = $this->listarparcelaconfirmarpagamento($paciente_contrato_parcelas_id);
        $valor = $parcela[0]->valor;
        $paciente_id = $parcela[0]->paciente_id;
        $credor = $parcela[0]->financeiro_credor_devedor_id;
  
        if ($this->session->userdata('cadastro') == 2 && $depende_id != "" && $depende_id != $paciente_id) {
            $paciente_id = $depende_id;
            $credor = $parcela[0]->financeiro_credor_devedor_id_dependente;
        }
          
//       echo "Credor: ".$credor ; echo '<br>';
//       echo "paciente : ".$paciente_id ; echo '<br>';
//       die; 
        if ($credor == NULL || $credor == '') {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }


        $plano = $parcela[0]->plano;
        $data_parcela = $parcela[0]->data;

        $this->db->select('forma_entradas_saida_id as conta_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('conta_interna', 'true');
        $conta = $this->db->get()->result();

        if (count($conta) > 0) {
            $conta_id = $conta[0]->conta_id;
        } else {
            $conta_id = $parcela[0]->conta_id;
        }

        $this->db->select('financeiro_maior_zero');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
        $return = $this->db->get()->result();
        if ($return[0]->financeiro_maior_zero == 't' && $valor <= 0) { //Caso a flag esteja ativada e valor seja menor ou igual a zero, ele não vai adiconar no financeiro, ira somente costar que está pago.
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('manual', 't');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
        } else {
            //gravando na entrada 
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];

            $this->db->set('data', $data_parcela);
            $this->db->set('tipo', $plano);
            if($parcela[0]->taxa_adesao == 't'){
                $this->db->set('classe', 'ADESÃO');
            }else{
                $this->db->set('classe', 'PARCELA'); 
            }
            // $this->db->set('classe', 'PARCELA');
            $this->db->set('nome', $credor);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
//        Verificando se o usuario escolheu alguma conta, caso ele não tenha escolhido ele vai usar a do sistema que é a padrão
            if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }
//        $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');
            $entradas_id = $this->db->insert_id();

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entradas_id);


            if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }

            $this->db->set('nome', $credor);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $data_parcela);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');
 
            /////////////////////////////////////////////////
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('manual', 't');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
        }





        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function confirmarpagamentocarteira($contrato_id, $paciente_id, $titular_id = NULL) {

        // As variaveis tão com os valores invertidos...... 
        // Paciente é contrato e contrato é paciente...  
//      var_dump($paciente_contrato_parcelas_id); die; 
        if ($titular_id == NULL || $titular_id == '') {
            $parcela = $this->listarexames($titular_id);
        } else {
            $parcela = $this->listarexames($titular_id);
        }

        $situacao = @$parcela[0]->situacao;
        if ($contrato_id == $titular_id) {
            @$valor = $parcela[0]->valor_carteira_titular;
        } else {
            @$valor = $parcela[0]->valor;
        }

        $credor = $this->criarcredordevedorpaciente($titular_id);
        $plano = @$parcela[0]->plano;

        $this->db->select('financeiro_maior_zero');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
        $return = $this->db->get()->result();
        if ($return[0]->financeiro_maior_zero == 't' && $valor <= 0) { //Caso a flag financeiro_maior_zero esteja ativa e o valor seja manor que zero, ele não vai inserir no financeiro.(na tabela entrada,saldo)
            return;
        } else {
            $this->db->select('forma_entradas_saida_id as conta_id,
                            descricao');
            $this->db->from('tb_forma_entradas_saida');
            $this->db->where('ativo', 'true');
            $this->db->where('conta_interna', 'true');
            $conta = $this->db->get()->result();

            if (count($conta) > 0) {
                $conta_id = $conta[0]->conta_id;
            } else {
                $conta_id = $parcela[0]->conta_id;
            }

            //gravando na entrada

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];

            $this->db->set('data', $data);
            $this->db->set('tipo', $plano);
            $this->db->set('classe', 'CARTEIRA');
            $this->db->set('nome', $credor);
            $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');

            $entradas_id = $this->db->insert_id();
//        var_dump($entradas_id); die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entradas_id);
            $this->db->set('conta', $conta_id);
            $this->db->set('nome', $credor);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $data);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');
        }
    }

    function confirmarpagamentoautomaticoiugu($paciente_contrato_parcelas_id) {

        $verificar_parcela_entrada = $this->verificarparcelaentrada($paciente_contrato_parcelas_id);

        if (count($verificar_parcela_entrada) >= 1) {
            return;
        } else {
            
        }
        $parcela = $this->listarparcelaconfirmarpagamento($paciente_contrato_parcelas_id);
//        var_dump($parcela); die;
        $valor = $parcela[0]->valor;
        $paciente_id = $parcela[0]->paciente_id;

        $credor = $parcela[0]->financeiro_credor_devedor_id;


        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }

        $plano = $parcela[0]->plano;
        $data = $parcela[0]->data;
        $conta_id = $parcela[0]->conta_id;
        //gravando na entrada

        $horario = date("Y-m-d H:i:s");
//        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('valor', $valor);
//      $inicio = $_POST['inicio'];
        $this->db->set('paciente_contrato_parcelas_id',$paciente_contrato_parcelas_id);
        $this->db->set('data', $data);
        $this->db->set('tipo', $plano);
        $this->db->set('classe', 'PARCELA');
        $this->db->set('nome', $credor);
        $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        // Chamado #4009
        $this->db->insert('tb_entradas');
        $entradas_id = $this->db->insert_id();
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            $this->db->set('valor', $valor);
        $this->db->set('entrada_id', $entradas_id);
        $this->db->set('conta', $conta_id);
        $this->db->set('nome', $credor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_saldo');



        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpagamentoautomaticoiugu($paciente_contrato_parcelas_id) {


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->delete('tb_paciente_contrato_parcelas_iugu');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function confirmarpagamentoautocomplete($paciente_contrato_parcelas_id) {

        $parcela = $this->listarparcelaconfirmarpagamento($paciente_contrato_parcelas_id);
//      var_dump($parcela); die;
        $valor = $parcela[0]->valor;
        $paciente_id = $parcela[0]->paciente_id;
        $credor = $parcela[0]->financeiro_credor_devedor_id;
        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }
        $plano = $parcela[0]->plano;
        $data = $parcela[0]->data;
        $conta_id = $parcela[0]->conta_id;
        //gravando na entrada

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];
        $this->db->set('paciente_contrato_parcelas_id',$paciente_contrato_parcelas_id); 
        $this->db->set('data', $data);
        $this->db->set('tipo', $plano);
        $this->db->set('classe', 'PARCELA');
        $this->db->set('nome', $credor);
        $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_entradas');
        $entradas_id = $this->db->insert_id();
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            $this->db->set('valor', $valor);
        $this->db->set('entrada_id', $entradas_id);
        $this->db->set('conta', $conta_id);
        $this->db->set('nome', $credor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_saldo');

 
        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function confirmarpagamentogatilhoiugu($invoice_id) {

        $parcela = $this->listarparcelaconfirmarpagamentogatilhoiugu($invoice_id);
//        var_dump($parcela); die;
        $paciente_contrato_parcelas_id = $parcela[0]->paciente_contrato_parcelas_id;
        $paciente_id = $parcela[0]->paciente_id;
        $valor = $parcela[0]->valor;
        $credor = $parcela[0]->financeiro_credor_devedor_id;

        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }
        $plano = $parcela[0]->plano;
        $data = $parcela[0]->data;
        $conta_id = $parcela[0]->conta_id;
        //gravando na entrada

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];
        $this->db->set('paciente_contrato_parcelas_id',$paciente_contrato_parcelas_id);
        $this->db->set('data', $data);
        $this->db->set('tipo', $plano);
        $this->db->set('classe', 'PARCELA');
        $this->db->set('nome', $credor);
        $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_entradas');
        $entradas_id = $this->db->insert_id();
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            $this->db->set('valor', $valor);
        $this->db->set('entrada_id', $entradas_id);
        $this->db->set('conta', $conta_id);
        $this->db->set('nome', $credor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_saldo');



        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function cancelaragendamentocartao($paciente_contrato_parcelas_id, $contrato_id) {


        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cartao_iugu', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_cartao_exclusao', $horario);
        $this->db->set('operador_cartao_exclusao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');

        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->delete('tb_paciente_contrato_parcelas_iugu');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function listarpagamentoscontratoconsultaavulsa($consultas_avulsas_id) {
        $this->db->select('*');
        $this->db->from('tb_consultas_avulsas');
        $this->db->where("consultas_avulsas_id", $consultas_avulsas_id);
        $this->db->orderby("data");
        $return = $this->db->get();
        return $return->result();
    }

    function criarcredordevedorpaciente($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_paciente');
        $this->db->where("paciente_id", $paciente_id);
        // $this->db->orderby("data");
        $return = $this->db->get()->result();

        if (@$return[0]->credor_devedor_id != '') {
            return $return[0]->credor_devedor_id;
        } else {
            $this->db->set('razao_social', @$return[0]->nome);
            $this->db->set('cep', @$return[0]->cep);
            if (@$return[0]->cpf != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $return[0]->cpf)));
            } else {
                $this->db->set('cpf', null);
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", @$return[0]->telefone))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", @$return[0]->celular))));
            // if ($_POST['tipo_logradouro'] != '') {
            // $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
            // }
            if (@$return[0]->municipio_id != '') {
                $this->db->set('municipio_id', $return[0]->municipio_id);
            }
            $this->db->set('logradouro', @$return[0]->logradouro);
            $this->db->set('numero', @$return[0]->numero);
            $this->db->set('bairro', @$return[0]->bairro);
            $this->db->set('complemento', @$return[0]->complemento);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $financeiro_credor_devedor_id = $this->db->insert_id();

            $this->db->set('credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->where("paciente_id", $paciente_id);
            $this->db->update('tb_paciente');

            return $financeiro_credor_devedor_id;
        }
    }

    function confirmarpagamentoconsultaavulsa($consultas_avulsas_id, $paciente_id) {

        $credor_obj = $this->listarparcelaconfirmarpagamentoconsultaavulsa($paciente_id);

        $parcela = $this->listarpagamentoscontratoconsultaavulsa($consultas_avulsas_id);
        // echo '<pre>';
        // var_dump($credor); die;
        $tipo = $parcela[0]->tipo;
        $data_consulta_avul = $parcela[0]->data;
//        $credor = $credor_obj[0]->financeiro_credor_devedor_id;  SE BOTAR ESSA LINHA OS CREDORES VÃO DUPLICAR
        $credor = "";
        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }

        // var_dump($credor); die;

        if ($tipo == 'EXTRA') {
            $plano = 'CONSULTA EXTRA';
        } else {
            $plano = 'CONSULTA COPARTICIPAÇÃO';
        }


        $this->db->select('forma_entradas_saida_id as conta_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('conta_interna', 'true');
        $conta = $this->db->get()->result();

        if ($credor_obj[0]->conta_id == "") {

            $conta_id = $conta[0]->conta_id;
        } else {

            $conta_id = $credor_obj[0]->conta_id;
        }

        // var_dump($conta_id); die;
        //gravando na entrada
        $valor = $parcela[0]->valor;


        $this->db->select('financeiro_maior_zero');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $this->session->userdata('empresa_id'));

        $return = $this->db->get()->result();

        if ($return[0]->financeiro_maior_zero == 't' && $valor <= 0) {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('manual', 't');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
            $this->db->update('tb_consultas_avulsas');
        } else {

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];

            $this->db->set('data', $data_consulta_avul);
            $this->db->set('tipo', $plano);
            $this->db->set('classe', 'PARCELA');
            $this->db->set('nome', $credor);

            if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }
            $this->db->set('consultas_avulsas_id',$consultas_avulsas_id);
//          $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');
            $entradas_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            // if (trim($erro) != "") // erro de banco
            //     return -1;
            // else
            $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entradas_id);
            if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }
            $this->db->set('nome', $credor);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $data_consulta_avul);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');


            /////////////////////////////////////////////////
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('manual', 't');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
            $this->db->update('tb_consultas_avulsas');
        }
        $erro = $this->db->_error_message();

        // if (trim($erro) != "") // erro de banco
        //     return false;
        // else
        return $plano;
    }

    function gravarstatusconsultaextra($consultas_avulsas_id, $paciente_id) {

        // var_dump($_POST['status']); die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('utilizada', $_POST['status']);
        // $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
        $this->db->update('tb_consultas_avulsas');  
        $erro = $this->db->_error_message();

        return $consultas_avulsas_id;
    }

    function confirmarpagamentoautomaticoconsultaavulsaiugu($consultas_avulsas_id, $paciente_id, $tipo, $valor) {

        $parcela = $this->listarparcelaconfirmarpagamentoconsultaavulsa($paciente_id);
//        echo '<pre>';
//        var_dump($tipo); die;
      
        $credor = $parcela[0]->financeiro_credor_devedor_id;
        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }
        if ($tipo == 'EXTRA') {
            $plano = 'CONSULTA EXTRA';
        } else {
            $plano = 'CONSULTA COPARTICIPAÇÃO';
        }

        $conta_id = $parcela[0]->conta_id;
        //gravando na entrada

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('valor', $valor);
//      $inicio = $_POST['inicio'];
        $this->db->set('consultas_avulsas_id',$consultas_avulsas_id);
        $this->db->set('data', $data);
        $this->db->set('tipo', $plano);
        $this->db->set('classe', 'PARCELA');
        $this->db->set('nome', $credor);
        $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        // Chamado #4009
        $this->db->insert('tb_entradas');
        $entradas_id = $this->db->insert_id();
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            $this->db->set('valor', $valor);
        $this->db->set('entrada_id', $entradas_id);
        $this->db->set('conta', $conta_id);
        $this->db->set('nome', $credor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_saldo');



        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
        $this->db->update('tb_consultas_avulsas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarnovovalorprocedimento() {
        $procedimento = $_POST['procedimento'];

        $data_inicio = date("Y-m-d", strtotime($_POST['txtdata_inicio']));
        $data_fim = date("Y-m-d", strtotime($_POST['txtdata_fim']));

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $valor = str_replace(",", ".", $_POST['valor']);
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $sql = "UPDATE ponto.tb_agenda_exames 
SET data_atualizacao = '$horario', 
operador_atualizacao = $operador_id, 
valor = $valor, 
valor_total = quantidade * $valor 
WHERE procedimento_tuss_id = $procedimento 
AND data >= '$data_inicio' 
AND data <= '$data_fim'";
        $this->db->query($sql);
        return 0;
    }

    function consultargeralparticular($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularfaturado($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularnaofaturado($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconveniofaturado($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenionaofaturado($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenio($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralsintetico($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'
                and (c.dinheiro = false
                or c.dinheiro = true)";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function gravarintegracaoiugu($url, $invoice_id, $paciente_contrato_parcelas_id, $empresa_id = NULL) {
        try {
            $this->db->set('data_cartao_iugu', null);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('url', $url);
            $this->db->set('invoice_id', $invoice_id);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if (@$empresa_id != "") {
                $this->db->set('empresa_id', @$empresa_id);
            } else {
                
            }
            $this->db->insert('tb_paciente_contrato_parcelas_iugu');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarintegracaoiuguconsultaavulsaalterardata($url, $invoice_id, $consulta_avulsa_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->set('url', $url);
            $this->db->set('invoice_id', $invoice_id);
//            $this->db->set('data_vencimento', null);
            $this->db->where('consultas_avulsas_id', $consulta_avulsa_id);
            $this->db->update('tb_consultas_avulsas');

            /* inicia o mapeamento no banco */

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarintegracaoiuguautocomplete($url, $invoice_id, $paciente_contrato_parcelas_id, $status, $LR) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->delete('tb_paciente_contrato_parcelas_iugu');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($status == 'Autorizado') {
                $parcela = $this->confirmarpagamentoautocomplete($paciente_contrato_parcelas_id);
            } else {
                $this->db->set('ativo', 't');
                $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
                $this->db->update('tb_paciente_contrato_parcelas');
            }
            $this->db->set('url', $url);
            $this->db->set('status', $status);
            $this->db->set('codigo_lr', $LR);
            $this->db->set('invoice_id', $invoice_id);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_parcelas_iugu');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarintegracaoiuguconsultaavulsa($url, $invoice_id, $consultas_avulsas_id) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('url', $url);
            $this->db->set('invoice_id', $invoice_id);
            $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
            $this->db->update('tb_consultas_avulsas');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($paciente_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarverificado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('verificado', 't');
            $this->db->set('data_verificado', $horario);
            $this->db->set('operador_verificado', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function recebidoresultado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('recebido', 't');
            $this->db->set('data_recebido', $horario);
            $this->db->set('operador_recebido', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarrecebidoresultado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('recebido', 'f');
            $this->db->set('data_recebido', $horario);
            $this->db->set('operador_recebido', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarentregaexame($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('entregue', $_POST['txtentregue']);
            $this->db->set('entregue_telefone', $_POST['telefone']);
            $this->db->set('entregue_observacao', $_POST['observacaocancelamento']);
            $this->db->set('data_entregue', $horario);
            $this->db->set('operador_entregue', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarobservacaoguia($guia_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('observacoes', $_POST['observacoes']);
        $this->db->set('nota_fiscal', $_POST['nota_fiscal']);
        $this->db->set('recibo', $_POST['recibo']);
        $this->db->set('data_observacoes', $horario);
        $this->db->set('operador_observacoes', $operador_id);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarguiaconvenio($guia_id) {
        $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarfaturamento() {
        try {

            if ($_POST['ajuste1'] != "0") {
                $valor1 = $_POST['valorajuste1'];
            } else {
                $valor1 = $_POST['valor1'];
            }
            if ($_POST['ajuste2'] != "0") {
                $valor2 = $_POST['valorajuste2'];
            } else {
                $valor2 = $_POST['valor2'];
            }
            if ($_POST['ajuste3'] != "0") {
                $valor3 = $_POST['valorajuste3'];
            } else {
                $valor3 = $_POST['valor3'];
            }
            if ($_POST['ajuste4'] != "0") {
                $valor4 = $_POST['valorajuste4'];
            } else {
                $valor4 = $_POST['valor4'];
            }
            if ($_POST['ajuste1'] != "0" || $_POST['ajuste2'] != "0" || $_POST['ajuste3'] != "0" || $_POST['ajuste4'] != "0") {
                if ($_POST['valor1'] > $_POST['valorajuste1']) {
                    $desconto1 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto1 = $_POST['valorajuste1'] - $_POST['valor1'];
                }
                if ($_POST['valor2'] > $_POST['valorajuste2']) {
                    $desconto2 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto2 = $_POST['valorajuste2'] - $_POST['valor2'];
                }
                if ($_POST['valor3'] > $_POST['valorajuste3']) {
                    $desconto3 = $_POST['valor3'] - $_POST['valorajuste3'];
                } else {
                    $desconto3 = $_POST['valorajuste3'] - $_POST['valor3'];
                }
                if ($_POST['valor4'] > $_POST['valorajuste4']) {
                    $desconto4 = $_POST['valor4'] - $_POST['valorajuste4'];
                } else {
                    $desconto4 = $_POST['valorajuste4'] - $_POST['valor4'];
                }

                $desconto = $desconto1 + $desconto2 + $desconto3 + $desconto4;
            } else {
                $desconto = $_POST['desconto'];
            }
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', $_POST['parcela1']);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', $_POST['parcela2']);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', $_POST['parcela3']);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', $_POST['parcela4']);
            }
            $this->db->set('desconto', $desconto);
            $this->db->set('valor_total', $_POST['novovalortotal']);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarpagamentoiugu($paciente_contrato_parcelas_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->delete('tb_paciente_contrato_parcelas_iugu');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultaavulsa($paciente_id) {
        try {
//            $this->db->select('consulta_avulsa');
//            $this->db->from('tb_paciente');
//            $this->db->where("paciente_id", $paciente_id);
//            $return = $this->db->get()->result();
//            echo '<pre>';
            $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $data = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
//            var_dump($valor); die;
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
//            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data', $data);
            $this->db->set('tipo', 'EXTRA');
            $this->db->set('valor', $valor);
            if ($valor == 0.00) {
                $this->db->set('ativo', 'f');
                $this->db->set('manual', 't');
            }
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->insert('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarvoucherconsultaextra($paciente_id, $consulta_avulsa_id) {
        try {

            $data = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
            $hora = date("H:i:s", strtotime(str_replace("/", "-", $_POST['hora'])));
            // var_dump($hora); die;

            $cadastro = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data', $data);
            $this->db->set('horario', $hora);
            $this->db->set('consulta_avulsa_id', $consulta_avulsa_id);
            $this->db->set('parceiro_id', $_POST['parceiro_id']);

            if (isset($_POST['gratuito'])) {
                $this->db->set('gratuito', 't');
            } else {
                $this->db->set('gratuito', 'f');
            }

            $this->db->set('data_cadastro', $cadastro);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_voucher_consulta');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultacoop($paciente_id) {
        try {

//            $this->db->select('consulta_avulsa');
//            $this->db->from('tb_paciente');
//            $this->db->where("paciente_id", $paciente_id);
//            $return = $this->db->get()->result();
//            echo '<pre>';
            $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $data = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
//            var_dump($valor); die;

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
//            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data', $data);
            $this->db->set('tipo', 'COOP');
            $this->db->set('valor', $valor);
            if ($valor == 0.00) {
                $this->db->set('ativo', 'f');
                $this->db->set('manual', 't');
            }
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->insert('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarnovaparcelacontrato($paciente_id, $contrato_id) {
        try {
            $this->db->select('parcela');
            $this->db->from('tb_paciente_contrato_parcelas');
            $this->db->where("paciente_contrato_id", $contrato_id);
            $this->db->orderby("parcela desc");
            $return = $this->db->get()->result();
//            echo '<pre>';
//            var_dump($return); die;
            if (count($return) > 0) {
                $parcela = $return[0]->parcela + 1;
            } else {
                $parcela = 1;
            }

            $valor = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
            $data = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
//          $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_contrato_id', $contrato_id);
            $this->db->set('data', $data);
            $this->db->set('valor', $valor);
            $this->db->set('parcela', $parcela);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_parcelas');
            $paciente_contrato_parcelas_id = $this->db->insert_id();
            if ($valor == 0.00) {
                $this->confirmarpagamento($paciente_contrato_parcelas_id, $paciente_id);
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarcancelarparcelaiugu($paciente_id, $contrato_id) {


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('cp.paciente_contrato_parcelas_id, invoice_id');
        $this->db->from('tb_paciente_contrato_parcelas cp');
        $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
        $this->db->where("cp.paciente_contrato_id", $contrato_id);
        $this->db->where("cpi.paciente_contrato_parcelas_id is not null"); // Pega apenas os que estão no IUGU e no futuro
        $this->db->where("cp.ativo", 't');
        $this->db->where("cp.data >", date("Y-m-d"));
        $this->db->where("cp.excluido", 'f');
        $return = $this->db->get()->result();
//            
//        echo "<pre>";
//        var_dump($return);
//        die;

        foreach ($return as $item) {
            $sql = "DELETE FROM ponto.tb_paciente_contrato_parcelas_iugu
                    WHERE paciente_contrato_parcelas_id = $item->paciente_contrato_parcelas_id";
            $this->db->query($sql);
        }

        return $return;
    }

    function gravarcartaoclienteiugu($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('cp.paciente_contrato_parcelas_id');
            $this->db->from('tb_paciente_contrato_parcelas cp');
            $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
            $this->db->where("cp.paciente_contrato_id", $contrato_id);
            $this->db->where("cpi.paciente_contrato_parcelas_id is null"); // Pega apenas os que ainda não estão no IUGU
            $this->db->where("cp.ativo", 't');
            $this->db->where("cp.excluido", 'f');
            $return = $this->db->get()->result();
//            
//            echo "<pre>";
//            var_dump($return); die;

            foreach ($return as $item) {
                $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                    SET data_cartao_iugu = data, data_cartao_cadastro = '$horario', operador_cartao_cadastro = $operador_id
                    WHERE paciente_contrato_parcelas_id = $item->paciente_contrato_parcelas_id
                    AND taxa_adesao = false;";

                $this->db->query($sql);
            }


//            $this->db->set('data_cartao_iugu = data');
//            $this->db->set('data_atualizacao', $horario);
//            $this->db->set('operador_atualizacao', $operador_id);
//            $this->db->where('paciente_contrato_id', $contrato_id);
//            $this->db->update('tb_paciente_contrato_parcelas');
//            var_dump($_POST); die;
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('card_number', $_POST['card_number']);
            $this->db->set('card_csv', $_POST['card_csv']);
            $this->db->set('mes', $_POST['mes']);
            $this->db->set('ano', $_POST['ano']);
            $this->db->set('first_name', $_POST['first_name']);
            $this->db->set('last_name', $_POST['last_name']);

            if ($_POST['cartao_id'] != '') {
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente_cartao_credito');
            } else {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_cartao_credito');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardebitoconta($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('conta_agencia', $_POST['conta_agencia']);
            $this->db->set('codigo_operacao', $_POST['codigo_operacao']);
            $this->db->set('conta_numero', $_POST['conta_numero']);
            $this->db->set('conta_digito', $_POST['conta_digito']);

            if ($_POST['conta_id'] != '') {
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente_conta_debito');
            } else {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_conta_debito');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirparcelacontrato($paciente_id, $contrato_id, $parcela_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('excluido', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_parcelas_id', $parcela_id);
            $this->db->update('tb_paciente_contrato_parcelas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function confirmarpagamentofidelidade($exames_fidelidade_id) {
        try {
            $this->db->select('valor, paciente_titular_id');
            $this->db->where('exames_fidelidade_id', $exames_fidelidade_id);
            $this->db->from('tb_exames_fidelidade');
            $return = $this->db->get()->result();
            $paciente_id = $return[0]->paciente_titular_id;


            $this->db->select('cp.financeiro_credor_devedor_id, fp.conta_id');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->join('tb_paciente_contrato_parcelas cp', 'cp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
            $this->db->join('tb_paciente_contrato_parcelas_iugu cpi', 'cpi.paciente_contrato_parcelas_id = cp.paciente_contrato_parcelas_id', 'left');
            $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
            $this->db->where("pc.paciente_id", $paciente_id);
            $this->db->where("cpi.paciente_contrato_parcelas_id is null");
            $this->db->where("cp.ativo", 't');
            $this->db->where("pc.ativo", 't');
            $this->db->where("cp.excluido", 'f');
            $this->db->limit(1);
            $return2 = $this->db->get()->result();
            $credor = $return2[0]->financeiro_credor_devedor_id;
            $conta_id = $return2[0]->conta_id;
            $data = date("Y-m-d");

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $valor = $return[0]->valor;
//            var_dump($return);
//            die;
            $this->db->set('valor', $valor);
            $this->db->set('data', $data);
            $this->db->set('tipo', 'RECEBIMENTO');
            $this->db->set('classe', 'PAGAMENTO NA CLINICA');
            $this->db->set('nome', $credor);
            $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_entradas');
            $entradas_id = $this->db->insert_id();


            $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entradas_id);
            $this->db->set('conta', $conta_id);
            $this->db->set('nome', $credor);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $data);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');




            $this->db->set('pagamento_confirmado', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_fidelidade_id', $exames_fidelidade_id);
            $this->db->update('tb_exames_fidelidade');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluircontrato($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluircontratoadmin($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo_admin', 'f');
            $this->db->set('ativo', 'f');
            $this->db->set('excluido', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function ativarcontrato($paciente_id, $contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function parcelascontratojson($plano_id) {

        $teste = (int) $plano_id;

        $this->db->select('valor1, valor5 , valor6, valor10, valor11, valor12,valor23,valor24');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $teste);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirconsultaavulsa($consulta_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");

            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('excluido', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('consultas_avulsas_id', $consulta_id);
            $this->db->update('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterarobservacao($paciente_contrato_parcelas_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterarobservacaoavulsa($consulta_avulsa_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->where('consultas_avulsas_id', $consulta_avulsa_id);
            $this->db->update('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardatapagamento($paciente_contrato_parcelas_id) {
        try {

            $this->db->select('data_cartao_iugu');
            $this->db->from('tb_paciente_contrato_parcelas pc');
            $this->db->where("paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
            $this->db->orderby("data");
            $retorno_data = $this->db->get()->result();

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data']))));
            if (@$retorno_data[0]->data_cartao_iugu != '') {
                $this->db->set('data_cartao_iugu', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data']))));
            }
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardataconsultaavulsa($consulta_avulsa_id) {
        try {


            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data']))));

            $this->db->where('consultas_avulsas_id', $consulta_avulsa_id);
            $this->db->update('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarnovovalorparcela($paciente_contrato_parcelas_id, $valor, $observacao) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");

            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('valor', $valor);
            $this->db->set('observacao', $observacao);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardata($agenda_exames_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $dataautorizacao = $_POST['data'] . " " . $hora;
//            var_dump($dataautorizacao);
//            die;
            $sql = "UPDATE ponto.tb_agenda_exames
                    SET data_antiga = data
                    WHERE agenda_exames_id = $agenda_exames_id;";

            $this->db->query($sql);

//            $this->db->set('data_antiga', 'data');
            $this->db->set('data_aterardatafaturamento', $horario);
            $this->db->set('data_autorizacao', $dataautorizacao);
            $this->db->set('operador_aterardatafaturamento', $operador_id);
            $this->db->set('data', $_POST['data']);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentoconvenio() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor1', $_POST['valorafaturar']);
            $this->db->set('valor_total', $_POST['valorafaturar']);

            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentodetalhe() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('autorizacao', $_POST['autorizacao']);
            $this->db->set('observacoes', $_POST['txtobservacao']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('raca_cor', $_POST['raca_cor']);
            $this->db->where('paciente_id', $_POST['paciente_id']);
            $this->db->update('tb_paciente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarplano($paciente_id, $empresa_cadastro_id = NULL) {
        try {

            $ajuste = substr($_POST['checkboxvalor1'], 3, 5);
            $parcelas = substr($_POST['checkboxvalor1'], 0, 2);
            $parcelas = (int) $parcelas;

            $qtd_parcelas = $parcelas . " x " . $ajuste;


            if (@$empresa_cadastro_id != "") {
                $this->db->set('ativo', 'f');
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente_contrato');
            } else {
                
            }

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['nao_renovar'])) {
                $this->db->set('nao_renovar', 't');
            } else {
                $this->db->set('nao_renovar', 'f');
            }
            $this->db->set('paciente_id', $_POST['txtpaciente']);
            $this->db->set('plano_id', $_POST['plano']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('parcelas', $qtd_parcelas);

            if (@$_POST['forma_pagamento'] != "") {
                $this->db->set('forma_rendimento_id', @$_POST['forma_pagamento']);
            }
            if (@$_POST['vendedor_baixo'] != "") {
                $this->db->set('vendedor_id', @$_POST['vendedor_baixo']);
            }
            $this->db->insert('tb_paciente_contrato');
            $erro = $this->db->_error_message();




            $paciente_contrato_id = $this->db->insert_id();
            return $paciente_contrato_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarplanoparcelas($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('paciente_contrato_id, pc.plano_id, fp.taxa_adesao, valoradcional, fp.parcelas,pc.paciente_id,p.credor_devedor_id');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_paciente as p', 'p.paciente_id = pc.paciente_id');
        $this->db->where('pc.paciente_id', $paciente_id);
        $this->db->where('pc.ativo', 't');
        $query = $this->db->get();
        $return = $query->result();

//        echo '<pre>';
//        var_dump($_POST);
//        print_r($return);
//        die;

        @$paciente_contrato_id = $return[0]->paciente_contrato_id;
//        $ajuste = $return[0]->ajuste;
        $ajuste = substr($_POST['checkboxvalor1'], 3, 5);
        $parcelas = substr($_POST['checkboxvalor1'], 0, 2);

        $parcelas = (int) $parcelas;
        $mes = 1;
        $dia = $_POST['vencimentoparcela'];
        if ((int) $_POST['vencimentoparcela'] < 10) {
            $dia = str_replace('0', '', $dia);
            $dia = "0" . $dia;
        }

        $data_post = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['adesao'])));
        $data_adesao = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['adesao'])));
        $data_receber = date("Y-m-$dia", strtotime($data_post));
        if (date("d", strtotime($data_receber)) == '31') {
            $data_receber = date("Y-m-30", strtotime($data_receber));
        }
        $mes_atual = date("m");
        $ano_atual = date("Y");
        if (date("Y", strtotime($data_receber)) < '2000' && date("m", strtotime($data_receber)) == '12') {
            $data_receber = date("$ano_atual-$mes_atual-d", strtotime($data_receber));
        }
//        var_dump($dia); die;

        if ($data_receber < $data_post) {
            if (date("d", strtotime($data_receber)) == '30' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-2 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) $_POST['pularmes'] > 0) {
//            echo 'uhasuhdasd';
                    $quantidade_meses = (int) $_POST['pularmes'];
//           var_dump($data_receber); die;
                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 2;
            } elseif (date("d", strtotime($data_receber)) == '29' && date("m", strtotime($data_receber)) == '01') {
                $data_receber = date("Y-m-d", strtotime("-1 days", strtotime($data_receber)));
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) $_POST['pularmes'] > 0) {

                    $quantidade_meses = (int) $_POST['pularmes'];

                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 1;
            } else {
                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                if ((int) $_POST['pularmes'] > 0) {

                    $quantidade_meses = (int) $_POST['pularmes'];

                    $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
                }
                $b = 0;
            }
        } else {
            if ((int) $_POST['pularmes'] > 0) {

                $quantidade_meses = (int) $_POST['pularmes'];

                $data_receber = date("Y-m-d", strtotime("+$quantidade_meses month", strtotime($data_receber)));
            }
        }

//        echo '<pre>';
//        var_dump($_POST);
//        var_dump($data_adesao);
//        var_dump($data_receber);
//        die;




        if ($return[0]->credor_devedor_id == "") {


            $this->db->set('razao_social', $_POST['nome']);
            $this->db->set('cep', $_POST['cep']);
            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            } else {
                $this->db->set('cpf', null);
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['tipo_logradouro'] != '') {
                $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
            }
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
//        $horario = date("Y-m-d H:i:s");
//        $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $financeiro_credor_devedor_id = $this->db->insert_id();
        } else {
            $financeiro_credor_devedor_id = $return[0]->credor_devedor_id;
        }


        $data_atual = date("d/m/Y");
//        $data_adesao = date("Y-m-d");
//        echo '<pre>';
//        var_dump($return[0]->taxa_adesao); die;
        if ($return[0]->taxa_adesao == 't') {
            $forma_pagamento = $this->paciente->listaforma_pagamento($_POST['plano']);
            $valor_adesao =  $forma_pagamento[0]->valor_adesao;
            $this->db->set('taxa_adesao', 't');

            if ($valor_adesao >= 0) {
                $this->db->set('valor', $valor_adesao);
            } else {
                $this->db->set('valor', $ajuste);
            }

            if ($ajuste == 0.00) {
                $this->db->set('ativo', 'f');
                $this->db->set('manual', 't');
            }
            $this->db->set('parcela', 0);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->set('data', $data_adesao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_parcelas');
        }
 
        for ($i = 1; $i <= $parcelas; $i++) {
            $this->db->set('adesao_digitada', $_POST['adesao']);
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
            $this->db->set('operador_cadastro', $operador_id);
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
                    $this->db->set('operador_cadastro', $operador_id);
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
                    $this->db->set('operador_cadastro', $operador_id);
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
        if ($_POST['pessoajuridica'] == 'SIM') {
            $this->db->set('pessoa_juridica', 't');
        }



        $this->db->set('paciente_id', $_POST['paciente_id']);
        $this->db->set('paciente_contrato_id', $paciente_contrato_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_contrato_dependente');
//        $contrato_old_id = $this->db->insert_id();
        // Seleciono o ultimo contrato pra ver se tem algum dependente, caso haja, o sistema vai atualizar os dependentes 
        // para o novo contrato e calcular o valor da parcela para o valor correto.
        $this->db->select('paciente_contrato_id');
        $this->db->from('tb_paciente_contrato_dependente pcd');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('paciente_contrato_id !=', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $this->db->where('pessoa_juridica', 'f');
        $this->db->orderby('paciente_contrato_id desc');
        $query2 = $this->db->get();
        $return2 = $query2->result();

        if (count($return2) > 0) {
            $contrato_old_id = $return2[0]->paciente_contrato_id;

            $sql = "UPDATE ponto.tb_paciente_contrato_dependente
                SET paciente_contrato_id = $paciente_contrato_id
                 WHERE paciente_contrato_id = $contrato_old_id
                     AND paciente_id != {$_POST['paciente_id']}
                     ";
            $this->db->query($sql);

            $this->db->select('paciente_contrato_dependente_id');
            $this->db->from('tb_paciente_contrato_dependente');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->where('ativo', 't');
            $this->db->where('pessoa_juridica', 'f');
            $query = $this->db->get();
            $resultado = $query->result();

            $total = count($resultado);
            $total_limite = $return[0]->parcelas;
            $valor = $return[0]->valoradcional;



            if ($this->session->userdata('cadastro') == 2) {
                
            } else {
                if ($total > $total_limite) {
                    $valor_adicional = ($total - $total_limite) * $valor;
                    $sql2 = "UPDATE ponto.tb_paciente_contrato_parcelas
                SET valor = valor + '$valor_adicional'
                 WHERE paciente_contrato_id = $paciente_contrato_id ";
                    $this->db->query($sql2);
                }
            }
        }
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_id !=', $paciente_contrato_id);
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->update('tb_paciente_contrato_dependente');



        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
    }

    function gravarvalorplano($paciente_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $paciente_contrato_id = $_POST['paciente_contrato_id'];
            $ajuste = substr($_POST['checkboxvalor1'], 3, 5);
            $parcelas = substr($_POST['checkboxvalor1'], 0, 2);
//            var_dump($paciente_contrato_id );
//            echo '-----';
//            var_dump($ajuste);
//            echo '-----';
//            var_dump($parcelas );
//            echo '-----';
            $parcelas = (int) $parcelas;
            $mes = 1;
            $data_receber = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['adesao'])));
            for ($i = 1; $i <= $parcelas; $i++) {

                $this->db->set('valor', $ajuste);
                $this->db->set('parcela', $i);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data', $data_receber);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_parcelas');
                //$mes++;
                $data_receber = date("Y-m-d", strtotime("+$mes month", strtotime($data_receber)));
            }

            $this->db->set('paciente_id', $_POST['txtpaciente']);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_paciente_contrato_dependente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardependentes() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $paciente_contrato_id = $_POST['txtcontrato_id'];

            $this->db->select('paciente_contrato_id, plano_id');
            $this->db->from('tb_paciente_contrato');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->where('ativo', 't');
            $query = $this->db->get();
            $return = $query->result();

            $this->db->select('parcelas, valoradcional');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', @$return[0]->plano_id);
            $this->db->where('ativo', 't');
            $query = $this->db->get();
            $retorno = $query->result();

            $this->db->select('paciente_contrato_dependente_id');
            $this->db->from('tb_paciente_contrato_dependente');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->where('ativo', 't');
            $this->db->where('pessoa_juridica', 'f');
            $query = $this->db->get();
            $resultado = $query->result();
//            echo '<pre>';
//            var_dump($retorno);
//            die;

            $total = count($resultado);
            $valor = @$retorno[0]->valoradcional;

            if ($valor == "") {
                $valor = 0;
            }
//            var_dump($valor); die;
            if ($total < @$retorno[0]->parcelas) {

                $this->db->set('paciente_id', $_POST['dependente']);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_dependente');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
            }else {

                $this->db->set('paciente_id', $_POST['dependente']);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_dependente');

                if ($this->session->userdata('cadastro') == 2) {
                    
                } else {

                    $sql = "UPDATE ponto.tb_paciente_contrato_parcelas
                SET valor = valor + '$valor'
                 WHERE paciente_contrato_id = $paciente_contrato_id ";
                    $this->db->query($sql);
                }


//            $this->db->set('ativo', 'f');
//            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
//            $this->db->update('tb_paciente_contrato_parcelas');
            }


            $this->db->set('situacao', 'Dependente');
            $this->db->set('status', 'false');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id', $_POST['dependente']);
            $this->db->update('tb_paciente');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototal() {
        try {

            if ($_POST['ajuste1'] != "0") {
                $valor1 = $_POST['valorajuste1'];
            } else {
                $valor1 = $_POST['valor1'];
            }
            if ($_POST['ajuste2'] != "0") {
                $valor2 = $_POST['valorajuste2'];
            } else {
                $valor2 = $_POST['valor2'];
            }
            if ($_POST['ajuste3'] != "0") {
                $valor3 = $_POST['valorajuste3'];
            } else {
                $valor3 = $_POST['valor3'];
            }
            if ($_POST['ajuste4'] != "0") {
                $valor4 = $_POST['valorajuste4'];
            } else {
                $valor4 = $_POST['valor4'];
            }
            if ($_POST['ajuste1'] != "0" || $_POST['ajuste2'] != "0" || $_POST['ajuste3'] != "0" || $_POST['ajuste4'] != "0") {
                if ($_POST['valor1'] > $_POST['valorajuste1']) {
                    $desconto1 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto1 = $_POST['valorajuste1'] - $_POST['valor1'];
                }
                if ($_POST['valor2'] > $_POST['valorajuste2']) {
                    $desconto2 = $_POST['valor1'] - $_POST['valorajuste1'];
                } else {
                    $desconto2 = $_POST['valorajuste2'] - $_POST['valor2'];
                }
                if ($_POST['valor3'] > $_POST['valorajuste3']) {
                    $desconto3 = $_POST['valor3'] - $_POST['valorajuste3'];
                } else {
                    $desconto3 = $_POST['valorajuste3'] - $_POST['valor3'];
                }
                if ($_POST['valor4'] > $_POST['valorajuste4']) {
                    $desconto4 = $_POST['valor4'] - $_POST['valorajuste4'];
                } else {
                    $desconto4 = $_POST['valorajuste4'] - $_POST['valor4'];
                }

                $desconto = $desconto1 + $desconto2 + $desconto3 + $desconto4;
            } else {
                $desconto = $_POST['desconto'];
            }

//            $desconto = $_POST['desconto'];
//            $valor1 = $_POST['valor1'];
//            $valor2 = $_POST['valor2'];
//            $valor3 = $_POST['valor3'];
//            $valor4 = $_POST['valor4'];

            $juros = $_POST['juros'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

            $this->db->select('ae.agenda_exames_id, ae.valor_total, ae.guia_id, ae.paciente_id');
            $this->db->from('tb_agenda_exames ae');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("guia_id", $guia);
            $this->db->where('confirmado', 'true');
            $query = $this->db->get();
            $returno = $query->result();

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exames_id', $returno[0]->agenda_exames_id);
            $this->db->set('valor_total', $desconto);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];

            $id_juros = $returno[0]->agenda_exames_id;
            $valortotal_juros = $returno[0]->valor_total + $juros;
            $valortotal = 0;

            foreach ($returno as $value) {
                if ($value->valor_total >= $desconto) {
                    $valortotal = $value->valor_total - $desconto;
                    $desconto = 0;
                } else {
                    $valortotal = 0;
                    $desconto = $desconto - $value->valor_total;
                }
//            var_dump($desconto);
//            echo '-----';
//            var_dump($valortotal);
//            die;
                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                        $this->db->set('valor4', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas4', $_POST['parcela4']);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $valor3 = 0;
                    $i = 4;
                }
                if ($juros > 0) {
                    if ($_POST['formapamento1'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento1'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento1'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento1'] == 6) {
                        $formajuros = 6;
                    }
                    if ($_POST['formapamento2'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento2'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento2'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento2'] == 6) {
                        $formajuros = 6;
                    }

                    $this->db->set('forma_pagamento4', $formajuros);
                    $this->db->set('valor_total', $valortotal_juros);
                    $this->db->set('valor4', $juros);
                    $this->db->where('agenda_exames_id', $id_juros);
                    $this->db->update('tb_agenda_exames');
                }
                /* inicia o mapeamento no banco */
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalnaofaturado() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

//            var_dump($_POST['financeiro_grupo_id']);die;
            $this->db->select('ae.agenda_exames_id, ae.valor_total, ae.guia_id, ae.paciente_id');
            $this->db->from('tb_agenda_exames ae');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("fg.financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("guia_id", $guia);
            $this->db->where("faturado", 'f');
            $this->db->where('confirmado', 'true');
            $query = $this->db->get();
            $returno = $query->result();

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exames_id', $returno[0]->agenda_exames_id);
            $this->db->set('valor_total', $_POST['desconto']);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];
            $desconto = $_POST['desconto'];
            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];
            $juros = $_POST['juros'];
            $id_juros = $returno[0]->agenda_exames_id;
            $valortotal_juros = $returno[0]->valor_total + $juros;
            $valortotal = 0;


            foreach ($returno as $value) {

                if ($value->valor_total >= $desconto) {
                    $valortotal = $value->valor_total - $desconto;
                    $desconto = 0;
                } else {
                    $valortotal = 0;
                    $desconto = $desconto - $value->valor_total;
                }

                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                        $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                        $this->db->set('valor4', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas4', $_POST['parcela4']);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $valor3 = 0;
                    $i = 4;
                } elseif ($valor1 == 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                }
                if ($juros > 0) {
                    if ($_POST['formapamento1'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento1'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento1'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento1'] == 6) {
                        $formajuros = 6;
                    }
                    if ($_POST['formapamento2'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento2'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento2'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento2'] == 6) {
                        $formajuros = 6;
                    }

                    $this->db->set('forma_pagamento4', $formajuros);
                    $this->db->set('valor_total', $valortotal_juros);
                    $this->db->set('valor4', $juros);
                    $this->db->where('agenda_exames_id', $id_juros);
                    $this->db->update('tb_agenda_exames');
                }
                /* inicia o mapeamento no banco */
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalconvenio() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

            $this->db->select('agenda_exames_id, valor_total');
            $this->db->from('tb_agenda_exames');
            $this->db->where("guia_id", $guia);
            $query = $this->db->get();
            $returno = $query->result();

            foreach ($returno as $value) {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $value->valor_total));
                $this->db->set('data_faturamento', $horario);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('faturado', 't');
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function relatoriocaixaforma($formapagamento_id) {
//        var_dump($formapagamento_id);die;
        $this->db->select('ae.agenda_exames_id,
                            ae.valor1,
                            ae.parcelas1,
                            ae.forma_pagamento,
                            ae.valor2,
                            ae.parcelas2,
                            ae.forma_pagamento2,
                            ae.valor3,
                            ae.parcelas3,
                            ae.forma_pagamento3,
                            ae.valor4,
                            ae.parcelas4,
                            ae.forma_pagamento4');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.forma_pagamento', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento2', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento3', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento4', $formapagamento_id);
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.financeiro', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $return = $this->db->get();
        return $return->result();
    }

    function burcarcontasrecebertemp() {
        $this->db->select('distinct(data)');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function burcarcontasrecebertemp2($data) {
        $this->db->select('sum(valor)                           
                           valor,
                           devedor,
                           parcela,
                           observacao,
                           data_cadastro,
                           operador_cadastro,
                           entrada_id,
                           conta,
                           classe');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('data', $data);
        $this->db->where('ativo', 't');
        $this->db->groupby('devedor');
        $this->db->groupby('parcela');
        $this->db->groupby('observacao');
        $this->db->groupby('data_cadastro');
        $this->db->groupby('operador_cadastro');
        $this->db->groupby('entrada_id');
        $this->db->groupby('conta');
        $this->db->groupby('classe');
        $return = $this->db->get();
        return $return->result();
    }

    function fecharcaixa() {

//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $data_inicio = $_POST['data1'];
        $data_cauculo = substr($_POST['data1'], 6, 4) . "-" . substr($_POST['data1'], 3, 2) . "-" . substr($_POST['data1'], 0, 2);
        $data_fim = $_POST['data2'];
        $observacao = "Periodo de" . $_POST['data1'] . "a" . $_POST['data2'];
        $data = date("Y-m-d");
        $data30 = date('Y-m-d', strtotime("+30 days", strtotime($data_cauculo)));
        $data4 = date('Y-m-d', strtotime("+4 days", strtotime($data_cauculo)));
        $data2 = date('Y-m-d', strtotime("+2 days", strtotime($data_cauculo)));


        $this->db->select('forma_pagamento_id,
                            nome, 
                            conta_id, 
                            credor_devedor,
                            tempo_receber, 
                            dia_receber,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        $forma_pagamento = $return->result();

        $teste = $_POST['qtde'];
        $w = 0;
        foreach ($forma_pagamento as $value) {
            $classe = "CAIXA" . " " . $value->nome;
            $w++;
            $valor_total = (str_replace(".", "", $teste[$w]));
            $valor_total = (str_replace(",", ".", $valor_total));
            if ($valor_total != '0.00') {

                if (empty($value->nome) || empty($value->conta_id) || empty($value->credor_devedor) || empty($value->parcelas)) {
                    return 10;
                }

                if ((empty($value->tempo_receber) || $value->tempo_receber == 0) && (empty($value->dia_receber) || $value->dia_receber == 0)) {
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = date("Y-m-d");
                        $dia_atual = substr(date("Y-m-d"), 8);
                        $mes_atual = substr(date("Y-m-d"), 5, 2);
                        $ano_atual = substr(date("Y-m-d"), 0, 4);

                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixaforma($value->forma_pagamento_id);

                        foreach ($agenda_exames_id as $item) {
                            if ($item->forma_pagamento == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas1;
                                $valor = $item->valor1;
//                                    $retorno = $this->parcelas1($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento2 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas2;
                                $valor = $item->valor2;
//                                    $retorno = $this->parcelas2($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento3 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas3;
                                $valor = $item->valor3;
//                                    $retorno = $this->parcelas3($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento4 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas4;
                                $valor = $item->valor4;
//                                    $retorno = $this->parcelas4($item->agenda_exames_id);
                            }
                            $mes = 1;

                            if ($parcelas > 1) {
                                $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);

                                if ($jurosporparcelas[0]->taxa_juros > 0) {
                                    $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                } else {
                                    $taxa_juros = 0;
                                }

                                $valor_com_juros = $valor + ($valor * ($taxa_juros / 100));
                                $valor_parcelado = $valor_com_juros / $parcelas;
                            } else {
                                $valor_parcelado = $valor;
                            }

                            if ($parcelas > 1) {
                                for ($i = 2; $i <= $parcelas; $i++) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$mes month", strtotime($data_receber)));

                                    $this->db->set('valor', $valor_parcelado);
                                    $this->db->set('devedor', $value->credor_devedor);
                                    $this->db->set('parcela', $i);
                                    $this->db->set('data', $data_receber_p);
                                    $this->db->set('classe', $classe);
                                    $this->db->set('conta', $value->conta_id);
                                    $this->db->set('observacao', $observacao);
                                    $this->db->set('data_cadastro', $horario);
                                    $this->db->set('operador_cadastro', $operador_id);
                                    $this->db->insert('tb_financeiro_contasreceber_temp');
                                    $mes++;
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }
                        }

                        $this->db->set('valor', $valor_n_parcelado);
                        $this->db->set('devedor', $value->credor_devedor);
                        $this->db->set('data', $data_receber);
                        $this->db->set('classe', $classe);
                        $this->db->set('conta', $value->conta_id);
                        $this->db->set('observacao', $observacao);
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_financeiro_contasreceber');

                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->insert('tb_financeiro_contasreceber');
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->update('tb_financeiro_contasreceber_temp');
                    } else {
                        if (isset($value->tempo_receber) && $value->tempo_receber > 0) {
                            $valor_n_parcelado = $valor_total;
                            $agenda_exames_id = $this->relatoriocaixaforma($value->forma_pagamento_id);

                            foreach ($agenda_exames_id as $item) {
                                if ($item->forma_pagamento == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas1;
                                    $valor = $item->valor1;
//                                    $retorno = $this->parcelas1($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento2 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas2;
                                    $valor = $item->valor2;
//                                    $retorno = $this->parcelas2($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento3 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas3;
                                    $valor = $item->valor3;
//                                    $retorno = $this->parcelas3($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento4 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas4;
                                    $valor = $item->valor4;
//                                    $retorno = $this->parcelas4($item->agenda_exames_id);
                                }

                                if ($parcelas > 1) {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);

                                    if ($jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $valor_com_juros = $valor + ($valor * ($taxa_juros / 100));
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }

                                $tempo_receber = $value->tempo_receber;
                                if ($parcelas > 1) {
                                    for ($i = 2; $i <= $parcelas; $i++) {
                                        $tempo_receber = $tempo_receber + $value->tempo_receber;
                                        $data_atual = date("Y-m-d");
                                        $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));

                                        $this->db->set('valor', $valor_parcelado);
                                        $this->db->set('devedor', $value->credor_devedor);
                                        $this->db->set('parcela', $i);
                                        $this->db->set('data', $data_receber_p);
                                        $this->db->set('classe', $classe);
                                        $this->db->set('conta', $value->conta_id);
                                        $this->db->set('observacao', $observacao);
                                        $this->db->set('data_cadastro', $horario);
                                        $this->db->set('operador_cadastro', $operador_id);
                                        $this->db->insert('tb_financeiro_contasreceber_temp');
                                    }
                                    $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                                }
                            }
                            $data_atual = date("Y-m-d");
                            $data_receber = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));

                            $this->db->set('valor', $valor_n_parcelado);
                            $this->db->set('devedor', $value->credor_devedor);
                            $this->db->set('data', $data_receber);
                            $this->db->set('classe', $classe);
                            $this->db->set('conta', $value->conta_id);
                            $this->db->set('observacao', $observacao);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_financeiro_contasreceber');

                            $receber_temp = $this->burcarcontasrecebertemp();
                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('observacao', $receber_temp2[0]->observacao);
                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                                $this->db->insert('tb_financeiro_contasreceber');
                            }
                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }



//            if ($_POST[$value->nome] != '0,00') {
//                if ($value->nome == 'dinheiro' || $value->nome == 'DINHEIRO') {
//                    $this->db->set('data', $_POST['data1']);
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('nome', 14);
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_entradas');
//                    $entradas_id = $this->db->insert_id();
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('entrada_id', $entradas_id);
//                    $this->db->set('conta', 1);
//                    $this->db->set('nome', 14);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_saldo');
//                } elseif ($value->nome == 'cheque' || $value->nome == 'CHEQUE') {
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data4);
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                } elseif ($value->nome == 'DEBITO' || $value->nome == 'debito' || $value->nome == 'DÉBITO' || $value->nome == 'débito') {
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data4);
//                    $this->db->set('tipo', 'CAIXA DEBITO EM CONTA');
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                } else {
//                    $cartao[$value->nome] = str_replace(",", ".", str_replace(".", "", $_POST[$value->nome]));
////            $cartaovisa = $cartaovisa * 0.965;
//                    $cartao[$value->nome] = $cartao[$value->nome] * 1;
//                    $this->db->set('valor', $cartao[$value->nome]);
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data30);
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('conta', 6);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                }
//            }
        }

        if ($_POST['grupo'] == 0) {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND c.dinheiro = true 
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }

        if ($_POST['grupo'] == 1) {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND pt.grupo != 'RM'
AND c.dinheiro = true  
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }

        if ($_POST['grupo'] == "RM") {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario',financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND pt.grupo = 'RM'
AND c.dinheiro = true  
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }


//
//        if ($_POST['dinheiro'] != '0,00') {
//
//            $this->db->set('data', $_POST['data1']);
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['dinheiro'])));
//            $this->db->set('tipo', 'CAIXA DINHEIRO');
//            $this->db->set('nome', 14);
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_entradas');
//            $entradas_id = $this->db->insert_id();
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['dinheiro'])));
//            $this->db->set('entrada_id', $entradas_id);
//            $this->db->set('conta', 1);
//            $this->db->set('nome', 14);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_saldo');
//        }
//
//        if ($_POST['cheque'] != '0,00') {
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['cheque'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data4);
//            $this->db->set('tipo', 'CAIXA CHEQUE');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['debito'] != '0,00') {
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['debito'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data4);
//            $this->db->set('tipo', 'CAIXA DEBITO EM CONTA');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaovisa'] != '0,00') {
//            $cartaovisa = str_replace(",", ".", str_replace(".", "", $_POST['cartaovisa']));
////            $cartaovisa = $cartaovisa * 0.965;
//            $cartaovisa = $cartaovisa * 1;
//            $this->db->set('valor', $cartaovisa);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO VISA');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaocredito'] != '0,00') {
//            $cartaocredito = str_replace(",", ".", str_replace(".", "", $_POST['cartaocredito']));
////            $cartaovisa = $cartaovisa * 0.965;
//            $cartaocredito = $cartaocredito * 1;
//            $this->db->set('valor', $cartaocredito);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO CREDITO');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaomaster'] != '0,00') {
//            $cartaomaster = str_replace(",", ".", str_replace(".", "", $_POST['cartaomaster']));
////            $cartaomaster = $cartaomaster * 0.965;
//            $cartaomaster = $cartaomaster * 1;
//            $this->db->set('valor', $cartaomaster);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO MASTER');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaohiper'] != '0,00') {
//            $cartaohiper = str_replace(",", ".", str_replace(".", "", $_POST['cartaohiper']));
////            $cartaohiper = $cartaohiper * 0.965;
//            $cartaohiper = $cartaohiper * 1;
//            $this->db->set('valor', $cartaomaster);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO HIPER');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//        if ($_POST['outros'] != '0,00') {
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['outros'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data2);
//            $this->db->set('tipo', 'CAIXA OUTROS');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
    }

    function jurosporparcelas($formapagamento_id, $parcelas) {
        $this->db->select('taxa_juros');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('parcelas_inicio <=', $parcelas);
        $this->db->where('parcelas_fim >=', $parcelas);
        $query = $this->db->get();

        return $query->result();
    }

    function fecharmedico() {
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');


        $this->db->set('data', $data);
        $this->db->set('valor', $_POST['valor']);
        $this->db->set('tipo', $_POST['tipo']);
        $this->db->set('credor', $_POST['nome']);
        if ($_POST['conta'] != '') {
            $this->db->set('conta', $_POST['conta']);
        }
        $this->db->set('observacao', $_POST['observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_financeiro_contaspagar');
        $saida_id = $this->db->insert_id();
    }

    function listardados($convenio) {
        $this->db->select('nome,
                            dinheiro,
                            credor_devedor_id,
                            conta_id');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where("convenio_id", $convenio);
        $return = $this->db->get();
        return $return->result();
    }

    function selecionarprocedimentos($procedimentos) {
        $this->db->select('nome');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("procedimento_tuss_id", $procedimentos);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresas() {

        $this->db->select('empresa_id,
            banco,
            razao_social,
            producaomedicadinheiro,
            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresassicov() {

        $this->db->select('*');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarclassificacao() {

        $this->db->select('tuss_classificacao_id,
            nome');
        $this->db->from('tb_tuss_classificacao');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentos() {

        $this->db->select('procedimento_tuss_id,
            nome');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo() {

        $this->db->select('ambulatorio_grupo_id,
            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresa($empresa_id = null) {

        $empresa_id = $this->session->userdata('empresa_id');
        if ($empresa_id == null) {
            $empresa_id = 1;
        }
        $this->db->select('e.razao_social,
                            e.logradouro,
                            e.numero,
                            e.nome,
                            e.banco,
                            e.email,
                            e.tipo_carencia,
                            e.telefone,
                            e.producaomedicadinheiro,
                            e.celular,
                            e.iugu_token,
                            e.titular_flag,
                            e.modelo_carteira,
                            m.nome as municipio,
                            e.bairro,
                            e.impressao_tipo,
                            e.usuario_epharma,
                            e.senha_epharma,
                            e.url_epharma,
                            e.codigo_plano,
                            e.client_id,
                            e.client_secret');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function verificasessoesabertas($procedimento_convenio_id, $paciente_id) {
        $this->db->select('pt.grupo,
                            c.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_convenio_id);
        $return = $this->db->get();
        $x = $return->result();
        $especialidade = $x[0]->grupo;

//        var_dump($x); die;

        if ($x[0]->nome != 'PARTICULAR') {
//            $this->db->select('confirmado , agenda_exames_id');
//            $this->db->from('tb_agenda_exames');
//            $this->db->where('tipo', $especialidade);
////            $this->db->where('tipo', 'FISIOTERAPIA');
//            $this->db->where('ativo', 'false');
//            $this->db->where('numero_sessao >=', '1');
//            $this->db->where('realizada', 'false');
//            $this->db->where('confirmado', 'false');
//            $this->db->where('cancelada', 'false');
//            $return = $this->db->get();
//            $result = $return->result();

            $data = date("Y-m-d");
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.numero_sessao,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.grupo ,
                            al.situacao as situacaolaudo');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
            $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
            $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
            $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
            $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.numero_sessao');
            $this->db->where('ae.empresa_id', $empresa_id);
            $this->db->where('ae.paciente_id', $paciente_id);
//            $this->db->where('ae.tipo ', $especialidade);
            $this->db->where('pt.grupo ', $especialidade);
            $this->db->where('ae.ativo', 'false');
            $this->db->where('ae.numero_sessao >=', '1');
            $this->db->where('ae.realizada', 'false');
            $this->db->where('ae.confirmado', 'false');
            $this->db->where('ae.cancelada', 'false');
            $return = $this->db->get();
            $result = $return->result();


//            $contador = 0;
//            foreach ($result as $item) {
//                $data_atual = date('Y-m-d');
//                $data1 = new DateTime($data_atual);
//                $data2 = new DateTime($item->data);
//                $intervalo = $data1->diff($data2);
//
//                if ($intervalo->d == 0) {
//                    $contador++;
//                }
//            }


            if (count($result) != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function gravarguia($paciente_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('data_criacao', $data);
        $this->db->set('convenio_id', $_POST['convenio1']);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gerarnumeroNSA() {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_sicov_caixa');
        $sicov_caixa_id = $this->db->insert_id();
        return $sicov_caixa_id;
    }

    function gravarorcamento($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_criacao', $data);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_orcamento');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gravarmedico($crm) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('conselho', $crm);
        $this->db->set('nome', $_POST['medico1']);
        $this->db->set('medico', 't');
        $this->db->insert('tb_operador');
        $medico_id = $this->db->insert_id();
        return $medico_id;
    }

    function gravarexames($ambulatorio_guia_id, $medico_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
                ;
            }
            if ($_POST['data'] != "") {
                $this->db->set('data_entrega', $_POST['data']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valortotal);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('medico_solicitante', $medico_id);

            $this->db->set('data', $data);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }

            $this->db->select('ae.agenda_exames_id,
                            ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            ae.agenda_exames_id,
                            ae.inicio,
                            c.nome as convenio,
                            ae.operador_autorizacao,
                            o.nome as tecnico,
                            ae.data_autorizacao,
                            pt.nome as procedimento,
                            pt.codigo,
                            ae.guia_id,
                            pt.grupo,
                            pc.procedimento_tuss_id');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
            $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
            $query = $this->db->get();
            $return = $query->result();


            $grupo = $return[0]->grupo;
            if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
                $grupo = 'CR';
            }
            if ($grupo == 'RM') {
                $grupo = 'MR';
            }

            $this->db->set('wkl_aetitle', "AETITLE");
            $this->db->set('wkl_procstep_startdate', str_replace("-", "", date("Y-m-d")));
            $this->db->set('wkl_procstep_starttime', str_replace(":", "", date("H:i:s")));
            $this->db->set('wkl_modality', $grupo);
            $this->db->set('wkl_perfphysname', $return[0]->tecnico);
            $this->db->set('wkl_procstep_descr', $return[0]->procedimento);
            $this->db->set('wkl_procstep_id', $return[0]->codigo);
            $this->db->set('wkl_reqprocid', $return[0]->codigo);
            $this->db->set('wkl_reqprocdescr', $return[0]->procedimento);
            $this->db->set('wkl_studyinstuid', $agenda_exames_id);
            $this->db->set('wkl_accnumber', $agenda_exames_id);
            $this->db->set('wkl_reqphysician', $return[0]->convenio);
            $this->db->set('wkl_patientid', $return[0]->paciente_id);
            $this->db->set('wkl_patientname', $return[0]->paciente);
            $this->db->set('wkl_patientbirthdate', str_replace("-", "", $return[0]->nascimento));
            $this->db->set('wkl_patientsex', $return[0]->sexo);
            $this->db->set('wkl_exame_id', $agenda_exames_id);

            $this->db->insert('tb_integracao');


            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function verificaexamemedicamento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function gravaratendimemto($ambulatorio_guia_id, $medico_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        die;
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                if ($medico_id != "") {
                    $this->db->set('medico_solicitante', $medico_id);
                    $this->db->set('tipo', 'EXAME');
                } else {
                    $this->db->set('tipo', 'CONSULTA');
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $_POST['valor1']);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarorcamentoitem($ambulatorio_orcamento_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);

            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', $data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_orcamento_item');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }
            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarnovocontratoanual($paciente_contrato_id) {
        try {

            $this->db->select('p.*');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
            $this->db->where('pc.ativo', 't');
            $this->db->where('pc.paciente_contrato_id', $paciente_contrato_id);
            $verificar_contrato = $this->db->get()->result();



            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('pc.*');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
//            $this->db->where("pc.ativo", 't');
            $this->db->orderby('pc.paciente_contrato_id');
            $return = $this->db->get()->result();


            $this->db->select('qtd_dias,valor12');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $return[0]->plano_id);

            $return_plano = $this->db->get()->result();

            $qtd_dias = $return_plano[0]->qtd_dias;

            if ($qtd_dias != "") {
                
            } else {
                $qtd_dias = 365;
            }

            $data_cadastro_contrato = $return[0]->data_cadastro;
            $nova_data_cadastro = date("Y-m-d", strtotime("$qtd_dias days", strtotime($data_cadastro_contrato)));
            //colocando no dia de hoje
            $partes = explode("-", $nova_data_cadastro);
            $ano = $partes[0];
            $mes = $partes[1];
            $dia = $partes[2];
            $nova_data_contrato_atual = date('Y') . "-" . $mes . "-" . $dia;

            $ajuste = substr($return[0]->parcelas, 4, 9);
            $parcelas = substr($return[0]->parcelas, 0, 2);
            $parcelas = (int) $parcelas;

            $this->db->select('pcp.*');
            $this->db->from('tb_paciente_contrato_parcelas pcp');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id');
            $this->db->where("pcp.paciente_contrato_id", $paciente_contrato_id);
            $this->db->where("pcp.taxa_adesao", 'f');
            $this->db->where('pcp.excluido', 'f');

            if ($parcelas == 0) {
                $this->db->where('pcp.parcela', 1);
            } else {
                $this->db->where('pcp.parcela <=', $parcelas);
            }
            $this->db->where('pc.ativo', 't');
            $this->db->orderby('pcp.paciente_contrato_parcelas_id desc');
            $return_parcelas = $this->db->get()->result();
//            echo $parcelas;
//            echo $ajuste;
//            echo "<br>";
//            echo $return_parcelas[0]->data;
//            die; 
            $this->db->set('paciente_id', $return[0]->paciente_id);
            $this->db->set('forma_rendimento_id', $return[0]->forma_rendimento_id);
            $this->db->set('plano_id', $return[0]->plano_id);
            $this->db->set('data_cadastro', $nova_data_contrato_atual);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('parcelas', $return[0]->parcelas);
            $this->db->set('pago_todos_iugu', $return[0]->pago_todos_iugu);
            $this->db->insert('tb_paciente_contrato');
            $paciente_contrato_novo_id = $this->db->insert_id();

            if ($verificar_contrato[0]->empresa_id != "" || $verificar_contrato[0]->empresa_id != NULL) {
                @$dia_menos_um = date('d') - 1;
                @$data_verificadora = date('Y-m-' . $dia_menos_um . '');
                $this->db->set('valor', 0.00);
                $this->db->set('parcela', null);
                $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
//            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
                $this->db->set('data', $data_verificadora);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('parcela_verificadora', 't');
                $this->db->insert('tb_paciente_contrato_parcelas');
            }




            @$data_receber = $return_parcelas[0]->data;

            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
//            foreach ($return_parcelas as $item) {

            $partes_parcela = explode("-", $data_receber);
            $ano_parcela = $partes_parcela[0];
            $mes_parcela = $partes_parcela[1];
            $dia_parcela = $partes_parcela[2];
            $nova_data_parcela_atual = date('Y') . "-" . $mes_parcela . "-" . $dia_parcela;


            $nova_data_parcela_atual = date("Y-m-d", strtotime("+1 month", strtotime($nova_data_contrato_atual)));

//            echo "<pre>";
//            print_r($return_parcelas); 
//            die;


            for ($i = 1; $i <= $parcelas; $i++) { 
                if ($ajuste == 0 || $ajuste == "") {
                    $this->db->set('valor', $return_plano[0]->valor12);
                } else {
                    $this->db->set('valor', $ajuste);
                }
                $this->db->set('parcela', $i);
                $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
                $this->db->set('data', $nova_data_parcela_atual);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_parcelas');  
                $nova_data_parcela_atual = date("Y-m-d", strtotime("+1 month", strtotime($nova_data_parcela_atual)));
            }

//            }

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->update('tb_paciente_contrato_dependente');

            $this->db->set('ativo', 'f');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->update('tb_paciente_contrato');

//            echo '<pre>';
//            var_dump($return);
//            die;

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsulta($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
                ;
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valortotal);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('data', $data);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapia($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    if ($index == 1) {
                        $this->db->set('valor1', $_POST['valor1']);
                    } else {
                        $this->db->set('valor1', 0);
                    }
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpsicologia($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $valortotal);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('tipo', 'PSICOLOGIA');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexamesfaturamento() {
        try {

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor1', $valortotal);
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('ativo', 'f');
            $this->db->set('realizada', 't');
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_solicitante', $_POST['medicoagenda']);
            }
            $this->db->set('faturado', 't');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $_POST['txtguia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', $_POST['txtdata']);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_realizacao', $horario);
            $this->db->set('operador_realizacao', $operador_id);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $agenda_exames_id = $this->db->insert_id();

            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('medico_realizador', $_POST['medicoagenda']);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('guia_id', $_POST['txtguia_id']);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_exames');
            $exames_id = $this->db->insert_id();

            if ($_POST['laudo'] == "on") {
                $this->db->set('empresa_id', $_POST['txtempresa']);
                $this->db->set('data', $_POST['txtdata']);
                $this->db->set('medico_parecer1', $_POST['medicoagenda']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_ambulatorio_laudo');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarexames() {
        try {

            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('guia_id', $_POST['guia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('medico_solicitante', $_POST['medico']);
            $this->db->set('data_editar', $horario);
            $this->db->set('operador_editar', $operador_id);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('sala_id', $_POST['sala1']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarexamesselect($ambulatorio_guia_id) {

        $this->db->select('ae.autorizacao,
                              ae.medico_solicitante,
                              ae.agenda_exames_nome_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.agenda_exames_id", $ambulatorio_guia_id);
        $query = $this->db->get();
        return $query->result();
    }

    function valorexames() {
        try {
            $exame_id = "";

            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $agenda_exames_id = $_POST['agenda_exames_id'];
            $this->db->select('exames_id');
            $this->db->from('tb_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $retorno = $this->db->count_all_results();

            if ($retorno > 0) {
                $agenda_exames_id = $_POST['agenda_exames_id'];
                $this->db->select('exames_id');
                $this->db->from('tb_exames');
                $this->db->where("agenda_exames_id", $agenda_exames_id);
                $query = $this->db->get();
                $return = $query->result();
                $exame_id = $return[0]->exames_id;
            }

            $dadosantigos = $this->listarvalor($agenda_exames_id);
            $this->db->set('editarforma_pagamento', $dadosantigos[0]->forma_pagamento);
            $this->db->set('editarquantidade', $dadosantigos[0]->quantidade);
            $this->db->set('editarprocedimento_tuss_id', $dadosantigos[0]->procedimento_tuss_id);
            $this->db->set('editarvalor_total', $dadosantigos[0]->valor_total);
            $this->db->set('operador_faturamentoantigo', $dadosantigos[0]->operador_faturamento);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('guia_id', $_POST['guia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('forma_pagamento', $_POST['formapamento']);
                $this->db->set('valor1', $valortotal);
                $this->db->set('forma_pagamento2', NULL);
                $this->db->set('valor2', 0);
                $this->db->set('forma_pagamento3', NULL);
                $this->db->set('valor3', 0);
                $this->db->set('forma_pagamento4', NULL);
                $this->db->set('valor4', 0);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
            } elseif ($_POST['formapamento'] == 0 && $dinheiro == "t") {
                $this->db->set('faturado', 'f');
                $this->db->set('forma_pagamento', NULL);
                $this->db->set('valor1', 0);
                $this->db->set('forma_pagamento2', NULL);
                $this->db->set('valor2', 0);
                $this->db->set('forma_pagamento3', NULL);
                $this->db->set('valor3', 0);
                $this->db->set('forma_pagamento4', NULL);
                $this->db->set('valor4', 0);
            }
            $this->db->set('data_editar', $horario);
            $this->db->set('operador_editar', $operador_id);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            if ($exame_id != "") {
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('exames_id', $exame_id);
                $this->db->update('tb_exames');

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('exame_id', $exame_id);
                $this->db->update('tb_ambulatorio_laudo');
            }



            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarvalor($agenda_exames_id) {
        $this->db->select('forma_pagamento,
                            quantidade,
                            operador_faturamento,
                            procedimento_tuss_id,
                            valor_total');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravareditarfichaxml($exames_id) {

        try {
            $p1 = $_POST['p1'];
            $p2 = $_POST['p2'];
            $p3 = $_POST['p3'];
            $p4 = $_POST['p4'];
            $p5 = $_POST['p5'];
            $p6 = $_POST['p6'];
            $p7 = $_POST['p7'];
            $p8 = $_POST['p8'];
            $p9 = $_POST['p9'];
            $p10 = $_POST['p10'];
            $p11 = $_POST['p11'];
            $p12 = $_POST['p12'];
            $p13 = $_POST['p13'];
            $p14 = $_POST['p14'];
            $p15 = $_POST['p15'];
            $p16 = $_POST['p16'];
            $p17 = $_POST['p17'];
            $p18 = $_POST['p18'];
            $p19 = $_POST['p19'];
            $p20 = $_POST['p20'];
            $peso = $_POST['txtpeso'];
            $txtp9 = $_POST['txtp9'];
            $txtp19 = $_POST['txtp19'];
            $txtp20 = $_POST['txtp20'];
            $obs = $_POST['obs'];

            $sql = "UPDATE ponto.tb_respostas_xml
                    set  peso = $peso , txtp9 = '$txtp9' , txtp19 = '$txtp19' , txtp20 = '$txtp20' , obs = '$obs',
                    perguntas_respostas = xmlelement (name perguntas ,xmlconcat (
                     xmlelement ( name  p1 , '$p1') , 
                     xmlelement ( name  p2 , '$p2') , 
                     xmlelement ( name  p3 , '$p3') , 
                     xmlelement ( name  p4 , '$p4') , 
                     xmlelement ( name  p5 , '$p5') ,
                     xmlelement ( name  p6 , '$p6') ,
                     xmlelement ( name  p7 , '$p7') ,
                     xmlelement ( name  p8 , '$p8') ,
                     xmlelement ( name  p9 , '$p9') ,
                     xmlelement ( name  p10 , '$p10') ,
                     xmlelement ( name  p11 , '$p11') ,
                     xmlelement ( name  p12 , '$p12') ,
                     xmlelement ( name  p13 , '$p13') ,
                     xmlelement ( name  p14 , '$p14') ,
                     xmlelement ( name  p15 , '$p15') ,
                     xmlelement ( name  p16 , '$p16') ,
                     xmlelement ( name  p17 , '$p17') ,
                     xmlelement ( name  p18 , '$p18') ,
                     xmlelement ( name  p19 , '$p19')  ,
                     xmlelement ( name  p20 , '$p20')
                     ))
                     WHERE agenda_exames_id = $exames_id;";


            $this->db->query($sql);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    function listarfichatexto($exames_id) {
        $this->db->select('agenda_exames_id, peso , txtp9 , txtp19 , txtp20, obs');
        $this->db->from('tb_respostas_xml');
        $this->db->where('agenda_exames_id', $exames_id);
        $return = $this->db->get();

        return $return->result();
    }

    function listarfichaxml($exames_id) {
        $this->load->dbutil();
        $query = $this->db->query("SELECT perguntas_respostas FROM ponto.tb_respostas_xml where agenda_exames_id = $exames_id");
        $config = array(
            'root' => 'root',
            'element' => 'element',
            'newline' => "\n",
            'tab' => "\t"
        );
        $return = $this->dbutil->xml_from_result($query, $config);
        return $return;
    }

    function gravarfichaxml($exames_id) {

        try {

            $teste = $this->listarfichatexto($exames_id);

            if (!isset($teste[0]->agenda_exames_id)) {

                $p1 = $_POST['p1'];
                $p2 = $_POST['p2'];
                $p3 = $_POST['p3'];
                $p4 = $_POST['p4'];
                $p5 = $_POST['p5'];
                $p6 = $_POST['p6'];
                $p7 = $_POST['p7'];
                $p8 = $_POST['p8'];
                $p9 = $_POST['p9'];
                $p10 = $_POST['p10'];
                $p11 = $_POST['p11'];
                $p12 = $_POST['p12'];
                $p13 = $_POST['p13'];
                $p14 = $_POST['p14'];
                $p15 = $_POST['p15'];
                $p16 = $_POST['p16'];
                $p17 = $_POST['p17'];
                $p18 = $_POST['p18'];
                $p19 = $_POST['p19'];
                $p20 = $_POST['p20'];
                $peso = $_POST['txtpeso'];
                $txtp9 = $_POST['txtp9'];
                $txtp19 = $_POST['txtp19'];
                $txtp20 = $_POST['txtp20'];
                $obs = $_POST['obs'];

                $sql = "INSERT INTO ponto.tb_respostas_xml(agenda_exames_id, peso , txtp9 , txtp19 , txtp20 , obs,
                    perguntas_respostas )
                    VALUES ($exames_id, $peso , '$txtp9' ,'$txtp19','$txtp20'  , '$obs' , xmlelement (name perguntas ,xmlconcat (
                     xmlelement ( name  p1 , '$p1') , 
                     xmlelement ( name  p2 , '$p2') , 
                     xmlelement ( name  p3 , '$p3') , 
                     xmlelement ( name  p4 , '$p4') , 
                     xmlelement ( name  p5 , '$p5') ,
                     xmlelement ( name  p6 , '$p6') ,
                     xmlelement ( name  p7 , '$p7') ,
                     xmlelement ( name  p8 , '$p8') ,
                     xmlelement ( name  p9 , '$p9') ,
                     xmlelement ( name  p10 , '$p10') ,
                     xmlelement ( name  p11 , '$p11') ,
                     xmlelement ( name  p12 , '$p12') ,
                     xmlelement ( name  p13 , '$p13') ,
                     xmlelement ( name  p14 , '$p14') ,
                     xmlelement ( name  p15 , '$p15') ,
                     xmlelement ( name  p16 , '$p16') ,
                     xmlelement ( name  p17 , '$p17') ,
                     xmlelement ( name  p18 , '$p18'),
                     xmlelement ( name  p19 , '$p19')  ,
                     xmlelement ( name  p20 , '$p20')
                     )));";

                $this->db->query($sql);
                return true;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    private function instanciar($exame_sala_id) {

        if ($exame_sala_id != 0) {
            $this->db->select('exame_sala_id, nome');
            $this->db->from('tb_ambulatorio_guia');
            $this->db->where("exame_sala_id", $exame_sala_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_exame_sala_id = $exame_sala_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_exame_sala_id = null;
        }
    }

    function gerarsicovoptante() {
        $this->db->select('p.nome,
                            p.logradouro,
                            p.numero,
                            p.complemento,
                            p.bairro,
                            p.celular,
                            p.telefone,
                            p.cpf,
                            p.paciente_id,
                            p.telefone,
                            pcd.conta_agencia,
                            pcd.codigo_operacao,
                            pcd.conta_numero,
                            pcd.conta_digito,
                            pc.paciente_contrato_id');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_paciente_conta_debito pcd', 'p.paciente_id = pcd.paciente_id', 'left');
        $this->db->where('p.ativo', 'true');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pcd.ativo', 'true');
        $this->db->where('p.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('p.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('p.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function addimpressao($contrato_id = NULL, $paciente_id = NULL, $paciente_contrato_dependente_id = NULL) {

        $horario = date('Y-m-d H:i:s');

        $operador = $this->session->userdata('operador_id');
        $this->db->select('contador_impressao');
        $this->db->from('tb_paciente_contrato_dependente');
        $this->db->where('paciente_contrato_id', $contrato_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('ativo', 't');
        $returno = $this->db->get()->result();

        $valor_atual = $returno[0]->contador_impressao + 1;


        $this->db->where('paciente_contrato_dependente_id', $paciente_contrato_dependente_id);
        $this->db->set('contador_impressao', $valor_atual);
        $this->db->set('data_ultima_impressao', date('Y-m-d'));
        $this->db->set('ultimo_operador_impressao', $operador);
        $this->db->update('tb_paciente_contrato_dependente');


        $this->db->set('paciente_contrato_id', $contrato_id);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('operador_cadastro', $operador);
        $this->db->set('data_cadastro', $horario);

        $this->db->set('paciente_contrato_dependente_id', $paciente_contrato_dependente_id);

        $this->db->insert('tb_impressoes_contratro_dependente');
    }

    function listarcontrato($paciente_contrato_id = NULL) {

        $this->db->select('');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_contrato_id', @$paciente_contrato_id);
//        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function atualizarcontrato($paciente_id, $paciente_contrato_id) {
        $horario = date("Y-m-d H:i:s");
//        $this->db->select('');
//        $this->db->from('tb_paciente_contrato');
//        $this->db->where('paciente_contrato_id', $_POST['novo_numero']);
//        $return = $this->db->get()->result();
//
//        if ($return) {
//            return -1;
//        } else { 
        try {
//          $this->db->where('ativo', 't');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('data_cadastro', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_contrato']))));
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
            $this->db->update('tb_paciente_contrato');

//                $this->db->select('');
//                $this->db->from('tb_paciente_contrato_dependente');
//                $this->db->where('paciente_contrato_id', $paciente_contrato_id);
////                $this->db->where('ativo', 't');
//                $pendente_return = $this->db->get()->result();
//                if ($pendente_return) {
////                    $this->db->where('ativo', 't');
//                    $this->db->where('paciente_contrato_id', $paciente_contrato_id);
//                    $this->db->set('paciente_contrato_id', $_POST['novo_numero']);
//                    $this->db->set('data_atualizacao', $horario);
//                    $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
//                    $this->db->update('tb_paciente_contrato_dependente');
//                }
//                $this->db->select('');
//                $this->db->from('tb_paciente_contrato_parcelas');
//                $this->db->where('paciente_contrato_id', $paciente_contrato_id);
//                $this->db->where('ativo', 't');
//                $parcelar_return = $this->db->get()->result();
//                if ($parcelar_return) {
////                    $this->db->where('ativo', 't');
//                    $this->db->where('paciente_contrato_id', $paciente_contrato_id);
//                    $this->db->set('paciente_contrato_id', $_POST['novo_numero']);
//                    $this->db->set('data_atualizacao', $horario);
//                    $this->db->set('operador_atualizacao', $this->session->userdata('operador_id'));
//                    $this->db->update('tb_paciente_contrato_parcelas');
//                }

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
//        }
    }

    function listarcontas() {

        $this->db->select('');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 't');
        $this->db->order_by('forma_entradas_saida_id', 'desc');
        return $this->db->get()->result();
    }

    function alterardatapagamentoavulsa($consultas_avulsas_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data']))));
            $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
            $this->db->update('tb_consultas_avulsas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarnumpacelas($paciente_titular_id, $paciente_contrato_id = NULL, $dependente = NULL) {
        $data = date("Y-m-d");
        $this->db->select(' pcp.paciente_contrato_id,
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        if ($this->session->userdata('cadastro') == 2 && $dependente == true) {

            $this->db->where('pcp.paciente_dependente_id', $paciente_titular_id);
            $this->db->where('pc.paciente_contrato_id', $paciente_contrato_id);
        } else {
            $this->db->where("pc.paciente_id", $paciente_titular_id);
        }
        $this->db->where("pcp.data <=", $data);
        $this->db->where("pc.ativo", 't');
//        $this->db->where("pcp.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarparcelaspagas($paciente_titular_id, $paciente_contrato_id = NULL, $dependente = NULL) {
        $data = date("Y-m-d");
        $this->db->select(' pcp.paciente_contrato_id,
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');

        if ($this->session->userdata('cadastro') == 2 && $dependente == true) {

            $this->db->where('pcp.paciente_dependente_id', $paciente_titular_id);
            $this->db->where('pc.paciente_contrato_id', $paciente_contrato_id);
        } else {

            $this->db->where("pc.paciente_id", $paciente_titular_id);
        }

        $this->db->where("pcp.data <=", $data);
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.ativo", 'f');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientecarteirapadrao2($paciente_id = NULL) {

        $this->db->select('p.paciente_id,
                            p.nascimento,
                            p.situacao,
                            p.nome,
                            pc.data_cadastro,
                            fp.qtd_dias,
                            p.cpf');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("p.paciente_id", $paciente_id);
//        $this->db->where('pc.ativo','t');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacienteimportado($paciente_id = NULL) {
        try {
            $this->db->select("p.nome as paciente,p.paciente_id,cp.valor,cp.data,cp.ativo,cp.paciente_contrato_parcelas_id");
            $this->db->from("tb_paciente p");
            $this->db->join("tb_paciente_contrato pc", "pc.paciente_id = p.paciente_id", 'letf');
            $this->db->join("tb_paciente_contrato_parcelas cp", "cp.paciente_contrato_id = pc.paciente_contrato_id", 'letf');
            $this->db->where("pc.ativo", 't');
            $this->db->where("cp.ativo", 't');
            $this->db->where("p.paciente_id", $paciente_id);
            return $this->db->get()->result();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarparcelaconfirmarpagamentoimportada($paciente_id = NULL) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            pcp.parcela,
                            pcp.data,
                            pcp.financeiro_credor_devedor_id,
                            m.nome as municipio,
                            fcd.razao_social as credor,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            fp.conta_id,
                            pc.data_cadastro,
                            p.credor_devedor_id');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
//        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->where('p.paciente_id', $paciente_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('pcp.ativo', 't');
        $this->db->where('pcp.excluido', 'f');
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function confirmaparcelaimportada($paciente_id = NULL) {

        $parcelas = $this->listarparcelaconfirmarpagamentoimportada($paciente_id);
        
        foreach ($parcelas as $pacel) {
            @$valor = $pacel->valor;
            @$paciente_id = $pacel->paciente_id;
            $credor = $pacel->credor_devedor_id;             
            if (!$credor > 0) {
                $credor = $this->criarcredordevedorpaciente($paciente_id);
            }
            @$plano = $pacel->plano;
            @$data_parcela = $pacel->data;

            $this->db->select('forma_entradas_saida_id as conta_id,
                            descricao');
            $this->db->from('tb_forma_entradas_saida');
            $this->db->where('ativo', 'true');
            $this->db->where('conta_interna', 'true');
            $conta = $this->db->get()->result();

            if (count($conta) > 0) {
                $conta_id = $conta[0]->conta_id;
            } else {
                $conta_id = $pacel->conta_id;
            }

            $this->db->select('financeiro_maior_zero');
            $this->db->from('tb_empresa');
            $this->db->where('empresa_id', $this->session->userdata('empresa_id'));
            $return = $this->db->get()->result();
            if ($return[0]->financeiro_maior_zero == 't' && $valor <= 0) { //Caso a flag esteja ativada e valor seja menor ou igual a zero, ele não vai adiconar no financeiro, ira somente costar que está pago.
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('debito', 't');
                $this->db->set('ativo', 'f');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_contrato_parcelas_id', $pacel->paciente_contrato_parcelas_id);
                $this->db->update('tb_paciente_contrato_parcelas');
            } else {
                //gravando na entrada 
                $horario = date("Y-m-d H:i:s");
                $data = date("Y-m-d");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('valor', $valor);
//        $inicio = $_POST['inicio'];$data_parcela

                $this->db->set('data', $horario);
                $this->db->set('tipo', $plano);
                $this->db->set('classe', 'PARCELA');
                $this->db->set('nome', $credor);
//        Verificando se o usuario escolheu alguma conta, caso ele não tenha escolhido ele vai usar a do sistema que é a padrão
                if (@$_POST['conta'] != "") {
                    $this->db->set('conta', @$_POST['conta']);
                } else {
                    $this->db->set('conta', $conta_id);
                }
//        $this->db->set('observacao', $_POST['Observacao']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('paciente_contrato_parcelas_id', $pacel->paciente_contrato_parcelas_id);
                $this->db->insert('tb_entradas');
                $entradas_id = $this->db->insert_id();

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $this->db->set('valor', $valor);
                $this->db->set('entrada_id', $entradas_id);


                if (@$_POST['conta'] != "") {
                    $this->db->set('conta', @$_POST['conta']);
                } else {
                    $this->db->set('conta', $conta_id);
                }

                $this->db->set('nome', $credor);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('data', $data_parcela);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('paciente_contrato_parcelas_id', $pacel->paciente_contrato_parcelas_id);
                $this->db->insert('tb_saldo');

                /////////////////////////////////////////////////
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('debito', 't');
                $this->db->set('ativo', 'f');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_contrato_parcelas_id', $pacel->paciente_contrato_parcelas_id);
                $this->db->update('tb_paciente_contrato_parcelas');
            }
            break;
        }
    }

    function listarpacienteimportadopagos($paciente_id = NULL) {
        try {
            $this->db->select("p.nome as paciente,p.paciente_id,cp.valor,cp.data,cp.ativo,cp.paciente_contrato_parcelas_id");
            $this->db->from("tb_paciente p");
            $this->db->join("tb_paciente_contrato pc", "pc.paciente_id = p.paciente_id", 'letf');
            $this->db->join("tb_paciente_contrato_parcelas cp", "cp.paciente_contrato_id = pc.paciente_contrato_id", 'letf');
//        $this->db->where("pc.ativo",'f');
//        $this->db->where("cp.ativo",'t');
            $this->db->where("p.paciente_id", $paciente_id);
            return $this->db->get()->result();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function pagamentoiuguempresa($paciente_contrato_parcelas_id, $empresa_id) {


        $this->db->select('pc.paciente_contrato_id,pcp.paciente_contrato_parcelas_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id =  p.paciente_id');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id');
        $this->db->where('pcp.parcela_verificadora', 't');
        $this->db->where('p.empresa_id', $empresa_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $paciente_contrato = $this->db->get()->result();

        foreach ($paciente_contrato as $item) {
            $this->db->set('empresa_iugu', 't');
            $this->db->where('paciente_contrato_parcelas_id', $item->paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');
        }


        $this->db->set('empresa_iugu', 't');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
    }

    function cancelarparcela($paciente_id, $contrato_id, $paciente_contrato_parcelas_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('debito', 'f');
        $this->db->set('ativo', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');


        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_entradas');



        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_entradas');


        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_saldo');
    }

    function listarempresaporid($empresa_id = null) {
        $this->db->select('e.razao_social,
                            e.logradouro,
                            e.numero,
                            e.nome,
                            e.banco,
                            e.email,
                            e.tipo_carencia,
                            e.telefone,
                            e.producaomedicadinheiro,
                            e.celular,
                            e.iugu_token,
                            e.modelo_carteira,
                            m.nome as municipio,
                            e.bairro,
                            e.impressao_tipo');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('e.ativo', 't');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarnovocontratoanualdesativar($paciente_contrato_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('pc.*');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
//        $this->db->where("pc.ativo", 't');
            $this->db->orderby('pc.paciente_contrato_id');
            $return = $this->db->get()->result();


            $this->db->select('qtd_dias');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $return[0]->plano_id);

            $return_plano = $this->db->get()->result();

            $qtd_dias = $return_plano[0]->qtd_dias;

            if ($qtd_dias != "") {
                
            } else {
                $qtd_dias = 365;
            }

            $data_cadastro_contrato = $return[0]->data_cadastro;
            $nova_data_cadastro = date("Y-m-d", strtotime("$qtd_dias days", strtotime($data_cadastro_contrato)));

            $partes = explode("-", $nova_data_cadastro);
            $ano = $partes[0];
            $mes = $partes[1];
            $dia = $partes[2];
            $nova_data_contrato_atual = date('Y') . "-" . $mes . "-" . $dia;

            $this->db->select('pcp.*');
            $this->db->from('tb_paciente_contrato_parcelas pcp');
            $this->db->where("pcp.paciente_contrato_id", $paciente_contrato_id);
            $this->db->where("pcp.taxa_adesao", 'f');
            $this->db->orderby('pcp.paciente_contrato_parcelas_id desc');
            $return_parcelas = $this->db->get()->result();

//            $this->db->set('paciente_id', $return[0]->paciente_id);
//            $this->db->set('plano_id', $return[0]->plano_id);
//            $this->db->set('data_cadastro', $nova_data_contrato_atual);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_paciente_contrato');
//            $paciente_contrato_novo_id = $this->db->insert_id();


            $data_receber = $return_parcelas[0]->data;

            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));

//            foreach ($return_parcelas as $item) {
//
//                $this->db->set('valor', $item->valor);
//                $this->db->set('parcela', $item->parcela);
//                $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
//                $this->db->set('data', $data_receber);
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
//                $this->db->insert('tb_paciente_contrato_parcelas');
//                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
//            }
//            $this->db->set('data_atualizacao', $horario);
//            $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
//            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
//            $this->db->update('tb_paciente_contrato_dependente');

            $this->db->set('ativo', 'f');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->update('tb_paciente_contrato');


//            echo '<pre>';
//            var_dump($return);
//            die;

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluircontratoempresaadmin($contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo_admin', 'f');
            $this->db->set('ativo', 'f');
            $this->db->set('excluido', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluircontratoempresa($contrato_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function ativarcontratoempresa($contrato_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_id', $contrato_id);
            $this->db->update('tb_paciente_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarparcelacontratoempresa($paciente_contrato_id = NULL) {
   
        $operador_id = $this->session->userdata('operador_id');
        $horario = date('Y-m-d H:i:s');

        $empresa_cadastro_id = $_POST['empresa_id'];
        $this->db->select('afe.*,f.nome as plano,f.taxa_adesao,f.valor_adesao,afe.forma_pagamento_id');
        $this->db->from('tb_qtd_funcionarios_empresa afe');
        $this->db->join('tb_forma_pagamento f','f.forma_pagamento_id = afe.forma_pagamento_id','left');
        $this->db->where('afe.ativo', 't');
        $this->db->where('afe.empresa_id', $empresa_cadastro_id);
        $retorno = $this->db->get()->result();
      
        
      
        $funcionarios = $this->listarfuncionariosempresacadastro($_POST['empresa_id']);
        foreach($funcionarios as $value){
             $dependentes = $this->listardependentescontrato($value->paciente_contrato_id);
                 foreach($dependentes as $item2){
                     if($item2->situacao == "Dependente"){
                      @$valor_dependentes{$value->forma_pagamento_id} += $item2->valoradcional;
                     }
                 }
        }
      
        foreach ($retorno as $item) { 
            $ajuste = ($item->valor*$item->qtd_funcionarios)+ @$valor_dependentes{$item->forma_pagamento_id};
            $dia = (int) $_POST['vencimento'];            
            if ((int) $_POST['vencimento'] < 10) {
                 $dia = str_replace('0', '', $dia);
                 $dia = "0" . $dia;
             }           
            $qtd_parcela = (int)$item->parcelas;
            $data_receber = date("Y-m-").$dia;       
            
            if($item->taxa_adesao == "t"){  
              
                $this->db->set('taxa_adesao', 't');
                $this->db->set('valor', $ajuste);
                if ($ajuste == 0.00) {
                    $this->db->set('ativo', 'f');
                    $this->db->set('manual', 't');
                }
                $this->db->set('parcela', 0);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data', $data_receber);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('plano_id',$item->forma_pagamento_id);
                $this->db->insert('tb_paciente_contrato_parcelas');
            }
            
            for($i = 1; $i <=  $item->parcelas; $i++){
                $parcelas = (int) $parcelas;  
                if (date("d", strtotime($data_receber)) == '30' && date("m", strtotime($data_receber)) == '01') {
                      $data_receber = date("Y-m-d", strtotime("-2 days", strtotime($data_receber)));
                      $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                } elseif (date("d", strtotime($data_receber)) == '29' && date("m", strtotime($data_receber)) == '01') {
                    $data_receber = date("Y-m-d", strtotime("-1 days", strtotime($data_receber)));
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));                
                } else {
                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));   
                }          
                $this->db->set('valor', $ajuste);
                $this->db->set('parcela', $i);
                $this->db->set('paciente_contrato_id', $paciente_contrato_id);
                $this->db->set('data', $data_receber);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('plano_id',$item->forma_pagamento_id);
                $this->db->insert('tb_paciente_contrato_parcelas');
             
            }
        }
   
       
    }

    function gravarintegracaoiuguempresacadastro($url, $invoice_id, $paciente_contrato_parcelas_id, $empresa_id = NULL) {
        try {


            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//Processo onde é enviado o mesmo link de pagamento da empresa, para que quando a empresa pagar o boleto o paciente tambem ser liberado.
            $this->db->select('pc.paciente_contrato_id,pcp.paciente_contrato_parcelas_id');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id =  p.paciente_id');
            $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id');
            $this->db->where('pcp.parcela_verificadora', 't');
            $this->db->where('p.empresa_id', $empresa_id);
            $this->db->where('pc.ativo', 't');
            $this->db->where('p.ativo', 't');
            $paciente_contrato = $this->db->get()->result();




            foreach ($paciente_contrato as $item) {

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('url', $url);
                $this->db->set('invoice_id', $invoice_id);
                $this->db->set('paciente_contrato_parcelas_id', $item->paciente_contrato_parcelas_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', @$empresa_id);
                $this->db->insert('tb_paciente_contrato_parcelas_iugu');

                $this->db->set('data_cartao_iugu', null);
                $this->db->where('paciente_contrato_parcelas_id', $item->paciente_contrato_parcelas_id);
                $this->db->update('tb_paciente_contrato_parcelas');
            }
//fim do processo de enviar o link






            $this->db->set('data_cartao_iugu', null);
            $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->update('tb_paciente_contrato_parcelas');

            /* inicia o mapeamento no banco */

            $this->db->set('url', $url);
            $this->db->set('invoice_id', $invoice_id);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if (@$empresa_id != "") {
                $this->db->set('empresa_id', @$empresa_id);
            } else {
                
            }
            $this->db->insert('tb_paciente_contrato_parcelas_iugu');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function confirmarpagamentoautomaticoiuguempresa($paciente_contrato_parcelas_id,$boleto=NULL) {

        $this->db->select('forma_entradas_saida_id as conta_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $this->db->where('ativo', 'true');
        $this->db->where('conta_interna', 'true');
        $conta = $this->db->get()->result();
        $conta_id = $conta[0]->conta_id;


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $parcela = $this->listarparcelaconfirmarpagamentoempresa($paciente_contrato_parcelas_id);

        $valor = $parcela[0]->valor;
     
        $credor = $parcela[0]->credor_id;
        $empresa_cadastro_id = $parcela[0]->empresa_cadastro_id;
        if (!$credor > 0) {
            $credor = $this->criarcredordevedorempresa($empresa_cadastro_id);
        }
       
        $data = $parcela[0]->data;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        if($boleto == "true"){           
            $PAGA = "PAGA (Boleto Empresa)";
        }else{
            $PAGA = "PAGA (Manual Empresa)";  
        }        
        if ($data != null && $parcela[0]->empresa_cadastro_id != "") {
            $this->db->set('valor', $valor);
            $this->db->set('data', $data);
            $this->db->set('tipo', $PAGA);
            $this->db->set('classe', 'PARCELA');
            $this->db->set('nome', $credor);
            if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }
            $this->db->set('ativo', 't');
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_cadastro_id', $parcela[0]->empresa_cadastro_id);
            $this->db->set('nome_empresa_cadastro', $parcela[0]->empresa);
            $this->db->insert('tb_entradas');
            $entradas_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $this->db->set('valor', $valor);
            $this->db->set('entrada_id', $entradas_id);
              if (@$_POST['conta'] != "") {
                $this->db->set('conta', @$_POST['conta']);
            } else {
                $this->db->set('conta', $conta_id);
            }
            $this->db->set('nome', $credor);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $data);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('empresa_cadastro_id', $parcela[0]->empresa_cadastro_id);
            $this->db->insert('tb_saldo');
        }
        /////////////////////////////////////////////////
        $this->db->set('ativo', 'f');
        if($boleto == "true"){
            $this->db->set('empresa_iugu','t');
        }else{
            $this->db->set('manual', 't');
        }
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirparcelacontratoempresacadastro($parcela_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('excluido', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_contrato_parcelas_id', $parcela_id);
            $this->db->update('tb_paciente_contrato_parcelas');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarimpressoescarteira($paciente_contrato_dependente_id) {

        $this->db->select('id.data_cadastro, o.nome as operador_cadastro');
        $this->db->from('tb_impressoes_contratro_dependente id');
        $this->db->join('tb_operador o', 'o.operador_id = id.operador_cadastro', 'left');
        $this->db->where('id.paciente_contrato_dependente_id', $paciente_contrato_dependente_id);
        $this->db->where('id.ativo', 't');
        return $this->db->get()->result();
    }

    function gerarparcelaverificadora($empresa_id) {


        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('paciente_id');
        $this->db->from('tb_paciente');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $return1 = $this->db->get()->result();

        foreach ($return1 as $item) {
            $this->db->select('pc.paciente_contrato_id, pc.plano_id, fp.taxa_adesao, fp.valor_adesao,p.paciente_id');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
            $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id');
            $this->db->where('pc.paciente_id', $item->paciente_id);
            $this->db->where('pc.ativo', 't');
            $this->db->where('p.ativo', 't');
            $query = $this->db->get();
            $return = $query->result();

            if(date('d') > 1){
                 $dia_menos_um = date('d') - 1;          
            }else{
                 $dia_menos_um = date('d');
            }
           
            $data_verificadora = date('Y-m-' . $dia_menos_um . '');
//          echo $data_verificadora;die; 
            $this->db->set('valor', 0.00);
            $this->db->set('parcela', null);
            $this->db->set('paciente_contrato_id', $return[0]->paciente_contrato_id);
//            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->set('data', $data_verificadora);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('parcela_verificadora', 't');
            $this->db->insert('tb_paciente_contrato_parcelas');
        }
    }

    function listarcontratoativoempresa($empresa_id) {

        $this->db->select('pc.paciente_contrato_id,
                            fp.nome as plano,
                            pc.ativo,
                            cp.data,
                            fp.nome as plano,
                            pc.data_cadastro,
                            fp.qtd_dias
                            ');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas cp', 'cp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where("pc.empresa_cadastro_id", $empresa_id);
        $this->db->where("pc.ativo", 't');
        $this->db->orderby('cp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarnovocontratoanualempresa($paciente_contrato_id, $empresa_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');




            $valor_total = 0;
            $this->db->select('qf.qtd_funcionarios_empresa_id,qf.valor,qf.qtd_funcionarios,fp.nome as plano,qf.parcelas,qf.forma_pagamento_id');
            $this->db->from('tb_qtd_funcionarios_empresa qf');
            $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = qf.forma_pagamento_id', 'left');
            $this->db->where('qf.ativo', 't');
            $this->db->where('empresa_id', $empresa_id);
            $return2 = $this->db->get()->result();
            foreach ($return2 as $item) {
                $valor_total += $item->valor * $item->parcelas * $item->qtd_funcionarios;
            }






//            $this->db->select('pc.*');
//            $this->db->from('tb_paciente_contrato pc');
//            $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
//            $this->db->orderby('pc.paciente_contrato_id');
//            $return = $this->db->get()->result();
// 
            //BUSCANDO INFORMAÇÕES PARA CRIAR O NOVO CONTRATO.
            $this->db->select('pcp.*,pc.data_cadastro as data_cadastro_contrato');
            $this->db->from('tb_paciente_contrato_parcelas pcp');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id');
            $this->db->where("pcp.paciente_contrato_id", $paciente_contrato_id);
            $this->db->where("pcp.taxa_adesao", 'f');
            $this->db->where('pcp.excluido', 'f');
            $this->db->where('pc.ativo', 't');
            $this->db->orderby('pcp.paciente_contrato_parcelas_id desc');
            $return_parcelas = $this->db->get()->result();

            @$qtd_dias = 365;

            $data_cadastro_contrato = $return_parcelas[0]->data_cadastro_contrato;
            $nova_data_cadastro = date("Y-m-d", strtotime("$qtd_dias days", strtotime($data_cadastro_contrato)));
            //colocando no dia de hoje
            $partes = explode("-", $nova_data_cadastro);
            $ano = $partes[0];
            $mes = $partes[1];
            $dia = $partes[2];
            $nova_data_contrato_atual = date('Y') . "-" . $mes . "-" . $dia;

            //CRIANDO O NOVO CONTRATO
            $this->db->set('data_cadastro', $nova_data_contrato_atual);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_cadastro_id', $empresa_id);
            $this->db->insert('tb_paciente_contrato');
            $paciente_contrato_novo_id = $this->db->insert_id();

            $data_receber = $return_parcelas[0]->data;
//            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
            $data_receber = date("Y-m-d", strtotime($data_receber));

            $partes_parcela = explode("-", $data_receber);
            $ano_parcela = $partes_parcela[0];
            $mes_parcela = $partes_parcela[1];
            $dia_parcela = $partes_parcela[2];
            $nova_data_parcela_atual = date('Y') . "-" . $mes_parcela . "-" . $dia_parcela;

            for ($i = 1; $i <= 1; $i++) {
                //CRIANDO UMA PARCELA PARA O CONTRATO RENOVADO
                $this->db->set('valor', $valor_total);
                $this->db->set('parcela', 1);
                $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
                $this->db->set('data', $nova_data_parcela_atual);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_contrato_parcelas');
                $nova_data_parcela_atual = date("Y-m-d", strtotime("+1 month", strtotime($nova_data_parcela_atual)));
            }


            $this->db->set('data_atualizacao', $horario);
            $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->where('ativo', 't');
            $this->db->update('tb_paciente_contrato_dependente');

            $this->db->set('ativo', 'f');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->update('tb_paciente_contrato');

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarnovocontratoanualdesativarempresa($paciente_contrato_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('pc.*');
            $this->db->from('tb_paciente_contrato pc');
            $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
//        $this->db->where("pc.ativo", 't');
            $this->db->orderby('pc.paciente_contrato_id');
            $return = $this->db->get()->result();


            $this->db->select('qtd_dias');
            $this->db->from('tb_forma_pagamento');
            $this->db->where('forma_pagamento_id', $return[0]->plano_id);

            $return_plano = $this->db->get()->result();

            $qtd_dias = $return_plano[0]->qtd_dias;

            if ($qtd_dias != "") {
                
            } else {
                $qtd_dias = 365;
            }

            $data_cadastro_contrato = $return[0]->data_cadastro;
            $nova_data_cadastro = date("Y-m-d", strtotime("$qtd_dias days", strtotime($data_cadastro_contrato)));

            $partes = explode("-", $nova_data_cadastro);
            $ano = $partes[0];
            $mes = $partes[1];
            $dia = $partes[2];
            $nova_data_contrato_atual = date('Y') . "-" . $mes . "-" . $dia;

            $this->db->select('pcp.*');
            $this->db->from('tb_paciente_contrato_parcelas pcp');
            $this->db->where("pcp.paciente_contrato_id", $paciente_contrato_id);
            $this->db->where("pcp.taxa_adesao", 'f');
            $this->db->orderby('pcp.paciente_contrato_parcelas_id desc');
            $return_parcelas = $this->db->get()->result();

//            $this->db->set('paciente_id', $return[0]->paciente_id);
//            $this->db->set('plano_id', $return[0]->plano_id);
//            $this->db->set('data_cadastro', $nova_data_contrato_atual);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_paciente_contrato');
//            $paciente_contrato_novo_id = $this->db->insert_id();


            $data_receber = $return_parcelas[0]->data;

            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));

//            foreach ($return_parcelas as $item) {
//
//                $this->db->set('valor', $item->valor);
//                $this->db->set('parcela', $item->parcela);
//                $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
//                $this->db->set('data', $data_receber);
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
//                $this->db->insert('tb_paciente_contrato_parcelas');
//                $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
//            }
//            $this->db->set('data_atualizacao', $horario);
//            $this->db->set('paciente_contrato_id', $paciente_contrato_novo_id);
//            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
//            $this->db->update('tb_paciente_contrato_dependente');

            $this->db->set('ativo', 'f');
            $this->db->where('paciente_contrato_id', $paciente_contrato_id);
            $this->db->update('tb_paciente_contrato');


//            echo '<pre>';
//            var_dump($return);
//            die;

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function verificarempresaplano($empresa_cadastro_id, $plano_id) {
        $this->db->select('');
        $this->db->from('tb_qtd_funcionarios_empresa');
        $this->db->where('ativo', 't');
        $this->db->where('forma_pagamento_id', $plano_id);
        $this->db->where('empresa_id', $empresa_cadastro_id);
        $verificar = $this->db->get()->result();



        $this->db->select('fp.forma_pagamento_id,pc.paciente_contrato_id,p.nome as paciente, fp.nome as forma_pagamento,p.paciente_id,fp.valor1,fp.valor6,fp.valor12,fp.valor5,fp.valor10,fp.valor11');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.empresa_id', $empresa_cadastro_id);
        $this->db->where('pc.plano_id', $plano_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('p.empresa_id is not null');
        $verificar_qtd = $this->db->get()->result();


        if (count($verificar) > 0 && ( count($verificar_qtd) < $verificar[0]->qtd_funcionarios )) {
            return 1;
        } else {
            return -1;
        }
    }

    function atualizarplanofuncionario($paciente_id) {

        $plano_id = $_POST['plano'];
        $horario = date('Y-m-d H:i:s');
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('pc.paciente_contrato_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.paciente_id', $paciente_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $retorno = $this->db->get()->result();

        $this->db->where('paciente_contrato_id', $retorno[0]->paciente_contrato_id);
        $this->db->set('plano_id', $plano_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->update('tb_paciente_contrato');
    }

    function listarparcelaconfirmarpagamentoempresa($paciente_contrato_parcelas_id) {

        $this->db->select('pc.paciente_contrato_id,
            pcp.paciente_contrato_parcelas_id,
                            pc.ativo,
                            p.logradouro,
                            p.numero,
                            p.bairro,
                            p.paciente_id,
                            p.telefone,
                            pcp.parcela,
                            pcp.data,
                            pcp.financeiro_credor_devedor_id,
                            m.nome as municipio,
                            fcd.razao_social as credor,
                            pcp.valor,
                            p.nome as paciente,
                            fp.nome as plano,
                            fp.conta_id,
                            pc.data_cadastro,
                            e.empresa_id,
                            e.nome as empresa,
                            pc.empresa_cadastro_id,
                            ec.financeiro_credor_devedor_id as credor_id
                            ');
        $this->db->from('tb_paciente_contrato_parcelas pcp');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_contrato_id = pcp.paciente_contrato_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = pcp.financeiro_credor_devedor_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = p.empresa_id', 'left');
        $this->db->join('tb_empresa_cadastro ec','ec.empresa_cadastro_id = pc.empresa_cadastro_id','left');
        $this->db->where("pcp.paciente_contrato_parcelas_id", $paciente_contrato_parcelas_id);
        $this->db->where('pcp.ativo', 't');
        $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function cancelarparcelaempresa($paciente_contrato_parcelas_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('debito', 'f');
        $this->db->set('ativo', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');


        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_entradas');



        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_entradas');

        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_saldo');
    }

    function verificarparcelaentrada($paciente_contrato_parcelas_id) {

        $this->db->select('');
        $this->db->from('tb_entradas');
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->where('ativo', 't');
        return $this->db->get()->result();
    }

    function funcionariosempresa($empresa_id) {

        $this->db->select('pc.paciente_contrato_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('empresa_id', $empresa_id);
        return $this->db->get()->result();
    }

    function confirmarparcelaverificadora($contrato_id) {
        $this->db->set('empresa_iugu', 't');
        $this->db->set('ativo', 'f');
        $this->db->where('paciente_contrato_id', $contrato_id);
        $this->db->update('tb_paciente_contrato_parcelas');
    }

    function listarpacientecarteirapadrao3($paciente_id = NULL) {
        $this->db->select('p.paciente_id,
                            p.nascimento,
                            p.situacao,
                            p.nome,
                            pc.data_cadastro,
                            fp.qtd_dias,
                            p.cpf,
                            fp.nome as plano,
                            p.rg,
                            p.empresa_id,
                            e.razao_social  as empresa_cadastro,
                            fp.nome_impressao');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = p.empresa_id', 'left');
        $this->db->where("p.paciente_id", $paciente_id);
        // $this->db->orderby('pcp.parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinforpaciente($paciente_id) {

        $this->db->select('p.credor_devedor_id,p.paciente_id');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = p.credor_devedor_id', 'left');
        $this->db->where('p.paciente_id', $paciente_id);
        return $this->db->get()->result();
    }

    function gravarintegracaogerencianet($charge_id, $paciente_contrato_parcelas_id, $link = NULL, $pdf = NULL, $status = NULL) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('link', @$link);
            $this->db->set('pdf', @$pdf);
            $this->db->set('status', @$status);
            $this->db->set('charge_id', $charge_id);
            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if (@$empresa_id != "") {
                $this->db->set('empresa_id', @$empresa_id);
            } else {
                
            }
            $this->db->insert('tb_paciente_contrato_parcelas_gerencianet');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();
            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atualizarintegracaogerencianet($charge_id, $paciente_contrato_parcelas_id, $link = NULL, $pdf = NULL, $status = NULL) {

        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('link', $link);
        $this->db->set('pdf', $pdf);
        $this->db->where('charge_id', "$charge_id");
        $this->db->set('status', $status);
//            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);

        $this->db->update('tb_paciente_contrato_parcelas_gerencianet');
    }

    function confirmarpagamentoautomaticogerencianet($paciente_contrato_parcelas_id) {

        $verificar_parcela_entrada = $this->verificarparcelaentrada($paciente_contrato_parcelas_id);

        if (count($verificar_parcela_entrada) >= 1) {
            return;
        } else {
            
        }

        $parcela = $this->listarparcelaconfirmarpagamento($paciente_contrato_parcelas_id);
//        var_dump($parcela); die;
        $valor = $parcela[0]->valor;

        $paciente_id = $parcela[0]->paciente_id;
        $credor = $parcela[0]->financeiro_credor_devedor_id;


        if (!$credor > 0) {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
        }
        $plano = $parcela[0]->plano;
        $data = $parcela[0]->data;
        $conta_id = $parcela[0]->conta_id;
        //gravando na entrada

        $horario = date("Y-m-d H:i:s");
//        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');



        $this->db->set('valor', $valor);
//      $inicio = $_POST['inicio'];
        $this->db->set('paciente_contrato_parcelas_id',$paciente_contrato_parcelas_id);
        $this->db->set('data', $data);
        $this->db->set('tipo', $plano);
        $this->db->set('classe', 'PARCELA');
        $this->db->set('nome', $credor);
        $this->db->set('conta', $conta_id);
//        $this->db->set('observacao', $_POST['Observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', 1);
        // Chamado #4009
        $this->db->insert('tb_entradas');
        $entradas_id = $this->db->insert_id();
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            $this->db->set('valor', $valor);
        $this->db->set('entrada_id', $entradas_id);
        $this->db->set('conta', $conta_id);
        $this->db->set('nome', $credor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('operador_cadastro', 1);
        $this->db->insert('tb_saldo');



        /////////////////////////////////////////////////
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarintegracaogerencianetconsultaavulsaalterardata($charge_id, $consultas_avulsas_id, $link, $pdf) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('charge_id_GN', $charge_id);
            $this->db->set('link_GN', $link);
            $this->db->set('pdf_GN', $pdf);
            $this->db->where('consultas_avulsas_id', $consultas_avulsas_id);
            $this->db->update('tb_consultas_avulsas');

            /* inicia o mapeamento no banco */

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return @$ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarempresapermissoes($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select(' ');
        $this->db->from('tb_empresa e');
        if ($empresa_id == "") {
            
        } else {
            $this->db->where('e.empresa_id', $empresa_id);
        }
        $this->db->where('e.ativo', 't');

        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosverificar() {

        $this->db->select('pc.procedimento_convenio_id,
            pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id');
        $this->db->where('pt.ativo', 't');
        $this->db->where('pc.ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarverificados($cpf, $paciente_id, $nome) {

        if ($cpf == "" && $paciente_id == "" && $nome == "") {
            
        } else {

            $horario = date('Y-m-d H:i:s');
            $operador = $this->session->userdata('operador_id');

            $this->db->select('pc.procedimento_convenio_id,
            pt.nome,pc.autorizar_manual,
            pc.quantidade');
            $this->db->from('tb_procedimento_tuss pt');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id');
            $this->db->where('pt.ativo', 't');
            $this->db->where('pc.ativo', 't');
            $this->db->where('pc.procedimento_convenio_id', @$_POST['procedimento_convenio_id']);
            $this->db->orderby('nome');
            $manual = $this->db->get()->result();
            if (@$manual[0]->autorizar_manual == 't') {
                @$manualv = "sim";
            }

            $this->db->select('pc.paciente_contrato_id,tp.tipo_logradouro_id as codigo_logradouro,co.nome as nome_convenio, pc.plano_id, co.convenio_id as convenio,tp.descricao,p.*,c.estado, c.nome as cidade_desc,c.municipio_id as cidade_cod, codigo_ibge');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
            if ($cpf != "") {
                $this->db->where("cpf", $cpf);
            } elseif ($nome != "") {
                $this->db->where('p.nome ilike', "%" . $nome . "%");
            } else {
                $this->db->where("p.paciente_id", $paciente_id);
            }

            $this->db->where("p.ativo", 't');
            $this->db->where("pc.ativo", 't');
            $return = $this->db->get()->result();


            foreach ($return as $item) {

                $this->db->select('');
                $this->db->from('tb_paciente_verificados');
                $this->db->where("paciente_contrato_id", $item->paciente_contrato_id);
                $this->db->where('procedimento_convenio_id', @$_POST['procedimento_convenio_id']);
                $this->db->where('excluido', 'f');
                $verificarqtdusados = $this->db->get()->result();
                if (@count($verificarqtdusados) == @$manual[0]->quantidade) {
                    continue;
                }

                $this->db->select('o.nome as operador_ultima_impressao,p.nome, p.nascimento, p.paciente_id, situacao,contador_impressao,data_ultima_impressao,pcd.paciente_contrato_dependente_id');
                $this->db->from('tb_paciente p');
                $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
                $this->db->join('tb_operador o', 'o.operador_id = pcd.ultimo_operador_impressao', 'left');
                $this->db->where("pcd.paciente_contrato_id", $item->paciente_contrato_id);
                $this->db->where("pcd.ativo", "t");
                $this->db->order_by('situacao', 'desc');
                $return2 = $this->db->get()->result();
                $cotador = @count($verificarqtdusados);
//              echo $cotador;
//              die;
                foreach ($return2 as $value) {
                    $value->nome;
                    if ($value->nome != $item->nome) {
                        $titular_id = $item->paciente_id;
                    }
                    if ($value->nome != $item->nome) {


                        if ($manual[0]->quantidade <= $cotador) {
                            
                        } else {
                            //                        echo $value->nome."<br>";
                            $this->db->set('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
                            $this->db->set('titular_id', $titular_id);
                            $this->db->set('dependente', $value->paciente_id);
                            if (@$manualv == 'sim') {
                                $this->db->set('ativo', 'f');
                            } else {
                                $this->db->set('ativo', 't');
                            }
                            $this->db->set('excluido', 'f');
                            $this->db->set('paciente_contrato_id', $item->paciente_contrato_id);
                            $this->db->set('dependente', $value->paciente_id);
                            $this->db->set('financeiro_parceiro_id', $this->session->userdata('financeiro_parceiro_id'));
                            $this->db->set('data_cadastro', $horario);
                            if ($operador == "") {
                                $this->db->set('operador_cadastro', $operador);
                            }
                            $this->db->insert('tb_paciente_verificados');
                            @$cotador++;
                        }

//                        
                    }
                }
            }

//            die;
        }
    }

    function verficarsituacao($paciente_id) {
        $this->db->select('*');
        $this->db->from('tb_paciente_verificados');
        $this->db->where('excluido', null);
        $this->db->or_where('excluido', 'f');
        $this->db->where('dependente', $paciente_id);
        return $this->db->get()->result();
    }

    function listarinformacoes($paciente_id) {
        $this->db->select('pt.nome as procedimento,p.nome as paciente,pv.paciente_verificados_id as numero_autorizacao,pv.data_cadastro,fp.razao_social,pv.data_autorizacao_manual,o.nome as operador_autorizacao,fpa.nome as plano');
        $this->db->from('tb_paciente_verificados  pv');
        $this->db->join('tb_paciente p', 'p.paciente_id = pv.dependente', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pv.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = pv.financeiro_parceiro_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pv.operador_autorizacao_manual', 'left');
        $this->db->join('tb_paciente_contrato pac', 'pac.paciente_contrato_id = pv.paciente_contrato_id', 'left');
        $this->db->join('tb_forma_pagamento fpa', 'fpa.forma_pagamento_id = pac.plano_id', 'left');
        $this->db->where('pv.excluido', 'f');
        $this->db->where('pv.ativo', 't');
        $this->db->where('pv.dependente', $paciente_id);
        return $this->db->get()->result();
    }

    function listarparceiro($financeiro_parceiro_id) {

        $this->db->select('');
        $this->db->from('tb_financeiro_parceiro');
        if ($financeiro_parceiro_id != "") {
            $this->db->where('financeiro_parceiro_id', $financeiro_parceiro_id);
        }

        return $this->db->get()->result();
    }

    function listarautorizacao($args = array()) {
        $this->db->select('pv.data_cadastro,p.nome as paciente, pt.nome as procedimento,pv.paciente_verificados_id,fp.razao_social');
        $this->db->from('tb_paciente_verificados pv');
        $this->db->join('tb_paciente p', 'p.paciente_id = pv.dependente', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pv.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_financeiro_parceiro fp', 'fp.financeiro_parceiro_id = pv.financeiro_parceiro_id', 'left');
        $this->db->where('pv.ativo', 'f');
        $this->db->where('pv.excluido', 'f');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', '%' . $args['nome'] . '%');
        }
        return $this->db;
    }

    function autorizarprocedimento($paciente_verificados_id) {
        $horario = date('Y-m-d');
        $operador = $this->session->userdata('operador_id');
        $this->db->set('ativo', 't');
        $this->db->set('data_autorizacao_manual', $horario);
        $this->db->set('operador_autorizacao_manual', $operador);
        $this->db->where('paciente_verificados_id', $paciente_verificados_id);
        $this->db->update('tb_paciente_verificados');
    }

    function excluirautorizarprocedimento($paciente_verificados_id) {
        $horario = date('Y-m-d');
        $operador = $this->session->userdata('operador_id');
        $this->db->set('excluido', 't');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador);
        $this->db->where('paciente_verificados_id', $paciente_verificados_id);
        $this->db->update('tb_paciente_verificados');
    }

    function atualizarintegracaogerencianetcarne($charge_id, $paciente_contrato_parcelas_id, $link = NULL, $pdf = NULL, $link_carne, $cover_carne, $pdf_carne, $pdf_cover_carne, $carnet_id, $ci) {

        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('link', $link);
        $this->db->set('pdf', $pdf);
        $this->db->where('charge_id', "$charge_id");
//        $this->db->set('status', $status);
        $this->db->set('carne', 't');
        $this->db->set('link_carne', $link_carne);
        $this->db->set('cover_carne', $cover_carne);
        $this->db->set('pdf_carnet', $pdf_carne);
        $this->db->set('pdf_cover_carne', $pdf_cover_carne);
        $this->db->set('carnet_id', $carnet_id);
        $this->db->set('num_carne', $ci);


//            $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);

        $this->db->update('tb_paciente_contrato_parcelas_gerencianet');
    }

    function geraparcelasdependente($dependente_id, $paciente_contrato_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('*');
        $this->db->from('tb_paciente_contrato');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('ativo', 't');
        $res = $this->db->get()->result();

        $this->db->select('');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('forma_pagamento_id', $res[0]->plano_id);
        $plano = $this->db->get()->result();
        $ajuste = $plano[0]->valoradcional;

        $this->db->select('');
        $this->db->from('tb_paciente');
        $this->db->where('paciente_id', $dependente_id);
        $dadospaciente = $this->db->get()->result();
        $tirarx = str_replace("x", "", $res[0]->parcelas);
        $parcelas = substr($res[0]->parcelas, 0, 2);

 
        $parcelas = (int) $parcelas;
        $mes = 1;
 
 
        $this->db->select('');
        $this->db->from('tb_paciente_contrato_parcelas');
        $this->db->where('paciente_contrato_id', $paciente_contrato_id);
        $this->db->where('taxa_adesao', 'f');
        $this->db->where("(parcela_dependente = false or parcela_dependente is null)");
        $this->db->limit($parcelas);
//        $this->db->where("( (adesao_digitada is not null or adesao_digitada != '') or data_cadastro = '2019-05-10 00:00:00'  )");
        $this->db->where("(taxa_adesao = 'f')");
        $this->db->orderby('parcela', 'asc');
        $dados = $this->db->get()->result();

        $dia = substr($dados[0]->data, 8, 12);
        $adesao = $dados[0]->adesao_digitada;

        if ((int) $dia < 10) {
            $dia = str_replace('0', '', $dia);
            $dia = "0" . $dia;
        }

//        echo "<pre>";
//        print_r($dados);
//        print_r($res);
//        die;

        if ($dadospaciente[0]->credor_devedor_id == "") {
            $this->db->set('razao_social', $dadospaciente[0]->nome);
            $this->db->set('cep', $dadospaciente[0]->cep);
            if ($dadospaciente[0]->cpf != '' && $dadospaciente[0]->cpf != "NULL") {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $dadospaciente[0]->cpf)));
            } else {
                $this->db->set('cpf', null);
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $dadospaciente[0]->telefone))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $dadospaciente[0]->celular))));
            if ($dadospaciente[0]->tipo_logradouro != '') {
                $this->db->set('tipo_logradouro_id', $dadospaciente[0]->tipo_logradouro);
            }
            if ($dadospaciente[0]->municipio_id != '') {
                $this->db->set('municipio_id', $dadospaciente[0]->municipio_id);
            }
            $this->db->set('logradouro', $dadospaciente[0]->logradouro);
            $this->db->set('numero', $dadospaciente[0]->numero);
            $this->db->set('bairro', $dadospaciente[0]->bairro);
            $this->db->set('complemento', $dadospaciente[0]->complemento);

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->where('paciente_id', $dependente_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $financeiro_credor_devedor_id = $this->db->insert_id();

            $this->db->where('paciente_id', $dependente_id);
            $this->db->set('credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->update('tb_paciente');
        } else {
            $financeiro_credor_devedor_id = $dadospaciente[0]->credor_devedor_id;
        }

        $data_atual = date("d/m/Y");
//      echo $dadospaciente[0]->cpf;
//        echo  $financeiro_credor_devedor_id;
//        echo $dia;
//        echo "<pre>";
//        print_r($dados);
//        echo $financeiro_credor_devedor_id;
//        die;

        foreach ($dados as $item) {
            $this->db->set('valor', $ajuste);
            $this->db->set('parcela', $item->parcela);
            $this->db->set('paciente_contrato_id', $paciente_contrato_id);
            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->set('data', $item->data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('parcela_dependente', 't');
            $this->db->set('paciente_dependente_id', $dependente_id);
            $this->db->insert('tb_paciente_contrato_parcelas');
        }
    }

    function gravarobservacaocontrato($paciente_id) {


        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');
        $this->db->set('observacao', $_POST['observacao']);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador);
        $this->db->insert('tb_observacao_contrato');
    }

    function listarobservacaocadastro($paciente_id) {
        $this->db->select('oc.observacao,op.nome as operador,oc.data_cadastro,oc.observacao_contrato_id');
        $this->db->from('tb_observacao_contrato oc');
        $this->db->join('tb_operador op', 'op.operador_id = oc.operador_cadastro', 'left');
        $this->db->where('oc.paciente_id', $paciente_id);
        $this->db->where('oc.ativo', 't');
        return $this->db->get()->result();
    }

    function excluirobservacao($observacao_contrato_id) {
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('operador_id');

        $this->db->where('observacao_contrato_id', $observacao_contrato_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador);
        $this->db->set('ativo', 'f');
        $this->db->update('tb_observacao_contrato');
    }

    function listarparcelaspacientependente($paciente_contrato_id) {

        $this->db->select('
                            pcp.situacao,
                            pcp.ativo,
                            pcp.data,
                            pcp.parcela,
                            pcp.valor,
                            fp.nome as plano,
                            pc.data_cadastro');
        $this->db->from('tb_paciente_contrato pc');
        $this->db->join('tb_paciente_contrato_parcelas pcp', 'pcp.paciente_contrato_id = pc.paciente_contrato_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->where("pc.paciente_contrato_id", $paciente_contrato_id);
        $this->db->where("pcp.ativo", 't');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pcp.excluido", 'f');
        $this->db->orderby('pcp.data');
        $return = $this->db->get();
        return $return->result();
    }

    function verificarcredordevedorgeral($paciente_id) {
//        $this->db->select('p.credor_devedor_id,p.cpf,fcd.financeiro_credor_devedor_id,fcd.cpf as cpfcredor,p.paciente_id');
//        $this->db->from('tb_paciente p');
//        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.cpf = p.cpf');
//        $this->db->where("(p.cpf is not null and p.cpf != 'NULL')");
//        $this->db->where('p.paciente_id', $paciente_id);
//        $this->db->where('fcd.ativo','t');
//        $return = $this->db->get()->result();
//        if (count($return) == 1) {
//            $this->db->where('paciente_id', $paciente_id);
//            $this->db->set('credor_devedor_id', $return[0]->financeiro_credor_devedor_id);
//            $this->db->update('tb_paciente');
//            return;
//        }
        $this->db->select('p.credor_devedor_id,p.cpf');
        $this->db->from('tb_paciente p');
        $this->db->where('p.paciente_id', $paciente_id);
        $return2 = $this->db->get()->result();
        if ($return2[0]->credor_devedor_id == "" || $return2[0]->credor_devedor_id == 'null') {
            $credor = $this->criarcredordevedorpaciente($paciente_id);
            if ($credor != "") {
                $this->db->where('paciente_id', $paciente_id);
                $this->db->set('credor_devedor_id', $credor);
                $this->db->update('tb_paciente');
            }
        }
    }

    
    
    function confirmarenviohoje($paciente_contrato_parcelas_id){        
        $horario = date("Y-m-d");
        $data = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');      
        $this->db->set('data_envio_iugu', $horario);         
        $this->db->where('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->update('tb_paciente_contrato_parcelas');     
         
        $this->db->set('data_cadastro',$data);
        $this->db->set('operador_cadastro',$operador_id);
        $this->db->set('paciente_contrato_parcelas_id', $paciente_contrato_parcelas_id);
        $this->db->insert('tb_envio_iugu_card');
          
    }
    
    
    function relatorioprevisaorecebimento(){  
        if ($_POST['mes'] < 10) {
            $_POST['mes'] = str_replace('0', '', $_POST['mes'] );  
            $mes = "0".$_POST['mes'];  
        }else{
             $mes = $_POST['mes']; 
        } 
          $ano = date('Y');
          $sql = "SELECT pcp.ativo as paga,pcp.data,pcp.valor
          FROM ponto.tb_paciente_contrato_parcelas pcp 
          left join ponto.tb_paciente_contrato pc on pc.paciente_contrato_id = pcp.paciente_contrato_id 
          left join ponto.tb_paciente p on p.paciente_id = pc.paciente_id 
          WHERE EXTRACT('Month' From data) = $mes 
          AND EXTRACT('YEAR' From data) = $ano
          AND pcp.excluido = false
          AND pc.ativo = true
          AND p.ativo = true 
          AND pc.excluido = false";  
          return $this->db->query($sql)->result();  
    }
    
    function recebimentoconsultaavulsa() { 
        if ($_POST['mes'] < 10) {
          $_POST['mes'] = str_replace('0', '', $_POST['mes'] );
            $mes = "0".$_POST['mes'];  
        }else{
             $mes = $_POST['mes']; 
        } 
        $ano = date('Y');
        $sql = "SELECT cp.*,p.nome as paciente FROM ponto.tb_consultas_avulsas cp
                 left join ponto.tb_paciente p on p.paciente_id = cp.paciente_id 
                 left join ponto.tb_paciente_contrato pc on pc.paciente_id = p.paciente_id
                 WHERE EXTRACT('Month' From data) = $mes 
                 AND EXTRACT('YEAR' From data) = $ano
                 AND cp.excluido = false
                 AND tipo = 'EXTRA'
                 AND p.ativo = true 
                 AND pc.ativo = true 
                 AND pc.excluido = false"; 
        return $this->db->query($sql)->result();  
        
        
    }
    
      function recebimentoconsultacoop() { 
        if ($_POST['mes'] < 10) { 
            $_POST['mes'] = str_replace('0', '', $_POST['mes'] );  
            $mes = "0".$_POST['mes'];
        }else{
             $mes = $_POST['mes']; 
        }  
        $ano = date('Y');
        $sql = "SELECT cp.* FROM ponto.tb_consultas_avulsas cp
                left join ponto.tb_paciente p on p.paciente_id = cp.paciente_id 
                left join ponto.tb_paciente_contrato pc on pc.paciente_id = p.paciente_id
                WHERE EXTRACT('Month' From data) = $mes 
                AND EXTRACT('YEAR' From data) = $ano
                AND cp.excluido = false
                AND tipo = 'COOP' 
                AND p.ativo = true 
                AND pc.excluido = false 
                AND pc.ativo = true"; 
        return $this->db->query($sql)->result(); 
    }
    
    
    
    function listarplanos(){
        
        $this->db->select('');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo','t');
        return $this->db->get()->result();
        
    }
    
    
    
    
    
    function excluircontratodependente($paciente_id, $paciente_contrato_dependente_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
    
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('ativo', 't');
        $this->db->update('tb_paciente_contrato_dependente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }
    
    
    function relatorioparceiroverificar(){
        $this->db->select('pd.nome as dependente,p.nome as titular,fp.fantasia,pc.valortotal,pt.nome as procedimento');
        $this->db->from('tb_paciente_verificados pv');
        $this->db->join('tb_paciente pd','pd.paciente_id = pv.dependente','left');
        $this->db->join('tb_paciente p','p.paciente_id = pv.titular_id','left');
        $this->db->join('tb_procedimento_convenio pc','pc.procedimento_convenio_id = pv.procedimento_convenio_id','left');
        $this->db->join('tb_procedimento_tuss pt','pt.procedimento_tuss_id = pc.procedimento_tuss_id','left');
        $this->db->join('tb_financeiro_parceiro fp','fp.financeiro_parceiro_id =  pv.financeiro_parceiro_id','left');
        $this->db->where('pv.excluido','f');
        $this->db->where('pv.ativo','t');
        if($_POST['parceiro'] != "0"){
           $this->db->where('pv.financeiro_parceiro_id',$_POST['parceiro']);  
        }
        $this->db->where('pv.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where('pv.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
       $this->db->orderby('pd.nome');
        return $this->db->get()->result();
        
    }


    function relatoriovoucher(){
        $this->db->select('p.nome as paciente,
                            vc.data, vc.horario,
                            vc.data_cadastro,
                            vc.operador_cadastro, 
                            ca.valor,
                            pa.fantasia,
                            o.nome as operador,
                            vc.gratuito');
        $this->db->from('tb_voucher_consulta vc');
        $this->db->join('tb_consultas_avulsas ca','vc.consulta_avulsa_id = ca.consultas_avulsas_id','left');
        $this->db->join('tb_paciente p','p.paciente_id = ca.paciente_id','left');
        $this->db->join('tb_financeiro_parceiro pa','pa.financeiro_parceiro_id = vc.parceiro_id','left');
        $this->db->join('tb_operador o','o.operador_id = vc.operador_cadastro','left');
        $this->db->where('vc.ativo','t');
        $this->db->where('vc.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where('vc.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        
        if($_POST['parceiro_id'] != '0'){
            $this->db->where('vc.parceiro_id',$_POST['parceiro_id']);
        }

        if($_POST['confirmacao'] == 'SIM'){
            $this->db->where('vc.confirmado','t');
        }

        if($_POST['gratuito'] == 'SIM'){
            $this->db->where('vc.gratuito','t');
        }else if($_POST['gratuito'] == 'NAO'){
            $this->db->where("(vc.gratuito is null or vc.gratuito = 'f')"); 
        }else{
            
        }

        if($_POST['pagamento_id'] != '0'){
            $this->db->where('vc.rendimento_id',$_POST['pagamento_id']);
        }

        $this->db->orderby('vc.data_cadastro, paciente');
        return $this->db->get()->result();
        
    }
    
      function listarfuncionariosempresacadastro($empresa_id = NULL) {

        $this->db->select('fp.forma_pagamento_id,pc.paciente_contrato_id,p.nome as paciente, fp.nome as forma_pagamento,p.paciente_id,fp.valor1,fp.valor6,fp.valor12,fp.valor5,fp.valor10,fp.valor11');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato pc', 'pc.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = pc.plano_id', 'left');
        $this->db->where('p.empresa_id', $empresa_id);
        $this->db->where('pc.ativo', 't');
        $this->db->where('p.ativo', 't');
        $this->db->where('p.empresa_id is not null');
        $this->db->orderby('fp.nome,p.nome');
        return $this->db->get()->result();
    }
    
      function listardependentescontrato($contrato_id) {
        $this->db->select('o.nome as operador_ultima_impressao,p.nome, p.nascimento, p.paciente_id, situacao,contador_impressao,data_ultima_impressao,pcd.paciente_contrato_dependente_id,fp.valoradcional');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_contrato_dependente pcd', 'pcd.paciente_id = p.paciente_id', 'left');
        $this->db->join('tb_paciente_contrato pt','pt.paciente_contrato_id = pcd.paciente_contrato_id','left');
        $this->db->join('tb_forma_pagamento fp','fp.forma_pagamento_id = pt.plano_id','left');
        $this->db->join('tb_operador o', 'o.operador_id = pcd.ultimo_operador_impressao', 'left');
        $this->db->where("pcd.paciente_contrato_id", $contrato_id);
        $this->db->where("pcd.ativo", "t");
        $this->db->order_by('situacao', 'desc');
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function criarcredordevedorempresa($empresa_cadastro_id) {
        $this->db->select('*');
        $this->db->from('tb_empresa_cadastro');
        $this->db->where("empresa_cadastro_id", $empresa_cadastro_id);
        $return = $this->db->get()->result();
if($return[0]->financeiro_credor_devedor_id == ""){
        
            $this->db->set('razao_social', @$return[0]->nome);
            $this->db->set('cep', @$return[0]->cep);            
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", @$return[0]->telefone))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", @$return[0]->celular))));
            if (@$return[0]->municipio_id != '') {
                $this->db->set('municipio_id', $return[0]->municipio_id);
            }
            $this->db->set('logradouro', @$return[0]->logradouro);
            $this->db->set('numero', @$return[0]->numero);
            $this->db->set('bairro', @$return[0]->bairro);
            $this->db->set('complemento', @$return[0]->complemento);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_cadastro_id', $empresa_cadastro_id);
            $this->db->insert('tb_financeiro_credor_devedor');
            $financeiro_credor_devedor_id = $this->db->insert_id();

            $this->db->set('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->where("empresa_cadastro_id", $empresa_cadastro_id);
            $this->db->update('tb_empresa_cadastro');
            return $financeiro_credor_devedor_id;
}
    }
    
    
    function confirmarvoucher(){
        $horario = date('Y-m-d H:i:s');
        $operador = $this->session->userdata('financeiro_parceiro_id');        
        $this->db->set('confirmado','t');
        $this->db->set('parceiro_atualizacao',$operador);
        $this->db->set('data_atualizacao',$horario);
        $this->db->set('horario_uso',date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_uso'])))." 00:00:00");
        $this->db->set('rendimento_id', $_POST['pagamento_id']);
        $this->db->where('voucher_consulta_id',$_POST['voucher_consulta_id']);
        $this->db->update('tb_voucher_consulta');
        
    }
    
    
    function listarempresacadastro($empresa_cadastro_id = NULL ){
        $this->db->select('');
        $this->db->from('tb_empresa_cadastro');
        $this->db->where('ativo','t');
        if($empresa_cadastro_id != ""){
           $this->db->where('empresa_cadastro_id',$empresa_cadastro_id);
        }
        return $this->db->get()->result();
    }
    
    
    function relatorioparcelasempresa(){
         if ($_POST['mes'] < 10) {
            $_POST['mes'] = str_replace('0', '', $_POST['mes'] );  
            $mes = "0".$_POST['mes'];  
        }else{
             $mes = $_POST['mes']; 
        } 
        $empresa = $_POST['empresa_cadastro_id'];
          $ano = date('Y');
          $sql = "SELECT qf.*,p.nome as paciente,fp.nome as forma,pc.paciente_contrato_id,p.cpf
          FROM ponto.tb_qtd_funcionarios_empresa qf
          LEFT JOIN ponto.tb_paciente_contrato pc  ON qf.forma_pagamento_id = pc.plano_id
          LEFT JOIN ponto.tb_paciente p ON pc.paciente_id = p.paciente_id
          LEFT JOIN ponto.tb_forma_pagamento fp ON fp.forma_pagamento_id = qf.forma_pagamento_id
          WHERE qf.empresa_id = $empresa
          AND pc.ativo = 'true'
          AND qf.ativo = 'true'
          AND p.empresa_id = $empresa
          AND qf.ativo = 'true'
          ORDER BY fp.nome,p.nome ASC
            ";  
          return $this->db->query($sql)->result(); 
          
    }
    
    
    
    function listarpagamentofuncionariosempresa($paciente_id,$empresa_id,$plano_id){
        
          $sql = "SELECT qtd.*
          FROM ponto.tb_empresa_cadastro ec
          LEFT JOIN ponto.tb_paciente_contrato pc  ON ec.empresa_cadastro_id = pc.empresa_cadastro_id
          LEFT JOIN ponto.tb_paciente p ON p.empresa_id = ec.empresa_cadastro_id
       
          LEFT JOIN ponto.tb_qtd_funcionarios_empresa qtd ON qtd.empresa_id  = ec.empresa_cadastro_id
          WHERE ec.empresa_cadastro_id = $empresa_id  
          AND pc.ativo_admin = 'true'
          AND pc.ativo = 'true'
          AND p.paciente_id = $paciente_id
        
          AND qtd.ativo = 'true'
          AND qtd.forma_pagamento_id  = $plano_id
          
            ";  
          return $this->db->query($sql)->result(); 
          
    }
    
    
}

?>
