
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/novoalerta">
            Novo Alerta
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Lerta</a></h3>
        <div>
            <table>
                <thead>

                    <tr>
                        <th class="tabela_header">Nome</th>
                            <th class="tabela_header">Observação</th>
                                  <th class="tabela_header">Cor</th>
                   
                        <th class="tabela_header" colspan="4"><center>Ações</center></th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->internacao_m->listaralertainternacao($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->internacao_m->listaralertainternacao($_GET)->limit($limit, $pagina)->orderby("nome asc")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                

                                   <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>
                                   <td class="<?php echo $estilo_linha; ?>">
                                   
                                   
                                  <div style=" width:60px;   background-color:<?
            if (@$item->cor != "") {
                echo @$item->cor;
            } else {

                echo "black";
            }
            ?>">


                &nbsp;

            </div>
                                   
                                   
                                   
                                   
                                   
                                      <td class="<?php echo $estilo_linha; ?>" style="width: 100px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>internacao/internacao/editaralertainternacao/<?= $item->internacao_alerta_id; ?>">Editar</a></div>
                                </td>
                                  <td class="<?php echo $estilo_linha; ?>" style="width: 100px;"><div class="bt_link">
                                        <a onclick="javascript:return confirm('Deseja realmente excluir esse questionário?');" href="<?= base_url() ?>internacao/internacao/excluiralertainternacao/<?= $item->internacao_alerta_id; ?>">Excluir</a></div>
                                </td>
                             
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
