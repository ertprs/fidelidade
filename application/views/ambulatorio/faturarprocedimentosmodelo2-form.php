
<meta charset="UTF-8">

<style>
    .input_grande{
        width: 400px;
    }
    .input_pequeno{
        width: 150px;
    }
    input, label{
        margin-left: 10px;
    }
    legend{
        font-size: 15px;
    }
    #conteudo{
        overflow-y: auto;
    }
</style>
<?
if (count($forma_cadastradaTotal) > 0) {
    $valor_restante = $exame[0]->valor_total - $forma_cadastradaTotal[0]->valor_total_pago;
    $valor_total = $exame[0]->valor_total;
} else {
    $valor_restante = $exame[0]->valor_total;
    $valor_total = $exame[0]->valor_total;
}

  foreach ($forma_cadastrada as $value) {
    if ($value->forma_pagamento_id == 1000) {
        @$credito_cont++;
    }
}

// echo '<pre>';
// var_dump($forma_cadastradaTotal);
// die;
?>
<div id="conteudo"> <!-- Inicio da DIV content -->

    <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosfaturarmodelo2" method="post">
        <fieldset>
            <legend>Faturar</legend>
            <div>
                <table>
                    <tr>
                        <td>
                            <label>Valor Total a Faturar</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="valor_proc" id="valor_proc" class="input_pequeno" value="<?= number_format($valor_total, 2, ',', '.'); ?>" readonly />
                            <input type="hidden" name="valorafaturar" id="valorafaturar" class="input_pequeno" value="<?= $valor_restante; ?>" readonly />
                            <input type="hidden" name="guia_id" id="guia_id" class="texto01" value="<?= $guia_id; ?>"/>
                            <input type="hidden" name="array_exames" id="guia_id" class="texto01" value="<?= $exame[0]->array_exames; ?>"/>
                            <input type="hidden" name="array_valores" id="guia_id" class="texto01" value="<?= $exame[0]->array_valores; ?>"/>
                        </td>
                    </tr>


                </table>
                <br>
            </div>
        </fieldset>        

        <fieldset>        
            <legend>Adicionar Pagamento</legend>
            <table>  
                <tr>
                    <td>
                        <label>Desconto</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input step="0.01" type="number" name="desconto" min="0" max="<?= $valor_restante ?>" value="0" id="desconto" class="input_pequeno" value="" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Valor</label>
                    </td>
                    <td>
                        <label>Forma de pagamento</label>
                    </td>
                    <td>
                        <label>Ajuste(%)</label>
                    </td>
                    <td>
                        <label>Valor Ajustado</label>
                    </td>
                    <td>
                        <label>Parcelas</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="input_pequeno" required type="number" step="0.01" min=0 max='<?= $valor_restante ?>' name="valor1" id="valor1" value="0"  />
                        <input hidden="" class="input_pequeno"  name="paciente_id" id="paciente_id"  />
                    </td>
                    <td>
                        <select required  name="forma_pagamento_id" id="forma_pagamento_id" class="size2" >
                            <option value="">Selecione</option>
                            <? foreach ($forma_pagamento as $item) : ?> 
                                <option value="<?= $item->forma_pagamento_id; ?>"
                                         <?
                                if (@$credito_cont >= 1 && $item->forma_pagamento_id == 1000) {
                                    echo "disabled";
                                }
                                ?> 
                                        ><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>

                    </td>
                    <td>
                        <input class="input_pequeno" readonly type="text" name="ajuste1" id="ajuste1" size="2" value="<?= $valor; ?>"/> 
                    </td>
                    <td>
                        <input class="input_pequeno" readonly type="text" name="valorajuste1" id="valorajuste1" size="2" value="<?= $valor; ?>"/> 
                    </td>
                    <td>
                        <input  style="width: 60px;" type="number" name="parcela1" id="parcela1"  value="1" min="1" /> 
                    </td>

                </tr>
                <tr>
                    <td>
                        <label>Valor Pendente</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="valorFaturarVisivel" id="valorFaturarVisivel" class="input_pequeno" value="<?= number_format($valor_restante, 2, ',', '.'); ?>" readonly />

                    </td>
                </tr>
                <tr>
                    <td>
                        <? if ($valor_restante > 0) { ?>
                            <button type="submit" name="btnEnviar" id="btnEnviar" >
                                Adicionar
                            </button>
                        <? } else { ?>
                            <button disabled type="submit" name="btnEnviar" id="btnEnviar" >
                                Faturado
                            </button>
                        <? } ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        Observação
                    </td>    
                </tr>
                <tr>
                    <td>
                        <textarea type="text" id="observacao" name="observacao" class="texto"  value="" cols="50" rows="4"></textarea>  
                    </td>
                </tr>
            </table>


        </fieldset>    
        <fieldset>
            <?
            $desconto_total = 0;
            if (count(@$forma_cadastrada) > 0) {
                ?>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header">Valor Ajustado</th>
                            <th class="tabela_header">Forma de Pag.</th>
                            <th class="tabela_header">Ajuste</th>
                            <th class="tabela_header">Desconto</th>
                            <th class="tabela_header">Parcelas</th>
                            <!-- <th class="tabela_header">Data</th> -->
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        $y = 0;
                        $data_for = '';
                        $total_pago = 0;
                        foreach ($forma_cadastrada as $item) {
                            $desconto_total += $item->desconto;
                            $total_pago += $item->valor;

                            $array_financeiroPG = $item->array_financeiro;
                            $array_financeiroStr = str_replace('{', '', str_replace('}', '', $array_financeiroPG));
                            $array_financeiro = explode(',', $array_financeiroStr);

                            if ($item->data != $data_for) {
                                ?>
                                <tr>
                                    <th class="tabela_header" colspan="8"><?= date("d/m/Y", strtotime($item->data)); ?></th>

                                </tr>
                                <?
                            }
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tr>
                                <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?= number_format($item->valor_bruto, 2, ',', '.'); ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?= number_format($item->valor, 2, ',', '.'); ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>" style="min-width: 300px;"><center><? echo $item->forma_pagamento; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center><?= $item->ajuste . "%"; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?= number_format($item->desconto, 2, ',', '.'); ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>"><center><? echo $item->parcela; ?></center></td>
                        <!-- <td class="<?php echo $estilo_linha; ?>"><center><?= date("d/m/Y", strtotime($item->data)); ?></center></td> -->


                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <? $perfil_id = $this->session->userdata('perfil_id'); ?>
                            <? if (($perfil_id == 1 && !in_array('t', $array_financeiro))) { ?> 
                                <a onclick="javascript:return confirm('Deseja realmente excluir o pagamento?');" href="<?= base_url() ?>ambulatorio/guia/apagarfaturarprocedimentosmodelo2/<?= $item->forma_pagamento_id; ?>/<?= $guia_id ?>/<?= $item->data ?>" class="delete">
                                </a>
                            <? } ?>
                        </td>
                        </tr>


                        <?
                        $data_for = $item->data;
                    }
                    ?>
                    <tr>
                        <th class="tabela_header" colspan="7">Total Pago: <?= number_format($total_pago, 2, ',', '.') ?> | Desconto: <?= number_format($desconto_total, 2, ',', '.') ?></th>

                    </tr>
                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">
                        </th>
                    </tr>
                </tfoot>
            </table> 
        </fieldset>                    
    </form>


</div> <!-- Final da DIV content -->
</body>
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<?php
$this->load->library('utilitario');
// var_dump($this->session->flashdata('message'));die;
Utilitario::pmf_mensagem($this->session->flashdata('message'));
?>
<script type="text/javascript">

                        $(document).ready(function () { //Essa function serve para que o usuario não possa burlar o sistema atualizando a pagina para poder adicionar a quantidade de credito que quiser, talvez exista algo melhor.
                            $('#forma_pagamento_id').val(""); //seta o valor do select para vazio.
                        });

                        var formID = document.getElementById("form_faturar");
                        var send = $("#btnEnviar");
                        $(formID).submit(function (event) {
                            if (formID.checkValidity()) {
                                send.attr('disabled', 'disabled');
                            }
                        });
                        $(function () {
                            $('#desconto').change(function () {
                                descontoFuncao();
                            });
                        });

                        function descontoFuncao() {
                            desconto_semPonto = document.form_faturar.desconto.value;
                            desconto = parseFloat(desconto_semPonto);
                            restante_semPonto = document.form_faturar.valorafaturar.value;
                            restante = parseFloat(restante_semPonto);
                            valor_max = restante - desconto;
                            if (valor_max < 0) {
                                valor_max = 0;
                            }
                            // alert(valor_max);
                            $('#valor1').prop("max", valor_max);
                            $('#valorFaturarVisivel').val(valor_max);
                            return true;
                        }
                        descontoFuncao();

                        $(function () {
                            $('#forma_pagamento_id').change(function () {

                                if (this.value == 1000) {
                                    var selecionado = false;

                                    for (var i = 1; i < 5; i++) {
                                        if (i == 1) {
                                            continue;
                                        }
                                        if ($('#formapamento' + i).val() == 1000) {
                                            selecionado = true;
                                        }
                                    }

                                    if (!selecionado) {
                                        var valorDiferenca = $('#valor_proc').val();
                                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                                            if ($('#valor1').val() > parseFloat(j.saldo)) { // verificando se o valor digitado pelo o usuario é maior que o credito do paciente se for ele vai entrar e dar um alerta
                                                alert("Valor sugerido é maior que o Crédito do Paciente!");
                                                document.getElementById("valor1").max = j.saldo; //atribuindo o valor maximo do input que no caso é o proprio credito do paciente
                                            } else {
                                                $('#paciente_id').val(j.paciente_id); //mandando o paceinte_id para um input
                                                document.getElementById("valor1").max = valor_max; //case não entre na funcao acima então o valor maximo do input vai ser o proprio valor maximo que seria o resto. vc pode ver onde calcula isso um pouco mais acima só procurar por valor_max
                                            }

                                        });
                                    } else {
                                        $('#forma_pagamento_id').val('');

                                    }

                                } else {
                                    $('#valor1').removeAttr("readonly");

                                    document.getElementById("valor1").max = valor_max;

                                }

                                if ($(this).val()) {
                                    forma_pagamento_id = document.getElementById("forma_pagamento_id").value;
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {forma_pagamento_id: $(this).val(), ajax: true}, function (j) {
                                        options = "";
                                        parcelas = "";
                                        options = j[0].ajuste;
                                        parcelas = j[0].parcelas;
                                        numer_1_semPonto = document.form_faturar.valor1.value;
                                        numer_1 = parseFloat(numer_1_semPonto);
                                        // alert(numer_1);
                                        if (j[0].parcelas != null) {
                                            document.getElementById("parcela1").max = parcelas;
                                        } else {
                                            document.getElementById("parcela1").max = '1';
                                        }
                                        if (j[0].ajuste != null) {
                                            document.getElementById("ajuste1").value = options;
                                            valorajuste1 = (numer_1 * options) / 100;
                                            // pg1 = parseFloat(numer_1 + valorajuste1).toFixed(2);
                                            pg1 = numer_1 + valorajuste1;
                                            // console.log(pg1);
                                            document.getElementById("valorajuste1").value = pg1;
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                                        } else {
                                            document.getElementById("ajuste1").value = '0';
                                            document.getElementById("valorajuste1").value = '0';

                                        }
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#ajuste1').html('value=""');
                                }
                            });
                        });

                        $(function () {
                            $('#valor1').change(function () {
                                // console.log($('#forma_pagamento_id').val());
                                if ($('#forma_pagamento_id').val() == 1000) {
                                    var selecionado = false;

                                    for (var i = 1; i < 5; i++) {
                                        if (i == 1) {
                                            continue;
                                        }
                                        if ($('#formapamento' + i).val() == 1000) {
                                            selecionado = true;
                                        }
                                    }

                                    if (!selecionado) {

                                        var valorDiferenca = $('#valor_proc').val();

                                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {

                                            if ($('#valor1').val() > parseFloat(j.saldo)) {

                                                alert("Valor sugerido é maior que o Crédito do Paciente possui!");

                                                document.getElementById("valor1").max = j.saldo;

                                            } else {


                                                $('#paciente_id').val(j.paciente_id);


                                                document.getElementById("valor1").max = valor_max;

                                            }
                                        });
                                    } else {
                                        $('#forma_pagamento_id').val('');
                                        document.getElementById("valor1").max = valor_max;
                                    }


                                } else {
                                    $('#valor1').removeAttr("readonly");

                                }

                                if ($('#forma_pagamento_id').val() && $('#valor1').val() != '') {
                                    forma_pagamento_id = document.getElementById("forma_pagamento_id").value;
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {forma_pagamento_id: $('#forma_pagamento_id').val(), ajax: true}, function (j) {
                                        options = "";
                                        parcelas = "";
                                        options = j[0].ajuste;
                                        parcelas = j[0].parcelas;
                                        numer_1_semPonto = document.form_faturar.valor1.value;
                                        numer_1 = parseFloat(numer_1_semPonto);
                                        console.log(numer_1);
                                        if (j[0].parcelas != null) {
                                            document.getElementById("parcela1").max = parcelas;
                                        } else {
                                            document.getElementById("parcela1").max = '1';
                                        }
                                        if (j[0].ajuste != null) {
                                            document.getElementById("ajuste1").value = options;
                                            valorajuste1 = (numer_1 * options) / 100;
                                            pg1 = numer_1 + valorajuste1;
                                            valor_ajuste = parseFloat(pg1.toFixed(2));
                                            document.getElementById("valorajuste1").value = valor_ajuste;
                                            console.log(valor_ajuste);
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                                        } else {
                                            document.getElementById("ajuste1").value = '0';
                                            document.getElementById("valorajuste1").value = '0';

                                        }
                                        $('.carregando').hide();
                                    });
                                } else {
                                    $('#ajuste1').html('value=""');
                                }
                            });
                        });

</script>