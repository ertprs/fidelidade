<?
//echo "<pre>";
//print_r($exame);
?>
<html>
    <head>
        <title>
            Ficha 13 -  Mamografia
        </title>
        <meta charset="utf-8">
    </head>
    <body>



        <?
        $empresa_id = $this->session->userdata('empresa_id');
        @$data['cabecalho'] = $this->guia->listarcabecalho($empresa_id);
        ?> 


        <style>
            .table{
                margin-left: auto;
                margin-right: auto;
                width: 100%;
                text-align: center;
            }
            td{

                font-family: arial;

            }.botar_esquerda{
                float: left;


            }
        </style>


        <table border='0'  class="table" >
            <tr>
                <td colspan="3"  ><p style=""><?= @$data['cabecalho'][0]->cabecalho ?></p></td>
            </tr>
            <tr style="text-align: center;">
                <td colspan="3" ><p style=""> QUESTIONARIO CLÍNICO - MAMOGRAFIA E RESSONÂNCIA MAGNÉTICA DAS MAMAS</p></td>
            </tr>
            <tr>
                <td colspan="3"><p style="">&nbsp;</p></td>
            </tr>
            <tr>
                <td style="text-align: right;"  >PACIENTE: </td>
                
                <td style="text-align: left;"><p style="">
                        <?
                        if (@$exame[0]->paciente) {
                            echo $exame[0]->paciente; echo "&nbsp;&nbsp;";
                        } else {
                            ?>__________________________________________________
                            <?
                        }
                        ?>
                    </p></td>
                <td style="text-align: left;"><p style="">PEDIDO:____________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></td>

            </tr>
            <tr>
                <td colspan="3"  ><p style="">&nbsp;</p></td>
            </tr>
            <tr>
                <td  style="text-align: right;"  >SOLICITANTE:</td>
                <td colspan="0" style="text-align: left;"  ><p style="">
                        
                         <?
                        if (@$exame[0]->paciente) {
                            echo $exame[0]->medico_solicitante; echo "&nbsp;&nbsp;";
                        } else {
                            ?>__________________________________________________
                            <?
                        }
                        ?>
                      </p></td>
                
                  <td style="text-align: left;"><p style="">  DATA:
                          <?
                      if (@$exame[0]->data_autorizacao) {
                          ?>
                          <?php echo substr(@$exame[0]->data_autorizacao, 8, 2) . '/' . substr(@$exame[0]->data_autorizacao, 5, 2) . '/' . substr(@$exame[0]->data_autorizacao, 0, 4); ?>
                          <?
                      }else{
                          ?> 
                          ___/___/_______&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
                      <? }?>
                
                
                
            </tr>
            <tr>
                <td colspan="3"><p style="">&nbsp;</p></td>
            </tr>
            <tr>
                <td colspan="3"><p style="">EXAME SOLICITADO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAMOGRAFIA(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM DE MAMAS(&nbsp;&nbsp;&nbsp;)</p></td>
            </tr>

        </table>
        <table border=1 cellspacing=0 cellpadding=2 bordercolor="666633" class='table'>
            <tr>
                <td   style="border-bottom:none;"><p style="float: left;"   >TROUXE EXAME ANTERIORES?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;&nbsp;)</p></td>
            </tr>
            <tr >
                <td style="border-top:none;"><p style="float: left;"   >(&nbsp;&nbsp;&nbsp;) MAMOGRAFIA - DATA__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;)US - DATA__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;)RM - DATA__/__/____</p></td>
            </tr>
            <tr>
                <td><p style="float: left;">ESTÁ GRÁVIDA?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;)SIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;)NÃO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AMAMENTANDO?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;)SIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)NÃO</p></td>
            </tr>

            <tr>
                <td style="border-bottom:none;" > <p style="float: left;">HISTÓRICO FAMILIAR&nbsp;&nbsp;&nbsp;POSITIVA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NEGATIVA(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td style="border-top:none;" ><p style="border-top:none;" class="botar_esquerda"  >MÃE(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IRMÃ(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVÓ(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FILHA(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IDADE:_______   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAMA(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OVÁRIO(&nbsp;&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td style="border-bottom:none;" ><p class="botar_esquerda"   >CIRURGIA ANTERIOR&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</td>
            </tr>
            <tr>
                <td style="border-top:none;border-bottom:none;"  ><p  class="botar_esquerda">CIRURGIA REDUTORA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;DATA:__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIÓPSIA CIRURGICA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/____</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;border-bottom:none;" ><p class="botar_esquerda">QUADRANTECTOMIA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/_____&nbsp;&nbsp;&nbsp;&nbsp;MASTECTOMIA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/____</p></td>
            </tr>
            <tr>
                <td   style="border-top:none;border-bottom:none;" ><p class="botar_esquerda">RECONSTRUÇÃO(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/_____</p></td>
            </tr>
            <tr>
                <td style="border-top:none;"   ><p class="botar_esquerda">MÚSCULO ABDOMINAL(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;MÚSCULO DORSAL(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;PRÓTESE(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td  style="border-bottom:none;" ><p class="botar_esquerda">PRÓTESE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;border-bottom:none;" ><p class="botar_esquerda">SUSPEITA DE RUPTURA&nbsp;&nbsp;SIM(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DOLOROSA&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td   style="border-top:none;" ><p class="botar_esquerda">TROCA PRÉVIA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>

            <tr>
                <td  style="border-bottom:none;" ><p class="botar_esquerda">MOTIVO DO EXAME:&nbsp;&nbsp;&nbsp;&nbsp;PREVENÇÃO(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;DIAGNÓSTIVO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td   style="border-top:none;border-bottom:none;" ><p class="botar_esquerda">APALPA ALGUM NÓDULO&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;MAMA DIREITA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;MAMA ESQUERDA(&nbsp;&nbsp;)</p></td>
            </tr>

            <tr>
                <td  style="border-top:none;border-bottom:none;"  ><p class="botar_esquerda">BIOPSIA PERCUTÂNEA (CORE BIOPSY,MAMOTOMIA)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;) &nbsp;DATA:__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;" ><p class="botar_esquerda">QUAL:_____________________________________________DIAGNÓSTICO:_______________________________________</p></td>
            </tr>
            <tr>
                <td style="border-bottom:none;"  ><p class="botar_esquerda">TRATAMENTO DE CANCER DE MAMA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td style="border-top:none;border-bottom:none;"  ><p class="botar_esquerda">RADIOTERAPIA(&nbsp;&nbsp;) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QUIMIOTERAPIA(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;DATA:__/__/____</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;" ><p class="botar_esquerda">TAMOXIFEN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td style="border-bottom:none;" ><p class="botar_esquerda">DATA DA ÚLTIMA MESTRUAÇÃO (DUM)__/__/____&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MENOPAUSA: SIM(&nbsp;&nbsp;)&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;border-bottom:none;" ><p class="botar_esquerda">USA ANTICONCEPCIONAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIM(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;)&nbsp;&nbsp;QUANTO TEMPO:_________________________</p></td>
            </tr>
            <tr>
                <td  style="border-top:none;" ><p class="botar_esquerda">FAZ REPOSIÇÃO HORMONAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SIM(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;NÃO(&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;QUANTO TEMPO:_______________________________</p></td>
            </tr> 


        </table>


        <table class="table" border='0'  >
            <tr>
                <td colspan="2"> <p class="botar_esquerda">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORTALEZA,<?= @date('d'); ?>/<?= @date('m'); ?>/<?= @date('Y'); ?></p></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                <td  style="text-align: right;" >Assinatura (paciente ou responsável):</td>
                <td style="text-align: left;"  > ________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="2"  ><img src="<?= base_url() ?>img/mamografiaimg.png" ></td>
            </tr> 

        </table>




    </body>
</html>