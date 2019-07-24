<style>
.table{
    border-collapse: collapse;
    
}
td{
    padding: 5px;
}
th{
    padding: 8px;
}
</style>
<meta charset="utf-8">
<div class="content"> <!-- Inicio da DIV content -->
<table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <? if (count($medico) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MÉDICO: <?= $medico[0]->operador; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS MÉDICOS</th>
                </tr>
            <? } ?>
            <? if (count($sala) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">SALA: <?= $sala[0]->nome; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS AS SALAS</th>
                </tr>
            <? } ?>
            <? if ($_POST['tipo'] != '') { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TIPO: <?=$_POST['tipo']; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TIPO: TODOS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO DE CANCELAMENTOS</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>
            
          
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
        border-bottom:none;mso-border-top-alt:none;border-left:
        none;border-right:none;' colspan="9">&nbsp;</th>
            </tr>
            </table>
            <table  border="1" class="table">
    <? if (count($relatorio) > 0) {
        ?>
                <tr>
                   
                    <th class="tabela_teste" ><font size="-1">Nome</th>
                    <th class="tabela_teste" ><font size="-1">Médico</th>
                    <th class="tabela_teste" ><font size="-1">Operador</th>
                    <th class="tabela_teste" ><font size="-1">Motivo</th>
                    <?if($_POST['encaixe'] == 'SIM'){?>
                        <th class="tabela_teste" ><font size="-1">Encaixe</th>
                    <?}else{?>

                    <?}?>
                    <th class="tabela_teste" ><font size="-1">Data</th>
                
                </tr>
                
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                foreach ($relatorio as $item) :
                    $i++;
                        $qtde++;
                        $qtdetotal++;
?>
                        <tr>
                            <td><font size="-1"><?= $item->paciente; ?></td>
                            <td><font size="-1"><?= $item->medico; ?></td>
                            <td><font size="-1"><?= $item->operador; ?></td>
                            <td><font size="-1"><?= $item->motivo; ?></td>
                            <?if($_POST['encaixe'] == 'SIM'){?>
                                <td><font size="-1"><?= ($item->encaixe == 't')? 'SIM' : 'NÃO'; ?></td>
                            <?}else{?>

                            <?}?>
                            <td><font size="-1"><?= date("d/m/Y H:i:s",strtotime($item->data)); ?></td>
                        </tr>
                        <?php
                   
                endforeach;
                ?>
                <tr>
                </tr>
                
                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Total: <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>

    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>