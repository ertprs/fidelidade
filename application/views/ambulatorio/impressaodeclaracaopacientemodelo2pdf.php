
        <meta charset="utf-8">
        <style>
            td{
                font-family: arial;
            }
            .cor_vermelha{
                color: red;
                font-size: 14px;
            }
            .maior{
                font-size: 14px !important;
            }
            .letramenor{
                font-size: 14px;
            }
            .quebrar_pagina{
                page-break-before: always
            }
            .cabecalho{
                font-size: 19px !important;
            }
            .letramenor2{
                  font-size: 14px;
            }
        </style>

    <body>
           
           
        <table align="center">
        <tr><td><img style="width:150px" src="<?=base_url()?>upload/empresalogocheckout/logo.jpg" ></td></tr>
        </table>

        
        <table  style="width:100%;"  class='letramenor'>
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
            inscrita no CGC/CNPJ  
            <?
                        $nbr_cnpj = @$empresa[0]->cnpj;
        
                        @$parte_um = substr($nbr_cnpj, 0, 2);
                        @$parte_dois = substr($nbr_cnpj, 2, 3);
                        @$parte_tres = substr($nbr_cnpj, 5, 3);
                        @$parte_quatro = substr($nbr_cnpj, 8, 4);
                        @$parte_cinco = substr($nbr_cnpj, 12, 2);
            
                        @$monta_cnpj = "$parte_um.$parte_dois.$parte_tres/$parte_quatro-$parte_cinco";
            
            
            
                        if (@$nbr_cnpj != "") {
                            echo "<u>" . @$monta_cnpj . "</u>";
                        } else {
                            echo "_______________";
                        }
            ?>, 
            doravante denominada  <b>CONTRATADA </b>, neste ato representada, pelo seu Diretor Presidente e, 
            de outro lado doravante denominado <!-- <b>CLIENTE/ASSOCIADO </b>: --> <br><br>       
            </td>
            </tr>

            <tr>
            <td>
            <b>CLIENTE/ASSOCIADO </b><!-- Eu, --><u> <?= $this->session->userdata('nome_titular'); ?> </u>,<!-- Brasileiro(a),--> <b>estado civil</b>
             ________, 
            <b>Profissão</b>  _______________________
            <b>portador do RG nº</b>  ______________________  
            <b>e do CPF nº </b><u><?=
            $cpf_titular = $this->session->userdata('cpf_titular');
            ?></u>,
            <b>Estado do </b> <u> <?=$this->session->userdata('estado_titular');?></u>
            <b>nascido em </b>
                <u><?= $this->session->userdata('nascimento_titular') ?></u>,
            <b>residente nesta cidade, na </b> <u><?= $this->session->userdata('logradouro_titular').' '.$this->session->userdata('numero_titular');?></u>,
            <b> bairro </b><u><?=$this->session->userdata('bairro_titular')?></u>, 
            <b>cep </b><u><?= $this->session->userdata('cep_titular')?>, </u>
            <b>Telefone </b>
            <u><?= $this->session->userdata('celular_titular')?>, </u>
            </td>
            </tr>

            <tr>
            <td>
            <br>
            <b><u>Dependentes</u></b>
            <br>
                    
            </td>
            </tr>

            <tr align='center'>
            <td>
            <i>Têm entre si, justo e acordado o presente contrato, regido pelas seguintes <br>cláusulas: </i>
           
            </td>
            </tr>

            <tr>
            <td align='justify'>
            <b>Art. 1º</b> Serão oferecidos ao CLIENTE/ASSOCIADO, através do presente contrato de adesão,
            convênios com empresas de prestação de serviços e produtos nas áreas de saúde, educação,
            lazer, esportes, seguros, alimentação, dentre outros, sob custos reduzidos pelo uso do Cartão
            SALUTE
            </td>
            </tr>

            <tr>
            <td align='justify'>
             <b>§1º</b> A Salute intermediará a relação entre cliente e empresas conveniadas. 
              
            </td>
            </tr>

            <tr>
            <td align='justify'>
             <b>§2º</b> O CLIENTE/ASSOCIADO, no momento da celebração do presente contrato, declara ter
            recebido lista com o nome das empresas conveniadas com o Cartão SALUTE. Declara ainda estar
            ciente de que eventuais mudanças na lista de prestadores de serviços conveniados serão
            informadas no sítio eletrônico oficial da CONTRATADA. 
            </td>
            </tr>

            <tr>
            <td align='justify'>
            <b>§3º</b> Terão acesso aos parceiros conveniados, conforme especificação de cada plano (ANEXO I),
            o CLIENTE/ASSOCIADO e seu grupo familiar, considerado: pais do titular, cônjuge, filhos e netos
            até os 21 anos, desde que não seja ultrapassado o limite do plano escolhido (ANEXO I), e de
            que estes sejam devidamente inscritos no ato da assinatura do presente contrato.
            </td>
            </tr>
        </table>
 
 
       
        <table  style="width:100%;"  class='letramenor'> 
            
            <tr>
            <td align='justify'>
            <b>§4º</b> Para fins deste contrato, será utilizado na especificidade de cada plano o entendimento de
            grupo familiar descrito acima. Excepcionalmente, será aceita a inscrição dos sogros do
            CLIENTE/ASSOCIADO como beneficiários, mas sob nenhuma hipótese será admitida a inscrição
            de tios, sobrinhos e demais familiares.  
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>§5º</b> Somente terá direito aos serviços de descontos e vantagens propostos pela CONTRATADA
            junto as empresas conveniadas o CLIENTE/ASSOCIADO adimplente com suas obrigações
            financeiras.  
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>Art. 2º</b> O CLIENTE/ASSOCIADO optará sobre o PLANO de sua preferência, por este obrigar-se-
            á, a pagar as obrigações assumidas. Será dada ainda autorização, conforme sua opção de
            pagamento.
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>Parágrafo único:</b> A inadimplência resultará em suspensão do presente contrato, a partir do
            sexagésimo dia sem pagamento.
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>Art. 3º</b> – O presente contrato terá validade conforme a opção do plano escolhido. Haverá
            renovação automática, excetuando-se esta, caso o CLIENTE faça manifestação expressa
            pleiteando o cancelamento do vínculo.  
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>§1º</b> Poderá o CLIENTE/ASSOCIADO rescindir o presente contrato sem qualquer ônus dentro do
            prazo de 07 (sete) dias contados da data da assinatura em qualquer unidade da SALUTE. 
            </td>
            </tr>
            <tr>
            <td align='justify'>
            <b>§2º</b> No caso de rescisão imotivada antes do período contratado, o CONTRATANTE arcará com
            multa rescisória equivalente a 50% (cinquenta por cento) sobre o valor da soma das parcelas
            vincendas. 
            </td>
            </tr>
            <tr>
            <td align='justify'>
            <b>§3º</b> A renovação do presente contrato se dará tacitamente por prazo adicional igualmente ao
            contratado.
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>§4º</b> O valor da mensalidade será reajustado anualmente, na proporção da variação do INPC. <br> 
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>§5º </b>É de inteira responsabilidade do CLIENTE/ASSOCIADO, manter a empresa, ora
            CONTRATADA - SALUTE informada sobre quaisquer alterações no seu cadastro pessoal e
            familiar.  
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>§6º</b> O Cartão SALUTE não se responsabiliza pelas informações pessoais fornecidas pelos clientes
            associados no momento da adesão, reservando-se ao direito de regresso, em caso de fraude. 
            </td>
            </tr>
            
            <tr>
            <td align='justify'>
            <b>Art. 4º</b> – O CLIENTE/ASSOCIADO declara estar ciente e de acordo com as cláusulas do presente
            contrato. Declara estar ciente ainda de que <b>tudo que usar ou comprar, será pago ao
            prestador conveniado diretamente, assegurando apenas os preços e descontos que
            constem nas informações no site e em seus materiais de divulgação. </b>
            </td>
            </tr>
        </table>

       


    <table  style="width:100%;"  class='letramenor'>
    

    <tr>
    <td align='justify'>
    <b>Art.5º</b> O presente contrato deverá ser devidamente interpretado 
    de acordo com as regras previstas no Código do Consumidor.
    </td>
    </tr>

    <tr>
    <td align='justify'>
    <b>Parágrafo único:</b> Nesta ocasião, o cliente associado 
    recebe uma via do contrato de adesão firmado entre as partes.  
    </td>
    </tr>

    <tr>
    <td align='justify'>
    <b>Art.6º</b> As partes elegem exclusivamente o foro da comarca de 
    Marabá, com renúncia expressa de qualquer outro, por mais 
    privilegiado que seja, para dirimir questões oriundas deste.  
    </td>
    </tr>

    <tr>
    <td align='justify'>
    Estando ambas em comum acordo e cientes dos direitos e 
    obrigações adquiridas por este termo, assinam na presença 
    de duas testemunhas.  
    </td>
    </tr>

        <tr>
                <td align='right'><?
                    if (@$empresa[0]->municipio != "") {
                        echo @$empresa[0]->municipio;
                    } else {
                        echo "____________________";
                    }
                    ?> ,
                    <?
                    if (@$empresa[0]->estado != "") {
                        echo @$empresa[0]->estado;
                    } else {
                        echo '__________________';
                    }
                    ?> <? 
                    $nbr_data_cadastro = date('Y-m-d');
                        //2020-01-01
                        @$ano = substr($nbr_data_cadastro, 0, 4);
                        @$mes_data = substr($nbr_data_cadastro, 5, 2);
                        @$dia = substr($nbr_data_cadastro, 8, 2);

                   echo "<u>" . $dia . "</u>"; ?> de <?
                    switch ($mes_data) {
                        case "01": $mes = "Janeiro";
                            break;
                        case "02": $mes = "Fevereiro";
                            break;
                        case "03": $mes = "Março";
                            break;
                        case "04": $mes = "Abril";
                            break;
                        case "05": $mes = "Maio";
                            break;
                        case "06": $mes = "Junho";
                            break;
                        case "07": $mes = "Julho";
                            break;
                        case "08": $mes = "Agosto";
                            break;
                        case "09": $mes = "Setembro";
                            break;
                        case "10": $mes = "Outubro";
                            break;
                        case "11": $mes = "Novembro";
                            break;
                        case "12": $mes = "Dezembro";
                            break;
                    }

                    echo "<u>" . @$mes . "</u>";
                    ?> de <?= $ano; ?>
                    <br><br><br>
                </td>
        </tr>

        <tr>
        <td align='center'> ______________________________________</td>
        </tr>
        <tr>
        <td align='center'> <b><?= $empresa[0]->nome?> <br>  CNPJ 
        <?
                        $nbr_cnpj = @$empresa[0]->cnpj;
                        //30.869.446/0001-18
                        @$parte_um = substr($nbr_cnpj, 0, 2);
                        @$parte_dois = substr($nbr_cnpj, 2, 3);
                        @$parte_tres = substr($nbr_cnpj, 5, 3);
                        @$parte_quatro = substr($nbr_cnpj, 8, 4);
                        @$parte_cinco = substr($nbr_cnpj, 12, 2);
            
                        @$monta_cnpj = "$parte_um.$parte_dois.$parte_tres/$parte_quatro-$parte_cinco";
            
            //echo $monta_cpf;
            
            
                        if (@$nbr_cnpj != "") {
                            echo @$monta_cnpj;
                        } else {
                            echo "_______________";
                        }
            ?> <br> CONTRATADA</b> <br>
            <b> (assinado digitalmente)</b><br><br><br></td>
        </tr>

        <tr>
        <td align='center'><b>__________________________________________ <br>
                 CONTRATANTE:<br>
                            NOME: <?=$this->session->userdata('nome_titular')?><br><br>
                            CPF: <?=$this->session->userdata('cpf_titular')?> <br><br>
                             
        </b></td>
        </tr>

        <tr>
        <td align='justify'>
        <i>Em testemunho da verdade, assinam as testemunhas: </i>
        </td>
        </tr>

        <tr>
        <td><b>
        I – NOME: <br> 
        RG/CPF:
        </b><br><br> </td>
        </tr>

        <tr>
        <td><b>
        II – NOME: <br> 
        RG/CPF:
        </b></td>
        </tr>
    </table> 
    

    <table style="width:100%;"  class='letramenor'>
    
    <tr>
    <td colspan="2" align='center' style="border:1px solid black;"> <b>ANEXO I – OPÇÃO DE PLANO</b><br></td>
    </tr>

    <tr>
    <td colspan="2" align='justify'><b>Art.1º</b> - O CLIENTE/ASSOCIADO SALUTE optará pelo plano escolhido, marcando um X no espaço
    da opção desejada:

        <br><br>
        <center><b>1 - SALUTE INDIVIDUAL:</b> Plano único para o cliente, sem beneficiários por 12 meses.</center>
        <br>
    
        <b>BENEFÍCIOS:</b> I - Acesso a todos os benefícios listados; II - UMA consulta gratuita por ano
        (CLÍNICA MÉDICA). <b>OPÇÕES DE PAGAMENTO:</b> I – <b>RECORRÊNCIA NO CARTÃO DE
        CRÉDITO:</b> Taxa de Adesão em R$30,00 e 12 mensalidades de R$30,00; II - <b>CARTÃO DE
        CRÉDITO</b> - Taxa de Adesão em R$24,90 e o valor R$298,80 (total, parcelado em 12X de R$
        24,90); III – <b>PLANO PRÉ-PAGO TRIMESTRAL:</b> Adesão em R$30,00 e o plano no valor de
        R$90,00. Se renovado, após os 3 meses, o cliente não pagará a adesão, ficando R$90,00 por
        mais três meses.

        <br><br>
        <center><b>2 – SALUTE CASAL:</b> Plano anual SALUTE para o casal + 1 filho.</center>
        <br>

        <b>BENEFÍCIOS:</b> I – Acesso a todos os benefícios do cartão SALUTE; II – DUAS consultas
        GRATUITAS por ano (CLÍNICA MÉDICA). <b>OPÇÕES DE PAGAMENTO:</b> I – <b>RECORRÊNCIA NO
        CARTÃO DE CRÉDITO:</b> Taxa de Adesão em R$45,00 e 12 parcelas mensais de R$ 45,00; II-
        <b>CARTÃO DE CRÉDITO</b> - Taxa de Adesão em 39,90 e o parcelamento do total de R$ 478,80 em
        12X de 39,90; <b>III-PLANO PRÉ PAGO TRIMESTRAL:</b> Adesão em R$45,00 e o plano no valor
        de R$135,00 válido por três meses, sendo que na renovação o cliente não paga adesão, assim
        ficará (se renovado) o valor de R$135,00 por mais três meses.

        <br><br>
        <center><b>3 – SALUTE FAMÍLIA:</b> Plano anual; um titular + 5 dependentes (conjugue e grupo familiar).</center>
        <br>

        <b>BENEFÍCIOS:</b> I – Acesso a todos os benefícios do cartão SALUTE; II – DUAS consultas
        GRATUITAS por ano (CLÍNICA MÉDICA). <b>OPÇÕES DE PAGAMENTO:</b> I - <b>RECORRÊNCIA NO
        CARTÃO DE CRÉDITO:</b> Taxa de Adesão em R$65,00 e 12 parcelas mensais de R$ 65,00; II-
        <b>CARTÃO DE CRÉDITO:</b> Taxa de Adesão em 59,90 e o parcelamento do total de R$ 718,00 em
        12X de 59,90; <b>III-PLANO PRÉ PAGO TRIMESTRAL:</b> Adesão em R$ 65,00 o valor total de
        R$195,00 válido por três meses, sendo que na renovação o cliente não pagará adesão, assim
        ficará (se renovado) o valor de R$195,00 por mais três meses.


        <br><br>
        <center><b>4 – SALUTE CLEAN:</b> Plano anual básico com casal + 5 filhos (até os 21 anos).</center>
        <br>

        <b>BENEFÍCIOS: I</b> – Acesso somente a REDE CREDENCIADA de atendimento em saúde; II – NÃO
        HÁ COBRANÇA de adesão; III – Sem consultas gratuitas. <b>OPÇÕES DE PAGAMENTO: Somente
        no cartão de crédito. I-PLANO PRÉ PAGO ANUAL 1:</b> Valor de R$ 360,00 em até 6X de
        R$60,00; <b>II-PLANO PRÉ PAGO ANUAL 2:</b> Valor de R$ 240,00 em até 6X de R$40,00.
        <b>VALORES DAS CONSULTAS:</b> clínica médica R$50,00 e Pediatria em R$100,00 (preços
        exclusivos no consultório SALUTE). Os descontos nas consultas de outras naturezas de
        atendimento serão disponibilizados no site da SALUTE.

    </td>
    </tr>

    <tr>
    <td align='center' style="border:1px solid black;"> <b>OPÇÃO DE PLANO:</b> </td>
    <td align='center' style="border:1px solid black;"> <b>FORMA DE PAGAMENTO:</b> </td>
    </tr>

    <tr>
        <td><b>______ PLANO SALUTE INDIVIDUAL</b></td>
        <td><b>____ RECORRÊNCIA NO CARTÃO DE CRÉDITO</b></td>
    </tr>

    <tr>
        <td><b>______ PLANO SALUTE CASAL</b></td>
        <td><b>____ PRÉ PAGO</b></td>
    </tr>

    <tr>
        <td><b>______ PLANO SALUTE FAMÍLIA</b></td>
        <td><b>____ CARTÃO DE CRÉDITO</b></td>
    </tr>

    <tr>
        <td><b>______ PLANO SALUTE CLEAN ANUAL I</b></td>
        <td><b>____ PAGAMENTO À VISTA</b></td>
    </tr>

    <tr>
        <td><b>______ PLANO SALUTE CLEAN ANUAL II * <br>
        * Somente para clientes oriundos Amma Saúde.</b></td>
        <td><b>____ CARTÃO DE DÉBITO PGT À VISTA</b></td>
    </tr>


    </table>


    <table  style="width:100%;"  class='letramenor'> 
    <tr>
    <td align='center' style="border:1px solid black;"> <b>ANEXO II </b><br></td>
    </tr>

    <tr>
    <td align='center'><b>SEGURADORA CONVENIADA – SEGURO DE ACIDENTES PESSOAIS</b>  </td>
    </tr> 
    <tr>
    <td align='justify'><b>Art.1º</b> - Por este termo o CLIENTE/ASSOCIADO adere ao seguro de acidentes pessoais ofertado
    pela empresa SALUTE, a partir de convênio firmado com a seguradora PORTO SEGURO CIA. DE
    SEGUROS GERAIS (05886) Al. Barão de Piracicaba, 618 - Campos Elíseos - São Paulo - CEP
    01216-010 - CNPJ 61.198.164/0001-60, e intermediado pela THOMAZ CORRETORA DE
    SEGUROS, pessoa jurídica de direito privado inscrita regularmente em CNPJ: 00.500.837/0001-
    01 e sediada à Travessa Quintino Bocaiuva, 1127, 3o andar, Belém – PA, Bairro do Reduto, CEP:
    66053-240. </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.2º</b> - A adesão refere a cobertura em <b>Seguro de Acidentes 
    Pessoais Coletivos da Porto Seguro</b>, sendo os serviços 
    à disposição do cliente associado: </td>
    </tr>

    <tr>
    <td align='justify'><b>§1º</b> - O referido seguro, terá um custo <b>per capita</b> incluído na mensalidade do cliente SALUTE
    abrangendo <b>sua pessoa e a composição familiar registrada que detenha CPF</b> (cadastro de
    pessoa física, regular), conforme disposto no termo de condições gerais.</td>
    </tr>

    <tr>
    <td align='justify'><b>§2º</b> - A cobertura refere-se a: morte acidental, 
    invalidez permanente total ou parcial por acidente, conforme a tabela a seguir: </td>
    </tr>
    </table>
    
    
  
  
