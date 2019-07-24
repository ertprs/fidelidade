
<fieldset>
    <div class="body">
        <div class="row clearfix">
            <a class="btn btn-primary waves-effect" href="<?php echo base_url() ?>ambulatorio/motivocancelamento/carregarmotivocancelamento/0">
                Novo Motivo
            </a>
        </div>
        <div class="row clearfix">
            <div class="header">
                <legend>Motivo cancelamento</legend>
            </div>

            <div class="body">
                <form method="get" action="<?= base_url() ?>ambulatorio/motivocancelamento/pesquisar">
                    <div class="row clearfix">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Nome</label>
                                    <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 sol-md-2">
                            <?= botao_pesquisar() ?>
                        </div>
                    </div>
                </form>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->motivocancelamento->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                        ?>
                        <tbody>
                        <?php
                        $lista = $this->motivocancelamento->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  <?= botao_editar('/ambulatorio/motivocancelamento/carregarmotivocancelamento/'.$item->ambulatorio_cancelamento_id) ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  <?= botao_excluir('/ambulatorio/motivocancelamento/excluir/'.$item->ambulatorio_cancelamento_id)?>
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
    </div>
</fieldset>

