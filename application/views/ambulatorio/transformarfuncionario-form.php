<html>
    <head>
        <title></title>
        <style>
            body{
                background-color: silver;
            }
        </style>
    </head>
    <body>
        
        <form action="<?= base_url(); ?>ambulatorio/guia/gravartrasnformarfuncionario" method="post" >
        <h3>Alterar Paciente</h3>
        <input type="hidden" value="<?= $paciente_id; ?>" name="paciente_id" id="paciente_id">
            <table>
               <tr>
                <td>Empresa</td>
                    <td>
                        <select name="empresa_cadastro_id" id="empresa_cadastro_id" required="">
                            <option value="">Selecione</option>
                            <?php foreach($empresa as $item){
                                ?>
                            <option value="<?= $item->empresa_cadastro_id; ?>"> <?= $item->nome; ?></option>
                            <?
                            }
                               ?>
                       </select>
                    </td>
                </tr>
                <tr>
                  <td>Plano</td>
                  <td><select name="plano" id="plano" required="">
                              <option value="">Selecione</option>
                              <?php foreach($planos as $item){
                                  ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"> <?= $item->nome; ?></option>
                             <?
                                }
                             ?>
                         </select>
                  </td>
                </tr> 
             </table> 
        <input type="submit" value="Enviar">
        </form>
 
 
    </body>
</html>
