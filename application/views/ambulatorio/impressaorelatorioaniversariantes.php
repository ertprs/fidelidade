 

<div class="content"> <!-- Inicio da DIV content -->
    <? 

    if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Aniversariantes</h4>
    <h4>MES: <?
    if ($txtdata_inicio < 0) {
      echo $txtdata_inicio*-1;  
    }else{
       echo $txtdata_inicio ; 
    }
     
    
    ?></h4>

    <hr>
    <? if (count($relatorio) > 0) {
        ?>
    
    <style>
        tr:nth-child(2n+2) {
    background: #ccc;
}

tr{
    
    font-family: arial;
    
}
table tr:hover td{
	background-color:#1e272e;
        
 }

table tr:hover td{
 color:white; 
}
        
    </style>
    
    <title>Relat&oacute;rio Anivers&aacute;riantes</title>
    
    
    <table  border=1 cellspacing=0 cellpadding=2 bordercolor="black" style="width: 100%;" >
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                      <th class="tabela_header"><font size="-1"><?= utf8_decode('Endereço')?></th>
                    <th class="tabela_header"><font size="-1">Telefone/Celular</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($relatorio as $item) :

                    ?>
                    <tr>
                        <td><font size="-2"><?= substr($item->nascimento, 8,2) . "/" . substr($item->nascimento, 5,2) . "/" . substr($item->nascimento, 0,4); ?></td>
                        <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                              <td><font size="-2"><? echo  utf8_decode($item->logradouro); ?>,<? echo  utf8_decode($item->numero); ?>,<? echo  utf8_decode($item->bairro); ?> - <? echo  utf8_decode($item->municipio); ?></td>
                        <td><font size="-2"><?= utf8_decode($item->telefone). " / " . utf8_decode($item->celular);?></td>
                    </tr>
                    <?endforeach;?>
            </tbody>
        </table>
        <?
       
        
    } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <title>Relatório Aniversáriante</title>
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
