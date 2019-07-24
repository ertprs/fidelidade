

<meta charset="utf-8">


<style>
     tr:nth-child(even) {
        background-color: #f2f2f2
    }
    
    
</style>
<h3>Holter 24h</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
       <td><b>Ritmo</b></td>
        <td><b> FC MAX</b></td>
        <td><b>FC MIN</b></td>
        <td><b>FC MED</b></td>
        <td><b>ESSV</b></td>    
          <td><b>ESV</b></td>    
        <td><b>TAQUIARRITMIAS</b></td>    
        <td><b>BRADIARRITMIAS</b></td>
        <td><b>SINTOMAS</b></td>
        <td><b>PAUSAS</b></td> 
        <td><b>Alt Repol Ventricular</b></td>
        <td><b>Conclusão</b></td>
  
    </tr>

<?
//echo "<pre>";
//print_r(@$lista);


foreach (@$lista as $item) {
    
   
    $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);
    
    $impressao_aso = json_decode($item->holter);

//            echo "<pre>";
//            print_r($impressao_aso);
    ?>


    <tr> 
        
        
        
       
        
          <td><?=  $data['paciente'][0]->nome; ?></td>
       <td><? echo $impressao_aso->ritmo; ?></td>
        <td><? echo $impressao_aso->fcmax; ?></td>
        <td><? echo $impressao_aso->fcmin; ?></td>
        <td><? echo $impressao_aso->fcmed; ?></td>
        <td><? echo $impressao_aso->essv; ?></td>  
        <td><? echo $impressao_aso->esv; ?></td>    
        <td><? echo $impressao_aso->taquiarritmias; ?></td>    
        <td><? echo $impressao_aso->bradiarritmias; ?></td>
        <td><? echo $impressao_aso->sintomas; ?></td>
        <td><? echo $impressao_aso->pausas; ?></td> 
        <td><? echo $impressao_aso->arventricular; ?></td>
        <td><? echo $impressao_aso->conclusao; ?></td>
       
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
    $exame_id =$item->agenda_exames_id;
     
    ?>


    <tr> 
        
        
        
       
        
          <td><?= $item->paciente; ?> </td>
             <td><?= $item->nome; ?> </td>
                <td><?= $item->grupo; ?> </td>
                  <td><?= $item->tipo; ?> </td>
                   <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/anexarimagemmedico/" . $item->agenda_exames_id ?> ', '_blank', 'width=1200,height=700');">
                                    <font size="-1" style="color:red;"><b>Ver Imagens</b></font>
                                </a>
                            </div></center>
                        </td>
       
    </tr>

 
    <?
}
//echo "<pre>";
//print_r(@$exames);

?>


</table>
