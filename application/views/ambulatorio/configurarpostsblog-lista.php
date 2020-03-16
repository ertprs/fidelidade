
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/empresa/carregarpostsblog/0">
            Novo Post
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Informativos</a></h3>
        <div>
            <table>
                <thead>
<!--                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/empresa/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>-->
                    <tr>
                        <th class="tabela_header">ID</th>
                        <th class="tabela_header">Titulo</th>
                        <th class="tabela_header">Data </th>
                        <!--<th class="tabela_header">Raz&atilde;o social</th>-->
                        <th class="tabela_header" colspan="5"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $perfil_id = $this->session->userdata('perfil_id'); 
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->empresa->listarpostsblog($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listarpostsblog($_GET)->limit($limit, $pagina)->orderby("e.data_cadastro")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->posts_blog_id;?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->titulo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>
                                <td style="width:140px;" class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/empresa/carregarpostsblog/<?= $item->posts_blog_id; ?>">Editar</a></div>
                                </td>
                                <?php if($perfil_id != 18 && $perfil_id != 20){?>
                                <td style="width:140px;" class="<?php echo $estilo_linha; ?>"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir o post?')" href="<?= base_url() ?>ambulatorio/empresa/excluirpostsblog/<?= $item->posts_blog_id; ?>">Excluir</a></div>
                                </td>
                                <?php }?>
                                <? 
                                $operador_id = $this->session->userdata('operador_id');
                                if ($perfil_id == 1):
                                    ?>
                                    
                               <? endif; ?>
                                <?
//                                $perfil_id = $this->session->userdata('perfil_id');
                                if ($operador_id == 1):
                                    ?>
                                    
                               <? endif; ?>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
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
