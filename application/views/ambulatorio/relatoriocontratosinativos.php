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
                        <label>Indicação</label>
                    </dt>
                    <dd> 
                        <select   name="indicacao[]" id="indicacao  " multiple class=" chosen-select"    data-placeholder="Selecione">                          
                         <!--<option value="">Selecione</option>-->
                         <option value="0">Todos</option>
                            <?foreach ($listarindicacao as $key => $value) {?>
                                <option <?if(count($listarindicacao) == 1){echo 'selected';}?> value="<?=$value->operador_id?>"><?=$value->nome?></option>
                           <? }?>
                        </select>
                    </dd><br><br><br>
                    
                    <dt>
                        <label>BUSCAR POR</label>
                    </dt>
                    <dd>
                        <select name="tipobusca" id="tipobusca" class="size2">
                            <option value="I">Inativos</option>
                            <option value="A">Ativos</option>
                        </select>
                    </dd>
                    <br>
                    <dt>
                        <label>BUSCAR POR PACIENTE</label>
                    </dt>
                    <dd>
                        <select name="tipopaciente" id="tipopaciente" class="size2">
                            <option value="titular">Titulares</option>
                            <option value="dependente">Dependentes</option>
                        </select>
                    </dd>

                    <dt id="paciente_titular_">
                        <label>TITULAR</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="paciente_titular_id" id="paciente_titular_id" class="size1" />
                        <input type="text" name="paciente_titular" id="paciente_titular" class="size3" />
                    </dd>


                    <dt id="paciente_dependente_">
                        <label>DEPENDENTE</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="paciente_dependente_id" id="paciente_dependente_id" class="size1" />
                        <input type="text" name="paciente_dependente" id="paciente_dependente" class="size3"/>
                    </dd>

                    <br>


                    <dt>
                        <label>Data tipo</label>
                    </dt>
                    <dd>
                        <select name="tipodata" id="tipodata" class="size2">
                            <option value="C">Cadastro</option>
                            <option value="E">Excluido</option>
                        </select>
                    </dd>
                       <dt>
                        <label>Forma de Pagamento</label>
                    </dt>
                    <dd>
                      <select name="forma_rendimento" id="forma_rendimento" class="size2">
                           <option value="">TODOS</option>
                            <?php 
                            foreach($forma as $value){
                                ?>                            
                            <option value="<?= $value->forma_rendimento_id ?>"><?= $value->nome ?></option>
                            <?                               
                            }
                            ?> 
                        </select>
                    </dd>
                    
                    </dd>
                       <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                      <select name="empresa_id" id="empresa_id" class="size2">
                           <option value="">TODOS</option>
                            <?php 
                            foreach($empresa as $value){
                                ?>                            
                               <option value="<?= $value->empresa_id ?>"><?= $value->nome ?></option>
                            <?                               
                            }
                            ?> 
                               <?php if(count($empresacadastro) > 0){?>
                          <optgroup label="Outras">
                            <?php foreach($empresacadastro as $item){?>
                                 <option value="E<?= $item->empresa_cadastro_id; ?>"><?= $item->nome; ?></option>
                            <?php }?>
                           </optgroup>
                               <?php }?>
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


    $('#tipopaciente').change(function () {
        trocartitular();
    });

    function trocartitular(){
        if($('#tipopaciente').val() == 'titular'){
            $('#paciente_titular').show();
            $('#paciente_titular_').show();
            $('#paciente_dependente').hide();
            $('#paciente_dependente_id').val('');
            $('#paciente_dependente').val('');
            $('#paciente_dependente_').hide();

        }else{
            $('#paciente_dependente').show();
            $('#paciente_dependente_').show();
            $('#paciente_titular_').hide();
            $('#paciente_titular_id').val('');
            $('#paciente_titular').val('');
            $('#paciente_titular').hide();

        }
    }

    trocartitular();



    $(function () {
        $("#paciente_titular").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientetitularrelatorio",
            minLength: 7, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#paciente_titular").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#paciente_titular").val(ui.item.value);
                $("#paciente_titular_id").val(ui.item.id);;
        
                return false;
            }
        });
    });

    $(function () {
        $("#paciente_dependente").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientedependenterelatorio",
            minLength: 7, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#paciente_dependente").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#paciente_dependente").val(ui.item.value);
                $("#paciente_dependente_id").val(ui.item.id);;
        
                return false;
            }
        });
    });

</script>