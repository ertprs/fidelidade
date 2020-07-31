<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formarendimento" id="form_formarendimento" action="<?= base_url() ?>cadastros/formapagamento/gravarformarendimento" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformarendimentoid" class="texto10" value="<?= @$lista[0]->forma_rendimento_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$lista[0]->nome; ?>" />
                    </dd>

                    <?if($permissao[0]->conta_pagamento_associado == 't'){?>
                    <dt>
                        <label>Conta</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" required>
                            <option value="">Selecione</option>
                                <?foreach($conta as $value){?>
                                    <option value="<?=$value->forma_entradas_saida_id?>"
                                    <? if ($value->forma_entradas_saida_id == @$lista[0]->conta_pagamento):echo 'selected';
                                        endif;
                                    ?>
                                    > <?=$value->descricao?></option>
                                <?}?>
                        </select>
                    </dd>

                    <?}?>

                   

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
        jQuery('#form_formarendimento').validate({
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
