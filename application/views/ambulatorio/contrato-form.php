 

<?
//echo '<pre>';
//print_r($contrato);die;
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; Alterar Contrato</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/atualizarnumerocontrato/<?= $contrato[0]->paciente_id ?>/<?= $contrato[0]->paciente_contrato_id ?>">
                <!--                <dl>  
                                    <dt>
                                        <label>Novo Número</label>
                                    </dt> 
                                    <dd>
                                        <input type="number"  min="1" pattern="^[0-9]+" name="novo_numero" id="novo_numero"  value="<?= $contrato[0]->paciente_contrato_id ?>"/>
                                    </dd> 
                                </dl>-->
                <dl>  
                    <dt>
                        <label>Nova data</label>
                    </dt> 
                    <dd>
                        <input type="text" name="data_contrato" id="data_contrato"   class="texto02" alt="data_contrato" value="<?php echo substr(@$contrato[0]->data_cadastro, 8, 2) . '/' . substr(@$contrato[0]->data_cadastro, 5, 2) . '/' . substr(@$contrato[0]->data_cadastro, 0, 4); ?>"  required="" />
                    </dd> 
                </dl> 
 
                <hr> 
                <button type="submit" >Enviar</button>
                <a href="<?= base_url() ?>ambulatorio/guia/listardependentes/<?= $contrato[0]->paciente_id ?>/<?= $contrato[0]->paciente_contrato_id ?>">
                    <button type="button" id="btnVoltar">Voltar</button>
                </a>
            </form>  
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#data_contrato").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

<?php if ($this->session->flashdata('message') != ''): ?>
        alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>

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