<?
$dataatualizacao = $exame[0]->data_autorizacao;
$totalpagar = 0;
$formapagamento = '';
$teste = "";
$teste2 = "";
$teste3 = "";
$teste4 = "";


$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$idade = $diff->format('%Y %mm %dd');
?>

<?
$sexo = $exame[0]->sexo;
if ($sexo == "M") {
    $sexopaciente = "Masculino";
} elseif ($sexo == "F") {
    $sexopaciente = "Feminino";
} else {
    $sexopaciente = "Outro";
}
$dataFuturo = date("Y-m-d");
$dataAtual = $paciente['0']->nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
$exame_id = $exame[0]->agenda_exames_id;
$dataatualizacao = $exame[0]->data_autorizacao;
$inicio = $exame[0]->inicio;
$agenda = $exame[0]->agenda;
?>
<meta charset="UTF-8">
<title>Ficha 13 - Tomografia</title>
<table>
    <tbody>
        <tr>
            <td colspan="2"  ><font size = -1><?= $paciente['0']->nome; ?> - <?= $paciente['0']->paciente_id; ?> <font size = -1>D.N.: <?= substr($paciente['0']->nascimento, 8, 2) . "/" . substr($paciente['0']->nascimento, 5, 2) . "/" . substr($paciente['0']->nascimento, 0, 4); ?></font></font></td>
            <td ><font size = -1>Idade: <?= $teste; ?>&nbsp; </font></td>
            <td width="280px"><font size = -1><center></center></font></td>
<td width="30px">&nbsp;</td>
<td ><font size = -1><u><?= $empresa[0]->razao_social ?></u></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1><?= $exame[0]->convenio; ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?= $exame[0]->guia_id ?></font></td>
    <td ><font size = -1>SEXO: <?= $sexopaciente ?></font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><u>&nbsp;</u></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>DATA: <?= substr($exame[0]->data, 8, 2) . "/" . substr($exame[0]->data, 5, 2) . "/" . substr($exame[0]->data, 0, 4); ?> HORA: <?= substr($dataatualizacao, 10, 6); ?></font></td>
    <td ><font size = -1>FONE:<?= $paciente['0']->telefone; ?> </font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>
        <?
        foreach ($exames as $item) :
            echo $item->procedimento;
            ?><br><? endforeach; ?>
        </font></td>
    <td ><font size = -1>MEDICO:<?= substr($exame[0]->medicosolicitante, 0, 8); ?></font></td>
    <td><font size = -2></font></td>
    <td >&nbsp;</td> 
    <td ><font size = -1><?
        foreach ($exames as $item) :
            echo $item->procedimento;
            ?><br><? endforeach; ?></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1>Atendente: <?= substr($exame[0]->atendente, 0, 13); ?></font></td>
    <td ><font size = -1> &nbsp;<?= $exame[0]->agenda_exames_id; ?></font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2><center>LAUDO:</center></font></td>
<td >&nbsp;</td>            
<td ><font size = -1></font></td>
</tr>
<tr>
    <td colspan="2" ><font size = -1></font></td>
    <td ><font size = -1></font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2>&nbsp;</font></td>
    <td >&nbsp;</td>
    <td ><font size = -2></font></td>
</tr>
<tr>
    <td ><font size = -2>( )FEBRE</font></td>
    <td ><font size = -2>( )DIARREIA</font></td>
    <td ><font size = -2>( )FRATURA</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -2>PAC: <?= substr($paciente['0']->nome, 0, 18); ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )TOSSE</font></td>
    <td ><font size = -2>( )VOMITOS</font></td>
    <td ><font size = -2>( )CORPO ESTRANHO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -2></font></td>
