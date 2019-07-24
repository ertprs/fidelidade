
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>farmacia/saida/carregarsaidaproduto/0">
            Novo Saída
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Saída</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                <form method="get" action="<?= base_url() ?>farmacia/saida/pesquisarsaida_produto">
                    <tr>
                        <th class="tabela_title">Produto</th>                 
                        <th class="tabela_title">Armazém</th>
                        <th  class="tabela_title">Lote</th>
                            <th class="tabela_title">Validade</th>
                        <th class="tabela_title">Tipo Saída</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="produto" value="<?php echo @$_GET['produto']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input style="width:60px;" type="text" name="lote" value="<?php echo @$_GET['lote']; ?>" colspan="2"/>
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="validade" id="validade" alt="date" value="<?php echo @$_GET['validade']; ?>" colspan="2"/>
                        </th>
                          <th class="tabela_title">
                            <input type="text" name="tipo_saida" value="<?php echo @$_GET['tipo_saida']; ?>" colspan="2"/>
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                    </tr>
                </form>
            </table>
            <table>
                <tr>
                    <th class="tabela_header">Produto</th>
                    <th class="tabela_header">Armazém</th>
                    <th class="tabela_header">Lote</th>
                    <th class="tabela_header">Validade</th>
                    <th class="tabela_header">Tipo de Saída.</th>
                
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->saida->listarsaidaproduto($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->saida->listarsaidaproduto($_GET)->limit($limit, $pagina)->get()->result();
                        
                        
//                        echo "<pre>";          
//                        print_r($lista);
//                        
                        
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
//                            $cor = '';
//                            $dias = '';
//                            if($item->validade != '//' && $item->validade != ''){
//                                $data_inicio =  new DateTime(date("Y-m-d")); 
//                                $data_fim = new DateTime($item->validade);
//    
//                                if($data_inicio > $data_fim){
//                                    $dias = 0;
//                                    // var_dump($dias);
//                                }else{
//                                    // Resgata diferença entre as datas
//                                    $dateInterval2 = $data_inicio->diff($data_fim);
//                                        
//                                    $dias = $dateInterval2->days;
//                                }
//                               
//                            }else{
//                                $dias = 'NA';
//                            }
                           

//                            if(isset($dias)){
//                                // var_dump($dias);
//
//                                if($dias <= 0){
//                                    $cor = 'red';
//                                }elseif($dias <= 10){
//                                    $cor = '#b2a010';
//                                }elseif($dias <= 20){
//                                    $cor = 'blue';
//                                }
//                                // echo 'ashduas';
//                            }

                            // echo $item->validade . " - $dias  - " . " $cor  |";
                            // echo $dias, $cor;
      

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                               <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->lote; ?></td>
                                <td class="
                                    
                                    
                                    <?php echo $estilo_linha; ?>">
                                    
                                    <?php echo substr($item->data_validade, 8, 2) . '/' . substr($item->data_validade, 5, 2) . '/' . substr($item->data_validade, 0, 4); ?>
                                 
                                
                                
                                
                                
                                </td>
                                      <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo_saida; ?></td>
                                <!--<td class="<?php echo $estilo_linha; ?>" style="color: <?=$cor?>"><?= ($item->validade != '//' && $item->validade != '') ? date('d/m/Y',strtotime($item->validade)) : ''; ?></td>-->
                              <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">

                                  <a href="<?= base_url() ?>farmacia/saida/carregarsaida_produto/<?= $item->farmacia_saida_produto_id ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>farmacia/saida/excluirsaida_produto/<?= $item->farmacia_saida_produto_id ?>">Excluir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>farmacia/saida/anexarimagemsaida/<?= $item->farmacia_saida_produto_id ?>">Arquivos</a></div>
                                </td>
                                      
                                      
                  
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="9">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<!-- Final da DIV content -->
<script type="text/javascript">
 $(function () {
        $("#validade").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });





                                $(function() {
                                    $("#accordion").accordion();
                                });

</script>
