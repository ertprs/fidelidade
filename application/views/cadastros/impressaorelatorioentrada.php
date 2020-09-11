
<?php 
//echo "<pre>";
//print_r($relatorioentrada);

?>
<meta charset="UTF-8">

<style>
    th{
        font-family: arial;
    }
</style>

<title>Relatório Entrada</title>
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO<?= $tipo[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODOS OS TIPOS</h4>
    <? } ?>
    <? if (count($classe) > 0) { ?>
        <? $texto = strtr(strtoupper($classe[0]->descricao), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); ?>
        <h4>CLASSE: <?= $texto; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLASSES</h4>
    <? } ?>
    <? if (count($forma) > 0) { ?>
        <h4>CONTA:<?= $forma[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CONTAS</h4>
    <? } ?>
    <? if (count($credordevedor) > 0) { ?>
        <h4><?= $credordevedor[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS OS DEVEDORES</h4>
    <? } ?>
    <h4>RELATORIO DE ENTRADA</h4>
    <h4>PERIODO: <?= date('d/m/Y', strtotime($txtdata_inicio)); ?> ate <?= date('d/m/Y', strtotime($txtdata_fim)); ?></h4>
    <hr>
    <?
    
//    echo "<pre>";
//    print_r($relatorioentrada);
    
    if ($relatorioentrada > 0) {
        ?>
        <table border=1 cellspacing=0 cellpadding=2 bordercolor="666633">
            <thead>
                <tr>
                    <!-- <th width="100px;" class="tabela_header">ID</th> -->
                    <th width="100px;" class="tabela_header">Numero do Cliente</th>
                    <th width="100px;" class="tabela_header">Conta</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Dt entrada</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Valor</th>
                    <? if ($mostrar_form_pagamento == 'SIM'): ?>
                        <th class="tabela_header">Forma de Pagamento</th>
                    <? endif; ?>
                    <? if ($operador != 0) { ?>
                        <th class="tabela_header">Operador</th>
                    <? } ?>
                    <th class="tabela_header">Observacao</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                echo "<pre>";
//                print_r($relatorioentrada);
                $tipoEntradaArray = Array();
                $total = 0;
                $total_parcelas = 0;
                $relatorio_array = Array();
                foreach ($relatorioentrada as $item) :
                    @$tipoEntradaArray[$item->classe]++; 
                    @$relatorio_array[$item->conta] += $item->valor + $valor;
                     
                    @$qtd_parcelas++;
                    @$qtd_parcelas_{$item->forma_entradas_saida_id}++;
                    $total += $item->valor;
                    ?>
                    <tr>
                    <!-- <td ><?= @$item->entradas_id; ?></td> -->
                        
                        <td ><? if($item->empresa_cadastro_id != ""){
                           echo @$item->empresa_cadastro_id;
                        }else{
                           echo @$item->paciente_id; 
                        }
                            
                        ?></td>
                        <td ><?= @$item->conta; ?></td>
                        <td ><?= @$item->razao_social; ?>&nbsp;</td>
                        <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= $item->tipo; ?>&nbsp;</td>
                        <td ><?= $item->classe; ?>&nbsp;</td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                        <? if ($operador != 0) { ?>
                            <td ><?= $item->operador; ?></td>
                        <? } ?>
                        <? if ($mostrar_form_pagamento == 'SIM'): ?>
                            <td ><?= ($item->forma_rendimento  != "" ) ? $item->forma_rendimento : $item->forma_rendimento2 ; ?>&nbsp;</td>
                        <? endif; ?>


                        <td ><?= $item->observacao; ?>&nbsp;</td>
                    </tr>
                <? endforeach; ?>
                    
                    
                <tr>
                    <td colspan="4"><b>TOTAL</b></td>
                    <td colspan="2"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>

            </tbody> 

            <? 
        } else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>
    </table>
</div> <!-- Final da DIV content -->
<br>
  
<?
//echo "<pre>";
//print_r($tipoEntradaArray);
?>
<table  border=1 cellspacing=0 cellpadding=2 bordercolor="666633">
                <thead>
                    <tr>
                        <th class="tabela_header" colspan="2">Resumo</th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Descrição</th>
                        <th class="tabela_header">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?   
                    $estilo_linha = "tabela_content01";
                 foreach($relatorio_array as $key => $val){ 
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01"; 
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"> <?= $key;?> </td>
                            <td class="<?php echo $estilo_linha; ?>">R$<?= number_format(@$val, 2, ",", "."); ?></td>
                        </tr>
                    <? } ?>
                </tbody>
                 <tfoot>
                     <? foreach($tipoEntradaArray as $key => $item){?>
                      <tr>
                        <th class="tabela_footer"> <?= $key; ?> </th>
                         <th class="tabela_footer" > <?= $item; ?> </th>
                    </tr> 
                     <?}?>
                    <tr>
                        <th class="tabela_footer" colspan="2">
                            Total Parcelas: <?=  @$qtd_parcelas; ?>
                        </th>
                    </tr>
                </tfoot>
               
            </table>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
