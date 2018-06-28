<meta charset="utf-8">

    <h4>RELATORIO DE DEPENDENTES</h4>
    <!--<h4>PERIODO: <?//= $txtdata_inicio; ?> ate <?//= $txtdata_fim; ?></h4>-->
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <!--<th class="tabela_header">Dependente</th>-->
                    <!--<th class="tabela_header">Titular</th>-->
                    <th class="tabela_header">ID</th>
                    <th class="tabela_header">Nome</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatorio as $item) :
                    $total++;
                    ?>
                    <tr>
                        <td ><?= $item->operador_id; ?></td>
                        <td ><?= $item->nome; ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="1"><b>TOTAL</b></td>
                    <td colspan="1"><b><?= $total; ?></b></td>
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
