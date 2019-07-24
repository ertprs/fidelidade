 <?
// echo "<pre>";
// print_r($tiposcirurgia);
 ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Caráter</a></h3>
        <div>
            <form name="form_sala" id="form_sigla" action="<?= base_url() ?>ambulatorio/guia/gravarcarater" method="post">
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcarater_id" id="txtcarater_id" class="texto10" value="<?= @$carater[0]->carater_id; ?>" />
                        <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$carater[0]->descricao; ?>" required=""/>                      
                    </dd>
                     <dt>
                    <label>Codigo</label>
                    </dt>
                    <dd>  
                        <input type="text" name="codigo" id="codigo" class="texto10" value="<?= @$carater[0]->codigo; ?>" required=""/>
                        
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <!--<button type="reset" name="btnLimpar">Limpar</button>-->
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/guia/listarcarater');
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