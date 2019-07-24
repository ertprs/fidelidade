<div class="content"> <!-- Inicio da DIV content -->
    
    <div id="accordion">
        <h3><a href="#">Manter Parecer</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="8">
                            Lista de Solicitacões
                            <form method="get" action="<?php echo base_url() ?>centrocirurgico/centrocirurgico/pesquisarsolicitacaorotina">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Especialidade</th>
                        <th class="tabela_header">Médico Solicitante</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" width="30px;" colspan="6"><center></center></th>

                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->centrocirurgico_m->listarsolicitacaoparecer($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->centrocirurgico_m->listarsolicitacaoparecer($_GET)->orderby('cp.data_cadastro desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $situacao = '';

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo  date("d/m/Y H:i:s",strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->especialidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->solicitante; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->status; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                    <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/atendersolicitacaoparecer/<?= $item->centrocirurgico_parecer_id; ?>">Atender</a></div>
                                </td> 
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                    <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/visualizarparecercirurgico/<?= $item->centrocirurgico_parecer_id; ?>">Visualizar</a></div>
                                </td> 
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                    <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/impressaoparecercirurgico/<?= $item->centrocirurgico_parecer_id; ?>">Imprimir</a></div>
                                </td> 
                              
                               
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="15">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
