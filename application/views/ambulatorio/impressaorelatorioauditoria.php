<meta charset="utf-8">
  
<style>
    td{
        font-family: arial;
    }
</style>
<title>Relatório</title>
<div class="content"> <!-- Inicio da DIV content -->
    <h4>RELATORIO DE INADIMPLENTES</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>

    <hr>
    <table border="1"> 
        <?
        if (count($relatorio) > 0) {
            ?> 

            <thead>
                <tr>
                    <th class="tabela_header">Numero do Cliente</th>
                    <th class="tabela_header">Usuario</th>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Hora</th>
                    <th class="tabela_header">Cliente</th>
                    <th class="tabela_header">Ação</th>
                     <th class="tabela_header">Observação</th>

                </tr>
            </thead>
            <tbody>
                <?php
                // $total = 0;
                // $qtd_pacientes = 0;
                // $qtd_parcelas = 0;
                foreach ($relatorio as $item) : 
                            ?>
                            <tr>
                                <td >  <?= @$item->paciente_id; ?></td>
                                <td ><?= @$item->operador; ?></td>
                                <td ><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4) ?></td>
                                <td ><?= substr($item->data_cadastro, 10, 9)?></td>
                                <td ><?= @$item->paciente ?></td>
                                <td ><?= @$item->acao ?></td>
                                <td><?= (isset(json_decode($item->json,true)['observacao'])) ? json_decode($item->json,true)['observacao'] : "";?></td>


                            </tr>
                <?

            
         endforeach;
    ?>

            </tbody> 
    <?
} else {
    ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>
    </table>

</div> <!-- Final da DIV content -->


<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
