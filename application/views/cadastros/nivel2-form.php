<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Nivel2</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>cadastros/nivel2/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosnivel2id" class="texto10" value="<?= @$obj->_nivel2_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_descricao; ?>" required/>
                    </dd>
                    <dt>
                    <label>Nível 1</label>
                    </dt>
                    <dd>
                        <?$nivel1 = $this->nivel1->listarnivel1();?>
                        <select name="txtnivel1_id" id="txtnivel1_id" class="size4" required>
                            <? foreach ($nivel1 as $value) : ?>
                                <option value="<?= $value->nivel1_id; ?>"<? if (@$obj->_nivel1_id == $value->nivel1_id):echo 'selected';
                    endif;
                        ?>><?= $value->descricao; ?></option>
                            <? endforeach; ?>
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
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>cadastros/classe');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_sala').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>


