
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/exame/carregarsalatoten/0">
            Nova Sala
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Salas do Toten</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="8" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/sala/pesquisar">
                                <!-- <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" /> -->
                                <!-- <button type="submit" id="enviar">Pesquisar</button> -->
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">ID</th>
                        <th class="tabela_header">Nome</th>
                        <!--<th class="tabela_header">Tipo</th>-->
                        <th class="tabela_header" colspan="8">Detalhes</th>
                    </tr>
                </thead>
                <?php
                    $data['empresa'] = $this->empresa->listarempresatoten();
                    $endereco = $data['empresa'][0]->endereco_toten;
                    $data['endereco'] = $endereco;
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->exame->listarsalatoten($endereco);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->exame->listarsalatoten($endereco)->limit($limit, $pagina)->orderby("id, nome")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->id; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                            <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/exame/carregarsalatoten/<?= $item->id ?>">Editar</a></div>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                <a onclick="javascript: return confirm('Deseja realmente excluir a sala?');" href="<?= base_url() ?>ambulatorio/exame/excluirsalatoten/<?= $item->id ?>">Excluir</a></div>
                            </td>
                            
                        </tr>

                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="7">
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
        $( "#accordion" ).accordion();
    });

</script>
