<html>
    <head>
        <title>Relatório</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body> 
        <h2>  Relátorio de Pesquisa</h2>
        <h3>Data: <?= $txtdata_inicio; ?> até <?= $txtdata_fim; ?></h3>
        <hr>
        <table border="2">
            <thead>
                <tr>
                    <th>Data Cadastro</th>
                    <th>Operador Cadastro</th>
                    <th>Parceiro</th>
                    <th>Pesquisa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($relatorio as $item){ ?>
                <tr>
                    <td><?=  date('d/m/Y',strtotime($item->data_cadastro)) ; ?></td>
                    <td><?=   $item->operador; ?></td>
                    <td><?=  $item->fantasia;  ?></td>
                    <td><?
                    $colunas = json_decode($item->json,true);
                    foreach($colunas as $key => $value){
                        $coluna = "";
                        
                        if($key == "paciente_id"){
                           $coluna = "Matrícula";  
                        }
                        if($key == "cpf"){
                          $coluna = "CPF";    
                        }
                        if($key == "nome"){
                          $coluna = "Nome";    
                        }
                        if($key == "procedimento_convenio_id"){
                            if($value > 0){
                                 $res =  $this->guia->listarprocedimento($value);
                               $value =  $res[0]->procedimento;  
                            }
                         
                        
                          $coluna = "Procedimento";    
                        }  
                        if($value != ""){
                        echo $coluna." : ".$value;
                        echo "<br>";
                        }
                    }
                     ?></td>
                </tr> 
                <? }?>
            </tbody>
        </table>

    </body>
</html>
