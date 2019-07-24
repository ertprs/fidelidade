
<div class="content ficha_ceatox">

    <div >
        <?
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa');
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
        <?
        $empresa = $this->guia->listarempresa();
        ?>
        <h3 class="singular"><a href="#">Consulta Coparticipação</a></h3>
        <div>
            <div class="row clearfix" style="margin-bottom: 2rem;">
                <div class="col-sm-2">
                    <a class="btn btn-primary waves-effect"  href="<?= base_url() . "ambulatorio/guia/criarconsultacoop/$paciente_id/$contrato_id"; ?>">
                        Criar Consulta
                    </a>
                </div>
            </div>

            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravardependentes" method="post">
                <fieldset>
                    <div class="header">
                        <legend>Dados do Paciente</legend>
                    </div>

                    <div class="body">

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Nome</label>
                                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                                        <input type="hidden" id="txtcontrato_id" name="txtcontrato_id"  value="<?= $contrato_id; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
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
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Nascimento</label>


                                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">

                                            <label>Idade</label>
                                            <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Nome da M&atilde;e</label>


                                            <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </fieldset>

            </form>
            <fieldset>
                <? if (count($listarpagamentoscontrato) > 0) { ?>
                    <table id="table_justa" class="table table-responsive table-bordered">
                        <thead>

                        <tr>
                            <th width="70px;" class="tabela_header">Parcela</th>
                            <th width="70px;" class="tabela_header">Data</th>
                            <th width="70px;" class="tabela_header">Valor</th>
                            <th width="70px;" class="tabela_header">Situacao</th>
                            <th width="70px;" class="tabela_header">Observações</th>
                            <!--                                <th width="70px;" class="tabela_header">Taxa de Adesão</th>-->
                            <th width="70px;" colspan="6" class="tabela_header"></th>
                            <!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                        </tr>
                        </thead>
                        <?
                        $key = $empresa[0]->iugu_token;
                        Iugu::setApiKey($key);
                        $contador = 0;
                        foreach ($listarpagamentoscontrato as $item) {
                            $contador ++;
//                            if ($empresa[0]->iugu_token != '' && $item->ativo == 't' && $item->invoice_id != '') {
//                                $invoice_id = $item->invoice_id;
//
//                                $retorno = Iugu_Invoice::fetch($invoice_id);
//                                if ($retorno['status'] == 'paid') {
////                                    echo '<pre>';
////                                    var_dump($retorno);
////                                    die;
//                                    $this->guia->confirmarpagamentoconsultaavulsa($item->consultas_avulsas_id, $contrato_id);
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
                                <td class="<?php echo $estilo_linha; ?>"><?= $mes; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.') ?></td>

                                <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>">ABERTA</td>
                                    <td style="width: 130px" class="<?php echo $estilo_linha; ?>"><a class="btn btn-primary waves-effect" href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
                                    <? if ($perfil_id == 1) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <div class="bt_link">
                                                <a class="btn btn-primary waves-effect" href="<?= base_url() ?>ambulatorio/guia/confirmarpagamentoconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Confirmar
                                                </a>
                                            </div>
                                        </td>
                                    <? }
                                    if ($item->invoice_id == '' && $empresa[0]->iugu_token != '') { ?>
                                        <td colspan="1" class="<?php echo $estilo_linha; ?>" width="60px;"><div style="width: 160px;" class="bt_link">
                                                <a class="btn btn-primary waves-effect" id="botaopagamento<?= $contador ?>" href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiuguconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>/COOP">Gerar Pagamento Iugu
                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" colspan="1">
                                            <div style="width: 160px;" class="bt_link">
                                                <a class="btn btn-primary waves-effect" target="_blank" href="<?= $item->url ?>">Pagamento Iugu
                                                </a>
                                            </div>
                                        </td>                                                                                 </td>-->
                                    <? }
                                    if ($perfil_id == 1) { ?>
                                        <td class="<?php echo $estilo_linha; ?>">
                                            <div class="bt_link">
                                                <a class="btn btn-primary waves-effect" href="<?= base_url() ?>ambulatorio/guia/excluirconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Excluir
                                                </a>
                                            </div>
                                        </td>

                                    <? }
                                    ?>

                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">PAGA</td>

                                    <td  colspan="4" style="width: 130px" class="<?php echo $estilo_linha; ?>"><a class="btn btn-primary waves-effect" href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
                                    <!--                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiugu/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Gerar Pagamento Iugu
                                                </a></div>
                                        </td> -->
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


            </fieldset>

        </div>
    </div>
</div> <!-- Final da DIV content -->

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