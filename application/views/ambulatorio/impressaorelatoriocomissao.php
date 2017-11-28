<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Comiss&atilde;o</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">VENDEDOR: <?= $vendedor ?></th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdatainicio; ?> ate <?= $txtdatafim; ?></th>
            </tr>

        </thead>
    </table>
    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <td class="tabela_teste">Cliente</th>
                    <td class="tabela_teste">Plano</th>
                    <td class="tabela_teste">Comiss&atilde;o</th>
                </tr>
            </thead>
            <hr>
            <tbody>
     
                <?php
                $valortotal = 0;
                foreach ($relatorio as $item) :                                           
                    $valortotal = $valortotal + $item->comissao;


                    ?>                      
                    <tr>
                        <td ><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                        <td ><font size="-2"><?= utf8_decode($item->plano); ?></td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($item->comissao, 2, ',', '.'); ?></td>
                    </tr>

                <? endforeach; ?>
                                        <tr>
                        <td COLSPAN = 2>VALOR TOTAL</td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($valortotal, 2, ',', '.'); ?></td>
                    </tr>
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->

