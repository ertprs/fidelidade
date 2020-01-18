<div class="content"> <!-- Inicio da DIV content -->

    <h4>RELATORIO DE CADASTRO</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Numero Registro</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Segmento</th>
                    <th class="tabela_header">Nascimento</th>
                    <th class="tabela_header">CPF</th>
                    <th class="tabela_header">RG</th>
                    <th class="tabela_header">Endere&ccedil;o</th>
                    <th class="tabela_header">Telefone</th>
                    <th class="tabela_header">Data Cadastro</th>
                    <th class="tabela_header">Cidade</th>
                    <th class="tabela_header">Situa&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
               
                foreach ($relatorio as $item) :
                    $total++;
                    ?>
                    <tr>
                        <td ><?= $item->paciente_id; ?></td>
                        <td ><?= utf8_decode($item->nome); ?></td>
                        <td ><?= utf8_decode($item->convenio); ?></td>
                        <td ><?= substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4); ?></td>
                        <td ><?= utf8_decode($item->cpf); ?></td>
                        <td ><?= utf8_decode($item->rg); ?></td>
                        <td ><?= utf8_decode($item->logradouro) . " " . $item->numero; ?></td>
                        <td ><?
                        echo $item->telefone;
                        if ($item->celular != "") {
                            echo " / ".$item->celular;
                        }                        
                        ?></td>
                        <td ><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        <td ><?= utf8_decode($item->municipio); ?></td>
                        <td ><?= utf8_decode($item->situacao); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="9"><b>TOTAL</b></td>
                    <td ><b><?= $total; ?></b></td>
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