<table border="1" align="center" style="width:100%; font-size: 12px;" class="letramenor2" CELLSPACING="0" CELLPADDING="2">
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
  <table class="letramenor2">
      <tr>
      <td></td>
      </tr>
      </table>
         
    
 
    
    <table  style="width:100%;" class='letramenor'>
  

    <tr>
    <td align='justify'><b>§ 3º</b> - No caso de invalidez parcial, a tabela dá a cada 
    parte do corpo um percentual diferente. Assim, para saber como dar entrada, 
    observe a tabela de valores para ter uma ideia do que poderá receber. 
    No caso de invalidez parcial, ficará a cargo do médico que atender a 
    vítima determinar a porcentagem da indenização.  </td>
    </tr>

    <tr>
    <td align='justify'><b>§ 4º</b> - Auxílio funeral, com capital segurado de até R$ 3.000,00 (três mil reais) em favor do
grupo familiar cadastrado, para uso de custeio funerário;  </td>
    </tr>

    <tr>
    <td align='justify'><b>§ 5º</b> - Cesta básica alimentar, no valor de 
    R$ 300,00 (trezentos reais) por período de 06 (seis) meses.  </td>
    </tr>

    <tr>
    <td align='justify'><b>§ 6º</b> - A presente modalidade de seguro não consta apólice, sendo sua cobertura a exata
    transcrição dos tópicos anteriores.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.3º</b> - O limite de idade estabelecido para fins de cadastro e cobertura em seguro de acidentes
