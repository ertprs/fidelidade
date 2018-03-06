<meta charset="UTF-8">
<style>
    .div-chave{
    transform: scale(.75,.75);  
    /*-ms-transform: scale(.75,.75);*/  
    /*-webkit-transform: scale(.75,.75);*/  
    /*transform: scale(3,1);*/
    /*height: 200px;*/
    }
   
    
    @font-face {
    font-family: 'Lucida-Sans-Unicode';
    src:url('<?= base_url() ?>/css/fonts/lucida/Lucida-Sans-Unicode.ttf.woff') format('woff'),
        url('<?= base_url() ?>/css/fonts/lucida/Lucida-Sans-Unicode.ttf.svg#Lucida-Sans-Unicode') format('svg'),
        url('<?= base_url() ?>/css/fonts/lucida/Lucida-Sans-Unicode.ttf.eot'),
        url('<?= base_url() ?>/css/fonts/lucida/Lucida-Sans-Unicode.ttf.eot?#iefix') format('embedded-opentype'); 
    font-weight: bolder;
    font-style: normal;
}
</style>
<div class="div-chave">
    <table style="background-color:#011F51;color: white;font-weight: bold;border-spacing: 12px;" border="0">

        <tbody>
            <tr>
                <td rowspan="3"><img style="width: 150px;" src="<?= base_url() ?>img/dez/soudez.png"></td>
                <td style="text-align: center;font-family: 'Showcard Gothic';font-size: 15pt;" rowspan="2">CATEGORIA <br> <?=$dependente[0]->contrato?></td>
                <td style="font-family: 'Aharoni';">NOME</td>
                <td style="font-family: 'Lucida-Sans-Unicode';background-color: #4aa6bf;border-radius: 10px;border-color: #4e95a9;border-width: 3px;border:6px solid #4e95a9;"><?= $dependente[0]->paciente ?></td>
            </tr>
            <tr>
                <!--<td><img style="width: 120px;" src="<?= base_url() ?>img/dez/soudez.png"></td>-->
                <!--<td>CATEGORIA <br> ESPECIAL</td>-->
                <td style="font-family: 'Aharoni';font-size: 18px;">CPF</td>
                <?
                $parte_um = substr($dependente[0]->cpf, 0, 3);
                $parte_dois = substr($dependente[0]->cpf, 3, 3);
                $parte_tres = substr($dependente[0]->cpf, 6, 3);
                $parte_quatro = substr($dependente[0]->cpf, 9, 2);

                $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";
                ?>
                <td style="font-weight: bold;font-family: 'Lucida-Sans-Unicode' ;background-color: #4aa6bf;border-radius: 10px;border-color: #4e95a9;border-width: 3px;border:6px solid #4e95a9;"><?= $monta_cpf ?></td>
            </tr>
            <tr>
                <td style="text-align: center;font-family: 'Aharoni';"></td>
                <td style="text-align: center;font-family: 'Aharoni';" colspan="3">DEPENDENTES</td>
                <!--<td></td>-->
                <!--<td></td>-->
            </tr>
            <tr>
                <td colspan="2"><img style="height:200px;width: 320px" src="../../../img/dez/centro.png"></td>
                <!--<td></td>-->
                <td style="background-color: #4aa6bf;border-radius: 10px;" colspan="2">
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

                            <span style="font-family: 'Lucida-Sans-Unicode' ;color: red">+</span> <?= $item->paciente ?> <br>
                            CPF: <?=$monta_cpf?>
                            <br>

                        <?
                        }
                    }
                    ?>
</td>          <!--<td></td>-->
            </tr>
            <tr>
                <td style="text-align: left;font-family: 'Lucida-Sans-Unicode';" colspan="4">
                    &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-style: italic; font-size: 10pt;"> Emissão : 20/10/2017</span>
                </td>  
            </tr>
        </tbody>
    </table>
</div>