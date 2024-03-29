<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Saída</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" action="<?= site_url('/cadastros/caixa/gravarsaida') ?>" method="post">
                    <input type="hidden" id="saida_id" class="texto_id" name="saida_id" value="<?= @$obj->_saida_id; ?>" />
                    <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />

                    <div class="row clearfix">

                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="valor" alt="decimal" class="form-control valor-base" value="<?= @$obj->_valor; ?>"/>
                                    <label class="form-label">Valor</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="inicio" id="inicio" class="form-control nascimento" value="<?= substr(@$obj->_data, 8, 2) . "-" . substr(@$obj->_data, 5, 2) . "-" . substr(@$obj->_data, 0, 4); ?>"/>
                                    <label class="form-label">Data</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />
                                    <input type="text" id="devedorlabel" class="form-control autocomplete-credordevedor" name="devedorlabel" value="<?= @$obj->_razao_social; ?>" />
                                    <label class="form-label">Pagar a:</label>
                                    <ul id="lista_credordevedor" class="dropdown-content ac-dropdown"></ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="classe" id="classe" class="form-control show-tick" data-live-search="true">
                                    <option value="">Selecione uma classe...</option>
                                    <? foreach ($classe as $value) : ?>
                                        <option value="<?= $value->descricao; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="conta" id="conta" class="form-control show-tick" data-live-search="true">
                                    <option value="">Selecione uma forma...</option>
                                    <? foreach ($conta as $value) : ?>
                                        <option value="<?= $value->forma_entradas_saida_id; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-8 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea cols="70" rows="3" name="Observacao" id="Observacao" class="form-control"></textarea>
                                    <label class="form-label">Observação</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_salvar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_limpar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_voltar('/cadastros/caixa'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Saida</a></h3>
        <div>
            <form name="form_saida" id="form_saida" action="<?= base_url() ?>cadastros/caixa/gravarsaida" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor"  id="valor" alt="decimal" class="texto04" value="<?= @$obj->_valor; ?>"/>
                        <input type="hidden" id="saida_id" class="texto_id" name="saida_id" value="<?= @$obj->_saida_id; ?>" />
                    </dd>
                    <dt>
                        <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" value="<?= substr(@$obj->_data, 8, 2) . "-" . substr(@$obj->_data, 5, 2) . "-" . substr(@$obj->_data, 0, 4); ?>"/>
                    </dd>
                    <dt>
                        <label>Pagar a:</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />
                        <input type="text" id="devedorlabel" class="texto09" name="devedorlabel" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <!--                        <label>Tipo *</label>
                                            </dt>
                                            <dd>
                                                <select name="tipo" id="tipo" class="size4">
                                                    <option value="">Selecione</option>
                        <? foreach ($tipo as $value) : ?>
                                                            <option value="<?= $value->descricao; ?>" <?
                            if (@$obj->_tipo == $value->descricao):echo'selected';
                            endif;
                            ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                                                </select>-->
                        </dd>
                    <dt>
                        <label>Classe *</label>
                    </dt>
                    <dd>
                        <select name="classe" id="classe" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($classe as $value) : ?>
                                <option value="<?= $value->descricao; ?>"><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Forma *</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"<?
                                        if (@$obj->_forma == $value->forma_entradas_saida_id):echo'selected';
                                        endif;
                                        ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao"><?= @$obj->_observacao; ?></textarea><br/>
                    </dd>
                </dl>

                <hr/>
                <button type="submit" name="btnEnviar">enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<!--
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script type="text/javascript">

//    $(function () {
//        $('#tipo').change(function () {
//            if ($(this).val()) {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaida', {tipo: $(this).val(), ajax: true}, function (j) {
//                    options = '<option value=""></option>';
//                    for (var c = 0; c < j.length; c++) {
//                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
//                    }
//                    $('#classe').html(options).show();
//                    $('.carregando').hide();
//                });
//            } else {
//                $('#classe').html('<option value="">Selecione</option>');
//            }
//        });
//    });

    $(function () {
        $("#devedorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=credordevedor",
            minLength: 1,
            focus: function (event, ui) {
                $("#devedorlabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#devedorlabel").val(ui.item.value);
                $("#devedor").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).ready(function () {
        jQuery('#form_saida').validate({
            rules: {
                valor: {
                    required: true
                },
                devedor: {
                    required: true
                },
                classe: {
                    required: true
                },
                conta: {
                    required: true
                },
                inicio: {
                    required: true
                }
            },
            messages: {
                valor: {
                    required: "*"
                },
                devedor: {
                    required: "*"
                },
                classe: {
                    required: "*"
                },
                conta: {
                    required: "*"
                },
                inicio: {
                    required: "*"
                }
            }
        });
    });


</script>
