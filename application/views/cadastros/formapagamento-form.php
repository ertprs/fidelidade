<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$obj->_nome; ?>" />
                    </dd>

                    <dt>
                        <label>Valor 1 vez</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor1" class="texto02" id="valor1" alt="decimal" value="<?= @$obj->_valor1; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 5 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor5" class="texto02" id="valor5" alt="decimal" value="<?= @$obj->_valor5; ?>" />
                    </dd>

                    <dt>
                        <label>Valor 6 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor6" class="texto02" id="valor6" alt="decimal" value="<?= @$obj->_valor6; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 10 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor10" class="texto02" id="valor10" alt="decimal" value="<?= @$obj->_valor10; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 12 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor12" class="texto02" id="valor12" alt="decimal" value="<?= @$obj->_valor12; ?>" />
                    </dd>
                    <dt>
                        <label>Taxa Adesão</label>
                    </dt>
                    <dd>
                        <?php
                        if (@$obj->_taxa_adesao == "t") {
                            ?>
                            <input type="checkbox" name="taxa_adesao" checked ="true"/>
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="taxa_adesao"  />
                            <?php
                        }
                        ?>
                    </dd>
                    <dt>
                        <label>N° Maximo de Clientes</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcelas" class="texto02" id="parcelas" alt="integer" value= "<?= @$obj->_parcelas; ?>" />
                    </dd>
                    <dt>
                        <label>Valor cliente adcional</label>
                    </dt>
                    <dd>
                        <input type="text" name="valoradcional" class="texto02" id="valoradcional" alt="decimal" value="<?= @$obj->_valoradcional; ?>" />
                    </dd>

                    <dt>
                        <label>Consulta Avulsa</label>
                    </dt>
                    <dd>
                        <input type="text" name="consulta_avulsa" class="texto02" id="consulta_avulsa" alt="decimal" value="<?= @$obj->_consulta_avulsa; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_mensal" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_mensal; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Gerente Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_gerente_mensal" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_gerente_mensal; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Gerente</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_gerente" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_gerente; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Seguradora</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_seguradora" class="texto02" id="comissao_seguradora" alt="decimal" value="<?= @$obj->_comissao_seguradora; ?>" />
                    </dd>
                    <dt title="Selecione a conta onde o dinheiro irá ingressar">
                        <label>Conta</label>
                    </dt>
                    <dd title="Selecione a conta onde o dinheiro irá ingressar">
                        <select name="conta" id="conta" class="texto03" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($conta as $value) { ?>
                                <option value="<?= $value->forma_entradas_saida_id ?>" <?
                                if (@$obj->_conta_id == $value->forma_entradas_saida_id):echo 'selected';
                                endif;
                                ?>><?= $value->descricao ?></option>
                                    <? } ?>                            
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
