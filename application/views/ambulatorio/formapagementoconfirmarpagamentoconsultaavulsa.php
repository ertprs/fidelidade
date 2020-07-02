<html>
    <head>
        <title></title> 
        <style>
            body{
                background-color: silver;
            }
        </style>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
 <? 
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');
?>
       <form action="<?= base_url(); ?>ambulatorio/guia/confirmarpagamentoconsultaavulsa/<?=$paciente_id;?>/<?= $contrato_id; ?>/<?= $consultas_avulsas_id; ?>" method="post">
           <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $paciente_id; ?>">
           <input type="hidden" name="contrato_id" id="contrato_id" value="<?= $contrato_id; ?>">
           <input type="hidden" name="consultas_avulsas_id" id="consultas_avulsas_id" value="<?= $consultas_avulsas_id; ?>">
          
        <table>
            <tr>
                <td>Forma de pagamento</td>
                <td>
                    <select name="forma_rendimento_id" name="forma_rendimento_id">
                        <?
                        foreach($forma_pagamentos as $item){  ?>
                          <option value="<?=  $item->forma_rendimento_id; ?>"><?= $item->nome?></option> 
                        <? 
                        }
                        ?>  
                    </select>
                </td>
            </tr>
            
          <? if($perfil_id == 1 || $operador_id == 1){ ?>
            <tr>
                <td>Valor</td>
                <td><input type="text" id="valor" name="valor" style="text-align: right;" alt="decimal" class="texto02" value="<?=  number_format($pagamento[0]->valor, 2, ',', '.'); ?>"  /></td>
            </tr>
          <?}?> 
            <tr>
                <td><input type="submit" value="Enviar"></td>
            </tr>
        </table>
       </form>
    </body>
</html>

<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/maskedmoney.js"></script>

<script>
    
    
    $("#valor").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

</script>