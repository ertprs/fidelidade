   

<meta charset="utf-8">


<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }


</style>
<h3>MAPA</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
        <td><b>Medidas</b></td>
        <td><b>PAS Vigília</b></td>
        <td><b>PAD Vigília</b></td>
        <td><b>PAS Sono</b></td>
        <td><b>PAD Sono</b></td>
        <td><b>Sistólico</b></td>
        <td><b>Distólico</b></td>
        <td><b>Conclusão</b></td>
    </tr>

    <?
    foreach (@$lista as $item) {


        $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);

        $impressao_aso = json_decode($item->mapa);
//
//        echo "<pre>";
//        print_r($impressao_aso);
        ?>


        <tr> 
 
            <td><?= $data['paciente'][0]->nome; ?></td>
            <td><?= $impressao_aso->medidas; ?></td>
            <td><?= $impressao_aso->pasvigilia; ?></td>
            <td><?= $impressao_aso->padvigilia; ?></td>
            <td><?= $impressao_aso->passono; ?></td>
            <td><?= $impressao_aso->padsono; ?></td>
            <td><?= $impressao_aso->sistolico; ?></td>
            <td><?= $impressao_aso->distolico; ?></td>
            <td><?= $impressao_aso->conclusao; ?></td>
 
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
