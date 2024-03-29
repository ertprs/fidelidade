<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<div class="content"> <!-- Inicio da DIV content -->

    <? if ($this->session->userdata('perfil_id') == 1): ?>
        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>cadastros/caixa/novaentrada">
                Nova entrada
            </a>
        </div>
    <? endif; ?>
    <?
    $saldo = $this->caixa->saldo();
    $empresa = $this->caixa->empresa();
    $conta = $this->forma->listarforma();
    $tipo = $this->tipo->listartipo();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Entrada</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>cadastros/caixa/pesquisar">
                    <tr>
                        <th class="tabela_title">Conta</th>
                        <th class="tabela_title">Data Inicio</th>
                        <th class="tabela_title">Data Fim</th>
                        <th class="tabela_title">Tipo</th>
                        <th class="tabela_title">Classe</th>
                        <th class="tabela_title">Empresa</th>
                        <th class="tabela_title">Observacao</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="conta" id="conta" class="size2">
                                <option value="">TODAS</option>
                                <? foreach ($conta as $value) : ?>
                                    <option value="<?= $value->forma_entradas_saida_id; ?>" <?
                                    if (@$_GET['conta'] == $value->forma_entradas_saida_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <? if (isset($_GET['datainicio'])) { ?>
                                <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @$_GET['datainicio']; ?>" />
                            <? } else { ?>
    <!--                                <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @date('01/m/Y'); ?>" /> -->
                                <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1"  value="<?php echo @$_GET['datainicio']; ?>" />

                            <? } ?>
                        </th>
                        <th class="tabela_title">
                            <? if (isset($_GET['datafim'])) { ?>
                                <input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @$_GET['datafim']; ?>" />
                            <? } else { ?>
    <!--                                <input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @date('t/m/Y'); ?>" /> -->
                                <input type="text"  id="datafim" alt="date" name="datafim" class="size1"  value="<?php echo @$_GET['datafim']; ?>" />

                            <? } ?>
                        </th>
                        <th class="tabela_title">
                            <select name="nome" id="nome" class="size2">
                                <option value="">TODOS</option>
                                <? foreach ($tipo as $value) : ?>
                                    <option value="<?= $value->tipo_entradas_saida_id; ?>" <?
                                    if (@$_GET['nome'] == $value->tipo_entradas_saida_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->descricao; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="nome_classe" id="nome_classe" class="size2">
                                <option value="">TODOS</option>
                                <option value="PARCELA">PARCELA</option>
                                <option value="CARTEIRA">CARTEIRA</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="empresa" id="empresa" class="size1">
                                <option value="">TODOS</option>
                                <? foreach ($empresa as $value) : ?>
                                    <option value="<?= $value->financeiro_credor_devedor_id; ?>" <?
                                    if (@$_GET['empresa'] == $value->financeiro_credor_devedor_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->razao_social; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="obs" name="obs" class="size2"  value="<?php echo @$_GET['obs']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                </form>
                </th>

                </tr>
                <tr>

                    <th class="tabela_title">Saldo Total em Caixa:  <?= number_format($saldo[0]->sum, 2, ",", ".") ?></th>
                </tr>
                </thead>
            </table>
            <table>
                <thead>
                    </form>
                    </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header">Classe</th>
                        <th class="tabela_header" width="90px;">Dt entrada</th>
                        <th class="tabela_header" width="90px;">Valor</th>
                        <th class="tabela_header">Conta</th>
                        <th class="tabela_header">Observacao</th>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->caixa->listarentrada($_GET);
                $total = $consulta->count_all_results();
                $limit = 60;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $data['permissao'] = $this->empresa->listarpermissoes();
//                        print_r( $data['permissao']);

                        $totaldalista = 0;
                        $lista = $this->caixa->listarentrada($_GET)->orderby('data desc')->orderby('razao_social')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                             $totaldalista += $item->valor;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                           
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?
                                        if ($item->razao_social == "") {
                                            echo $item->empresa;
                                        }else{
                                            
                                           echo $item->razao_social;
                                        }
                                
                                
                                ?></td>
                                
                                
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><b><?= number_format($item->valor, 2, ",", "."); ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->conta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>
                               
                                    <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                         <? if ($this->session->userdata('perfil_id') == 1 || $data['permissao'][0]->excluir_entrada_saida == 't'): ?>
                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/caixa/excluirentrada/<?= $item->entradas_id ?>">Excluir</a></div>
                                         <? endif; ?>
                                    </td>
                               
                              
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                          <? if ($this->session->userdata('perfil_id') == 1): ?>
                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>cadastros/caixa/anexarimagementrada/<?= $item->entradas_id ?>">Arquivos</a></div>
                                     <? endif; ?>
                                    </td>
                              
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                        <th class="tabela_footer" colspan="3">
                            <? if ($total > 0) { ?>
                                Valor Total : <?= number_format($totaldalista, 2, ",", "."); ?>
                            <? } ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <br>
            <table>
                <thead>
                <th class="tabela_header">Contas</th>
                <th class="tabela_header">Saldo</th>
                </thead>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($conta as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $valor = $this->caixa->listarsomaconta($item->forma_entradas_saida_id);
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($valor[0]->total, 2, ",", "."); ?></td>
                        </tr>
                    <? } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="2">
                            Saldo Total: <?= number_format($saldo[0]->sum, 2, ",", ".") ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $('#nome').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalista', {nome: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    options += '<option value="PARCELA">PARCELA</option>';
                    options += '<option value="CARTEIRA">CARTEIRA</option>';  
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#nome_classe').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#nome_classe').html('<option value="">TODOS</option><option value="PARCELA">PARCELA</option><option value="CARTEIRA">CARTEIRA</option>');
           
            }
        });
    });

    $(function () {
        $("#datainicio").datepicker({
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
        $("#datafim").datepicker({
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

</script>
