
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">

        <h3 class="singular"><a href="#">Agendamentos Autorizados</a></h3>
        <div>
            <?
            $medico = $this->exame->listarmedico();
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listaragendamentosautorizados">

                    <tr>
                        <th class="tabela_title">Parceiro</th>
                        <!--<th class="tabela_title">Medicos</th>-->
                        <!--<th class="tabela_title">SITUA&Ccedil;&Atilde;O</th>-->
                        <th class="tabela_title">Data</th>
                        <th class="tabela_title">Nome</th>
                        <th  class="tabela_title">Titular</th>
                    </tr>
                    <tr>
                        <? $listarpaceiros = $this->exame->listarparceiros(); ?>
                        <th class="tabela_title">
                            <select name="parceiro" id="parceiro" class="size2">
                                <option value="">Selecione</option>
                                <? foreach ($listarpaceiros as $item) { ?>

                                    <option value="<?= $item->financeiro_parceiro_id ?>" <?
                                    if ($item->financeiro_parceiro_id == @$_GET['parceiro']) {
                                        echo 'selected';
                                    }
                                    ?>><?= $item->fantasia ?></option>
                                        <? } ?>

                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th  class="tabela_title">
                            <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th  class="tabela_title">
                            <input type="text" name="nometitular" class="texto06 bestupper" value="<?php echo @$_GET['nometitular']; ?>" />
                        </th>
                        <th  class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" >Nome</th>
                        <th class="tabela_header" >Titular</th>
                        <th class="tabela_header" >Parceiro</th>
                        <th class="tabela_header" width="120px">Grupo</th>
                        <th class="tabela_header" width="40px">Data</th>
                        <th class="tabela_header" >Dia</th>
                        <th class="tabela_header">Telefone</th>
                        <th class="tabela_header">Situação</th>
                        <th class="tabela_header"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listaragendamentosautorizados($_GET);
                $total = $consulta->count_all_results();
                $limit = 50;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->exame->listaragendamentosautorizados($_GET)->limit($limit, $pagina)->get()->result();
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


                            $situacao = '';
                            $cor = '';
                            if ($item->carencia_liberada == 't') {
                                if ($item->consulta_avulsa == 't') {
                                    $situacao = "Consulta $item->consulta_tipo";
                                    $cor = 'green';
                                } else {
                                    $situacao = 'Carência Utilizada';
                                    $cor = 'green';
                                }
                                $pagamento = 'ok';
                            } else {
                                if ($item->pagamento_confirmado == 'f') {
                                    $situacao = "Pagamento Pendente R$: " . number_format($item->valor, 2, ",", ".");
                                    $cor = 'red';
                                    $pagamento = 'pendente';
                                } else {
                                    $situacao = "Pagamento Confirmado R$: " . number_format($item->valor, 2, ",", ".");
                                    $cor = 'green';
                                    $pagamento = 'ok';
                                }
                            }

                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%H:%I:%S');
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                            $faltou = false;
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

                                <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->titular ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->parceiro ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" style="color: <?= $cor ?>;"><?= $situacao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <? if ($pagamento == 'pendente' && $item->pagamento_confirmado == 'f') { ?>
                                        <div class="bt_link">
                                            <a onclick="javascript: return confirm('Deseja realmente confirmar esse pagamento?');" href="<?= base_url() ?>ambulatorio/exametemp/confirmarpagamentofidelidade/<?= $item->exames_fidelidade_id ?>/" target="_blank">Confirmar Pag.
                                            </a>
                                        </div>  
                                    <? } ?>

                                </td>


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
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
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
