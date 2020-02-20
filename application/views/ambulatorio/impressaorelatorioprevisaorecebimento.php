<?php 
 
$ParcelasPagas = 0;
$ParcelasReceber = 0;
$ParcelasNpagas = 0;
$percentualPagas = 0;
$percentualReceber = 0;
$percentualNpagas = 0;
$total = 0;
 
foreach($relatorio as $item){
    $total++;
    if ($item->paga == 'f') {
        $ParcelasPagas++;  
    }elseif(strtotime($item->data) > strtotime(date('Y-m-d'))){   
        $ParcelasReceber++; 
    }elseif($item->paga == 't'){
        $ParcelasNpagas++;
    }  
}
foreach($consultaavulsas as $item){
    $total++;
    if ($item->ativo == 'f') {
        $ParcelasPagas++;  
    }elseif(strtotime($item->data) > strtotime(date('Y-m-d'))){   
        $ParcelasReceber++; 
    }elseif($item->ativo == 't'){
        $ParcelasNpagas++;
       
    }  
}




foreach($consultacoop as $item){
    $total++;
    if ($item->ativo == 'f') {
        $ParcelasPagas++;  
    }elseif(strtotime($item->data) > strtotime(date('Y-m-d'))){   
        $ParcelasReceber++; 
    }elseif($item->ativo == 't'){
        $ParcelasNpagas++;
    }  
}
if ($total > 0) { 

$percentualPagas = ($ParcelasPagas*100)/$total;
$percentualReceber = ($ParcelasReceber*100)/$total;
$percentualNpagas = ($ParcelasNpagas*100)/$total;
        
 }
?>
<meta charset="utf-8"> 
<input type="hidden" id="pagas" value="<?= $ParcelasPagas; ?>">
<input type="hidden" id="receber" value="<?= $ParcelasReceber; ?>">
<input type="hidden" id="naopagas" value="<?= $ParcelasNpagas; ?>">

<input type="hidden" id="Ppagas" value="<?= $percentualReceber; ?>">
<input type="hidden" id="Preceber" value="<?= $percentualReceber; ?>">
<input type="hidden" id="Pnaopagas" value="<?= $ParcelasNpagas; ?>">

<style>
    td,p{
        font-family: arial;
    }
    tr:nth-child(2n+2) {
    background: #ccc;
}
</style>
 <title>Relatório</title>  
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script> 
    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php 
switch ($_POST['mes']) {
        case "01":    $mes = 'Janeiro';     break;
        case "02":    $mes = 'Fevereiro';   break;
        case "03":    $mes = 'Março';       break;
        case "04":    $mes = 'Abril';       break;
        case "05":    $mes = 'Maio';        break;
        case "06":    $mes = 'Junho';       break;
        case "07":    $mes = 'Julho';       break;
        case "08":    $mes = 'Agosto';      break;
        case "09":    $mes = 'Setembro';    break;
        case "10":    $mes = 'Outubro';     break;
        case "11":    $mes = 'Novembro';    break;
        case "12":    $mes = 'Dezembro';    break; 
 }
        
?>
<p>Empresa: <?= $empresa[0]->nome; ?></p>
<p>Mês: <?= $mes; ?></p>  

<hr>

<table border="0"  >
    <tr>
        <td><div id="columnchart_values"  ></div>
      </td>
      <td>
         <table border=1 cellspacing=0 cellpadding=2>
            <tr>
                <td>Pagas</td>
                <td>Não pagas</td>
                <td>A receber</td>

            </tr>
            <tr>
                <td><?= $ParcelasPagas; ?> - <?= round($percentualPagas, 2)."%"; ?></td>
                 <td><?= $ParcelasNpagas; ?> - <?= round($percentualNpagas, 2)."%"; ?></td>
                  <td><?= $ParcelasReceber; ?> - <?= round($percentualReceber, 2)."%"; ?></td>
            </tr>
         <tr>
        <td>Total</td>
        <td colspan="2"><?= $total; ?></td> 
        </tr>
</table> 
      </td>
    </tr> 
</table>


  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
//    
   

    
    function drawChart() {
         var pagas = parseInt($("#pagas").val());
         var receber =   parseInt($("#receber").val());
         var naopagas =   parseInt($("#naopagas").val());
          
      var data = google.visualization.arrayToDataTable([
        ["Element", "Quantidade", { role: "style" } ],
        ["Pagas",pagas, 'color: #27ae60' ],
        ["Não pagas ",naopagas, 'color:#bdc3c7' ],
        ["A receber",receber , 'color:#dfe4ea' ]
 
      ]); 
    var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
          
        title: "Relatório Previsão de Recebimento",
        width: 800,
        height: 600,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>

