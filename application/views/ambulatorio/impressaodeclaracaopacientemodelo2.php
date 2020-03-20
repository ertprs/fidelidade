<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <style>
            td{
                font-family: arial;
            }
            .cor_vermelha{
                color: red;
                font-size: 13px;
            }
            .maior{
                font-size: 15px !important;
            }
            .letramenor{
                font-size: 13px;
            }
            .quebrar_pagina{
                page-break-before: always
            }
            .cabecalho{
                font-size: 22px;
            }

        </style>
    </head>
    <body>
        <?php
//        echo "<pre>";
//        print_r($paciente);
//        die;
        ?>
        <table border="0">
        <tr >
         <td>
            <table>
                <tr><td class='cor_vermelha'>“Tudo podemos em Deus, pois Ele nos fortalece"</td></tr>
                <tr><td class='cor_vermelha'>Filipenses 4:13</td><tr>
                <tr><td class='cor_vermelha'></td></tr>
                <tr><td class='cor_vermelha maior'>Nós já aderimos a Código de Ética dos Corretores de Seguros</td></tr>
            </table>
         </td>
         <!-- align="right" -->
         <td>
             <table>
                <tr><td style="width:150px"><img style="width:80%" src="<?= base_url() . "upload/empresalogo/" . @$empresa_id . "/" . @$arquivo_pasta[0] ?>" ></td></tr>
             </table>
         </td>
        </tr>
        </table>

        <table class="letramenor">
        <tr>
        <td>De acordo com o texto, o valor máximo de indenização do é de R$ 10.000,00, a ser pago em casos de morte ou invalidez total permanente.</td>
        </tr>
        </table>


        <table border="1" align="center" style="width:100%;" class="letramenor" CELLSPACING="0" CELLPADDING="2">
           <tr>
            <th>Danos Corporais Totais <br> Repercussão na Íntegra do Patrimônio Físico</th>
            <th >Percentual <br> da Perda</th>
           <tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de ambos os membros superiores ou inferiores</td>
           <td rowspan="9" align="center">100</td>
           </tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de ambas as mãos ou de ambos pés</td>
           </tr>
           
           <tr>
           <td>Perda anatômica e/ou funcional completa de um membro superior e de um membro inferior</td>
           </tr>
                      
           <tr>
           <td>Perda completa da visão em ambos os olhos (cegueira bilateral) ou cegueira legal bilateral</td>
           </tr>
                      
           <tr>
           <td>Lesões neurológicas que cursem com: (a) dano cognitivo-comportamental</td>
           </tr>
                      
           <tr>
           <td>alienante; (b) impedimento do senso de orientação espacial e/ou do livre</td>
           </tr>
                      
           <tr>
           <td>deslocamento corporal; (c) perda completa do controle esfincteriano; (d)</td>
           </tr>
                      
           <tr>
           <td>comprometimento de função vital ou autonômica</td>
           </tr>
                      
           <tr>
           <td>Lesões de orgãos e estruturas crânio-faciais, cervicais, torácicos, abdominais <br>
           pélvicos ou retro-peritoneais cursando com prejuizos funcionais não compensáveis <br>
           de ordem autonômica, respiratória, cardiovascular, digestiva, excretora ou de <br>
           qualquer outra espécie, desde que haja comprometimento de função vital</td>
           </tr>

           <tr>
            <th>Danos Corporais Segmentares (Parciais) <br> Repercussão em Partes de Membros Superiores e Inferiores</th>
            <th>Percentuais <br> da Perda</th>
           <tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de um dos membros superiores e/ou <br>
           de uma das mãos</td>
           <td rowspan="2" align="center">70</td>
           </tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de um dos membros inferiores</td>
           </tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de um dos pés</td>
           <td align="center">50</td>
           </tr>

           <tr>
            <td> Perda completa de mobilidade de um dos ombros, cotovelos, punhos ou dedo <br> polegar</td>
            <td rowspan="2" align="center">25</td>
           </tr>

           <tr>
           <td>Perda completa da mobilidade de um quadril, joelho ou tornozelo</td>
           </tr>

           <tr>
            <td> Perda anatômica e/ou funcional completa de qualquer um dentre os outros dedos da <br> mão</td>
            <td rowspan="2" align="center">10</td>
           </tr>

           <tr>
           <td>Perda anatômica e/ou funcional completa de qualquer um dos dedos do pé</td>
           </tr>

           <tr>
           <th>Danos Corporais Segmentares (Parciais) <br> Outras Repercussões em Orgãos e Estruturas Corporais</th>
           <th>Percentuais das Perdas</th>
           </tr>

           <tr>
           <td>Perda auditiva total bilateral (surdez completa) ou da fonação (mudez completa) ou <br>
           da visão de um olho</td>
           <td align="center">50</td>
           </tr>
           <tr>

           <td>Perda completa da mobilidade de um segmento da coluna vertebral exceto o sacral</td>
           <td align="center">25</td>
           </tr>
                      
           <tr>
           <td>Perda integral (retirada cirúrgica) do baço</td>
           <td align="center">10</td>
           </tr>
        </table>

        <table class="letramenor">
        <tr>
        <td>No caso de invalidez parcial, a tabela dá a cada parte do corpo um percentual diferente. Assim, para saber como dar entrada, fique por
            dentro desses valores para ter uma ideia do que poderá receber.<br></td>
        </tr>

        <tr>
        <td>É importante destacar, contudo, que no caso de invalidez parcial, ficará a cargo do médico que atender a vítima determinar a
            porcentagem da indenização. Para entender essa conta, considere o seguinte exemplo:<br></td>
        </tr>

        <tr>
        <td>Suponha que João se envolveu em um acidente, e perdeu o movimento de um dos braços. Ele terá direito a 70% do valor total de R$
            10.000,00 ou seja, R$ 7.000,00.</td>
        </tr>
        </table>

            <div class="quebrar_pagina"><div>

            
            <!-- CABEÇALHO -->
        <table align="center">
        <tr><td><img style="width:150px" src="<?= base_url() . "upload/empresalogo/" . @$empresa_id . "/" . @$arquivo_pasta[0] ?>" ></td></tr>
        <table>

        <!-- CORPO -->
        <table  style="width:100%;">
            <tr>
                <th align="center" class="cabecalho"><u> TERMO DE USO CARTÃO SALUTE </u></th>
            </tr>

            <tr>
            <td>
            Pelo presente instrumento particular, as partes 
            <b><?= $empresa[0]->nome?></b>, 
            situada na <?= $empresa[0]->logradouro.', '.$empresa[0]->numero?>
            <?if($empresa[0]->complemento == '' OR $empresa[0]->complemento == NULL){
                    echo ', ';
                }else{
                    echo ', '.$empresa[0]->complemento .',';
                }?>
            
            bairro <?= $empresa[0]->bairro.', '.$empresa[0]->municipio.'/'.$empresa[0]->estado.', CEP:'.$empresa[0]->cep.', '?>
            inscrita no CGC/CNPJ  <?= $empresa[0]->cnpj?>, 
            doravante denominada  <b>CONTRATADA </b>,
            neste ato representada, pelo seu Diretor Presidente e, 
            de outro lado doravante denominado  <b>CLIENTE/ASSOCIADO </b>:            
            </td>
            </tr>

            <tr>
            <td>
            Eu,<b><u> <?= $paciente[0]->nome?> </b></u>, Brasileiro(a), estado civil <u>__________</u>, 
            Profissão <u><? if($paciente[0]->descricao == ''){echo _______________} else{ echo $paciente[0]->descricao }?></u>, portador do RG nº <u>5278977</u>, 
            e do CPF nº <u>797.763.025-72</u>, Estado do <u>PARA</u> nascido em <u>15/03/1989</u>, 
            residente nesta cidade, na <u>rua SOL POENTE 123</u>, bairro <u>CIDADE NOVA</u>, 
            cep <u>68503-630</u>, Telefone <u>94 991321105</u>
            </td>
            </tr>
        </table>



    </body>
</html>
