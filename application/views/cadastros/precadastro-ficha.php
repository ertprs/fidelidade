 <div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
   
         <?= form_open_multipart(base_url() . 'cadastros/pacientes/gravarprecadastro'); ?>
        <fieldset>
             <legend>Dados do Paciente</legend>
             <div>
                <label>Nome *</label>               
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$lista[0]->nome; ?>" required/>
                <input type="hidden" id="precadastro_id" name="precadastro_id" value="<?= @$lista[0]->precadastro_id; ?>">
            </div>
            <div>
                <label>&nbsp;</label>
                <input type="checkbox" name="cpf_responsavel" id ="cpf_responsavel" <? if (@$obj->_cpf_responsavel_flag == 't') echo "checked"; ?>> CPF do resposável
            </div>
            <div>
                <label>Cpf</label>
            <input type="text" name="cpf" id ="cpfcnpj" class="texto03" value="<?= @$lista[0]->cpf; ?>" onblur="verificarCPF()" />
            </div>
            
              <div>
                    <label>Telefone</label>
                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$lista[0]->telefone; ?>"  />
                </div>
            
            <div>
                <label>Plano *</label>

                <select name="plano" id="plano" class="size2" >
                    <option value='' >selecione</option>
                    <?php
                    $planos = $this->formapagamento->listarforma();
                    foreach ($planos as $itens) {
                        ?>
                    <option  <? if(@$lista[0]->plano_id == $itens->forma_pagamento_id) { echo "selected"; }?>  value=<?php echo $itens->forma_pagamento_id; ?>><?php echo $itens->nome; ?></option>

                        <?php
                    }
                    ?> 
                </select>
            </div>
            
            <?php
            
                    $datalistarvendedor = $this->paciente->listarvendedor();  
                    $vendedor = $this->paciente->dadosvendedor(@$lista[0]->vendedor);  
                    //if ($this->session->userdata('perfil_id') == 1) {                    
                      
                    ?>
            
            <div>
                    <label>Indicação
                   </label>                    
                    <select id="vendedor" name="vendedor">
                            <?php 
                            foreach($datalistarvendedor as $item){
                                
                                ?>
                        <option <? if($item->operador_id == @$lista[0]->vendedor){ echo "selected"; }?> value="<?= $item->operador_id ?>" ><?= $item->nome; ?></option>
                        <?  }
                            ?>
                    </select>
                   
             </div>
            <?
                  //  }else{
            ?>
             <!-- <div>
                    <label>Vendedor</label>
                     <select id="vendedor" name="vendedor">
                            
                        <option value="<?= $vendedor[0]->operador_id ?>" ><?=  $vendedor[0]->nome; ?></option>
                        
                    </select>
                     
             </div> -->
                <?php 
                   // }
                ?>
              
             <div>
                  <label>Arquivo</label>
                   <input type="file" name="userfile"/>
             </div>
             
        </fieldset>
     <fieldset>   
         
           <input type="submit" value="Enviar"></fieldset>
     
     <fieldset>
         <h3><a href="#">Vizualizar arquivos </a></h3>
        <div >
            <table>
                <tr>
                <?
                $i=0;
                if (@$arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) :
                    $i++;
                        ?>
                
                <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/precadastro/" . $precadastro_id . "/" . $value ?>','_blank','toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/precadastro/" . $precadastro_id . "/" . $value ?>"><br><? echo substr($value, 0, 10)?>
                    <br/><a onclick="javascript: return confirm('Deseja realmente excluir o arquivo <?= $value; ?>');" href="<?= base_url() ?>cadastros/caixa/excluirarquivoprecadastro/<?= $precadastro_id?>/<?=$value?>">Excluir</a></td>
                    <?
                    if($i == 8){
                        ?>
                        </tr><tr>
                        <?
                    }
                    endforeach;
                endif
                ?>
            </table>
        </div>

     </fieldset>
  <?= form_close(); ?>
 </div>


<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>

<script  type="text/javascript">
    
      $("#cpfcnpj").mask("999.999.999-99");
       $("#txtTelefone").mask("(99) 9999-9999");      
              function verificarCPF() {
                        
                                var cpf = $("#cpfcnpj").val();
                                var paciente_id = "";
                                if ($('#cpf_responsavel').prop('checked')) {
                                    var cpf_responsavel = 'on';
                                } else {
                                    var cpf_responsavel = '';
                                }

                                $.getJSON('<?= base_url() ?>autocomplete/verificarcpfpaciente', {cpf: cpf, cpf_responsavel: cpf_responsavel, paciente_id: paciente_id, ajax: true}, function (j) {
                                    if (j != '') {
                                        alert(j);
                                        $("#cpfcnpj").val('');
                                    }
                                });
                            
                           
 
                        }
                        
                        
</script>