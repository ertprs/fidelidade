<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<?
$MES = date("m");

switch ($MES) {
    case 1 : $MES = 'Janeiro';
        break;
    case 2 : $MES = 'Fevereiro';
        break;
    case 3 : $MES = 'Mar&ccedil;o';
        break;
    case 4 : $MES = 'Abril';
        break;
    case 5 : $MES = 'Maio';
        break;
    case 6 : $MES = 'Junho';
        break;
    case 7 : $MES = 'Julho';
        break;
    case 8 : $MES = 'Agosto';
        break;
    case 9 : $MES = 'Setembro';
        break;
    case 10 : $MES = 'Outubro';
        break;
    case 11 : $MES = 'Novembro';
        break;
    case 12 : $MES = 'Dezembro';
        break;
        break;
}
?>
<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if ($tecnico != 0 && $recibo == 'SIM') { ?>
        <div>
            <p style="text-align: center;"><img align = 'center'  width='300px' height='150px' src="<?= base_url() . "img/cabecalho.jpg" ?>"></p>
        </div>
    <? } ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Técnico Convenios</h4>
    <? $sit = ($situacao == '') ? "TODOS" : (($situacao == '0') ? 'ABERTO' : 'FINALIZADO' ); ?>
    <h4>SITUAÇÃO: <?= $sit ?></h4>
    <h4>PERIODO: <?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4); ?> ate <?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4); ?></h4>
    <?
   
    if ($tecnico == 0) {
        ?>
        <h4>Tecnico: TODOS</h4>
    <? } else { ?>
        <h4>Tecnico: <?= $tecnico[0]->operador; ?></h4>
    <? } ?>
        
    <? if (count(@$sala) > 0) { ?>
        <h4>SALA: <?= @$sala[0]->nome; ?></h4>
    <? } else { ?>
        <h4>TODAS AS SALAS</h4>
    <? } ?>

    <hr>
    <?
    if (count($relatorio) > 0) {
        $totalperc = 0;
        $valor_recebimento = 0;
        ?>

        <? if (count($relatorio) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <td colspan="50"><center>PRODUÇÃO AMBULATORIAL</center></td>
                </tr>
                <tr>


                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Tecnico</th>
                    <th class="tabela_header" width="100px;" title="Data do agendamento. Data onde o paciente foi agendado"><font size="-1">Data Agend.</th>
                    <th class="tabela_header" width="100px;" title="Data do atendimento. Data em que foi enviado da sala de espera"><font size="-1">Data Atend.</th>
                    <th class="tabela_header" width="100px;" title="Data de recebimento. Data em que o relatorio se baseia"><font size="-1">Data Receb.</th>
                    <th class="tabela_header"><font size="-1">Qtde</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    
                        <th class="tabela_header" ><font size="-1">Valor Bruto</th>
                        <th class="tabela_header" ><font size="-1">ISS</th>
                        <th class="tabela_header" ><font size="-1">Valor Liquido</th>
                    
                    <? if ($_POST['forma_pagamento'] == 'SIM') { ?>
                        <th class="tabela_header" ><font size="-1">F. Pagamento Cartão</th>
                        <th class="tabela_header" ><font size="-1">F. Pagamento Dinheiro</th>
                    <? } ?>
                   
                    <th class="tabela_header" width="80px;"><font size="-1">Indice/Valor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor tecnico</th>
                 
                    
                </tr>
                </thead>
                <tbody>
                    <?php
                    $dados = array();
                    $vlrTotalDinheiro = 0;
                    $vlrTotalCartao = 0;
                    $i = 0;
                    $valor = 0;
                    $valortotal = 0;
                    $convenio = "";
                    $y = 0;
                    $qtde = 0;
                    $qtdetotal = 0;
                    $resultado = 0;
                    $simbolopercebtual = " %";
                    $iss = 0;
                    $perc = 0;
                    $totalgeral = 0;
                    $percpromotor = 0;
                    $totalgeralpromotor = 0;
                    $totalpercpromotor = 0;
                    $perclaboratorio = 0;
                    $totalgerallaboratorio = 0;
                    $totalperclaboratorio = 0;
                    $totalconsulta = 0;
                    $totalretorno = 0;
                    $taxaAdministracao = 0;
                    $valor_total = 0;
                    $valor_total_calculo = 0;
                    $valor_credito = 0;
                    $producao_paga = 'f';
                    $descontoTotal = 0;
                    
                    foreach ($relatorio as $item) :
                        $i++;
                        $procedimentopercentual = $item->procedimento_convenio_id;
                        $descontoAtual = 0;
//            $tecnicopercentual = $item->tecnico_parecer1;
                        $tecnicopercentual = $item->operador_id;
                        if ($item->grupo != "RETORNO") {
                            $totalconsulta++;
                        } else {
                            $totalretorno++;
                        }

                        if($item->producao_paga == 't'){
                            $producao_paga = 't';
                        }

                        if($empresa_permissao[0]->faturamento_novo == 't'){
                            $descontoForma = $this->guia->listardescontoTotal($item->agenda_exames_id);
                            // var_dump($descontoForma);
                            if(count($descontoForma) > 0){
                                $descontoTotal+= $descontoForma[0]->desconto;
                                $descontoAtual = $descontoForma[0]->desconto;
                            }
                        }

                        $valor_total = $item->valor_total;
//                        $valor_total_formas = $item->valor1 + $item->valor2 + $item->valor3 + $item->valor4;
//                        $valor_total = $valor_total_formas + $item->desconto_ajuste1 + $item->desconto_ajuste2 + $item->desconto_ajuste3 + $item->desconto_ajuste4;
                        if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                            $valor_total_calculo = $item->valor_total;
                        } else {
                            if ($item->forma_pagamento1 == 1000) {
                                $valorSemCreditoTotal = $item->valor2 + $item->valor3 + $item->valor4;
                                $valor_credito = $valor_credito + $item->valor1;
                            }
                            if ($item->forma_pagamento2 == 1000) {
                                $valorSemCreditoTotal = $item->valor1 + $item->valor3 + $item->valor4;
                                $valor_credito = $valor_credito + $item->valor2;
                            }
                            if ($item->forma_pagamento3 == 1000) {
                                $valorSemCreditoTotal = $item->valor1 + $item->valor2 + $item->valor4;
                                $valor_credito = $valor_credito + $item->valor3;
                            }
                            if ($item->forma_pagamento4 == 1000) {
                                $valorSemCreditoTotal = $item->valor1 + $item->valor2 + $item->valor3;
                                $valor_credito = $valor_credito + $item->valor4;
                            }
                            $valor_total_calculo = $valorSemCreditoTotal;
                        }

//                        $valor_total = $item->valor_total;
//                        var_dump($valor_total_calculo);
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->paciente; ?></td>
                            <td><font size="-2"><?= $item->tecnico; ?></td>
                            <td><font size="-2">
                                <?
                                $modificado = "";
                                $onclick = "";
                                if ($item->data_antiga != "") {
                                    $modificado = " ** ";
                                }

                                echo $modificado,
                                substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4),
                                ($item->sala_pendente != "f") ? " (PENDENTE)" : "",
                                $modificado;
                                ?>
                            </td>
                            <td ><font size="-2"><?= date('d/m/Y', strtotime($item->data_laudo)); ?></td>
                            <td ><font size="-2"><?= date('d/m/Y', strtotime($item->data_producao)); ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>

                            <td><font size="-2"><?= $item->procedimento; ?></td>
                           
                            <td style='text-align: right;'><font size="-2"><?= number_format($valor_total, 2, ",", "."); ?></td>
                            <td style='text-align: right;' width="50"><font size="-2"><?= number_format($item->iss, 2, ",", "."); ?> (%)</td>
                            <?