</tr>
<tr>
    <td ><font size = -2>( )EXPECTORA&Ccedil;&Atilde;O</font></td>
    <td ><font size = -2>( )SANGUE NA URINA</font></td>
    <td ><font size = -2>( )PERDA DE PESO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -2>CONV: <?= substr($exame[0]->convenio, 0, 10); ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )HEMOPTISE</font></td>
    <td ><font size = -2>( )CALCULO</font></td>
    <td ><font size = -2>( )MH</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>N.PEDIDO: <u><?= $exame[0]->guia_id ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )DISPNEIA</font></td>
    <td ><font size = -2>( )CEFALEIA</font></td>
    <td ><font size = -2>( )DIABETE</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>REALIZADO: <?= substr($exame[0]->data_autorizacao, 8, 2) . "/" . substr($exame[0]->data_autorizacao, 5, 2) . "/" . substr($exame[0]->data_autorizacao, 0, 4); ?> &agrave;s <?= substr($dataatualizacao, 10, 9); ?></u></font></td>
</tr>
<tr>
    <td ><font size = -2>( )TB RESIDUAL</font></td>
    <td ><font size = -2>( )CORIZA</font></td>
    <td ><font size = -2>( )TONTURA</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>

    <?
    $DT_ENTREGA = substr($exame[0]->data_entrega, 8, 2) . "/" . substr($exame[0]->data_entrega, 5, 2) . "/" . substr($exame[0]->data_entrega, 0, 4);
//    $b = 0;
//    foreach ($exames as $item) :
//    $b++;
//    $data = $item->data_autorizacao;
    $data = $exame[0]->data_autorizacao;
    $dia = strftime("%A", strtotime($data));

//    if ($dia == "Saturday") {    
//    $DT_ENTREGA = date('d-m-Y', strtotime("+2 days", strtotime($exame[0]->data_autorizacao)));
//    }elseif($dia == "Sunday") {
//    $DT_ENTREGA = date('d-m-Y', strtotime("+1 days", strtotime($exame[0]->data_autorizacao)));
//    }
//    if ($dia == "Saturday") {    
//    $DT_ENTREGA = date('d-m-Y', strtotime("+2 days", strtotime($item->data_autorizacao)));
//    }elseif($dia == "Sunday") {
//    $DT_ENTREGA = date('d-m-Y', strtotime("+1 days", strtotime($item->data_autorizacao)));
//    }
//    endforeach;
    ?>

    <td ><font size = -1>PREVISAO ENTREGA: </font></td>
</tr>
<tr>
    <td ><font size = -2>( )CONT. DE TRAT.</font></td>
    <td ><font size = -2>( )OBSTRU&Ccedil;&Atilde;O</font></td>
    <td ><font size = -2>( )ADMISSIONAL</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><?= $DT_ENTREGA ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )COMUNICANTE</font></td>
    <td ><font size = -2>( )SINUSITE</font></td>
    <td ><font size = -2>( )DEMISSIONAL</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>DE 16:00 AS 17:00 HS</font></td>
</tr>
<tr>
    <td ><font size = -2>( )PNEUMONIA</font></td>
    <td ><font size = -2>( )DOR</font></td>
    <td ><font size = -2>( )PERIODICO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>ASS:</font></td>
</tr>
<tr>
    <td ><font size = -2>( )COLICA</font></td>
    <td ><font size = -2>( )EDEMA</font></td>
    <td ><font size = -2>( )PRE-OPERATORIO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Atendimento:</font></td>
</tr>
<tr>
    <td ><font size = -2>( )FUMANTE</font></td>
    <td ><font size = -2>( )TRAUMATISMO</font></td>
    <td ><font size = -2>( )POS-OPERATORIO</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Seg a Sex de <?= $empresa[0]->horario_seg_sex ?></font></td>
</tr>
<tr>
    <td ><font size = -2>( )HIPERTENS&Atilde;O</font></td>
    <td ><font size = -2>( )ESCOLIOSE</font></td>
    <td ><font size = -2>( )CHECK-UP</font></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1>Sab de <?= $empresa[0]->horario_sab ?></font></td>
</tr>
<tr>
    <td ><font size = -1>INDICA&Ccedil;&Atilde;O: <?= $exame[0]->indicacao; ?></font></td>
    <td ><font size = -1></font></td>
    <td></td>
    <td style='width:58pt;border:solid windowtext 1.0pt;
        border-bottom:none;border-top:none;mso-border-left-alt:
        solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -2></font></td>
    <td >&nbsp;</td>
    <td ><font size = -1><?= $exame[0]->logradouro; ?><?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></font></td>
