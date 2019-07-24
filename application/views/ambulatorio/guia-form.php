 
<div class="content ficha_ceatox">

    <div >
        <?
        ?>
        <h3 class="singular"><a href="#">Marcar exames</a></h3>
        <div> 
            <?
            if ($empresa_permissao[0]->alterar_contrato == 't') {
               ?> 
            <div class="bt_link_new" >
                <a href="<?=  base_url(); ?>ambulatorio/guia/editarnumerocontrato/<?= $contrato_id; ?>">Alterar Contrato</a>
            </div>
            <?
            }else{ 
                
            }
            ?>
             
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravardependentes" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="txtcontrato_id" name="txtcontrato_id"  value="<?= $contrato_id; ?>"/>
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
                <? $perfil_id = $this->session->userdata('perfil_id'); ?>
                <? if ($perfil_id != 6 && $perfil_id != 5 || true) { ?>
                    <fieldset>
                        <table id="table_justa">
                            <thead>

                                <tr>
                                    <th width="70px;" class="tabela_header">Dependente</th>
    <!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <td> 
                                        <select  name="dependente" id="dependente" class=" chosen-select" tabindex="1" required="" >
                                            <option value="">Selecione</option>
                                            <? foreach ($lista as $item) : ?>
                                                <option value="<?= $item->paciente_id; ?>"><?= $item->nome; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>

                                </tr>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="4">
                                    </th>
                                </tr>
                            </tfoot>
                        </table> 
                        <hr/>
                        <button type="submit" name="btnEnviar">Adicionar</button>
                    </fieldset>
                <? } ?> 
            </form>
            <fieldset>
                <? if (count($listacadastro) > 0) { ?>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="160px;" class="tabela_header">Cliente</th>
                                <th width="70px;" class="tabela_header">Dt. Nascimento</th>
                                <th width="70px;" class="tabela_header">Situacao</th>
                                <th width="30px;" class="tabela_header" colspan="2"></th>
                                <th width="30px;" class="tabela_header" colspan="1"  title="Quantidade de Impressões feitas">Qtd. de Impressões</th>
                                <th width="30px;" class="tabela_header" colspan="1" title="Data da última Impressão">Dt. impressão</th>

    <!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <? foreach ($listacadastro as $item) {
                            ?>
                            <?
                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao; ?></td>

                                    <? if ($perfil_id != 6 && $perfil_id != 5 || true) { ?>

                                        <? if ($item->situacao != 'Titular') { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                                    <a href="<?= base_url() ?>ambulatorio/guia/excluir/<?= $item->paciente_id ?>/<?= $contrato_id ?>">Excluir
                                                    </a></div>
                                            </td>
                                        <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                            </td>
                                        <? } ?>

                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>"></td>     

                                    <? } ?> 
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;" >
                                        
                                        <div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaocarteira/" . $item->paciente_id . "/" . $contrato_id."/".$item->paciente_contrato_dependente_id."/".$paciente_id ?> ', '_blank', 'width=1000,height=1000');">
                                                Carteira  
                                            </a>
                                        </div> 
                                        
                                    </td>

                                    <td class="<?php echo $estilo_linha; ?>" width="30px;" title="Quantidade de Impressões feitas"><div class=" ">
                                            <?= $item->contador_impressao; ?></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;" title="Data da última Impressão"><div class=" ">  
                                            <?
                                            if ($item->data_ultima_impressao == "") {
                                                
                                            } else {
                                                 ?>
                                           <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/listarimpressoescarteria/" . $item->paciente_contrato_dependente_id ?>', '_blank', 'width=1000,height=1000,scrollbars=1');"><b><?= $item->operador_ultima_impressao; ?></b>
                                                    <?= "&nbsp;"; ?>
                                                    <?= substr($item->data_ultima_impressao, 8, 2) . '/' . substr($item->data_ultima_impressao, 5, 2) . '/' . substr($item->data_ultima_impressao, 0, 4); ?>
                                           </a>
                                            
                                            <?
                                            }
                                            ?>  
                                        </div>
                                    </td>

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


            </fieldset>

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
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