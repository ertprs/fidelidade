<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Movimentação</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/caixa/gerarelatorioduplaAssinatura">
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresas as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Movimentação</label>
                    </dt>
                    <dd>
                        <select name="movimentacao" id="movimentacao" class="size2">
                           
                            <option value="">TODAS</option>
                            <option value="ENTRADA">ENTRADA</option>
                            <option value="SAIDA">SAIDA</option>
                            <option value="DESCONTO">DESCONTO</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Status</label>
                    </dt>
                    <dd>
                        <select name="status" id="status" class="size2">
                           
                            <option value="">TODOS</option>
                            <option value="CONFIRMADO">CONFIRMADO</option>
                            <option value="NÃO CONFIRMADO">NÃO CONFIRMADO</option>
                        </select>
                    </dd>
                    
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
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
        $('#empresa').change(function () {
//                                            if ($(this).val()) {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $(this).val(), ajax: true}, function (j) {
                options = '<option value="0">TODOS</option>';
//                options += '<option value="0">TODOS</option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].forma_entradas_saida_id + '">' + j[c].descricao + '</option>';
                }
                $('#conta').html(options).show();
                $('.carregando').hide();
            });
//                                            } else {
//                                                $('#nome_classe').html('<option value="">TODOS</option>');
//                                            }
        });
    });

    if ($('#empresa').val() > 0) {
//                                          $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $('#empresa').val(), ajax: true}, function (j) {
            options = '<option value="0">TODOS</option>';
            for (var c = 0; c < j.length; c++) {

                if ($('#conta').val() == j[c].forma_entradas_saida_id) {
                    options += '<option selected value="' + j[c].forma_entradas_saida_id + '">' + j[c].descricao + '</option>';
                } else {
                    options += '<option value="' + j[c].forma_entradas_saida_id + '">' + j[c].descricao + '</option>';
                }

            }
            $('#conta').html(options).show();
            $('.carregando').hide();
        });
    }



    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#tipo').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaida', {tipo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#classe').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe').html('<option value="">TODOS</option>');
            }
        });
    });

</script>