</tr>
<tr>
    <td ><font size = -2>TEC:________________ANA:____________ SALA:____</font></td>
    <td><font size = -2></font></td>
    <td ><font size = -1><center></center></font></td>
<td style='width:58pt;border:solid windowtext 1.0pt;
    mso-border-bottom-alt:solid windowtext .5pt;border-top:none;mso-border-left-alt:
    solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;'><font size = -1><center></center></font></td>

<td >&nbsp;</td>
<td ><font size = -1>Fone: <?= $exame[0]->telefoneempresa; ?> - <?= $exame[0]->celularempresa; ?></font></td>
</tr>
</table>
<div style="float:left;">
    <table border="1" style="border-collapse: collapse" >
        <tr >
            <td width="60px;"><font size = -2>E-</font></td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>MA-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>S-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
        <tr>
            <td><font size = -2>KV-</font></td><td width="60px;">&nbsp;</td><td width="60px;">&nbsp;</<td><td width="60px;">&nbsp;</<td>
        </tr>
    </table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br style="page-break-before: always;" /> 

<p><center><u><?= $exame[0]->razao_social; ?></u></center></p>
<p><center><?= $exame[0]->logradouro; ?> - <?= $exame[0]->numero; ?> - <?= $exame[0]->bairro; ?></center></p>
<p><center>Fone: (85) <?= $exame[0]->telefoneempresa; ?> - (85) <?= $exame[0]->celularempresa; ?></center></p>
<p>
<p><center>Recibo</center></p>
<p>
<p><center>N&SmallCircle; PEDIDO:<?= $exame[0]->agenda_exames_id; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VALOR:# <?= $valor; ?> &nbsp;#</center></p>
<p>
<p>Recebi de <?= $paciente['0']->nome; ?>, a importancia de <?= $valor; ?> (<?= $extenso; ?>)  referente
    a   <?
    $formapagamento = "";
    $teste = "";
    $teste2 = "";
    $teste3 = "";
    $teste4 = "";
    foreach ($exames as $item) :
        echo $item->procedimento;
        ?><br><?
        if ($item->forma_pagamento != null && $item->formadepagamento != $teste && $item->formadepagamento != $teste2 && $item->formadepagamento != $teste3 && $item->formadepagamento != $teste4) {
            $teste = $item->formadepagamento;
            $formapagamento = $formapagamento . "/" . $item->formadepagamento;
        }
        if ($item->forma_pagamento2 != null && $item->formadepagamento2 != $teste && $item->formadepagamento2 != $teste2 && $item->formadepagamento2 != $teste3 && $item->formadepagamento2 != $teste4) {
            $teste2 = $item->formadepagamento2;
            $formapagamento = $formapagamento . "/" . $item->formadepagamento2;
        }
        if ($item->forma_pagamento3 != null && $item->formadepagamento3 != $teste && $item->formadepagamento3 != $teste2 && $item->formadepagamento3 != $teste3 && $item->formadepagamento3 != $teste4) {
            $teste3 = $item->formadepagamento3;
            $formapagamento = $formapagamento . "/" . $item->formadepagamento3;
        }
        if ($item->forma_pagamento4 != null && $item->formadepagamento4 != $teste && $item->formadepagamento4 != $teste2 && $item->formadepagamento4 != $teste3 && $item->formadepagamento4 != $teste4) {
            $teste4 = $item->formadepagamento4;
            $formapagamento = $formapagamento . "/" . $item->formadepagamento4;
        }
    endforeach;
    ?></p>
