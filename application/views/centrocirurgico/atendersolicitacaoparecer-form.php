<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/langs/pt_BR.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/jquery.tinymce.min.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/tinymce.min.js"></script>-->


<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<head>
    <title>Parecer</title>
</head>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$parecer[0]->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
//    var_dump(isset(@$parecer[0]->peso), isset(@$parecer[0]->altura)); die;
    if (@$parecer[0]->peso != '') {
        $peso = @$parecer[0]->peso;
    } else {
        $peso = @$laudo_peso[0]->peso;
    }
    if (@$parecer[0]->altura != '') {
        $altura = @$parecer[0]->altura;
    } else {
        $altura = @$laudo_peso[0]->altura;
    }

    if (@$parecer[0]->hipertensao != '') {
        $hipertensao = @$parecer[0]->hipertensao;
    } else {
        $hipertensao = @$laudo_peso[0]->hipertensao;
    }
    
    if (@$parecer[0]->diabetes != '') {
        $diabetes = @$parecer[0]->diabetes;
    } else {
        $diabetes = @$laudo_peso[0]->diabetes;
    }


   
    $opc_telatendimento = array(@$parecer[0]->tela);
   
//    var_dump($empresapermissao[0]->dados_atendimentomed); die;
    if (@$empresapermissao[0]->dados_atendimentomed != '') {
        $opc_dadospaciente = json_decode(@$empresapermissao[0]->dados_atendimentomed);
    } else {
        $opc_dadospaciente = array();
    }


    $integracaosollis = $this->session->userdata('integracaosollis');
    $laudo_sigiloso = $this->session->userdata('laudo_sigiloso');
    $operador_id = $this->session->userdata('operador_id');
    if (@$parecer[0]->status == 'FINALIZADO' && $laudo_sigiloso == 't' && $operador_id != 1) {
        $readonly = 1;
    } else {
        $readonly = 0;
    }
    if (@$parecer[0]->status == 'FINALIZADO' && $laudo_sigiloso == 't') {
        $adendo = true;
    } else {
        $adendo = false;
    }
    if (@$parecer[0]->estado_civil == 1):$estado_civil = 'Solteiro';
    endif;
    if (@$parecer[0]->estado_civil == 2):$estado_civil = 'Casado';
    endif;
    if (@$parecer[0]->estado_civil == 3):$estado_civil = 'Divorciado';
    endif;
    if (@$parecer[0]->estado_civil == 4):$estado_civil = 'Viuvo';
    endif;
    if (@$parecer[0]->estado_civil == 5):$estado_civil = 'Outros';
    endif;
//    var_dump($laudo_sigiloso); die;
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarparecercirurgico/<?= @$centrocirurgico_parecer_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$parecer[0]->guia_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table style="border-collapse: collapse; width: 100%;"> 
                        <tr >
                            <? if (in_array('paciente', $opc_dadospaciente)) { ?>
                                <td colspan="4" width="400px;">Paciente:<?= @$parecer[0]->paciente ?></td>
                            <? } ?>
                            <? if (in_array('nascimento', $opc_dadospaciente)) { ?>
                                <td colspan="1">Nascimento:<?= substr(@$parecer[0]->nascimento, 8, 2) . "/" . substr(@$parecer[0]->nascimento, 5, 2) . "/" . substr(@$parecer[0]->nascimento, 0, 4); ?></td>
                            <? } ?>
                            <? if (in_array('idade', $opc_dadospaciente)) { ?>
                                <td colspan="3">Idade: <?= $teste ?></td>
                            <? } ?>
                            <? if (in_array('sexo', $opc_dadospaciente)) { ?>
                                <td colspan="2">Sexo: <?= @$parecer[0]->sexo ?></td>
                            <? } ?>


<td rowspan="3"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= @$parecer[0]->paciente_id ?>.jpg" width="100" height="120" /></td>
                        </tr>
                        <tr>
                           
                            <? if (in_array('telefone', $opc_dadospaciente)) { ?>
                                <td colspan="2" style="width: 200px">Telefone: <?= @$parecer[0]->telefone ?></td>
                            <? } ?> 
                            <? if (in_array('ocupacao', $opc_dadospaciente)) { ?>
                                <td colspan="4" width="300px;">Ocupação: <?= @$parecer[0]->profissao_cbo ?> </td>
                            <? } ?>

                            <? if (in_array('estadocivil', $opc_dadospaciente)) { ?>
                                <td colspan="2" style="width: 200px">Estado Civíl: <?= @$estado_civil ?> </td>
                            <? } ?>

                        </tr>
                        

                        <tr>
                            <? if (in_array('solicitante', $opc_dadospaciente)) { ?>
                                <td colspan="4" width="400px;">Solicitante: <?= @$parecer[0]->solicitante ?></td>
                            <? } ?>
                         

<!--<td>Indicacao: <?= @$parecer[0]->indicado ?></td>-->

                        </tr>
                        <tr>
                            <? if (in_array('endereco', $opc_dadospaciente)) { ?>
                                <td colspan="10">Endereco: <?= @$parecer[0]->logradouro ?>, <?= @$parecer[0]->numero . ' ' . @$parecer[0]->bairro ?> <?=(in_array('cidade', $opc_dadospaciente))? ' , ' . @$parecer[0]->cidade : '';?> - <?= @$parecer[0]->uf ?></td>
                            <? } ?>
                        </tr>
                        <tr>
                            <? if (in_array('nome_pai', $opc_dadospaciente)) { ?>
                                <td colspan="5" style="width: 200px">Pai: <?= @$parecer[0]->nome_pai ?></td>
                            <? } ?>    
                            <? if (in_array('ocupacao_pai', $opc_dadospaciente)) { ?>
                                <td colspan="5" style="width: 200px">Ocupação do Pai: <?= @$parecer[0]->ocupacao_pai ?></td>
                            <? } ?>
                        </tr>
                        <tr>
                            <? if (in_array('nome_mae', $opc_dadospaciente)) { ?>
                                <td colspan="5" style="width: 200px">Mãe: <?= @$parecer[0]->nome_mae ?></td>
                            <? } ?>
                            <? if (in_array('ocupacao_mae', $opc_dadospaciente)) { ?>
                                <td colspan="5" style="width: 200px">Ocupação da Mãe: <?= @$parecer[0]->ocupacao_mae ?></td>
                            <? } ?>

                        </tr>

                    </table>

                    <table>
                                               
                    </table>



                </fieldset>
               
                <table>
                    <tr>
                        
                        <td>
                            <? if (in_array('editar', $opc_telatendimento)) { ?>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregar/<?= @$parecer[0]->paciente_id ?>');" >
                                        Editar</a></div>
                            <? } ?>
                        </td>

                  
                        <td>
                            <? if (in_array('histconsulta', $opc_telatendimento)) { ?>
                                <div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/laudo/carregarlaudohistorico/<?= @$parecer[0]->paciente_id ?>">Hist. Consulta</a></div>
                            <? } ?>
                        </td>
                        <td>
                            <div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/laudo/carregaranamineseantigo/<?= @$parecer[0]->paciente_id ?>">Hist. Antigo</a></div>
                        </td>


                    </tr>
                </table>
                <div>

                    <fieldset>
                        <legend>MEDIDAS</legend>
                        <table>
                            <tr>
                                <td><font size = -1>Peso:</font></td>
                                <td width="50px;"><font size = -1><input type="number" step="0.01" name="Peso" id="Peso" class="texto02"  alt="decimal"  onblur="calculaImc()" value="<?= $peso ?>"/></font></td>
                                <td width="50px;"><font size = -1>Kg</font></td>
                                <td ><font size = -1>Altura:</font></td>
                                <td width="50px;"><font size = -1><input type="number" name="Altura" step="0.1" id="Altura" class="texto02" value="<?= $altura; ?>" onblur="calculaImc()"/></font></td> <!--onblur="history.go(0)"-->
                                <td width="50px;"><font size = -1>Cm</font></td>
                                <!--</tr>-->
                                <?
