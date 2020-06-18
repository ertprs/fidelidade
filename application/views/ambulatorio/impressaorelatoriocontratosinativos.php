<meta charset="utf-8">

    <h4>RELATORIO DE CONTRATOS</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <h4>BUSCANDO POR: <?= ($_POST['tipobusca'] == "I") ? "INATIVOS" : "ATIVOS"; ?></h4>
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Número</th>
                    <th class="tabela_header">Plano</th>
                    <th class="tabela_header">Telefone</th>
                    <th class="tabela_header">Celular</th>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Vendedor</th>
                    <th class="tabela_header">Indicação</th>
                    <? if($_POST['tipobusca'] == 'I'){ ?>
                        <th class="tabela_header">Data Exclusão</th>
                        <th class="tabela_header">Operador Exclusão</th>
                    <? } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($relatorio as $item) :
                    $total++;
                    ?>
                    <tr>
                        <td ><?= $item->nome; ?></td>
                        <td ><?= $item->paciente_contrato_id; ?></td>
                        <td ><?= $item->plano; ?></td> 
                        <td ><?= $item->telefone; ?></td>
                        <td ><?= $item->celular; ?></td> 
                        <td ><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        <td ><?= $item->vendedor; ?></td>
                        <td ><?= $item->indicacao; ?></td>
                        <? if($_POST['tipobusca'] == 'I'){ ?>
                        <td ><?= substr($item->data_atualizacao, 8, 2) . "/" . substr($item->data_atualizacao, 5, 2) . "/" . substr($item->data_atualizacao, 0, 4); ?></td>
                            <td><?= $item->operador; ?></td>
                        <? } ?>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <? if($_POST['tipobusca'] == 'I'){ ?>
                        <td colspan="6"><b>TOTAL</b></td>
                    <? } else { ?>
                        <td colspan="4"><b>TOTAL</b></td>
                    <? } ?>
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
