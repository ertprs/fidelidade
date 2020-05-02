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
                <th>Valor Voucher</th>
                <th>Data e Hora (Voucher)</th>
                <th>Operador Cadastro</th>
            </tr>
            <?php 
            foreach($relatorio  as $item){
                $data = date("d/m/Y", strtotime(str_replace('-', '/', $item->data)));

                if($item->gratuito == 't'){
                ?>
                <tr class="corverde">
                <td><?= $item->paciente; ?></td>
                <td>GRATUITO</td>
                <td><?= $data .' - '.$item->horario; ?></td>
                <td><?= $item->operador; ?></td>
                </tr>
                <?
                }else{
                ?>
            <tr>
                <td><?= $item->paciente; ?></td>
                <td>R$ <?= number_format($item->valor, 2, ',', '.'); ?></td>
                <td><?= $data .' - '.$item->horario; ?></td>
                <td><?= $item->operador; ?></td>
            </tr>
            <?
            }
            }
            ?>
          
        </table>
    </body>
</html>
