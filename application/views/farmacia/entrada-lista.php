
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>farmacia/entrada/carregarentrada/0">
            Novo Entrada
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Entrada</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                <form method="get" action="<?= base_url() ?>farmacia/entrada/pesquisar">
                    <tr>
                        <th class="tabela_title">Produto</th>
                        <th class="tabela_title">Fornecedor</th>
                        <th class="tabela_title">Armazem</th>
                        <th class="tabela_title">Nota</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="produto" value="<?php echo @$_GET['produto']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="fornecedor" value="<?php echo @$_GET['fornecedor']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="armazem" value="<?php echo @$_GET['armazem']; ?>" colspan="2"/>
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="nota" value="<?php echo @$_GET['nota']; ?>" colspan="2"/>
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
                    <th class="tabela_header">Fornecedor</th>
                    <th class="tabela_header">Armazem</th>
                    <th class="tabela_header">Quantidade</th>
                    <th class="tabela_header">Nota</th>
                    <th class="tabela_header">Validade</th>
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->entrada->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->entrada->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $cor = '';
                            $dias = '';
                            if($item->validade != '//' && $item->validade != ''){
                                $data_inicio =  new DateTime(date("Y-m-d")); 
                                $data_fim = new DateTime($item->validade);
    
                                if($data_inicio > $data_fim){
                                    $dias = 0;
                                    // var_dump($dias);
                                }else{
                                    // Resgata diferença entre as datas
                                    $dateInterval2 = $data_inicio->diff($data_fim);
                                        
                                    $dias = $dateInterval2->days;
                                }
                               
                            }else{
                                $dias = 'NA';
                            }
                           

                            if(isset($dias)){
                                // var_dump($dias);

                                if($dias <= 0){
                                    $cor = 'red';
                                }elseif($dias <= 10){
                                    $cor = '#b2a010';
                                }elseif($dias <= 20){
                                    $cor = 'blue';
                                }
                                // echo 'ashduas';
                            }

                            // echo $item->validade . " - $dias  - " . " $cor  |";
                            // echo $dias, $cor;
                            



                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?><?if($item->fracionamento_id > 0){
                                    echo " <span style='color:red;'>(Fracionamento)</span>";
                                    
                                }?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->armazem; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" style="color: <?=$cor?>"><?= ($item->validade != '//' && $item->validade != '') ? date('d/m/Y',strtotime($item->validade)) : ''; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                    <a href="<?= base_url() ?>farmacia/entrada/carregarentrada/<?= $item->farmacia_entrada_id ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>farmacia/entrada/excluir/<?= $item->farmacia_entrada_id ?>">Excluir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>farmacia/entrada/anexarimagementrada/<?= $item->farmacia_entrada_id ?>">Arquivos</a></div>
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

</div> <!-- Final da DIV content -->
<script type="text/javascript">

                                $(function() {
                                    $("#accordion").accordion();
                                });

</script>
