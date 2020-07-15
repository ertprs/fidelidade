
<?
if (count($exames) > 0) {

    foreach ($exames as $item) {
        if ($item->ativo == 't') {
            $ativo = 't';
            break;
        } else {
            $ativo = 'f';
        }
    }
} else {
    $ativo = 'f';
}
?>
<style>
    #observacao{
        width: 190%; height: 70%;
    }
</style>
<div class="content ficha_ceatox">
    <? 
    $perfil_id = $this->session->userdata('perfil_id');
    if ($ativo == 'f' && $perfil_id != 10) { ?>
        <div class="bt_link_new">
            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/novocontrato/" . $paciente['0']->paciente_id; ?> ', '_blank', 'width=900,height=600');">
                Novo Contrato
            </a>
        </div>
    <? } ?> 
    
    <?php
    if($paciente[0]->situacao == "Titular" ){
        if($paciente['0']->empresa_id == "") {
          ?>
       <div class="bt_link_new">
              <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/trasnformarfuncionario/" . $paciente['0']->paciente_id; ?> ', '_blank', 'width=900,height=600');">
                 Transformar funcionario
              </a>
          </div>
      <? }else{?> 
        <div class="bt_link_new">
             <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/trasnformartitular/" . $paciente['0']->paciente_id; ?> ', '_blank', 'width=900,height=600');">
                  Transformar Titular
              </a>
          </div> 
     <?   
       }
    }
    ?>
    
    
    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
                        if ($paciente['0']->sexo == "M"):echo 'selected';
                        endif;
                        ?>>Masculino</option>
                        <option value="F" <?
                        if ($paciente['0']->sexo == "F"):echo 'selected';
                        endif;
                        ?>>Feminino</option>
                    </select>
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
        </form>

        <fieldset>
            <?
            $guia_id = 0;
            $cancelado = 0;
            // echo '<pre>';
            // print_r($exames);
            // die;
            if (count($exames) > 0) {
                ?>
                <table >
                    <thead>
                        <tr>
                            <th class="tabela_header">Contrato</th>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Status</th>
                            <th colspan="6" class="tabela_header"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) :
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td style="width: 150px;" class="<?php echo $estilo_linha; ?>" ><a href="<?= base_url() ?>ambulatorio/guia/listardependentes/<?= @$paciente['0']->paciente_id; ?>/<?= @$item->paciente_contrato_id ?>" target="_blank"><?= @$item->paciente_contrato_id . "-" . @$item->plano; ?></a></td>
                                <td style="width: 150px;" class="<?php echo $estilo_linha; ?>" ><?= substr(@$item->data_cadastro, 8, 2) . "/" . substr(@$item->data_cadastro, 5, 2) . "/" . substr(@$item->data_cadastro, 0, 4); ?></td>

                                <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">Ativo</td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">Inativo</td>
                                <? } ?>
                                <? if ($perfil_id != 6 && $perfil_id != 5) { ?>
                                    <? $perfil_id = $this->session->userdata('perfil_id'); ?>
                                            
                                    <?php if($item->ativo == 'f'){?>
                                    
                                   <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                        <div class="bt_link_new" style="width: 100px;">
                                           <a target="_blank" href="<?= base_url() . "ambulatorio/guia/impressaorecibocontrato/" . @$item->paciente_contrato_id . "/" . @$paciente['0']->paciente_id ?>">
                                                Recibo
                                            </a>
                                        </div>
                                    </td>
     
                                    <?php }?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                        <div class="bt_link_new" style="width: 100px;">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . @$item->paciente_contrato_id ?> ', '_blank', 'width=1000,height=1000');">
                                                Carteira
                                            </a>
                                        </div>
                                    </td>
                                <?php 
                                
                               // if($paciente['0']->empresa_id != "") {
                                    
                                //}
?>
                                    
                                <!--  <td class="<?php echo $estilo_linha; ?>" >       
                                        <div class="bt_link_new" style="width: 100px;">
                                            <a target="_blank" href="<?= base_url() . "ambulatorio/guia/listarpagamentofuncionariosempresa/" . @$paciente['0']->paciente_id."/".$paciente['0']->empresa_id."/".$item->forma_pagamento_id."/".$item->paciente_contrato_id;?>">
                                                Pagamento 
                                            </a>
                                        </div>
                                    </td>-->
                             
                                    
                                    <td class="<?php echo $estilo_linha; ?>" >       
                                        <div class="bt_link_new" style="width: 100px;">
                                            <a target="_blank" href="<?= base_url() . "ambulatorio/guia/listarpagamentos/" . @$paciente['0']->paciente_id . "/" . @$item->paciente_contrato_id ?>">
                                                Pagamento
                                            </a>
                                        </div>
                                    </td>                                    
                                               
                                    <td class="<?php echo $estilo_linha; ?>" >       
                                        <div class="bt_link_new" style="width: 100px;">
                                            <a target="_blank" href="<?= base_url() . "ambulatorio/guia/anexararquivoscontrato/" . @$item->paciente_contrato_id ?>">
                                                Arquivos
                                            </a>
                                        </div>
                                    </td>

                                    <? if (($perfil_id == 1 || $perfil_id == 5) && $item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>"  colspan="2">       
                                            <div class="bt_link_new" style="width: 100px;">
                                                <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas');"   href="<?= base_url() . "ambulatorio/guia/excluircontrato/" . $paciente[0]->paciente_id . "/" . @$item->paciente_contrato_id ?>">
                                                    Excluir
                                                </a>
                                            </div>
                                        </td>   
                                    <? } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"> 
                                            <? if ($ativo == 'f' && $perfil_id != 10) { ?>
                                                <div class="bt_link_new" style="width: 100px;">
                                                    <a onclick="javascript: return confirm('Deseja realmente re-ativar o contrato?');"   href="<?= base_url() . "ambulatorio/guia/ativarcontrato/" . $paciente['0']->paciente_id . "/" . @$item->paciente_contrato_id ?>">
                                                        Re-Ativar
                                                    </a>
                                                </div>
                                            <? } ?>
                                        </td>      
                                    <? } ?>
                                    <?
                                    if ($operador_id == 1) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" >       
                                            <div class="bt_link_new" style="width: 100px;">
                                                <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas. Excluir por esse botão fará o contrato sumir');"   href="<?= base_url() . "ambulatorio/guia/excluircontratoadmin/" . $paciente[0]->paciente_id . "/" . @$item->paciente_contrato_id ?>">
                                                    Excluir (Admin)
                                                </a>
                                            </div>
                                        </td> 
                                        <?
                                    }
                                    ?>
                                    <?
                                } else {
                                    if ($perfil_id == 5 && $item->ativo == 't') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" >       
                                            <div class="bt_link_new" style="width: 100px;">
                                                <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas');"   href="<?= base_url() . "ambulatorio/guia/excluircontrato/" . $paciente[0]->paciente_id . "/" . @$item->paciente_contrato_id ?>">
                                                    Excluir
                                                </a>
                                            </div>
                                        </td> 
                                        <?
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" colspan="5"> 
                                        </td>     
                                        <?
                                    }
                                }
                                ?>

                                                                                                                <!--                            <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                                                                                                    <div class="bt_link_new">
                                                                                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/integracaoiugu/" . $paciente['0']->paciente_id . "/" . $item->paciente_contrato_id ?> ', '_blank', 'width=800,height=1000');">
                                                                                                                            Pagamento Iugu
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                </td>-->




                            </tr>


                            <?
                        endforeach;
                    } else {
                        $estilo_linha = "tabela_content01";
                        ?>
                    <table >
                        <thead>
                            <tr>
                                <th class="tabela_header">Contrato</th>
                                <th class="tabela_header">Titular</th>
                                <th colspan="2" class="tabela_header"></th>


                            </tr>
                        </thead>
                        <tbody>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= @$titular['0']->paciente_id; ?>/<?= @$titular['0']->paciente_contrato_id ?>');"><?= @$titular['0']->paciente_contrato_id; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= @$titular['0']->paciente_id; ?>/<?= @$titular['0']->paciente_contrato_id ?>');"><?= @$titular['0']->nome; ?></td>
                        <? if ($perfil_id != 6 && $perfil_id != 5) { ?>
                        <td class="<?php echo $estilo_linha; ?>" width="50px;" >       
                                <div class="bt_link_new"    >
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . @$titular['0']->paciente_contrato_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=1000');">
                                        Carteira
                                    </a>
                                </div>
                             <?php if (@$paciente[0]->situacao == "Dependente" && @$titular['0']->paciente_id != "") {
                                ?>
                                     
                                    <div class="bt_link_new" style="width: 10px;">
                                        <a href="<?= base_url() . "ambulatorio/guia/pesquisar/" . @$titular['0']->paciente_id; ?>" target="_blank">
                                            Contrato
                                        </a>
                                    </div>
                                  <?php if($perfil_id != 10){?>
                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/guia/excluir/<?= $paciente['0']->paciente_id ?>/<?= $titular['0']->paciente_contrato_id ?>">Excluir </a>
                                    </div> 
                                  <?php }?>
                             
                            <?php } 
                             if (count($titular) > 0 && $titular['0']->paciente_contrato_id == "" && @$paciente[0]->situacao == "Dependente") {
                                ?>
                              <div class="bt_link">
                                  <a href="<?= base_url() ?>ambulatorio/guia/excluircontratodependente/<?= $paciente['0']->paciente_id ?>/<?= $titular['0']->paciente_contrato_dependente_id ?>" target="_blank">Excluir </a>
                              </div>    
                            <?  } ?>
                            
                            
                            </td>
                           

                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"></td>
                        <? } ?>    
                        <?
                    }
                    ?>
                    </tbody>                                
                    <br>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="11">
                            </th>
                        </tr>
                    </tfoot>
                </table>
        </fieldset>
        <fieldset>

         <?php if($perfil_id != 10){?>
            <button type="button" class="btn-toggle" data-element="#minhaDiv">Observação</button>   
            <br>
            <div id="minhaDiv" style="display:none">

                <form action="<?= base_url() ?>ambulatorio/guia/gravarobservacaopaciente/<?= $paciente[0]->paciente_id; ?>" method="post" target="_blank">
                    <table>
                        <tr>
                        <td><label><b>STATUS</b></label></td>

                        <td> 
                            <select name="status" required>
                        <option value="">Selecione</option>
                        <? foreach($status as $item){?>
                            <option value="<?=$item->status_id?>">
                            <?=$item->nome?></option>
                        <? } ?>
                        </select>
                            </td>
                        </tr>
                        <tr>
                            <td> <textarea type="text" name="observacao" id="observacao" style=""></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>  <button type="submit">Enviar</button></td>
                        </tr>

                    </table>
                </form>
                <br>

            </div>
            <br>
         <?php }?>
            <legend>Observações</legend>
            <table>
                <tr>
                    <td  class="tabela_header">Observação</td>
                    <td  class="tabela_header">Usuário</td>
                    <td  class="tabela_header" colspan="2">Data/Hora</td>
                </tr>
                <?php
                $estilo_linha = "tabela_content01";
                foreach ($observacao_paciente as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td  class="<?php echo $estilo_linha; ?>" ><?= $item->observacao ?></td>
                        <td  class="<?php echo $estilo_linha; ?>" ><?= $item->operador ?></td>
                        <td  class="<?php echo $estilo_linha; ?>" ><?= date('d/m/Y H:i:s', strtotime($item->data_cadastro)) ?></td>

                        <?php
                        if ($this->session->userdata('operador_id') == 1) {
                            ?>
                            <td  class="<?php echo $estilo_linha; ?>" >
                                <div class="bt_link_new" style="width: 100px;">
                                    <a  onclick="javascript: return confirm('Deseja realmente excluir?');"  href="<?= base_url() ?>ambulatorio/guia/excluirobservacao/<?= $item->observacao_contrato_id; ?>" target="_blank">Excluir</a>
                                </div>
                            </td>
                            <?php
                        }
                        ?>


                    </tr>

                    <?
                }
                ?>
            </table>
          
        </fieldset>
        <br>
    </div>


    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
    <script type="text/javascript">


                                        $(document).ready(function () {

                                            $.getJSON('<?= base_url() ?>autocomplete/pagamentoautomaticoiugucliente', {paciente_id: <?= $paciente['0']->paciente_id; ?>, ajax: true}, function (j) {
                                                //           alert(j);
                                                //                    
                                            });

                                            $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticoiugucliente', {paciente_id: <?= $paciente['0']->paciente_id; ?>, ajax: true}, function (j) {
                                                //           alert(j);
                                                //                    
                                            });

                                            $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticoconsultaavulsaiugucliente', {paciente_id: <?= $paciente['0']->paciente_id; ?>, ajax: true}, function (j) {
                                                //           alert(j);
                                                //                    
                                            });
                                        });




                                        $(function () {
                                            $(".btn-toggle").click(function (e) {
                                                e.preventDefault();
                                                el = $(this).data('element');
                                                $(el).toggle();
                                            });
                                        });


    </script>
