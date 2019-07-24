  

<meta charset="utf-8">


<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }


</style>
<h3>CINTILOGRAFIA</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
        <td><b>Tipo</b></td>
        <td><b>SSS</b></td>
        <td><b>FE</b></td>
        <td><b>Área de Fibrose</b></td>
        <td><b>Área de Isquemia</b></td>
        <td><b>Disfunção</b></td>
        <td><b>Teste Ergométrico</b></td>
        <td><b>Outros achados</b></td>










    </tr>

    <?
    foreach (@$lista as $item) {


        $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);

        $impressao_aso = json_decode($item->cintil);
//
//        echo "<pre>";
//        print_r($impressao_aso);
        ?>


        <tr> 





            <td><?= $data['paciente'][0]->nome; ?></td>
            <td><?= $impressao_aso->tipo; ?></td>
              <td><?= $impressao_aso->sss; ?></td>
        <td> <?= $impressao_aso->fe; ?></td>
        <td><?= $impressao_aso->afibrose; ?></td>
        <td><?= $impressao_aso->aisquemia; ?></td>
        <td><?= $impressao_aso->disfuncao; ?></td>
        <td><?= $impressao_aso->tergometrico; ?></td>
        <td><?= $impressao_aso->outrosachados; ?></td>



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
