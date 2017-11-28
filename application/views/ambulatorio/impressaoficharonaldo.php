<?
$i = 0;
$b = 0;
$total = count($exame);

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
                <td width="250px;"><img align = 'left'  width='160px' height='50px' src=<?= base_url() . "img/LOGO.jpg" ?>></td> 
                <td colspan="2" width="400px;"><img align = 'left'  width='160px' height='50px' src=<?= base_url() . "img/LOGO.jpg" ?>> &nbsp;&nbsp;<b>TAXA DE ADMINISTRA&Ccedil;&Atilde;O</b></td> 
                <td width="200px;">Valor R$: <p><font size = 6><b>&nbsp;&nbsp;&nbsp;&nbsp;<?= number_format($exame[0]->valor, 2, ',', '.'); ?></b></font></td>        
            </tr>
            <tr>
                <td >BENEFIC&Aacute;RIO: <P><b><?= $exame[0]->paciente; ?></b></td>
                <td colspan="2" >BENEFIC&Aacute;RIO: <b><?= $exame[0]->paciente; ?></b></td>
                <td >PLANO:<b> <?= utf8_decode($exame[0]->plano) ?></b></td>
            </tr>
            <tr>
                <td >ENDERE&Ccedil;O:<p><font size = -2><b><?= substr(utf8_decode($exame[0]->logradouro), 0, 20) . "  " . $exame[0]->numero . " - " . utf8_decode($exame[0]->bairro)  . " - " . $exame[0]->municipio ?></b></font></td>
                <td colspan="3">ENDERE&Ccedil;O:&nbsp;&nbsp;<b> <?= utf8_decode($exame[0]->logradouro) . "  " . $exame[0]->numero . " - " . utf8_decode($exame[0]->bairro)  . " - " . $exame[0]->municipio ?></b></td>
            </tr>
            <tr>
                <td >DOCUMENTO:  PARC <b><?= $exame[0]->parcela . " / " . $total ?></b></td>
                <td colspan="3">CONTATOS &nbsp;&nbsp; <b><?= "(" . substr($exame[0]->telefone, 0, 2) . ")". substr($exame[0]->telefone, 3, 4) . ".". substr($exame[0]->telefone, 7, 4);?></b></td>
            </tr>

            <tr>
                <td >Valor: <b><?= number_format($exame[0]->valor, 2, ',', '.'); ?></b></td>
                <td colspan="3">DOCUMENTO:  PARC <b><?= $exame[0]->parcela . " / " . $total ?></b>&nbsp;&nbsp;&nbsp; VALOR: <b><?= number_format($exame[0]->valor, 2, ',', '.'); ?></b> &nbsp;&nbsp;&nbsp;VENCIMENTO: <b><?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?></b></td>
            </tr>

            <tr><td >Vencimento:<b><?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?></b><br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<font size = -3><b>VIA DO CLIENTE</b></font></td>
                <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br><font size = -3><b>VIA DO ESTABELECIMENTO</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;ASSINATURA DO BENEFICI&Aacute;RIO</font></td>
            </tr>
        </tbody>
    </table>
    <p>
    <hr align="left" width="850" size="1" color=red>
    <p>

    <script type="text/javascript">
        window.print()


    </script>