//                            $imc = 0;
//                            $peso =  @$parecer[0]->peso;
//                            $altura = substr(@$parecer[0]->altura, 0, 1) . "." .  substr(@$parecer[0]->altura, 1, 2);
//                            $altura = floatval($altura);
//                            if($altura != 0){
//                            $imc = $peso / pow($altura, 2);
//                            }
                                ?>
                                <!--<tr>-->
                                <td><font size = -1>IMC</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="imc" id="imc" class="texto02"  readonly/></font></td>
                                <td width="30px;"></td>
<!--                                <td ><font size = -1></font></td>
                                <td width="60px;"></td>
                                <td width="60px;"></td>-->
                                <!--                            </tr>
                                                            <tr>-->
                                <td><font size = -1>Diabetes:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="diabetes" id="diabetes" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$diabetes == 'nao'):echo 'selected';
                                        endif;
                                        ?> >Não</option>
                                        <option value='sim' <?
                                        if (@$diabetes == 'sim'):echo 'selected';
                                        endif;
                                        ?> >Sim</option>
                                    </select><font></td>
                                <td width="20px;"></td>
                                <td><font size = -1>Hipertens&atilde;o:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="hipertensao" id="hipertensao" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$hipertensao == 'nao'):echo 'selected';
                                        endif;
                                        ?> >Não</option>
                                        <option value='sim' <?
                                        if (@$hipertensao == 'sim'):echo 'selected';
                                        endif;
                                        ?> >Sim</option>
                                    </select><font></td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <? if ($empresapermissao[0]->oftamologia == 't' && @$parecer[0]->grupo == 'OFTALMOLOGIA') { ?>
                    <script>
                        $(function () {
                        $("#tabs").tabs();
                        });
                        $(".tab-ativa").tabs("option", "active", 1);
                    </script>    

                <? }
                ?>
                <? if ($empresapermissao[0]->oftamologia != 't' || @$parecer[0]->grupo != 'OFTALMOLOGIA') { ?>
                    <script>
                        $(function () {
                        $("#tabs").tabs();
                        });
                        $(".tab-ativa").tabs("option", "active", 1);
                    </script>    

                <? }
                ?>


                <div>

                    <fieldset>
                        <div id="tabs">
                            <? if ($empresapermissao[0]->oftamologia == 't' && @$parecer[0]->grupo == 'OFTALMOLOGIA') { ?>
                                <ul>
                                    <li><a class="tab-ativa" href="#tabs-2">Anamnese</a></li>
                                    
                                </ul>
                            <? }
                            ?>

                            
                                <? if ($empresapermissao[0]->oftamologia == 'f' || @$parecer[0]->grupo != 'OFTALMOLOGIA') { ?>
                                    <ul>
                                        <li><a class="tab-ativa" href="#tabs-2">Anamnese</a></li>                                        
                                                                               
                                    </ul>
                                <? }
                                ?>
                                <div id="tabs-2">
                                <!-- <div>
                                    <label>Modelo</label>
                                    <select name="exame" id="exame" class="size2" >
                                        <option value='' >selecione</option>
                                        <?php foreach ($lista as $item) { ?>
                                            <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?
                                    if (@$parecer[0]->cabecalho == "") {
                                        $cabecalho = @$parecer[0]->procedimento;
                                    } else {
                                        $cabecalho = @$parecer[0]->cabecalho;
                                    }
                                    ?>
                                    
                                </div> -->
                                <!--<br>-->
                                
                                <style>
                                .row{
                                    display: flex;
                                }
                                .col{
                                    flex: 1;
                                    align-self: center;
                                }

                                </style>    
                                <div class="row">
                                    <div class="col">
                                        <?
                                        $contador_col = 0;

                                        ?>

                                        
                                        <table>
                                            <tr><td rowspan="11" >
                                                    <label>Texto</label>
                                                    <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 100%"></textarea>
                                                    <!-- <input type="hidden" id="laudo_antigo" name="laudo_antigo" value="<?= @$parecer[0]->texto; ?>"> -->
                                                    <div>
                                   
                                                        <label>Status</label>
                                                        <select name="status" id="status" class="size2">
                                                            <option value='ESPERA' <?=(@$parecer[0]->status == 'ESPERA')? 'selected':'';?>>ESPERA</option>
                                                            <option value='AGUARDANDO EXAMES' <?=(@$parecer[0]->status == 'AGUARDANDO EXAMES')? 'selected':'';?>>AGUARDANDO EXAMES</option>
                                                            <option value='EM ATENDIMENTO' <?=(@$parecer[0]->status == 'EM ATENDIMENTO')? 'selected':'';?>>EM ATENDIMENTO</option>
                                                            <option value='FINALIZADO' <?=(@$parecer[0]->status == 'FINALIZADO')? 'selected':'';?>>FINALIZADO</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <hr>
                                                    <button type="submit" name="btnEnviar">Salvar</button>
                                                </td>

                                                <? if (in_array('receituario', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">

                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituario/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Receituario</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if ($integracaosollis == 't') { ?>
                                                    <td width="40px;"><div class="bt_link_new">

                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarprescricao/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Prescrição</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('parecercirurgia', $opc_telatendimento)) { ?>
                                                    
                                                    <td>
                                                        <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoparecer/<?= @$parecer[0]->ambulatorio_laudo_id ?>');" >
                                                            Parecer C.P</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                            

                                               
                                                    <? if (in_array('laudoapendicite', $opc_telatendimento)) { ?>
                                                       
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoapendicite/<?= @$parecer[0]->ambulatorio_laudo_id ?>');" >
                                                                Laudo Apendicite
                                                            </a>
                                                        </div>
                                                    
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                    <? } ?>
                                                

                                               
                                            <!-- </tr>
                                            <tr> -->
                                                <? if (in_array('rotinas', $opc_telatendimento)) { ?>
                                                    <td width="40px;">
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarrotinas/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Rotinas</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>

                                                <? if (in_array('historicoimprimir', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaohistoricoescolhermedico/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Imprimir Histórico</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                    <? if (in_array('cirurgias', $opc_telatendimento)) { ?>
                                                        <td>
                                                            <div class="bt_link_new">
                                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preenchercirurgia/<?= $centrocirurgico_parecer_id ?>');" >
                                                                    Cirurgias</a>
                                                            </div>
                                                        </td>
                                                        <?
                                                            $contador_col++;
                                                            if($contador_col == 2){
                                                                $contador_col = 0;
                                                                echo '</tr><tr>';
                                                            }
                                                        ?>
                                                    <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('receituarioesp', $opc_telatendimento)) { ?>
                                                    <td width="40px;">
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituarioespecial/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                R. especial
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('cirurgias', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencherexameslab/<?= $centrocirurgico_parecer_id ?>');" >
                                                                E. Laboratoriais</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                
                                                
                                                <? if (in_array('eco', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencherecocardio/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Ecocardiograma</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('atestado', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaratestado/<?= $centrocirurgico_parecer_id ?>/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Atestado</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('ecostress', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencherecostress/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Eco Stress</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('declaracao', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/escolherdeclaracao/<?= @$parecer[0]->paciente_id ?>');" >
                                                                Declaração</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('cate', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preenchercate/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Cateterismo</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                               
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('arquivos', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Arquivos</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('holter', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencherholter/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Holter 24h</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('aih', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/imprimirmodeloaih/<?= $centrocirurgico_parecer_id ?>');" >
                                                                AIH</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('cintil', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preenchercintilografia/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Cintilografia</a>
                                                        </div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('consultar_procedimento', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/procedimentoplanoconsultalaudo);" >
                                                                Consultar Proc...</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                               
                                                <? if (in_array('mapa', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preenchermapa/<?= $centrocirurgico_parecer_id ?>');" >
                                                            Mapa</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('sadt', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/pesquisarsolicitacaosadt/<?= @$parecer[0]->paciente_id ?>/<?= @$parecer[0]->convenio_id ?>/<?= @$parecer[0]->medico_parecer1 ?>');" >
                                                                Solicitação SADT</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                                <? if (in_array('te', $opc_telatendimento)) { ?>
                                                    <td>
                                                        <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preenchertergometrico/<?= $centrocirurgico_parecer_id ?>');" >
                                                            Teste Ergométrico</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            <!-- </tr> -->
                                            <!-- <tr> -->
                                                <? if (in_array('cadastro_aso', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/cadastroaso/<?= @$parecer[0]->paciente_id ?>/<?= @$parecer[0]->medico_parecer1 ?>');" >
                                                                Cadastro ASO</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                <? if (in_array('solicitarparecer', $opc_telatendimento)) { ?>
                                                    <td width="40px;"><div class="bt_link_new">
                                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/solicitarparecer/<?= @$parecer[0]->paciente_id ?>/<?= $centrocirurgico_parecer_id ?>');" >
                                                                Solicitar Parecer</a></div>
                                                    </td>
                                                    <?
                                                        $contador_col++;
                                                        if($contador_col == 2){
                                                            $contador_col = 0;
                                                            echo '</tr><tr>';
                                                        }
                                                    ?>
                                                <? } ?>
                                                
                                            </tr>
                                            <tr>
                                                <td width="40px;"><div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $centrocirurgico_parecer_id ?>/');" >
                                                            Imprimir</a></div>
                                                </td>

                                            </tr>

                                            
                                            


                                        </table>
                                        <!-- style="display:none;" -->
                                        <table >
                                            <tr>
                                         
                                                <tr>
                                                    <td style="width: 700px; min-heigth: 300px;">
                                                        <div>
                                                            <label><h3>Histórico do Parecer</h3></label>
                                                            <textarea id="adendo" name="laudo_antigo" class="adendo" rows="30" cols="80" style="width: 100%"><?= @$parecer[0]->texto; ?></textarea>
                                                        </div>  
                                                    </td>
                                                </tr>
                                            
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table>
                                            <tr>

                                                <td>
                                                <center><font color="#FF0000" size="6" face="Arial Black"><span id="clock1"></span><script>setTimeout('getSecs()', 1000);</script></font></center>
                                                </td>
                                            </tr>
                                            
                                            
                                        
                                        </table>  
                                    </div>
                                      
                                </div>
                                    <?
                                    $perfil_id = $this->session->userdata('perfil_id');
                                    ?>
                                
                            </div>
                            
                            

                        </div>

                       
                        
                    </fieldset>
                    <br>
                    <br>
                    <fieldset>
                        <legend><b><font size="3" color="red">Arquivos Anexados Paciente</font></b></legend>
                        <table>
                            <tr>
                                <?
                                $l = 0;
                                if ($arquivos_paciente != false):
                                    foreach ($arquivos_paciente as $value) :
                                        $l++;
                                        ?>

                                        <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . @$parecer[0]->paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . @$parecer[0]->paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a target="_blank"  href="<?= base_url() ?>cadastros/pacientes/excluirimagemlaudo/<?= @$parecer[0]->paciente_id ?>/<?= $value ?>">Excluir</a></td>
                                        <?
                                        if ($l == 8) {
                                            ?>
                                        </tr><tr>
                                            <?
                                        }
                                    endforeach;
                                endif
                                ?>
                        </table>
                    </fieldset>
                    <br>
                    <br>
                    <fieldset>
                        <legend><b><font size="3" color="red">Arquivos Anexados Laudo</font></b></legend>
                        <table>
                            <tr>
                                <?
                                $o = 0;
                                if ($arquivos_anexados != false):
                                    foreach ($arquivos_anexados as $value) :
                                        $o++;
                                        ?>

                                        <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $centrocirurgico_parecer_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/consulta/" . $centrocirurgico_parecer_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a href="<?= base_url() ?>ambulatorio/laudo/excluirimagemlaudo/<?= $centrocirurgico_parecer_id ?>/<?= $value ?>">Excluir</a></td>
                                        <?
                                        if ($o == 8) {
                                            ?>
                                        </tr><tr>
                                            <?
                                        }
                                    endforeach;
                                endif
                                ?>
                        </table>
                    </fieldset>
                    <br>
                    <br>
                    <fieldset>
                        <legend><b><font size="3" color="red">Historico de consultas</font></b></legend>
                        <div>
                            <?
                            // Esse código serve para mostrar os históricos que foram importados
                            // De outro sistema STG.
                            // Na hora que o médico finaliza o atendimento, o sistema manda os dados para o endereço do sistema
                            // Digitado no cadastro do médico, caso exista ele salva numa tabela especifica.
                            // Para não criar um outro local onde iriam aparecer os atendimentos dessa tabela 
                            // Há essa lógica aqui embaixo para inserir no meio dos outros atendimentos da ambulatorio_laudo os outros
                            // da integração
                            $contador_teste = 0;
                            // Contador para utilizar no array
//                            $historico = array();
                            foreach ($historico as $item) {
                                // Verifica se há informação
                                if (isset($historicowebcon[$contador_teste])) {
                                    // Define as datas
                                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                                    $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data));
                                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                                    while ($data_while > $data_foreach) {
                                        ?>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td ><span style="color: #007fff">Integração</span></td>
                                                </tr>
                                                <tr>
                                                    <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                                                </tr>
                                                <?
                                                $idade = 0;
                                                $dataFuturo2 = $historicowebcon[$contador_teste]->data;
                                                $dataAtual2 = @$parecer[0]->nascimento;
                                                if($dataAtual2 != ''){
                                                    $date_time2 = new DateTime($dataAtual2);
                                                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                                    $teste2 = $diff2->format('%Y');
                                                    $idade = $teste2;
                                                }
                                                ?>
                                                <tr>
                                                    <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                                </tr>
                                                <tr>
                                                    <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                                                </tr>

                                                <tr>
                                                    <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <?
                                        $contador_teste ++;
                                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                                        if (isset($historicowebcon[$contador_teste])) {
                                            $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data_cadastro));
                                        } else {
                                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                        </tr>
                                        <?
                                        $idade = 0;
                                        $dataFuturo2 = $item->data_cadastro;
                                        $dataAtual2 = @$parecer[0]->nascimento;
                                        if($dataAtual2 != ''){
                                            $date_time2 = new DateTime($dataAtual2);
                                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                            $teste2 = $diff2->format('%Y');
                                            $idade = $teste2;
                                        }
                                        ?>
                                        <tr>
                                            <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                        </tr>
                                        <tr>
                                            <td >Medico: <?= $item->medico; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Tipo: <?= $item->procedimento; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Queixa principal: <?= $item->texto; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Arquivos anexos:
                                                <?
                                                $this->load->helper('directory');
                                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                                $w = 0;
                                                if ($arquivo_pasta != false):
                                                    foreach ($arquivo_pasta as $value) :
                                                        $w++;
                                                        ?>

                                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                                        <?
                                                        if ($w == 8) {
                                                            
                                                        }
                                                    endforeach;
                                                    $arquivo_pasta = "";
                                                endif
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            <? }
                            ?>
                        </div>
                        <?
                        if (count($historico) == 0 || $contador_teste < count($historicowebcon)) {
                            while ($contador_teste < count($historicowebcon)) {
                                ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><span style="color: #007fff">Integração</span></td>
                                        </tr>
                                        <tr>
                                            <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                                        </tr>
                                        <?
                                        $idade = 0;
                                        $dataFuturo2 = $historicowebcon[$contador_teste]->data;
                                        $dataAtual2 = @$parecer[0]->nascimento;
                                        if($dataAtual2 != ''){
                                            $date_time2 = new DateTime($dataAtual2);
                                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                            $teste2 = $diff2->format('%Y');
                                            $idade = $teste2;
                                        }
                                        ?>
                                        <tr>
                                            <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                        </tr>
                                        <tr>
                                            <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                                        </tr>

                                        <tr>
                                            <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <hr>

                                <?
                                $contador_teste++;
                            }
                        }
                        ?>

                        <!-- <div>
                            <? foreach ($historicoantigo as $itens) {
                                ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td >Data: <?= substr($itens->data_cadastro, 8, 2) . "/" . substr($itens->data_cadastro, 5, 2) . "/" . substr($itens->data_cadastro, 0, 4); ?></td>
                                        </tr>
                                        <tr>
                                            <td >Queixa principal: <?= $itens->laudo; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            <? }
                            ?>
                        </div> -->

                    </fieldset>

                    <fieldset>
                        <legend><b><font size="3" color="red">Historico de exames</font></b></legend>
                        <div>

                            <?
                            $contador_exame = 0;
                            foreach ($historicoexame as $item) {
                                // Verifica se há informação
                                if (isset($historicowebexa[$contador_exame])) {
                                    // Define as datas
                                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                                    $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data));
                                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                                    while ($data_while > $data_foreach) {
                                        ?>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td ><span style="color: #007fff">Integração</span></td>
                                                </tr>
                                                <tr>
                                                    <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                                                </tr>
                                                <?
                                                $idade = 0;
                                                $dataFuturo2 = $historicowebexa[$contador_exame]->data;
                                                $dataAtual2 = @$parecer[0]->nascimento;
                                                if($dataAtual2 != ''){
                                                    $date_time2 = new DateTime($dataAtual2);
                                                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                                    $teste2 = $diff2->format('%Y');
                                                    $idade = $teste2;
                                                }
                                                ?>
                                                <tr>
                                                    <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                                </tr>
                                                <tr>
                                                    <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                                                </tr>

                                                <tr>
                                                    <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <?
                                        $contador_exame ++;
                                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                                        if (isset($historicowebexa[$contador_exame])) {
                                            $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data_cadastro));
                                        } else {
                                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <table>
                                    <tbody>


                                        <tr>
                                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                        </tr>
                                        <?
                                        $idade = 0;
                                        $dataFuturo2 = $item->data_cadastro;
                                        $dataAtual2 = @$parecer[0]->nascimento;
                                        if($dataAtual2 != ''){
                                            $date_time2 = new DateTime($dataAtual2);
                                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                            $teste2 = $diff2->format('%Y');
                                            $idade = $teste2;
                                        }
                                        ?>
                                        <tr>
                                            <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                        </tr>
                                        <tr>
                                            <td >Medico: <?= $item->medico; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Tipo: <?= $item->procedimento; ?></td>
                                        </tr>
                                        <tr>
                                            <?
                                            $this->load->helper('directory');
                                            $arquivo_pastaimagem = directory_map("./upload/$item->exames_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
                                            if ($arquivo_pastaimagem != false) {
                                                sort($arquivo_pastaimagem);
                                            }
                                            $i = 0;
                                            if ($arquivo_pastaimagem != false) {
                                                foreach ($arquivo_pastaimagem as $value) {
                                                    $i++;
                                                }
                                            }
                                            ?>
                                            <td >Imagens : <font size="2"><b> <?= $i ?></b>
                                                <?
                                                if ($arquivo_pastaimagem != false):
                                                    foreach ($arquivo_pastaimagem as $value) {
                                                        ?>
                                                        <a onclick="javascript:window.open('<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?>"></a>
                                                        <?
                                                    }
                                                    $arquivo_pastaimagem = "";
                                                endif
                                                ?>
                                                <!--                <ul id="sortable">

                                                                </ul>-->
                                            </td >
                                        </tr>
                                        <tr>
                                            <td >Laudo: <?= $item->texto; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Arquivos anexos:
                                                <?
                                                $this->load->helper('directory');
                                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                                $w = 0;
                                                if ($arquivo_pasta != false):

                                                    foreach ($arquivo_pasta as $value) :
                                                        $w++;
                                                        ?>

                                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                                        <?
                                                        if ($w == 8) {
                                                            
                                                        }
                                                    endforeach;
                                                    $arquivo_pasta = "";
                                                endif
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style='width:10pt;border:solid windowtext 1.0pt;
                                                border-bottom:none;mso-border-top-alt:none;border-left:
                                                none;border-right:none;' colspan="10">&nbsp;</th>
                                        </tr>


                                    </tbody>
                                </table>
                            <? }
                            ?>
                            <?
                            if (count($historico) == 0 || $contador_exame < count($historicowebexa)) {
                                while ($contador_exame < count($historicowebexa)) {
                                    ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td><span style="color: #007fff">Integração</span></td>
                                            </tr>
                                            <tr>
                                                <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                                            </tr>
                                            <tr>
                                                <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                                            </tr>
                                            <?
                                            $idade = 0;
                                            $dataFuturo2 = $historicowebexa[$contador_exame]->data;
                                            $dataAtual2 = @$parecer[0]->nascimento;
                                            if($dataAtual2 != ''){
                                                $date_time2 = new DateTime($dataAtual2);
                                                $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                                $teste2 = $diff2->format('%Y');
                                                $idade = $teste2;
                                            }
                                            ?>
                                            <tr>
                                                <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                            </tr>
                                            <tr>
                                                <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                                            </tr>

                                            <tr>
                                                <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                                            </tr>
                                            <tr>
                                                <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <hr>

                                    <?
                                    $contador_exame++;
                                }
                            }
                            ?>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend><b><font size="3" color="red">Historico de especialidades</font></b></legend>
                        <div>

                            <?
                            $contador_especialidade = 0;
                            foreach ($historicoespecialidade as $item) {
                                // Verifica se há informação
                                if (isset($historicowebesp[$contador_especialidade])) {
                                    // Define as datas
                                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                                    $data_while = date("Y-m-d", strtotime($historicowebesp[$contador_especialidade]->data));
                                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                                    while ($data_while > $data_foreach) {
                                        ?>

                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td ><span style="color: #007fff">Integração</span></td>
                                                </tr>
                                                <tr>
                                                    <td >Empresa: <?= $historicowebesp[$contador_especialidade]->empresa; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Data: <?= substr($historicowebesp[$contador_especialidade]->data, 8, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 5, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 0, 4); ?></td>
                                                </tr>
                                                <?
                                                $idade = 0;
                                                $dataFuturo2 = $historicowebesp[$contador_especialidade]->data;
                                                $dataAtual2 = @$parecer[0]->nascimento;
                                                if($dataAtual2 != ''){
                                                    $date_time2 = new DateTime($dataAtual2);
                                                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                                    $teste2 = $diff2->format('%Y');
                                                    $idade = $teste2;
                                                }
                                                ?>
                                                <tr>
                                                    <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                                </tr>
                                                <tr>
                                                    <td >Medico: <?= $historicowebesp[$contador_especialidade]->medico_integracao; ?></td>
                                                </tr>

                                                <tr>
                                                    <td >Tipo: <?= $historicowebesp[$contador_especialidade]->procedimento; ?></td>
                                                </tr>
                                                <tr>
                                                    <td >Queixa principal: <?= $historicowebesp[$contador_especialidade]->texto; ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <hr>
                                        <?
                                        $contador_especialidade ++;
                                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                                        if (isset($historicowebesp[$contador_especialidade])) {
                                            $data_while = date("Y-m-d", strtotime($historicowebesp[$contador_especialidade]->data_cadastro));
                                        } else {
                                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <table>
                                    <tbody>


                                        <tr>
                                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                        </tr>
                                        <?
                                        $idade = 0;
                                        $dataFuturo2 = $item->data_cadastro;
                                        $dataAtual2 = @$parecer[0]->nascimento;
                                        if($dataAtual2 != ''){
                                            $date_time2 = new DateTime($dataAtual2);
                                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                            $teste2 = $diff2->format('%Y');
                                            $idade = $teste2;
                                        }
                                        ?>
                                        <tr>
                                            <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                        </tr>
                                        <tr>
                                            <td >Medico: <?= $item->medico; ?></td>
                                        </tr>
                                        <tr>
                                            <td >Tipo: <?= $item->procedimento; ?></td>
                                        </tr>
                                        <tr>
                                            <?
                                            $this->load->helper('directory');
                                            $arquivo_pastaimagem = directory_map("./upload/$item->exames_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$especialidade_id/");
                                            if ($arquivo_pastaimagem != false) {
                                                sort($arquivo_pastaimagem);
                                            }
                                            $i = 0;
                                            if ($arquivo_pastaimagem != false) {
                                                foreach ($arquivo_pastaimagem as $value) {
                                                    $i++;
                                                }
                                            }
                                            ?>
                                            <td >Imagens : <font size="2"><b> <?= $i ?></b>
                                                <?
                                                if ($arquivo_pastaimagem != false):
                                                    foreach ($arquivo_pastaimagem as $value) {
                                                        ?>
                                                        <a onclick="javascript:window.open('<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?>"></a>
                                                        <?
                                                    }
                                                    $arquivo_pastaimagem = "";
                                                endif
                                                ?>
                                                <!--                <ul id="sortable">

                                                                </ul>-->
                                            </td >
                                        </tr>
                                        <tr>
                                            <td >Laudo: <?= $item->texto; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Arquivos anexos:
                                                <?
                                                $this->load->helper('directory');
                                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                                $w = 0;
                                                if ($arquivo_pasta != false):

                                                    foreach ($arquivo_pasta as $value) :
                                                        $w++;
                                                        ?>

                                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                                        <?
                                                        if ($w == 8) {
                                                            
                                                        }
                                                    endforeach;
                                                    $arquivo_pasta = "";
                                                endif
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style='width:10pt;border:solid windowtext 1.0pt;
                                                border-bottom:none;mso-border-top-alt:none;border-left:
                                                none;border-right:none;' colspan="10">&nbsp;</th>
                                        </tr>


                                    </tbody>
                                </table>
                            <? }
                            ?>
                            <?
                            if (count($historico) == 0 || $contador_especialidade < count($historicowebesp)) {
                                while ($contador_especialidade < count($historicowebesp)) {
                                    ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td><span style="color: #007fff">Integração</span></td>
                                            </tr>
                                            <tr>
                                                <td >Empresa: <?= $historicowebesp[$contador_especialidade]->empresa; ?></td>
                                            </tr>
                                            <tr>
                                                <td >Data: <?= substr($historicowebesp[$contador_especialidade]->data, 8, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 5, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 0, 4); ?></td>
                                            </tr>
                                            <tr>
                                                <td >Medico: <?= $historicowebesp[$contador_especialidade]->medico_integracao; ?></td>
                                            </tr>

                                            <tr>
                                                <td >Tipo: <?= $historicowebesp[$contador_especialidade]->procedimento; ?></td>
                                            </tr>
                                            <tr>
                                                <td >Queixa principal: <?= $historicowebesp[$contador_especialidade]->texto; ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <hr>

                                    <?
                                    $contador_especialidade++;
                                }
                            }
                            ?>
                        </div>

                    </fieldset>
                    <fieldset>
                        <legend><b><font size="3" color="red">Digitaliza&ccedil;&otilde;es</font></b></legend>
                        <div>
                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <?
                                            $this->load->helper('directory');
                                            $arquivo_pasta = directory_map("./upload/paciente/{$parecer[0]->paciente_id}/");

                                            $w = 0;
                                            if ($arquivo_pasta != false):

                                                foreach ($arquivo_pasta as $value) :
                                                    $w++;
                                                    ?>

                                                <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . @$parecer[0]->paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . @$parecer[0]->paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?></td>
                                                <?
                                                if ($w == 8) {
                                                    
                                                }
                                            endforeach;
                                            $arquivo_pasta = "";
                                        endif
                                        ?>
                                        </td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>

                    </fieldset>
                    </form>

                </div> 
            </div> 
    </div> 
</div> <!-- Final da DIV content -->
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>
<!--<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script> -->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui.js" ></script>


<script type="text/javascript">
                                            jQuery('#rev').change(function () {
                                            if (this.checked) {
                                            var tag = '<table><tr><td><input type="radio" name="tempoRevisao" value="1a"><span>1 ano</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="6m" required><span>6 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="3m"><span>3 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="1m"><span>1 mes</span></td></tr></table>';
                                            jQuery(".dias").append(tag);
                                            } else {
                                            jQuery(".dias span").remove();
                                            jQuery(".dias input").remove();
                                            }
                                            });
<? if ((int) @$parecer[0]->dias_retorno != '0') { ?>
                                                jQuery(".dias_retorno_div").show();
<? } else { ?>
                                                jQuery(".dias_retorno_div").hide();
<? } ?>

                                            jQuery('#ret').change(function () {
                                            if (this.checked) {
                                            jQuery(".dias_retorno_div").show();
                                            } else {
                                            jQuery(".dias_retorno_div").hide();
                                            }
                                            });
                                            // jQuery("#Altura").mask("999", {placeholder: " "});
//                                                    jQuery("#Peso").mask("999", {placeholder: " "});

////////// ORDENANDO OS SELECTS DA OFTAMOLOGIA//////////////////

                                            function oftamologia_od_esferico() {
                                            var itensOrdenados = $('#oftamologia_od_esferico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_od_esferico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_od_esferico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_od_esferico ?>';
                                                //        alert(teste);
                                                $('#oftamologia_od_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_od_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_od_esferico();
                                            function oftamologia_oe_esferico() {
                                            var itensOrdenados = $('#oftamologia_oe_esferico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_oe_esferico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_oe_esferico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_oe_esferico ?>';
                                                //        alert(teste);
                                                $('#oftamologia_oe_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_oe_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_oe_esferico();
                                            function oftamologia_od_cilindrico() {
                                            var itensOrdenados = $('#oftamologia_od_cilindrico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_od_cilindrico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_od_cilindrico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_od_cilindrico ?>';
                                                //        alert(teste);
                                                $('#oftamologia_od_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_od_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_od_cilindrico();
                                            function oftamologia_oe_cilindrico() {
                                            var itensOrdenados = $('#oftamologia_oe_cilindrico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_oe_cilindrico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_oe_cilindrico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_oe_cilindrico ?>';
                                                $('#oftamologia_oe_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_oe_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_oe_cilindrico();
                                            function oftamologia_oe_eixo() {
                                            var itensOrdenados = $('#oftamologia_oe_eixo option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_oe_eixo').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_oe_eixo != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_oe_eixo ?>';
                                                //        alert(teste);
                                                $('#oftamologia_oe_eixo').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_oe_eixo').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_oe_eixo();
                                            function oftamologia_oe_av() {
                                            var itensOrdenados = $('#oftamologia_oe_av option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_oe_av').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_oe_av != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_oe_av ?>';
                                                //        alert(teste);
                                                $('#oftamologia_oe_av').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_oe_av').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_oe_av();
                                            function oftamologia_od_eixo() {
                                            var itensOrdenados = $('#oftamologia_od_eixo option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_od_eixo').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_od_eixo != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_od_eixo ?>';
                                                //        alert(teste);
                                                $('#oftamologia_od_eixo').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_od_eixo').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_od_eixo();
                                            function oftamologia_od_av() {
                                            var itensOrdenados = $('#oftamologia_od_av option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_od_av').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_od_av != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_od_av ?>';
                                                //        alert(teste);
                                                $('#oftamologia_od_av').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_od_av').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_od_av();
                                            function oftamologia_ad_esferico() {
                                            var itensOrdenados = $('#oftamologia_ad_esferico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_ad_esferico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_ad_esferico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_ad_esferico ?>';
                                                //        alert(teste);
                                                $('#oftamologia_ad_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_ad_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_ad_esferico();
                                            function oftamologia_ad_cilindrico() {
                                            var itensOrdenados = $('#oftamologia_ad_cilindrico option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#oftamologia_ad_cilindrico').html(itensOrdenados);
<? if (@$parecer[0]->oftamologia_ad_cilindrico != '') { ?>
                                                var teste = '<?= @$parecer[0]->oftamologia_ad_cilindrico ?>';
                                                //        alert(teste);
                                                $('#oftamologia_ad_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#oftamologia_ad_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            oftamologia_ad_cilindrico();
                                            function acuidade_oe() {
                                            var itensOrdenados = $('#acuidade_oe option').sort(function (a, b) {
                                            return a.text < b.text ? - 1 : 1;
                                            });
                                            $('#acuidade_oe').html(itensOrdenados);
<? if (@$parecer[0]->acuidade_oe != '') { ?>
                                                var teste = '<?= @$parecer[0]->acuidade_oe ?>';
                                                //        alert(teste);
                                                $('#acuidade_oe').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#acuidade_oe').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            acuidade_oe();
                                            function acuidade_od() {
                                            var acuidade_oditensOrdenados = $('#acuidade_od option').sort(function (a, b) {
//                        alert(b.text);
                                            return a.text < b.text ? - 1 : 1;
                                            });
//        console.log(acuidade_oditensOrdenados);
                                            $('#acuidade_od').html(acuidade_oditensOrdenados);
<? if (@$parecer[0]->acuidade_od != '') { ?>
                                                var teste = '<?= @$parecer[0]->acuidade_od ?>';
                                                //        alert(teste);
                                                $('#acuidade_od').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
                                                $('#acuidade_od').find('option:contains(" ")').prop('selected', true);
<? } ?>
                                            }
                                            acuidade_od();
//////////////////////////////////////////////////



                                            function validar(dom, tipo) {
                                            switch (tipo) {
                                            case'num':
                                                    var regex = /[A-Za-z]/g;
                                            break;
                                            case'text':
                                                    var regex = /\d/g;
                                            break;
                                            }
                                            dom.value = dom.value.replace(regex, '');
                                            }


                                            pesob1 = document.getElementById('Peso').value;
                                            peso = parseFloat(pesob1.replace(',', '.'));
//                                        peso = pesob1.substring(0, 2)  + "." + pesob1.substring(3, 1);
                                            alturae1 = document.getElementById('Altura').value;
                                            var res = alturae1.substring(0, 1) + "." + alturae1.substring(1, 3);
                                            var altura = parseFloat(res);
                                            imc = peso / Math.pow(altura, 2);
                                            //imc = res;
                                            resultado = imc.toFixed(2)
                                                    document.getElementById('imc').value = resultado.replace('.', ',');
                                            function calculaImc() {
                                            pesob1 = document.getElementById('Peso').value;
                                            peso = parseFloat(pesob1.replace(',', '.'));
                                            //                                        peso = pesob1.substring(0, 2)  + "." + pesob1.substring(3, 1);
                                            alturae1 = document.getElementById('Altura').value;
                                            var res = alturae1.substring(0, 1) + "." + alturae1.substring(1, 3);
                                            var altura = parseFloat(res);
                                            imc = peso / Math.pow(altura, 2);
                                            //imc = res;
                                            resultado = imc.toFixed(2)
                                                    document.getElementById('imc').value = resultado.replace('.', ',');
                                            }



                                            var sHors = "0" + 0;
                                            var sMins = "0" + 0;
                                            var sSecs = - 1;
                                            function getSecs() {
                                            sSecs++;
                                            if (sSecs == 60) {
                                            sSecs = 0;
                                            sMins++;
                                            if (sMins <= 9)
                                                    sMins = "0" + sMins;
                                            }
                                            if (sMins == 60) {
                                            sMins = "0" + 0;
                                            sHors++;
                                            if (sHors <= 9)
                                                    sHors = "0" + sHors;
                                            }
                                            if (sSecs <= 9)
                                                    sSecs = "0" + sSecs;
                                            clock1.innerHTML = sHors + "<font color=#000000>:</font>" + sMins + "<font color=#000000>:</font>" + sSecs;
                                            setTimeout('getSecs()', 1000);
                                            }


                                            $(document).ready(function () {
                                            $('#sortable').sortable();
                                            });
                                            $(document).ready(function () {
                                            jQuery('#ficha_laudo').validate({
                                            rules: {
                                            imagem: {
                                            required: true
                                            }
                                            },
                                                    messages: {
                                                    imagem: {
                                                    required: "*"
                                                    }
                                                    }
                                            });
                                            });
                                            function muda(obj) {
                                            if (obj.value != 'DIGITANDO') {
                                            document.getElementById('titulosenha').style.display = "block";
                                            document.getElementById('senha').style.display = "block";
                                            } else {
                                            document.getElementById('titulosenha').style.display = "none";
                                            document.getElementById('senha').style.display = "none";
                                            }
                                            }

                                                                    $(function () {
                                                                    $("#txtCICPrimariolabel").autocomplete({

                                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                                                                            minLength: 3,
                                                                            focus: function (event, ui) {
                                                                            $("#txtCICPrimariolabel").val(ui.item.label);
                                                                            return false;
                                                                            },
                                                                            select: function (event, ui) {
                                                                            $("#txtCICPrimariolabel").val(ui.item.value);
                                                                            $("#txtCICPrimario").val(ui.item.id);
                                                                            return false;
                                                                            }
                                                                    });
                                                                    });
                                                                    $(function () {
                                                                    $("#txtCodigoTusslabel").autocomplete({
                                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotusspesquisa",
                                                                            minLength: 3,
                                                                            focus: function (event, ui) {
                                                                            $("#txtCodigoTusslabel").val(ui.item.label);
                                                                            return false;
                                                                            },
                                                                            select: function (event, ui) {
                                                                            $("#txtCodigoTusslabel").val(ui.item.value);
                                                                            $("#txtCodigoTuss").val(ui.item.id);
//                                                                $("#txtcodigo").val(ui.item.codigo);
//                                                                $("#txtdescricao").val(ui.item.descricao);
                                                                            return false;
                                                                            }
                                                                    });
                                                                    });
                                                                    $(function () {
                                                                    $("#txtCICSecundariolabel").autocomplete({
                                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=cid2",
                                                                            minLength: 3,
                                                                            focus: function (event, ui) {
                                                                            $("#txtCICSecundariolabel").val(ui.item.label);
                                                                            return false;
                                                                            },
                                                                            select: function (event, ui) {
                                                                            $("#txtCICSecundariolabel").val(ui.item.value);
                                                                            $("#txtCICSecundario").val(ui.item.id);
                                                                            return false;
                                                                            }
                                                                    });
                                                                    });
                                                                    var readonly = <?= $readonly ?>;
                                                                    tinyMCE.init({
                                                                    // General options
                                                                    mode: "exact",
                                                                             setup : function(ed)
                                                                            {
                                                                                // set the editor font size
                                                                                ed.onInit.add(function(ed)
                                                                                {
                                                                                ed.getBody().style.fontSize = '10px';
                                                                                ed.execCommand("fontSize", false, "2");

                                                                                });
                                                                            },
                                                                            elements: "laudo",
                                                                            theme: "advanced",
                                                                             
                                                                            readonly: readonly,
                                                                            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                                                            menubar: "tools",
                                                                            toolbar: "spellchecker",
                                                                            spellchecker_languages: 'pt_BR',
                                                                            browser_spellcheck: true,
                                                                            theme_url: 'js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js',
//                                                        external_plugins: 'js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js',

                                                                            // Theme options
                                                                            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                                                            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                                                            theme_advanced_toolbar_location: "top",
                                                                            theme_advanced_toolbar_align: "left",
                                                                            theme_advanced_statusbar_location: "bottom",
                                                                            theme_advanced_resizing: true,
                                                                            // Example content CSS (should be your site CSS)
                                                                            //                                    content_css : "css/content.css",
                                                                            // content_css: "css/tinymce_content.css",

                                                                            // Drop lists for link/image/media/template dialogs
                                                                            template_external_list_url: "lists/template_list.js",
                                                                            external_link_list_url: "lists/link_list.js",
                                                                            external_image_list_url: "lists/image_list.js",
                                                                            media_external_list_url: "lists/media_list.js",
                                                                            // Style formats
                                                                            style_formats: [
                                                                            {title: 'Bold text', inline: 'b'},
                                                                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                            {title: 'Table styles'},
                                                                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                            ],
                                                                            // Replace values for the template plugin
                                                                            template_replace_values: {
                                                                            username: "Some User",
                                                                                    staffid: "991234"
                                                                            }

                                                                    });
                                                                    tinyMCE.init({
                                                                    // General options
                                                                    mode: "exact",
                                                                            elements: "dados",
                                                                            theme: "advanced",
                                                                            readonly: readonly,
                                                                            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                                                            menubar: "tools",
                                                                            toolbar: "spellchecker",
                                                                            spellchecker_languages: 'pt_BR',
                                                                            browser_spellcheck: true,
                                                                            theme_url: 'js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js',
//                                                        external_plugins: 'js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js',

                                                                            // Theme options
                                                                            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                                                            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                                                            theme_advanced_toolbar_location: "top",
                                                                            theme_advanced_toolbar_align: "left",
                                                                            theme_advanced_statusbar_location: "bottom",
                                                                            theme_advanced_resizing: true,
                                                                            // Example content CSS (should be your site CSS)
                                                                            //                                    content_css : "css/content.css",
                                                                            content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                                                                            // Drop lists for link/image/media/template dialogs
                                                                            template_external_list_url: "lists/template_list.js",
                                                                            external_link_list_url: "lists/link_list.js",
                                                                            external_image_list_url: "lists/image_list.js",
                                                                            media_external_list_url: "lists/media_list.js",
                                                                            // Style formats
                                                                            style_formats: [
                                                                            {title: 'Bold text', inline: 'b'},
                                                                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                            {title: 'Table styles'},
                                                                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                            ],
                                                                            // Replace values for the template plugin
                                                                            template_replace_values: {
                                                                            username: "Some User",
                                                                                    staffid: "991234"
                                                                            }

                                                                    });
                                                                    tinyMCE.init({
                                                                    // General options
                                                                    mode: "exact",
                                                                            elements: "adendo",
                                                                            theme: "advanced",
                                                                            readonly: 1,
                                                                            // plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                                                            menubar: "tools",
                                                                            toolbar: "spellchecker",
                                                                            spellchecker_languages: 'pt_BR',
                                                                            browser_spellcheck: true,
                                                                            theme_url: 'js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js',
//                                                        external_plugins: 'js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js',

                                                                            // Theme options
                                                                            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                                                            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                                                            theme_advanced_toolbar_location: "top",
                                                                            theme_advanced_toolbar_align: "left",
                                                                            theme_advanced_statusbar_location: "bottom",
                                                                            theme_advanced_resizing: true,
                                                                            // Example content CSS (should be your site CSS)
                                                                            //                                    content_css : "css/content.css",
                                                                            content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                                                                            // Drop lists for link/image/media/template dialogs
                                                                            template_external_list_url: "lists/template_list.js",
                                                                            external_link_list_url: "lists/link_list.js",
                                                                            external_image_list_url: "lists/image_list.js",
                                                                            media_external_list_url: "lists/media_list.js",
                                                                            // Style formats
                                                                            style_formats: [
                                                                            {title: 'Bold text', inline: 'b'},
                                                                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                            {title: 'Table styles'},
                                                                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                            ],
                                                                            // Replace values for the template plugin
                                                                            template_replace_values: {
                                                                            username: "Some User",
                                                                                    staffid: "991234"
                                                                            }

                                                                    });
                                                                    $(function () {
                                                                    $('#exame').change(function () {
                                                                    if ($(this).val()) {
                                                                    //$('#laudo').hide();
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].texto;
                                                                    //                                                document.getElementById("laudo").value = options

                                                                    $('#laudo').val(options)
                                                                            var ed = tinyMCE.get('laudo');
                                                                    ed.setContent($('#laudo').val());
                                                                    //$('#laudo').val(options);
                                                                    //$('#laudo').html(options).show();
                                                                    //                                                $('.carregando').hide();
                                                                    //history.go(0) 
                                                                    });
                                                                    } else {
                                                                    $('#laudo').html('value=""');
                                                                    }
                                                                    });
                                                                    });
                                                                    $(function () {
                                                                    $('#linha').change(function () {
                                                                    if ($(this).val()) {
                                                                    //$('#laudo').hide();
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function (j) {
                                                                    options = "";
                                                                    options += j[0].texto;
                                                                    //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                                    $('#laudo').val() + options
                                                                            var ed = tinyMCE.get('laudo');
                                                                    ed.setContent($('#laudo').val());
                                                                    //$('#laudo').html(options).show();
                                                                    });
                                                                    } else {
                                                                    $('#laudo').html('value=""');
                                                                    }
                                                                    });
                                                                    });
                                                                    $(function () {
                                                                    $("#linha2").autocomplete({
                                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                                                            minLength: 1,
                                                                            focus: function (event, ui) {
                                                                            $("#linha2").val(ui.item.label);
                                                                            return false;
                                                                            },
                                                                            select: function (event, ui) {
                                                                            $("#linha2").val(ui.item.value);
                                                                            tinyMCE.triggerSave(true, true);
                                                                            document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                                                                    $('#laudo').val() + ui.item.id
                                                                                    var ed = tinyMCE.get('laudo');
                                                                            ed.setContent($('#laudo').val());
                                                                            //$( "#laudo" ).val() + ui.item.id;
                                                                            document.getElementById("linha2").value = ''
                                                                                    return false;
                                                                            }
                                                                    });
                                                                    });
                                                                    $(function (a) {
                                                                    $('#anteriores').change(function () {
                                                                    if ($(this).val()) {
                                                                    //$('#laudo').hide();
                                                                    $('.carregando').show();
                                                                    $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function (i) {
                                                                    option = "";
                                                                    option = i[0].texto;
                                                                    tinyMCE.triggerSave();
                                                                    document.getElementById("laudo").value = option
                                                                            //$('#laudo').val(options);
                                                                            //$('#laudo').html(options).show();
                                                                            $('.carregando').hide();
                                                                    history.go(0)
                                                                    });
                                                                    } else {
                                                                    $('#laudo').html('value="texto"');
                                                                    }
                                                                    });
                                                                    });
                                                                    //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//                $('.jqte-test').jqte();









</script>

