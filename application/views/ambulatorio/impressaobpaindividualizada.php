
<!--Calculando o controle do cabeçalho de acordo com o manual da BPA-->
<?
foreach ($listabpa as $item) {
    @$somar = $somar + $item->procedimento_tuss_id;
    @$resto = $somar % 111;
    @$q_controle = $resto + 111;
}
?>


<?
$totalregistros = count($listabpa);
//$totalregistrosfake = count($listabpa); //CONTADOR 'FAKE' PARA NÃO INTERFERIR NO CONTADOR DE REGISTROS NORMAL
//$contador_pagina = 1;
//while ($totalregistrosfake > 22) { // CONTANDO QUANTAS PAGINAS TEM NO PDF NO CASO EU GEREI MUITOS REGISTROS E VI ATÉ QUE LINHA
//    @$contador_pagina++;           // OS REGISTROS CHEGAVAM PARA PASSAR DE PAGINA
//    @$totalregistrosfake = $totalregistrosfake - 22; // AQUI ELE ELE DIMINUI POR 22 QUE É O TOTAL QUE UMA PAGINA AGUENTA(PRA NÃO ACUMULAR) 
//}
?>




<table>
    <tbody>
        <?
//        Criando o cabeçalho do pdf ou planilha
        
        foreach ($dadosempresa as $value) {
            ?>   
            <tr>
                <td><?
                    $data = date('Ym');
                    $tipo_registro = "01";
                    $nome_empresa_sigla = "";
                    $cpf_empresa = "";
                    $orgao_saude_empresa = "";
                    $orgao_indicador_destinatario = "M";
                    $contador_pagina = "";
//                     *(PREENCHER DIREITA) É UMA FUNCAO QUE VC PASSA O VALOR, DIZ QUANTOS CARACTERES VAI PEGAR DESSE VALOR 
//                         E O QUE QUER PREENCHER A DIREITA CASO NÃO TENHA O NUMERO DE CARACTERES SUFICIENTE.
//                     *(PREENCHER ESQUERDA) TEM A MESMA LOGICA, SÓ QUE VAI PRA ESQUEDA. É USADO MUITO QUANTO SE TRATA DE NUMEROS.
                    echo $BPA1 = $this->utilitario->preencherDireita("01", 2, " ");
                    echo $BPA = $this->utilitario->preencherDireita("#BPA#", 5, " ");
                    echo $ano_mes = $this->utilitario->preencherEsquerda($data, 6, " ");
                    echo $total = $this->utilitario->preencherEsquerda($totalregistros, 6, "0");
                    echo $q_paginas = $this->utilitario->preencherEsquerda($contador_pagina, 6, "0");
                    echo $cbc_smt_vrf = $this->utilitario->preencherEsquerda(@$q_controle, 4, "0");
                    echo $camp_cbc_rsp = $this->utilitario->preencherDireita($value->nome, 30, " ");
                    echo $camp_sigla_empresa = $this->utilitario->preencherDireita($nome_empresa_sigla, 6, " ");
                    echo $camp_cpf_empresa = $this->utilitario->preencherEsquerda($cpf_empresa, 14, "0");
                    echo $camp_orgao_saude = $this->utilitario->preencherDireita($orgao_saude_empresa, 40, " ");
                    echo $camp_indi_orgao = $this->utilitario->preencherDireita($orgao_indicador_destinatario, 1, " ");
                    echo $camp_versao_sis = $this->utilitario->preencherDireita("1.0", 10, " ");
                    echo $camp_fim_cabecalho = $this->utilitario->preencherDireita("", 2, " ");
                    ?>
                </td>
            </tr>
            <?
        }
        ?>

        <?
        $prd_ident = 3; //contador 3,4,5...
        $prd_seq = 0;
        $contador = 0;
        $prd_flh = 0;
//        Criando o corpo do pdf ou planilha
        foreach ($listabpa as $item) {

            if (@$contador > 22) { //AQUI É O CONTADOR DE ONDE O REGISTRO TA NA PAGINA, SE O CONTADOR FOR MAIOR QUE 22 ELE VAI CONTAR UMA PAGINA. E ENTAO VAI ZERAR O CONTADOR PARA PODER DIZER QUE 'PULOU UMA PAGINA AGORA VAMOS VER SE TEM MAIS UMA, TIPO ISSO' 
//                $prd_flh++;
//                $contador = 0;
            }
            ?> <tr>
                <td> 
                    <?
                    $logradouro = $item->logradouro;

                    $nascimento = str_replace('-', "", $item->nascimento);
                    $ceppaciente = str_replace("-", "", $item->ceppaciente);
                    $telefone = str_replace(" ", "", $item->telefone);
                    if ($item->data_realizacao == "") {
                        $data_realizacao = "";
                    } else {
                        $partes = explode("-", $item->data_realizacao);
                        $ano = $partes[0];
                        $mes = $partes[1];
                        $data_realizacao = $ano . $mes;
                    }
                    if ($item->data_atendimento == "") {
                        $data_atendimento = "";
                    } else {
                        $partes = explode("-", $item->data_atendimento);
                        $ano = $partes[0];
                        $mes = $partes[1];
                        $dia = $partes[2];
                        $data_atendimento = $ano . $mes . $dia;
                    }
                    $partes_atendimento = explode("-", $item->data_cadastro);
                    $ano_atendimento = $partes_atendimento[0];
                    $mes_atendimento = $partes_atendimento[1];
                    $dia_atendimento = $partes_atendimento[2];
                    $dataFuturo2 = date("Y-m-d");  // ISSO 
                    $dataAtual2 = $item->nascimento; // TUDO
                    $date_time2 = new DateTime($dataAtual2); // CALCULA 
                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2)); //A
                    $idade = $diff2->format('%Y'); // IDADE
                    $prd_cnsmed = "";
