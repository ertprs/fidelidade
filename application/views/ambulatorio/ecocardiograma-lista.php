 

<meta charset="utf-8">


<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }


</style>
<h3>Ecocardiograma</h3>
<table border="0">

    <tr> 
        <td><b>Paciente</b></td>
        <td><b>Diametro diast VE </b></td>
        <td><b>Diametro sist VE </b></td>
        <td><b>Esp diast septo IV </b></td>
        <td><b>Esp diast PP VE</b></td>
        <td><b>Massa VE </b></td>
        <td><b>Diametro diast VI </b></td>
        
        <td><b>Diametro sist AE</b></td>
        <td><b>Diametro Ao </b></td>
        <td><b>FE</b></td>
        <td><b>%enc sist (AD)</b></td>
        <td><b>VDFVE </b></td>
        <td><b>VSFVE</b></td>
        <td><b>Cavidades/<b></td>
        <td><b>Contratilidade VE</b></td>
        <td><b>Válvulas</b></td>
        <td><b>Aorta</b></td>
        <td><b>Pericardio</b></td>
        <td><b>Conclusão</b></td>




    </tr>

    <?
//echo "<pre>";
//print_r(@$lista);


    foreach (@$lista as $item) {


        $data['paciente'] = $this->paciente->listarpacienteholter($item->paciente_id);

        $impressao_aso = json_decode($item->ecocardio);

//        echo "<pre>";
//        print_r($impressao_aso);
        ?>


        <tr> 





            <td><?= $data['paciente'][0]->nome; ?></td>
            
            <td><b><?= $impressao_aso->diastve; ?></b></td>
        <td><b><?= $impressao_aso->sistve; ?></b></td>
        <td><b><?= $impressao_aso->diastve; ?></b></td>
        <td><b><?= $impressao_aso->diastppve; ?></b></td>
        <td><b><?= $impressao_aso->massave; ?></b></td>
        <td><b><?= $impressao_aso->diastvi; ?></b></td>
        <td><b><?= $impressao_aso->sistae; ?></b></td>
        <td><b><?= $impressao_aso->ao; ?></b></td>
        <td><b><?= $impressao_aso->fe; ?></b></td>
        <td><b><?= $impressao_aso->sistad; ?></b></td>
        <td><b><?= $impressao_aso->vdfve; ?></b></td>
        <td><b><?= $impressao_aso->vsfve; ?></b></td>
        <td><b><?= $impressao_aso->cavidades; ?></b></td>
        <td><b><?= $impressao_aso->contratilidade; ?></b></td>
        <td><b><?= $impressao_aso->valvulas; ?></b></td>
        <td><b><?= $impressao_aso->aorta; ?></b></td>
        <td><b><?= $impressao_aso->pericardio; ?></b></td>
        <td><b><?= $impressao_aso->conclusao; ?></b></td>



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
        $exame_id = $item->agenda_exames_id;
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