pessoais neste contrato é de no mínimo 16 (dezesseis) anos e máximo 73 (setenta e três) anos.
No seguro funerário a apólice cobrirá o cliente ou dependente em grupo familiar, sem idade
mínima (desde que tenha CPF cadastrado) até os 73 (setenta e três) anos de vida.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.4º</b> - A partir do ato de contratação geral 
    (termo de adesão cliente) se adere igualmente a este seguro 
    ofertado pela citada conveniada. </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.5º</b> - A inclusão do cliente associado SALUTE no rol de segurados se dará com o repasse da
intermediadora à empresa seguradora conveniada em até 24 (vinte e quatro horas) da
assinatura, sendo esta data base de sua admissão e direito a uso do serviço do grupo de
segurados SALUTE </td>
    </tr>
    <tr>
    <td align='justify'><b>Art.6º</b> - O CLIENTE SALUTE para acionar o SEGURO de acidentes pessoais, deve entrar em
        contato <b>diretamente com a SALUTE</b> no contato previsto no rodapé da página.  </td>
    </tr>
    <tr>
        <td align='justify'><b>Art.7º</b> - O serviço de <b>atendimento funerário é disponibilizado pelo contato AUXÍLIO
FUNERAL</b>, constando também no rodapé da página.  </td>
    </tr>

    <tr>
        <td align='center' style="border:1px solid black;"><b>ANEXO III </b> </td>
    </tr>
    <tr>
    <td align='center'><b>ASSISTÊNCIA MÉDICA  </b></td>
    </tr>
    

    <tr>
    <td align='justify'><b>Art.1º</b> - A SALUTE se compromete em cada contrato, 
    fornecer 02 (duas) consultas com o médico clínico geral ao ano, sob o 
    preço do valor mensal.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Parágrafo único:</b> Em havendo necessidade de atendimentos 
    extras com o clínico geral (extrapolando as duas consultas anuais), será 
    obrigatoriamente cobrado o valor de R$ 20,00 (vinte reais) em cada consulta 
    adicional. Estas consultas deverão ser agendadas diretamente na sede da Salute.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.2º</b> - Os atendimentos de saúde realizado nas 
    cínicas credenciadas deverão ser previamente agendadas diretamente 
    nestes estabelecimentos, cabendo ao paciente receber destes o local, 
    a data e o horário do atendimento.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Parágrafo único:</b> A SALUTE não se responsabiliza 
    pela frequência do cliente ou do profissional e ainda pelo atendimento, q
    ue é feito com toda liberalidade pelo profissional conveniado, haja vista, 
    ambas as relações serem diretas entre as partes – somente fazendo a 
    intermediação do valor mais vantajoso ao cliente em teor de ofertar sua 
    rede conveniada de profissionais de saúde.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.3º</b> - As consultas com o clínico geral ofertadas dentro 
    do plano vigente (conforme o artigo 1) terão um prazo inicial de carência em 90 
    (noventa) dias para a primeira consulta e de 180 (cento e oitenta) dias para a 
    segunda consulta, ambas contando após o início de vigência do plano para com o 
    CLIENTE SALUTE.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.4º</b> - Exames, procedimentos e consultas realizadas pela 
    rede credenciada com profissionais de saúde serão pagas diretamente ao 
    estabelecimento que prestará o serviço, sendo facultado ao mesmo estipular o 
    valor de cada procedimento.  </td>
    </tr> 
    </table> 
     
    
    <table  style="width:100%;"  class='letramenor'>
    
    <tr>
    <td align='justify'><b>Art.5º</b> - A SALUTE se compromete em manter atualizada a lista
     de sua rede de saúde conveniada em seu site e/ou aplicativo e tais informações também 
     estarão disponíveis em sua sede, a disposição de qualquer cliente.  </td>
    </tr>
 
    <tr>
        <td align='center' style="border:1px solid black;"><b>ANEXO IV </b></td> 
    </tr>
    <tr>
        <td align='center'><b>CRÉDITO </b></td> 
    </tr>

    <tr>
    <td align='justify'><b>Art. 1º</b> - O cliente SALUTE após a adesão e devidamente 
    autorizado pelo mesmo, poderá ser realizado em favor deste, análise de crédito 
    e, caso aprovado, a SALUTE poderá, se assim desejar o cliente, ofertar lhes 
    créditos pecuniários para diversas finalidades, através de empresa em sua 
    rede conveniada, nesta especificidade.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Parágrafo único:</b> O cliente por meio deste, 
    autoriza desde já, que a SALUTE possa a qualquer tempo lhe ofertar 
    pacotes, programas de crédito, empréstimos e consignados. A Salute 
    somente ofertará a disposição do cliente tal vantagem, cabendo a ele 
    posteriormente decidir livremente em aceitar ou recusar o empréstimo 
    que lhe é disposto.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.2º</b> - Havendo o aceite e o interesse real a 
    oferta de empréstimo, o cliente SALUTE será convidado a conhecer as 
    condições com a conveniada APROVA CRÉDITO que com ele procederá 
    formalização de contrato, liberação de valores e demais disposições 
    desta relação.  </td>
    </tr>

    <tr>
    <td align='justify'><b>Art.3º</b> - A SALUTE é mera intermediadora desta relação, 
    advindo da mesma a prospecção e análise creditória, o empréstimo e demais 
    consequências da relação financeira ficará a cargo da sua conveniada. </td>
    </tr>

    <tr>
        <td>
            <br><br><br><br><br>
            Fale conosco: Vendas (94) 99297 5157, Agendamentos (94) 99132 1149/3018 4840, Financeiro
        (94) 991321153.
        </td>
    </tr>
 
    </table>
    
