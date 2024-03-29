
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/carregarespecialidadeparecer/0">
            Nova Especialidade Parecer
        </a>
    </div>
    
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Especialidade Parecer</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>centrocirurgico/centrocirurgico/manterespecialidadeparecer">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header" colspan="3"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->centrocirurgico_m->listarespecialidadeparecer($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->centrocirurgico_m->listarespecialidadeparecer($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarespecialidadeparecer/<?= $item->especialidade_parecer_id ?>">Editar</a></div>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir essa especialidade parecer?');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirespecialidadeparecer/<?= $item->especialidade_parecer_id ?>">Excluir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/subrotinaespecialidadeparecer/<?= $item->especialidade_parecer_id ?>">Sub-Rotina</a></div>
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

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
