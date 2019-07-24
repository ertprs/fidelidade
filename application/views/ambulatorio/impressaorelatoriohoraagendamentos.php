
<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }
</style>
<meta charset="utf-8">
<title>Relatório Agendamento de Poltronas </title>
<?
$data['empresa'] = $this->guia->listardadosdaempresa();
echo $data['empresa'][0]->razao_social;
?>
<hr>
Relatório Agendamento de Poltronas
<hr>
Data de <?= @$data_inicio; ?> até <?= @$data_fim; ?>
<hr>
<?
foreach (@$relatoriohoraagendamentos as $item) {
    @$array[] = $item->operador_id;
}
@$result = array_unique($array);
?>
 
<table border=1 cellspacing=0 cellpadding=2 bordercolor="666633">

    <tr>
        <td>Nome do paciente</td>
        <td>Idade</td>
        <td>Prontuário</td>
        <td>Medicação</td>
        <td>Qtd. Horas</td>
        <!--<td>Poltronas</td>-->
        <td>Telefone</td>
    </tr>

    <?
    if (count(@$result) > 0) {

        foreach (@$result as $item) {
            ?>
            <tr>

                <td colspan="7" style="text-align: center; background-color: #fffa65;">
                    <?
                    foreach (@$relatoriohoraagendamentos as $item2) {



                        if (@$varificar[$item2->operador_id] > 0) {
                            
                        } else {


                            if (@$item2->operador_id == $item) {
                                echo @$item2->operador;

                                @$varificar[$item2->operador_id] ++;
                            }
                        }
                    }
                    ?>
                </td>
            </tr>

            <?
            foreach ($relatoriohoraagendamentos as $value) {
                @$dataFuturo2 = date("Y-m-d");
                @$dataAtual2 = $value->nascimento;
                @$date_time2 = new DateTime($dataAtual2);
                @$diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                @$teste2 = $diff2->format('%Ya %mm %dd');

                if ($value->operador_id == $item) {

//            @$varificar[$value->operador_id] ++;
//            if ($varificar[$value->operador_id] > 1) {
//                
//            } else {
                    ?> 

                    <tr>
                        <td>                                   
                            <?= $value->paciente; ?>
                        </td> 


                        <td>                                   
                            <?= @$teste2; ?>
                        </td>  


                        <td>                                   
                            <?= $value->prontuario; ?>
                        </td> 

                        <td>                                   
                            <?= $value->medicamentos; ?>
                        </td> 
                        <td>                                   
                            <?
                            // CALCULADO QUANTIDADE DE HORAS             
// $entrada = $value->hora_inicio;                    
//$saida = $value->hora_fim;
//$hora1 = explode(":",$entrada);
//$hora2 = explode(":",$saida);
//@$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
//@$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
//$resultado = $acumulador2 - $acumulador1;
//$hora_ponto = floor($resultado / 3600);
//$resultado = $resultado - ($hora_ponto * 3600);
//$min_ponto = floor($resultado / 60);
//$resultado = $resultado - ($min_ponto * 60);
//$secs_ponto = $resultado;
////Grava na variável resultado final
//$tempo = $hora_ponto.":".$min_ponto.":".$secs_ponto;
                            echo $value->tempo_atendimento;
                            ?>
                        </td> 

                        <td>                                   
                            <?= $value->telefone; ?>
                        </td>  



                    </tr>





                    <?
//                        }
                }
            }
            ?>









        </tr>

        <?
    }
} else {

    echo "Nenhum Registro encontrado";
}
?>






</table>