<p>Recebimento atraves de: <?= $formapagamento; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Categoria: <?= $exame[0]->convenio; ?></p><p align="right"><?= $exame[0]->municipio ?>, <?= substr($exame[0]->data_autorizacao, 8, 2) . "/" . substr($exame[0]->data_autorizacao, 5, 2) . "/" . substr($exame[0]->data_autorizacao, 0, 4); ?></p>
<p>Atendente: <?= substr($exame[0]->atendente, 0, 13); ?></p>
<br>
<h4><center>___________________________________________</center></h4>
<h4><center>Raz&atilde;o Social: <?= $exame[0]->razao_social; ?></center></h4>
<h4><center>CNPJ: <?= $exame[0]->cnpj; ?></center></h4>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<?php
$colspan = "colspan= '5' "
?>
<table border="0" width="100%" style="page-break-before: always;" >
    <tr>
        <td style="text-align: center;font-family: arial;font-size: 12px;" <?= $colspan; ?> ><b>TERMO DE CONSENTIMENTO / ESCLARECIMENTO  - TOMOGRAFIA</b>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;font-family: arial;font-size: 12px;" <?= $colspan; ?> >PACIENTE:____________________________________________________________________IDADE: _____________  
        </td>
           
    </tr>
    <tr>
        <td style="text-align: center;font-family: arial;font-size: 12px;" <?= $colspan; ?> >SOLICITANTE:_______________________________________________PESO:______ CONVÊNIO:_________________</td>
    </tr>
    <tr>
        <td style="text-align: center;font-family: arial;font-size: 12px;" <?= $colspan; ?> >DATA EXAME:___/___/___ Nº ATEND.:_______________TELEFONE:_________________________________________</td>
    </tr>
    <tr>
        <td  align="justify" style="font-family: arial;font-size: 14px;" <?= $colspan; ?>  > <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O nosso serviço de diagnóstico por imagem tem por objetivo oferecer-lhe a máxima segurança na realização 
            de seus exames. Uma das providências tomadas é na escolha de produtos de contraste adequado e de melhor  
            qualidade. <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estes produtos de contrates, porém, contém iodo em sua fórmula básica, o que poderá causar reações 
            alérgicas (leve, moderada, grave), segundo grau de sensibilidade de cada pessoa. Salientamos, também, que os 
            contrastes iodados são isentos de qualquer substância radioativa. Apesar de todos os cuidados e de todo um  
            acompanhamento especializado durante seu exame, eventuais reações de intolerância podem ocorrer.<br> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O serviço possui equipamentos e pessoal treinado para prestar atendimento rápido e eficiente nos casos de 
            intolerância grave. Desta forma, desenvolvemos este questionário, no qual poderemos ter uma idéia de seu passado 
            e potencial alérgico. Preencha-o com atenção e sinta-se à vontade para perguntar o que achar necessário. Segue 
            definições dos graus de reações: <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reações leves: (pouco frequentes) - alterações passageiras e rápidas como: coceira, vermelhidão na pele, 
            espirros, tosse, náusea, vômitos. <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reações moderadas: (raras) - dispnéia leve (falta de ar), baixa súbita de pressão, tontura, associada ou não 
            com as reações leves. <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reações graves: (muito raras) - dispnéia intensa, bronco espasmo, edema de glote, associado ou não com 
            as alterações leves e moderadas. <br><br>

        </td>
    </tr> 
</table>
 
<table border=1 cellspacing=0 cellpadding=1 bordercolor="black" width="100%" >
    <tr>
        <td>&nbsp;</td>
        <td class="font_questionario">QUESTIONÁRIO</td>
        <td  class="font_questionario">SIM</td>
        <td  class="font_questionario">NÃO</td>
        <td  class="font_questionario">QUAIS</td>
    </tr>
    <tr>
        <td  class="font_questionario">01.</td>
        <td  class="font_questionario_left">Possui algum tipo de alergia? Qual?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">02.</td>
        <td  class="font_questionario_left">Já realizou algum exame com uso de contrate iodado? Qual?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">03.</td>
        <td  class="font_questionario_left">Teve reação alérgica ao contrate?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">04.</td>
        <td  class="font_questionario_left">Já teve alergia ou intoxicação ao ingerir alimento, como:camarão, peixe ou outros frutos do mar?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">05.</td>
        <td  class="font_questionario_left">Já teve alergia a algum medicamento? Qual?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">06.</td>
        <td  class="font_questionario_left">Possui urticária ou alergia de pele?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">07.</td>
        <td  class="font_questionario_left">tem insuficiência renal?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">08.</td>
        <td  class="font_questionario_left">Está grávida?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">09.</td>
        <td  class="font_questionario_left">Já realizou alguma cirurgia? Qual(is)?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">10.</td>
        <td  class="font_questionario_left">Já realizou algum exame anterior relacionado ao atual?Qual(is)?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario">11.</td>
        <td  class="font_questionario_left">Já realizou radioterapia ou Quimioterapia? Quando?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario" ROWSPAN=2 >12.</td>
        <td  class="font_questionario_left">Tem Asma?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr> 
        <td  class="font_questionario_left">Bronquite?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
   
     <tr>
        <td  class="font_questionario" ROWSPAN=2 >13.</td>
        <td  class="font_questionario_left">É Hipertenso?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr> 
        <td  class="font_questionario_left">Cardíaco?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
     <tr>
        <td  class="font_questionario"  >14.</td>
        <td  class="font_questionario_left">Rinite alérgico?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td  class="font_questionario"  >15.</td>
        <td  class="font_questionario_left">Diabético?</td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr> 
