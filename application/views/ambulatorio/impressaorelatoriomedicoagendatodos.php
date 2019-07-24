<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Agenda Consultas</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <h4>Medico: <? 
    if(count(@$medico) > 0 && $medico != null){
       echo $medico[0]->operador; 
    }else{
        echo 'TODOS';
    }
    
    
    ?></h4>
    <h4>Convênio: <?=(@$convenios > 0)? $convenios[0]->nome: 'TODOS';?></h4>
    <hr>
    
        <?
    @$empresa_id = $this->session->userdata('empresa_id');
    @$data['retorno'] = $this->exame->permisoesempresa($empresa_id);
    @$agenda_modificada = $data['retorno'][0]->agenda_modificada;
    // var_dump($agenda_modificada); die;
    ?>

    <style>
    .right{
        text-align: right;
    }
    .background{
        background-color: #d3d3d3;
    }
    
    </style>
    <table border="1" cellspacing=0 cellpadding=2>
       
        <!-- <tbody> -->
            <?php
            $paciente = "";
            $mostrarHeader = false;
            $turno = '';
            $medico_atual = '';
            $turno_atual = '';
            $data_atual = '';
            $contador = 0;
            if (count($relatorio) > 0) {
                foreach ($relatorio as $key => $item) {


                $hora = date("H:i",strtotime($item->inicio));
                $manha = date("H:i",strtotime("06:00"));
                $tarde = date("H:i",strtotime("12:00"));
                $noite = date("H:i",strtotime("18:00"));

                if($hora >= $manha && $hora < $tarde){
                    $turno = 'Manhã';
                }elseif($hora >= $tarde && $hora < $noite){
                    $turno = 'Tarde';
                }elseif($hora >= $noite){
                    $turno = 'Noite';
                }
                
                if(($medico_atual != $item->medico_agenda) || ($turno_atual != $turno)){
                    $mostrarHeader = true;
                }else{
                    $mostrarHeader = false;
                }
                

                $turno_atual = $turno;
                $medico_atual = $item->medico_agenda;

                if($_POST['medicos'] > 0){
                    $mostrarHeader = false;
                }
                $contador++;
    
                if($key == 0 || $mostrarHeader){?>
            <?if($mostrarHeader){?>
                </table>
                <br>
                <table border="1" cellspacing=0 cellpadding=2>
                <thead>

                    
                    <tr class="background">
                        <th colspan="2">
                            Turno: <?=$turno?> <?//=$contador?>
                            <?
                            $contador = 0;
                            ?>
                        </th>
                        <th colspan="12" class="right">
                            Médico: <?=$item->medicoagenda?>
                        </th>
                    </tr>
            <?}?>
                    <tr>
                        <?
                            if (@$agenda_modificada == 't') {
                                ?>
                                <th class="tabela_header" width="20px;">Nº</th>
                                <?
                            } else {
                                ?>
                                <th class="tabela_header" width="70px;">Status</th>
                                <?
                            }
                            ?>
                            <th class="tabela_header" width="250px;">Nome</th>
                            <th class="tabela_header" width="70px;">Resp.</th>
                            <th class="tabela_header">Telefone</th>
                            <?if($_POST['data_mostrar'] == 'SIM'){?>
                                <th class="tabela_header" width="70px;">Data</th>
                            <?}?>
                            <?
                            if (@$agenda_modificada == 't') {
                                
                            } else {
                                ?>
                                <th class="tabela_header" width="70px;">Dia</th>

                                <?
                            }
                            ?>
                            <?
                            if (@$data['retorno'][0]->agenda_modificada == 't') {
                                ?>
                                <th class="tabela_header" width="70px;">Horário</th>
                                <?
                            } else {
                                ?>
                                <th class="tabela_header" width="70px;">Agenda</th>   
                                <?
                            }
                            ?>
                            <th class="tabela_header" width="150px;">Medico</th>
                            <?
                            if (@$data['retorno'][0]->agenda_modificada == 't') {
                                
                            } else {
                            if ($_POST['procedimento'] == 'SIM') { ?>
                                <th class="tabela_header" width="150px;">Procedimentos</th>
                            <?} 
                            }
                            ?>
                            <th class="tabela_header" width="150px;">Convenio</th>
                            <th class="tabela_header"><center>Status Telefonema</center></th>
                            <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                            
                            


                    </tr>
                </thead>


                <?
                }
                    $dataFuturo = date("Y-m-d H:i:s");
                    $dataAtual = $item->data_atualizacao;

                    if ($item->celular != "") {
                        $telefone = $item->celular;
                    } elseif ($item->telefone != "") {
                        $telefone = $item->telefone;
                    } else {
                        $telefone = "";
                    }

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');

                    if ($item->paciente == "" && $item->bloqueado == 't') {
                        $situacao = "Bloqueado";
                        $paciente = "Bloqueado";
                        $verifica = 5;
                    } else {
                        $paciente = "";

                        if ($item->realizada == 't' && $item->situacaolaudo != 'FINALIZADO') {
                            $situacao = "Aguardando";
                            $verifica = 2;
                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                            $situacao = "Finalizado";
                            $verifica = 4;
                        } elseif ($item->confirmado == 'f') {
                            if($item->encaixe == 't'){
                                $situacao = "Encaixe";
                            }else{
                                $situacao = "Agenda";
                            }
                            
                            $verifica = 1;
                        } else {
                            $situacao = "Espera";
                            $verifica = 3;
                        }
                    }
                    if ($item->paciente == "" && $item->bloqueado == 'f') {
                        $paciente = "vago";
                    }
                    $data = $item->data;
                    $dia = strftime("%A", strtotime($data));

                    switch ($dia) {
                        case"Sunday": $dia = "Domingo";
                            break;
                        case"Monday": $dia = "Segunda";
                            break;
                        case"Tuesday": $dia = "Terça";
                            break;
                        case"Wednesday": $dia = "Quarta";
                            break;
                        case"Thursday": $dia = "Quinta";
                            break;
                        case"Friday": $dia = "Sexta";
                            break;
                        case"Saturday": $dia = "Sabado";
                            break;
                    }
                    ?>
                    <tr>
                        <td ><b> 
                            <?
                                if (@$agenda_modificada == 't') {
                                    echo @$numero = 1 + $numero;
                                } else {
                                    echo @$situacao;
                                }
                                ?>
                            </b></td>
                        <td <b><?= $item->paciente; ?></b></td>
                        <td ><?= substr($item->secretaria, 0, 9); ?></td>
                        <td ><?= $telefone; ?></td>
                        <?if($_POST['data_mostrar'] == 'SIM'){?>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <?}?>
                        <?
                        if (@$agenda_modificada == 't') {
                            
                        } else {
                            ?>
                            <?
                            echo "<td>";
                            echo substr($dia, 0, 3);
                            echo " </td>";
                        }
                        ?> 
                        <td ><?= $item->inicio; ?></td>
                        <td  width="150px;">
                            <? 
                             if (@$agenda_modificada == 't') {
                                
                            } else {
                                if ($_POST['sala'] == 'SIM') {
                                    echo $item->sala . " - ";
                                }
                            }
                            echo substr($item->medicoagenda, 0, 15); ?></td>
                            <?
                            if (@$agenda_modificada == 't') {
                                
                            } else {
                                ?>      
                                <? if ($_POST['procedimento'] == 'SIM') {
                                    ?>
                                    <td ><?=$item->procedimento; ?></td>  
                                    <?
                                }
                            }
                            ?>
                        <td ><?= $item->convenio; ?></td>
                        
                       
                        <? if ($item->bloqueado == 't') { ?>
                            <td width="60px;"> Bloqueado</td>
                            <?
                        }elseif ($item->telefonema == 't') {
                            ?>
                            <td width="60px;">Confirmado</td>
                        <? }else{?>
                            <td width="60px;">Não-Confirmado</td>
                       <? }
                        ?>
                         <td ><?= $item->observacoes; ?></td>
                         
                    </tr>

                
                <?php
            }
        }
        ?>
        <!-- </tbody> -->

    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
