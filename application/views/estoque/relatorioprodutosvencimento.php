<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatorio Produtos Vencimento</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>estoque/entrada/gerarelatorioprodutosvencimento">
                <dl>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                        <dd>
                            <select name="empresa" id="empresa" class="size2" required>
                            <option value="0">TODOS</option>
                                <? foreach ($empresa as $value) : ?>
                                    <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                                
                            </select>
                        </dd>
                    <dt>
                        <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="armazem" id="armazem" class="size2" required>
                            <option value="0">TODOS</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>" ><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Tempo de Vencimento</label>
                    </dt>
                    <dd>
                        <input type="number" min=1 name="vencimento" id="vencimento" required/>
                    </dd>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
        $(function() {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    
    $(function() {
        $("#txtfornecedorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function(event, ui) {
                $("#txtfornecedorlabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtfornecedorlabel").val(ui.item.value);
                $("#txtfornecedor").val(ui.item.id);
                return false;
            }
        });
    });

    $(function() {
        $("#txtprodutolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
            minLength: 2,
            focus: function(event, ui) {
                $("#txtprodutolabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtprodutolabel").val(ui.item.value);
                $("#txtproduto").val(ui.item.id);
                return false;
            }
        });
    });



    $(function() {
        $("#accordion").accordion();
    });

</script>