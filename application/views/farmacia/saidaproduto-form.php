

<?
//
//echo "<pre>";
//
//print_r($dados);
?>

<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Saída</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>farmacia/saida/gravarsaida_produto" method="post">


                <input type="hidden" name="farmacia_saida_produto_id" value="<?= @$dados[0]->farmacia_saida_produto_id ?>">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Produto</label>
                    </dt>
                    <dt>
                        <select name="produto_id" id="produto_id" class="size4 chosen-select" tabindex="1" required data-placeholder="Selecione um Produto">
<!--                            <option value="">Selecione</option>-->
             
                                 <? foreach ($produtos as $value) : ?>
                                <option value="<?= $value->farmacia_entrada_id; ?>"<?
                            if(@$dados[0]->farmacia_entrada_id == $value->farmacia_entrada_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?> - <?php echo $value->lote; ?></option>
                                    <? endforeach; ?>
                                

                        </select>
                    </dt>
                    <br><br>
                    <dt>
                        <label>Armazém</label>
                    </dt>
                    <dd>
                        <select name="produto_armazem" id="produto_armazem" class="size4 chosen-select" tabindex="1" required data-placeholder="Selecione um Armazém">          
                            <option value="<?= @$dados[0]->farmacia_armazem_id; ?>" > <?= @$dados[0]->armazem; ?></option>                     
                        </select>
                    </dd>

                    <dt>
                        <label>Tipo de Saída</label>
                    </dt>
                    <dd>
                        <select name="txtasaida" id="txtasaida" class="size4 chosen-select" tabindex="1" >

                            <? foreach (@$tipo_saida as $value) : ?>
                                <option value="<?= @$value->farmacia_tipo_saida_id; ?>" <? if (@$dados[0]->farmacia_tipo_saida_id == $value->farmacia_tipo_saida_id) echo 'selected' ?>>
                                    <?php echo @$value->descricao; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="number" name="quantidade" id="quantidade" min="0" max="<?= @$dados[0]->qtd_m; ?>" class="texto01" value="<?= @$dados[0]->quantidade; ?>" required/>
                    </dd>

                    <dt>
                        <label>Lote</label>
                    </dt>
                    <dd>
                        <select name="lote" id="lote" class="size4 chosen-select" tabindex="1" required data-placeholder="Selecione um Lote">
                            <option value="<?= @$dados[0]->lote; ?>" > <?= @$dados[0]->lote; ?></option>                   


                        </select>
                    </dd>

                    <dt>
                        <label>Validade</label>
                    </dt>                          
                    <dd>              
                        <select name="validade" id="validade" class="size4 chosen-select" tabindex="1" required data-placeholder="Selecione uma validade">   
                            <option value="<?= @$dados[0]->validade; ?>" > <?= @$dados[0]->validade; ?></option>   
                        </select>            
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>





<script type="text/javascript">

 $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>farmacia/saida/saida_produto');
    });
    
    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {
                $.getJSON('<?= base_url() ?>autocomplete/armazemsaidaproduto', {produto: $(this).val()}, function (j) {
                    // alert(j[0].total);
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].validade + '">' + j[c].validade + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#validade option').remove();
                    $('#validade').append(options);
                    $("#validade").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {

            }
        });
    });










    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {
                $.getJSON('<?= base_url() ?>autocomplete/lotesaidaproduto', {produto: $(this).val()}, function (j) {
                    // alert(j[0].total);
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].lote + '">' + j[c].lote + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#lote option').remove();
                    $('#lote').append(options);
                    $("#lote").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {

            }
        });
    });










    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {

                $.getJSON('<?= base_url() ?>autocomplete/quantidadesaidaproduto', {produto: $(this).val()}, function (j) {
                    // console.log(j);
                    if (j.length > 0) {
                        if (j[0].quantidade == null || j[0].quantidade == undefined) {
//                            alert('Sem saldo deste produto');
                            $("#quantidade").prop('max', '0');
                        } else {
//                             alert('asda:'+j[0].quantidade);
                            $("#quantidade").prop('max', j[0].quantidade);
                        }
                    } else {
//                        alert('Sem saldo deste produto');
                        $("#quantidade").prop('max', '0');
                    }


                });
            } else {

            }
        });
    });




    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {
                $.getJSON('<?= base_url() ?>autocomplete/armazemsaidaproduto', {produto: $(this).val()}, function (j) {
                    // alert(j[0].total);
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].farmacia_armazem_id + '">' + j[c].armazem + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#produto_armazem option').remove();
                    $('#produto_armazem').append(options);
                    $("#produto_armazem").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {

            }
        });
    });


























    $(function () {
        $("#txtfornecedorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedorfarmacia",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtfornecedorlabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtfornecedorlabel").val(ui.item.value);
                $("#txtfornecedor").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtprodutolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produtofarmacia",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtprodutolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtprodutolabel").val(ui.item.value);
                $("#txtproduto").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#validade").datepicker({
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
        $("#data_compra").datepicker({
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
        $("#data_chegada").datepicker({
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