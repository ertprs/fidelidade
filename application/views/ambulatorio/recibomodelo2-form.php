
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
if (count($forma_cadastrada) > 0) {  
    $valor_restante = $forma_cadastrada[0]->valor_restante;
} else {
    $valor_restante = $pagamento[0]->valor;
}


foreach ($forma_cadastrada as $value) {
    if ($value->forma_pagamento_id == 1000) {
        @$credito_cont++;
    }
}

 
 $desconto_maximo = 100.00;
 

$total_desconto = $valor_restante * ($desconto_maximo / 100);
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');

?>
<div id="conteudo"> <!-- Inicio da DIV content -->

    <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadomodelo2" method="post">
           
        <fieldset>
            <?
            $desconto_total = 0;
            if (count(@$forma_cadastrada) > 0) {
                ?>
                <table id="table_agente_toxico" border="0" width="100%">
                    <thead>

                        <tr>
                            <th class="tabela_header">Valor</th>
                          
                            <th class="tabela_header">Forma de Pag.</th>
                            <th class="tabela_header">Desconto</th>
                            
                            <!-- <th class="tabela_header">Data</th> -->
                            <th class="tabela_header" colspan="2">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
//                                echo "<pre>";
//                                print_r($forma_cadastrada);

                        $estilo_linha = "tabela_content01";
                        $y = 0;
                        $data_for = '';
                        $total_pago = 0;
                        foreach ($forma_cadastrada as $item) {

                            $total_pago += $item->valor_bruto;
                            $desconto_total += $item->desconto;
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
                         
                        <td class="<?php echo $estilo_linha; ?>" style="min-width: 300px;"><center><? echo $item->forma_pagamento; ?></center></td>
                          <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?= number_format($item->desconto, 2, ',', '.'); ?></center></td>
                       
                
                       <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/guia/impressaorecibo2/<?= $item->paciente_contrato_parcelas_faturar_id ?>">Recibo</a>
                            </div>
                        </td> 
                        
                        </tr>


                        <?
                        $data_for = $item->data;
                    }
                    ?>
                    <tr>
                        <th class="tabela_header" colspan="8">Total Pago: <?= number_format($total_pago, 2, ',', '.') ?> </th>

                    </tr>
                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="6">
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
<script type="text/javascript" src="<?= base_url() ?>js/maskedmoney.js"></script>
<?php
$this->load->library('utilitario');
// var_dump($this->session->flashdata('message'));die;
$utilitario = new Utilitario();
$utilitario->pmf_mensagem($this->session->flashdata('message'));
?>
<script type="text/javascript">
     
    $("#valor_proc").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

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
                        var formID = document.getElementById("form_faturar");
                        var send = $("#btnEnviar");
                        $(formID).submit(function (event) {
                            if (formID.checkValidity()) {
                                send.attr('disabled', 'disabled');
                            }
                        });
                        $(function () {
                            $('#desconto').change(function () {
                                // alert('asdasd');
                                descontoFuncao();
                            });
                        });

 
                        function descontoFuncao() {
                            // alert('asdasd');
                            desconto_semPonto = document.form_faturar.desconto.value;
                            desconto = parseFloat(desconto_semPonto);
                            restante_semPonto = document.form_faturar.valorafaturar.value;
                            restante = parseFloat(restante_semPonto);
                            valor_max = restante - desconto;
                            if (valor_max < 0) {
                                valor_max = 0;
                            }
                            $('#valor1').prop("max", valor_max);
                            $('#valorFaturarVisivel').val(valor_max);
                            return true;
                        }
                        descontoFuncao();


                        $(document).ready(function () {


                            $('#forma_pagamento_id').val("");

                           
                             $("#desconto").prop('readonly', false);
                                
                            

                        });

                         
                       

                        $(function () {
                            $('#forma_pagamento_id').change(function () { 
                            
                               $('#valor1').removeAttr("readonly"); 
                               document.getElementById("valor1").max = valor_max;
 

                                if ($(this).val()) {
                                    forma_pagamento_id = document.getElementById("forma_pagamento_id").value;
                                     
                                    $('.carregando').show();
                                    $.getJSON('<?= base_url() ?>autocomplete/formaredimento/' + forma_pagamento_id + '/', {forma_pagamento_id: $(this).val(), ajax: true}, function (j) {
                                       
                                     
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
                                            pg1 = numer_1 + valorajuste1;
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
                               
                              $('#valor1').removeAttr("readonly");
 

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