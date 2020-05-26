<meta charset="UTF-8">
<style>
.cinza{
    background: Grey;
}
</style>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Comiss&atilde;o</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

            <?if($vendedor != ''){?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">VENDEDOR: <? foreach($vendedor as $item){
                 echo $item->nome.', ';   
                } ?></th>
            </tr>
            <?}else{?>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">NÃO HÁ VENDEDORES CADASTRADOS PARA ESSE GERENTE</th>
            <?}?>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= date("d/m/Y",strtotime($txtdatainicio)); ?> ate <?=  date("d/m/Y",strtotime($txtdatafim)); ?></th>
            </tr>

        </thead>
    </table>
    <?
    
    $forma_comissao_v = array();
    foreach($relatorio_forma as $item){
        // echo '<pre>';
        // var_dump($relatorio); die;
        if($item->contador > 0){
        //    var_dump($item);
           $forma_comissao = $this->guia->vendedorComissaoFormaRend($item->contador, $item->plano_id, $item->forma_rendimento_id);
            // var_dump($forma_comissao);
            // $forma_comissao_v =
            if(count($forma_comissao) > 0){
                if(!isset($forma_comissao_v[$item->plano_id])){
                    $forma_comissao_v[$item->plano_id] = array();
                }
                $forma_comissao_v[$item->plano_id][$item->forma_rendimento_id] = $forma_comissao[0]->valor_comissao;
            }
        }

    }
    // var_dump($forma_comissao_v);
    //  die;
    ?>
    <? if (count($relatorio) > 0) {
        ?>

        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste">Cliente</th>
                    <th class="tabela_teste">Plano</th>
                    <th class="tabela_teste">Vendedor</th>
                    <th class="tabela_teste">Forma de Pag.</th>
                    <th class="tabela_teste">Comiss&atilde;o</th>
                    <th class="tabela_teste">Comiss&atilde;o Vendedor Externo</th>
                    <th class="tabela_teste">Comiss&atilde;o Gerente</th>
                    <th class="tabela_teste">Comiss&atilde;o Seguradora</th>
                </tr>
            </thead>
            <hr>
            <tbody>
     
                <?php
                $valortotal = 0;
                $total = 0;
                $totalporvendedor = 0;
                $valorvendedortotal = 0;
                $pegarnomevendedor = 0;
                foreach ($relatorio as $item) :   
                    
                    if($_POST['tipopesquisa'] == '2'){

                        if($pegarnomevendedor == 0){
                            $operadorvendedor = $item->vendedor;
                            $pegarnomevendedor++;
                        }
    
                        if($item->vendedor != $operadorvendedor){
                            ?>
                        <tr class="cinza">
                        <td COLSPAN = 4><font size="-1">TOTAL VENDEDOR: <?=$totalporvendedor?></td>
                        <!-- <td COLSPAN = 3></td> -->
                        <td style='text-align: center;' ><font size="-1">VALOR TOTAL VENDEDOR: <?= number_format($valorvendedortotal, 2, ',', '.'); ?></td>
                    </tr>
                                            
                            <?
                            $valorvendedortotal = 0;
                            $totalporvendedor = 0;
                            }
    
                        }


                    $total++;
                    $totalporvendedor++;
                    if(isset($forma_comissao_v[$item->plano_id][$item->forma_rendimento_id])){
                        $valor_comissao = $forma_comissao_v[$item->plano_id][$item->forma_rendimento_id];
                    }else{
                        $valor_comissao = $item->comissao;
                    }                                     
                    $valortotal = $valortotal + $valor_comissao;
                    $valorvendedortotal = $valorvendedortotal + $valor_comissao;


                    ?>                      
                    <tr>
                        <td ><font size="-2"><?= $item->paciente; ?></td>
                        <td ><font size="-2"><?= $item->plano; ?></td>
                        <td ><font size="-2"><?= $item->vendedor; ?></td>
                        <td ><font size="-2"><?= $item->forma_rendimento; ?></td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($item->comissao, 2, ',', '.'); ?></td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($valor_comissao, 2, ',', '.'); ?></td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($item->comissao_gerente, 2, ',', '.'); ?></td>
                        <td style='text-align: center;' ><font size="-2"><?= number_format($item->comissao_seguradora, 2, ',', '.'); ?></td>
                    </tr>

                    <?   
                    
                    if($_POST['tipopesquisa'] == '2'){
                    if($operadorvendedor != $item->vendedor){
                        $operadorvendedor = $item->vendedor; 
                    }
                }
                ?>

                <? endforeach; 
                
                if($_POST['tipopesquisa'] == '2'){?>
                <tr class="cinza">
                        <td COLSPAN = 4><font size="-1">TOTAL VENDEDOR: <?=$totalporvendedor?></td>
                        <!-- <td COLSPAN = 3></td> -->
                        <td style='text-align: center;' ><font size="-1">VALOR TOTAL VENDEDOR: <?= number_format($valorvendedortotal, 2, ',', '.'); ?></td>
                </tr>

                <?}?>

                    <tr>
                        <td COLSPAN = 4><font size="-1">TOTAL: <?=$total?></td>
                        <!-- <td COLSPAN = 3></td> -->
                        <td style='text-align: center;' ><font size="-1">VALOR TOTAL: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                    </tr>
            </tbody>
        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->

