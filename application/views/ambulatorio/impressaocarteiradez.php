<meta charset="UTF-8">
<div>
    <table style="background-color:#011F51;color: white;font-weight: bold;border-spacing: 12px; " border="0">

        <tbody>
            <tr>
                <td rowspan="2"><img style="width: 100px;" src="<?= base_url() ?>img/dez/soudez.png"></td>
                <td style="text-align: center;" rowspan="2">CATEGORIA <br> ESPECIAL</td>
                <td>Nome:</td>
                <td style="background-color: #00AAE7;border-radius: 10px;border-color: #66afe9;border-width: 3px;border:5px solid #67B3FF;"><?= $dependente[0]->paciente ?></td>
            </tr>
            <tr>
                <!--<td><img style="width: 120px;" src="<?= base_url() ?>img/dez/soudez.png"></td>-->
                <!--<td>CATEGORIA <br> ESPECIAL</td>-->
                <td >CPF:</td>
                <?
                $parte_um = substr($dependente[0]->cpf, 0, 3);
                $parte_dois = substr($dependente[0]->cpf, 3, 3);
                $parte_tres = substr($dependente[0]->cpf, 6, 3);
                $parte_quatro = substr($dependente[0]->cpf, 9, 2);

                $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
                ?>
                <td style="background-color: #00AAE7;border-radius: 10px;border-color: #66afe9;border-width: 3px;border:5px solid #67B3FF;"><?= $monta_cpf ?></td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="4">DEPENDENTES</td>
<!--                <td></td>-->
                <!--<td></td>-->
            </tr>
            <tr>
                <td style="background-color: #00AAE7;border-radius: 15px;text-align: center;border-color: #66afe9;border:5px solid #67B3FF;" colspan="2">Central  de <br> Atendimento <br>
                    (85) 3276.1883</td>
                <!--<td></td>-->
                <td style="background-color: #00AAE7;border-radius: 10px;" colspan="2">
                    <?
                    foreach ($dependente as $item) {
                        if ($item->situacao == 'Dependente') {
                            ?>
                            <?
                            $parte_um = substr($item->cpf, 0, 3);
                            $parte_dois = substr($item->cpf, 3, 3);
                            $parte_tres = substr($item->cpf, 6, 3);
                            $parte_quatro = substr($item->cpf, 9, 2);

                            $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
                            ?>

                            <span style="color: red">+</span> <?= $item->paciente ?> <br>
                            CPF: <?=$monta_cpf?>
                            <br>

                        <?
                        }
                    }
                    ?>
</td>          <!--<td></td>-->
            </tr>
            <tr>
                <td style="text-align: center;" colspan="4">
                    Emissão : 20/10/2017
                </td>  
            </tr>
        </tbody>
    </table>
</div>