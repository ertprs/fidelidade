<style>
    td{
        font-size: 17px;
        font-family: arial;
    }
    
</style>
<meta charset="UTF-8">
<?
if ($permissao[0]->carteira_padao_1 == 't') {
    ?>

    <table>
        <tbody>
            <tr>
                <td width="8%" ><img width="8%" src="<?= base_url() . 'upload/empresalogo/' . @$empresa_id . '/' . @$arquivo_pasta[0] .'' ?>" ></b></td>
            </tr>
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
} elseif ($permissao[0]->carteira_padao_2 == 't') {

//    echo "<pre>";
//print_r($paciente);
//die;
    ?>

<table border="0">
        <tbody>
            <tr>
                <td ><img width="8%" src="<?= base_url() . 'upload/empresalogo/' . @$empresa_id . '/' . @$arquivo_pasta[0] .'' ?>" ></b></td>
            </tr>
            <tr>
                <td colspan="2">NOME: <b><?= @$paciente[0]->nome; ?></b></td>
            </tr>
            <tr>
                <td width="15%">CPF: <b><?
                        if (strlen(preg_replace("/\D/", '', @$paciente[0]->cpf)) === 11) {
                            echo preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", @$paciente[0]->cpf);
                        } else {
//    $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
                            echo "000.000.000-00";
                        }
                        ?></b></td>
            </tr>
            <tr>
                <td >MATRICULA: <b>0<?= @$titular_id; ?></b></td>
                <td >VENCIMENTO: <?
                    if (@$paciente[0]->qtd_dias == "" || @$paciente[0]->qtd_dias == 0) {
                        @$qtd_dias = 0;
                    } else {
                        @$qtd_dias = @$paciente[0]->qtd_dias;
                    } 
                    if (@$paciente[0]->data_cadastro == "") { 
                        echo "00/00/0000";
                    }else{
                    $validade =  date("Y-m-d", strtotime("+$qtd_dias days", strtotime(@$paciente[0]->data_cadastro))); 
                   echo substr(@$validade, 8, 2) . '/' . substr(@$validade, 5, 2) . '/' . substr(@$validade, 0, 4);  
                   
                    }
                    
                    ?> <b> </b></td>
            </tr>
 
        </tbody>
    </table>

    <?
}elseif ($permissao[0]->carteira_padao_6 == 't') {
    $empresa_id = 1;
    ?>
        <table >
  
            <tbody align="right">
                <tr>
                <td width="8%" ><img width="8%" src="<?= base_url() . 'upload/empresalogo/' . @$empresa_id . '/' . @$arquivo_pasta[0] .'' ?>" ></b></td>
                </tr>
                <tr>
                    <td >MATRICULA: <b>000<?= $titular_id; ?></b></td>
                </tr>
                <tr>
                    <td >NOME: <b><?= @$paciente[0]->nome; ?></b></td>
                </tr>
                <? if(@$paciente[0]->paciente_contrato_id == ''){?>
                <tr>
                <td >CONTRATO: <b><?= @$contrato[0]->paciente_contrato_id;?></b></td>
                </tr>
                <?}else{
                ?>
                <tr>
                    <td >CONTRATO: <b><?= @$paciente[0]->paciente_contrato_id;?></b></td>
                </tr>
                <?}
                ?>
            </tbody>
        </table>
    <?
    } else {
    ?> 



    <?
}
?>