//                                $valorLiqMed = ((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100)) - ((float) $valor_total * ((float) $item->taxa_administracao / 100))); 
                            ?>
                            <td style='text-align: right;'><font size="-2"><?= number_format(((float) $valor_total - ((float) $valor_total * ((float) $item->iss / 100))), 2, ",", "."); ?></td>
                            <?
                           
                            if ($_POST['forma_pagamento'] == 'SIM') {
                                $vlrDinheiro = 0;
                                $vlrCartao = 0;
                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {


                                    if ($item->cartao1 != 'f') {
                                        $vlrDinheiro += $item->valor1;
                                    } else {
                                        $vlrCartao += $item->valor1;
                                    }

                                    if ($item->cartao2 != 'f') {
                                        $vlrDinheiro += $item->valor2;
                                    } else {
                                        $vlrCartao += $item->valor2;
                                    }

                                    if ($item->cartao3 != 'f') {
                                        $vlrDinheiro += $item->valor3;
                                    } else {
                                        $vlrCartao += $item->valor3;
                                    }

                                    if ($item->cartao4 != 'f') {
                                        $vlrDinheiro += $item->valor4;
                                    } else {
                                        $vlrCartao += $item->valor4;
                                    }
                                }

                                $vlrTotalDinheiro += $vlrDinheiro;
                                $vlrTotalCartao += $vlrCartao;
                                ?>
                                <td style='text-align: right;'><font size="-2"><?= number_format($vlrDinheiro, 2, ",", "."); ?></td>
                                <td style='text-align: right;'><font size="-2"><?= number_format($vlrCartao, 2, ",", "."); ?></td>
                                <?
                            }

                            
                            // EM CASO DE A CONDIÇÃO ABAIXO SER VERDADEIRA. O VALOR DO PROMOTOR VAI SER DESCONTADO DO MÉDICO
                            // NÃO DÁ CLINICA

                            if (@$empresa_permissao[0]->promotor_tecnico == 't' && $_POST['promotor'] == 'SIM') {
                                // MESMAS REGRAS ABAIXO PARA O PROMOTOR ABAIXO
//                                var_dump(@$empresa_permissao[0]->promotor_tecnico);
//                                die;
                                if ($item->percentual_promotor == "t") {
                                    $simbolopercebtualpromotor = " %";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valor_total * ($valorpercentualpromotor / 100);
                                } else {
                                    $simbolopercebtualpromotor = "";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valorpercentualpromotor * $item->quantidade;
                                }

                                // SE FOR PERCENTUAL, ELE CALCULA O TOTAL PELO PERCENTUAL
                                if ($item->percentual_tecnico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualtecnico = $item->valor_tecnico/* - ((float) $item->valor_tecnico * ((float) $item->taxa_administracao / 100)) */;

                                    $perc = $valor_total * ($valorpercentualtecnico / 100);
                                    if ($item->valor_promotor != null) {
//                                        echo '<pre>';
                                        $perc = $perc - $percpromotor;
                                    }
                                } else {
                                    // SE FOR VALOR, É O VALOR * A QUANTIDADE
                                    $simbolopercebtual = "";
                                    $valorpercentualtecnico = $item->valor_tecnico/* - ((float) $item->valor_tecnico * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentualtecnico;

                                    $perc = $valorpercentualtecnico * $item->quantidade;
                                    if ($item->valor_promotor != null) {
//                                        echo '<pre>';
                                        $perc = $perc - $percpromotor;
                                    }
                                }
//                                var_dump($item->valor_promotor);
//                                var_dump($perc);
//                                var_dump($percpromotor);
//                                die;

                                $totalperc = $totalperc + $perc;
//                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                                $totalgeral = $totalgeral + $valor_total_calculo;
//                                }

                                $totalpercpromotor = $totalpercpromotor + $percpromotor;
                                $totalgeralpromotor = $totalgeralpromotor + $valor_total;
                            } else {
                                // SENÃO, VAI CONTINUAR DA FORMA QUE ERA ANTES
                                if ($item->percentual_tecnico == "t") {
                                    $simbolopercebtual = " %";

                                    $valorpercentualtecnico = $item->valor_tecnico/* - ((float) $item->valor_tecnico * ((float) $item->taxa_administracao / 100)) */;

                                    $perc = $valor_total * ($valorpercentualtecnico / 100);
                                } else {
                                    $simbolopercebtual = "";
                                    $valorpercentualtecnico = $item->valor_tecnico/* - ((float) $item->valor_tecnico * ((float) $item->taxa_administracao / 100)) */;

//                                    $perc = $valorpercentualtecnico;
                                    $perc = $valorpercentualtecnico * $item->quantidade;
                                }

                                $totalperc = $totalperc + $perc;
//                                if ($item->forma_pagamento1 != 1000 && $item->forma_pagamento2 != 1000 && $item->forma_pagamento3 != 1000 && $item->forma_pagamento4 != 1000) {
                                $totalgeral = $totalgeral + $valor_total_calculo;
//                                }

                                if ($item->percentual_promotor == "t") {
                                    $simbolopercebtualpromotor = " %";

                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

                                    $percpromotor = $valor_total * ($valorpercentualpromotor / 100);
                                } else {
                                    $simbolopercebtualpromotor = "";
                                    $valorpercentualpromotor = $item->valor_promotor/* - ((float) $item->valor_promotor * ((float) $item->taxa_administracao / 100)) */;

//                                    $percpromotor = $valorpercentualpromotor;
                                    $percpromotor = $valorpercentualpromotor * $item->quantidade;
                                }

                                $totalpercpromotor = $totalpercpromotor + $percpromotor;
                                $totalgeralpromotor = $totalgeralpromotor + $valor_total;
                            }

                            @$tempoRecebimento[str_replace("-", "", $item->data_producao)][$item->tecnico_parecer1] = array(
                                "tecnico_nome" => @$item->tecnico,
                                "valor_recebimento" => @$tempoRecebimento[str_replace("-", "", $item->data_producao)][@$item->tecnico_parecer1]["valor_recebimento"] + $perc,
                                "data_recebimento" => $item->data_producao
                            );
                            ?>
                            
                            <td style='text-align: right;'><font size="-2"><?= number_format($valorpercentualtecnico, 2, ",", "") . $simbolopercebtual ?></td>
                            <td style='text-align: right;'><font size="-2"><?= number_format($perc, 2, ",", "."); ?></td>
                           
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                    endforeach;

                    
//                    var_dump(@$empresa_permissao[0]->valor_laboratorio);
                    
                    if (@$empresa_permissao[0]->valor_laboratorio == 't') {
                        $resultadototalgeral = $totalgeral - $totalperc;
                    } else {
                        $resultadototalgeral = $totalgeral - $totalperc - $totalperclaboratorio;
                    }
                    
                    if($empresa_permissao[0]->faturamento_novo == 't'){
                        $resultadototalgeral -= $descontoTotal;
                    }
                    ?>
                    <tr>
                        <td ><font size="-1">TOTAL</td>
                        <td  colspan="2" style='text-align: right;'><font size="-1">Nr. Procedimentos: <?= $qtdetotal; ?></td>
                        
                        
                        <td colspan="4" style='text-align: right;'><font size="-1">TOTAL CLINICA: <?= number_format($resultadototalgeral, 2, ",", "."); ?></td>
                        
                       
                        <!--                            As váriaveis estão invertidas-->
                        <? if ($_POST['forma_pagamento'] == 'SIM') { ?>
                            <td colspan="2" style='text-align: right;'><font size="-1">T. CARTÃO: <?= number_format($vlrTotalDinheiro, 2, ",", "."); ?></td>
                            <td colspan="3" style='text-align: right;'><font size="-1">T. DINHEIRO: <?= number_format($vlrTotalCartao, 2, ",", "."); ?></td>
                        <? } ?>
                        
                       
                        <td colspan="3" style='text-align: right;'><font size="-1">TOTAL Técnico: <?= number_format($totalperc, 2, ",", "."); ?></td>
                    </tr>
                </tbody>
            </table>
            <?if($empresa_permissao[0]->faturamento_novo == 't'){?>
                <br>
                <br>
                <table border="1">
                    <tr>
                        <td>
                            TOTAL BRUTO
                        </td>
                        <td>
                            <?= number_format($resultadototalgeral + $totalperc, 2, ",", "."); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            TOTAL DESCONTO
                        </td>
                        <td>
                            <?= number_format($descontoTotal, 2, ",", "."); ?>         
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PRODUÇÃO MÉDICA
                        </td>
                        <td>
                            <?= number_format($totalperc, 2, ",", "."); ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            SALDO
                        </td>
                        <td>
                            <?= number_format($resultadototalgeral, 2, ",", "."); ?>          
                        </td>
                    </tr>
                </table>
                <br>
                <br>
            <?}?>
        <? endif; ?>

        <?
        if ($tecnico != 0) {
            ?>

            <hr>
            <? if ($tecnico != 0 && $recibo == 'NAO') { ?> 
                <table border="1">
                    <tr>
                        <th colspan="2" width="200px;">RESUMO</th>
                    </tr>
                    <?
                    $resultado = $totalperc;
                    if (@$totalretorno > 0 || @$totalconsulta > 0) :
                        ?>
                        <tr>
                            <td>TOTAL CONSULTAS</td>
                            <td style='text-align: right;' width="30px;"><?= $totalconsulta; ?></td>
                        </tr>

                        <tr>
                            <td>TOTAL RETORNO</td>
                            <td style='text-align: right;'><?= $totalretorno; ?></td>
                        </tr>
                        <?
                    endif;
                    if (@$totalprocedimentoscirurgicos > 0):
                        ?>
                        <tr>
                            <td>TOTAL PROC. CIRURGICOS</td>
                            <td style='text-align: right;'><?= $totalprocedimentoscirurgicos; ?></td>
                        </tr>
                    <? endif; ?>
                </table>
                <?
                if (@$totalperchome != 0) {
                    $totalperc = $totalperc + $totalperchome;
                }

                $irpf = 0;
                if ($totalperc >= $tecnico[0]->valor_base) {
                    $irpf = $totalperc * ($tecnico[0]->ir / 100);
                    ?>
                    <br>
                    <table border="1">
                        <tr>
                            <th colspan="2" width="200px;">RESUMO FISCAL</th>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td style='text-align: right;'><?= number_format(@$totalperc, 2, ",", "."); ?></td>
                        </tr>

                        <tr>
                            <td>IRPF</td>
                            <td style='text-align: right;'><?= number_format($irpf, 2, ",", "."); ?></td>
                        </tr>
                       
                        <?
                    } else {
                        ?>
                        <hr>
                        <table border="1">
                            <tr>
                                <th colspan="2" width="200px;">RESUMO FISCAL</th>
                            </tr>
                            <?
                        }
                        if ($totalperc > 215) {
                            $pis = $totalperc * ($tecnico[0]->pis / 100);
                            $csll = $totalperc * ($tecnico[0]->csll / 100);
                            $cofins = $totalperc * ($tecnico[0]->cofins / 100);
                            $resultado = $resultado - $pis - $csll - $cofins;
                            ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td>TAXA ADMINISTRAÇÃO</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td style='text-align: right;'><?= number_format($taxaAdministracao, 2, ",", "."); ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>-->
                            <tr>
                                <td>PIS</td>
                                <td style='text-align: right;'><?= number_format($pis, 2, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>CSLL</td>
                                <td style='text-align: right;'><?= number_format($csll, 2, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>COFINS</td>
                                <td style='text-align: right;'><?= number_format($cofins, 2, ",", "."); ?></td>
                            </tr>
                            <?
                            $iss = $totalperc * ($tecnico[0]->iss / 100);
                            $resultado = $resultado - $iss;
                        }
                        if (@$iss > 0) {
                            ?>
                            <tr>
                                <td>ISS</td>
                                <td style='text-align: right;'><?= number_format($iss, 2, ",", "."); ?></td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td>RESULTADO</td>
                            <td style='text-align: right;'><?= number_format($resultado, 2, ",", "."); ?></td>
                        </tr>
                    </table>
                <? } ?>
                <? ?>
                <? if ($tecnico != 0) {
                    ?>

                    <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/fechartecnico" method="post">
                        <input type="hidden" class="texto3" name="tipo" value="<?= $tecnico[0]->tipo_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="nome" value="<?= $tecnico[0]->credor_devedor_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="conta" value="<?= $tecnico[0]->conta_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="classe" value="<?= $tecnico[0]->classe; ?>" readonly/>
                        <input type="hidden" class="texto3" name="empresa_id" value="<?= $_POST['empresa']; ?>" readonly/>
                        <input type="hidden" class="texto3" name="operador_id" value="<?= $tecnico[0]->operador_id; ?>" readonly/>
                        <input type="hidden" class="texto3" name="observacao" value="<?= "Período " . substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) . " até " . substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4) . " médico: " . $tecnico[0]->operador; ?>" readonly/>
                        <input type="hidden" class="texto3" name="data" value="<?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4) ?>" readonly/>
                        <input type="hidden" class="texto3" name="data_fim" value="<?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4) ?>" readonly/>
                        <input type="hidden" class="texto3" name="valor" value="<?= $resultado; ?>" readonly/>
                        <?
                        $j = 0;
                        if ($tecnico != 0 && $recibo == 'NAO') {
                            ?> 
                            <br>
                            <?
                            $empresa_id = $this->session->userdata('empresa_id');
                            $data['empresa'] = $this->guia->listarempresa($empresa_id);
                            $data_contaspagar = $data['empresa'][0]->data_contaspagar;
                            if ($data_contaspagar == 't') {
                                ?>

                                <br>
                                <label>Data Contas a Pagar</label><br>
                                <input type="text" class="texto3" name="data_escolhida" id="data_escolhida" value=""/>
                                <br>
                                <br>  
                            <? } ?>

                            <!--<br>-->
                            <button type="submit" name="btnEnviar">Producao Tecnica</button>

                        <? } ?>
                    </form>
                    <?
                }
            }
            ?>
            <br>
            <? if ($tecnico != 0 && $recibo == 'NAO') { ?> 
                <div>
                    <div style="display: inline-block">
                       
                            <table border="1">
                                
                                <thead>
                                <tr>
                                        <td colspan="50"><center>PRODUÇÃO AMBULATORIAL</center></td>
                                </tr>
                                <tr>
                                    <th class="tabela_header"><font size="-1">tecnico</th>
                                    <th class="tabela_header"><font size="-1">Qtde</th>
                                    <th class="tabela_header"><font size="-1">Produ&ccedil;&atilde;o tecnico</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?
                                    foreach ($relatoriogeral as $itens) :
                                        ?>

                                        <tr>
                                            <td><font size="-2"><?= $itens->tecnico; ?></td>
                                            <td ><font size="-2"><?= $itens->quantidade; ?></td>
                                            <td ><font size="-2"><?= number_format($itens->valor, 2, ",", "."); ?></td>
                                        </tr>

                                    <? endforeach; ?>
                                </tbody>
                            </table>
                    
                    </div>
                <? } ?>
                <div style="display: inline-block;margin: 5pt">
                </div>

            </div>

           
               
                                                                                                            </style>
            <? if ($tecnico != 0 && $recibo == 'SIM') { ?>
    <div>
            <div>
                <p style="text-align: center;font-size: 14pt"> <strong>RECIBO</strong> <span style="color:red;"><?=($producao_paga == 't')? '(Pago)': ''; ?></span></p>
            <?
            $valor = number_format($totalperc, 2, ",", ".");
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            $extenso = GExtenso::moeda($valoreditado);
            ?>
                <p style="text-align: center;">EU   <u><b><?= $tecnico[0]->operador ?></b></u>, RECEBI DA CLÍNICA,</p>
                <p style="text-align: center;">  A QUANTIA DE R$ <?= number_format($totalperc, 2, ",", "."); ?> (<?= strtoupper($extenso) ?>)

                <p style="text-align: center;">REFERENTE AOS ATENDIMENTOS 
                    CLÍNICOS DO PERÍODO DE <?= substr($txtdata_inicio, 8, 2) . "/" . substr($txtdata_inicio, 5, 2) . "/" . substr($txtdata_inicio, 0, 4); ?> a <?= substr($txtdata_fim, 8, 2) . "/" . substr($txtdata_fim, 5, 2) . "/" . substr($txtdata_fim, 0, 4); ?> </p>
                <!--<p><?= $empresamunicipio[0]->municipio ?> </p>-->
                <p style="text-align: center"><?= $empresamunicipio[0]->municipio ?>,
                <?= date("d") . " de " . $MES . " de " . date("Y"); ?> -

                <?= date("H:i") ?>
                </p>
                <!--<p><center><font size = 4><b>DECLARA&Ccedil;&Atilde;O</b></font></center></p>-->
                <br>


                <h4><center>______________________________________________________________</center></h4>
                <h4><center>Assinatura do Profissional</center></h4>
                <h4><center>Carimbo</center></h4>
                <br>
                <br>
                <p style="text-align: center"><b>AVISO:</b> CARO PROFISSIONAL, INFORMAMOS QUE QUALQUER RECLAMAÇÃO DAREMOS UM 
                    PRAZO DE 05(CINCO DIAS) A CONTAR DA DATA DE RECEBIMENTO PARA REINVIDICAR SEUS 
                    DIREITOS. A CLINICA NÃO RECEBERÁ CONTESTAÇÃO SOB HIPÓTESE ALGUMA FORA DO PRAZO DETERMINADO ACIMA
                </p>
            </div>
    </div>
            <? } ?>
            <?
        } else {
            ?>
                <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
