<?
$empresa = $this->guia->listarempresa();
$operador_id = $this->session->userdata('operador_id');
//$empresa_id = $this->session->userdata('empresa_id');
$perfil_id = $this->session->userdata('perfil_id');
?>
<div class="content"> <!-- Inicio da DIV content -->

    <?
    if (count($contratos) > 0) {

        foreach ($contratos as $item) {
            if ($item->ativo == 't') {
                $ativo = 't';
                break;
            } else {
                $ativo = 'f';
            }
        }
    } else {
        $ativo = 'f';
    }
    ?>


    <?
    if (count($quantidade_funcionarios) > 0) {
        ?>
        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>cadastros/pacientes/carregarfuncionario/<?php echo @$empresa_id; ?>">
                Novo funcionário(a)
            </a>
        </div>

        <?
    } else {
        
    }
    ?> 

    <?
    foreach ($funcionarios as $value):
//        $resultado = $this->paciente->somarparcelasdefuncionarios($value->paciente_id);
        @$contador2{$value->forma_pagamento_id} ++;
    endforeach;
    ?>

    <?
    foreach ($quantidade_funcionarios as $value):

        @$contador{$value->forma_pagamento_id} ++;
    endforeach;
    ?>



    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Detalhes</a></h3>
        <div>

            <table >
                <thead>
                    <tr>
                        <th class="tabela_header"  colspan="1">Quantidade</th>
                        <th class="tabela_header"  colspan="1">Quantidade Usadas</th>
                        <th class="tabela_header" colspan="1">Plano</th>
                        <th class="tabela_header" colspan="1">Parcelas</th>
                        <th class="tabela_header" colspan="2">Detalhes</th>

                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach ($quantidade_funcionarios as $item):
                        (@$estilo_linha == "tabela_content01") ? @$estilo_linha = "tabela_content02" : @$estilo_linha = "tabela_content01";

                        @$valor_total_parcelas += ($item->parcelas * $item->valor) * $item->qtd_funcionarios;
                        @$quantidade_funcionarios_num += $item->qtd_funcionarios;

                        @$valor_mensal += $item->valor;
                        ?>
                        <tr>

                            <td class="<?php echo @$estilo_linha; ?>"><?= $item->qtd_funcionarios ?></td> 

                            <?
                            @$quantidade_total += $item->qtd_funcionarios;
                            ?>

                            <td class="<?php echo @$estilo_linha; ?>"> <?
                                if (@$contador2{$item->forma_pagamento_id} == "") {
                                    echo "0";
                                } else {
                                    echo @$contador2{$item->forma_pagamento_id};
                                    @$contador_tota_usados += $contador2{$item->forma_pagamento_id};
                                }
                                ?></td>

                            <td class="<?php echo @$estilo_linha; ?>"><?= $item->plano ?></td>
                            <td class="<?php echo @$estilo_linha; ?>"> <?= $item->parcelas ?> x <?= $item->valor ?> </td>
                            <td class="<?php echo @$estilo_linha; ?>" >


                                <?
                                if (count($contratos) <= 0) {
                                    ?>
                                    <a href="#!" onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/editarquantidade/" . $item->qtd_funcionarios_empresa_id . "/" . $item->forma_pagamento_id . "/" . $empresa_id ?> ', '_blank', 'width=600,height=300 ');">
                                        Editar Quantidade
                                    </a> 
                                    <?
                                } else {
                                    
                                }
                                ?>

                            </td>
                            <td class="<?php echo @$estilo_linha; ?>" >

                                <a onclick="javascript: return confirm('Deseja realmente excluir o Funcionário?');"    href="<?= base_url() ?>cadastros/pacientes/excluirfuncionarioqtd/<?= $item->qtd_funcionarios_empresa_id; ?>" target="_blank">
                                    Excluir
                                </a>
                            </td>
                        </tr>

                        <?
                    endforeach;
                    ?>
                </tbody>   
            </table>
            <?
            if (@$contador_tota_usados >= 1 && count($contratos) <= 0 ) {
                @$pode_finalizar = "true";
            } else {
                @$pode_finalizar = "false";
            }
            
            ?> 

            <br><br> 
            <form method="post" action="<?= base_url() ?>cadastros/pacientes/gravarquantidadefuncionarios">



                <table>
                    <tr><td>Quantidade: <input type="number" name="qtd" id="qtd" min="1"  value="1"> 
                            <input type="hidden" name="empresa_id_qtd" id="empresa_id_qtd"   value="<?php echo @$empresa_id; ?>"> </td></tr>
                    <tr>
                        <td> Plano:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
                            <select id="plano" name="plano"  required="">
                                <option value=""> Selecione</option>
                                <?
                                foreach ($forma_pagamento as $item) {
                                    ?> 
                                    <?php
                                    if ($contador{$item->forma_pagamento_id} < 1) {
                                        ?>
                                        <option value='<?= $item->forma_pagamento_id ?>' ><?= $item->nome; ?></option>
                                        <?
                                    } else {
                                        ?>
                                        <option value='<?= $item->forma_pagamento_id ?>' disabled><?= $item->nome; ?></option>

                                        <?
                                    }
                                    ?>

                                    <?
                                }
                                ?>
                            </select>


                        </td>
                    </tr>

                    <tr><td class="valores">



                            <input required="" id="testec"   type="radio" name="testec" value=""/>1 x 0.00<br>

                            <input required="" id="testec"   type="radio" name="testec" value=""/>5 x 0.00<br> 


                            <input required="" id="testec"   type="radio" name="testec" value=" "/>6 x 0.00<br> 


                            <input required="" id="ttesteceste"   type="radio" name="testec" value=" "/>10 x 0.00<br> 

                            <input required="" id="testec"   type="radio" name="testec" value=" "/>11 x 0.00<br>  


                            <input required="" id="testec"   type="radio" name="testec" value=" "/>12 x 0.00<br> 


                        </td></tr>
                    <tr><td> Preço:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="precototal"  readonly="false">  
                        </td></tr>


                    <tr> 
                        <td> <br><input type="submit" value="Adicionar" > 


                            <?
                            if ($pode_finalizar == "true") {
                                ?>

                                <button>  
                                    <a href="#!" onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/finalizarcadastrodefuncionarios/" . $empresa_id ?> ', '_blank', 'width=900,height=600');" style="text-decoration: none;">
                                        Finalizar
                                    </a> 
                                </button>


                                <?
                            } else {
                                ?>




                                <?
                            }
                            ?>






                        </td>



                    </tr>


                </table>

            </form>








        </div>

    </div>








    <div class="content ficha_ceatox" style="margin-left:-1%;"> 


        <fieldset>
            <legend>Funcionários</legend>
            <table>
                <thead>
                    <tr> 
                      <!--<input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$empresa_id; ?>" />--> 
                    </tr>
                    <tr>
                        <th class="tabela_header"  colspan="1">Nome</th>
                        <th class="tabela_header"  colspan="3">Plano</th>
                        <th class="tabela_header" colspan="2">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
