
<div class="content"> <!-- Inicio da DIV content -->
    <!--    <div class="bt_link_new">
            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe');">
                Encaixar Consulta
            </a>
        </div>-->
    <div id="accordion">
        <?php $perfil_id = $this->session->userdata('perfil_id'); ?>
        <h3 class="singular"><a href="#">Multifuncao Agendamento Web</a></h3>
        <div>
            <?
            $medico = $this->exame->listarmedico();
            $listarpaceiros = $this->exame->listarparceiros();
            $endereco_ip = @$_GET['endereco_parceiro'];
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listaragendamentoweb">

                    <tr>
                        <th class="tabela_title">Parceiro</th>
                        <th class="tabela_title">Medicos</th>
                        <th class="tabela_title">SITUA&Ccedil;&Atilde;O</th>
                        <th class="tabela_title">Data</th>
                        <!--<th colspan="2" class="tabela_title">Nome</th>-->
                    </tr>
                    <tr>
<!--                        <th class="tabela_title">
                            <input type="text" id="txtcbo" class="texto02" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" />
                        </th>-->
                        <th class="tabela_title">



                            <select name="endereco_parceiro" id="endereco_parceiro" class="size2">
                                <option value="">Selecione</option>
                                <? foreach ($listarpaceiros as $item) { ?>

                                    <option value="<?= $item->financeiro_parceiro_id ?>" <?
                                    if ($item->financeiro_parceiro_id == @$_GET['endereco_parceiro']) {
                                        echo 'selected';
                                    }
                                    ?>><?= $item->fantasia ?></option>
                                        <? } ?>

                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="medico" id="medico" class="size1">
                                <option value=""> </option>
                                <? foreach ($medicos as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>"<?
                                    if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                    endif;
                                    ?>>

                                        <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>


                                    </option>
                                <? endforeach; ?>

                            </select>
                        </th>

                        <th class="tabela_title">
                            <select name="situacao" id="situacao" class="size2">
                                <option value=""></option>
                                <option <?
                                if (@$_GET['situacao'] == 'LIVRE') {
                                    echo 'selected';
                                }
                                ?> value="LIVRE">VAGO</option>
                                <option value="OK" <?
                                if (@$_GET['situacao'] == 'OK') {
                                    echo 'selected';
                                }
                                ?>>OCUPADO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
<!--                        <th colspan="3" class="tabela_title">
                            <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>-->
                        <th colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" >Status</th>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="70px;">Resp.</th>
                        <th class="tabela_header" width="70px;">Data</th>
                        <th class="tabela_header" width="50px;">Dia</th>
                        <th class="tabela_header" width="70px;">Agenda</th>
                        <th class="tabela_header" width="150px;">Sala</th>
                        <th class="tabela_header" width="150px;">Convenio</th>
                        <th class="tabela_header">Telefone</th>
                        <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                        <th class="tabela_header" >Empresa</th>
                        <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $total = 200000000000;
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
//                $l = $this->exame->listarestatisticapaciente($_GET);
//                $p = $this->exame->listarestatisticasempaciente($_GET);

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
//                        $lista = $this->exame->listarexamemultifuncaoconsulta2($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        $paciente = "";
                        foreach ($lista as $item) {
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
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

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
                                        $situacao = "<font color='gray'>faltou";
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
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                <? }if ($verifica == 4) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                <? } if ($verifica == 5) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $item->paciente; ?></b></td>
                                <? } if ($verifica == 6) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <? } ?>
                                <? if ($verifica == 7) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                    <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->secretaria, 0, 9); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>

                                <? if ($situacao == 'espera' || $situacao == 'agendado' || $situacao == "<font color='gray'>faltou") { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="150px;"><b><?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?></b></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="150px;"><?= $item->sala . " - " . substr($item->medicoagenda, 0, 15); ?></td>

                                <? } ?>                                

                                <? if ($item->convenio != '') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente; ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">=><?= $item->observacoes; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <? if ($item->paciente_id != "") { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        <!--                                        <div class="bt_link">
                                                                                    <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>');">Editar
                                                                                    </a></div>-->
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                                    <?
                                }
                                if ($item->paciente_id == "" && $item->bloqueado == 'f') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <?
                                            $endereco_ip = @$_GET['endereco_parceiro'];
                                            ?>
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/carregarconsultatemp/<?= $item->agenda_exames_id ?>/<?= $endereco_ip ?>');">Consultas
                                            </a></div>
                                    </td>
                                    <?
                                } elseif ($item->bloqueado == 'f') {

                                    if ($item->confirmado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <?php if($perfil_id != 10){?>
                                                <div class="bt_link">
                                                    <a onclick="javascript: return confirm('Deseja realmente cancelar esse atendimento?');" href="<?= base_url() ?>ambulatorio/exametemp/excluirconsultatempgeral/<?= $item->agenda_exames_id ?>/<?= $endereco_ip ?>" target="_blank">Cancelar
                                                    </a>
                                                </div>
                                            <?php }?>
                                        </td>    
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">

                                        </td>    
                                    <? }
                                    ?>

                                <? } elseif ($item->bloqueado == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                    <?
                                }
                                if ($paciente == "Bloqueado" || $paciente == "vago") {
                                    if ($item->bloqueado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <!--                                            <div class="bt_link">
                                                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/bloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Bloquear
                                                                                            </a></div>-->
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <!--                                            <div class="bt_link">
                                                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/desbloquear/<?= $item->agenda_exames_id ?>/<?= $item->inicio; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Desbloq.
                                                                                            </a></div>-->
                                        </td>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <? if ($item->telefonema == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><font color="green"title="<?= $item->telefonema_operador; ?>" ><b>Confirmado</b></td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <!--                                            <div class="bt_link">
                                                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/telefonema/<?= $item->agenda_exames_id ?>/<?= $item->paciente; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Confirma
                                                                                            </a></div>-->
                                        </td>
                                        <?
                                    }
                                }
                                ?>

                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="14">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
                                    $(document).ready(function () {


                                        var txtcbo = $("#txtcbo");
                                        txtcbo.focusout(function () {

                                        });

                                        $(function () {
                                            $("#txtcbo").autocomplete({
                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionaismultifuncao",
                                                minLength: 3,
                                                focus: function (event, ui) {
                                                    $("#txtcbo").val(ui.item.label);
                                                    return false;
                                                },
                                                select: function (event, ui) {
                                                    $("#txtcbo").val(ui.item.value);
                                                    $("#txtcboID").val(ui.item.id);
                                                    return false;
                                                }
                                            });
                                        });


                                        $(function () {
                                            txtcbo.change(function () {

                                                if ($(this).val()) {

                                                    especialidade_medico = txtcbo.val();
//                     alert(teste_parada);
                                                    $('.carregando').show();
//                     alert(teste_parada);
                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: especialidade_medico, ajax: true}, function (j) {
                                                        options = '<option value=""></option>';
                                                        console.log(j);

                                                        for (var c = 0; c < j.length; c++) {


                                                            if (j[0].operador_id != undefined) {
                                                                options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                                                            }
                                                        }
                                                        $('#medico').html(options).show();
                                                        $('.carregando').hide();



                                                    });
                                                } else {
                                                    $('#medico').html('<option value="">Selecione</option>');
                                                }
                                            });
                                        });



                                        $(function () {
                                            $("#data").datepicker({
                                                autosize: true,
                                                changeYear: true,
                                                changeMonth: true,
                                                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                buttonImage: '<?= base_url() ?>img/form/date.png',
                                                dateFormat: 'dd/mm/yy'
                                            });
                                        });

                                        $(function () {
                                            $("#accordion").accordion();
                                        });

                                        setTimeout('delayReload()', 20000);
                                        function delayReload()
                                        {
                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
                                                history.go(0);
                                            } else {
                                                window.location.reload();
                                            }
                                        }

                                    });

</script>
