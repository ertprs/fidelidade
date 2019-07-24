<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->    
    <?
    $MES = '';
    $MES_ant = '';

    switch ($_POST['mes']) {
        case 01 : $MES = 'Janeiro';
            break;
        case 02 : $MES = 'Fevereiro';
            break;
        case 03 : $MES = 'Mar&ccedil;o';
            break;
        case 04 : $MES = 'Abril';
            break;
        case 05 : $MES = 'Maio';
            break;
        case 06 : $MES = 'Junho';
            break;
        case 07 : $MES = 'Julho';
            break;
        case 08 : $MES = 'Agosto';
            break;
        case 09 : $MES = 'Setembro';
            break;
        case 10 : $MES = 'Outubro';
            break;
        case 11 : $MES = 'Novembro';
            break;
        case 12 : $MES = 'Dezembro';
            break;
    }

    switch ($_POST['mes'] - 1) {
        case 1 : $MES_ant = 'Janeiro';
            break;
        case 2 : $MES_ant = 'Fevereiro';
            break;
        case 3 : $MES_ant = 'Mar&ccedil;o';
            break;
        case 4 : $MES_ant = 'Abril';
            break;
        case 5 : $MES_ant = 'Maio';
            break;
        case 6 : $MES_ant = 'Junho';
            break;
        case 7 : $MES_ant = 'Julho';
            break;
        case 8 : $MES_ant = 'Agosto';
            break;
        case 9 : $MES_ant = 'Setembro';
            break;
        case 10 : $MES_ant = 'Outubro';
            break;
        case 11 : $MES_ant = 'Novembro';
            break;
        case 12 : $MES_ant = 'Dezembro';
            break;
    }
    ?>

    <?
    $ano = date("Y");
    if ($_POST['tipoPesquisa'] == 'MENSAL') {

        // $MES = '';
        $periodo = "$MES de $ano";
    } else {
        $periodo = "" . $_POST['ano'];
    }
    ?>

    <style>
        .left{
            text-align: left;
        }
        .right{
            text-align: right;
        }

    </style>
    <h4>EMPRESA: <?= ($_POST['empresa'] > 0) ? $empresa[0]->nome : 'TODAS'; ?></h4>
    <h4>FLUXO DE CAIXA DE MENSAL</h4>
    <h4>PERIODO: <?= $periodo ?></h4>
    <h4>FLUXO DE CAIXA QUATRO NÍVEIS</h4>
    <hr>
    <?
    if (count($relatorio_entrada) > 0 || count($relatorio_saida) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header" colspan="1">ITENS</th>
                    <th class="tabela_header" colspan="1"> $ </th>
                    <th class="tabela_header" colspan="1">% NO GRUPO</th>
                    <th class="tabela_header" colspan="1">% TOTAL</th>
                </tr>
            </thead>
            <tr>
                <th class="tabela_header left" bgcolor="#C0C0C0" colspan="8">1. ENTRADAS</th>

            </tr>
            <?
            $contador = 0;
            $i = 0;
            $m = 0;
            $n = 0;
            $tipo_atual = '&nbsp;';
            $nivel1_atual = '&nbsp;';
            $nivel2_atual = '&nbsp;';
            $valor_totalEntrada = 0;
            $valor_tipo = 0;
            $percentual = 0;
            ?>


            <?
//            echo '<pre>'; var_dump($relatorio_entrada);die;
            foreach ($relatorio_entrada as $key => $item) {
                $valor_totalEntrada += $item->valor;
                if ($item->valor_tipo > 0) {
                    $percentual = round((100 * $item->valor) / $item->valor_tipo, 2);
                } else {
                    $percentual = 0;
                }

                if ($item->relatorio_total > 0) {
                    $percentual_tipo = round((100 * $item->valor_tipo) / $item->relatorio_total, 2);
                    $percentualNoTotal = round((100 * $item->valor) / $item->relatorio_total, 2);
                } else {
                    $percentual_tipo = 0;
                    $percentualNoTotal = 0;
                }
                ?>


                <? if ($item->nivel1 != $nivel1_atual) { ?>
                <tr>
                    <th class="tabela_header left" bgcolor="#606060" colspan="1">
                        <?= $item->nivel1 ?> 
                    </th>
                    <th class="tabela_header right" bgcolor="#606060" colspan="1">
                        <?= number_format($item->valor_nivel1, 2, ",", "."); ?>
                    </th>
                    <th class="tabela_header right" bgcolor="#606060" colspan="1">
                        100%  
                    </th>
                    <th class="tabela_header right" bgcolor="#606060" colspan="1">

                    </th>
                </tr>
                <? } ?>
                    <?
                    $m++;
                    $nivel1_atual = $item->nivel1;
                    ?>
                <? if ($item->nivel2 != $nivel2_atual) { ?>
                    <tr>
                        <th class="tabela_header left" bgcolor="#868686" colspan="1">
                            <?= $item->nivel2 ?>   
                        </th>
                        <th class="tabela_header right" bgcolor="#868686" colspan="1">
                            <?= number_format($item->valor_nivel2, 2, ",", "."); ?>
                        </th>
                        <th class="tabela_header right" bgcolor="#868686" colspan="1">
                            100%  
                        </th>
                        <th class="tabela_header right" bgcolor="#868686" colspan="1">

                        </th>
                    </tr>
                <? } ?>
                    <?
                    $n++;
                    $nivel2_atual = $item->nivel2;
                    ?>
                <? if ($item->tipo != $tipo_atual) { ?>
                    <tr>
                        <th class="tabela_header left" bgcolor="#C0C0C0" colspan="1">
                            <?= $item->tipo ?> 
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            <?= number_format($item->valor_tipo, 2, ",", "."); ?>
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            100%  
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            <?= str_replace('.', ',', $percentual_tipo) ?> %
                        </th>
                    </tr>

                    <?
                }
                $i++;
                $tipo_atual = $item->tipo;
                ?>
                <tr>
                    <td>
                        <?= $item->classe ?> 
                    </td>
                    <td class="right">
                        <?= number_format($item->valor, 2, ",", "."); ?>
                    </td>
                    <td class="right">
                        <?= str_replace('.', ',', $percentual); ?>%
                    </td>
                    <td class="right">
                        <?= str_replace('.', ',', $percentualNoTotal); ?>%
                    </td>
                </tr>

                <? if ((count($relatorio_entrada)) == $i) { ?>
                    <tr>
                        <td colspan="1" bgcolor="#C0C0C0"><b>SOMA DAS ENTRADAS</b></td>
                        <td colspan="" bgcolor="#C0C0C0" class="right"><b><?= number_format($item->relatorio_total, 2, ",", "."); ?></b></td>
                        <td colspan="1" bgcolor="#C0C0C0" class="right"><b>100%</b></td>

                        <td colspan="" bgcolor="#C0C0C0" class="right"><b>100%</b></td>
                    </tr>
                <? } ?>



            <? } ?>
            <tr>
                <th class="tabela_header left"  colspan="8">&nbsp;</th>

            </tr>
            <tr>
                <th class="tabela_header left" bgcolor="#C0C0C0" colspan="8">2. SAIDAS</th>

            </tr>
            <?
            $valor_totalSaida = 0;
            $i = 0;
            foreach ($relatorio_saida as $key => $item) {
                $valor_totalSaida += $item->valor;
                if ($item->valor_tipo > 0) {
                    $percentual = round((100 * $item->valor) / $item->valor_tipo, 2);
                } else {
                    $percentual = 0;
                }

                if ($item->relatorio_total > 0) {
                    $percentual_tipo = round((100 * $item->valor_tipo) / $item->relatorio_total, 2);
                    $percentualNoTotal = round((100 * $item->valor) / $item->relatorio_total, 2);
                } else {
                    $percentual_tipo = 0;
                    $percentualNoTotal = 0;
                }
                ?>
                <? if ($item->tipo != $tipo_atual) { ?>

                    <tr>
                        <th class="tabela_header left" bgcolor="#C0C0C0" colspan="1">
                            <?= $item->tipo ?> 
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            <?= number_format($item->valor_tipo, 2, ",", "."); ?>
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            100%  
                        </th>
                        <th class="tabela_header right" bgcolor="#C0C0C0" colspan="1">
                            <?= str_replace('.', ',', $percentual_tipo) ?> %
                        </th>
                    </tr>

                    <?
                }
                $i++;
                $tipo_atual = $item->tipo;
                ?>
                <tr>
                    <td>
                        <?= $item->classe ?> 
                    </td>
                    <td class="right">
                        <?= number_format($item->valor, 2, ",", "."); ?>
                    </td>
                    <td class="right">
                        <?= str_replace('.', ',', $percentual); ?>%
                    </td>
                    <td class="right">
                        <?= str_replace('.', ',', $percentualNoTotal); ?>%
                    </td>
                </tr>

                <? if ((count($relatorio_saida)) == $i) { ?>

                <? } ?>



            <? } ?>
            <tr>
                <td colspan="1" bgcolor="#C0C0C0"><b>SOMA DAS ENTRADAS</b></td>
                <td colspan="1" bgcolor="#C0C0C0" class="right" ><b><?= number_format($valor_totalEntrada, 2, ",", "."); ?></b></td>
                <td colspan="2" bgcolor="#C0C0C0"><b></b></td>  
            </tr>
            <tr>
                <td colspan="1" bgcolor="#C0C0C0"><b>SOMA DAS SAIDAS</b></td>
                <td colspan="1" bgcolor="#C0C0C0" class="right" ><b><?= number_format($valor_totalSaida, 2, ",", "."); ?></b></td>
                <td colspan="2" bgcolor="#C0C0C0"><b></b></td>    
            </tr>
            <?
            $_POST['ano'] = $_POST['ano'] - 1;
            $_POST['mes'] = $_POST['mes'] - 1;
            if ($_POST['tipoPesquisa'] == 'MENSAL') {
                $anterior = "({$MES_ant})";
            } else {
                $anterior = "({$_POST['ano']})";
            }
            ?>
            <tr>
                <td colspan="1" bgcolor="#C0C0C0"><b>SALDO ANTERIOR <?= $anterior ?></b></td>
                <td colspan="1" bgcolor="#C0C0C0" class="right" ><b><?= number_format($saldo_anterior[0]->valor, 2, ",", "."); ?></b></td>
                <td colspan="2" bgcolor="#C0C0C0"><b></b></td>    
            </tr>
            <tr>
                <td colspan="1" ><b>3.DIFERENÇA DO PERÍODO (1 - 2) </b></td>
                <td colspan="1" bgcolor="#C0C0C0" class="right" ><b><?= number_format($valor_totalEntrada - $valor_totalSaida, 2, ",", "."); ?></b></td>
                <td colspan="2" ><b></b></td>    
            </tr>
            <?
            $sup_def = $saldo_anterior[0]->valor + ($valor_totalEntrada - $valor_totalSaida);
            ?>
            <tr>
                <td colspan="1" ><b>4. <?= ($sup_def > 0) ? 'SUPERAVIT' : 'DÉFICIT' ?></b></td>
                <td colspan="1" bgcolor="#C0C0C0" class="right" ><b><?= number_format($sup_def, 2, ",", "."); ?></b></td>
                <td colspan="2" ><b></b></td>    
            </tr>



        </table>

        <h4>Obs: Transfer&ecirc;ncias n&atilde;o s&atilde;o mostradas nesse relatório </h4>

        <?
    } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
