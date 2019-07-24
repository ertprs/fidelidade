<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Contratos</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriocontratosinativos">
                <dl>

                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input required type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input required type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                    <dt>
                        <label>Plano</label>
                    </dt>
                    <dd> 
                        <select   name="plano[]" id="plano" class="size4 chosen-select "  multiple   data-placeholder="Selecione" >
                         <!--<option value="">Selecione</option>-->
                         <option value="0">Todos</option>
                            <?foreach ($planos as $key => $value) {?>
                                <option <?if(count($planos) == 1){echo 'selected';}?> value="<?=$value->forma_pagamento_id?>"><?=$value->nome?></option>
                           <? }?> 
                        </select>
                    </dd>
                    <br><br><br>
                     <dt>
                        <label>Vendedor</label>
                    </dt>
                    <dd> 
                        <select   name="vencedor[]" id="vencedor  " multiple class=" chosen-select"    data-placeholder="Selecione">
                           
                         <!--<option value="">Selecione</option>-->
                         <option value="0">Todos</option>
                            <?foreach ($vencedor as $key => $value) {?>
                                <option <?if(count($vencedor) == 1){echo 'selected';}?> value="<?=$value->operador_id?>"><?=$value->nome?></option>
                           <? }?>
                            
                        </select>
                    </dd> <br><br><br>
                    <dt>
                        <label>BUSCAR POR</label>
                    </dt>
                    <dd>
                        <select name="tipobusca" id="tipobusca" class="size2">
                            <option value="I">Inativos</option>
                            <option value="A">Ativos</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Data tipo</label>
                    </dt>
                    <dd>
                        <select name="tipodata" id="tipodata" class="size2">
                            <option value="C">Cadastro</option>
                            <option value="E">Excluido</option>
                        </select>
                    </dd>
                    
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>

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