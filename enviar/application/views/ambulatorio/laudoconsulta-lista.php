
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $salas = $this->exame->listartodassalas();
    $medicos = $this->operador_m->listarmedicos();
    $especialidade = $this->exame->listarespecialidade();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Consultas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/laudo/pesquisarconsulta">
                                <tr>
                                    <th class="tabela_title">Salas</th>
                                    <th class="tabela_title">Especialidade</th>
                                    <th class="tabela_title">Medico</th>
                                    <th class="tabela_title">Status</th>
                                    <th class="tabela_title">Data</th>
                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>
                                <tr>
                                    <th class="tabela_title">
                                        <select name="sala" id="sala" class="size1">
                                            <option value=""></option>
                                            <? foreach ($salas as $value) : ?>
                                                <option value="<?= $value->exame_sala_id; ?>" <?
                                                if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                                endif;
                                                ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <select name="especialidade" id="especialidade" class="size1">
                                            <option value=""></option>
                                            <? foreach ($especialidade as $value) : ?>
                                                <option value="<?= $value->descricao; ?>" <?
                                                if (@$_GET['especialidade'] == $value->descricao):echo 'selected';
                                                endif;
                                                ?>><?php echo $value->descricao; ?></option>
                                                    <? endforeach; ?>
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
                                                            <?php echo $value->nome; ?>

                                                </option>
                                            <? endforeach; ?>

                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <select name="situacao" id="situacao" class="size1" >
                                            <option value='' ></option>
                                            <option value='AGUARDANDO' >AGUARDANDO</option>
                                            <option value='DIGITANDO' >DIGITANDO</option>
                                            <option value='FINALIZADO' >FINALIZADO</option>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text"  id="data" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                                    </th>
                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                            </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="300px;">Nome</th>
                        <th class="tabela_header" width="30px;">Idade</th>
                        <th class="tabela_header" width="30px;">Data</th>
                        <th class="tabela_header" width="30px;">Convenio</th>
                        <th class="tabela_header" width="130px;">M&eacute;dico</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" width="300px;">Procedimento</th>
<!--                            <th class="tabela_header">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>-->
                        <th class="tabela_header" colspan="3" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->laudo->listarconsulta($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->laudo->listar2consulta($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_cadastro;
                            $operador_id = $this->session->userdata('operador_id');
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%d');

                            $ano_atual = date("Y");
                            $ano_nascimento = substr($item->nascimento, 0, 4);
                            $idade = $ano_atual - $ano_nascimento;

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $idade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"><?= substr($item->medico, 0, 18); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
        <!--                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->medicorevisor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao_revisor; ?></td>-->
                                <? if (($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' || $operador_id == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranaminese/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                Atender</a></div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                        <a>Bloqueado</a></font>
                                    </td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>');">
                                            Arquivos</a></div>
                                </td>
                                <? if ($operador_id == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/examecancelamento/<?= $item->exames_id ?>/<?= $item->sala_id ?> /<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?> ">
                                                Cancelar
                                            </a></div>
                                    </td>
                                <? } ?>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
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
//alert('teste_parada');
                                        $(function () {
                                            $('#especialidade').change(function () {

                                                if ($(this).val()) {

//                                                  alert('teste_parada');
                                                    $('.carregando').show();
//                                                        alert('teste_parada');
                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
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
                                                    $('.carregando').show();
//                                                        alert('teste_parada');
                                                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidadetodos', {txtcbo: $(this).val(), ajax: true}, function (j) {
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