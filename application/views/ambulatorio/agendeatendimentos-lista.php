 



<?
//echo '<pre>';
//print_r($lista);
?>

<meta charset="utf-8">


<style>
    tr:nth-child(even) {
        background-color: #f2f2f2
    }
    td{
        padding: 4px;
    }


</style>






<h1>Agendar Atendimentos</h1>
<table border='0'>

    <tr>

        <td >
            <b>Paciente</b>

        </td>
        <td>
            <b>Sala</b>

        </td>
        <td>
            <b>Data</b>

        </td>
        <td>
            <b>Tempo de Atendimento</b>

        </td>


        
        <td>
            <b>Observação</b>          
        </td>
        

         <td>
             
             
             <b>
Ação
    </b>  
</td>
        

    </tr>


    <? foreach ($lista as $item) {
        ?>

        <tr style="text-align: left;">
            <td><?echo $item->nome;?></td>
            <td><? echo $item->sala; ?></td>
            <td><?=($item->data != '')? date("d/m/Y",strtotime($item->data)) : ''; ?></td>
            <td ><?echo $item->tempo_atendimento;?></td>
            <td><? echo $item->observacao; ?></td>   
                 
            <td><a onclick="javascript: return confirm('Deseja realmente excluir o agendamento?');" href="<?= base_url() ?>ambulatorio/laudo/desativarhoraagenda/<? echo $item->hora_agendamento_id; ?>/<? echo $item->sala_id; ?>">Excluir</a></td>  
        </tr>





    <?
}
?>








</table>