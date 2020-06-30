<?
//echo "<pre>";
//print_r($listarpagamentoscontrato);
?>


<div class="content ficha_ceatox">

    <div>
        <?
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa');
        $perfil_id = $this->session->userdata('perfil_id');
        $empresa = $this->guia->listarempresa();
        ?>
        <!--<h3 class="singular"><a href="#">Marcar exames</a></h3>-->
        <!--         <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>cadastros/pacientes/novofuncionario/<?php echo @$empresa_cadastro_id; ?>">
                        Voltar
                    </a>
                </div>-->


        <div>

<!--            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravardependentes" method="post">
    <fieldset>
        <legend>Dados do Paciente</legend>
        
        <div>
            <label>Nascimento</label>  
            <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value=" " onblur="retornaIdade()" readonly/>
        </div>

        <div> 
            <label>Idade</label>
            <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value=" " readonly />

        </div>

        <div>
            <label>Nome da M&atilde;e</label>


            <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value=" " readonly/>
        </div>
    </fieldset>

</form>-->

            <fieldset width="100%">
                <legend>Parcelas</legend>
                <? if (count($listarpagamentoscontrato) > 0) { ?>
                    <table id="table_justa" >
                        <thead>
                            <tr>
                                <th width="70px;" class="tabela_header">Parcela</th>
                                <th width="70px;" class="tabela_header">Data</th>
                                <th width="70px;" class="tabela_header">Valor</th>
                                <th width="70px;" class="tabela_header">Situacao</th>
                                <th width="70px;" class="tabela_header">Observações</th>
    <!--                        <th width="70px;" class="tabela_header">Taxa de Adesão</th>-->
                                <th width="70px;" colspan="2" class="tabela_header">FORMA DE PAGAMETO: <?= @$listarpagamentoscontrato['0']->forma_pagamento; ?></th>
                                <? if (@$listarpagamentoscontrato[0]->contrato == 't') { ?>
                                    <th class="tabela_header" colspan="1">
                                        

                                    </th>
                                    <th class="tabela_header" colspan="1">

                                    </th>
                                     <th class="tabela_header" colspan="1">

                                    </th>
                                    <th class="tabela_header" colspan="1">
                                        <?
                                        if (@$paciente[0]->empresa_id != ""):
                                            if ($this->session->userdata('empresa_id') == @$paciente[0]->empresa_id):
                                                ?>


                                                <?
                                            else:

                                            endif;

                                        else:
                                            ?>


                                            <!--                                            <div class="bt_link">
                                                                                            <a href="<?= base_url() ?>ambulatorio/guia/pagamentodebitoconta/ <?= @$contrato_id ?>">Débito em conta
                                                                                            </a>
                                                                                        </div>-->

                                        <?
                                        endif;
                                        ?>



                                    </th>
                                <? } ?>
                            </tr>
                        </thead>
                        <?
                        $key = $empresa[0]->iugu_token;
                        Iugu::setApiKey($key);
                        $contador = 0;
                          $perfil_id = $this->session->userdata('perfil_id'); 
                        foreach ($listarpagamentoscontrato as $item) {

                            $saber_se_foi_pago = $item->data_cartao_iugu;

                            $paciente_contrato_parcelas_iugu_id = $item->paciente_contrato_parcelas_iugu_id;

                            $empresa_iugu = $empresa[0]->iugu_token;


                            if (@$item->empresa_id != "") {
                                $excluir_somente_empresa = true;
                            } else {
                                $excluir_somente_empresa = false;
                            }

                            $contador ++;
//                            if ($empresa[0]->iugu_token != '' && $item->ativo == 't' && $item->invoice_id != '') {
//                                $invoice_id = $item->invoice_id;
//
//                                $retorno = Iugu_Invoice::fetch($invoice_id);
//                                if ($retorno['status'] == 'paid') {
////                                    echo '<pre>';
////                                    var_dump($retorno);
////                                    die;
//                                    $this->guia->confirmarpagamento($item->paciente_contrato_parcelas_id);
//                                }
//                            }
                            ?>
                            <?
                            $MES = substr($item->data, 5, 2);

                            switch ($MES) {
                                case "01": $mes = 'Janeiro';
                                    break;
                                case "02": $mes = 'Fevereiro';
                                    break;
                                case "03": $mes = 'Março';
                                    break;
                                case "04": $mes = 'Abril';
                                    break;
                                case "05": $mes = 'Maio';
                                    break;
                                case "06": $mes = 'Junho';
                                    break;
                                case "07": $mes = 'Julho';
                                    break;
                                case "08": $mes = 'Agosto';
                                    break;
                                case "09": $mes = 'Setembro';
                                    break;
                                case "10": $mes = 'Outubro';
                                    break;
                                case "11": $mes = 'Novembro';
                                    break;
                                case "12": $mes = 'Dezembro';
                                    break;
                            }


                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>">
                                        <a style="text-decoration: none;" >
                                            <?= @$mes; ?> <? if (@$item->taxa_adesao == 't') { ?><span style="color:green;">Adesão </span><? } ?>
                                        </a >
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.') ?></td>


                                    <? if ($item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>">ABERTA</td>


                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>
                                                <td colspan="3"  class="<?php echo $estilo_linha; ?>">                                                       
                                                </td>
                                                <?
                                            else:
                                                ?>

                                                <td colspan="2"  class="<?php echo $estilo_linha; ?>">                                                       
                                                </td>
                                            <?
                                            endif;
                                        else:
                                            ?>

                                             <?php if($perfil_id != 10){?>
                                            <td style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $empresa_cadastro_id ?>/<?= @$contrato_id ?>/<?= @$item->paciente_contrato_parcelas_id ?>" target="_blank">=> <?= $item->observacao ?></a></td>
                                                                <?php }else{?>
                                              <td style="width: 130px"  class="<?php echo $estilo_linha; ?>"> </td>
                                                  <?php }?>
                                                
                                                <? endif; ?>

                                        <?
                                        if ($item->contrato == 't' && $perfil_id != 10) {

                                            @$contrato = "true";
                                            ?>

                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                 <?
                                   if ($empresapermissao[0]->confirm_outra_data == 't') {


                                        if ($excluir_somente_empresa == True):
                                                 if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                     ?>

                                                 <td colspan="2"  class="<?php echo $estilo_linha; ?>">                                                       
                                                 </td>

                                                 <?
                                             endif;
                                         else: ?>
                                            <div class="bt_link">
                                                  <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/alterarpagamentoempresa/$item->paciente_contrato_parcelas_id"; ?>/<?= $empresa_cadastro_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');">
                                                Confirmar
                                            </a>
                                            </div>
                                        <?
                                        endif;
                                        ?>
                                        </td>
                                        <?
                                    }else {
                                        ?>

                                        <td class="<?php echo $estilo_linha; ?>" width="60px;" >

                                            <div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/guia/confirmarpagamentoempresa/<?= @$item->paciente_contrato_parcelas_id ?>/<?= $empresa_cadastro_id; ?>" target="_blank">Confirmar
                                                </a>
                                            </div>

                                        </td>


                                    <? }
                                    ?>

                                    <? if ($perfil_id == 1 || $perfil_id == 2) { ?>


                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>
                                                <td colspan="3"  class="<?php echo $estilo_linha; ?>">                                                       
                                                </td>
                                                <?
                                            endif;
                                        else:
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                <div class="bt_link">

                                                    <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/alterardatapagamentoempresacadastro/$empresa_cadastro_id/$item->paciente_contrato_parcelas_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');">
                                                        Alterar Data
                                                    </a>
                                                </div>
                                            </td>
                                        <?
                                        endif;
                                        ?>



                                    <? }
                                    ?>
                                    <? if ($item->paciente_contrato_parcelas_iugu_id == '' && $empresa[0]->iugu_token != '' && $item->data_cartao_iugu == '') { ?>

                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>

                                                <td colspan="3"  class="<?php echo $estilo_linha; ?>">                                                       
                                                </td>

                                                <?
                                            else:
                                                ?>
                                                <td  class="<?php echo $estilo_linha; ?>" > 

                                                </td>
                                            <?
                                            endif;
                                        else:
                                            ?>

                                                                        <!--                                            <td  class="<?php echo $estilo_linha; ?>" ><div style="width: 100px;" class="bt_link">
                                                                                                                            <a id="botaopagamento<?= $contador ?>" href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiugu/ <?= @$contrato_id ?>/<?= @$item->paciente_contrato_parcelas_id ?>">Gerar Pag. Iugu
                                                                                                                            </a></div>
                                                                                                                    </td>-->
                                        <? endif; ?>



                                        <? if ($item->pago_cartao != 't') { ?>
                                            <td  class="<?php echo $estilo_linha; ?>" >

                                            </td>   
                                        <? } else { ?>
                            <!--                                            <td  class="<?php echo $estilo_linha; ?>" style="color: #ebcf11" >Aguardando Confirmação
                                            </td>  -->
                                        <? } ?>

                                    <? } elseif ($item->data_cartao_iugu != '') { ?>
                                        <? if ($item->status != '') { ?>
                                            <td colspan="1" class="<?php echo $estilo_linha; ?>" ><span style="color: #888001;font-weight: bold" > <?
                                                    if ($item->status == 'pending') {
                                                        echo 'Pendente';
                                                    } else {
                                                        echo $item->status . ". Código LR: " . $item->codigo_lr;
                                                    }
                                                    ?></span><a target="_blank" href="https://support.iugu.com/hc/pt-br/articles/206858953-Como-identificar-o-erro-da-tentativa-de-pagamento-com-cart%C3%A3o-de-cr%C3%A9dito-falha-">->></a> </td>
                                        <? } else { ?>
                                            <td colspan="1" class="<?php echo $estilo_linha; ?>" ><span style="color: #01882e;font-weight: bold" > Pagamento por Cartão Agendado</span> </td>      
                                        <? } ?>


                                        <td  class="<?php echo $estilo_linha; ?>" ><div style="width: 120px;" class="bt_link" >
                                                <a id="" href="<?= base_url() ?>ambulatorio/guia/cancelaragendamentocartao/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Cancelar Agen.
                                                </a></div> 

                                        </td> 
                                    <? } else { ?>

                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>

                                                <?
                                            else:
                                                ?>
                                                <td  class="<?php echo $estilo_linha; ?>" > 

                                                </td>
                                            <?
                                            endif;
                                        else:
                                            ?>

                                            <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                                <div style="width: 100px;" class="bt_link">
                                                    <a target="_blank" href="<?= $item->url ?>">Pag. Iugu
                                                    </a>
                                                </div>
                                            </td>
                                        <?
                                        endif;
                                        ?>

                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>

                                                <?
                                            else:
                                                ?>
                                                <td  class="<?php echo $estilo_linha; ?>" > 

                                                </td>
                                            <?
                                            endif;
                                        else:
                                            ?>

                                            <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                                <div style="width: 100px;" class="bt_link">
                                                    <a  href="<?= base_url() ?>ambulatorio/guia/reenviaremail/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Re-enviar Email
                                                    </a>
                                                </div>
                                            </td>

                                        <? endif; ?>


                                    <? }
                                    ?>
                                    <? if ($perfil_id == 1) { ?>

                                        <?
                                        if ($excluir_somente_empresa == True):
                                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                                ?>

                                                <?
                                            else:
                                                ?>

                                                <td  class="<?php echo $estilo_linha; ?>"                                                       
                                            </td>
                                        <?
                                        endif;
                                    else:
                                        ?> 
                                        <td onclick="javascript: return confirm('Deseja realmente excluir a parcela?');"  class="<?php echo $estilo_linha; ?>" ><div style="width: 50px;" class="bt_link">
                                                <a id="" href="<?= base_url() ?>ambulatorio/guia/excluirparcelacontratoempresacadastro/<?= @$item->paciente_contrato_parcelas_id ?>/<?= @$empresa_cadastro_id ?>">Excluir
                                                </a></div>  
                                        </td> 
                                    <?
                                    endif;
                                    ?>


                                <? }
                                ?>
                            <?
                            } else {
                                @$contrato = "false";
                                ?>
                                <td colspan="8" class="<?php echo $estilo_linha; ?>"></td> 

                            <? } ?>
                            <? } else { ?>
                            <td style="width: 130px" class="<?php echo $estilo_linha; ?>">PAGA (<?
                                if ($item->manual == 't') {
                                    echo 'Manual';
                                } elseif ($item->data_cartao_iugu != '') {
                                    echo 'Cartão';
                                } elseif ($item->debito == 't') {
                                    echo 'Débito';
                                } elseif ($item->empresa_iugu == 't') {
                                    echo 'Boleto Empresa';
                                } else {
                                    echo 'Manual';
                                }
                                ?>)
                            </td>
                            <? if ($item->manual == 't') { ?>

                                <?
                                if ($excluir_somente_empresa == True):
                                    if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                        ?>
                                        <td colspan="8" class="<?php echo $estilo_linha; ?>" > 

                                        </td>
                                        <?
                                    else:
                                        ?>

                                        <td colspan="5" class="<?php echo $estilo_linha; ?>"                                                       
                                    </td>
                                <?
                                endif;
                            else:
                                ?>



                <? endif; ?>


            <? } ?>


                        <?
                        if ($excluir_somente_empresa == True):
                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                ?>
                                <td colspan="6" class="<?php echo $estilo_linha; ?>" > 

                                </td>
                                <?
                            else:
                                ?>

                                <td colspan="5" class="<?php echo $estilo_linha; ?>"                                                       
                            </td>
                        <?
                        endif;
                    else:
                        ?>
                                        <?php if($perfil_id != 10){?>
                        <td colspan="1" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $empresa_cadastro_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>" target="_blank">=> <?= $item->observacao ?></a></td>
                                        <?php }else{
                                       ?>
                        <td colspan="2" class="<?php echo $estilo_linha; ?>"></td>
                        <?
                                        }
?>
                          
                        
                         <?php if($perfil_id != 10){?>
                            <td colspan="2"  class="<?php echo $estilo_linha; ?>">
                            <div class="bt_link">
                              <a href="<?= base_url() ?>ambulatorio/guia/impressaoreciboempresa/<?= $empresa_cadastro_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Recibo</a>
                              </div>
                            </td>
                         <?php }else{?>
                            <td colspan="5"  class="<?php echo $estilo_linha; ?>">
                             <div class="bt_link">
                               <a href="<?= base_url() ?>ambulatorio/guia/impressaoreciboempresa/<?= $empresa_cadastro_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Recibo</a>
                             </div>
                            </td>
                        <?php }?>
                        
                        
                        
                                    
 <? endif; ?>
                        


            <? if ($perfil_id == 1) { ?>


                        <?
                        if ($excluir_somente_empresa == True):
                            if ($this->session->userdata('empresa_id') == $item->empresa_id):
                                ?>

                                <?
                            else:
                                ?>

                                <td  class="<?php echo $estilo_linha; ?>"                                                       
                            </td>
                        <?
                        endif;
                    else:
                        ?>

                        <td   class="<?php echo $estilo_linha; ?>" ><div style="width: 50px;" class="bt_link">
                                <a id="" href="<?= base_url() ?>ambulatorio/guia/excluirparcelacontratoempresacadastro/<?= @$item->paciente_contrato_parcelas_id ?>/<?= @$empresa_cadastro_id ?>">Excluir
                                </a></div> 

                        </td>

                        <td   class="<?php echo $estilo_linha; ?>" colspan="2"><div style="width: 50px;" class="bt_link">
                                <a id="" onclick="javascript: return confirm('Deseja realmente Cancelar a parcela?');" href="<?= base_url() ?>ambulatorio/guia/cancelarparcelaempresa/<?= $item->paciente_contrato_parcelas_id ?>" target="_blank">Cancelar
                                </a></div> 

                        </td>
                    <?
                    endif;
                    ?>



                <? }
                ?>
        <? } ?>
            </tr>
            </tbody>
            <?
        }
        ?>
        <tfoot>

        </tfoot>
    </table> 
    <br/>
    <?
}
?>
</table> 


