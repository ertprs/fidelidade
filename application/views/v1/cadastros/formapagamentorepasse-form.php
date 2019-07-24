<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravarcarencia" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Valor do comissao</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input type="number" name="carencia_exame" class="texto03" value="<?= @$obj->_carencia_exame; ?>" />
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_formapagamento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                ajuste: {
                    required: true

                },
                parcelas: {
                    required: true
                }

            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                ajuste: {
                    required: "*"

                },
                parcelas: {
                    required: "*"
                }
            }
        });
    });

</script>
