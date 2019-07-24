<?
//echo "<pre>";
//print_r($lista);
?>

<style>
    body{
        background-color: silver;
    }
</style>
<html>
    <head>
        <title>title</title>
    </head>
    <body  >
        
        <h1 style="text-align: center;" >Alterar Sala</h1>
        <form  name="form_obs" id="form_obs" action="<?= base_url() ?>ambulatorio/laudo/atualizarsala"  method="post">
               
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<select name="sala" style="text-align: center;" aling="center" >
            
            <?
            foreach( $lista as $item){
            ?>
            
            <option value="<?= $item->exame_sala_id; ?>"
                    <?
                    if ($item->exame_sala_id == $sala_id) {
                        echo "selected";
                    }
                    
                    ?>
                    
                    
                    >
            <?= $item->nome; ?>   
                
                
            </option>
            
            <?
            }
            ?>
            
        </select>
        
        
        <input type="text" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id; ?>" hidden>      
        <input type="text" name="exame_id" value="<?= $exame_id; ?>" hidden>     
        <input type="text" name="paciente_id" value="<?= $paciente_id; ?>" hidden>
        <input type="text" name="procedimento_tuss_id" value="<?= $procedimento_tuss_id; ?>" hidden>
        
        
        
        
        <input type="submit" value="Enviar">
        </form>
        
    </body>
</html>

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
    
    
    
   
    $(function() {
        $( "#accordion" ).accordion();
    });




</script>