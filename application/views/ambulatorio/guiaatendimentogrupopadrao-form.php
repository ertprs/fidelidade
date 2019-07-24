
<?
$recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio');
$empresa = $this->guia->listarempresapermissoes();
$odontologia_alterar = $empresa[0]->odontologia_valor_alterar;
$retorno_alterar = $empresa[0]->selecionar_retorno;
$desabilitar_trava_retorno = $empresa[0]->desabilitar_trava_retorno;

?>
<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
        width: 50px;
    }
    .custom-combobox a {
        display: inline-block;        
    }
</style>
<script>
    $(function () {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";

                var wasOpen = false;

                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
<? if ($recomendacao_obrigatorio == 't') { ?>
                    .attr("required", "")
<? } ?>
                .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left text-input-recomendacao")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;

                input.on("click", function () {
                    input.trigger("focus");

                    // Close if already visible
                    if (wasOpen) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },

            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                        .val("")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });

        $("#indicacao").combobox();
//        $("#medico1").combobox();
    });
</script>
<div class="content ficha_ceatox">
    <div class="bt_link_new" style="width: 150pt">
        <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico Solicitante
        </a>
    </div>
    <div class="bt_link_new">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Cadastros
        </a>
    </div>
    <div >
        <?
        $perfil_id = $this->session->userdata('perfil_id');

        $botao_faturar_guia = $this->session->userdata('botao_faturar_guia');
        $botao_faturar_proc = $this->session->userdata('botao_faturar_proc');
        $recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio');
        $empresa_id = $this->session->userdata('empresa_id');
        $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);

        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $promotor_id = @$exames[count($exames) - 1]->indicacao;
        $medico_solicitante = @$exames[count($exames) - 1]->medico_solicitante;
        $medico_solicitante_id = @$exames[count($exames) - 1]->medico_solicitante_id;
        $convenio_paciente = "";
        // if ($contador > 0) {

