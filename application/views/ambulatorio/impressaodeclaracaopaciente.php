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
                <td width="25%" ><img width="90%" style="padding: 7%;" src="<?= base_url() . "upload/empresalogo/" . @$empresa_id . "/" . @$arquivo_pasta[0] ?>" ></td>
                <td  style="text-align: center;font-size: 15px; " >Nº Cartão___________________</td>
            </tr>

            <tr>

                <td  style="text-align: center;" colspan="2" >
                    <b>TERMO DE DECLARAÇÃO <?= @$empresa[0]->razao_social; ?></b>
                </td>
            </tr>
            <tr>                
                <td  style="text-align: left;" colspan="2" >
                    Eu, <?
                    if (@$paciente[0]->nome != "") {
                        echo "<u>" . @$paciente[0]->nome . "</u>";
                    } else {
                        echo "__________________________________";
                    }
                    ?>  ,
                </td>
            </tr>

            <tr>                
                <td  style="text-align: left;" colspan="2" >
                    Brasileiro(a), estado civil 
                    <?php
                    if (@$paciente[0]->estado_civil_id == 0) {
                        echo "________";
                    } elseif (@$paciente[0]->estado_civil_id == 1) {
                        echo "<u>Solteiro</u>";
                    } elseif (@$paciente[0]->estado_civil_id == 2) {
                        echo "<u>Casado</u>";
                    } elseif (@$paciente[0]->estado_civil_id == 3) {
                        echo "<u>Divorciado</u>";
                    } elseif (@$paciente[0]->estado_civil_id == 4) {
                        echo "<u>Viuvo</u>";
                    } elseif (@$paciente[0]->estado_civil_id == 5) {
                        echo "<u>Outros</u>";
                    } else {
                        
                    }
                    ?> ,Profissão 
                    <?php if (@$paciente[0]->descricao != "") {
                        ?>

                        <?= @"<u>" . @$paciente[0]->descricao . "</u>" ?>

                        <?php
                    } else {
                        echo "________________________________";
                    }
                    ?>,

                </td>
            </tr>
            <tr>
                <td colspan="2">portador do RG nº <?
                    if (@$paciente[0]->rg != "") {
                        echo "<u>" . @$paciente[0]->rg . "</u>";
                    } else {
                        echo "___________________________";
                    }
                    ?>
                    , e do CPF nº <?php
                    $nbr_cpf = @$paciente[0]->cpf;

                    @$parte_um = substr($nbr_cpf, 0, 3);
                    @$parte_dois = substr($nbr_cpf, 3, 3);
                    @$parte_tres = substr($nbr_cpf, 6, 3);
                    @$parte_quatro = substr($nbr_cpf, 9, 2);

                    @$monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

//echo $monta_cpf;


                    if (@$nbr_cpf != "") {
                        echo "<u>" . @$monta_cpf . "</u>";
                    } else {
                        echo "_______________";
                    }
                    ?>,
                </td>
            </tr>
            <tr>
                <td colspan="2">abaixo natural de <?
                    if (@$paciente[0]->cidade_desc != "") {
                        echo "<u>" . @$paciente[0]->cidade_desc . "</u>";
                    } else {
                        echo "___________________________";
                    }
                    ?>
                    , no Estado do <?
                    if (@$paciente[0]->estado != "") {
                        echo "<u>" . @$paciente[0]->estado . "</u>";
                    } else {
                        echo "_________________________";
                    }
                    ?></td>
            </tr>

            <tr>
                <td colspan="2"> nascido em  <?php
                    if (@$paciente[0]->nascimento != "") {
                        echo "<u>" . date('d/m/Y', strtotime(@$paciente[0]->nascimento)) . "</u>";
                    } else {
                        echo "__/___/_____";
                    }
                    ?>, residente nesta cidade,  na rua</td>
            </tr>

            <tr>
                <td colspan="2">
<?
if (@$paciente[0]->logradouro != "") {
    echo "<u>" . @$paciente[0]->logradouro;
    echo " ";
    echo @$paciente[0]->numero . "</u>";
} else {
    echo "___________________________________";
}
?>

                    , bairro <?
                    if (@$paciente[0]->bairro != "") {
                        echo "<u>" . @$paciente[0]->bairro . "</u>";
                    } else {
                        echo "_________________________";
                    }
?> , cep <?php
                    if (@$paciente[0]->cep != "") {
                        echo "<u>" . @$paciente[0]->cep . "</u>";
                    } else {

                        echo "_______________";
                    }
                    ?>, Telefone <?php
                    if (@$paciente[0]->celular == "") {
                        @$telefone = $paciente[0]->telefone;
                    } else {
                        @$telefone = $paciente[0]->celular;
                    }
                    echo "<u>" .
                    @$telefone
                    . "</u>";
                    if (@$telefone == "") {
                        echo "_____________";
                    }
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
                    if (@$paciente[0]->cidade_desc != "") {
                        echo @$paciente[0]->cidade_desc;
                    } else {
                        echo "____________________";
                    }
                    ?> ,
                    <?
                    if (@$paciente[0]->estado != "") {
                        echo @$paciente[0]->estado;
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