<br/>


<?
//echo "<pre>";
//print_r($listarpagamentoscontrato);
//echo $saber_se_foi_pago; 


if (count($listarpagamentoscontrato) > 0) {


    if ($empresa_iugu == "") {
        ?>

        <div style="text-align: center; border:1px solid silver;"> <b style="color:silver;" >API Token IUGU Não cadastrada</b></div>
        <?
    } else {

        if (@$saber_se_foi_pago == "" && @$paciente_contrato_parcelas_iugu_id == '' && @$empresa_iugu != '' && @$contrato != "false") {
            ?> 

            <div  style="width: 40%;" class="bt_link" >
                <a    href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiuguempresacadastro/<?= $empresa_cadastro_id ?>/<?= $contrato_id ?> " > Gerar Pagamento Iugu  </a> 
            </div> 


            <?
        } elseif (@$contrato == "false") {
            ?>
            <div style="text-align: center; border:1px solid silver;"> <b style="color:silver;" >Contrato Inativo</b></div>

            <?
        } else {
            ?>
            <div style="text-align: center; border:1px solid silver;"> <b style="color:green;" >Gerado com Sucesso!</b></div>

            <?
        }
        
        
        
    }
}
?>




</fieldset>




</div> 
</div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

<?php if ($this->session->flashdata('message') != ''): ?>
                                        alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>
                                    $(function () {
                                        $("#data").datepicker({
                                            autosize: true,
                                            changeYear: true,
                                            changeMonth: true,
                                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                            buttonImage: '<?= base_url() ?>img/form/date.png',
                                            dateFormat: 'dd/mm/yy'
                                        });
                                    });
                                    $(function () {
                                        $("#accordion").accordion();
                                    });
                                    $(function () {
                                        $("#medico1").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                            minLength: 3,
                                            focus: function (event, ui) {
                                                $("#medico1").val(ui.item.label);
                                                return false;
                                            },
                                            select: function (event, ui) {
                                                $("#medico1").val(ui.item.value);
                                                $("#crm1").val(ui.item.id);
                                                return false;
                                            }
                                        });
                                    });

