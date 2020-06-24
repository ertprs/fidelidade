<html>
    <head>
        <title>Data</title>
        <meta charset="utf-8">
    </head>
    
    <body style="background-color: silver;">
        <form action="<?= base_url() ?>ambulatorio/guia/confirmarvoucher" method="post">
            <p>Data de Uso</p>
            <input type="text" name="data_uso" id="data_uso" required="">
            <!-- <p>Forma de Pagamento:</p>
            <select name="pagamento_id" id="pagamento_id" class="size2" required>
                                        <?php foreach ($pagamentos as $item) {?>
                                            <option   value =<?php echo $item->forma_rendimento_id; ?>>
                                                <?php echo $item->nome; ?>
                                            </option>
                                        <? }?> 
         
            </select>   -->
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
