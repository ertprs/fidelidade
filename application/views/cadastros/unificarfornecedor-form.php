<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Unificar Credor/Devedor</a></h3>

        <div>
            <form name="form_fornecedor" id="form_fornecedor" action="<?= base_url() ?>cadastros/fornecedor/gravarunificarcredor" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Credor</label>
                    </dt>
                    <dd>
                        <input type="text" name="credor_devedor_id" class="texto01" value="<?= @$obj->_financeiro_credor_devedor_id; ?>" readonly/>
                        <input type="text" name="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" readonly/>
                    </dd>
                    
                    <dt>
                        <label>Credor que será unificado e excluido</label>
                    </dt>
                    <dd>
                        <select name="credor_devedor_id_antigo" id="credor_devedor_id_antigo" class="chosen-select" required="" tabindex="3">

                            <option value="">Selecione</option>
                            <?foreach($credordevedor as $item){?>
                                <option value="<?=$item->financeiro_credor_devedor_id?>"><?=$item->razao_social?></option>
                            <?}?>
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>cadastros/fornecedor');
    });
    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_fornecedor').validate({
            rules: {
                txtrazaosocial: {
                    required: true,
                    minlength: 3
                },
                endereco: {
                    required: true
                },
                cep: {
                    required: true
                },
                cns: {
                    maxLength: 15
                }, rg: {
                    maxLength: 20
                }

            },
            messages: {
                txtrazaosocial: {
                    required: "*",
                    minlength: "*"
                },
                endereco: {
                    required: "*"
                },
                cep: {
                    required: "*"
                },
                cns: {
                    required: "Tamanho m&acute;ximo do campo CNS é de 15 caracteres"
                },
                rg: {
                    maxlength: "Tamanho m&acute;ximo do campo RG é de 20 caracteres"
                }
            }
        });
    });

</script>