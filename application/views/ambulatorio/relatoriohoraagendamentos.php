 
 

<div class="content"> <!-- Inicio da DIV content -->

    <table>
        <tr>
<!--            <td width="20px;">
                <div class="bt_link" style="width: 110pt">
                    <a href="<?php echo base_url() ?>cadastros/pacientes/novo" style="width: 100pt">
                        Novo Cadastro
                    </a>
                </div>
            </td>-->


    </table>
    <?
    $empresa_id = $this->session->userdata('empresa_id');
    $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
    $filtro_exame = $empresapermissoes[0]->filtro_exame_cadastro;
    ?>
    <div id="accordion">
        <h3><a href="#">Manter Poltronas</a></h3>
        <div>

            <table >
                <thead>
                    <tr>

                        <th class="tabela_title" >Medico</th>
                        <th class="tabela_title" >
                            <label>Data inicio</label>
                        </th>

                        <th class="tabela_title" >
                            <label>Data fim</label>
                        </th>



                    </tr>

                <form method="get" action="<?php echo base_url() ?>ambulatorio/guia/pesquisarponltrona">


                    <tr>


                        <th class="tabela_title" colspan="">
                            <select name="medico" value="<?php echo @$_GET['medico']; ?>">
                                <option value="">TODOS</option>
                                <?
                                foreach (@$medicos as $item) {
                                    ?>

                                    <option value="<?= $item->operador_id; ?>"   <?
                                    if ($item->operador_id == @$medico_post) {
                                        echo 'selected';
                                    }
                                    ?>><?= $item->nome; ?></option>

                                    <?
                                }
                                ?>
                            </select>
                        </th>
                        <th class="tabela_title" colspan="">
                            <input type="text" name="txtdata_inicio"  value="<?php echo @$_GET['txtdata_inicio']; ?>" id="txtdata_inicio" alt="date"/>
                        </th>


                        <th class="tabela_title" colspan="">
                            <input type="text" name="txtdata_fim" value="<?php echo @$_GET['txtdata_fim']; ?>" id="txtdata_fim" alt="date"/>
                        </th>


                        <th class="tabela_title" colspan="">
                            <button type="submit" name="enviar">Pesquisar</button>
                        </th>






                    </tr>
                </form>

                </thead>
                <?php
//                $imagem = $this->session->userdata('imagem');
//                $consulta = $this->session->userdata('consulta');
//                $url = $this->utilitario->build_query_params(current_url(), $_GET);
//                
//                $consulta = $this->paciente->listar($_GET);
//                
//                
//                $total = $consulta->count_all_results();
//                $limit = 10;
//                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                ?>
                <tbody>
                    <?php
                    $relatoriohoraagendamentos = $this->guia->gerarelatoriohoraagendamentos($_GET)->get()->result();
                    ?>

                    <?
                    foreach (@$relatoriohoraagendamentos as $item) {
                        @$array[] = $item->operador_id;
                    }
                    @$result = array_unique($array);
                    ?>


                <table border="2">

                    <tr>
                        <td class="tabela_header">Nome do paciente</td>
                        <td class="tabela_header">Prontuário</td>
                        <!--<td class="tabela_header">Medicação</td>-->
                        <td class="tabela_header">Qtd. Tempo</td>
                        <!--<td class="tabela_header">Poltronas</td>-->

                        <!--<td class="tabela_header">Sit.Atendimento</td>-->
                        <td class="tabela_header">Telefone/Celular</td>
                        <td class="tabela_header">Observação</td>
                        <td class="tabela_header" colspan="2">Ação</td>
                    </tr>

                    <?
                    $estilo_linha = "tabela_content01";
                    if (count($result) > 0) {
                        foreach ($result as $item) {
                            ?>
 
                            <tr>

                                <td colspan="10" style="text-align: center;" class="tabela_header">


                                    <?
                                    foreach (@$relatoriohoraagendamentos as $item2) {

                                        if ($item2->operador_id == $item) {
                                            echo $item2->operador;
                                            break;
                                        }
                                    }
                                    ?>



                                </td>
                            </tr>



                            <?
                            foreach (@$relatoriohoraagendamentos as $value) {

                                if ($value->operador_id == $item) {

 
                                    ?>

 
                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>">                                   
                                            <?= $value->paciente; ?>
                                        </td >  
                                        <td class="<?php echo $estilo_linha; ?>">                                   
                                            <?= $value->prontuario; ?>
                                        </td> 
 
                                        <td class="<?php echo $estilo_linha; ?>">                                   
                                            <?echo $value->tempo_atendimento;?>
                                        </td>  
 
                                        <td class="<?php echo $estilo_linha; ?>">                                   
                                            <?= $value->telefone; ?>
                                        </td>  
 
                                        <td class="<?php echo $estilo_linha; ?>"><a title="<?= $value->observacao; ?>" style=" cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $value->hora_agendamento_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\  width=500,height=400');">=><?= $value->observacao; ?></td>         
                                        <!--<td class="<?php echo $estilo_linha; ?>" ><a href="<?= base_url() ?>ambulatorio/laudo/confirmarhoraagenda/<? echo $value->hora_agendamento_id; ?>">Confirmar</a></td>-->  
                                        <td class="<?php echo $estilo_linha; ?>" ><a href="<?= base_url() ?>ambulatorio/laudo/desativarhoraagenda/<? echo $value->hora_agendamento_id; ?>">Cancelar</a></td>  
                                    </tr>



                                    <?

                                }
                            }
                            ?>










                            <?
                        }
                    } else {
                        
                    }
                    ?>

                </table>






                <form method="post" action="<?php echo base_url() ?>ambulatorio/guia/gerarelatoriohoraagendamentos">
                    <input type="text" name="medico_post"  value="<? echo @$medico_post; ?>" hidden>
                    <input type="text" name="txtdata_inicio_post" value="<? echo @$data_inicio_post; ?>" hidden>
                    <input type="text" name="txtdata_fim_post" value="<? echo @$data_fim_post; ?>"  hidden>
                    <button type="submit" >IMPRIMIR</button> 
                </form>






                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="10">

                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>





<!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

</script>



