<html>
    <head>
        <title>Voucher</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body style="background-color: silver;">
        <h3>Voucher</h3>
       
       <input hidden="" value="<?= $vouchers[0]->voucher_consulta_id; ?>" id="voucher_consulta_id" name="voucher_consulta_id">
        <table  border=1 cellspacing=0 cellpadding=2>
            <tr>
                <td>Horario</td>
                <td>Data</td>
                <td>Data de Uso</td>
                <td>Ações</td>
            </tr> 
            <?php foreach($vouchers as $item){?>
            <tr id="<?= $item->voucher_consulta_id; ?>" >
                <td><?= $item->horario; ?></td>
                <td><?= date('d/m/Y',strtotime($item->data)); ?></td>   
                <td><?= ($item->horario_uso != "") ?date('d/m/Y',strtotime($item->horario_uso)) : ""; ?></td>   
                <td><b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/selecionardatavoucher/<?= $item->voucher_consulta_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=320');"><button>Confirmar</a></button></b></td>
            </tr>
            <?php }?>
           
        </table>

       
      
    </body>

  
  
</html>
