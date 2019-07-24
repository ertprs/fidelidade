 
<style>
    b{
        font-weight: normal;
        font-family: Arial, Helvetica, sans-serif;
          font-size:23px;
    }#eeee{
        font-weight: bold;
    }
    td{
        font-family:arial;
        font-size:20px;
    }#negritos{
        font-size: 17px;
    }#tabela2 td{
       font-size:26px;  
    }#tabela2 #negritos{
       font-size:22px;  
    }

</style>
<meta charset="utf-8">
<title>FICHA DE  ACOMPANHAMENTO ANESTÉSICO</title>

<?
foreach ($paciente as $value) {
    $empresa_id = $this->session->userdata('empresa_id');
    @$data['cabecalho'] = $this->solicitacirurgia_m->listarcabecalho($empresa_id);
    ?>
    <table border="1" cellspacing=0 cellpadding=2 bordercolor="666633" width="100%" width="100%" height="" >
        <tr>
            <td colspan='3'  style="border-left:1px solid white;border-top:1px solid white;"> 
                <p style="margin-left:-140px;"><?= @$data['cabecalho'][0]->cabecalho ?></p> 
                <h1 style="margin-left:60px;font-size:24px;"> <b>FICHA DE  ACOMPANHAMENTO ANESTÉSICO</b></h1> 
            </td>  
            <td colspan='6'>
                <b>NOME: <?= @$value->nome; ?></b> <br>
                <b>DATA NASC:  <?php echo substr(@$value->nascimento, 8, 2) . '/' . substr(@$value->nascimento, 5, 2) . '/' . substr(@$value->nascimento, 0, 4); ?>   </b><br>
                <b>LEITO: <?
                    if (@$value->leito == "") {
                        echo "_________________";
                    } else {
                        echo @$value->leito."_______";
                    }
                    ?> 
                </b>
                &nbsp;<b> PRONTUÁRIO: <?= $value->paciente_id; ?> </b><br>
                <b> CONVÊNIO: <?= @$value->convenio; ?></b>  &nbsp;  <b>ATENDIMENTO:________________</b>
            </td>
        </tr>
        <tr>
            <td colspan='6'>
                &nbsp;
            </td>
        </tr>
        <tr>
            <td><b>DATA:</b></td>  
            <td><b>IDADE:</b>  
                <?
                $data = $value->nascimento;
                // separando yyyy, mm, ddd
                list($ano, $mes, $dia) = explode('-', $data);
                // data atual
                $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                // Descobre a unix timestamp da data de nascimento do fulano
                $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
                // cálculo
                $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                echo "$idade Anos";
                ?>
            </td>
            <td><b>SEXO:</b>
                <?
                if ($value->sexo == "M") {
                    echo "Masculino";
                } elseif ($value->sexo == "F") {
                    echo "Feminino";
                } else {
                    echo "Outro";
                }
                ?>
            </td>
            <td><b>PESO:</b></td>
            <td colspan="2"><b>ALTURA:</b></td>
        </tr>
        <tr>
            <td><b>PRESSÃO ARTERIAL:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>  
            <td><b>PULSO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><b>RESPIRAÇÃO:</b></td>
            <td><b>TEMPERATURA</b></td>
            <td colspan="2"><b>UREIA</b></td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid white;"><b>TIPO SANGÚINEO:</b></td>  
            <td><b>HEMÁCIAS:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><b>HEMOGLOBINA:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><b>HEMATÓCRITO:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><b>GLICEMIA:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom:1px solid white;"><b>OUTROS:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan="" style="border-top:1px solid white;">&nbsp;</td>  
            <td colspan="4" >&nbsp;</td> 
            <td colspan="" style="border-top:1px solid white;">&nbsp;</td>  
        </tr>

        <tr>
            <td colspan="2"><b>AP. RESPIRATÓRIO:</b></td>  
            <td colspan="2"><b>ASMA:</b></td>
            <td colspan="2"><b>BRONQUITE:</b></td>
        </tr>


        <tr>
            <td colspan="2"><b>AP. CIRCULATÓRIO:</b></td>  
            <td colspan="4"><b>ELETROCARDIOGRAMA:</b></td>
        </tr>



        <tr>
            <td colspan="2" ><b>AP. DIGESTIVO:</b> &nbsp; &nbsp; &nbsp;</td>  
            <td colspan="2"><b>DENTES:</b> &nbsp; &nbsp; &nbsp;</td>
            <td colspan="1"><b>PESCOÇO:</b> &nbsp; &nbsp; &nbsp;</td>
            <td colspan=""><b>AP. URINÁRIO:</b> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; </td>
        </tr>



        <tr>
            <td colspan="1" ><b>ESTADO MENTAL:</b></td>  
            <td colspan="" ><b>ATARAXICOS:</b></td>
            <td colspan="2" ><b>CORTICÓIDES:</b></td>
            <td colspan="" ><b>ALERGIA:</b></td>
            <td colspan="" ><b>HIPOTENSORES:</b> &nbsp; &nbsp; &nbsp;</td>
        </tr>

        <tr>
            <td colspan="2"><b>DIAGNÓSTICO PRÉ-OPERATÓRIO:</b> </td>  
            <td colspan="2"><b>ESTADO FÍSICO:</b> </td>
            <td colspan="2"><b>RISCO:</b> </td>
        </tr>


        <tr>
            <td colspan="2"><b>ANESTESIAS ANTERIORES:</b> </td>  
            <td colspan="2"><b>MEDICAÇÃO PRÉ-ANESTÉSICA:</b> </td>
            <td colspan="1"><b>HORAS:</b> </td>
            <td colspan="1"><b>EFEITO:</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
        </tr>



        <tr>
            <td colspan="2">&nbsp;</td>  
            <td colspan="2">&nbsp;</td>
            <td colspan="1">&nbsp;</td>
            <td colspan="1">&nbsp;</td>
        </tr>





        <tr>
            <td colspan="6">HORÁRIO:</td>        
        </tr>


        <style>
            .foo { writing-mode: sideways-lr; }
            #quadrinhos{


                border:1px solid black;
                width: 30px; 
                height:30px;
                margin-left: 100px;
            }#quadrinhos2{

                border:1px solid black;
                width: 30px; 
                height:30px;
                margin-left: 131px;




            }#quadrinhos3{

                border:1px solid black;
                width: 30px; 
                height:30px;
                margin-left: 131px;


            }

        </style>

        <tr>
            <td colspan="4"  style="text-align: center; border-bottom:none; border-top:none;">
                <img style=" "  width="90%" height=""  src="<?php echo base_url(); ?>img/pequena2.png">
                <div class="foo" style="text-align: center; border-bottom:none; border-top:none; margin-top: -240px; ">
                    AGENTES ANESTÉSICOS 
                </div> 
            </td>     
            <td colspan="2" style="text-align: center; border-bottom:none;border-top:none;" ><b id="eeee"> INDUÇÃO
                </b>
                <div><br>
                    Satisf.:________ Exit.:________ Tosse:_______ <br><br><br>
                    Laringo espasmos:____________ Lenta:______ <br><br><br>
                   Náuseas:____________ Vômitos:____________<br><br>
                </div>
            </td>     
        </tr>
        <tr>
            <td colspan="1" style="text-align: center; border-bottom:none; border-top:none; border-right:none;" >&nbsp;</td>     
            <td colspan="3" style="text-align: center; border-bottom:none;border-top:none; border-right:none;border-left:none;" >&nbsp;</td>     
            <td colspan="2" style="text-align: left; border-top:none;"> &nbsp;&nbsp;Outros:___________________________________</td>     
        </tr>
        <tr>
            <td colspan="4">LIQUÍDOS:</td>   
            <td colspan="4" style="text-align: center;border-bottom: none;" ><b style=" font-weight: bold; " >MANUNTENÇÃO</b></td>   
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; border-bottom:none; border-top:none;">   
                <img  width="94%" height=""  src="<?php echo base_url(); ?>img/tras2.png" style="margin-top:21px;">
                <div class="foo" style="text-align: center; border-bottom:none; border-top:none; margin-top:-650px;">
                    CÓDIGOS:V Pressão Arterial;O-Pulso;O-Respiração:AX-Anestesia:O-Operação  
                </div>
            </td>     
            <td colspan="2" style="text-align: center; border-bottom:none;border-top:none;margin-top:-390px;" >
                <b id="eeee"> </b>
                <div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    Anestesia Satisf.: Sim_________ Não________ <br><br>
                   &nbsp;&nbsp; Se não, porque?___________________________<br><br> 
                    <b id="eeee"> DESPERTAR</b><br>
                    Reflexos na SO:__________________________<br>
                    Obstr.:_________ Co2:_________ Excit:_______<br>
                    Náuseas:____________ Vômitos:____________ 
                </div> 
            </td>     
        </tr>
        <tr>
            <td colspan="3" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>SÍMBOLOS E ANOTAÇÕES:</b></td>     
            <td colspan="1" style="text-align: left; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     
            <td colspan="2" style="text-align: left; border-bottom:1px solid white; border-top:1px solid white;">&nbsp;&nbsp;Outros:______________________</td>     
        </tr>
        <tr>
            <td colspan="3" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>POSIÇÃO:</b></td>     
            <td colspan="1" style="text-align: left; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid black;" >CÂNULAS:</td>     
            <td colspan="2" style="text-align: left; border-bottom:1px solid white; border-top:1px solid white;">&nbsp;&nbsp;Com Cânula</td>     
        </tr>
        <tr>
            <td colspan="1" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>AGENTES:</b></td>     
            <td colspan="3" style="text-align: center; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     
            <td colspan="2" style="text-align: left; border-bottom:1px solid white; border-top:1px solid white;">&nbsp;&nbsp;Para o Leito: Sim____ Não____</td>     
        </tr>
        <tr>
            <td colspan="1" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>TÉCNICA:</b></td>     
            <td colspan="3" style="text-align: center; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     

            <td colspan="2" style="text-align: left; border-bottom:1px solid white; border-top:1px solid white; text-align: center;"><b id="eeee"> CONDIÇÕES</b> </td>     
        </tr>
        <tr>
            <td colspan="1" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>OPERAÇÃO:</b></td>     
            <td colspan="3" style="text-align: center; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     
            <td colspan="2" style="text-align: center; border-bottom:1px solid white; border-top:1px solid white;">_______________________________________</td>     
        </tr>
        <tr>
            <td colspan="1" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>CIRURGIÕES:</b></td>     
            <td colspan="3" style="text-align: center; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     
            <td colspan="2" style="text-align: center; border-bottom:1px solid white; border-top:1px solid white;">_______________________________________</td>     
        </tr>

        <tr>
            <td colspan="1" style="text-align: left; border-bottom:1px solid white; border-top:1px solid black; border-right:1px solid white;" ><b>ANESTESIOLOGISTAS</b></td>     
            <td colspan="3" style="text-align: center; border-bottom:1px solid white;border-top:1px solid black; border-right:1px solid white;border-left:1px solid white;" >&nbsp;</td>     
            <td colspan="2" style="text-align: center; border-bottom:1px solid white; border-top:1px solid white;">_______________________________________</td>     
        </tr>
        <tr>
            <td colspan="3"  style="border-bottom:1px solid white;"><b>JUSTIFICATIVA:</b></td> 
            <td colspan="1"><b>PERDA SANGÚINEA:</b></td> 
        </tr>
         <tr>
            <td colspan="4" style="border-top:1px solid white;">&nbsp;</td>     
        </tr> 
    </table>
    <?
}
?> 
 
