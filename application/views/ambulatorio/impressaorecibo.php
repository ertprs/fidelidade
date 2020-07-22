<meta charset="utf-8">
<p style="font-weight: bold;text-align:center;text-decoration: underline;"><?=$empresa[0]->razao_social?></p>
<p style="text-align:center"><?=$empresa[0]->logradouro?> - <?=$empresa[0]->numero?> - <?=$empresa[0]->bairro?></p>
<p style="text-align:center"><?=$empresa[0]->telefone?> - <?=$empresa[0]->celular?></p>
<br clear="all">
<?

    
$data_pagamento = "";
if($pagamento[0]->data_pagamento != ""){
  $data_pagamento =   $pagamento[0]->data_pagamento;
} 
    
    $data_referencia = $pagamento[0]->data;
    
?>
</p><p><p><h2 align="Center"><FONT color="#333333" face="Engravers MT, Broadway BT">RECIBO</h2></FONT><br clear="all">
</p><p>Recebi do Sr(a). <?=$paciente[0]->nome?> a quantia de R$ <?=$valor?> (<?=$extenso?>), referente à parcela de <?= date("d/m/Y", strtotime($data_referencia)); ?>
 do plano <?=$pagamento[0]->plano;?>, dando-lhe por este recibo a devida quitação.
<br clear="all">
<br clear="all">
</p><p>
<?
$data_hoje = date('Y-m-d');
$MES = date("m",strtotime($data_hoje));
// print_r($data_referencia);
// print_r($MES);
// die;

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
</p><p>Local e Data: <?=$empresa[0]->municipio?>, <?=date("d",strtotime($data_hoje))?> de <?=$mes?> de <?=date("Y",strtotime($data_hoje))?>.
<br clear="all">
<br clear="all">

<!-- </p><p>Nome: ___________________________________________________<br> -->
<!-- Endereço: _______________________________________________ -->
<br clear="all">
<br clear="all">
<br clear="all">

</p><p>_______________________________________<br>
Assinatura 