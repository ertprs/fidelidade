<?php $perfil_id = $this->session->userdata('perfil_id'); ?>
<div class="content"> <!-- Inicio da DIV content -->
    <?php if($perfil_id != 10){?>
        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>ambulatorio/indicacao/carregarindicacao/0">
                Nova Indica&ccedil;&atilde;o
            </a>
        </div>
    <?php }?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Indica&ccedil;&atilde;o</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/indicacao/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->indicacao->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->indicacao->listar($_GET)->limit($limit, $pagina)->orderby('nome')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                            <?php if($perfil_id != 10){?>
                                    <a href="<?= base_url() ?>ambulatorio/indicacao/carregarindicacao/<?= $item->paciente_indicacao_id ?>">
                                        Editar
                                    </a>&zwnj;&nbsp;
                                           
                                    <a href="<?= base_url() ?>ambulatorio/indicacao/excluir/<?= $item->paciente_indicacao_id ?>">
                                        Excluir
                                    </a>
                                     <?php }?>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="6">
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
