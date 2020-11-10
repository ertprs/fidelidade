<html>
    <head>
        <title>Alterar Plano</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body style="background-color: silver;">
        <h3>Alterar Plano</h3>
       <form action="<?=base_url().'/ambulatorio/guia/gravaralterarplanotitular'?>" method="POST">
        <div>
            <label>Plano Atual</label>
            <input type='hidden' name="plano_atual_id" value="<?=$plano_atual[0]->plano_id?>" readonly/>
            <input type='hidden' name="contrato_id" value="<?=$contrato_id?>" readonly/>
            <input type='text' name="plano_atual" value="<?=$plano_atual[0]->nome?>" readonly/>
        </div>

        <div>
            <label>Novo Plano</label>
            <select name="plano" id="plano" class="size2" required>
                    <option value="" >selecione</option>
                    <?php foreach ($planos as $item) { 
                        if($plano_atual[0]->plano_id == $item->forma_pagamento_id){ continue; }?>
                    <option   value ="<?php echo $item->forma_pagamento_id; ?>"  ><?php echo $item->nome; ?></option>
                        <?php } ?> 
                </select>
        </div>

        <label>Forma de pagamento</label>
                <div class="valores">
                    <input required="" type="radio" name="testec" value=""/>1 x 0.00<br>
                    <input required="" type="radio" name="testec" value=""/>5 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>6 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>10 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>11 x 0.00<br>  
                    <input required="" type="radio" name="testec" value=""/>12 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>23 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>24 x 0.00<br> 
                </div>

       <div>
                        <button type="submit">Salvar</button>
       </div>
      </form>
    </body>

  
  
</html>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/maskedmoney.js"></script>
<script type="text/javascript">

$(function () {
                //   carregarPlano();
                    $('#plano').change(function () {
                        if ($(this).val()) {
                            $('.carregando').show();
                            $.getJSON('<?= base_url() ?>autocomplete/carregarprecos', {tipo: $(this).val(), ajax: true}, function (j) {
                            console.log(j);
                                var options = '';
                                for (var c = 0; c < j.length; c++) {
                                    //CARREGANDO TODOS OS INPUTS COM OS RESPECTIVOS VALORES DOS SEUS CAMPOS VINDO DO AUTOCOMPLETE
                                    options += ' <input required="" id="checkboxvalor1" type="radio" name="checkboxvalor1" value="01-' + j[0].valor1 + '  "/>1 x ' + j[0].valor1 + ' <br>\n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="05-' + j[0].valor5 + ' "/>5 x ' + j[0].valor5 + '<br>\n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="06-' + j[0].valor6 + ' "/>6 x ' + j[0].valor6 + '<br>   \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="10-' + j[0].valor10 + ' "/>10 x ' + j[0].valor10 + '  <br> \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="11-' + j[0].valor11 + ' "/>11 x ' + j[0].valor11 + ' <br>     \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="12-' + j[0].valor12 + ' "  />12 x ' + j[0].valor12 + '<br>  \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="23-' + j[0].valor23 + ' "  />23 x ' + j[0].valor23 + '<br>   \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="24-' + j[0].valor24 + ' "  />24 x ' + j[0].valor24 + '<br>                 ';
                                     
                                      var adesao = parseFloat(j[0].valor_adesao).toLocaleString('pt-br', {minimumFractionDigits: 2});  
                                      $("#valor_adesao").val(adesao);
                                }
                                $('.valores').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
//                                                    $('#classe').html('<option value="">TODOS</option>');
                        }
                    });
                 });

</script>
