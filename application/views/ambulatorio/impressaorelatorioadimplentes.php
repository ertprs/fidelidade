<meta charset="utf-8">
<div class="content"> <!-- Inicio da DIV content -->

    
    <h4>RELATORIO DE ADIMPLENTES</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <h4>BAIRRO: <?= ($_POST['bairro'] != '') ? $_POST['bairro'] : 'TODOS' ?></h4>
     <h4>FORMA DE PAGAMENTO: <?
    if (count($forma) > 0) {
         echo $forma[0]->nome;
    }else{
          echo "TODOS";
    }
         
        ?>
    </h4>
    <h4>ORDENAR POR: <?
        if (@$_POST['ordenar'] == 'order_nome') {
            echo "NOME";
        } elseif (@$_POST['ordenar'] == 'order_bairro') {
            echo "BAIRRO";
        } else {
            
        }
        ?>
    </h4>
    
    <hr>
    <?
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Endereço</th>
                    <th class="tabela_header">Bairro</th>
                    <th class="tabela_header">Fone</th>
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
                        <td ><?= $item->nome; ?></td>
                        <td ><?= $item->logradouro . " " . $item->numero . " " . $item->complemento . " "; ?></td>
                        <td ><?= $item->bairro?></td>
                        <td ><?= $item->celular . "/" . $item->telefone; ?></td>
                        <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= number_format($item->valor, 2, ",", "."); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="2"><b>TOTAL</b></td>
                    <td colspan="4"><b><?= number_format($total, 2, ",", "."); ?></b></td>
                </tr>
            </tbody>
        </table>

            <?
        }        else {
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
