<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; DashBoard Google</a></h3>
        <div>
        <table>
            <tr>
                 <td> <a href="<?php echo base_url() ?>event/addEvent">Adicionar Eventos</a> </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td> <a href="<?php echo base_url() ?>event/eventList">Lista de Eventos</a> </td>
            </tr>
        </table>
    </div> 

    <h3><a href="#">&nbsp;&nbsp;&nbsp; Calendario de Eventos</a></h3>
    <div>
        <center>
        <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=America%2FFortaleza&amp;src=bGVvbmFyZG9zYW50b3M5Njk4OTBAZ21haWwuY29t&amp;src=cHQuYnJhemlsaWFuI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&amp;color=%23039BE5&amp;color=%230B8043&amp;showNav=1&amp;showTitle=1&amp;showDate=1&amp;showCalendars=1&amp;showTz=0&amp;showTabs=1&amp;showPrint=0&amp;title=STG" style="border-width:0" width="1000" height="600" frameborder="0" scrolling="no"></iframe>
        </center>
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
