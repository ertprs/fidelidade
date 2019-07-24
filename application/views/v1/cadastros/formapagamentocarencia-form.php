<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Carência</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravarcarencia" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Carência Exame</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input type="number" name="carencia_exame" class="texto03" value="<?= @$obj->_carencia_exame; ?>" />
                        <?php
                        if (@$obj->_carencia_exame_mensal == "t") {
                            ?>
                            <input type="checkbox" name="carencia_exame_mensal" checked ="true"/>Carência Mensal Exame
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="carencia_exame_mensal"  />Carência Mensal Exame
                            <?php
                        }
                        ?>
                    </dd>
                    <dt>
                        <label>Carência Consulta</label>
                    </dt>
                    <dd>
                        <input type="number" name="carencia_consulta" class="texto03" value="<?= @$obj->_carencia_consulta; ?>" />
                        <?php
                        if (@$obj->_carencia_consulta_mensal == "t") {
                            ?>
                            <input type="checkbox" name="carencia_consulta_mensal" checked ="true"/>Carência Mensal Consulta
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="carencia_consulta_mensal"  />Carência Mensal Consulta
                            <?php
                        }
                        ?>
                    </dd>
                    <dt>
                        <label>Carência Especialidade</label>
                    </dt>
                    <dd>
                        <input type="number" name="carencia_especialidade" class="texto03" value="<?= @$obj->_carencia_especialidade; ?>" />
                        <?php
                        if (@$obj->_carencia_especialidade_mensal == "t") {
                            ?>
                            <input type="checkbox" name="carencia_especialidade_mensal" checked ="true"/>Carência Mensal Especialidade
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="carencia_especialidade_mensal"  />Carência Mensal Especialidade
                            <?php
                        }
                        ?>
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
