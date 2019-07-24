<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title >Agendar Atendimentos</title>
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<?
if (@$listarmedico[0]->hora_tarde > 0) {
    @list($h_tarde, $m_tarde) = explode(':', $listarmedico[0]->hora_tarde);
    @$tempo_total_tarde = $h_tarde * 60 + $m_tarde;
    ?>
    <input type='text' value="<?= $tempo_total_tarde ?>" id="verifiq_tarde" hidden> 
    <?
}

if (@$listarmedico[0]->hora_manha > 0) {
    @list($h_manha, $m_manha) = explode(':', $listarmedico[0]->hora_manha);
    @$tempo_total_manha = $h_manha * 60 + $m_manha;
    ?>

    <input type='text' value="<?= $tempo_total_manha ?>" id="verifiq_manha" hidden>
    <?
}
?>
 
<div>
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
    <?php
    $this->load->library('utilitario');
//    var_dump($this->session->flashdata('message')); die;
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
    <div>
        <form name="holter_laudo" id="holter_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarhora_agendamento/<?= @$ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>                          
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr>
                            <td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                        </tr>
                        <tr>                        
                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr> 
                    </table> 
                </fieldset>
                <fieldset>
                    <table align = "center"  width="500px">
                        <tr>                            
                            <td><h1 align = "center">Agendar Atendimentos</h1></td>   
                            <td>
<!--                                <button type="button" name="btnconsultacate" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/listaragendaatendimentos/<?= $sala_id; ?>');" >
                                    Consultar Agendar Atendimentos
                                </button>-->
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <?
//                    $exameslab = json_decode(@$exameslab[0]->exameslab);
                ?>

                <fieldset  style="border-bottom: none;">
                    <table align="left" > 
                        <tr>
                            <td>
                                <table width="600px" height="450px">

                                    <tr>
                                        <td>
                                            Data:   
                                        </td>                                       
                                        <td>
                                            <input type="text" alt="date" name="data" id="data" class="" required="">
                                            <!--<input type="hidden" alt="text" name="agenda_exames_id" id="agenda_exames_id" class="" value="<?= $agenda_exames_id; ?>"  required="">-->
                                        </td> 
                                    </tr> 
                                    <tr>
                                        <td>
                                            Tempo de Atendimento (Horas:Minutos):   
                                        </td>                                       
                                        <td id="tempo_atendento_td">
                                            <div id="tempo_atendimento2_div">
                                             
                                    <input type="text"  alt="time"  id="tempo_atendimento" name="tempo_atendimento"  required="" >
                                                
                                            </div> 
<!--                                <input type="text" alt="time"  id="tempo_atendimento2" name="tempo_atendimento2"     required onkeypress="return false;">-->
                                            <input type="hidden"   id="medico_id" name="medico_id" value="<?= @$obj->_medico_parecer1 ?>">
                                        </td>         
                                    </tr>

                                    <tr>
                                        <td>
                                            Turno  
                                        </td>
                                        <td  id="turno_escolha_td">
                                              
                                            <div id="sopraremover_turno">
                                               Manhã  <input type="radio"   id="manha" name="turno" value="manha" required="" >
                                               Tarde <input type="radio"   id="turno" name="turno" value="tarde" required="" > 
                                           </div>
                                           
                                        </td>           
                                    </tr> 

                                    <tr>
                                        <td>
                                            Observação:   
                                        </td>                                       
                                        <td>
                                            <textarea type="text" id="txtconclusao" name="observacao" class="texto"  value="" cols="50" rows="8"><?= @$obj->conclusao; ?></textarea>
                                        </td> 
                                    </tr>  
                                    <tr>
                                        <td>
                                            Medicamentos:   
                                        </td>                                       
                                        <td>
                                            <textarea type="text" id="txtconclusao" name="medicamentos" class="texto"  value="" cols="50" rows="8"><?= @$obj->medicamentos; ?></textarea>
                                        </td> 
                                    </tr>  
                                </table>
                            </td>
                        </tr>
                    </table>   
                </fieldset>
                <br> 
                <table align="center">
                    <td><button type="submit" name="btnEnviar">Salvar</button></td>
