<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio comissão</a></h3>
        <div>
            <form name="relatorio" id="relatorio" method="post"  action="<?= base_url() ?>ambulatorio/guia/gerarelatoriocomissao">
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date" required="true"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date" required="true"/>
                    </dd>
                    <dt>
                        <label>Tipo de Pesquisa</label>
                    </dt>
                    <dd>
                        <select name="tipoPesquisa" id="tipoPesquisa" class="size2">
                            <option value="VENDEDORES">VENDEDOR</option>
                            <option value="GERENTE">GERENTE DE VENDAS</option>
                         
                        </select>
                    </dd>

                        <div id="Divgerentedevendas">
                    <dt>
                        <label>Gerente de Vendas</label>
                    </dt>
                    <dd>
                        <select name="gerentedevendas" id="gerentedevendas" class="size2">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($listargerentedevendas as $item) {
                                ?>
                                <option   value =<?php echo $item->operador_id; ?>><?php echo $item->nome; ?></option>
                                <?php
                            }
                            ?> 
                        </select>

                    </dd>
                    <dt>
                            </div>

                            <div id="Divvendedor">

                    <dt>
                        <label>Vendedor</label>
                    </dt>
                    <dd>
                        <select name="vendedor[]" id="vendedor" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                            <option value=""></option>
                            <?php
                            foreach ($listarvendedor as $item) {
                                ?>
                                <option   value =<?php echo $item->operador_id; ?>><?php echo $item->nome; ?></option>
                                <?php
                            }
                            ?> 
                        </select>

                    </dd>
                    <dt>

                            </div>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<!-- <link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css"> -->
<script type="text/javascript">

$(function () {
        $("#accordion").accordion();
    });

    $('#tipoPesquisa').change(function () {
        trocarAnoMes();
    });

    function trocarAnoMes(){
        if($('#tipoPesquisa').val() == 'VENDEDORES'){
            $('#Divgerentedevendas').hide();
            $('#Divvendedor').show();
            $("#vendedor").prop('required', true);
            $("#gerentedevendas").prop('required', false);
        }else{
            $('#Divgerentedevendas').show();
            $('#Divvendedor').hide();
            $("#vendedor").prop('required', false);
            $("#gerentedevendas").prop('required', true);
        }
    }


    trocarAnoMes();


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




</script>