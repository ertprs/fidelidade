<meta charset="utf-8">

    <h4>RELATORIO DE TITULARES SEM CONTRATO</h4>
    <!--<h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>-->
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Operador Cadastro</th>
                    <th class="tabela_header">Data Inatividade</th>
                    <th class="tabela_header">Vendedor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $paciente_id = 0;
                foreach ($relatorio as $item) :
                    if($paciente_id == $item->paciente_id){

                    }else{
                    $total++;
                    ?>
                    <tr>
                        <td ><?= $item->paciente; ?></td>
                        <td ><?= $item->operador_cadastro; ?></td>
                        <td style="text-align: right"><?= date("d/m/Y", strtotime($item->data_atualizacao))?></td>
                        <td ><?= $item->vendedor; ?></td>
                    </tr>
                <?  $paciente_id = $item->paciente_id;
                                    }
                 endforeach; ?>
                <tr>
                    <td colspan="3"><b>TOTAL</b></td>
                    <td colspan="1"><b><?= $total; ?></b></td>
                </tr>
            </tbody>
        </table>
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
