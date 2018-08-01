<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8">
    <h4>RELATORIO DE CONSULTAS AGENDADAS</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <?
    if (count($lista) > 0) {
        ?>
        <table cellspacing="5"cellpadding="5">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Nome</th>
                    <th>Resp.</th>
                    <th>Data</th>
                    <th>Dia</th>
                    <th>Agenda</th>
                    <th>Sala</th>
                    <th>Convenio</th>
                    <th>Telefone</th>
                    <th>Observações</th>
                    <th>Empresa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($lista as $value) {?>
                    <tr><td colspan="15"></td></tr>
                    <tr>
                        <td colspan="15"><span style="font-weight: bold; font-size: 14pt">Parceiro:</span> <?=$value["parceiro"]?></td>
                    </tr>
                    <tr><td colspan="15"></td></tr>
                    <?
                    foreach ($value["dados"] as $item) {
                        $total++;
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

                        $faltou = false;
                        if ($item->paciente == "" && $item->bloqueado == 't') {
                            $situacao = "Bloqueado";
                            $paciente = "Bloqueado";
                            $verifica = 7;
                        } else {
                            $paciente = "";

                            if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                $situacao = "Aguardando";
                                $verifica = 2;
                            } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                                $situacao = "Finalizado";
                                $verifica = 4;
                            } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                $situacao = "Atendendo";
                                $verifica = 5;
                            } elseif ($item->confirmado == 'f' && $item->operador_atualizacao == null) {
                                $situacao = "agenda";
                                $verifica = 1;
                            } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
                                $verifica = 6;
                                $verifica = 6;
                                date_default_timezone_set('America/Fortaleza');
                                $data_atual = date('Y-m-d');
                                $hora_atual = date('H:i:s');
                                if ($item->data < $data_atual) {
                                    $situacao = "faltou";
                                    $faltou = true;
                                } else {
                                    $situacao = "agendado";
                                }
                            } else {
                                $situacao = "espera";
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
                            <td><?= $situacao; ?></td>
                            <td><?= $item->paciente; ?></td>
                            <td><?= substr($item->secretaria, 0, 9); ?></td>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td><?= substr($dia, 0, 3); ?></td>
                            <td><?= $item->inicio; ?></td>
                            <td><?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?></td>
                            <? if ($item->convenio != '') { ?>
                                <td><?= $item->convenio; ?></td>
                            <? } else { ?>
                                <td><?= $item->convenio_paciente; ?></td>
                            <? } ?>
                            <td><?= $telefone; ?></td>
                            <td>=><?= $item->observacoes; ?></td>
                            <td><?= $item->empresa; ?></td>
                        </tr>
                    <? } 
                }
                ?>
<!--                <tr>
                    <td colspan="10"><b>TOTAL</b></td>
                    <td ><b><?= $total; ?></b></td>
                </tr>-->
            </tbody>


            <?
        } else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
