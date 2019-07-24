

<meta charset="utf-8">


<style>
     tr:nth-child(even) {
        background-color: #f2f2f2
    }
    
    
</style>
<h3>Ecostress</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
       <td><b>Hipocinesiaanterior</b></td>
        <td><b>Hipocinesiamedial</b></td>
        <td><b>Hipocinesiaapical</b></td>
        <td><b>Hipocinesiainferior</b></td>
        <td><b>Hipocinesialateral</b></td>    
        <td><b>Disfuncão</b></td>    
       
  
    </tr>

<?

foreach (@$lista as $item) {
    
    
    $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);
    
    $impressao_aso = json_decode($item->ecostress);

            
    ?>


    <tr> 
        
        
        
       
        
          <td><?=  $data['paciente'][0]->nome; ?></td>
      <td><?= $impressao_aso->hipocinesiaanterior;?></td>
        <td><?= $impressao_aso->hipocinesiamedial;?></td>
        <td><?= $impressao_aso->hipocinesiaapical;?></td>
        <td><?= $impressao_aso->hipocinesiainferior;?></td>
        <td><?= $impressao_aso->hipocinesialateral;?></td>    
        <td>disfuncao</td>   
  
    </tr>







    <?
}
?>


</table>

<br>

<h3>Exames</h3>

 
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
         <td><b>Exame</b></td>
           <td><b>Grupo</b></td>
            <td><b>Tipo</b></td>
   
    </tr>

<?


foreach (@$exames as $item) {
    
     
    ?>


    <tr> 
        
        
        
       
        
          <td><?= $item->paciente; ?> </td>
             <td><?= $item->nome; ?> </td>
                <td><?= $item->grupo; ?> </td>
                  <td><?= $item->tipo; ?> </td>
       
    </tr>







    <?
}
 

?>


</table>
