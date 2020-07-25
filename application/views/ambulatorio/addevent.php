<?
if(isset($message)){
    redirect(base_url().'ambulatorio/guia/google/'.$message);
}

?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; Adicionar Eventos Agenda Google</a></h3>



        <form action="<?=base_url().'ambulatorio/guia/addEvent'?>" method="POST">
        <table>
            <tr>
                 <td> <a href="<?php echo base_url() ?>ambulatorio/guia/google">Agenda Google</a> </td>
            </tr>
            <tr>
            <td><br><br><br></td>
            </tr>
            <tr colspan="2"><th>Adicionar Agendamos Google</th></tr>

            <tr>
                <td><label>Titular:</label>
                    <?= form_input( array( 'name' => 'summary_id', 'id' => 'summary_id', 'type' => 'text' , 'class' => 'texto_id' , 'required' => true  ) );?>
                    <?= form_input( array( 'name' => 'summary', 'id' => 'summary', 'class' => 'texto10' , 'required' => true  ) );?>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr>
                <td><label>Data Da Agenda:</label>

                <?= form_input( array( 'name' => 'startDate', 'type' => 'text' , 'class' => 'texto1' , 'id' => 'startDate', 'alt' => 'date', 'required' => 'true' ) );?>
                
                <label>Hora Inicio:</label>
                <?= form_input( array( 'name' => 'startTime', 'type' => 'time' , 'class' => 'form-control' , 'required' => 'true' ) );?>
                
                <label>Hora FIm:</label>
                <?= form_input( array( 'name' => 'endTime', 'type' => 'time' , 'class' => 'form-control' , 'required' => 'true' ) );?>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr>
            <td><label>Descrição</label> <br>
            <?= form_textarea( array( 'name' => 'description', 'class' => 'form-control' , 'rows' => '3' ) );?>
            </tr>

            <tr>
            <td><?= form_submit( array( 'value' => 'Adicionar Evento' , 'class' => 'btn btn-primary' , 'style' => 'margin-top:15px;' ) );?></td>
            </tr>

        </table>
        </form>
    </div> 

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#startDate").datepicker({
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
        $("#summary").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientetitularrelatorio",
            minLength: 7, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#summary").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#summary").val(ui.item.value);
                $("#summary_id").val(ui.item.id);;
        
                return false;
            }
        });
    });

    $(function () {
        $("#summary_id").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientetitularrelatorioid",
            minLength: 1, // Todas as telas de agendamento eu coloquei esse comentario. Quando for alterar esse valor, basta ir em "Localizar em Projetos" e pesquisar por ele.
            focus: function (event, ui) {
                $("#summary_id").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#summary").val(ui.item.value);
                $("#summary_id").val(ui.item.id);;
        
                return false;
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });

    
</script>

<!-- <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In with Google</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-block btn-social btn-google-plus" href="<?= $loginUrl; ?>">
                        <i class="fa fa-google-plus"></i> Sign in with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> -->
