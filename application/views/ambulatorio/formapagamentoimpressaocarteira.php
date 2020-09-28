<html>
    <head>
        <title></title>
        
        <style>
            body{
                background-color: silver;
            }
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
       <form action="<?= base_url(); ?>ambulatorio/guia/impressaocarteira/<?=$paciente_id;?>/<?= $contrato_id; ?>/<?= $paciente_contrato_dependente_id; ?>/<?= $paciente_titular; ?>" method="post">
           <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $paciente_id; ?>">
           <input type="hidden" name="contrato_id" id="contrato_id" value="<?= $contrato_id; ?>">
           <input type="hidden" name="paciente_contrato_dependente_id" id="paciente_contrato_dependente_id" value="<?= $paciente_contrato_dependente_id; ?>">
           <input type="hidden" name="paciente_titular" id="paciente_titular" value="<?=  $paciente_titular; ?>">        
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
            <? if(isset($permissao[0]->conta_pagamento_associado) && $permissao[0]->conta_pagamento_associado != 't'){?>
            <tr>
                <td>Conta</td>
                 <td>
                     <select  name="conta">
                         <option value="" >Selecione</option>
                         <?
                         foreach ($contas as $conta) {
                             ?> 
                             <option value=<?= $conta->forma_entradas_saida_id ?>  ><?= $conta->descricao; ?></option> 
                             <?
                         }
                         ?>
                     </select>
                </td>
            </tr> 
                        <? } ?>
            
            <tr>
                <td><input type="submit" value="Enviar"></td>
            </tr>
        </table>
       </form>
    </body>
</html>