//                $consulta = $this->paciente->listarfuncionariosempresacadastro($_GET);
                $total = count($funcionarios);
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        foreach ($funcionarios as $item) {
                            $resultado = $this->paciente->somarparcelasdefuncionarios($item->paciente_id);
                            foreach ($resultado as $value) {

                                @$total_p += $value->valor;
                            }
                            (@$estilo_linha == "tabela_content01") ? @$estilo_linha = "tabela_content02" : @$estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo @$estilo_linha; ?>"><?= @$item->paciente; ?></td>
                                <td class="<?php echo @$estilo_linha; ?>"colspan="1"><?= @$item->forma_pagamento; ?></td>

                                <td  class="<?php echo @$estilo_linha; ?>">

                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                            Editar 

                                        </a>
                                    </div>
                                </td>

                                <td  class="<?php echo @$estilo_linha; ?>">

                                    <div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir o Funcionário?');"    href="<?= base_url() ?>cadastros/pacientes/excluirfuncionario/<?= $empresa_id; ?>/<?= $item->paciente_id; ?>">
                                            Excluir
                                        </a>
                                    </div>
                                </td>

                                <td  class="<?php echo @$estilo_linha; ?>">
                                    <div class="bt_link">
                                        <a     href="<?= base_url() ?>ambulatorio/guia/listardependentes/<?= $item->paciente_id; ?>/<?= $item->paciente_contrato_id; ?>">
                                            Dependentes
                                        </a> 
                                    </div>
                                </td> 
                                <td  class="<?php echo @$estilo_linha; ?>"> 
                                    <div class="bt_link">
                                        <a     href="#!" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/novocontratocadastro/" . $item->paciente_id . '/' . $empresa_id . "/" . $item->forma_pagamento_id ?> ', '_blank', 'width=500,height=200,left=510,top=300');">
                                            Plano
                                        </a> 
                                    </div>
                                </td>

                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="6">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>


                    </tr>
                </tfoot>
            </table>
            <br>
            Total 
            <table>

                <?
                foreach ($quantidade_funcionarios as $item):
                    ?>

                    <tr>
                        <td>
    <?php echo $item->parcelas . "x de " . $item->qtd_funcionarios . " x " . $item->valor . " = " . ($item->qtd_funcionarios * $item->valor); ?>
                        </td>
                    </tr>



    <?
endforeach;

//              
//            if (@$valor_total_parcelas == "") {
//                echo "0,00";
//            } else {
//                echo number_format($valor_total_parcelas, 2, ',', '.');
//            }
?>

            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td>


<?
if (@$valor_total_parcelas == ''):
    ?> 
                            <!--                            <div  style="width: 20%;border:1px solid silver;text-align: center;"  > 
                            
                            
                                                            <b style="color:silver;" >   Gerar Pagamento Iugu</b>  
                            
                                                        </div>  -->
    <?
else:
    ?>

    <?
    if ($empresa_id != $this->session->userdata('empresa_id') && $this->session->userdata('perfil_id') == 1) {
        ?>

                                <!--                                <div  style="width: 20%;" class="bt_link" >
                                                                    <a    href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiuguempresacadastro/<?= $empresa_id ?> " > Gerar Pagamento Iugu</a> 
                                                                </div> -->

                                <?
                            } else {
                                ?>
                                <div  style="width: 29%;" class="bt_link" >
                                    <b>Somente a Empresa Pode Gerar o Boleto</b> 
                                </div> 
                                <?
                            }
                            ?>







<? endif; ?>



                    </td>
                </tr> 
            </table>

        </fieldset>  








        <fieldset>
            <legend>Contrato</legend>
<?
$guia_id = 0;
$cancelado = 0;
if (count($contratos) > 0) {
    ?>
                <table >
                    <thead>
                        <tr>
                            <th class="tabela_header">Contrato</th>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Status</th>
                            <th colspan="5" class="tabela_header"></th>


                        </tr>
                    </thead>
                    <tbody>
    <?
    $estilo_linha = "tabela_content01";
    foreach ($contratos as $item) :
        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
        ?>
                            <tr>
                                <td style="width: 150px;" class="<?php echo $estilo_linha; ?>" ><?= @$item->paciente_contrato_id ?></td>
                                <td style="width: 150px;" class="<?php echo $estilo_linha; ?>" ><?= substr(@$item->data_cadastro, 8, 2) . "/" . substr(@$item->data_cadastro, 5, 2) . "/" . substr(@$item->data_cadastro, 0, 4); ?></td>

                            <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">Ativo</td>
        <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" style="width: 150px;">Inativo</td>
        <? } ?>
                                <? if ($perfil_id != 6 && $perfil_id != 5) { ?>
                                    <? $perfil_id = $this->session->userdata('perfil_id'); ?>

                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                        <!--                                        <div class="bt_link_new" style="width: 100px;">
                                                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . @$item->paciente_contrato_id ?> ', '_blank', 'width=1000,height=1000');">
                                                                                        Carteira
                                                                                    </a>
                                                                                </div>-->
                                    </td>



            <?
            if ($item->ativo == 't') {
                ?> 

                                        <td class="<?php echo $estilo_linha; ?>" >       

                                            <div class="bt_link_new" style="width: 100px;">
                                                <a target="_blank" href="<?= base_url() . "ambulatorio/guia/listarpagamentosempresa/" . @$item->paciente_contrato_id . "/" . $empresa_id ?>">
                                                    Pagamento
                                                </a>
                                            </div> 

                                        </td>
                <?
            } else {
                ?>
                                        <td class="<?php echo $estilo_linha; ?>" >       

                                            <div class="" style="width: 100px;">

                                            </div> 

                                        </td>

                <?
            }
            ?>


                                    <td class="<?php echo $estilo_linha; ?>" >       
                                        <div class="bt_link_new" style="width: 100px;">
                                            <a target="_blank" href="<?= base_url() . "ambulatorio/guia/anexararquivoscontrato/" . @$item->paciente_contrato_id ?>">
                                                Arquivos
                                            </a>
                                        </div>
                                    </td>

            <? if ($perfil_id == 1 && $item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" >       
                                            <div class="bt_link_new" style="width: 100px;">
                                                <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas');"   href="<?= base_url() . "ambulatorio/guia/excluircontratoempresa/" . @$item->paciente_contrato_id ?>" target="_blank" >
                                                    Excluir
                                                </a>
                                            </div>
                                        </td>   
            <? } else {
                ?>
                                        <td class="<?php echo $estilo_linha; ?>"> 
                <? if ($ativo == 'f') { ?>
                                                <div class="bt_link_new" style="width: 100px;">
                                                    <a onclick="javascript: return confirm('Deseja realmente re-ativar o contrato?');"   href="<?= base_url() . "ambulatorio/guia/ativarcontratoempresa/" . @$item->paciente_contrato_id ?>" target="_blank">
                                                        Re-Ativar
                                                    </a>
                                                </div>
                                            <? } ?>
                                        </td>      
            <? } ?>
            <?
            if ($operador_id == 1) {
                ?>
                                        <td class="<?php echo $estilo_linha; ?>" >       
                                            <div class="bt_link_new" style="width: 100px;">
                                                <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas. Excluir por esse botão fará o contrato sumir');"   href="<?= base_url() . "ambulatorio/guia/excluircontratoempresaadmin/" . @$item->paciente_contrato_id ?>" target="_blank">
                                                    Excluir (Admin)
                                                </a>
                                            </div>
                                        </td> 
                <?
            }
            ?>
        <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" colspan="5"> 
                                    </td>       
                                <? } ?>

                                                                                <!--                            <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                                                                    <div class="bt_link_new">
                                                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/integracaoiugu/" . $item->paciente_contrato_id ?> ', '_blank', 'width=800,height=1000');">
                                                                                            Pagamento Iugu
                                                                                        </a>
                                                                                    </div>
                                                                                </td>-->




                            </tr>


        <?
    endforeach;
} else {
    $estilo_linha = "tabela_content01";
    ?>
                    <table >
                        <thead>
                            <tr>
                                <th class="tabela_header">Contrato</th>
                                <th class="tabela_header">Titular</th>
                                <th colspan="2" class="tabela_header"></th>


                            </tr>
                        </thead>
                        <tbody>

                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= @$titular['0']->paciente_id; ?>/<?= @$titular['0']->paciente_contrato_id ?>');"><?= @$titular['0']->paciente_contrato_id; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= @$titular['0']->paciente_id; ?>/<?= @$titular['0']->paciente_contrato_id ?>');"><?= @$titular['0']->nome; ?></td>
    <? if ($perfil_id != 6 && $perfil_id != 5) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                <!--                                <div class="bt_link_new">
                                                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . @$titular['0']->paciente_contrato_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=1000');">
                                                                        Carteira
                                                                    </a>
                                                                </div>-->
                            </td>

    <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"></td>
    <? } ?>    
    <?
}
?>
                    </tbody>                                
                    <br>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="11">
                            </th>
                        </tr>
                    </tfoot>
                </table>



        </fieldset> 


    </div>

