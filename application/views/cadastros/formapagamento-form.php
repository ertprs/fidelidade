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
                        <label>Nome impressão</label>
                    </dt>
                    <dd>

                        <input type="text" name="txtNomeimpressao" class="texto05" value="<?= @$obj->_nome_impressao; ?>" />
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
                        <label>Valor 11 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor11" class="texto02" id="valor11" alt="decimal" value="<?= @$obj->_valor11; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 12 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor12" class="texto02" id="valor12" alt="decimal" value="<?= @$obj->_valor12; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 23 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor23" class="texto02" id="valor23" alt="decimal" value="<?= @$obj->_valor23; ?>" />
                    </dd>
                    <dt>
                        <label>Valor 24 vezes</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor24" class="texto02" id="valor24" alt="decimal" value="<?= @$obj->_valor24; ?>" />
                    </dd>
                    <dt>
                        <label>Multa Por Atraso (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="multa_atraso" class="texto02" id="multa_atraso" alt="decimal" value="<?= @$obj->_multa_atraso; ?>" />
                    </dd>
                    <dt>
                        <label>Juros (%)</label>
                    </dt>
                    <dd>
                        <input type="text" name="juros" class="texto02" id="juros" alt="decimal" value="<?= @$obj->_juros; ?>" />
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
                        <label>Valor Adesão (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor_adesao" class="texto02" id="valor_adesao" alt="decimal" value="<?= @$obj->_valor_adesao; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Carteira Titular (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor_carteira_titular" class="texto02" id="valor_carteira_titular" alt="decimal" value="<?= @$obj->_valor_carteira_titular; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Carteira Titular 2º em diante (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor_carteira_titular_2" class="texto02" id="valor_carteira_titular_2" alt="decimal" value="<?= @$obj->_valor_carteira_titular_2; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Carteira Dependente (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor_carteira" class="texto02" id="valor_carteira" alt="decimal" value="<?= @$obj->_valor_carteira; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Carteira Dependente 2º (R$)</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor_carteira_2" class="texto02" id="valor_carteira_2" alt="decimal" value="<?= @$obj->_valor_carteira_2; ?>" />
                    </dd>
                    
                    <dt>
                        <label>N° Maximo de Clientes</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcelas" class="texto02" id="parcelas" alt="integer" value= "<?= @$obj->_parcelas; ?>" />
                    </dd>
                    <dt>
                        <label>Valor cliente adicional</label>
                    </dt>
                    <dd>
                        <input type="text" name="valoradcional" class="texto02" id="valoradcional" alt="decimal" value="<?= @$obj->_valoradcional; ?>" />
                    </dd>

                    <dt>
                        <label>Consulta Avulsa Extra</label>
                    </dt>
                    <dd>
                        <input type="text" name="consulta_avulsa" class="texto02" id="consulta_avulsa" alt="decimal" value="<?= @$obj->_consulta_avulsa; ?>" />
                    </dd>
                    <dt>
                        <label>Consulta Avulsa Coop</label>
                    </dt>
                    <dd>
                        <input type="text" name="consulta_coop" class="texto02" id="consulta_coop" alt="decimal" value="<?= @$obj->_consulta_coop; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao; ?>" />
                     Percentual?  <input type="checkbox" name="percetual_comissao" id="percetual_comissao" <?= (@$obj->_percetual_comissao == "t") ? 'checked' : '' ; ?>>
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_mensal" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_mensal; ?>" />
                        Percentual? <input type="checkbox" name="percetual_comissao_vendedor_mensal" id="percetual_comissao_vendedor_mensal" <?= (@$obj->_percetual_comissao_vendedor_mensal == "t") ? 'checked' : '' ; ?>>
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
                        <label>Comiss&atilde;o Vendedor Externo</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_externo" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_externo; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor Externo Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_externo_mensal" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_externo_mensal; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor PJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_pj" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_pj; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Vendedor PJ Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_vendedor_pj_mensal" class="texto02" id="comissao" alt="decimal" value="<?= @$obj->_comissao_vendedor_pj_mensal; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Indicação</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_indicacao" class="texto02" id="comissao_indicacao" alt="decimal" value="<?= @$obj->_comissao_indicacao; ?>" />
                    </dd>
                    <dt>
                        <label>Comiss&atilde;o Indicação Mensal</label>
                    </dt>
                    <dd>
                        <input type="text" name="comissao_indicacao_mensal" class="texto02" id="comissao_indicacao_mensal" alt="decimal" value="<?= @$obj->_comissao_indicacao_mensal; ?>" />
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

                    <dt>
                        <label>Validade</label>
                    </dt>
                    <dd> 
                        &nbsp;<input type="number" id="qtd_dias" name="qtd_dias" class="texto02" min="1" pattern="^[0-9]+"  value="<?= @$obj->_qtd_dias; ?>"  />  

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


    document.addEventListener('click', function (e) {

        var self = e.target;

        if (['cpf', 'paciente_id'].indexOf(self.id) !== -1) {
            var el = document.getElementById(self.id === 'cpf' ? 'paciente_id' : 'cpf');

            self.removeAttribute('disabled');

            el.setAttribute('disabled', '');
            el.value = "";
        }
    })
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
