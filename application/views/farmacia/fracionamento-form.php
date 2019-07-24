<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Fracionamento</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>farmacia/entrada/gravarfracionamento" method="post">

                <dl class="dl_desconto_lista">
                    <!-- <fieldset> -->
                    <dt>
                    <label>Produto a ser Fracionado</label>
                    </dt>
                    <dd>
                        <select name="produto_id" id="produto_id" class="size4 chosen-select" tabindex="1" required>
                            <option value="">Selecione</option>
                            <? foreach ($produtos as $value) : ?>
                            <option value="<?= $value->farmacia_produto_id; ?>"><?php echo $value->descricao; ?> - <?php echo $value->unidade; ?> - <?php echo $value->lote; ?> - <?php echo $value->marca_produto; ?> </option>
                            <? endforeach; ?>
                            
                            
                            
                            
                        </select>
                    </dd>
                    <dt>
                    <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="number" name="quantidade" id="quantidade" min="0" class="texto01" required/>
                    </dd>
                    
                    <dt>
                    <label>Produto de Entrada</label>
                    </dt>
                    <dd>
                        <select name="produto_entrada" id="produto_entrada" class="size4 chosen-select" tabindex="1" required data-placeholder="Selecione um Produto">
                            <option value="">Selecione</option>
                            <!-- <? foreach ($produtos as $value) : ?>
                            <option value="<?= $value->farmacia_produto_id; ?>"><?php echo $value->descricao; ?></option>
                            <? endforeach; ?> -->
                        </select>
                        
                        
                        
                    </dd>
                    <dt>
                    <label>Fornecedor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" />
                        <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto10" value="<?= @$obj->_fornecedor; ?>" required/>
                    </dd>
                    <dt>
                    <label>Armazem de Entrada</label>
                    </dt>
                    <dd>
                        <select name="txtarmazem" id="txtarmazem" class="size4" required>
                            <option value="">Selecione</option>
                            <? foreach ($sub as $value) : ?>
                                <option value="<?= $value->farmacia_armazem_id; ?>"><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                   
                    <dt>
                    <label>Quantidade Entrada</label>
                    </dt>
                    <dd>
                        <input type="number" name="quantidade_entrada" id="quantidade_entrada" min="0" class="texto01" required/>
                    </dd>
                    <dt>
                    <label>Data Fracionamento</label>
                    </dt>
                    <dd>
                        <input type="text" name="data_fracionamento" id="data_fracionamento"  class="texto02" required value="<?=date("d/m/Y");?>"/>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!-- <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script> -->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
    
    $(function() {
        $( "#txtfornecedorlabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedorfarmacia",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.value );
                $( "#txtfornecedor" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function () {
        $('#produto_id').change(function () {
            if ($(this).val()) {

                $.getJSON('<?= base_url() ?>autocomplete/produtosaldofracionamentofarmacia', {produto: $(this).val()}, function (j) {
                    // console.log(j);
                    if(j.length > 0){
                        if (j[0].total == null || j[0].total == undefined) {
                            alert('Sem saldo deste produto');
                            $("#quantidade").prop('max', '0');
                        }else{
                            // alert('asda');
                            $("#quantidade").prop('max', j[0].total);
                        }
                    }else{
                        alert('Sem saldo deste produto');
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
                $.getJSON('<?= base_url() ?>autocomplete/produtofracionamentounidadefarmacia', {produto: $(this).val()}, function (j) {
                    // alert(j[0].total);
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].farmacia_produto_id + '">' + j[c].produto + ' - '+ j[c].unidade  +'</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#produto_entrada option').remove();
                    $('#produto_entrada').append(options);
                    $("#produto_entrada").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {

            }
        });
    });


      $(function() {
        $( "#data_fracionamento" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
</script>