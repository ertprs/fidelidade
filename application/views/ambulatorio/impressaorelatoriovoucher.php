<html>
    <head>
        <title>Relatorio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            td,th{
                font-family: arial;
            }
            .corverde td{
                color: green;
            }
        </style>
    </head>
    <body>        
        <h3>Relatório Parceiro Verificar</h3>
        <h4> Período: <?= $txtdata_inicio; ?> até   <?= $txtdata_fim; ?></h4>
        <hr>
        <table border=1 cellspacing=0 cellpadding=2 width="100%">
            <tr>
                <th>Nome</th>
                <th>Parceiro</th>
                <th>Valor Voucher</th>
                <th>Data e Hora (Voucher)</th>
                <th>Operador Cadastro</th>
            </tr>
            <?php 
            $valor_total = 0;
            foreach($relatorio  as $item){ 
                $data = date("d/m/Y", strtotime(str_replace('-', '/', $item->data))); 
                if($item->gratuito == 't'){ 
                ?>
                <tr class="corverde">
                <? if($item->pessoa != ''){?>
                <td><?= $item->pessoa; ?></td>
                <?}else{?>
                    <td><?= $item->paciente; ?></td>
                <?}?>
                <td><?= $item->fantasia; ?></td>
                <td>GRATUITO</td>
                <td><?= $data .' - '.$item->horario; ?></td>
                <td><?= $item->operador; ?></td>
                </tr>
                <?
                }else{
                     $valor_total += $item->valor;
                ?>
            <tr>
                 <td><?= $item->voucher_consulta_id; ?></td>
            <? if($item->pessoa != ''){?>
                <td><?= $item->pessoa; ?></td>
            <?}else{?>
                <td><?= $item->paciente; ?></td>
            <?}?>
                <td><?= $item->fantasia; ?></td>
                <td>R$ <?= number_format($item->valor, 2, ',', '.'); ?></td>
                <td><?= $data .' - '.$item->horario; ?></td>
                <td><?= $item->operador; ?></td>
            </tr>
            <?
             }
            }
            ?>
            <tr>
                <td colspan="2">Total</td>
                 <td colspan="3">R$   <?= number_format($valor_total, 2, ',', '.'); ?></td>
            </tr>
          
        </table>
    </body>
</html>