//            $medico_solicitante = $exames[0]->medico_solicitante;
//            $medico_solicitante_id = $exames[0]->medico_solicitante_id;
        $convenio_paciente = $empresapermissoes[0]->convenio_padrao_id;
        // var_dump($convenio_paciente); die;
        // $ordenador1 = 1;
        // }

      
        ?>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentogrupopadrao" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="guia_id" name="guia_id"  value="<?= $ambulatorio_guia_id; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <input name="sexo" id="txtSexo" class="size2" 
                               value="<?
                               if ($paciente['0']->sexo == "M"):echo 'Masculino';
                               endif;
                               if ($paciente['0']->sexo == "F"):echo 'Feminino';
                               endif;
                               if ($paciente['0']->sexo == "O"):echo 'Outro';
                               endif;
                               ?>" readonly="true">
                    </div>

                    <div>
                        <label>Nascimento</label>


                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                    </div>

                    <div>
                        <label>Idade</label>
                        <?
                        if ($paciente['0']->nascimento != '') {
                            $data_atual = date('Y-m-d');
                            $data1 = new DateTime($data_atual);
                            $data2 = new DateTime($paciente[0]->nascimento);

                            $intervalo = $data1->diff($data2);
                            ?>
                            <input type="text" name="idade" id="idade" class="texto02" readonly value="<?= $intervalo->y ?> ano(s)"/>
                        <? } else { ?>
                            <input type="text" name="nascimento" id="txtNascimento" class="texto01" readonly/>
                        <? } ?>
                    </div>

                    <div>
                        <label>Nome da M&atilde;e</label>


                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto09" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                    <?
                    $endereco_toten = $this->session->userdata('endereco_toten');
                    if($endereco_toten != ''){?>
                        <div>
                            <label>Senha Toten</label>


                            <input type="text" name="toten_fila_id" id="toten_fila_id" class="texto02" value="<?= $paciente['0']->toten_fila_id; ?>" required/>
                        </div>
                   <? }
                    ?>
                    
                </fieldset>
                <?
                
              
                ?>
               
                <fieldset>
                    <table id="table_justa">
                        <thead>

                            <tr>



                                <th class="tabela_header" style="display:none">Convenio*</th>
                                <th class="tabela_header">Grupo</th>
                                <th class="tabela_header">Procedimento Padrão</th>
                                <th class="tabela_header">Sessões</th>
                                <th width="70px;" class="tabela_header">Sala*</th>
                                <th class="tabela_header">Medico*</th>
                                <th colspan="" class="tabela_header">Solicitante</th>
                                <th class="tabela_header">Promotor</th>
                                <th class="tabela_header">Pagamento</th>
                                <th id="valorth" class="tabela_header">Valor</th>
                                <th class="tabela_header" id="vAjuste" style="display: none;"><span >V.Ajuste</span></th>
                                <th class="tabela_header">Autorizacão</th>
                                <th class="tabela_header">Entrega</th>
                                <th class="tabela_header">Ordenador</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  width="50px;" style="display:none">
                                    <select name="convenio1" id="convenio1" class="size1" required="">
                                        <option value="">Selecione</option>
                                        <?
                                        foreach ($convenio as $item) :
                                            $lastConv = $empresapermissoes[0]->convenio_padrao_id;
                                            if($empresapermissoes[0]->convenio_paciente == 't' && $paciente[0]->convenio_id != $item->convenio_id && $item->dinheiro == 'f'){
                                                continue;
                                            }
                                            ?>
                                            <option value="<?= $item->convenio_id; ?>" <? if ($lastConv == $item->convenio_id) echo 'selected'; ?>>
                                                <?= $item->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                
                                <td  >
                                    <select required  name="grupo1" id="grupo1" class="size1" >
                                        <option value="">Selecione</option>
                                        <?
                                        $lastGrupo = $exames[count($exames) - 1]->grupo;
                                        foreach ($grupos as $item) :
                                            ?>
                                            <option value="<?= $item->nome; ?>" <? if ($lastGrupo == $item->nome) echo 'selected'; ?>>
                                                <?= $item->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                
                                <td>
                                    <select required name="procedimento1" id="procedimento1" class="size2" data-placeholder="Selecione" tabindex="1">
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                <input type="hidden" name="qtde1" id="qtde1" value="1" class="texto00" required=""/>
                                <td  ><input type="text" name="qtde" id="qtde" class="texto01" readonly=""/></td>
                                <td > 
                                    <select  name="sala1" id="sala1" class="size1" required="" >
                                        <option value="">Selecione</option>
                                        <? foreach ($salas as $item) : ?>
                                            <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                    </select></td>
                                <td > 
                               
                                    <select  name="medicoagenda" id="exame" class="size1"  required="">
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $item) : ?>
                                            <option value="<?= $item->operador_id; ?>"<?
                                            $lastMed = 0;
                                            if ($lastMed == $item->operador_id):echo 'selected';
                                            endif;
                                            ?>><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                    </select></td>
                                   
                                <td >
                                    <input type="text" name="medico1" id="medico1" value="<?= $medico_solicitante; ?>" class="size2"/>
                                    <input type="hidden" name="crm1" id="crm1" value="<?= $medico_solicitante_id; ?>" class="texto01"/>
                                </td>

 
                                <td >
                                    <select name="indicacao" id="indicacao" class="size1 ui-widget" <?= ($recomendacao_obrigatorio == 't') ? 'required' : ''; ?>>
                                        <option value='' >Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacaoranqueada($_GET);
                                       
                                        foreach ($indicacao as $item) {
                                            // Não dê enter na hora de mostrar o valor no option, se não ele não vai mostrar o texto do jeito errado 
                                            ?>
                                            <option value="<?= $item->paciente_indicacao_id; ?>" <?= ($item->paciente_indicacao_id == $promotor_id) ? 'selected' : '' ?>><?php echo $item->nome . ( ($item->registro != '' ) ? " - " . $item->registro : '' ); ?></option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                <?
                                    // var_dump($retorno_alterar); die;
                                ?>
                                <td >
                                    <select  name="formapamento" id="formapamento" class="size1" onchange="buscaValorAjustePagamentoProcedimento()">
                                        <option value="">Selecione</option>
                                        <?
                                        foreach ($forma_pagamento as $item) :
                                            if ($item->forma_pagamento_id == 1000)
                                                continue;
                                            ?>
                                            <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td id="valortd">
                                    <input type="text" name="valor1" id="valor1" class="texto01" readonly=""/>
                                    <input type="hidden" name="valorunitario" id="valorunitario" class="texto01" readonly=""/>
                                </td>
                                <td id="vAjusteIn" style="display: none;"  >
                                    <input type="text" name="valorAjuste" id="valorAjuste" class="texto01" readonly=""/>
                                </td>

                                <td ><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                                <td ><input type="text" id="data" name="data" class="size1"/></td>
                                <td >
                                    <select name="ordenador" id="ordenador" class="size1" >
                                        <option value='1' >Normal</option>
                                        <option value='2' >Prioridade</option>
                                        <option value='3' >Urgência</option>

                                    </select>
                                </td>
<!--                                <td  width="70px;"><input type="text" name="observacao" id="observacao" class="texto04"/></td>-->
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
                    <button type="submit" name="btnEnviar" id="submitButton">
                        Adicionar
                    </button>
                   
                </fieldset>
            </form>
            

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 400px; }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>

