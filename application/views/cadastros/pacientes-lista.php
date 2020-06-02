<div class="content"> <!-- Inicio da DIV content -->

    <table>
        <tr>

            <!--            
                        <td width="100px;"><center>
                            <div class="bt_link_new">
                                <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopaciente">
                                    Agendar Exame
                                </a>
                            </div>
                            </td>
                            <td width="100px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteexameencaixe');">
                                        Encaixar Exame
                                    </a>
                                </div>
                                </td>
                                <td width="100px;"><center>
                                    <div class="bt_link_new">
                                        <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsulta">
                                            Agendar Consulta
                                        </a>
                                    </div>
                                    </td>
            
                                    <td width="100px;"><center>
                                        <div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe');">
                                                Encaixar Consulta
                                            </a>
                                        </div>
                                        </td>-->

    </table>
    <div id="accordion">
        <h3><a href="#">Clientes Cadastrados</a></h3>
        <div>
            <table >
                <thead>
                    <tr>
                        <!--<th class="tabela_title" ></th>-->
                        <th class="tabela_title" >Numero</th>
                        <th class="tabela_title" >Nome / Telefone / Nome da Mae</th>
                        <th class="tabela_title" >CPF</th>
                        <th class="tabela_title" colspan="2">Dt. Nascimento</th>
                    </tr>
                    <tr>
                <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/pesquisar">
<!--                        <th class="tabela_title" >
                        <input type="text" name="prontuario" class="texto03" value="<?php echo @$_GET['prontuario']; ?>" />
                        <input type="text" name="nome" class="texto08" value="<?php echo @$_GET['nome']; ?>" />
                        <input type="text" name="nascimento" class="texto03" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />
                </th>-->
                    <th class="tabela_title" >
                        <input type="text" name="prontuario" class="texto02" value="<?php echo @$_GET['prontuario']; ?>" />
                    </th>
                    <th class="tabela_title" >
                            <!--<input type="text" name="prontuario" class="texto03" value="<?php echo @$_GET['prontuario']; ?>" />-->
                        <input type="text" name="nome" class="texto06" value="<?php echo @$_GET['nome']; ?>" />
                        <!--<input type="text" name="nascimento" class="texto03" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />-->
                    </th>
                    <th class="tabela_title" >
                        <input type="text" name="cpf" id ="cpfcnpj" class="texto03" value="<?php echo @$_GET['cpf']; ?>" />
                       
                    </th>

                    <th class="tabela_title" colspan="2">
                        <input type="text" name="nascimento" class="texto03" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />
                    </th>
                    <th class="tabela_title" >
                        <button type="submit" name="enviar">Pesquisar</button>
                    </th>
                </form>
                </tr>
            </table>
            <table >
                <tr>
                    <th class="tabela_header">Numero</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Nome da Mãe</th>
                    <th class="tabela_header" width="100px;">Nascimento</th>
                    <th class="tabela_header" width="100px;">Telefone</th>
                    <th class="tabela_header" width="100px;">CPF</th>
                    <th class="tabela_header" width="100px;">Situação</th>
                    <th class="tabela_header" colspan="4"  width="70px;"><center>A&ccedil;&otilde;es</center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->paciente->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->paciente->listar($_GET)->orderby('paciente_id', 'desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            if ($item->celular == "") {
                                $telefone = $item->telefone;
                            } else {
                                $telefone = $item->celular;
                            }
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome_mae; ?></td>
                                <!-- <td class="<?php echo $estilo_linha; ?>"><?php echo $item->representante_id; ?></td> -->
                                <!-- <td class="<?php echo $estilo_linha; ?>"><?php echo $item->gerente_id; ?></td> -->
                                <!-- <td class="<?php echo $estilo_linha; ?>"><?php echo $item->vendedor; ?></td> -->
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $telefone; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $item->cpf; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= $item->situacao; ?></td>
                                <? $perfil_id = $this->session->userdata('perfil_id'); ?>
                                <? if ($perfil_id != 6) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                <b>Editar</b>
                                            </a></div>
                                    </td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>emergencia/filaacolhimento/novo/<?= $item->paciente_id ?>">
                                            <b>Op&ccedil;&otilde;es</b>
                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;">                    <div class="bt_linkm">
                                        <a onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . $item->paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                                        </a></div>
                                </td>

                                <?php
                                if ($item->reativar == "t" && $item->ativo == 'f') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">                    <div class="bt_linkm">
                                            <a   href="<?= base_url() ?>cadastros/pacientes/reativarpaciente" target="_blank" >Reativar
                                            </a></div>
                                    </td>
                                <?php } ?>

                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="10">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>cadastros/pacientes/pesquisar/50');" <?
                                    if ($limit == 50) {
                                        echo "selected";
                                    }
                                    ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>cadastros/pacientes/pesquisar/100');" <?
                                            if ($limit == 100) {
                                                echo "selected";
                                            }
                                    ?>> 100 </option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $("#cpfcnpj").mask("999.999.999-99");

</script>