</table> 
<div  class="font_questionario" >
    Declaro estar lúcido e que as informções fornecidas neste formulário, por mim, são verdadeiras. Autorizo  
    a realização do(s) exame(s), e da injeção de produto de contraste caso constando no pedido ou se julgado 
    necessário pelo médico executante do(s) mesmo(s). 
</div> 
<table border="0"  width="100%" >
    <tr>
        <td style="text-align: right;" >  </td>
        <td style="text-align: right;font-family: arial;font-size: 13px;" >Fortaleza,<?
// CASO FUTURAMENTE QUISEREM A DATA ATUAL SÓ TIRAR OS COMENTARIOS *FUTURE-MAN      
//        date('d')
      
        
        ?>___ de <?php
//switch (date("m")) {
//        case "01":    @$mes = 'Janeiro';     break;
//        case "02":    @$mes = 'Fevereiro';   break;
//        case "03":    @$mes = 'Março';       break;
//        case "04":    @$mes = 'Abril';       break;
//        case "05":    @$mes = 'Maio';        break;
//        case "06":    @$mes = 'Junho';       break;
//        case "07":    @$mes = 'Julho';       break;
//        case "08":    @$mes = 'Agosto';      break;
//        case "09":    @$mes = 'Setembro';    break;
//        case "10":    @$mes = 'Outubro';     break;
//        case "11":    @$mes = 'Novembro';    break;
//        case "12":    @$mes = 'Dezembro';    break; 
// }
 
// echo @$mes;
 
?> _____________de 20___ <?

//date('Y')


?> </td>
    </tr> 
    <tr>
          <td style="text-align: left;" >__________________________________________</td>
          <td style="text-align: right;">__________________________________________</td>
    </tr>
    <tr>
        <td style="text-align: left;font-family: arial;font-size: 13px;font-size: 13px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assinatura Médico </td>
           <td style="text-align: right;font-family: arial;font-size: 13px;" >Assinatura (paciente ou responsável)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
     </tr>
     <tr>
         <td style="text-align: left;border-bottom:4px solid black;font-family: arial;font-size: 13px;" colspan="2" > </td>
          
    </tr>
     <tr>
        <td style="text-align: center;font-size: 10px;font-family: arial;" colspan="2">Matriz - Av. Pontes Vieira, 2551 - Dionísio Torres - CEP 60.130-241 - Fortaleza-Ce</td>
          
    </tr>
     <tr>
        <td style="text-align: center;font-size: 10px;font-family: arial;" colspan="2">Filial - Rua Otoni Façanha de Sá, 69 - Dionísio Torres - CEP 60.170-180 - Fortaleza-Ce</td>  
    </tr>
</table>

<br><br><br><br><br><br><br>
<style>
    .font_questionario{
        text-align: center;font-family: arial;
        font-size: 13px;
    }
    .font_questionario_left{
        font-family: arial;
         font-size: 13px;
    }
    

</style>


<script type="text/javascript">
    window.print();

</script>