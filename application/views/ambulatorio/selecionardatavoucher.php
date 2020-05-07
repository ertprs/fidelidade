<html>
    <head>
        <title>Data</title>
    </head>
    
    <p>Data de Uso</p>
    <body style="background-color: silver;">
        <form action="<?= base_url() ?>ambulatorio/guia/confirmarvoucher" method="post">
            <input type="text" name="data_uso" id="data_uso" required="">
            <input type="hidden" name="voucher_consulta_id" id="voucher_consulta_id" value="<?= $voucher_consulta_id; ?>" >           
            <input  type="submit" value="Enviar">
        </form>
    </body>
    
        <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script>
    
     $(function () {
                                    $("#data_uso").datepicker({
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
  
  
</html>
