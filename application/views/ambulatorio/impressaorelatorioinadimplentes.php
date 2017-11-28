<div class="content"> <!-- Inicio da DIV content -->

    <h4>RELATORIO DE INADIMPLENTES</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatorio as $item) :
                    $total = $total + $item->valor;
                    ?>
                    <tr>
                        <td ><?= utf8_decode($item->nome); ?></td>
                        <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="2"><b>TOTAL</b></td>
                    <td colspan="2"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>


            <?
        }
        else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