//                    $prd_seq = "";
                    $prd_cnspac = "";
                    $prd_cid = "";
                    $prd_qt = "";
                    $prd_caten = "";
                    $prd_naut = "";
                    $prd_org = "BPA";
                    $prd_etnia = "";
                    $prd_nac = "";
                    $prd_srv = "";
                    $prd_clf = "";
                    $equipe_Seq = "";
                    $equipe_Area = "";
                    $lograd_pcnte = "";
                    $prd_ine = "";
                    if ($item->raca_cor == "0" || $item->raca_cor == "") {
                        $prd_raca = "99";
                    } elseif ($item->raca_cor == "1") {
                        $prd_raca = "01";
                    } elseif ($item->raca_cor == "3") {
                        $prd_raca = "02";
                    } elseif ($item->raca_cor == "4") {
                        $prd_raca = "03";
                    } elseif ($item->raca_cor == "2") {
                        $prd_raca = "04";
                    } elseif ($item->raca_cor == "5") {
                        $prd_raca = "05";
                    } else {
                        $prd_raca = "99";
                    }
                    
                    
                     $prd_seq++;
                     if ($prd_seq == 21) {
                         $prd_seq = 1;
                     }
                     
                     
                    echo $camp_prd_ident = $this->utilitario->preencherEsquerda(03, 2, "0");
                    echo $camp_prd_cnes = $this->utilitario->preencherEsquerda($item->cnes, 7, "0");
                    echo $camp_prd_cmp = $this->utilitario->preencherEsquerda($data_realizacao, 6, " ");
                    if ($prd_cnsmed == "") {
                        echo $camp_prd_cnsmed = $this->utilitario->preencherEsquerda($prd_cnsmed, 15, " ");
                    } else {
                        echo $camp_prd_cnsmed = $this->utilitario->preencherEsquerda($prd_cnsmed, 15, "0");
                    }
                    if ($item->cbo_ocupacao_id == "") {
                        echo $camp_prd_cbo = $this->utilitario->preencherEsquerda("", 6, " ");
                    } else {
                        echo $camp_prd_cbo = $this->utilitario->preencherEsquerda($item->cbo_ocupacao_id, 6, "0");
                    }
                    echo $camp_data_atendimento = $this->utilitario->preencherEsquerda($data_atendimento, 8, "0");
                    echo $camp_prd_flh = $this->utilitario->preencherEsquerda($prd_flh, 3, "0");
                    echo $camp_prd_seq = $this->utilitario->preencherEsquerda($prd_seq, 2, "0");
                    echo $camp_prd_pa = $this->utilitario->preencherEsquerda($item->codigo, 10, "0");
                    if ($prd_cnspac == "") {
                        echo $camp_prd_cnspac = $this->utilitario->preencherEsquerda($prd_cnspac, 15, " ");
                    } else {
                        echo $camp_prd_cnspac = $this->utilitario->preencherEsquerda($prd_cnspac, 15, "0");
                    }
                    echo $camp_prd_sexo = $this->utilitario->preencherDireita($item->sexo, 1, "0");
                    if ($item->codigo_ibge == "") {
                        echo $camp_prd_ibge = $this->utilitario->preencherDireita($item->codigo_ibge, 6, " ");
                    } else {
                        echo $camp_prd_ibge = $this->utilitario->preencherDireita($item->codigo_ibge, 6, "0");
                    }
                    echo $camp_prd_cid = $this->utilitario->preencherDireita($prd_cid, 4, " ");
                    echo $camp_prd_idade = $this->utilitario->preencherEsquerda($idade, 3, " ");

                    echo $camp_prd_qt = $this->utilitario->preencherEsquerda($prd_qt, 6, "0");
                    if ($prd_caten == "") {
                        echo $camp_prd_caten = $this->utilitario->preencherEsquerda($prd_caten, 2, " ");
                    } else {
                        echo $camp_prd_caten = $this->utilitario->preencherEsquerda($prd_caten, 2, "0");
                    }
                    if ($prd_naut == "") {
                        echo $camp_prd_naut = $this->utilitario->preencherEsquerda($prd_naut, 13, " ");
                    } else {
                        echo $camp_prd_naut = $this->utilitario->preencherEsquerda($prd_naut, 13, "0");
                    }
                    echo $camp_prd_org = $this->utilitario->preencherEsquerda($prd_org, 3, " ");
                    echo $camp_prd_nmpac = $this->utilitario->preencherDireita($item->paciente, 30, " ");
                    echo $camp_prd_dtnasc = $this->utilitario->preencherDireita($nascimento, 8, " ");
                    echo $camp_prd_raca = $this->utilitario->preencherEsquerda($prd_raca, 2, "0");
                    echo $camp_prd_etnia = $this->utilitario->preencherEsquerda($prd_etnia, 4, " ");
                    if ($prd_nac == "") {
                        echo $camp_prd_nac = $this->utilitario->preencherEsquerda($prd_nac, 3, " ");
                    } else {
                        echo $camp_prd_nac = $this->utilitario->preencherEsquerda($prd_nac, 3, "0");
                    }
                    if ($prd_srv == "") {
                        echo $camp_prd_srv = $this->utilitario->preencherEsquerda($prd_srv, 3, " ");
                    } else {
                        echo $camp_prd_srv = $this->utilitario->preencherEsquerda($prd_srv, 3, "0");
                    }
                    if ($prd_clf == "") {
                        echo $camp_prd_clf = $this->utilitario->preencherEsquerda($prd_clf, 3, " ");
                    } else {
                        echo $camp_prd_clf = $this->utilitario->preencherEsquerda($prd_clf, 3, "0");
                    }
                    if ($equipe_Seq == "") {
                        echo $camp_equipe_Seq = $this->utilitario->preencherEsquerda($equipe_Seq, 8, " ");
                    } else {
                        echo $camp_equipe_Seq = $this->utilitario->preencherEsquerda($equipe_Seq, 8, "0");
                    }
                    if ($equipe_Area == "") {
                        echo $camp_equipe_Area = $this->utilitario->preencherEsquerda($equipe_Area, 4, " ");
                    } else {
                        echo $camp_equipe_Area = $this->utilitario->preencherEsquerda($equipe_Area, 4, "0");
                    }
                    if ($item->cnpjempresa == "") {
                        echo $camp_prd_cnpj = $this->utilitario->preencherEsquerda($item->cnpjempresa, 14, " ");
                    } else {
                        echo $camp_prd_cnpj = $this->utilitario->preencherEsquerda($item->cnpjempresa, 14, "0");
                    }
                    if ($ceppaciente == "") {
                        echo $camp_prd_cep_pcnte = $this->utilitario->preencherEsquerda($ceppaciente, 8, " ");
                    } else {
                        echo $camp_prd_cep_pcnte = $this->utilitario->preencherEsquerda($ceppaciente, 8, "0");
                    }                 
