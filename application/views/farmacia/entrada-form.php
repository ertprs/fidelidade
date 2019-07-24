<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Entrada</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>farmacia/entrada/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Produto</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfarmacia_entrada_id" id="txtfarmacia_entrada_id" value="<?= @$obj->_farmacia_entrada_id; ?>" />
                        <input type="hidden" name="txtproduto" id="txtproduto" value="<?= @$obj->_produto_id; ?>" />
                        <input type="text" name="txtprodutolabel" id="txtprodutolabel" class="texto10" value="<?= @$obj->_produto; ?>" />
                    </dd>
                    <dt>
                    <label>Fornecedor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$obj->_fornecedor_id; ?>" />
                        <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto10" value="<?= @$obj->_fornecedor; ?>" />
                    </dd>
                    <dt>
                    <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="txtarmazem" id="txtarmazem" class="size4">
                            <? foreach ($sub as $value) : ?>
                                <option value="<?= $value->farmacia_armazem_id; ?>"<?
                            if(@$obj->_armazem_id == $value->farmacia_armazem_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Valor de compra</label>
                    </dt>
                    <dd>
                        <input type="text" id="compra" alt="decimal" class="texto02 calculadora" name="compra" value="<?= @$obj->_valor_compra; ?>" />
                    </dd>
                    <dt>
                    <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="text" id="quantidade" class="texto02 calculadora" alt="integer" name="quantidade" value="<?= @$obj->_quantidade; ?>" />
                    </dd>
                    <dt>
                    <label>Valor Unitário</label>
                    </dt>
                    <dd>
                        <input type="text" id="valor_unitario" alt="decimal" class="texto02" name="valor_unitario" value="<?= @$obj->_valor_unitario; ?>" />
                    </dd>
                    <dt>
                    <label>Nota Fiscal</label>
                    </dt>
                    <dd>
                        <input type="text" id="nota" alt="integer" class="texto02" name="nota" value="<?= @$obj->_nota_fiscal; ?>" />
                    </dd>
                    <dt>
                    <label>Lote</label>
                    </dt>
                    <dd>
                        <input type="text" id="lote" maxlength="20" class="texto02" name="lote" value="<?= @$obj->_lote; ?>" />
                    </dd>
                    <dt>
                    <label>Marca do Produto</label>
                    </dt>
                    <dd>
                        <input type="text" id="marca_produto" maxlength="20" class="texto02" name="marca_produto" value="<?= @$obj->_marca_produto; ?>" />
                    </dd>
                    <dt>
                    <label>Validade</label>
                    </dt>
                    <dd>
                        <input type="text" id="validade" class="texto02" name="validade" value="<?= substr(@$obj->_validade, 8,2) . "/" . substr(@$obj->_validade, 5,2) . "/" . substr(@$obj->_validade, 0,4); ?>" />
                    </dd>
                    <dt>
                    <label>Data de Compra</label>
                    </dt>
                    <dd>
                        <input type="text" id="data_compra" class="texto02" name="data_compra" value="<?= substr(@$obj->_data_compra, 8,2) . "/" . substr(@$obj->_data_compra, 5,2) . "/" . substr(@$obj->_data_compra, 0,4); ?>" />
                    </dd>
                    <dt>
                    <label>Data de Chegada</label>
                    </dt>
                    <dd>
                        <input type="text" id="data_chegada" class="texto02" name="data_chegada" value="<?= substr(@$obj->_data_chegada, 8,2) . "/" . substr(@$obj->_data_chegada, 5,2) . "/" . substr(@$obj->_data_chegada, 0,4); ?>" />
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

    $(function() {
        $( "#txtprodutolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produtofarmacia",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.value );
                $( "#txtproduto" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#validade" ).datepicker({
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
        $( "#data_compra" ).datepicker({
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
        $( "#data_chegada" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


     $(function () {
        $('.calculadora').change(function () {
           

            var valor1 = parseFloat($('#compra').val());   
            var quantidade = parseFloat($('#quantidade').val());   
            // alert(valor1);
            

            if(!valor1 > 0){
                valor1 = 0;
            }
            if(!quantidade > 0){
                quantidade = 1;
            }
            
            var resultado = parseFloat(valor1 / quantidade).toFixed(2); 
            // alert(resultado);

            $('#valor_unitario').val(resultado);   

            $('input:text').setMask();

        });
    });
    
    
    $(document).ready(function(){
        jQuery('#form_entrada').validate( {
            rules: {
                txtproduto: {
                    required: true
                },
                quantidade: {
                    required: true
                },
                compra: {
                    required: true
                }
   
            },
            messages: {
                txtproduto: {
                    required: "*"
                },
                quantidade: {
                    required: "*"
                },
                compra: {
                    required: "*"
                }
            }
        });
    });
    

    $(function() {
        $( "#accordion" ).accordion();
    });
</script>