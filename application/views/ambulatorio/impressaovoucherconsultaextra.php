<style>
    td{
        font-size: 17px;
        font-family: arial;
    }

</style>
<meta charset="UTF-8">
    <img src="<?=base_url()?>img/cabecalhoSalute.png" height="100px;">
    <table>
        <tbody>
            <tr>
                <td >NOME: <b><?= @$paciente[0]->nome; ?></b></td>
            </tr>
            <tr>
                <td >DATA: <b><?=(@$voucher[0]->data != '') ? date("d/m/Y",strtotime(@$voucher[0]->data)) : ''?></b></td>
            </tr>
            <tr>
                <td >HORA:  <b><?=(@$voucher[0]->horario != '') ? date("H:i", strtotime(@$voucher[0]->horario)) : ''?></b></td>
            </tr>
            <tr>
                <td>LOCAL:  <b><?= $voucher[0]->parceiro; ?></b> - <?= $voucher[0]->logradouro; ?>, <?= $voucher[0]->numero; ?>, <?= $voucher[0]->bairro; ?> - <?= $voucher[0]->municipio; ?></td>
            </tr>

        </tbody>
    </table>


<script type="text/javascript">
    window.print()


</script>