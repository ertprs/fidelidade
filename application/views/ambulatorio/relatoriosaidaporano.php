<div class="content"> <!-- Inicio da DIV content -->
    <? $empresas = $this->exame->listarempresas(); ?>
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; Gerar Relatório Saída por ano</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/caixa/gerarelatoriosaidaporano">
                <dl>
                    
                    <dt>
                        <label>Ano Inicial</label>
                    </dt>
                    <dd>
                        
                        <input type="number" name="ano_inicial" class="size1" id="ano_inicial" min=2000 required/>
                    </dd>
                    <dt>
                        <label>Ano Final</label>
                    </dt>
                    <dd>
                        
                        <input type="number" name="ano_final" class="size1" id="ano_final" min=2000 required/>
                    </dd>
                    <dt>
                        <label>Conta</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>" ><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size2">
                            <option value= 0 >TODOS</option>
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->tipo_entradas_saida_id; ?>" ><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Classe</label>
                    </dt>
                    <dd>
                        <select name="classe" id="classe" class="size2">
                            <option value="">TODOS</option>                           
                        </select>
                    </dd>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresas as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="">TODOS</option>
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
        $("#accordion").accordion();
    });

    $('#tipoPesquisa').change(function () {
        trocarAnoMes();
    });

    function trocarAnoMes(){
        if($('#tipoPesquisa').val() == 'MENSAL'){
            $('#ano').hide();
            $('#mes').show();
            $("#ano").prop('required', false);
        }else{
            $('#ano').show();
            $('#mes').hide();
            $("#ano").prop('required', true);
        }
    }

    trocarAnoMes();



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