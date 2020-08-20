<?if(isset($message)){
        echo "<script>alert('$message');</script>";
}
$empresa_id = $this->session->userdata('empresa_id');
$this->db->select('ep.api_google');
$this->db->from('tb_empresa ep');

$this->db->where('ep.empresa_id', $empresa_id);
$data['permissao'] = $this->db->get()->result();
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; DashBoard Google</a></h3>
        <div>
        <table>
            <tr>
                 <td> <a href="<?php echo base_url() ?>ambulatorio/guia/addEvent">Adicionar Eventos</a> </td>
            </tr>
            <!-- <tr>
                <td><br></td>
            </tr>
            <tr>
                <td> <a href="<?php echo base_url() ?>event/eventList">Lista de Eventos</a> </td>
            </tr> -->
        </table>
        <br>
        <center>
        <?=$data['permissao'][0]->api_google?>
        </center>
        
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
