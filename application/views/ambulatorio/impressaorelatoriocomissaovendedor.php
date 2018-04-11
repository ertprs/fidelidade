<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Comiss&atilde;o Vendedor</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">VENDEDOR: <?= $vendedor[0]->nome ?></th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= date("d/m/Y", strtotime($txtdatainicio)); ?> até <?= date("d/m/Y", strtotime($txtdatafim)); ?></th>
            </tr>

        </thead>
    </table>
    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste">Cliente</th>
                    <th class="tabela_teste">Plano</th>
                    <th class="tabela_teste">Data</th>
                    <th class="tabela_teste">Valor Parcela</th>
                    <th class="tabela_teste">Comissão Mensal</th>
                    <th class="tabela_teste">Situação da Parcela</th>
                </tr>
            </thead>
            <hr>
            <tbody>

                <?php
                $valortotal = 0;
                foreach ($relatorio as $item) :
                    if ($item->ativo == 'f') {
                        $valortotal = $valortotal + $item->comissao_vendedor_mensal;
                    }
                    ?>                      
                    <tr>
                        <td ><font size="-2"><?= $item->paciente; ?></td>
                        <td ><font size="-2"><?= $item->plano; ?></td>
                        <td ><font size="-2"><?= date("d/m/Y", strtotime($item->data)) ?></td>
                        <td ><font size="-2"><?= number_format($item->valor, 2, ',', '.'); ?></td>
                        <td style='text-align: center;<?
                        if ($item->ativo != 'f') {
                            echo 'color:red';
                        } else {
                            
                        }
                        ?>' ><font size="-2"><?= number_format($item->comissao_vendedor_mensal, 2, ',', '.'); ?></td>
                        <td style='text-align: center;' ><font size="-2"><?
                            if ($item->ativo == 'f') {
                                echo 'Paga';
                            } else {
                                echo 'Não-Paga';
                            }
                            ?></td>
                    </tr>

                <? endforeach; ?>
                <tr>
                    <td colspan="5">VALOR TOTAL</td>
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

