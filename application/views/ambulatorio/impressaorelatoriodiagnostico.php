
<?
//echo "<pre>";
//print_r($relatorio);
?>
<meta charset="utf-8">
<h4>Relatório Diagnóstico</h4>
<h4>Idade: <?= @$_POST['idade']; ?> Anos </h4>
<h4>Sexo : <?
    if ($_POST['sexo'] == "M") {
        echo 'Masculino';
    } elseif (@$_POST['sexo'] == "F") {
        echo "Feminino";
    } else {
        echo "Outro";
    }
    ?></h4>
<?
    if ($_POST['txtdata_inicio'] != ""  && $_POST['txtdata_fim'] != "") {
    

?>
<h4>PERÍODO:  <?= @$_POST['txtdata_inicio'];  ?> Até <?= @$_POST['txtdata_fim']; ?>
<?
    }else{
        
    }
?>


<hr>
<br>
<title>Relatório Diagnóstico</title>
<table border=1 cellspacing=0 cellpadding=2 bordercolor="666633"  width="100%" >
    <tr>
        <td title="Nome" ><b>Nome</b></td>
        <td title="Idade"   ><b>Idade</b></td>
        <td title="Sexo" ><b>Sexo</b></td>
        <td title="Diagnóstico" ><b>Diagnóstico</b></td>
    </tr>
<?
foreach ($relatorio as $item) {
    
    
    if ($_POST['idade'] != "") {
               
    @$dataFuturo2 = date("Y-m-d");
    @$dataAtual2 = $item->nascimento;
    @$date_time2 = new DateTime($dataAtual2);
    @$diff2 = $date_time2->diff(new DateTime($dataFuturo2));
    @$teste2 = $diff2->format('%Y');
    @$idade2 = $diff2->format('%Ya %mm %dd');
    }else{
 
    @$idade2 ="";
    } 
    
    ?> 
        <?
        if (@$teste2 == @$_POST['idade']) {
            ?>
            <tr>
                <td title="<?= @$item->paciente; ?>"   ><?= @$item->paciente; ?></td>
                <td  title="<?= @$idade2; ?>"  ><?= @$idade2; ?></td>
                <td  title="<?= @$item->sexo; ?>"  ><?
        if (@$item->sexo == "M") {
            echo "Masculino";
        } elseif (@$item->sexo == "F") {
            echo "Feminino";
        } else {
            echo "Outro";
        }
            ?></td>
               
                <td class=" "><a title="<?= @$item->diagnostico; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarhistorico/<?= @$item->paciente_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\  width=500,height=400, scrollbars=yes');"><b style="font-size: 11px;"  ></b><?= @$item->diagnostico; ?></td>                         
           

 </tr>



        <?
    }
    
     
    
    
}
?>

</table>