<script type="text/javascript">
                                        // Fazendo com que ao clicar no botão de submit, este passe a ficar desabilitado
                                        var formID = document.getElementById("form_guia");
                                        var send = $("#submitButton");
                                        $(formID).submit(function (event) {
                                            if (formID.checkValidity()) {
                                                send.attr('disabled', 'disabled');
                                            }
                                        });
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


//                                         $(function () {
//                                             $('#grupo1').change(function () {
//                                                 if ($('#grupo1').val()) {
//                                                     if ($('#convenio1').val()) {
//                                                         $('.carregando').show();
//                                                         $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupomedico', {grupo1: $(this).val(), convenio1: $('#convenio1').val(), teste: $('#exame').val()}, function (j) {
//                                                             options = '<option value=""></option>';
//                                                             for (var c = 0; c < j.length; c++) {
//                                                                 options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
//                                                             }
//                                                             //                                                $('#procedimento1').html(options).show();
//                                                             $('#procedimento1 option').remove();
//                                                             $('#procedimento1').append(options);
//                                                             $("#procedimento1").trigger("chosen:updated");
//                                                             $('.carregando').hide();
//                                                         });
//                                                     }
//                                                 } else {
//                                                     $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedicocadastrosala', {convenio1: $('#convenio1').val(), sala: $('#sala1').val(), teste: $('#exame').val(), ajax: true}, function (j) {
//                                                         options = '<option value=""></option>';
//                                                         for (var c = 0; c < j.length; c++) {
//                                                             options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
//                                                         }
// //                                                $('#procedimento1').html(options).show();
//                                                         $('#procedimento1 option').remove();
//                                                         $('#procedimento1').append(options);
//                                                         $("#procedimento1").trigger("chosen:updated");
//                                                         $('.carregando').hide();
//                                                     });
//                                                 }
//                                             });
//                                         });

                                        $(function () {
                                            $("#medico1").autocomplete({
                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicosranqueado",
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

                                        if ($('#grupo1').val()) {

                                            $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: $('#grupo1').val(), ajax: true}, function (j) {
                                                options = '<option value=""></option>';
//                                                                    console.log(j);
                                                for (var c = 0; c < j.length; c++) {
                                                    if (j.length == 1) {
                                                        options += '<option value="' + j[c].exame_sala_id + '" selected>' + j[c].nome + '</option>';
                                                    } else {
                                                        options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                                                    }
                                                }
                                                $('#sala1').html(options).show();
                                                $('.carregando').hide();
                                            });
                                        }
                                        function procedimentoSelected(procedimento_id) {
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: procedimento_id, ajax: true}, function (j) {
                                                options = "";
                                                options += j[0].valortotal;
                                                qtde = "";
                                                qtde += j[0].qtde;
<? if ($odontologia_alterar == 't') { ?>
                                                    if (j[0].grupo == 'ODONTOLOGIA') {
                                                        $("#valor1").prop('readonly', false);
                                                    } else {
                                                        $("#valor1").prop('readonly', true);
                                                    }
<? } ?>
                                                if (j[0].tipo == 'EXAME' || j[0].tipo == 'ESPECIALIDADE' || j[0].tipo == 'FISIOTERAPIA') {
                                                    $("#medico1").prop('required', true);
                                                } else {
                                                    $("#medico1").prop('required', false);
                                                }
                                                $('#grupo1').find('option:contains("' + j[0].grupo + '")').prop('selected', true);

                                                $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: j[0].grupo, ajax: true}, function (i) {
                                                    options = '<option value=""></option>';
                                                    for (var c = 0; c < i.length; c++) {
                                                        if (j.length == 1) {
                                                            options += '<option value="' + i[c].exame_sala_id + '" selected>' + i[c].nome + '</option>';
                                                        } else {
                                                            options += '<option value="' + i[c].exame_sala_id + '">' + i[c].nome + '</option>';
                                                        }
                                                    }
                                                    $('#sala1').html(options).show();
                                                    $('.carregando').hide();
                                                });


                                                document.getElementById("valorunitario").value = options;
                                                var valorTotal = options * (($('#qtde1').val()) ? $('#qtde1').val() : 1);
                                                document.getElementById("valor1").value = valorTotal;
                                                document.getElementById("qtde").value = qtde;
                                                $('.carregando').hide();
                                            });

                                            var procedimento = procedimento_id;
                                            $("#formapamento").prop('required', false);

                                            $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: procedimento_id, ajax: true}, function (j) {

                                                $("#vAjuste").css('display', 'none');
                                                $("#vAjusteIn").css('display', 'none');

                                                verificaAjustePagamentoProcedimento(procedimento);
                                                var options = '<option value="">Selecione</option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    if (j[c].forma_pagamento_id != null) {
                                                        options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                    }
                                                }
                                                $('#formapamento').html(options).show();
                                                $('.carregando').hide();

                                            });
                                        }

