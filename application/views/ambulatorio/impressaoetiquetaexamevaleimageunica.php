<meta charset="UTF-8">
<div class="" style="margin-left: 30px;">


<?foreach($examesGrupo as $key => $valor){?>
    <table>
        <tbody>
        
        <tr>
            <td  ><font size = -2><b><?= $paciente['0']->nome; ?> - <?= $exame[0]->guia_id; ?></b></td>
            <td ><font size = -2></td>
        </tr>
        <tr>
            <td  ><font size = -2><?= $exames[0]->medicosolicitante; ?></td>
            <td ><font size = -2></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr>
                <td ><font size = -2><?= $exame[0]->procedimento ?> </td>
            </tr>
            
            
        </tbody>
    </table>
    <table>
        <tr>
            <!-- Como a variavel $item tá sendo definida ali no foreach, da pra usar aqui -->
            <!-- <td  ><font size = -2> - </td> -->
            <td  ><font size = -2> <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>
        </tr>
    </table>
    <br>
    <br>
    <!-- <br> -->
<?}?>   
</div>
