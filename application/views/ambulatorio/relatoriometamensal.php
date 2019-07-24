<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatorio Meta Mensal</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriometamensal">
                <dl>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                  
                    <dt>
                        <label>M&ecirc;s</label>
                    </dt>
                    <dd>
                        <select name="mes" id="mes" class="size2" required="">
                             <option value="0">TODOS</option>
                            <option value="01">JANEIRO</option>
                            <option value="02">FEVEREIRO</option>
                            <option value="03">MARÇO</option>
                            <option value="04">ABRIL</option>
                            <option value="05">MAIO</option>
                            <option value="06">JUNHO</option>
                            <option value="07">JULHO</option>
                            <option value="08">AGOSTO</option>
                            <option value="09">SETEMBRO</option>
                            <option value="10">OUTUBRO</option>
                            <option value="11">NOVEMBRO</option>
                            <option value="12">DEZEMBRO</option>
                        </select>
                    </dd>
                  
                    
                       <dt>
                        <label>Ano</label>
                    </dt>
                    <dd>
                          <input type="number" name="ano" class="size1" id="ano" min=2000 required/>
                    </dd>
                    
                    
                    
                    
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->ambulatorio_grupo_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Gerar</label>
                    </dt>
                    <dd>
                        <select name="gerar" id="gerar" class="size2">
                            <option value="pdf">PDF</option>
                            <option value="xls">XLS</option>
                        </select>
                    </dd>
                    
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
</style>
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

</script>