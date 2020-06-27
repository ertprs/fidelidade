<?php $perfil_id = $this->session->userdata('perfil_id'); ?>
<div class="content"> <!-- Inicio da DIV content -->
    <?php if($perfil_id != 10){?>
        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>cadastros/formapagamento/carregarformapagamento/0">
                Novo Plano
            </a>
        </div>
    <?php }?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Planos</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>cadastros/formapagamento/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header" width="70px;" colspan="6"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $empresa_p = $this->guia->listarempresa();
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->formapagamento->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->formapagamento->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                        <tr >
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">  
                                            <?php if($perfil_id != 10){?>
                                    <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamento/<?= $item->forma_pagamento_id ?>">Editar</a>
                                            <?php }?>
                                </td>
                                 <?php if($perfil_id != 10 && $empresa_p[0]->tipo_carencia != "ESPECIFICA"){?>
                                   <td class="<?php echo $estilo_linha; ?>" width="70px;">   
                                        <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamentocarencia/<?= $item->forma_pagamento_id ?>">Carência</a> 
                                   </td>
                                <?php }elseif($perfil_id != 10 && $empresa_p[0]->tipo_carencia == "ESPECIFICA"){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">  
                                      <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamentocarenciaespecifica/<?= $item->forma_pagamento_id ?>">Carência Específica</a>
                                  </td>
                                <?php }else{  ?>
                                  <td class="<?php echo $estilo_linha; ?>" width="70px;"> </td>
                                  <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">   
                                      <?php if($perfil_id != 10){?>
                                    <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamentocomissao/<?= $item->forma_pagamento_id ?>">Comissão</a>
                                    <?php }?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> 
                                      <?php if($perfil_id != 10){?>
                                    <a href="<?= base_url() ?>cadastros/formapagamento/anexararquivos/<?= $item->forma_pagamento_id ?>">Arquivos</a>
                                     <?php }?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"> 
                                      <?php if($perfil_id != 10){?>
                                    <a   href="<?= base_url() ?>cadastros/formapagamento/cadastrarprocedimentoplano/<?= $item->forma_pagamento_id ?>">Procedimentos </a>
                                     <?php }?>
                                </td> 
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">  
                                    <?php if($perfil_id != 10){?>
                                      <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Forma?');" href="<?= base_url() ?>cadastros/formapagamento/excluir/<?= $item->forma_pagamento_id ?>">Excluir</a>
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

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>

