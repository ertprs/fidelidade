 <meta charset="UTF-8">





<?
$total_realizados = 0;
?>

 
<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }.linha-vertical {
  height: 160px;/*Altura da linha*/
  border-left: 1px solid black;/* Adiciona borda esquerda na div como ser fosse uma linha.*/
  margin-left:570px;
 margin-top:-96px;
    }#nome_desc{
       background-image: linear-gradient(-90deg, yellow, white);  
        
        
    }
</style>


<div style=" display: inline-block;border:2px solid black;">
    <table border="0" >
        <tbody> 
            <tr style="background-color:white;">               
                <td colspan="6" ><font size="-1"style="background-color:white;"><center><b>Período</b></center></td>                 
            </tr>
            <tr style="background-color:white;">    
                <td colspan="6" style="border-bottom:1px solid black;"><font size="-1"style="background-color:white;"><center><b><?= $data_inicio; ?> - <?= $data_fim; ?></b></center></td>           
            </tr>
            <tr>
                <td colspan="" ><font size="-1" style="background-color:white;"> <b>Razão social</b></td>
                <td colspan="4" ><font size="-1" style="background-color:white;"><b>Nome fantasia</b></td>         
                <td colspan="4" ><font size="-1" style="background-color:white;"><b>CNPJ</b></td>
            </tr>
            <tr>
                <td colspan=""  style=' background-color:white;'>   <?= $empresa[0]->nome ?> </td>
                <td colspan="4"  style=' background-color:white;'>    <?= $empresa[0]->nome ?> </td>
                <td colspan="4"  style=' background-color:white;'>    <?= $empresa[0]->cnpj ?> </td>
            </tr>


            <?
//            
//              echo "<pre>";;
//          print_r($relatoriosetoraso);
            
            $array_7 = Array();
            foreach ($relatoriosetoraso as $item_7) {
                $impressao_aso = json_decode($item_7->impressao_aso);
                $setor = $this->saudeocupacional->carregarsetorprocedimento($impressao_aso->setor);
                $array_7[] = $item_7->nome_procedimento;
            }
            
//              echo "<pre>";
            $result_7 = array_unique($array_7);
//            print_r($result_7);
            $array = Array();
            foreach ($relatoriosetoraso as $item) {
                $impressao_aso = json_decode($item->impressao_aso);
                $setor = $this->saudeocupacional->carregarsetorprocedimento($impressao_aso->setor);
                $array[] = $setor[0]->aso_setor_id;
                @$contador[$setor[0]->aso_setor_id][$item->nome_procedimento]++;
                 @$array_verificar_funcionario[$setor[0]->aso_setor_id][$item->paciente_id] ++;

                if ($array_verificar_funcionario[$setor[0]->aso_setor_id][$item->paciente_id] > 1) {
                    
                } else {
                    @$contador_fun[$setor[0]->aso_setor_id] ++;
                }
                
            }
//            echo "<pre>";
            $result = array_unique($array);
//            print_r($result);
//            echo "<pre>";
            $result2 = $array;
//            print_r($result2);
//            $valor = array_count_values($result2);
//            print_r($valor);
//            echo "<pre>";;
//            print_r($relatoriofuncaoaso);
            $array4 = Array();
            $array5 = Array();
            $varificar = Array();
            $array8 = Array();
//           $resultado4 =  array_unique($array4); 
            @$impressao_aso = json_decode($relatoriosetoraso[0]->impressao_aso);
            @$setor = $this->saudeocupacional->carregarsetorprocedimento($impressao_aso->setor);
