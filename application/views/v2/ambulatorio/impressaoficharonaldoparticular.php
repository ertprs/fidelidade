<?
$i = 0;
$b =0;
$total = count($exame);
foreach ($exame as $value) :
    $i++;
    $b++;
    $MES = substr($value->data, 5, 2);

    switch ($MES) {
        case "01": $mes = 'Janeiro';
            break;
        case "02": $mes = 'Fevereiro';
            break;
        case "03": $mes = 'Março';
            break;
        case "04": $mes = 'Abril';
            break;
        case "05": $mes = 'Maio';
            break;
        case "06": $mes = 'Junho';
            break;
        case "07": $mes = 'Julho';
            break;
        case "08": $mes = 'Agosto';
            break;
        case "09": $mes = 'Setembro';
            break;
        case "10": $mes = 'Outubro';
            break;
        case "11": $mes = 'Novembro';
            break;
        case "12": $mes = 'Dezembro';
            break;
    }
    ?>

        <? if ($i == 1) {
            ?>
     <hr align="left" width="850" size="1" color=red>
    <p>
            <? 
        }
        ?>

    <table border="1">
        <tbody>
            <tr>
                <td width="200px;"><img align = 'left'  width='160px' height='50px' src=<?= base_url() . "img/LOGO.jpg" ?>></td> 
                <td colspan="2" width="400px;"><img align = 'left'  width='160px' height='50px' src=<?= base_url() . "img/LOGO.jpg" ?>></td> 
                <td width="200px;">&nbsp;&nbsp;&nbsp;</td>        
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vencimento: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $mes . "/" . substr($value->data, 0, 4); ?></td>
                <td colspan="2" >Cliente: <?= $value->paciente; ?></td>
                <td >Vencimento: <?= $mes . "/" . substr($value->data, 0, 4); ?></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parcela: <?= $value->parcela . " / " . $total ?></td>
                                <td colspan="2" rowspan="5">
                    Para gerar 2a via do boleto, dirigir-se ao caixa<br>
                    Sera cobrado uma taxa de R$ 2,00.
                </td>
                <td >Parcela: <?= $value->parcela . " / " . $total?></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente: <?= $value->paciente; ?></td>

                <td >Codigo: <?= $value->paciente_contrato_parcelas_id; ?></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente n&ordm; : <?= $value->paciente_id; ?></td>
                <td >Cliente n&ordm; : <?= $value->paciente_id; ?></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Codigo: <?= $value->paciente_contrato_parcelas_id; ?></td>
                <td >Codigo: <?= $value->paciente_contrato_parcelas_id; ?></td>
            </tr>
            <tr>
                <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor: <?= number_format($value->valor, 2, ',', '.'); ?></td>
                <td >Valor: <?= number_format($value->valor, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td >&nbsp;</td>
                <td colspan="2" rowspan="2"><textarea name="banco" rows="5" cols="60"><?= $empresa[0]->banco; ?></textarea></td>
                <td >&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <p>
    <hr align="left" width="850" size="1" color=red>
    <p>
        <? if ($i == 3 && $b < $total) {
            ?>
            <br style="page-break-before: always;" />
            <? $i = 0;
        }
        ?>
    <? endforeach; ?>
    <script type="text/javascript">
        window.print()


    </script>