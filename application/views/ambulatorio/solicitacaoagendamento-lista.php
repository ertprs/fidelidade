
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Solicitacação de Agendamento</a></h3>
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
                        <th class="tabela_header">Prontuário</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Turno</th>
                        <th class="tabela_header">Convênio</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header" colspan="5"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $perfil_id = $this->session->userdata('perfil_id');
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->empresa->listarsolicitacaoagendamento($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listarsolicitacaoagendamento($_GET)->limit($limit, $pagina)->orderby("pp.data_cadastro")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente_id;?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->hora; ?></td>
                                <?if($item->convenio != ''){?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <?}else{?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_text; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento_text; ?></td>
                                <?}?>
                               
                                
                                <td style="width:140px;" class="<?php echo $estilo_linha; ?>">
                                     <?php if($perfil_id != 10){?>
                                        <div class="bt_link">
                                         <a onclick="javascript: return confirm('Deseja confirmar a solicitação de agendamento?')" href="<?= base_url() ?>ambulatorio/empresa/confirmarsolicitacaoagendamento/<?= $item->paciente_solicitar_agendamento_id; ?>">Confirmar</a>
                                        </div>
                                    <?php }?>
                                </td>
                                <td style="width:140px;" class="<?php echo $estilo_linha; ?>">
                                     <?php if($perfil_id != 10){?>
                                    <div class="bt_link">
                                      
                                         <a onclick="javascript: return confirm('Deseja remover a solicitação de agendamento?')" href="<?= base_url() ?>ambulatorio/empresa/excluirsolicitacaoagendamento/<?= $item->paciente_solicitar_agendamento_id; ?>">Excluir</a></div>
                                       <?php }?>
                                </td>
                                
                                <?
                                $perfil_id = $this->session->userdata('perfil_id');
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
