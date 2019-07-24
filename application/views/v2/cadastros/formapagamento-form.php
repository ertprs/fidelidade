<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Cadastro Forma de Pagamento</h3></div>
            <div class="body">
                <form name="form_sala" id="form_sala" action="<?= site_url('/cadastros/formapagamento/gravar') ?>" method="post">
                    <input type="hidden" name="txtcadastrosformapagamentoid" value="<?= @$obj->_forma_pagamento_id; ?>" />
                    <input type="hidden" name="valor1" value="0.00" />
                    <input type="hidden" name="valor5" value="0.00" />
                    <input type="hidden" name="valor6" value="0.00" />
                    <input type="hidden" name="valor10" value="0.00" />
                    <input type="hidden" name="consulta_coop" value="0.00" />
                    <input type="hidden" name="consulta_avulsa" value="0.00" />
                    <input type="hidden" name="comissao" value="0.00" />

                    <div class="row clearfix">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_nome; ?>" />
                                    <label class="form-label">Nome</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="valor12" class="form-control valor-base" alt="decimal" value="<?= @$obj->_valor12; ?>" />
                                    <label class="form-label">Valor 12 vezes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="multa_atraso" class="form-control valor-base" alt="decimal" value="<?= @$obj->_multa_atraso; ?>" />
                                    <label class="form-label">Multa Por Atraso (R$)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="juros" class="form-control valor-base" alt="decimal" value="<?= @$obj->_juros; ?>" />
                                    <label class="form-label">Juros (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="parcelas" class="form-control inteiro" maxlength="2" alt="integer" value= "<?= @$obj->_parcelas; ?>" />
                                    <label class="form-label">N° Maximo de Clientes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <?php if (@$obj->_taxa_adesao == "t") : ?>
                                    <input type="checkbox" id="taxa_adesao" class="filled-in" name="taxa_adesao" checked ="true"/>
                                <?php else : ?>
                                    <input type="checkbox" id="taxa_adesao" class="filled-in" name="taxa_adesao"  />
                                <?php endif; ?>
                                <label for="taxa_adesao">Taxa Adesão</label>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="valoradcional" class="form-control valor-base" alt="decimal" value="<?= @$obj->_valoradcional; ?>" />
                                    <label class="form-label">Valor cliente adicional</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="comissao_vendedor_mensal" class="form-control valor-base" alt="decimal" value="<?= @$obj->_comissao_vendedor_mensal; ?>" />
                                    <label class="form-label">Comissão Vendedor Mensal</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="comissao_vendedor" class="form-control valor-base" alt="decimal" value="<?= @$obj->_comissao_vendedor; ?>" />
                                    <label class="form-label">Comissão Vendedor</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="comissao_gerente_mensal" class="form-control valor-base" alt="decimal" value="<?= @$obj->_comissao_gerente_mensal; ?>" />
                                    <label class="form-label">Comissão Gerente Mensal</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="comissao_gerente" class="form-control valor-base" alt="decimal" value="<?= @$obj->_comissao_gerente; ?>" />
                                    <label class="form-label">Comissão Gerente</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line mascara-input">
                                    <input type="text" name="comissao_seguradora" class="form-control valor-base" alt="decimal" value="<?= @$obj->_comissao_seguradora; ?>" />
                                    <label class="form-label">Comissão Seguradora</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group form-float">
                                <select name="conta" class="form-control show-tick" data-live-search="true" required>
                                    <option value="">Selecione a conta...</option>
                                    <? foreach ($conta as $value) : ?>
                                        <option value="<?= $value->forma_entradas_saida_id ?>" <?
                                        if (@$obj->_conta_id == $value->forma_entradas_saida_id): echo 'selected'; endif;
                                        ?>><?= $value->descricao ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_salvar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_limpar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_voltar('/cadastros/formapagamento'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
