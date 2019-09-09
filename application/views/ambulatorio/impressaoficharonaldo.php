<style>
    td{
        font-size: 17px;
        font-family: arial;
    }

</style>
<meta charset="UTF-8">
<?
$data['permissao'] = $this->empresa->listarpermissoes();

if ($data['permissao'][0]->carteira_padao_1 == 't') {
    ?>

    <table>
        <tbody>
            <tr>
                <td >NOME: <b><?= @$paciente[0]->nome; ?></b></td>
            </tr>
            <tr>
                <td >MATRICULA: <b>000<?= $titular_id; ?></b></td>
            </tr>
            <tr>
                <td >NASCIMENTO: <b><?= substr(@$paciente[0]->nascimento, 8, 2) . '/' . substr(@$paciente[0]->nascimento, 5, 2) . '/' . substr(@$paciente[0]->nascimento, 0, 4); ?></b></td>
            </tr>

            <tr>
                <td><?= $empresa[0]->razao_social; ?>: <b><?= "(" . substr(@$empresa[0]->telefone, 0, 2) . ")" . substr(@$empresa[0]->telefone, 3, 4) . "-" . substr(@$empresa[0]->telefone, 7, 4); ?></b></td>
            </tr>

        </tbody>
    </table>

    <?
} elseif ($data['permissao'][0]->carteira_padao_2 == 't') {

//    echo "<pre>";
//print_r($paciente);
//die;
    ?>

    <table border="0">
        <tbody>
            <tr>
                <td colspan="2">NOME: <b><?

                        function limitarTexto($texto, $limite) {
                            if (strlen($texto) > $limite) {
                                $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '';
                            } else {
                                
                            }



                            return $texto;
                        }

// String a ser limitada
                        $titulo_nome = @$paciente[0]->nome;
// Mostrando a string limitada em 40 caracteres.
                        echo(limitarTexto($titulo_nome, $limite = 30));
                        ?> 

                    </b></td>
            </tr>
            <tr>
                <td colspan="2">CPF: <b><?
                        @$teste = $this->utilitario->preencherEsquerda(@$paciente[0]->cpf, 11, '0');

                        if (strlen(preg_replace("/\D/", '', @$teste)) === 11) {
                            echo preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", @$teste);
                        } else {
//    $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
                            echo "000.000.000-00";
                        }
                        ?></b></td>
            </tr>
            <tr>
                <td >MATRICULA: <b>0<?= @$titular_id; ?></b> 
                </td>
                <!--<td >-->
                    <!--VENCIMENTO:-->
 <?  
//                    
//                    if (@$contrato[0]->qtd_dias == "" || @$contrato[0]->qtd_dias == 0) {
////                    @$qtd_dias = 0;
//                } else {
//                    @$qtd_dias = @$contrato[0]->qtd_dias;
//                }
// 
                
//             if (@$paciente[0]->qtd_dias == "" || @$paciente[0]->qtd_dias == 0) {
////                    @$qtd_dias = 0; 
//                } else {
//                    @$qtd_dias = @$paciente[0]->qtd_dias;
//                    
//                }   
                
                
//                if (@$contrato[0]->data_cadastro != "") {
//                    if (@$contrato[0]->data_cadastro == "") {
//                        echo "00/00/0000";
//                    } else {
//                        if (@$qtd_dias == "") {
//                            @$qtd_dias = 0;
//                        }
//                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$contrato[0]->data_cadastro)));
//                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
//                    }
//                } else {
//                    if (@$paciente[0]->data_cadastro == "") {
//                        echo "00/00/0000";
//                    } else {
//                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$paciente[0]->data_cadastro)));
//                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
//                    }
//                }
                    ?> 
        <!--<b> </b>-->
    
    <!--</td>-->
                
                
            </tr>

        </tbody>
    </table>

    <?
} elseif ($data['permissao'][0]->carteira_padao_3 == 't') {

    $i = 0;
    if (@count($dependente) > 0 && @$paciente[0]->situacao != "Dependente") {
        foreach ($dependente as $item) {
            if ($item->situacao == 'Dependente') {
                @$i++;
            }
        }
    } else {
        
    }
    ?> 
    <table border=0> 

        <tr>
            <td  colspan="3">Nome</td> 
        </tr>

        <tr>
            <td colspan="3"><?

//          print_r($contrato);
//           print_r($paciente);
//          die; 
                function limitarTexto($texto, $limite) {
                    if (strlen($texto) > $limite) {
                        $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '';
                    } else {
                        
                    }
                    return $texto;
                }

// String a ser limitada
                $titulo_nome = @$paciente[0]->nome;
// Mostrando a string limitada em 40 caracteres.
                echo(limitarTexto($titulo_nome, $limite = 30));
                ?> </td>

        </tr> 
        
        
        <tr height=10>
            <td colspan="3 ">   </td>

        </tr> 

        <tr>
            <td>Documento</td>
            <td style="text-align: center;">Empresa</td>
            <td>Data Validade</td>


        </tr>

        <tr>
            <td><?
                @$teste = $this->utilitario->preencherEsquerda(@$paciente[0]->cpf, 11, '0');

                if (strlen(preg_replace("/\D/", '', @$teste)) === 11) {
                    echo preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", @$teste);
                } else {
//    $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
                    echo "000.000.000-00";
                }
                ?>

            </td> 

            <td>
                <?
//                print_r($paciente);
                if (@$paciente[0]->empresa_id != "") {
                    echo @$paciente[0]->empresa_cadastro;
                } else {
                    echo @$empresa[0]->razao_social;
                }
                ?> 

            </td>

            <td style="text-align: center;"><?
//            echo '<pre>';
//            print_r($paciente);


                if (@$contrato[0]->qtd_dias == "" || @$contrato[0]->qtd_dias == 0) {
//                    @$qtd_dias = 0;
                } else {
                    @$qtd_dias = @$contrato[0]->qtd_dias;
                }


                if (@$paciente[0]->qtd_dias == "" || @$paciente[0]->qtd_dias == 0) {
//                    @$qtd_dias = 0;
                } else {
                    @$qtd_dias = @$paciente[0]->qtd_dias;
                }

                if (@$contrato[0]->data_cadastro != "") {
                    if (@$contrato[0]->data_cadastro == "") {
                        echo "00/00/0000";
                    } else {
                         if (@$qtd_dias == "") {
                            @$qtd_dias = 0;
                        }
                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$contrato[0]->data_cadastro)));
                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
                    }
                } else {
                    if (@$paciente[0]->data_cadastro == "") {
                        echo "00/00/0000";
                    } else {
                         if (@$qtd_dias == "") {
                            @$qtd_dias = 0;
                        }
                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$paciente[0]->data_cadastro)));
                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
                    }
                }
                ?> </td> 
 

        </tr>
     
        <tr>
            <td colspan="3" height=10>   </td>

        </tr> 
        <tr>
            <td>Qtde Dependentes
            </td>

            <td style="text-align: center;">Plano</td>
            <td style="text-align: center;">Matrícula</td>
        </tr>

        <tr>
            <td style="text-align: center;"><?= $i; ?></td>

            <td style="text-align: center;"> <?
            if (@$paciente[0]->nome_impressao != "") {
                echo $paciente[0]->nome_impressao;
            } else {
                echo $contrato[0]->nome_impressao;
            }
                ?></td> 

            <td style="text-align: center;"> <?= @$paciente[0]->paciente_id ?></td>



        </tr>

    </table>



    <?
} elseif ($data['permissao'][0]->carteira_padao_4 == 't') {
    $i = 0;
    if (@count($dependente) > 0 && @$paciente[0]->situacao != "Dependente") {
        foreach ($dependente as $item) {
            if ($item->situacao == 'Dependente') {
                @$i++;
            }
        }
    } else {
        
    }
    ?>


    <table border='0'>
        <tr>
            <td>Nome</td>
        </tr>
        <tr>
            <td><?

//                echo '<pre>'; 
//          print_r($contrato);
//           print_r($paciente);
//          die;

    function limitarTexto($texto, $limite) {
        if (strlen($texto) > $limite) {
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '';
        } else {
            
        }
        return $texto;
    }

// String a ser limitada
    $titulo_nome = @$paciente[0]->nome;
// Mostrando a string limitada em 40 caracteres.
    echo(limitarTexto($titulo_nome, $limite = 30));
    ?></td>
        </tr>



        <tr>
            <td>Documento</td>
        </tr>
        <tr>
            <td><?
            @$teste = $this->utilitario->preencherEsquerda(@$paciente[0]->cpf, 11, '0');

            if (strlen(preg_replace("/\D/", '', @$teste)) === 11) {
                echo preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", @$teste);
            } else {
//    $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
                echo "000.000.000-00";
            }
    ?></td>
        </tr>


        <tr>
            <td>Empresa</td>
        </tr>  
        <tr>
            <td>   <?
//                print_r($paciente);
            if (@$paciente[0]->empresa_id != "") {
                echo @$paciente[0]->empresa_cadastro;
            } else {
                echo @$empresa[0]->razao_social;
            }
    ?> 
            </td>
        </tr>



        <tr>
            <td>Data Validade</td>
        </tr>
        <tr>
            <td><? 
            
//            print_r($paciente); 
            
            if (@$contrato[0]->qtd_dias == "" || @$contrato[0]->qtd_dias == 0) {
//                    @$qtd_dias = 0;
                } else {
                    @$qtd_dias = @$contrato[0]->qtd_dias;
                }
 
                
             if (@$paciente[0]->qtd_dias == "" || @$paciente[0]->qtd_dias == 0) {
//                    @$qtd_dias = 0; 
                } else {
                    @$qtd_dias = @$paciente[0]->qtd_dias;
                    
                }   
                
                
                if (@$contrato[0]->data_cadastro != "") {
                    if (@$contrato[0]->data_cadastro == "") {
                        echo "00/00/0000";
                    } else {
                        if (@$qtd_dias == "") {
                            @$qtd_dias = 0;
                        }
                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$contrato[0]->data_cadastro)));
                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
                    }
                } else {
                    if (@$paciente[0]->data_cadastro == "") {
                        echo "00/00/0000";
                    } else {
                        $validade = date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$paciente[0]->data_cadastro)));
                        echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);
                    }
                }
    ?> </td>
        </tr>


        <tr>
            <td>Qtde Dependentes</td>
        </tr>
        <tr>
            <td><?= $i; ?></td>
        </tr>


        <tr>
            <td>Plano</td>
        </tr>
        <tr>
            <td>
    <?
    if (@$paciente[0]->nome_impressao != "") {
        echo $paciente[0]->nome_impressao;
    } else {
        echo $contrato[0]->nome_impressao;
    }
    ?></td>
        </tr>


        <tr>
            <td>Matrícula</td>
        </tr>
        <tr>
            <td>
    <?= @$paciente[0]->paciente_id ?>
            </td>
        </tr>



    </table>







    <?
} elseif ($data['permissao'][0]->carteira_padao_5 == 't') {
    ?> 
 
    <table>
        <tbody>
            <tr>
                <td >NOME: <b><?= @$paciente[0]->nome; ?></b></td>
            </tr>
            <tr>
                <td >MATRICULA: <b>000<?= @$paciente[0]->paciente_id; ?></b></td>
            </tr>
            <tr>
                <td >NASCIMENTO: <b><?= substr(@$paciente[0]->nascimento, 8, 2) . '/' . substr(@$paciente[0]->nascimento, 5, 2) . '/' . substr(@$paciente[0]->nascimento, 0, 4); ?></b></td>
            </tr>

            <tr>
                <td><?= $empresa[0]->razao_social; ?>: <b><?= "(" . substr(@$empresa[0]->telefone, 0, 2) . ")" . substr(@$empresa[0]->telefone, 3, 4) . "-" . substr(@$empresa[0]->telefone, 7, 4); ?></b></td>
            </tr>

        </tbody>
    </table>

    <?
}else{
    
}
?>

<script type="text/javascript">
    window.print()


</script>