//                                botaogerartodos
                                    $("#botaogerartodos").click(function () {
                                        $("#botaogerartodos").hide();
                                    });

<? for ($i = 0; $i <= $contador; $i++) { ?>
                                        $("#botaopagamento<?= $i ?>").click(function () {
                                            $("#botaopagamento<?= $i ?>").hide();
                                        });
<? } ?>
                                    $(function () {
                                        $('#convenio1').change(function () {
                                            if ($(this).val()) {
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                    }
                                                    $('#procedimento1').html(options).show();
                                                    $('.carregando').hide();
                                                });
                                            } else {
                                                $('#procedimento1').html('<option value="">Selecione</option>');
                                            }
                                        });
                                    });
                                    $(function () {
                                        $('#procedimento1').change(function () {
                                            if ($(this).val()) {
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                    options = "";
                                                    options += j[0].valortotal;
                                                    document.getElementById("valor1").value = options
                                                    $('.carregando').hide();
                                                });
                                            } else {
                                                $('#valor1').html('value=""');
                                            }
                                        });
                                    });
                                    $(function () {
                                        $('#procedimento1').change(function () {
                                            if ($(this).val()) {
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                    var options = '<option value="0">Selecione</option>';
                                                    for (var c = 0; c < j.length; c++) {
                                                        if (j[c].forma_pagamento_id != null) {
                                                            options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                        }
                                                    }
                                                    $('#formapamento').html(options).show();
                                                    $('.carregando').hide();
                                                });
                                            } else {
                                                $('#formapamento').html('<option value="0">Selecione</option>');
                                            }
                                        });
                                    });
</script>