
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
    <? if($this->session->userdata('perfil_id') != 4 && $this->session->userdata('perfil_id') != 8 && $this->session->userdata('perfil_id') != 9){?>             
        <a href="<?php echo base_url() ?>ambulatorio/empresa/carregarempresacadastro/0">
            Nova Empresa
        </a>
    <? }?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Empresa</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/empresa/empresacadastrolista">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr> 
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">CNPJ</th>
                        <th class="tabela_header" colspan="1">Raz&atilde;o social</th>
                        <th class="tabela_header" colspan="4">Detalhes</th>
                    </tr>
                </thead>
                <?php
                
                $perfil_id = $this->session->userdata('perfil_id'); 
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->empresa->listarempresacadatro($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listarempresacadatro($_GET)->limit($limit, $pagina)->orderby("nome")->get()->result();
                        
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->cnpj; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->razao_social; ?></td> 
                                <? if($this->session->userdata('perfil_id') != 4 && $this->session->userdata('perfil_id') != 8 && $this->session->userdata('perfil_id') != 9  && $perfil_id != 10){?>
                                 <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/empresa/carregarempresacadastro/<?= $item->empresa_cadastro_id ?>">Editar</a></div>
                                 </td> 
                                <? } ?>
                               
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                   
                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/pacientes/novofuncionario/<?= $item->empresa_cadastro_id ?>">Detalhes</a>
                                    </div>   
                                 
                                </td>
                                <? if($this->session->userdata('perfil_id') != 5 ){
                                    ?>
                                <? if($this->session->userdata('perfil_id') != 4 && $this->session->userdata('perfil_id') != 8 && $this->session->userdata('perfil_id') != 9){?>             
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                       <?php if($perfil_id != 10){?>   
                                        <div class="bt_link">
                                            <a  onclick="javascript: return confirm('Deseja realmente excluir essa Empresa?');"   href="<?= base_url() ?>cadastros/pacientes/excluirempresacadastro/<?= $item->empresa_cadastro_id ?>">Excluir</a>
                                        </div> 
                                        <?php }?>
                                        
                                    </td> 
                                <?} } ?>
                                
                                
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
