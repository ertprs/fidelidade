<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Representante Comercial</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">REPRESENTANTE: <?= $vendedor ?></th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= date("d/m/Y",strtotime($txtdatainicio)); ?> ate <?=  date("d/m/Y",strtotime($txtdatafim)); ?></th>
            </tr>

        </thead>
    </table>

    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste">Cliente</th>
                    <th class="tabela_teste">Representante</th>
                    <th class="tabela_teste">Gerente</th>
                    <th class="tabela_teste">Vendedor</th>
                </tr>
            </thead>
            <hr>
            <tbody>
     
                <?php
                $valortotal = 0;
                $total = 0;
                foreach ($relatorio as $item) :      
                    $total++;
                    
                    $valor_comissao = $item->comissao;
                                      
                    $valortotal = $valortotal + $valor_comissao;


                    ?>                      
                    <tr>
                        <td ><font size="-2"><?= $item->paciente; ?></td>
                        <td ><font size="-2"><?= $item->representante; ?></td>
                        <td ><font size="-2"><?= $item->gerente; ?></td>
                        <td ><font size="-2"><?= $item->vendedor; ?></td>
                    </tr>

                <? endforeach; ?>
                    <tr>
                        <td COLSPAN = 4><font size="-1">TOTAL: <?=$total?></td>
                        <!-- <td COLSPAN = 3></td> -->
                        <!-- <td style='text-align: center;' ><font size="-1">VALOR TOTAL: <?= number_format($valortotal, 2, ',', '.'); ?></td> -->
                    </tr>
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->

