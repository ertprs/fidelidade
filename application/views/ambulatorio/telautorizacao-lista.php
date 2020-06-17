
<div class="content"> <!-- Inicio da DIV content -->
 
    <div id="accordion">
        <h3 class="singular"><a href="#">Tela de autorização</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/guia/listarautorizacao">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Nº Autorização</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Data / Hora</th>
                        <th class="tabela_header">Parceiro</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $perfil_id = $this->session->userdata('perfil_id'); 
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->guia->listarautorizacao($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->guia->listarautorizacao($_GET)->orderby('data_cadastro')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <?= $item->paciente_verificados_id; ?>   
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date('d/m/Y H:i:s', strtotime($item->data_cadastro)) ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">      
                                   <?php if($perfil_id != 10){?>
                                    <a onclick="javascript: return confirm('Deseja realmente Autorizar ?');" href="<?= base_url() ?>ambulatorio/guia/autorizarprocedimento/<?= $item->paciente_verificados_id ?>" target="_blank">Autorizar</a>
                                   <?php }?>
                                </td>
                                  <td class="<?php echo $estilo_linha; ?>" width="70px;"> 
                                     <?php if($perfil_id != 10){?>
                                       <a onclick="javascript: return confirm('Deseja realmente Excluir?');" href="<?= base_url() ?>ambulatorio/guia/excluirautorizarprocedimento/<?= $item->paciente_verificados_id ?>"  target="_blank">Excluir</a>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
