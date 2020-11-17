<html>
    <head>
        <title></title>
        <meta charset="utf-8">
        <style>
            td{
                font-family: arial;
            }
        </style>
    </head>
    <body>
        <?php
//        echo "<pre>";
//        print_r($paciente);
//        die;
        ?>
        <table border="0"  style="width: 100%; height: 100%;" >
            <tr>
                <td colspan="2" width="25%" ><img width="30%" style="padding: 7%;" src="<?=base_url()?>upload/empresalogocheckout/logo.jpg" ></td>
                <!-- <td  style="text-align: center;font-size: 15px; " >Nº Cartão <u>000<?= @$paciente_id ; ?></u></td> -->
            </tr>
            <tr>
                <td  style="text-align: center;" colspan="2" >
                    <b>TERMO DE DECLARAÇÃO <?= @$empresa[0]->razao_social; ?></b>
                </td>
            </tr>
            <tr>                
                <td  style="text-align: left;" colspan="2" >
                    Eu, <?
                    $this->session->userdata('nome_titular');
                    ?>  ,
                </td>
            </tr>

            <tr>                
                <td  style="text-align: left;" colspan="2" >
                    Brasileiro(a), estado civil 
                    <?php
                        echo "________";
                    
                    ?> ,Profissão 
                    <?php 
                        echo "________________________________";
                    
                    ?>,

                </td>
            </tr>
            <tr>
                <td colspan="2">portador do RG nº <?
                    
                        echo "___________________________";
                    
                    ?>
                    , e do CPF nº <?php
                    echo $this->session->userdata('cpf_titular');
                    ?>,
                </td>
            </tr>
            <tr>
                <td colspan="2"> <?
//                    if (@$paciente[0]->cidade_desc != "") {
//                        echo "<u>" . @$paciente[0]->cidade_desc . "</u>";
//                    } else {
//                        echo "___________________________";
//                    }
                    ?>
                    Estado do <?
                    $this->session->userdata('estado_titular');
                    ?>  nascido em  <?php
                    $this->session->userdata('nascimento_titular');
                    ?>, residente nesta cidade,  na rua</td>
                
                 
            </tr>

            

            <tr>
                <td colspan="2">
<?=
$this->session->userdata('logradouro_titular').' '.$this->session->userdata('numero_titular');
?>

                    , bairro <?=
                    $this->session->userdata('bairro_titular');
?> , cep <?php
                   echo $this->session->userdata('cep_titular');
                    ?>, Telefone <?php
                    echo $this->session->userdata('celular_titular');
                    ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:justify;">DECLARO, para fins de comprovação junto com 
                    <b>Associação Marabaense de Apoio e Amparo à Saúde  <?= "- " . @$empresa[0]->razao_social; ?></b>,
                    que preencho os requisitos informados pela entidade para receber os benefícios ofertados na qualidade de 
                    Associado Beneficiário. Afirmo, portante, que minha renda mensal é menor ou igual a 60% do teto de benefíos 
                    do Regime Geral da Previdência Social.<br>
                    Declaro, estar ciente que a entidade poderá requisitar a qualquer tempo os documentos que compravem as declarações
                    supra.<br>
                    Declaro ainda, que tive ciência que até a aprovação definitiva da minha solicitação - restarei em status de concessão provisória
                    e caso seja negado meu requerimento, me será devolvido o valor inicialmente pago(R$ 60,00) sem prejuízo das consultas ou exames 
                    realizados até a data de resposta.


                </td>
            </tr>
            <tr   >
                <td colspan="2" >&nbsp;</td>
            </tr>

            <tr  >
                <td colspan="2" ><?
                    if (@$empresa[0]->municipio != "") {
                        echo @$empresa[0]->municipio . ' - ' . @$empresa[0]->estado;
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
                    ?> <?= "<u>" . date('d') . "</u>" ?> de <?
                    switch (date("m")) {
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
                    ?> de <?= date('Y'); ?>



                </td>
            </tr>

            <tr >
                <td  colspan="2"> &nbsp;</td>
            </tr>

            <tr>
                <td  colspan="2"> _____________________________________________</td>
            </tr>
            <tr>
                <td  colspan="2"> Assinatura</td>
            </tr>


        </table>

    </body>
</html>
