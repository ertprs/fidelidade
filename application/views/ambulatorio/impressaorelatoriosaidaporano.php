<meta charset="UTF-8">
<style>
    .paddingCerto{
        padding-right: 20px; 
        padding-left: 20px; 
    }
    .paddingZero{
        padding-right: 0px; 
        padding-left: 0px; 
    }
</style>
<div class="content"> <!-- Inicio da DIV content -->    
   <?
    $MES = '';
    $MES_ant = '';
   ?>

    <?
    $ano = date("Y");
    
    $ano_inicial = $_POST['ano_inicial'];
    $periodo = "" . $_POST['ano_inicial'] . " até " . $_POST['ano_final'];
    $quantidade_anos = 1 + $_POST['ano_final'] - $_POST['ano_inicial'] ;
    // Tem que somar um porque quando voce coloca dois anos ele vai buscar ex: 1-1-2018 ao 31-12-2019, então são 24 meses e não 12;
    $quantidade_meses = $quantidade_anos * 12;
   
    
    function resetarValorMes($quantidade_meses){
        $array_meses = array();
        for($a = 1; $a <= $quantidade_meses; $a++){
            $array_meses[$a] = 0;
        }
        // unset($array_meses[6]);
        return $array_meses;
    }

    $array_display = array();
    // $array_display[0] = 6;
    // $array_display[1] = 12;
    // $array_display[3] = 5;
    // To criando esse array supondo a possibilidade de pedirem pra nao aparecer certos meses.
    // Caso exista algo nele o indice do array de cima, aquele mês não irá aparecer, morou?
    $array_meses = resetarValorMes($quantidade_meses);
    $array_meses_tipo = resetarValorMes($quantidade_meses);


    // echo '<pre>';
    // var_dump($array_meses);
    ?>

    <style>
        .left{
            text-align: left;
        }
        .right{
            text-align: right;
        }
    
    </style>
    <? if (count($tipo) > 0) { ?>
        <h4>TIPO: <?= $tipo[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODOS OS TIPOS</h4>
    <? } ?>
    <? if (count($classe) > 0) { ?>
        <? $texto = strtr(strtoupper($classe[0]->descricao), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); ?>
        <h4>CLASSE: <?= $texto; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLASSES</h4>
    <? } ?>
    <? if (count($forma) > 0) { ?>
        <h4>CONTA:<?= $forma[0]->descricao; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CONTAS</h4>
    <? } ?>
    <h4>EMPRESA: <?=($_POST['empresa'] > 0) ? $empresa[0]->nome : 'TODAS';?></h4>
    <h4>RELATORIO SAIDA POR ANO</h4>
    <h4>PERIODO: <?=$periodo?></h4>
    <hr>
    <?
    if (count($relatorio_saida) > 0) {
        ?>
        <table border="1">
            <thead>
                <!-- <tr>
                    <th class="tabela_header" colspan="1">ITENS</th>
                    <th class="tabela_header" colspan="1"> $ </th>
                   
                </tr> -->
            </thead>
            
            <?
            $contador = 0;
            $i = 0;
            $tipo_atual = '&nbsp;';
            $valor_totalEntrada = 0;
            $valor_tipo = 0;
            $percentual = 0;
            $valor_total_geral = 0;

            ?>
            <!-- <tr>
                <th class="tabela_header left"  colspan="8">&nbsp;</th>
                
            </tr> -->
            <tr>
                <th class="tabela_header left"  colspan="8">SAIDAS</th>
                <?
                $ano_nome = $ano_inicial;
                foreach ($array_meses as $key => $value) {?>
                    <?
                    $mes = $this->utilitario->ProporcaoMensal($key);
                    $nome_mes = $this->utilitario->retornarNomeMesINT($mes);
                    ?>
                    <?if(!in_array($key, $array_display)){?>
                        <th class="tabela_header left paddingCerto"  ><?=$nome_mes . "/" . $ano_nome?></th>
                    <?}?>
                    <?
                    if($key%12 == 0){
                        $ano_nome = $ano_inicial + $key/12;
                    }
                    ?>
                <?}
                ?>
            </tr>
            <?
            $valor_totalSaida = 0;
            $i = 0;
            $contador_tipo = 0;
            $contador_classe = 0;
            foreach ($relatorio_saida as $key => $item) {
                $valor_totalSaida += $item->valor;
                $tipo = $item->tipo;
                ?>
                <?if($item->tipo != $tipo_atual){?>
                    <?
                    $contador_tipo++;
                    $contador_classe = 0;
                    $ano_nome = $ano_inicial;
                    foreach($array_meses_tipo as $key0 => $valor_tipo){
                        $mes = $this->utilitario->ProporcaoMensal($key0);
                        $valor_tipo = $this->caixa->relatoriosaidaporanoValorTipo($ano_nome, $mes, $tipo);
                        if($valor_tipo > 0){
                            $array_meses_tipo[$key0] = number_format($valor_tipo, 2, ',', '.');
                            $valor_total_geral+= $valor_tipo;
                        }else{
                            $array_meses_tipo[$key0] = '-';
                        }
                        

                        if($key0%12 == 0){
                            $ano_nome = $ano_inicial + $key0/12;
                        }
                    }
                    ?>

                    <tr>
                        <th class="tabela_header left paddingZero"  colspan="8">
                            <?=$contador_tipo . ". " . $item->tipo?> 
                        </th>
                        <?
                        foreach ($array_meses_tipo as $key2 => $value_tipo) {?>
                            <?if(!in_array($key2, $array_display)){?>
                                <th class="tabela_header left ">R$ <?=$value_tipo?></th>
                            <?}?>
                        <?}
                        ?>
                        <?
                            $array_meses_tipo = resetarValorMes($quantidade_meses);
                        ?>
                        
                    </tr>
                    
                <?}
                $i++;
                $tipo_atual = $item->tipo;
                ?>
                <?
                // Mostrando a Classe.
                // array_key_exists("primeiro", $busca_array)

                ?>
                
                <tr>
                    <td colspan="8">
                        
                        <?
                        $contador_classe++;
                        $string_contador = $contador_tipo . "." . $contador_classe;
                        
                        ?>
                        <?=$string_contador . " " . $item->classe?> 
                    </td>
                    <?
                    $ano_nome = $ano_inicial;
                    $classe = $item->classe;
                    foreach($array_meses as $key3 => $valor_classe){
                        $mes = $this->utilitario->ProporcaoMensal($key3);
                        $valor_classe = $this->caixa->relatoriosaidaporanoValorClasse($ano_nome, $mes, $classe);
                        if($valor_classe > 0){
                            $array_meses[$key3] = number_format($valor_classe, 2, ',', '.');
                        }else{
                            $array_meses[$key3] = '-';
                        }
                        

                        if($key3%12 == 0){
                            $ano_nome = $ano_inicial + $key3/12;
                        }
                    }
                    ?>
                    <?
                    foreach ($array_meses as $key3 => $value_classe) {?>
                        <?if(!in_array($key3, $array_display)){?>
                            <td >R$ <?=$value_classe?></td>
                        <?}?>
                    <?}
                    ?>
                    <?
                        $array_meses = resetarValorMes($quantidade_meses);                     
                    ?>
                </tr>
                

                <?if((count($relatorio_saida)) == $i){?>
                    <tr>
                        <th class="left paddingCerto">
                            Valor Total: R$ <?=number_format($valor_total_geral, 2, ',', '.');?>
                        </th>
                    </tr>
                <?}?>
                

                
            <?}?>

           
        </table>

        <h4>Obs: Transfer&ecirc;ncias n&atilde;o s&atilde;o mostradas nesse relatório </h4>

        <?
    } else {
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
