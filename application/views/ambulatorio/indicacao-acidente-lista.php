
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/guia/carregararindicaacidente/">
            Nova Indicação Acidente
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Indicação Acidente</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/guia/listarindicaacidente">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                         <th class="tabela_header">Código</th>
                        <th class="tabela_header" colspan="3"style="text-align:center;"  >Ações</th> 
                    </tr> 

                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->guia->listarindicacaoacidente($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->guia->listarindicacaoacidente($_GET)->limit($limit, $pagina)->get()->result(); 
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                   <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"  width="50px" > 
                                <div class="bt_link" >
                                     <a href="<?= base_url() ?>ambulatorio/guia/carregararindicaacidente/<?= $item->indicacao_acidente_id; ?>" >Editar</a> 
                                </div>
                                    
                                </td> 
                                
                                <td class="<?php echo $estilo_linha; ?>"  width="50px" > 
                                <div class="bt_link">
                                     <a onclick="javascript: return confirm('Deseja realmente Excluir essa Indicação ?');"  href="<?= base_url() ?>ambulatorio/guia/exlcuirindicaacidente/<?= @$item->indicacao_acidente_id; ?>" >Excluir</a> 
                                </div>
                                    
                                </td>
                                
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
