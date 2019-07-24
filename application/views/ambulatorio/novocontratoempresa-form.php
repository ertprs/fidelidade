<html>
    <head>
        <title>Alterar Plano</title>
        <meta charset="utf-8">
    </head>
    <body style="background-color: silver;"  >
        
        <fieldset> 
               <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/alterarplano" method="post"> 
                   <input type="hidden" name="paciente_id" value="<?= $paciente_id;?>">
                   <input type="hidden"  name="empresa_cadastro_id" value="<?= $empresa_cadastro_id; ?>"> 
            <div>
                    <label>Plano</label>                      
                    <select name="plano" id="plano" class="size2" required="">
                        <option value='' >Selecione</option>
                        <?php
                        foreach ($planos as $item) {
                            ?> 
                            <option   value=<?php echo $item->forma_pagamento_id; ?>
                                      
                                      <?
                                          if (@$plano_id == $item->forma_pagamento_id): echo "selected"; endif;  
                                      ?>
                                      
                                      ><?php echo $item->nome; ?></option>
                            <?php
                        }
                        ?> 
                    </select>
                     
                </div>
                   <br><br>
                   
                   <input type="submit" value="Alterar">
            
               </form>
            
            
        </fieldset>
    
    </body>
</html>