<? if ($empresapermissoes[0]->valor_autorizar == 'f') { ?>
                                            $(function () {
                                                $('#convenio1').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/conveniocarteira', {convenio1: $(this).val()}, function (j) {
                                                            options = '<option value=""></option>';
                                                            if (j[0].dinheiro == 't') {
                                                                //                                                                            $("#valorth").show();
                                                                //                                                                            $("#valortd").show();
                                                                $("#valor1").attr("type", "text");
                                                            } else {
                                                                $("#valor1").attr("type", "hidden");
                                                                //                                                                            $("#valorth").hide();
                                                                //                                                                            $("#valortd").hide();
                                                            }
                                                            if (j[0].carteira_obrigatoria == 't') {
                                                                $("#autorizacao").prop('required', true);
                                                            } else {
                                                                $("#autorizacao").prop('required', false);
                                                            }

                                                        });
                                                    }
                                                });
                                            });


                                           
<? } ?>

                                        $(function () {
                                            $('#convenio1').change(function () {

                                                if ($(this).val()) {
                                                    $('.carregando').show();

//                                        alert($("#grupo1").val());
//                                        alert($('#convenio1').val());
//                                            if ($("#grupo1").val()) {
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioatendimentonovo', {grupo1: $("#grupo1").val(), convenio1: $('#convenio1').val()}, function (j) {
//                                                alert('asdasd');
                                                        options = '<option value=""></option>';

                                                        for (var c = 0; c < j.length; c++) {
                                                            options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                        }
//                                                    $('#procedimento1').html(options).show();
                                                        $('#procedimento1 option').remove();
                                                        $('#procedimento1').append(options);
                                                        $("#procedimento1").trigger("chosen:updated");
                                                        $('.carregando').hide();
                                                    });
//                                            }

                                                } else {
                                                    $('#procedimento1').html('<option value="">Selecione</option>');
                                                }
                                            });
                                        });

                                        $('#grupo1').change(function () {
                                            if ($('#convenio1').val()) {
                                                if ($(this).val()) {
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupopadrao', {grupo1: $(this).val(), convenio1: $('#convenio1').val(), teste: $('#medico_id1').val(), ajax: true}, function (j) {
                                                        options = '<option value=""></option>';
                                                        if(j.length == 0){
                                                            options = '<option value="">Sem Procedimento Padrão Associado</option>';
                                                        }
                                                        for (var c = 0; c < j.length; c++) {
                                                            if (j.length == 1) {
                                                                options += '<option value="' + j[c].procedimento_convenio_id + '" selected>' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                                procedimentoSelected(j[c].procedimento_convenio_id);
                                                            } else {
                                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                            }
                                                        }
                                                        $('#procedimento1').html(options).show();
                                                        $('.carregando').hide();
                                                    });

                                                    $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: $(this).val(), ajax: true}, function (j) {
                                                        var options = '<option value=""></option>';
                                                        for (var c = 0; c < j.length; c++) {
                                                            if (j.length == 1) {
                                                                options += '<option value="' + j[c].exame_sala_id + '" selected>' + j[c].nome + '</option>';
                                                            } else {
                                                                options += '<option value="' + j[c].exame_sala_id + '">' + j[c].nome + '</option>';
                                                            }
                                                        }
                                                        $('#sala1').html(options).show();
                                                        $('.carregando').hide();
                                                    });
                                                }
                                            }
                                        });

                                        $(function () {
                                            $('#procedimento1').change(function () {
//                                        alert('asdads');
                                                if ($(this).val()) {
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        options += j[0].valortotal;
                                                        qtde = "";
                                                        qtde += j[0].qtde;
<? if ($odontologia_alterar == 't') { ?>
                                                            if (j[0].grupo == 'ODONTOLOGIA') {
                                                                $("#valor1").prop('readonly', false);
                                                            } else {
                                                                $("#valor1").prop('readonly', true);
                                                            }
<? } ?>
                                                        if (j[0].tipo == 'EXAME' || j[0].tipo == 'ESPECIALIDADE' || j[0].tipo == 'FISIOTERAPIA') {
                                                            $("#medico1").prop('required', true);
                                                        } else {
                                                            $("#medico1").prop('required', false);
                                                        }
                                                        $("#grupo1").val(j[0].grupo);
//                                                      $('#grupo1').find('option:contains("' + j[0].grupo + '")').prop('selected', true);

                                                        $.getJSON('<?= base_url() ?>autocomplete/listarsalaporgrupo', {grupo1: j[0].grupo, ajax: true}, function (i) {
                                                            options = '<option value=""></option>';
                                                            for (var c = 0; c < i.length; c++) {
                                                                if (j.length == 1) {
                                                                    options += '<option value="' + i[c].exame_sala_id + '" selected>' + i[c].nome + '</option>';
                                                                } else {
                                                                    options += '<option value="' + i[c].exame_sala_id + '">' + i[c].nome + '</option>';
                                                                }
                                                            }
                                                            $('#sala1').html(options).show();
                                                            $('.carregando').hide();
                                                        });


                                                        document.getElementById("valorunitario").value = options;
                                                        var valorTotal = options * (($('#qtde1').val()) ? $('#qtde1').val() : 1);
                                                        document.getElementById("valor1").value = valorTotal;
                                                        document.getElementById("qtde").value = qtde;
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
                                                    $("#submitButton").attr('disabled', 'disabled');
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        options += j[0].valortotal;
                                                        document.getElementById("valorunitario").value = options;
                                                        var valorTotal = options * (($('#qtde1').val()) ? $('#qtde1').val() : 1);
                                                        document.getElementById("valor1").value = valorTotal;
                                                        $("#submitButton").removeAttr('disabled');
                                                        $('.carregando').hide();
                                                    });

<? if ($desabilitar_trava_retorno == 'f') { ?>
                                                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
                                                            if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                                                                alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                                                $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
                                                            } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                                                                alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                                                                $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val(''));
                                                            }
                                                        });

                                                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

                                                            //                                                        console.log(r);

                                                            if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
                                                                //                                                            alert('asdasd'); 
                                                                //                                                            alert("Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                                                //                                                            alert(r.procedimento_retorno);
                                                                if ('<?= $retorno_alterar ?>' == 'f') {
                                                                    if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
                                                                        //                                                                alert('asdas');
                                                                        $("#procedimento1").val(r.procedimento_retorno);
                                                                        //                                                            $('#valor1').val('0.00');
                                                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                                                            options = "";
                                                                            options += j[0].valortotal;
                                                                            document.getElementById("valorunitario").value = options;
                                                                            var valorTotal = options * (($('#qtde1').val()) ? $('#qtde1').val() : 1);
                                                                            document.getElementById("valor1").value = valorTotal;
                                                                            $('.carregando').hide();
                                                                        });
                                                                    }
                                                                } else {
                                                                    alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                                                    $("#procedimento1").val(r.procedimento_retorno);
                                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                                                        options = "";
                                                                        options += j[0].valortotal;
                                                                        document.getElementById("valorunitario").value = options;
                                                                        var valorTotal = options * (($('#qtde1').val()) ? $('#qtde1').val() : 1);
                                                                        document.getElementById("valor1").value = valorTotal;
                                                                        $('.carregando').hide();
                                                                    });
                                                                }


                                                            }
                                                        });
