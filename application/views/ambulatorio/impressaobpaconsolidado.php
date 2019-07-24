 
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
$contador_pagina = 0;
//while ($totalregistrosfake > 42) { // CONTANDO QUANTAS PAGINAS TEM NO PDF NO CASO EU GEREI MUITOS REGISTROS E VI ATÉ QUE LINHA
//    @$contador_pagina++;           // OS REGISTROS CHEGAVAM PARA PASSAR DE PAGINA
//    @$totalregistrosfake = $totalregistrosfake - 42; // AQUI ELE ELE DIMINUI POR 42 QUE É O TOTAL QUE UMA PAGINA AGUENTA(PRA NÃO ACUMULAR) 
//}
?>


<table>
    <tbody>
        <?
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
                    echo $camp_versao_sis = $this->utilitario->preencherDireita("", 10, " ");
                    echo $camp_fim_cabecalho = $this->utilitario->preencherDireita("", 2, " ");
                    ?></td>
            </tr>

            <?
        }
        ?>



        <?
        $prd_ident = 2;
        $prd_seq = 0;
        $total_regis = 1;
        $contador = 0;
        $prd_flh = 0;
        foreach ($listabpa as $item) {

            if (@$contador > 42) { //AQUI É O CONTADOR DE ONDE O REGISTRO TA NA PAGINA, SE O CONTADOR FOR MAIOR QUE 42 ELE VAI CONTAR UMA PAGINA. E ENTAO VAI ZERAR O CONTADOR PARA PODER DIZER QUE 'PULOU UMA PAGINA AGORA VAMOS VER SE TEM MAIS UMA, TIPO ISSO' 
//                $prd_flh++;
//                $contador = 0;
            }
            ?> <tr>
                <td> 
                    <?
                    $total_regis++;
                    if ($item->data_realizacao == "") {
                        $data_realizacao = "";
                    } else {
                        $partes = explode("-", $item->data_realizacao);
                        $ano = $partes[0];
                        $mes = $partes[1];
                        $data_realizacao = $ano . $mes;
                    }

                    $dataFuturo2 = date("Y-m-d");  //ISSO 
                    $dataAtual2 = $item->nascimento; // TUDO
                    $date_time2 = new DateTime($dataAtual2); // CALCULA 
                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2)); //A
                    $idade = $diff2->format('%Y'); // IDADE
                    $prd_seq++;
                    if ($prd_seq == 21) {
                        $prd_seq = 1;
                    }
                    $prd_qt = "";
                    $prd_org = "BPA";
                    $prd_fim = "";
                    echo $camp_prd_ident = $this->utilitario->preencherEsquerda($prd_ident++, 2, "0");
                    echo $camp_prd_cnes = $this->utilitario->preencherEsquerda($item->cnes, 7, "0");
                    echo $camp_prd_cmp = $this->utilitario->preencherEsquerda($data_realizacao, 6, " ");
                    echo $camp_prd_cbo = $this->utilitario->preencherEsquerda($item->cbo_ocupacao_id, 6, " ");
                    echo $camp_prd_flh = $this->utilitario->preencherEsquerda($prd_flh, 3, "0");
                    echo $camp_prd_seq = $this->utilitario->preencherEsquerda($prd_seq, 2, "0");
                    echo $camp_prd_pa = $this->utilitario->preencherEsquerda($item->codigo, 10, "0");
                    echo $camp_prd_idade = $this->utilitario->preencherEsquerda($idade, 3, "0");
                    echo $camp_prd_qt = $this->utilitario->preencherEsquerda($prd_qt, 6, "0");
                    echo $camp_org = $this->utilitario->preencherDireita($prd_org, 3, " ");
                    echo $camp_fim = $this->utilitario->preencherDireita($prd_fim, 2, " ");
                    ?>

                </td>

            </tr> 
            <?
            @$contador++;
        }
        ?>
    <tbody>

</table>