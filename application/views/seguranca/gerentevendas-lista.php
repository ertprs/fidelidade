<div class="content"> <!-- Inicio da DIV content -->
    <?php $perfil_id = $this->session->userdata('perfil_id'); ?>
<!--    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>seguranca/operador/novo">
            Novo Operador
        </a>
    </div>-->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Gerente de Vendas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            Lista de Gerente de Vendas
                            <form method="get" action="<?= base_url() ?>seguranca/operador/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Usu&aacute;rio</th>
                        <th class="tabela_header">Perfil</th>
                        <th class="tabela_header">Ações</th>
                        <!--<th class="tabela_header" colspan="3" width="140px;">A&ccedil;&otilde;es</th>-->
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->operador_m->listargerentevendas($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = $limite_paginacao;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        if($limit != "todos"){
                            $lista = $this->operador_m->listargerentevendas($_GET)->orderby('ativo desc')->orderby('nomeperfil')->orderby('nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->operador_m->listargerentevendas($_GET)->orderby('ativo desc')->orderby('nomeperfil')->orderby('nome')->get()->result();
                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->usuario; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nomeperfil; ?></td>
                                
                                 <?if($item->ativo == 't'){?>
                                
                                    
                                    <td colspan="3" class="<?php echo $estilo_linha; ?>" width="140px;">
                                                    <?php if($perfil_id != 10){ ?>  
                                    <a  onclick="javascript:window.open('<?= base_url() . "seguranca/operador/operadorgerentevendas/$item->operador_id"; ?> ', '_blank');">Vendedores
                                    </a>
                                                    <?php }?>
<!--                           href="<?= base_url() ?>seguranca/operador/operadorconvenio/<?= $item->operador_id ?>"-->
                                        </td>
                                                                    <?}else{?>
                                    <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <?}?>
                                   </td>
                        </tr>

                        </tbody>
                <?php
                        }
                    }
                ?>
                        <tfoot>
                            <tr>
                        <th class="tabela_footer" colspan="9">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisargerentevendas/50');" <? if ($limit == 50) { echo "selected"; } ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisargerentevendas/100');" <? if ($limit == 100) { echo "selected"; } ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>seguranca/operador/pesquisargerentevendas/todos');" <? if ($limit == "todos") { echo "selected"; } ?>> Todos </option>
                                </select>
                            </div>
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
