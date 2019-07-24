<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">VENCIMENTO PRODUTOS</th>
            </tr>
           
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TEMPO DE VENCIMENTO: <?= $_POST['vencimento']; ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? IF ($armazem > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: <?= $armazem[0]->descricao; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: TODOS</th>
                </tr>
            <? } ?>
           

            

        </thead>
    </table>

    <? if (count($relatorio) > 0) {
        ?>
        <style>
            table{
                border-collapse: collapse;
                border-spacing: 20px;
            }
            .tabelaPadrao td,th{
                padding: 6px;
            }
        </style>
        <table border="1" class="tabelaPadrao">
            <thead>
                <tr style="background-color: gray;">
                    <th class="tabela_teste"><font size="-1">Validade</th>
                    <th class="tabela_teste"><font size="-1">Produto</th>
                    <th class="tabela_teste"><font size="-1">Armazém</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $armazem = "";
                $paciente = "";
                foreach ($relatorio as $item) :
                        $qtde++;
                        $qtdetotal++;?>
                        <tr>
                            <td><font size="-1"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td><font size="-1"><?= $item->produto; ?></td>
                            <td><font size="-1"><?= $item->armazem; ?></td>
                        </tr>


                        <?php
                        
                    
                endforeach;
                ?>

                <!-- <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                </tr> -->
            </tbody>
        </table>
        <!-- <hr> -->
        <!-- <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <td width="140px;" align="center" ><b>Nr. Itens: &nbsp;<?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>

        </table> -->
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>