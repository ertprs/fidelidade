<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>CONFERENCIA BALANÇO DO DIA</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime(@$txtdata_inicio))); ?> até <?= str_replace("-", "/", date("d-m-Y", strtotime(@$txtdata_fim))); ?></h4>

    <?
    ?>

</div>

<hr>


<?
//echo "<pre>";
//    print_r($relatorio);

$totalcataoprocedimento = 0;
$totaldinheiroprocedimento = 0;

foreach ($relatorio as $item) {
    @$empresacataototal[$item->empresa_id] = 0;
    @$empresadinheirototal[$item->empresa_id] = 0;
    ?>
<? }
?>




<?

foreach ($relatorio as $item) {

    if ($item->faturado == 't' && $item->cartao1 == 't') {
        @$empresacataototal[$item->empresa_id] = $empresacataototal[$item->empresa_id] + @$item->valor1;
        @$empresacataototal[$item->empresa_id] = $empresacataototal[$item->empresa_id] + $item->valor;
        $totalcataoprocedimento = $totalcataoprocedimento + $item->valor1;
        $totalcataoprocedimento = $totalcataoprocedimento + @$item->valor;
    }



    if ($item->faturado == 't' && @$item->cartao2 == 't'
    ) {
        @$empresacataototal[$item->empresa_id] = $empresacataototal[$item->empresa_id] + $item->valor2;
        $totalcataoprocedimento = $totalcataoprocedimento + $item->valor2;
    }





    if ($item->faturado == 't' && @$item->cartao3 == 't'
    ) {
        @$empresacataototal[$item->empresa_id] = $empresacataototal[$item->empresa_id] + $item->valor3;
        $totalcataoprocedimento = $totalcataoprocedimento + $item->valor3;
    }




    if ($item->faturado == 't' && @$item->cartao4 == 't'
    ) {
        @$empresacataototal[$item->empresa_id] = $empresacataototal[$item->empresa_id] + $item->valor4;
        $totalcataoprocedimento = $totalcataoprocedimento + $item->valor4;
    }



    if ($item->faturado == 't' && $item->cartao1 == 'f') {
        @$empresadinheirototal[$item->empresa_id] = @$empresadinheirototal[$item->empresa_id] + @$item->valor1;
        @$empresadinheirototal[$item->empresa_id] = @$empresadinheirototal[$item->empresa_id] + $item->valor;
        $totaldinheiroprocedimento = $totaldinheiroprocedimento + $item->valor1;
        $totaldinheiroprocedimento = $totaldinheiroprocedimento + @$item->valor;
    }


    if ($item->faturado == 't' && @$item->cartao2 == 'f') {
        @$empresadinheirototal[$item->empresa_id] = @$empresadinheirototal[$item->empresa_id] + $item->valor2;
        $totaldinheiroprocedimento = $totaldinheiroprocedimento + $item->valor2;
    }


    if ($item->faturado == 't' && @$item->cartao3 == 'f') {
        @$empresadinheirototal[$item->empresa_id] = @$empresadinheirototal[$item->empresa_id] + $item->valor3;
        $totaldinheiroprocedimento = $totaldinheiroprocedimento + $item->valor3;
    }

    if ($item->faturado == 't' && @$item->cartao4 == 'f') {
        @$empresadinheirototal[$item->empresa_id] = @$empresadinheirototal[$item->empresa_id] + $item->valor4;
        $totaldinheiroprocedimento = $totaldinheiroprocedimento + $item->valor4;
    }
    ?>

<? }
?>


<style>


</style>

<!-- Final da DIV content -->
<div style=" display: inline-block;">
    <table boder="2" style="border:2px solid black;">
        <tbody>
            <tr>
                <td colspan="4" bgcolor="white"><center><font size="-1">BALANÇO DO DIA - <?= str_replace("-", "/", date("d-m-Y", strtotime(@$txtdata_inicio))); ?> até <?= str_replace("-", "/", date("d-m-Y", strtotime(@$txtdata_fim))); ?>   </center></td>
<!--        <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1"></center></td>-->
        </tr>
        <tr>
            <td colspan="1" bgcolor="#A4A4A4"><center><font size="-1" ><b style="color:white; ">Empresa</b></center></td>
        <td colspan="1" bgcolor="#A4A4A4"><center><font size="-1"><b style="color:white; ">Dinheiro</b></center></td>
        <td colspan="1" bgcolor="#A4A4A4"><center><font size="-1"><b style="color:white; ">Cartão</b></center></td>
        <td colspan="1" bgcolor="#A4A4A4"><center><font size="-1"><b style="color:white; ">Total</b></center></td>
        </tr>
<?
foreach ($empresa as $item) {
    ?>
            <tr>
                <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1"> <? echo $item->nome; ?></center></td>
            <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1"> <? echo "R$ " . number_format(@$empresadinheirototal[$item->empresa_id], 2, ',', '.'); ?></center></td>  
            <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1"> <? echo "R$ " . number_format(@$empresacataototal[$item->empresa_id], 2, ',', '.'); ?></center></td>
            <td colspan="1" bgcolor="#C0C0C0"><center><font size="-1"> <? echo "R$ " . number_format(@$empresacataototal[$item->empresa_id] + @$empresadinheirototal[$item->empresa_id], 2, ',', '.'); ?></center></td>
            </tr>

<? }
?>
        <tr>
            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp; </center></td>
        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp; </center></td>

        </tr>
        <tr>
            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp; </center></td>
        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp; </center></td>

        </tr>
        <tr>
            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp;</center></td>
        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> &nbsp; </center></td>

        </tr>
        <tr>
            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> Valor Total em Dinheiro </center></td>

        <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"><?= "R$ " . number_format($totaldinheiroprocedimento, 2, ',', '.'); ?></center></td>
        </tr>
        <tr>
            <td colspan="3" bgcolor="#C0C0C0"><center><font size="-1"> Valor Total Dinheiro + Cartão </center></td>

        <td colspan="3" bgcolor="#C0C0C0" ><center><font size="-1"><?= "R$ " . number_format($totalcataoprocedimento + $totaldinheiroprocedimento, 2, ',', '.'); ?></center></td>
        </tr>





        </tbody>

    </table>
</div>












<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>


