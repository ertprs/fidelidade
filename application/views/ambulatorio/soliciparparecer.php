<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<title>Solicitar Parecer</title>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

//    if (isset($obj->_peso)) {
//        $peso = @$obj->_peso;
//    } else {
//        $peso = @$laudo_peso[0]->peso;
//    }
//    if (isset($obj->_altura)) {
//        $altura = @$obj->_altura;
//    } else {
//        $altura = @$laudo_peso[0]->altura;
//    }


    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
    <?php
    $this->load->library('utilitario');
    $utilitario = new Utilitario();
    $utilitario->pmf_mensagem($this->session->flashdata('message'));
    ?>
    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarsolicitarparecer/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <input type="hidden" name="ambulatorio_laudo_id" id="ambulatorio_laudo_id" class="texto01"  value="<?= @$ambulatorio_laudo_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Procedimento: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                           <!-- <td>Peso:<?= $peso ?></td>
                            <td>Altura:<?= $altura ?></td>-->

                        </tr>


                        <tr>                        

                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>
                       

                    </table>


                </fieldset>
                <fieldset>
                    <h1 align = "center">Solicitar Parecer</h1>

                </fieldset>

                <fieldset>
                    
                    <table border = "0" align = "center"> 
                        <tr>
                            <th><h3 align = "center" colspan = "4">Especialidade Parecer</h3></th>
                            
                        </tr> 
                        <tr>
                            <td>
                                <!--<option selected>-->
                                <select name="especialidade_parecer" id="especialidade_parecer" class="size3" required>
                                    <option value=''>SELECIONE</option>
                                    <?foreach ($especialidade as $key => $value) {?>
                                        <option value='<?=$value->especialidade_parecer_id?>'><?=$value->nome?></option>
                                    <?}?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><h3 align = "center" colspan = "4">Sub-Rotina</h3></th>
                            
                        </tr> 
                        <tr>
                            <td>
                                <!--<option selected>-->
                                <select name="sub_rotina" id="sub_rotina" class="size3">
                                   
                                   
                                </select>
                            </td>
                        </tr>
                        
                    </table>
                   

                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                       
                    </table>
                    
                </fieldset>
                    <?
                    if (count($parecer_lista) > 0) {
                    ?>
                    <table id="table_agente_toxico" border="0">
                        <thead>
                            <tr>
                                <th class="tabela_header">Data</th>
                                
                                <th class="tabela_header">Médico</th>
                                <th class="tabela_header">Status</th>
                                <th class="tabela_header">Especialidade</th>
                                <th class="tabela_header">Sub Rotina</th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($parecer_lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->solicitante; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->status; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->especialidade; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->subrotina; ?></td>
                                </tr>

                            </tbody>
                            <?
                        }
                    }
                    ?>

                </table> 
            </div>
        </form>
    </div>
</div>

<script>

$('#especialidade_parecer').change(function () {
    if ($(this).val()) {
        $.getJSON('<?= base_url() ?>autocomplete/solicitarparecersubrotina', {especialidade_parecer: $(this).val(), ajax: true}, function (j) {
            options = '<option value="">Selecione</option>';
            var selected = '';
            for (var c = 0; c < j.length; c++) {
                if(j.length == 1){
                    selected = 'selected';
                }
                options += '<option ' + selected + ' value="' + j[c].especialidade_parecer_subrotina_id + '">' + j[c].nome + '</option>';
            }
            $('#sub_rotina option').remove();
            $('#sub_rotina').append(options);
            $("#sub_rotina").trigger("chosen:updated");
        });
    } else {
        $('#sub_rotina').html('value=""');
    }
});

</script>