</div> <!-- Final da DIV content -->



<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<script type="text/javascript">
<?php if ($this->session->flashdata('message') != ''): ?>
                                alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>



                            window.onload = function () {
                                $('#plano').val('');
                                $('#precototal').val('');
                                $('#qtd').val(1);
                            }


                            $(function () {
                                $('#plano').change(function () {
                                    if ($(this).val()) {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/carregarprecos', {tipo: $(this).val(), ajax: true}, function (j) {

                                            var options = '';
                                            for (var c = 0; c < j.length; c++) {
                                                //CARREGANDO TODOS OS INPUTS COM OS RESPECTIVOS VALORES DOS SEUS CAMPOS VINDO DO AUTOCOMPLETE
                                                options += ' <input required="" id="checkboxvalor1" onclick="return calcularpreco();" type="radio" name="checkboxvalor1" value="01-' + j[0].valor1 + '  "/>1 x ' + j[0].valor1 + ' <br>\n\
                                                                      <input required id="checkboxvalor1" onclick="return calcularpreco();" type="radio" name="checkboxvalor1"  value="05-' + j[0].valor5 + ' "/>5 x ' + j[0].valor5 + '<br>\n\
                                                                      <input required id="checkboxvalor1" onclick="return calcularpreco();" type="radio" name="checkboxvalor1"  value="06-' + j[0].valor6 + ' "/>6 x ' + j[0].valor6 + '<br>   \n\
                                                                      <input required id="checkboxvalor1" onclick="return calcularpreco();" type="radio" name="checkboxvalor1"  value="10-' + j[0].valor10 + ' "/>10 x ' + j[0].valor10 + '  <br> \n\
                                                                         <input required id="checkboxvalor1" onclick="return calcularpreco();" type="radio" name="checkboxvalor1"  value="11-' + j[0].valor11 + ' "/>11 x ' + j[0].valor11 + ' <br>     \n\
                                                                     <input required id="checkboxvalor1" onclick="return calcularpreco();"    type="radio" name="checkboxvalor1"  value="12-' + j[0].valor12 + ' "  />12 x ' + j[0].valor12 + '<br>               ';

                                            }
                                            $('.valores').html(options).show();
                                            $('.carregando').hide();
                                        });
                                    } else {
//                                                    $('#classe').html('<option value="">TODOS</option>');
                                    }
                                });
                            });




                            function calcularpreco() {
                                //PEGAGANDO O VALOR DA QUANTIDADE 
                                var qtd = document.getElementById("qtd").value;
                                //PEGANDO O VALOR DO RADIO SELECIONADO
                                var valor = $("input[type=radio][name='checkboxvalor1']:checked").val();
                                // PEGANDO O VALOR DO RADIO SELECIONADO
                                var parcelas = $("input[type=radio][name='checkboxvalor1']:checked").val();
                                //SEPARANDO O VALOR QUE VEIO DO RADIO PARA PEGAR SOMENTE O VALOR DA PARCELA
                                var resvalor = valor.substr(3, 5);
                                //SEPARANDO A QUANTIDADE QUE VEIO DO RADIO PARA PEGAR SOMENTE A QUANTIDADE
                                var resparcelas = parcelas.substr(0, 2);
                                //CALCULANDO O VALOR DE TODA PARCELA
                                var precototal = resparcelas * resvalor;
                                //MULTIPLICANDO PELA QUANTIDADE DE FUNCIONARIO PARA PODER SABER QUANTO A EMPRESA VAI GASTAR NO TOTAL.
                                var preco_mais_funcionarios = precototal * qtd;
                                //COLOCANDO O VALOR EM UM INPUT SOMENTE PARA MOSTRAR PARA O USUARIO
                                $('#precototal').val("R$ " + preco_mais_funcionarios);

                            }


                            $(document).ready(function () {
                                $("#qtd").change(function () {
                                    //PEGAGANDO O VALOR DA QUANTIDADE 
                                    var qtd = document.getElementById("qtd").value;
                                    //PEGANDO O VALOR DO RADIO SELECIONADO
                                    var valor = $("input[type=radio][name='checkboxvalor1']:checked").val();
                                    // PEGANDO O VALOR DO RADIO SELECIONADO
                                    var parcelas = $("input[type=radio][name='checkboxvalor1']:checked").val();
                                    //SEPARANDO O VALOR QUE VEIO DO RADIO PARA PEGAR SOMENTE O VALOR DA PARCELA
                                    var resvalor = valor.substr(3, 5);
                                    //SEPARANDO A QUANTIDADE QUE VEIO DO RADIO PARA PEGAR SOMENTE A QUANTIDADE
                                    var resparcelas = parcelas.substr(0, 2);
                                    //CALCULANDO O VALOR DE TODA PARCELA
                                    var precototal = resparcelas * resvalor;
                                    //MULTIPLICANDO PELA QUANTIDADE DE FUNCIONARIO PARA PODER SABER QUANTO A EMPRESA VAI GASTAR NO TOTAL.
                                    var preco_mais_funcionarios = precototal * qtd;
                                    //COLOCANDO O VALOR EM UM INPUT SOMENTE PARA MOSTRAR PARA O USUARIO
                                    $('#precototal').val("R$ " + preco_mais_funcionarios);
                                });
                            });

                            $(function () {
                                $("#accordion").accordion();
                            });


</script>