//            echo $funcao[0]->descricao_funcao;
            $setor_aso['setor_aso'] = $this->saudeocupacional->listasetoraso();
            @$impressao_aso = json_decode($item->impressao_aso);
            foreach ($result as $item) {
                echo "<tr >";
                echo "<td colspan='6' id='nome_desc' style=' border-bottom:1px solid black; border-top:1px solid black;'> <center><b> Setor</b>  <br>    ";
                
                foreach ($setor_aso['setor_aso'] as $item2) {
                    $setor = $this->saudeocupacional->carregarsetorprocedimento($impressao_aso->setor);
                    if ($item2->aso_setor_id == $item[0]) {
                        echo $item2->descricao_setor;
                    }
                }     
                echo "</center></td>";
                echo "</tr>";
                echo "
                    <tr>
                     <td style='border-bottom:1px solid black;background-color:white;'> <b>Exame</b> </td>
                     <td style='border-bottom:1px solid black;background-color:white;'>  </td>
                     <td style='border-bottom:1px solid black;background-color:white;'> <b>Realizado</b> </td>
                     <td style='border-bottom:1px solid black;background-color:white;'> <b>Alterado</b> </td>
                     <td style='border-bottom:1px solid black;background-color:white;'> <b>Alterado%</b> </td>
                     <td colspan='2'  style='border-bottom:1px solid black;background-color:white;'> <b>Nº.de Exames para o ano Seguinte</b></td>
                    </tr><tr>
                    ";
                foreach ($relatoriosetoraso as $item3) {
                    $impressao_aso = json_decode($item3->impressao_aso);
                    $setor3 = $this->saudeocupacional->carregarsetorprocedimento($impressao_aso->setor);
//                  echo  $funcao[0]->aso_funcao_id;         
                    ?>
                    <?
                    if ($setor3[0]->aso_setor_id == $item[0]) {


                        @$varificar[$setor3[0]->aso_setor_id][$item3->nome_procedimento]++;
                        if ($varificar[$setor3[0]->aso_setor_id][$item3->nome_procedimento] > 1) {
                            
                        } else {
                            ?> 
                            <tr>
                                <td>                                   
                                    <?
                                    $array4[$item[0]] = $relatoriosetoraso[0]->p2;
                                    ?>    
                                    <?
                                    $resultado5 = $array4;
                                    foreach ($resultado5 as $key4 => $item4) {
                                        if ($key4 == $item[0]) {

                                            echo $item3->nome_procedimento." (".$item3->tipo.")";
                                        }
                                    }
                                    ?> 
                                </td>  
                                 <td>

                                </td> 
                                <td>
                                    <?
                                    echo @$contador[$setor3[0]->aso_setor_id][$item3->nome_procedimento];
                                     @$totalcontador[$setor3[0]->aso_setor_id] = $totalcontador[$setor3[0]->aso_setor_id]+$contador[$setor3[0]->aso_setor_id][$item3->nome_procedimento];
                                    
                                    
                                    ?>   
                                </td>
                                
                                
                                
                                
                                <td>
                                    0                                 
                                </td>  

                                <td>
                                    0,00                                 
                                </td> 
                           
                                <td colspan="2" >
                                   <center> - </center>                             
                                </td>
              
                            </tr>  
                
                            <?
                        }
                        
                      
                    }
                    ?>


                    <?
                }
                echo "
                               <tr>
                              <td style='border-top:1px solid black;'>Quantidade de empregados na função: <b>" . $contador_fun[$item[0]] . "</b></td>
                            <td  style='border-top:1px solid black;'><b>TOTAIS:<b>  </td>                             
                            <td  style='border-top:1px solid black;'><b><b>" . @$totalcontador[$item[0]] . " </td>
                              <td style='border-top:1px solid black;'> 0</td>
                              <td style='border-top:1px solid black;' colspan='0'>0,00</td>
                              <td style='border-top:1px solid black;' colspan='2'> <center>-</center></td>
                                         
                            </tr>";
                  @$trabalhadores_fun = $trabalhadores_fun+ $contador_fun[$item[0]];
            @$total_realizado = $total_realizado+$totalcontador[$item[0]];
            }

//echo "<pre>";
//print_r($array4);
//echo "<pre>";
//print_r($varificar);
//                 
            ?> 
                           

 <tr>
                            <td style="border-bottom:1px solid black; border-top:3px solid black;" >Quantidade de Empregados Geral: <b><?= @$trabalhadores_fun; ?></b> </td>
                               <td style="border-bottom:1px solid black; border-top:3px solid black;" >
                                 <b>TOTAL</b> </td>
                          <td style="border-bottom:1px solid black; border-top:3px solid black;" ><b><?= @$total_realizado; ?></b> </td>
                        <td style="border-bottom:1px solid black; border-top:3px solid black;" >
                                 0 </td>
                         <td style="border-bottom:1px solid black; border-top:3px solid black;" >
                                 0,00 </td>
                          <td style="border-bottom:1px solid black; border-top:3px solid black;" >
                        <center> - </center>  </td>
                        </tr>

        </tbody>

    </table>
      <? 
      $data = date('d/m/Y');
      ?>
    <br>  <br>  <br>  <br>  <br> 
      <hr>
      <b>Assinatura do Coordenador Responsável</b>                      
     <br>  <br>         
     <hr style="width:300px; margin-left:66px;margin-top:40px;" >                 
      <div class="linha-vertical">
         <b> Local e data</b>     <br>    <br>    <br>
          &nbsp; Fortaleza - <?= $data ?>  
      </div>
     
    
</div>





