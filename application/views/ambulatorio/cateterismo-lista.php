 

<meta charset="utf-8">


<style>
     tr:nth-child(even) {
        background-color: #f2f2f2
    }
    
    
</style>
<h3>Cateterismo Cardíaco</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
       <td><b>Da</b></td>
        <td><b>Cx</b></td>
         <td><b>MgCX 1</b></td>
         <td><b>MgCX 2</b></td>
          <td><b>MgCX 3</b></td>
           <td><b>Diag</b></td>
            <td><b>Diagonalis</b></td>
             <td><b>CD</b></td>
              <td><b>DP da CD</b></td>
               <td><b>VP da CD</b></td>
                   <td><b>Colaterais</b></td> 
                   <td><b>VE</b></td> 
                   <td><b>VM</b></td> 
                   <td><b>VAo</b></td>
                    <td><b>VT</b></td>
                    <td><b>VP</b></td>
                     <td><b>Circ Pulmonar</b></td>
                      <td><b>Observações</b></td>
                   
                   
                   
                   
         
         
        
  
    </tr>

<?

foreach (@$lista as $item) {
    
    
    $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);
    
    $impressao_aso = json_decode($item->cate);
//
//            echo "<pre>";
//            print_r($impressao_aso);
    ?>


    <tr> 
        
        
        
       
        
          <td><?=  $data['paciente'][0]->nome; ?></td>
      <td><?= $impressao_aso->da; ?></td>
        <td><?= $impressao_aso->cx; ?></td>
         <td><?= $impressao_aso->mgcx1; ?></td>
         <td><?= $impressao_aso->mgcx2; ?></td>
          <td><?= $impressao_aso->mgcx3; ?></td>
           <td><?= $impressao_aso->diag; ?></td>
            <td><?= $impressao_aso->diagonalis; ?></td>
             <td><?= $impressao_aso->cd; ?></td>
              <td><?= $impressao_aso->dpcd; ?></td>
               <td><?= $impressao_aso->vpcd; ?></td>
                   <td><?= $impressao_aso->colaterais; ?></td> 
                   <td><?= $impressao_aso->ve; ?></td> 
                   <td><?= $impressao_aso->vm; ?></td> 
                   <td><?= $impressao_aso->vao; ?></td>
                   <td><?= $impressao_aso->vt; ?></td>
                    <td><?= $impressao_aso->vp; ?></td>
                     <td><?= $impressao_aso->circpulmonar; ?></td>
                      <td><?= $impressao_aso->observacoes; ?></td>
       
        
  
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
