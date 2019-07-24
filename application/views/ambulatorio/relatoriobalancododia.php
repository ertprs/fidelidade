<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Balanço do dia</a></h3>
        <div>
            <form name="form_paciente" id="form_paciente"  method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriobalancododia">
                <dl>

                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="periodo_inicio" alt="date" required=""/>
                        
                    </dd>

                    <dt>
                        <label>Data Fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="periodo_fim" alt="date" required=""/>
                    </dd>




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
                </dl>

                <?
                
   
            
                ?>
                
                
                
                

                <button type="submit" >Pesquisar</button>



            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(document).ready(function () {
        jQuery('#form_paciente').validate({
            rules: {
                txtdata_inicio: {
                    required: true
                },
                txtdata_fim: {
                    required: true
                },
                producao: {
                    required: true
                }

            },
            messages: {
                txtdata_inicio: {
                    required: "*"
                },
                txtdata_fim: {
                    required: "*"
                },
                producao: {
                    required: "*"
                }
            }
        });
    });

    $(function () {
        $("#periodo_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

//    $(function () {
//        $("#periodo_inicio").focus(function () {
//            $(".ui-datepicker-calendar").hide();
//            $("#ui-datepicker-div").position({
//                my: "center top",
//                at: "center bottom",
//                of: $(this)
//            });
//        });
//    });

    $(function () {
        $("#periodo_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

//    $(function () {
//        $("#periodo_fim").focus(function () {
//            $(".ui-datepicker-calendar").hide();
//            $("#ui-datepicker-div").position({
//                my: "center top",
//                at: "center bottom",
//                of: $(this)
//            });
//        });
//    });

    $(function () {
        $("#accordion").accordion();
    });

</script>