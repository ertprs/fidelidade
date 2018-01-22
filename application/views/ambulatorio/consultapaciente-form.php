<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteconsultatemp/<?= $agenda_exames_id ?>/<?=$parceiro_ip?>" method="post">
        <fieldset>
            <legend>Marcar</legend>

            <div>
                <label>Nome</label>
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" required class="texto10"/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" class="texto02" alt="date"/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>

            </div>
            <div>
                <label>Telefone</label>


                <input type="text" id="telefone" class="texto02" name="telefone" alt="phone"/>
            </div>
            <div>
                <label>Celular</label>


                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone"/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio" id="convenio" class="size4">
                    <option  value="0">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
<!--                <select  name="procedimento" id="procedimento" class="size1" required >
                    <option value="">Selecione</option>
                </select>-->
                <select name="procedimento" id="procedimento" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1"  required="">
                    <option value="">Selecione</option>
                </select>

            </div>
            <div>
                <label>Observacoes</label>


                <input type="text" id="observacoes" class="texto10" name="observacoes" />
            </div>


            <div>
                <label>&nbsp;</label>
                <button id="botaoenviar" type="submit" name="btnEnviar">Enviar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    ?>
    <table id="table_agente_toxico" border="0">
        <thead>

            <tr>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Hora</th>
                <th class="tabela_header">Exame</th>
                <th class="tabela_header">Observa&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <?
        $estilo_linha = "tabela_content01";
        foreach ($consultas as $item) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            ?>
            <tbody>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                </tr>

            </tbody>
            <?
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 

</fieldset>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>

<script type="text/javascript">

    $(function () {
        $("#data_ficha").datepicker({
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
        $('#procedimento').change(function () {
            if ($(this).val() && $('#txtNomeid').val()) {
//                $('.carregando').show();
//alert('asd');
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconsultarcarencia', {procedimento: $(this).val(), paciente: $('#txtNomeid').val(), parceiro_id: <?=$parceiro_ip?>, ajax: true}, function (j) {

                      $('#botaoenviar').show();


                });
            } else {
//                $('#botaoenviar').hide();
//                $('#procedimento option').remove();
//                $('#procedimento').append('');
//                $("#procedimento").trigger("chosen:updated");
            }
        });
    });
    $(function () {
        $('#convenio').change(function () {
            if ($(this).val()) {
//                $('.carregando').show();
                $.getJSON('http://<?=$endereco_ip?>autocomplete/procedimentoconveniofidelidadeweb', {convenio1: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
//                                    $('#procedimento').html(options).show();
                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
//                    $("#procedimento").trigger("chosen:updated");
//                    $('.carregando').hide();
                });
            } else {
                $('#procedimento option').remove();
//                $('#procedimento').append('');
//                $("#procedimento").trigger("chosen:updated");
            }
        });
    });

    $(function () {
        $('#exame').change(function () {
            if ($(this).val()) {
                $('#horarios').hide();
                $('.carregando').show();
                $.getJSON('<?= $endereco_ip ?>autocomplete/horariosambulatorio', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '-' + j[i].medico_agenda + '</option>';
                    }
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });

    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });



    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
//        $('#botaoenviar').hide();
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>