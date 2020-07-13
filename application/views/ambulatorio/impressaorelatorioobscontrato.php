 
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
        <h3>Relatório Observação Contrato</h3>
        <h3>Data: <?= $data_inicio; ?> até <?= $data_fim; ?></h3>
        <hr>
        <table border="2">
            <thead>
            <tr> 
                <th>Operador Cadastro</th>
                <th>Data de Cadastro / Hora</th>
                <th>Observação</th>
            </tr>
            </thead>
            <?
            foreach($relatorio as $item){
                ?>
            <tr>
                <td><?= $item->operador; ?></td>
                <td> <?= date('d/m/Y H:i:s',strtotime($item->data_cadastro)); ?></td>
                 <td><?= $item->observacao; ?></td>
            </tr>
            
            <?
            }
            ?>
        </table>

    </body>
</html>
