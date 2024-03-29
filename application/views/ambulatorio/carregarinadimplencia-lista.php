<?
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/exametemp/carregarinadimplencia/<?= $paciente_id ?>">
            Nova Inadimplência
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Inadimplência</a></h3>
        <div>
            <table>
                
                    <form method="get" action="<?= base_url() ?>ambulatorio/exametemp/listarinadimplencia/<?= $paciente_id ?>">
                        <tr>
                            <th class="tabela_title">Procedimento</th>
                            <th class="tabela_title">Convênio</th>
                            <th class="tabela_title"></th>
                        </tr>
                        <tr>
                            <th class="tabela_title">
                                <input type="text" name="procedimento" value="<?php echo @$_GET['procedimento']; ?>" />
                            </th>
                            <th class="tabela_title">
                                <input type="text" name="convenio" value="<?php echo @$_GET['convenio']; ?>" />
                            </th>
                            <th class="tabela_title">
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                    </form>
            </table>
            <table>
                <tr>
                    <th class="tabela_header">Paciente</th>
                    <th class="tabela_header">Data</th>
                    
                    <? if(@$permissoes[0]->associa_credito_procedimento == 't') {?>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Convênio</th>
                    <? } ?>
                        
                    <th class="tabela_header">Valor (R$)</th>
                       <th class="tabela_header">Observação</th>
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exametemp->listarinadimplencia($paciente_id);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exametemp->listarinadimplencia($paciente_id)->orderby('pt.nome, c.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                
                                <? if(@$permissoes[0]->associa_credito_procedimento == 't') {?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", ""); ?></td>
                                  <td class="<?php echo $estilo_linha; ?>"><?= @$item->observacaocredito; ?></td>
                              
                                <?$gerente_recepcao_top_saude = $this->session->userdata('gerente_recepcao_top_saude');?>
                                <?if($item->agenda_exames_id == '' && $perfil_id == 1 || ($gerente_recepcao_top_saude && $perfil_id == 5)){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir esse item?');" href="<?= base_url() ?>ambulatorio/exametemp/excluirinadimplencia/<?= $item->paciente_inadimplencia_id ?>/<?= $paciente_id ?>">Excluir</a></div>
                                    </td> 
                                <?}?>
                                
                                <? if ($item->faturado == 'f') { ?>
                                    
                                    <?if($item->agenda_exames_id != ''){?>
                                        <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/faturarmodelo2/<?= $item->agenda_exames_id ?>/<?= $item->procedimento_convenio_id?>/<?= $item->guia_id?>">Faturar</a></div>
                                        </td>  
                                    <?}else{?>
                                        <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/exametemp/faturarinadimplencia/<?= $item->paciente_inadimplencia_id ?>/<?= $paciente_id ?>">Faturar</a></div>
                                        </td>  
                                    <?} ?>
                                    
                                     
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                            Faturado
                                    </td>  

                                <? } ?>
                               
 
                            </tr>
                        <? } ?>
                        <tr id="tot">
                            <td class="<?php echo $estilo_linha; ?>" id="textovalortotal" colspan="2">
                                <span id="spantotal"> Saldo:</span> 
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" colspan="3">
                                <span id="spantotal">
                                    R$ <?= number_format($valortotal[0]->saldo, 2, ',', '') ?>
                                </span>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" id="textovalortotal" colspan="3">
<!--                                <div class="bt_link" style="float: right">
                                    <a href="<?= base_url() ?>ambulatorio/exametemp/gerasaldocredito/<?= $paciente_id ?>">Saldo</a>
                                </div>-->
                            </td>
                        </tr>

                    </tbody>
                <? } ?>
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
    function confirmarEstorno(credito_id, paciente_id){
//        alert('<?= base_url() ?>ambulatorio/exametemp/excluircredito/'+credito_id+'/'+paciente_id+'?justificativa=');
        var resposta = prompt("Informe o motivo do estorno.");
        if(resposta == null || resposta == ""){
            return false;
        }
        else {
            window.open('<?= base_url() ?>ambulatorio/exametemp/excluircredito/'+credito_id+'/'+paciente_id+'?justificativa='+resposta, '_self');
//            alert(resposta);
        }
    }
</script>
<style>
    #spantotal{

        color: black;
        font-weight: bolder;
        font-size: 18px;
    }
    #textovalortotal{
        text-align: right;
    }
    #tot td{
        background-color: #bdc3c7;
    }

    #form_solicitacaoitens div{
        margin: 3pt;
    }
</style>