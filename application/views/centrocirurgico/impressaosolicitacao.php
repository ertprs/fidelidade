<head>
    <meta charset="utf8"/>
    <style>
        table{
            /* border-collapse: collapse; */
            border: 1px solid;
            border-radius: 15px;
            font-size: 10pt;
            /* height: 50%; */
            width: 100%;
            padding: 1px ;
            margin: 0px;
            border-spacing: 0px;
            
           
        }
        td{
            border: 1px solid;
            border-bottom: 0px;
            border-right: 0px;
            /* margin-left: 0px; */
            padding: 2px;
            margin: 0px;
            font-weight: bold;
            /* border-spacing: 0px; */
        }
        td span{
            font-weight: normal;
            font-size: 10pt;
        }
        .bordaEsquerda{
            border-left: 0px;
        }
        .bordaCima{
            border-top: 0px;
        }
        tr{
            height: 30px;
        }
        .trMaior{
            height: 60px;
        }
        
    </style>
</head>
 <!-- Inicio da DIV content -->
        <table border="1" style="border:0px;">
            <tr>
                <td class="" style="border: 0px; width: 30%">
                   <?=$cabecalho_config?> 
                </td>
                <td class="" style="border: 0px; width: 50%; font-size: 14pt; text-align:center;">
                    <hr>
                    FOLHA DE OPERAÇÃO
                    <hr>
                </td>
            </tr>
        </table>
        <table style="">
                <tr class="trMaior">
                    <td style="" colspan="2" class="bordaEsquerda bordaCima">
                        <?=$solicitacao[0]->paciente;?>
                    </td>
                    <td style="" class=" bordaCima">
                       Nº Reg: <span><?=$solicitacao[0]->solicitacao_cirurgia_id;?></span> 
                    </td>
                    
                </tr>
                
                <tr>
                    <td style="" class="bordaEsquerda">
                        DATA DE OPERAÇÃO: 
                        <span>
                            <?= (@$solicitacao[0]->data_prevista != '') ? date("d/m/Y", strtotime(@$solicitacao[0]->data_prevista)) : ''; ?>
                        </span>
                    </td>
                    <td colspan="1" style="">
                        ENF
                    </td>
                    <td colspan="1" style="">
                        LEITO
                    </td>
                    

                </tr>
                <tr>
                    <td style="" class="bordaEsquerda"  colspan="2">
                        OPERADOR: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 0){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                    <td colspan="1" style="">
                        1º AUXILIAR: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 1){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda"  >
                        2º AUXILIAR: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 2){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                    <td colspan="1" style="">
                        3º AUXILIAR: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 3){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                    <td colspan="1" style="">
                        INSTRUMENTADOR: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 5){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda"  >
                        ANESTESISTA: 
                        <span>
                            <?
                            foreach($solicitacao as $item){
                                if($item->funcao == 6){
                                    echo $item->operador_equipe;
                                }
                            }
                            ?>
                        </span>
                    </td>
                    <td colspan="2" style="">
                        TIPO DE ANESTESIA
                    </td>
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        DIAGNÓSTICO PRÉ-OPERATÓRIO
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        TIPO DE OPERAÇÃO
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        DIAGNÓSTICO PÓS-OPERATÓRIO
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        RELATÓRIO IMEDIATO DO PROTOLOGISTA
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        EXAME RADIOLÓGICO NO ATO 
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        ACIDENTE DURANTE A OPERAÇÃO 
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="text-align: center;" class="bordaEsquerda" colspan="3" >
                        DESCRIÇÃO DA OPERAÇÃO
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="text-align: center;" class="bordaEsquerda" colspan="3" >
                        VIA DE ACESSO - TÁTICA E TÉC, LIGADURAS DRENAGEM - SUTURA 
                        <BR>
                        MATERIAL EMPREGADO ASPECTOVISCEMAS
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="" class="bordaEsquerda" colspan="3" >
                        
                        <span>
                          
                        </span>
                    </td>
                    
                    
                </tr>
               

            </table>



<!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