<!--                    <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoholter/<?= $ambulatorio_laudo_id ?>');">

                            Imprimir
                        </button>
                    </td>-->
                </table> 

            </div>
        </form>
    </div>
    
    
      
    <fieldset style="margin-left: 700px; position: absolute; margin-top: -530px;" >
    
    
    <table border="2" style="border-collapse: collapse;" border="1" id="tabeladehoras">
        <tr><td>
                <b>  Horas - Manhã</b> 
            </td>

            <td>
                <b>  Horas - Tarde</b> 

            </td>

        </tr>



        <?
        foreach ($listarmedico as $item) {
            ?>
<!--            <tr>
                <td>-->
                    <? // echo $item->hora_manha ?>
<!--                </td>
                <td>-->
                    <? // echo $item->hora_tarde ?>
<!--                </td>

            </tr>-->
        <? }
        ?>

    </table>
    <hr>

    <table id="tabelapolmanha" border="2" style="border-collapse: collapse;" border="1">
        <tr> 


        </tr>

    </table>



    <h1>Agendamentos do dia</h1>
    <div id="agendamentos_data"  style=""> 
        <table border="2" id="tabelapol" style="border-collapse: collapse;" border="1"> 
            <tr>
                <th>Médico</th>
                <th>Turno</th>
                <th>Tempo atendimento</th>
                <th>Paciente</th>
            </tr>
        </table>
    </div>
    <br>  
    <br> 
  </fieldset>
     

</div>
<?
// CALCULANDO A QUANTIDADES TOTAIS DE HORAS QUE O MEDICO ATENDE POR DIA
//                        $entrada = $item->hora_manha;
//                        $saida = $item->hora_tarde;
//                        $hora1 = explode(":", $entrada);
//                        $hora2 = explode(":", $saida);
//                        @$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
//                        @$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
//                        $resultado = $acumulador2 + $acumulador1;
//                        $hora_ponto = floor($resultado / 3600);
//                        $resultado = $resultado - ($hora_ponto * 3600);
//                        $min_ponto = floor($resultado / 60);
//                        $resultado = $resultado - ($min_ponto * 60);
//                        $secs_ponto = $resultado;
//Grava na variável resultado final
//                        $tempo = $hora_ponto . ":" . $min_ponto . ":" . $secs_ponto;
//                        echo $tempo;
?> 

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>


