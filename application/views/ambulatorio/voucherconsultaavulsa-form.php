<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript">

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

</script>
<style>
    td{
        width: 70px;
    }
</style>
<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Informações Voucher</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarvoucherconsultaextra/<?= $consulta_avulsa_id; ?>/<?= $paciente_id; ?>/<?= $contrato_id; ?>" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <table>
                            <tr>
                                <td>
                                    Data:
                                </td>
                                <td>
                                    <input required style="width:100px;" type="text" id="data" name="data"  class="texto02" value="<?=(@$voucher[0]->data != '') ? date("d/m/Y",strtotime(@$voucher[0]->data)) : ''?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Hora:
                                </td>
                                <td>
                                    <input required style="width:100px;" type="time" id="hora" alt="time" name="hora"  class="texto02" value="<?=(@$voucher[0]->horario != '') ? date("H:i", strtotime(@$voucher[0]->horario)) : ''?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Forma de Pagamento</td>
                                <td>
                                    <select name="forma_rendimento_id" name="forma_rendimento_id">
                                        <? foreach($forma_pagamentos as $item){  ?>
                                          <option value="<?=  $item->forma_rendimento_id; ?>"
                                                <?
                                                if (@$voucher[0]->forma_rendimento_id == $item->forma_rendimento_id):echo 'selected';
                                                endif;
                                                ?>   
                                                  ><?= $item->nome?></option> 
                                        <? } ?>  
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    Parceiro:
                                </td>
                                <td>
                                    <? $listarparceiro = $this->paciente->listarparceiros(); ?>
                                    <select name="parceiro_id" id="parceiro_id" class="size2" required>
                                        <option value='' >Selecione</option>
                                        <?php foreach ($listarparceiro as $item) {?>
                                            <option   value =<?php echo $item->financeiro_parceiro_id; ?> <?
                                                if (@$voucher[0]->parceiro_id == $item->financeiro_parceiro_id):echo 'selected';
                                                endif;
                                                ?>>
                                                <?php echo $item->fantasia; ?>
                                            </option>
                                        <? }?> 
                                                
                                            
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            <td>Gratuito?</td>
                            <td><input type="checkbox" name="gratuito" <? if (@$voucher[0]->gratuito == 't') echo "checked"; ?>></td>
                            </tr>
                        </table>
                            
                        
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
                <fieldset>
                    <table border=1 cellspacing=0 cellpadding=2 >
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Forma de pagamento</th>
                            <th>Parceiro</th>
                            <th>Gratuito?</th>
                            <th colspan="3">Ações</th>
                        </tr>
                            <?php  
                            foreach($voucher as $item){   ?>
                             <tr>
                                 <td><?= date('d/m/Y',strtotime($item->data)); ?></td>
                                 <td><?= date('H:i:s',strtotime($item->horario)); ?></td>
                                 <td><?=  $item->forma_pagamento; ?></td>
                                 <td><?=  $item->parceiro; ?></td>
                                 <td><?= ($item->gratuito == "t") ? "Sim" : "Não";?></td>
                                 
                                 <td><a href="<?= base_url(); ?>ambulatorio/guia/carregarvoucher/<?= $paciente_id; ?>/<?= $contrato_id; ?>/<?= $consulta_avulsa_id; ?>/<?= $item->voucher_consulta_id; ?>">Editar</a></td>
                                 <td><a href="<?= base_url(); ?>ambulatorio/guia/impressaovoucherconsultaextra/<?= $paciente_id; ?>/<?= $contrato_id; ?>/<?= $consulta_avulsa_id; ?>/<?= $item->voucher_consulta_id; ?>">Imprimir</a></td>
                                  <?php if($this->session->userdata('operador_id') == 1){?>
                                       <td><a href="<?= base_url(); ?>ambulatorio/guia/excluirvoucher/<?= $paciente_id; ?>/<?= $contrato_id; ?>/<?= $consulta_avulsa_id; ?>/<?= $item->voucher_consulta_id; ?>">Excluir</a></td>
                                  <?php }?>
                             </tr>
                           <?  } ?>
                    </table>
                  
                </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
