<html>
    <head>
        <title>Relatorio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            td,th{
                font-family: arial;
            }
        </style>
    </head>
    <body>        
        <h3>Relatório Parceiro Verificar</h3>
        <h4> Período: <?= $txtdata_inicio; ?> até   <?= $txtdata_fim; ?></h4>
        <hr>
        <table border=1 cellspacing=0 cellpadding=2 width="100%">
            <tr>
                <th>Dependente</th>
                <th>Procedimento</th>
                <th>Valor</th>
            </tr>
            <?php 
            $valortotal = 0;
            foreach($relatorio  as $item){
                $valortotal += $item->valortotal;
                ?>
            <tr>
                <td><?= $item->dependente; ?></td>
                <td><?= $item->procedimento; ?></td>
                <td>R$ <?= number_format($item->valortotal, 2, ',', '.'); ?></td>
            </tr>
            <?
            }
            ?>
            <tr>
                <td colspan="2">Total:</td>
                <td>R$ <?= number_format($valortotal, 2, ',', '.'); ?></td>
            </tr>            
        </table>
    </body>
</html>