<script>

 
                                                    jQuery("#tempo_atendimento")
                                                            .mask("99:99")
                                                            .focusout(function (event) {
                                                                var target, phone, element;
                                                                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                                                                phone = target.value.replace(/\D/g, '');
                                                                element = $(target);
                                                                element.unmask();
                                                                if (phone.length > 10) {
                                                                    element.mask("99:99");
                                                                } else {
                                                                    element.mask("99:99");
                                                                }
                                                            });


                                                    $(function () {
                                                        $('#data').change(function () {
                                                            if ($(this).val()) {
                                                                $.getJSON('<?= base_url() ?>autocomplete/listarpoltronascomplete', {data: $(this).val(), medico_id: $('#medico_id').val()}, function (j) {

                                                                    var options = '';
                                                                    var tempo_total_hora_min = 0;
                                                                    var tempo_total_min = 0;
                                                                    var total_min = 0;
                                                                    var total_verificar_min = 0;
                                                                    var min_tarde_mais_manha;

                                                                    for (var c = 0; c < j.length; c++) {
                                                                        var tempo_total = j[c].tempo_atendimento.substr(0, 2) * 1; //QUANTIDADE DE HORAS ##:00, onde ## = Horas pegadas
                                                                        tempo_total_hora_min = tempo_total * 60; // CONVERTENDO HORAS EM MINUTOS
                                                                        tempo_total_min = j[c].tempo_atendimento.substr(3, 2) * 1; //QUANTIDADE DE MINUTOS 00:##, onde ## = Minutos pegados
                                                                        total_min = parseInt(tempo_total_min) + parseInt(tempo_total_hora_min); //SOMANDO MINUTOS horas+minutos 
                                                                        total_verificar_min = parseInt(total_verificar_min) + parseInt(total_min); //saber qual a quantidade total de minutos de atedimento do medico

                                                                        var hora_tarde_hora = j[c].hora_tarde.substr(0, 2) * 1; //PEGANDO QUANTIDADE DE HORAS
                                                                        var hora_tarde_hora_min = hora_tarde_hora * 60; //CONVERTENDO HORAS EM MINUTOS
                                                                        var hora_tarde_min = j[c].hora_tarde.substr(3, 2) * 1; //PEGANDO MINUTOS
                                                                        var min_tarde = parseInt(hora_tarde_min) + parseInt(hora_tarde_hora_min); //SOMANDO TOTAL DE MINUTOS DA TARDE


                                                                        var hora_manha_hora = j[c].hora_manha.substr(0, 2) * 1; //PEGANDO HORAS DA MANHA
                                                                        var hora_manha_hora_min = hora_manha_hora * 60; //CONVERTENDO HORAS DA MANHA EM MINUTOS
                                                                        var hora_manha_min = j[c].hora_manha.substr(3, 2) * 1; //PEGANDO MINUTOS DA MANHA
                                                                        var min_manha = parseInt(hora_manha_min) + parseInt(hora_manha_hora_min); //SOMANDO TOTAL DE MINUTOS DA MANHA

                                                                        min_tarde_mais_manha = parseInt(min_manha) + parseInt(min_tarde); //SOMANDO MUNITOS DA TARDE+MANHA

                                                                        if (j[c].turno == "tarde") { //ISSO É SÓ PRA CORRIGIR O NOME PARA FICAR MAIS BONITO
                                                                            var turno = "Tarde";
                                                                        }
                                                                        if (j[c].turno == "manha") { //ISSO É SÓ PRA CORRIGIR O NOME PARA FICAR MAIS BONITO
                                                                            var turno = "Manhã";
                                                                        }
                                                                        //CONTRUINDO LINHAS DA TABELA COM O NOME DO MEDICO TURNO E TEMPO DE ATENDIMENTO
                                                                        options += ' <tr id="teste"> <td> <b style="color:' + j[c].cor_mapa + ';">' + j[c].medico + ' </b></td> <td> ' + turno + ' </td><td> ' + j[c].tempo_atendimento + ' </td><td> ' + j[c].paciente + ' </td></tr> ';
                                                                    }

//                                                                    if (total_verificar_min >= min_tarde_mais_manha) { //VERIFICANDO SE O TEMPO TOTAL DO MEDICO É MAIOR OU IGUAL AO TOTAL DE HORAS ATENDIDAS NO DIA SELECIONADO
//                                                                        $('#semuso').remove();
//                                                                        $('#sopraremover_turno').remove();
//                                                                        var tempo_atend = '<input type="text"     id="semuso"  required="" onkeypress="return false;">';
//                                                                        $(' #turno_div_false #manha2').remove();
//                                                                        $(' #turno_div_false #turno2').remove();
//                                                                        $('#turno_escolha_td #turno_manha_tarde').hide();
//                                                                        var turno_escolha = '<div id="turno_div_false"> <input type="radio"   id="manha2" name="turno2"   required="" disabled> <input type="radio"   id="turno2" name="turno2" value=""      required="" disabled></div>';
//                                                                    } else { // SE O TOTAL DE MINUTOS (USANDOS TEMPO_ATENDIMENTO) FOR MENOR AO TOTAL DE MINUTOS QUE O MEDICO PODE ATENDER EM UM DIA ELE FICAR HABILITADO  
//                                                                        $('#turno_escolha_td #turno_manha_tarde').hide(); //ESCONDENDO INPUT RADIO
//                                                                        $('#sopraremover_turno').remove(); //REMOVENDO
//                                                                        $('#semuso').remove(); //REMOVENDO

//                                                                        var verifiq_tarde = $('#verifiq_tarde').val();
//                                                                        var verifiq_manha = $('#verifiq_manha').val();
//                        alert(verifiq_tarde);

                                                                        
//                        var tempo_atend = '<input type="text"  alt="time"  id="tempo_atendimento" name="tempo_atendimento"  required="" >';
//                                                                        var turno_escolha = '<div id = "turno_div_true" > <input type="radio"   id="manha" name="turno" value="manha" required="" > ';



//                                                                        turno_escolha += '<input type="radio"   id="turno" name="turno" value="tarde" required="" ' + cheked2 + '></div>';



//                                                                    }

                                                                    $('#tabelapol #teste').remove(); //REMOVENDO TODAS AS LINHAS DA TABELA
                                                                    $('#tabelapol').append(options); //MANDANDO AS LINHAS DA TABELA
                                                                    $("#tabelapol").trigger("chosen:updated"); //ATULIZANDO

//                                                    $('#tempo_atendento_td #tempo_atendimento2').remove();
//                                                    $('#tempo_atendimento2_div #tempo_atendimento').remove();
//                                                    $("#tempo_atendimento2_div").append(tempo_atend);

//                                                                    $('#turno_escolha_td #turno_manha_tarde').show(); //MOSTRANDO 
//                                                                    $('#turno_escolha_td #turno_div_false #manha2').remove(); //REMOVENDO INPUT TIPE
//                                                                    $('#turno_escolha_td #turno_div_false #turno2').remove();
//                                                                    $('#turno_escolha2_div #turno_div_true #manha').remove();
//                                                                    $('#turno_escolha2_div #turno_div_true #turno').remove();
//                                                                    $("#turno_escolha2_div").append(turno_escolha);

                                                                    $('.carregando').hide();
                                                                });
                                                            } else {

                                                            }

                                                        });
                                                    });



                                                    $("#hora_fim").mask("99:99");
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
                                                        $('#data').change(function () {
                                                            if ($(this).val()) {
                                                                $.getJSON('<?= base_url() ?>autocomplete/listarpoltronascompletemanha', {data: $(this).val(), medico_id: $('#medico_id').val()}, function (j) {
                                                                    // alert(j[0].total);
                                                                    var options = '';
                                                                    var tempo_total_hora = 0;
                                                                    var tempo_total_hora_min = 0;
                                                                    var tempo_total_min = 0;
                                                                    var total_min = 0;
                                                                    var total_verificar_min = 0;
                                                                    var hora_tarde = 0;
                                                                    var hora_manha = 0;
                                                                    var hora_total = 0;
                                                                    var min_tarde_mais_manha = 0;
                                                                    var min_manha = 0;

                                                                    for (var c = 0; c < j.length; c++) {

                                                                        var tempo_total = j[c].tempo_atendimento.substr(0, 2) * 1;
                                                                        tempo_total_hora_min = tempo_total * 60;
                                                                        tempo_total_min = j[c].tempo_atendimento.substr(3, 2) * 1;
                                                                        total_min = parseInt(tempo_total_min) + parseInt(tempo_total_hora_min);
                                                                        total_verificar_min = parseInt(total_verificar_min) + parseInt(total_min);

//                        var hora_tarde_hora = j[c].hora_tarde.substr(0, 2) * 1;
//                        var hora_tarde_hora_min = hora_tarde_hora * 60;
//                        var hora_tarde_min = j[c].hora_tarde.substr(3, 2) * 1;
//                        var min_tarde = parseInt(hora_tarde_min) + parseInt(hora_tarde_hora_min);


                                                                        var hora_manha_hora = j[c].hora_manha.substr(0, 2) * 1;
                                                                        var hora_manha_hora_min = hora_manha_hora * 60;
                                                                        var hora_manha_min = j[c].hora_manha.substr(3, 2) * 1;
                                                                        min_manha = parseInt(hora_manha_min) + parseInt(hora_manha_hora_min);

                                                                        min_tarde_mais_manha = parseInt(min_manha) - parseInt(total_verificar_min);
//                        var trasn_min_resto = parseInt(min_tarde_mais_manha)%60; CASO QUIRAM EM HORAS 00:00
//                        var trans_hora = parseInt(min_tarde_mais_manha - trasn_min_resto)/60; CASO QUIRAM EM HORAS 00:00

                                                                    }

                                                                    if (j.length <= 0) {
                                                                        min_tarde_mais_manha = "Ainda não foi usado nenhum minuto!";
                                                                    }
                                                                    options += ' <tr id="teste"> <td><b> Minutos restantes para Manhã: </b></td>   <td> ' + min_tarde_mais_manha + ' </td> </tr> ';

                                                                    $('#tabelapolmanha #teste').remove();
                                                                    $('#tabelapolmanha').append(options);
                                                                    $("#tabelapolmanha").trigger("chosen:updated");
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {

                                                            }

                                                        });
                                                    });






                                                    $(function () {
                                                        $('#data').change(function () {
                                                            if ($(this).val()) {
                                                                $.getJSON('<?= base_url() ?>autocomplete/listarpoltronascompletetarde', {data: $(this).val(), medico_id: $('#medico_id').val()}, function (j) {
                                                                    // alert(j[0].total);
                                                                    var options = '';
                                                                    var tempo_total_hora = 0;
                                                                    var tempo_total_hora_min = 0;
                                                                    var tempo_total_min = 0;
                                                                    var total_min = 0;
                                                                    var total_verificar_min = 0;
                                                                    var hora_tarde = 0;
                                                                    var hora_manha = 0;
                                                                    var hora_total = 0;
                                                                    var min_tarde_mais_tarde = 0;
                                                                    var min_tarde = 0;

                                                                    for (var c = 0; c < j.length; c++) {

                                                                        var tempo_total = j[c].tempo_atendimento.substr(0, 2) * 1;
                                                                        tempo_total_hora_min = tempo_total * 60;
                                                                        tempo_total_min = j[c].tempo_atendimento.substr(3, 2) * 1;
                                                                        total_min = parseInt(tempo_total_min) + parseInt(tempo_total_hora_min);
                                                                        total_verificar_min = parseInt(total_verificar_min) + parseInt(total_min);

//                        var hora_tarde_hora = j[c].hora_tarde.substr(0, 2) * 1;
//                        var hora_tarde_hora_min = hora_tarde_hora * 60;
//                        var hora_tarde_min = j[c].hora_tarde.substr(3, 2) * 1;
//                        var min_tarde = parseInt(hora_tarde_min) + parseInt(hora_tarde_hora_min);


                                                                        var hora_tarde_hora = j[c].hora_tarde.substr(0, 2) * 1;
                                                                        var hora_tarde_hora_min = hora_tarde_hora * 60;
                                                                        var hora_tarde_min = j[c].hora_tarde.substr(3, 2) * 1;
                                                                        min_tarde = parseInt(hora_tarde_min) + parseInt(hora_tarde_hora_min);

                                                                        min_tarde_mais_tarde = parseInt(min_tarde) - parseInt(total_verificar_min);

                                                                    }

                                                                    if (j.length <= 0) {
                                                                        min_tarde_mais_tarde = "Ainda não foi usado nenhum minuto!";
                                                                    }

                                                                    options += '<tr id="teste2"> <td><b> Minutos restantes para Tarde: </b>  </td>   <td> ' + min_tarde_mais_tarde + ' </td> </tr> ';

                                                                    $('#tabelapolmanha #teste2').remove();
                                                                    $('#tabelapolmanha').append(options);
                                                                    $("#tabelapolmanha").trigger("chosen:updated");
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {

                                                            }

                                                        });
                                                    });


$(function () {
                                                        $('#data').change(function () {
                                                            if ($(this).val()) {
                                                                $.getJSON('<?= base_url() ?>autocomplete/listarpoltronascompletehorasdia', {data: $(this).val(), medico_id: $('#medico_id').val()}, function (j) {

                                                                    var options = '';
                                                                     

                                                                    for (var c = 0; c < j.length; c++) {
                                                                        //CONTRUINDO LINHAS DA TABELA COM O NOME DO MEDICO TURNO E TEMPO DE ATENDIMENTO
                                                                        
                                                                         if (j[c].hora_manha == null) {
                                                                                j[c].hora_manha = "00:00";
                                                                            }
                                                                            
                                                                            
                                                                            if (j[c].hora_tarde == null) {
                                                                                j[c].hora_tarde = "00:00";
                                                                            }
                                                                        
                                                                        options += ' <tr id="teste">  <td> ' + j[c].hora_manha + ' </td><td> ' + j[c].hora_tarde + ' </td></tr> ';
                                                              
                                                                    }
                                                                       if (j.length <= 0) {
                                                                      $('#tabeladehoras #teste').remove();
                                                                    }
                                                                        
                                                                    $('#tabeladehoras #teste').remove(); //REMOVENDO TODAS AS LINHAS DA TABELA
                                                                    $('#tabeladehoras').append(options); //MANDANDO AS LINHAS DA TABELA
                                                                    $("#tabeladehoras").trigger("chosen:updated"); //ATULIZANDO

//                                
                                                                    $('.carregando').hide();
                                                                });
                                                            } else {

                                                            }

                                                        });
                                                    });




</script>