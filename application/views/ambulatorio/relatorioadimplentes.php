<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Adimplentes</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatorioadimplentes">
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
                    <div id="bairrodiv">
                        <dt>
                            <label>Bairro </label>
                        </dt>
                        <dd>
                            <select name="bairro" id="bairro" class="size2" tabindex="1">
                                <option value='' >TODOS</option>
                                <? foreach ($bairros as $value) : ?>
                                    <option value="<?= $value->bairro; ?>"><?= $value->bairro; ?></option>
                                <? endforeach; ?>
                            </select>
                        </dd>
                    </div>
                    <div id="bairrodiv">
                        <dt>
                            <label>Forma de Pagamento</label>
                        </dt>
                        <dd>
                            <select name="forma_pagamento" id="forma_pagamento" class="size2" tabindex="1">
                                <option value='' >TODOS</option>

                                <option value='manual' >Manual</option>
                                <option value='cartao' >Cartão</option>
                                <option value='debito' >Débito</option>
                                <option value='boleto' >Boleto</option>
                                <option value='boleto_emp' >Boleto Empresa</option>


                            </select>
                        </dd>
                    </div>
                <div id="bairrodiv">
                        <dt>
                            <label>Ordenar Por</label>
                        </dt>
                        <dd>
                            <select name="ordenar" id="bairro" class="size2" tabindex="1">
                                <option value='order_nome' >Nome</option>
                                <option value='order_bairro' >Bairro</option> 
                            </select>
                        </dd>
                    </div>
                 <div id="bairrodiv">
                        <dt>
                            <label>Gerar </label>
                        </dt>
                        <dd>
                            <select name="gerar" id="gerar" class="size2" tabindex="1">
                                <option value='' >Selecione</option>
                                <option value='pdf' >PDF</option>
                                <option value='planilha' >PLANILHA</option> 
                            </select>
                        </dd>
                    </div>
                    
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