<? } ?>
                                                } else {
                                                    $('#valor1').html('value=""');
                                                }
                                            });
                                        });

                                        $(function () {
                                            $('#qtde1').change(function () {
                                                if ($(this).val()) {
                                                    var valor = $(this).val() * document.getElementById("valorunitario").value;
                                                    if (typeof (valor) == 'number') {
                                                        document.getElementById("valor1").value = valor;
                                                    }
                                                } else {
                                                    $(this).val(1);
                                                }
                                            });
                                        });

                                        $(function () {
                                            $('#procedimento1').change(function () {
                                                if ($(this).val()) {
                                                    $('.carregando').show();

                                                    var procedimento = $(this).val();
                                                    $("#formapamento").prop('required', false);

                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {

                                                        $("#vAjuste").css('display', 'none');
                                                        $("#vAjusteIn").css('display', 'none');

                                                        verificaAjustePagamentoProcedimento(procedimento);
                                                        var options = '<option value="">Selecione</option>';
                                                        for (var c = 0; c < j.length; c++) {
                                                            if (j[c].forma_pagamento_id != null) {
                                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                            }
                                                        }
                                                        $('#formapamento').html(options).show();
                                                        $('.carregando').hide();

                                                    });
                                                    $.getJSON('<?= base_url() ?>autocomplete/listarmedicoprocedimentoconvenio', {procedimento: $(this).val(), ajax: true}, function (m) {
                                                        options = '<option value=""></option>';
                                                        //                            console.log(j);
                                                        for (var y = 0; y < m.length; y++) {
                                                            //                                if(m[y].operador_id == medico_agenda[]){
                                                            //                                  options += '<option selected="" value="' + m[y].operador_id + '">' + m[y].nome + '</option>';  
                                                            //                                }else{
                                                            options += '<option value="' + m[y].operador_id + '">' + m[y].nome + '</option>';
                                                            //                                }
                                                        }
                                                        $('#exame').html(options).show();

                                                        $('.carregando').hide();

                                                    });


<? if ($desabilitar_trava_retorno == 'f') { ?>
                                                        $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
                                                            //                                                console.log(r);
                                                            if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                                                                alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                                                $("select[name=procedimento1]").val($("select[name=procedimento1] option:first-child").val());
                                                            }
                                                        });
<? } ?>
                                                } else {
                                                    $('#formapamento').html('<option value="0">Selecione</option>');
                                                }
                                            });
                                        });