<table id="tabela2"  border=1 cellspacing=0 cellpadding=2 bordercolor="666633" width="100%" width="100%" height="" style="page-break-before: always;">
    <tr>
        <td style='text-align: center; background-color: silver;'><b id="negritos" >MEDICAMENTOS</b></td>    
        <td style='text-align: center;  background-color: silver;'><b id="negritos"  >QTD</b></td>  
        <td style='text-align: center;  background-color: silver;'><b id="negritos"  >MEDICAMENTOS</b></td>    
        <td style='text-align: center;  background-color: silver;'><b id="negritos"  >QTD</b></td> 
        <td style='text-align: center;  background-color: silver;'><b id="negritos"   >MEDICAMENTOS</b></td>    
        <td style='text-align: center;  background-color: silver;'><b  id="negritos"  >QTD</b></td> 
    </tr>  
    <tr>
        <td> Adrenalina amp </td>
        <td> </td>
        <td> Esmeron 50mg/ ml FR</td>
        <td> </td>
        <td> Succitrat-Suxamet 100mg FR </td>
        <td> </td>
    </tr>
    <tr>
        <td>Água Destilada amp </td>
        <td> </td>
        <td> Ethamolin amp</td>
        <td> </td>
        <td> Sufenta 1/2ml amp </td>
        <td> </td>
    </tr>

    <tr>
        <td>Albamina Humana FR</td>
        <td> </td>
        <td> Fenergan 50mg amp</td>
        <td> </td>
        <td> Sulf. Magnésio 50/10% amp </td>
        <td> </td>
    </tr>

    <tr>
        <td>Amicacina 500mg/ 2ml amp </td>
        <td> </td>
        <td>Fentanil 2/5 amp</td>
        <td> </td>
        <td>  Superam 25mg amp</td>
        <td> </td>
    </tr>

    <tr>
        <td>Aminofilina 4mg/ ml amp </td>
        <td> </td>
        <td> Flagyl 5mg/ ml Bs</td>
        <td> </td>
        <td> Tenoxican 40/20mg FR </td>
        <td> </td>
    </tr>



    <tr>
        <td>Forene Ml FR</td>
        <td> </td>
        <td>Forane ML FR</td>
        <td> </td>
        <td> Thiopental 0,5g/ 1mg FR </td>
        <td> </td>
    </tr>

    <tr>
        <td>Antak 25mg/ ml amp </td>
        <td> </td>
        <td>   Glicose 50/25% amp</td>
        <td> </td>
        <td> Toradol 30mg/ ml amp </td>
        <td> </td>
    </tr>

    <tr>
        <td>Aramin 10mg/ ml amp </td>
        <td> </td>
        <td> Gluco de Cálcio 10% amp</td>
        <td> </td>
        <td> Tracrium 25/50mg amp </td>
        <td> </td>
    </tr>

    <tr>
        <td> Atropina 0,25mg/ ml amp</td>
        <td> </td>
        <td>Heparina 5000Ul/ml amp</td>
        <td> </td>
        <td> Tramal 50/100mg amp </td>
        <td> </td>
    </tr>     
    <tr>
        <td> Bextra 40mg FR</td>
        <td> </td>
        <td>  Hypnomidate Amp </td>
        <td> </td>
        <td>  Transamin 250mg amp</td>
        <td> </td>
    </tr>     
    <tr>
        <td>Bicarb. Sódio 10/8,4% amp </td>
        <td> </td>
        <td> lpsilon 1/4g FR</td>
        <td> </td>
        <td>  Tridil 5mg/ ml amp</td>
        <td> </td>
    </tr>
    <tr>
        <td>Bridion</td>
        <td> </td>
        <td> Kanakion 10mg/ ml amp  </td>
        <td> </td>
        <td> Ultiva 1/2mg amp </td>
        <td> </td>
    </tr> 
    <tr>
        <td> Buscopan Composto amp</td>
        <td> </td>
        <td>  Kefazol 1g FR  </td>
        <td> </td>
        <td>  Vitamina C 100mg/ ml amp </td>
        <td> </td>
    </tr>     
    <tr>
        <td>Buscopan Simples amp </td>
        <td> </td>
        <td> Keflin 1g FR </td>
        <td> </td>
        <td> Voluven 60mg/ ml Ms </td>
        <td> </td>
    </tr>

    <tr>
        <td>Cefoxitina 1g FR </td>
        <td> </td>
        <td> Ketalar Ml </td>
        <td> </td>
        <td> Xylestesin 5ml 2% amp </td>
        <td> </td>
    </tr>

    <tr>
        <td> Cipro 200/ 400mg Bs</td>
        <td> </td>
        <td>  Lanexat amp</td>
        <td> </td>
        <td>  Xylestesin 10% FR </td>
        <td> </td>
    </tr>

    <tr>
        <td> Clexane SER</td>
        <td> </td>
        <td> Lasix 20mg amp </td>
        <td> </td>
        <td> Xylocaína C/A S/A 2% FR</td>
        <td> </td>
    </tr>
    <tr>
        <td> Clonidin 150mcg/ml amp</td>
        <td> </td>
        <td> Narcan amp </td>
        <td>  </td>
        <td style='text-align: center; background-color:silver;
            '><b id="negritos" >HEMODERIVADOS</b></td> 
        <td>  </td>
    </tr>
    <tr>
        <td> Clonidin 150mcg/ml amp</td>
        <td> </td>
        <td> Narcan amp </td>
        <td> </td>
        <td> Concentrado de Hem. Filt. un </td>
        <td> </td>
    </tr>
    <tr>
        <td>Decadron 4mg/ ml amp</td>
        <td> </td>
        <td>  Naropin 0,75mg/ 1,0mg amp</td>
        <td> </td>
        <td> Concentrado de Hemac. un </td>
        <td> </td>
    </tr>
    <tr>
        <td>Difenidramia amp</td>
        <td> </td>
        <td>Nausedron 4/8mg amp</td>
        <td> </td>
        <td>  Crioprecipitado un</td>
        <td> </td>
    </tr>
    <tr>
        <td>Dimorf 0,2mg amp </td>
        <td> </td>
        <td> Neocaína S/A C/A FR </td>
        <td> </td>
        <td  >Concentrado de Plaquetas un</td> 
        <td> </td>
    </tr>

    <tr>
        <td>Dimorf 10mg/ 2mg amp </td>
        <td> </td>
        <td> Neocaína Isobárica 4ml amp</td>
        <td> </td>
        <td>  Concent. Plaquetas Filtra un </td>
        <td> </td>
    </tr>
    <tr>
        <td>Dipirona 1g amp </td>
        <td> </td>
        <td> Neocaína Pesada amp </td>
        <td> </td>
        <td> Plasma Fresco Congel.un   </td>
        <td> </td>
    </tr>
    <tr>
        <td>Diprivan amp</td>
        <td> </td>
        <td>Nexium 40mg FR</td>
        <td> </td>
        <td style='text-align: center; background-color:silver;
            '><b id="negritos"   >MATERIAIS</b></td> 
        <td> </td>
    </tr>
    <tr>
        <td> Diprivan PFS 1/2 % SER</td>
        <td> </td>
        <td> Nimbium 10/20g amp </td>
        <td> </td>
        <td> Abocath nº un  </td>
        <td> </td>
    </tr>

    <tr>
        <td> Diprospan 5mg+2mg/ml amp</td>
        <td> </td>
        <td> Nipride 50m FR</td>
        <td> </td>
        <td> Agulha p/Peridural un </td>
        <td> </td>
    </tr>

    <tr>
        <td> Dobutamina 250/ ml amp</td>
        <td> </td>
        <td>  Norapinefrina 8mg ml amp </td>
        <td> </td>
        <td>Agulha p/Raqui un </td>
        <td> </td>
    </tr>
    <tr>
        <td> Dolantina 100mg amp</td>
        <td> </td>
        <td>Norcuron 4mg/ 1ml amp</td>
        <td> </td>
        <td>Agulha Stimuplex un </td>
        <td> </td>
    </tr>
    <tr>
        <td>Dopamina 50mg amp</td>
        <td> </td>
        <td>Nubain 10mg/ ml amp</td>
        <td> </td>
        <td> Catéter Peridural un</td>
        <td> </td>
    </tr>
    <tr>
        <td>Dorminid 5/15 amp</td>
        <td> </td>
        <td>Pancurônio 2mg/ ml amp</td>
        <td> </td>
        <td> Contiplex nº un</td>
        <td> </td>
    </tr>
    <tr>
        <td>Dramin B6 amp</td>
        <td> </td>
        <td> Pantozol 40mg FR</td>
        <td> </td>
        <td> Equipo p/ Bomba de Inf. un</td>
        <td> </td>
    </tr>
    <tr>
        <td>Dropediral 2,5mg amp  </td>
        <td> </td>
        <td>Plamet 10mg amp </td>
        <td> </td>
        <td  > Equipo c/ Injetor Lat. un</td> 
        <td> </td>
    </tr>

    <tr>
        <td>Efedrin 50mg/ ml amp </td>
        <td> </td>
        <td>  	Plasil 10mg amp </td>
        <td> </td>
        <td> Equipo Fotossensível un  </td>
        <td> </td>
    </tr>

    <tr>
        <td> Efortil 10mg amp</td>
        <td> </td>
        <td>  Precedex FR</td>
        <td> </td>
        <td> Equipo Simples un </td>
        <td> </td>
    </tr>

    <tr>
       <td style='  text-align: center;background-color:silver;
            ' ><b id="negritos" >SOROS </b></td>
        <td> </td>
        <td>Profenid 100mg FR </td>
        <td> </td>
        <td> Extensor 20/60/120 cm   </td>
        <td> </td>
    </tr>

    <tr>
        <td> Frutose 5% </td>
        <td> </td>
        <td>  Propovan amp</td>
        <td> </td>
        <td> Fita p/Análise de GLicemia un </td>
        <td> </td>
    </tr>

    <tr>
        <td> Manitol 20%</td>
        <td> </td>
        <td>  Prostigmine 0,5mg/ m amp</td>
        <td> </td>
        <td> Kit Transdutor de Pressão un  </td>
        <td> </td>
    </tr>

    <tr>
        <td>Soro Fisiolófico 0,9% 500ml </td>
        <td> </td>
        <td>  Protanima 1000UI/ ml amp </td>
        <td> </td>
        <td>  Máscara Laríngea nº un </td>
        <td> </td>
    </tr>

    <tr>
        <td  > Soro Fisiológico 0,9% 250ml    </td>
        <td> </td>
        <td>  Rapifen 5ml amp</td>
        <td> </td>
        <td> Perfusor 20/60/120 cm  </td>
        <td> </td>
    </tr>

    <tr>
        <td> Soro Glicofisiológico 1:1 500ml </td>
        <td> </td>
        <td>  Rocefin 1g FR</td>
        <td> </td>
        <td> Presep un</td>
        <td> </td>
    </tr>

    <tr>
        <td> Soro Glicosado 500ml  </td>
        <td> </td>
        <td> Sevorane/ Sevocris ml</td>
        <td> </td>
        <td>  Scalp un  </td>
        <td> </td>
    </tr>


    <tr>
        <td  >  Soro Ringer c/ Lactado 500ml</td>
        <td> </td>

        <td>   Solu-cortef 100/500mg FR</td>
        <td> </td>
        <td> Sensor Bis un  </td>
        <td> </td>
    </tr>

    <tr>
        <td style='background-color:silver;
            text-align: center; ' ><b id="negritos" >USO DE APARELHOS </b></td>
        <td> </td>
       <td style='  text-align: center; background-color:silver; 
            ' ><b id="negritos"
           >GASES</b></td>
        <td> </td>
        <td>  Sensor Flotrac un </td>
        <td> </td>

    </tr>
    <tr>
        <td > Analisador de Gases H(s)</td>
        <td> </td>
        <td> 	Ar comprimido H(s)   </td>
        <td> </td>
        <td>    	Sonda Asp. Trap.un</td>
        <td> </td>

    </tr>
    <tr>
        <td >  Capnógrafo H(s) </td>
        <td> </td>
        <td>  	O2 H(s)</td>
        <td> </td>
        <td> Sonda Endotraq. un  </td>
        <td> </td>

    </tr>
    <tr>
        <td >Monitor Cardíaco H(s)  </td>
        <td> </td>
        <td> N2O H(s)  </td>
        <td> </td>
        <td>  	Sonda Nasogástrica un </td>
        <td> </td>

    </tr>
    <tr>
        <td >Oxímetro de Pulso H(s) </td>
        <td> </td>
        <td   >   </td>
        <td> </td>
        <td>  Torneira 3 vias un   </td>
        <td> </td>

    </tr>
    <tr> 
        <td > SURGICEL</td>
        <td> </td>
        <td   >    </td>
        <td> </td>
        <td>  </td>
        <td> </td>
    </tr>
    <tr>
        <td > SURGIFLOR </td>
        <td> </td>

        <td> </td>
        <td> </td>
        <td> </td>
        <td> </td>
    </tr>
    <tr>
        <td >GELFOAN </td>
        <td> </td> 
        <td>  </td>
        <td> </td>
        <td>    </td>
        <td> </td>
    </tr>
 
    
   
    <tr>
        <td colspan="6" style='text-align: center; background-color: silver;
            '><b id="negritos" >JUSTIFICATIVAS</b></td> 
    </tr> 

    <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr>
    <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr> 
    <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr>  
     <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr> 
     <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr> 
     <tr>
        <td colspan="6" style=' '>&nbsp;   </td>    
    </tr> 
    <tr>
        <td colspan="6" style='border-bottom:none;'>&nbsp;  </td>    
    </tr>
 
</table>
<br>
<br><br><br>  
<table  width="100%">
    <tr>
        <td colspan="3" style=" border-bottom:none;border-left: none;   ">
            Assinatura do Anestesista:______________________________________________</td>
        <td colspan="0" style="font-size:17px;border-bottom:1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b  style="font-weight: bold;font-size:12px;"  > ELABORAÇÃO:</b>
            <br>Dr.João Flávio(Jun/1997)</td>
        <td colspan="0" style="  font-size:17px;border-bottom:1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b  style="font-weight: bold;font-size:12px;"  >VALIDAÇÃO:</b>
            <br>Dr. Francisco Monteiro (Jun/1997)
        </td>
        <td colspan="0" style=" font-size:17px;border-bottom:1px solid black;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b  style="font-weight: bold;font-size:12px;"  >REVISÃO:</b>
            <br>Dr. João Flávio (Nº 04-Jan/16)
        </td>
    </tr>
</table>