//                    codigo logradouro
                    if ($lograd_pcnte == "") {
                        echo $camp_prd_lograd_pcnte = $this->utilitario->preencherEsquerda($lograd_pcnte, 8, " ");
                    } else {
                        echo $camp_prd_lograd_pcnte = $this->utilitario->preencherEsquerda($lograd_pcnte, 8, "0");
                    }
//                   Endereço
                    if ($item->logradouro == "") {
                      echo  $camp_prd_end_pcnte = $this->utilitario->preencherDireita("", 30, " ");
                    } else {
                       echo $camp_prd_end_pcnte = $this->utilitario->preencherDireita($item->logradouro, 30, " ");
                    }
                    if ($item->complemento == "") {
                       echo $camp_prd_compl_pcnte = $this->utilitario->preencherDireita("", 30, " ");
                    } else {
                       echo $camp_prd_compl_pcnte = $this->utilitario->preencherDireita($item->complemento, 30, " ");
                    }
                    echo $camp_prd_num_pcnte = $this->utilitario->preencherDireita($item->numero, 5, " ");
                    echo $camp_prd_bairro_pcnte = $this->utilitario->preencherDireita($item->bairro, 30, " ");
                    echo $camp_prd_ddtel_pcnte = $this->utilitario->preencherDireita($telefone, 11, " ");
                    if ($item->email == "") {
                        echo $camp_prd_email_pcnte = $this->utilitario->preencherDireita($item->email, 40, " ");
                    } else {
                        echo $camp_prd_email_pcnte = $this->utilitario->preencherDireita($item->email, 40, "0");
                    }
                    if ($prd_ine == "") {
                        echo $camp_prd_ine = $this->utilitario->preencherDireita($prd_ine, 10, " ");
                    } else {
                        echo $camp_prd_ine = $this->utilitario->preencherEsquerda($prd_ine, 10, "0");
                    }
                    ?>
                </td>
            </tr> 
            <?
            @$contador++;
        }
        ?>
    <tbody>

</table>