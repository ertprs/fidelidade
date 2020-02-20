<meta charset="utf-8">

<title>Recibo</title>
<?php  
//echo "<pre>";
//print_r($pagamentos);
//die; 
?>
<style>
    p{
        font-family: arial;
    }
</style>


<p style="font-weight: bold;text-align:center;text-decoration: underline;"><?= $empresa[0]->razao_social ?></p>
<p style="text-align:center"><?=$empresa[0]->logradouro?> - <?=$empresa[0]->numero?> - <?=$empresa[0]->bairro?></p>
<p style="text-align:center"><?=$empresa[0]->telefone?> - <?=$empresa[0]->celular?></p>
<br clear="all">

 <p><p><h2 align="Center"><FONT color="#333333" face="Engravers MT, Broadway BT">RECIBO</h2></FONT><br clear="all">
 <?php 
 $valor_total = 0.00;
 foreach($pagamentos as $item){
     
 $valor_total += $item->valor;
 $valor = number_format($item->valor, 2, ',', '.');
    
 if ($valor == '0,00') {
      $extenso = 'ZERO';
 } else {
      $valoreditado = str_replace(",", "", str_replace(".", "", $valor)); 
      $extenso = GExtenso::moeda($valoreditado); 
 }

        
 ?>
 <p>Recebi do Sr(a). <?=$paciente[0]->nome?> a quantia de R$ <?= $valor; ?> (<?=$extenso?>), referente à parcela de <?=date("d/m/Y", strtotime($item->data))?>
 do plano <?= $item->plano;?>, dando-lhe por este recibo a devida quitação.

 <?php }?>
<br clear="all">


<br clear="all"> 
 <p>Valor Total: R$ <? 
 $valor_total = number_format($valor_total, 2, ',', '.');
 
 if ($valor_total == '0,00') {
      $extenso_total = 'ZERO';
 } else {
      $valoreditado_total = str_replace(",", "", str_replace(".", "", $valor_total)); 
      $extenso_total = GExtenso::moeda($valoreditado_total); 
 } 
 echo $valor_total." (".$extenso_total.")"; 
 
 ?></p>
</p><p>
<?
$MES = date("m");

switch ($MES) {
    case "01": $mes = 'Janeiro';
        break;
    case "02": $mes = 'Fevereiro';
        break;
    case "03": $mes = 'Março';
        break;
    case "04": $mes = 'Abril';
        break;
    case "05": $mes = 'Maio';
        break;
    case "06": $mes = 'Junho';
        break;
    case "07": $mes = 'Julho';
        break;
    case "08": $mes = 'Agosto';
        break;
    case "09": $mes = 'Setembro';
        break;
    case "10": $mes = 'Outubro';
        break;
    case "11": $mes = 'Novembro';
        break;
    case "12": $mes = 'Dezembro';
        break;
}
?>
</p><p>Local e Data: <?=$empresa[0]->municipio?>, <?=date("d")?> de <?=$mes?> de <?=date("Y")?>.
<br clear="all">
<br clear="all">

<!-- </p><p>Nome: ___________________________________________________<br> -->
<!-- Endereço: _______________________________________________ -->
<br clear="all">
<br clear="all">
<br clear="all">

</p><p>_______________________________________<br>
Assinatura 