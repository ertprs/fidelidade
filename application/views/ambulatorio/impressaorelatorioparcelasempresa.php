<html>
    <head>
        <title>Relatorio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            td{
                font-family: arial;
            }
            
        </style>
    </head>
    <body>
        <h2>Relatório Empresa</h2>
        <h3>Empresa: <?= $empresa[0]->nome; ?></h3> 
        <h3>Mês: <?= $mes; ?></h3> 
        <hr>
        <table   border=1 cellspacing=0 cellpadding=2 >
            <tr>
                <th>Nome</th>
                <th>Cpf</td>             
                <th title="Já incluso o valor dos Dependentes">Valor</th>
                <th title="Já incluso o valor dos Dependentes">Valor Total</th>                
            </tr>
            
            <?
            $valor_total = 0;
            $contador_total = 0;
            //echo "<pre>";
            //print_r($relatorio);
            foreach($relatorio as $item){
                $valor_dependentes = 0;
                 $dependentes =  $this->paciente->listardependentescontrato($item->paciente_contrato_id);
                 // echo '<pre>';
                  // print_r($dependentes);
                   $quantidade_clientes = 0;
                   if(count($dependentes) > 0){
                       $quantidade_clientes = $dependentes[0]->parcelas;
                    }
                //  die;
                    $i = 0;
                    $a = 1;
                    foreach($dependentes as $item2){ 
                        if($item2->situacao == "Dependente"){
                            if($a >= $quantidade_clientes){
                               $valor_dependentes += $item2->valoradcional;
                            }
                            $a++;
                            $i++;
                        }
                    }
                  $valor_total   += ($item->valor + $valor_dependentes ); 
                ?>
            <tr>
                <td><?= $item->paciente ?></td>
                <td><?
                $cnpj_cpf = preg_replace("/\D/", '', $item->cpf);
                echo @preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf); ?>
                </td>
                <td   >R$ <?= number_format($item->valor, 2, ',', '.'); ?> (<?=$i;?>) </td>
               <td  title="Já incluso o valor dos Dependentes">R$ <?= number_format($item->valor + $valor_dependentes, 2, ',', '.'); ?></td>
               <? 
               $total_titular = ($item->valor + $valor_dependentes)*$mes;
               $contador_total = $contador_total + $total_titular;
               ?>
            </tr>            
            <?
             foreach($dependentes as $item2){
                        if($item2->situacao == "Dependente"){  
                            ?> 
            <tr>
                <td style="color:green;" colspan="4"><?= $item2->nome; ?></td>
            </tr>
                            <?
                        }
                    }                    
                 
            
            }
?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                 <td><b>R$ <?=  number_format($valor_total, 2, ',', '.'); ?></b></td>
            </tr>
            
        </table>

    </body>
</html>
