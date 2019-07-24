<div class="content"> <!-- Inicio da DIV content -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <table>
        <thead>
            <? // var_dump($_POST['grupo']);die;?>
            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>

            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">GRUPO: TODOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">GRUPO: <?= $grupo; ?></th>
                </tr>
            <? } ?>                
            <? // var_dump($mes);die;?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">
                    <?
                    $mes_escolhido = '';
                
                    if ($mes == "01") {
                        $mes_escolhido = 'JANEIRO';
                    } elseif ($mes == "02") {
                        $mes_escolhido = 'FEVEREIRO';
                    } elseif ($mes == "03") {
                        $mes_escolhido = 'MARÇO';
                    } elseif ($mes == "04") {
                        $mes_escolhido = 'ABRIL';
                    } elseif ($mes == "05") {
                        $mes_escolhido = 'MAIO';
                    } elseif ($mes == "06") {
                        $mes_escolhido = 'JUNHO';
                    } elseif ($mes == "07") {
                        $mes_escolhido = 'JULHO';
                    } elseif ($mes == "08") {
                        $mes_escolhido = 'AGOSTO';
                    } elseif ($mes == "09") {
                        $mes_escolhido = 'SETEMBRO';
                    } elseif ($mes == "10") {
                        $mes_escolhido = 'OUTUBRO';
                    } elseif ($mes == "11") {
                        $mes_escolhido = 'NOVEMBRO';
                    } elseif ($mes == "12") {
                        $mes_escolhido = 'DEZEMBRO';
                    }
                    ?>
                    <? // var_dump($mes_escolhido);die; ?>
                    MÊS: <?
                    if ($mes != "0") {
                        echo 
                    $mes_escolhido; 
                        
                    }else{
                        
                        echo "TODOS";
                        
                    }
                    
                    
                    ?>
                    <br>
                    ANO: <?= 
                    $ano;
                    ?>
                    
              
                    


                </th>
            </tr>


            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="8">&nbsp;</th>
            </tr>
        </thead>
    </table>

    <?
    $valorFaturado = 0;
    $valorReceber = 0;
    $valorTotal = 0;
    foreach ($relatorio as $value) :
//        $valorProc = (float) $value->valor_total;
//        if ($value->faturado == 't') {
//            $valorFaturado += $valorProc;
//        } else {
//            $valorReceber += $valorProc;
//        }
//        $valorTotal += $valorProc;
    endforeach;
    
    
//    echo "<pre>";
//    print_r($relatorio);
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    <h3 align="center">Meta Mensal por Procedimentos</h3>
    <table align="center" width="50%"  border="1" style= "border-collapse:collapse;" cellpadding="10" cellspacing="10">
        <thead>
            <? if (count($relatorio) > 0) {
                ?>

                <tr>               
                    <th width="450px" class="tabela_teste" >Procedimento</th>
                    <th class="tabela_teste" >Meta Mensal</th>
                    <th class="tabela_teste" >Total Realizado</th>            
                    <th class="tabela_teste" >PORCENTAGEM REALIZADA</th>            
                </tr>
            </thead>
            <tbody>
                <?
                $proc_atual = '0';
                $meta_grupo = 0;
                $array_metagrupo = array();
                ?>
                <? foreach ($relatorio as $value) : ?>
                    <?
                    if (array_key_exists("$value->grupo", $array_metagrupo)) {
                        $array_metagrupo[$value->grupo]['quantidade'] += $value->contador;
                        $array_metagrupo[$value->grupo]['meta'] += $value->meta_mensal;
                    } else {
                        $array_metagrupo[$value->grupo] = array();
                        $array_metagrupo[$value->grupo]['quantidade'] = (int) $value->contador;
                        $array_metagrupo[$value->grupo]['meta'] = (int) $value->meta_mensal;
                    }
                    ?>
                    <? if ($value->exame != $proc_atual) { ?>
                        <? $proc_atual = $value->exame; ?>
                        <tr>
                            
                            
                            <? $meta_grupo = $meta_grupo + $value->meta_mensal; ?>
                            
                            
                            
                            
                            
                            <td><?= $value->exame; ?></td>
                            <td align="center"><?
                                        if ($mes == 0 || $mes == "" ) {
                                            
                                            
                                            
                                              echo  $value->meta_mensal*12; 
                                        }else{
                                            
                                            echo $value->meta_mensal;
                                            
                                        }
                            
                            
                           
                            
                            
                            ?>
                            
                            
                            
                            </td>
                            <td align="center"><?= $value->contador; ?></td>
                            <td align="center"><?
                            
                              if ($mes == 0 || $mes == "" ) {
        
                                              echo round((100*$value->contador)/($value->meta_mensal*12), 2) . "%";
                                        }else{
                                            
                                        echo round((100*$value->contador)/$value->meta_mensal, 2) . "%";
                                            
                                        }
                            
                             ?></td>
                            
                            
                            
                            

                        </tr>
                    <? } ?>
                <? endforeach; ?>
            </tbody>
        </table>
        <br>
        
    <? } ?>
    <?
//    echo '<pre>';
//    var_dump($array_metagrupo); die;
    ?>
    <h3 align="center">Meta Mensal por Grupo</h3>
    <table align="center" width="50%" border="1" style= "border-collapse:collapse;" cellpadding="10" cellspacing="10">
        <thead>
            <? if (count($relatorio) > 0) {
                ?>

                <tr>               
                    <th width="450px" class="tabela_teste" >Grupo</th>
                    <th class="tabela_teste" >Meta Mensal</th>
                    <th class="tabela_teste" >Total Realizado</th>            
                    <th class="tabela_teste" >PORCENTAGEM REALIZADA</th>            
                </tr>
            </thead>
            <tbody>
                <?                
                foreach ($array_metagrupo as $key => $value) {
                    ?>
                    <tr>

                        <td><?= $key; ?></td>
                        <td align="center"><? 
          
                      if ($mes == 0 || $mes == "" ) {
                                            
                                            
                                            
                                              echo  $value['meta']*12; 
                                        }else{
                                            
                                            echo $value['meta'];
                                            
                                        }
                        
                        ?></td>
                        
                        
                        
                        
                        <td align="center"><?= $value['quantidade']; ?></td>
                        <td align="center">
                            
                            
                            
                       <? 
                               
                               
                                  if ($mes == 0 || $mes == "" ) {
                                            
                                            
                                      echo round((100*$value['quantidade'])/($value['meta']*12), 2) . "%" ;     
                                              
                                        }else{
                                            
                                      echo  round((100*$value['quantidade'])/($value['meta']), 2) . "%" ;     
                                            
                                        }
                               
                               
                               ?>
                        
                        
                            
                            
                        
                        
                        
                        </td>
                    

                    </tr>
                <? }
                ?>

            </tbody>
        </table>
        <br>
        
    <? } ?>


</div>  <!-- Final da DIV content -->
<!--<meta http-equiv="content-type" content="text/html;charset=utf-8" />-->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>