//                                function calculoIdade() {
//                                    var data = document.getElementById("txtNascimento").value;
//                                    var ano = data.substring(6, 12);
//                                    var idade = new Date().getFullYear() - ano;
//                                    document.getElementById("txtIdade").value = idade;
//                                }
                                        function calculoIdade() {
                                            var data = document.getElementById("txtNascimento").value;

                                            if (data != '' && data != '//') {

                                                var ano = data.substring(6, 12);
                                                var idade = new Date().getFullYear() - ano;

                                                var dtAtual = new Date();
                                                var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

                                                if (dtAtual < aniversario) {
                                                    idade--;
                                                }

                                                document.getElementById("txtIdade").value = idade + " ano(s)";
                                            }
                                        }
                                        calculoIdade();

                                        function verificaAjustePagamentoProcedimento(procedimentoConvenioId) {
<? if (@$empresapermissoes[0]->ajuste_pagamento_procedimento == 't') { ?>
                                                $.getJSON('<?= base_url() ?>autocomplete/verificaAjustePagamentoProcedimento', {procedimento: procedimentoConvenioId, ajax: true}, function (p) {
                                                    if (p.length != 0) {
                                                        $("#formapamento").prop('required', true);
                                                        $("#vAjuste").css('display', 'block');
                                                        $("#vAjusteIn").css('display', 'block');
                                                        //                                                console.log($('#formapamento'));
                                                    }
                                                });
<? } ?>
                                        }

                                        function buscaValorAjustePagamentoProcedimento() {
                                            $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoProcedimento', {procedimento: $('#procedimento1').val(), forma: $('#formapamento').val(), ajax: true}, function (p) {
                                                if (p.length != 0) {
                                                    $("#valorAjuste").val(p[0].ajuste);
                                                } else {
                                                    $("#valorAjuste").val('');
                                                }
                                            });
                                        }

</script>
