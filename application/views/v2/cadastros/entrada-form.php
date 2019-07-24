<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Entrada</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" action="<?= site_url('/cadastros/caixa/gravarentrada') ?>" method="post">
                    <input type="hidden" name="devedor" value="<?= @$obj->_devedor; ?>" />

                    <div class="row clearfix">

                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="valor" alt="decimal" class="form-control valor-base"/>
                                    <label class="form-label">Valor</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="inicio" id="inicio" class="form-control nascimento"/>
                                    <label class="form-label">Data</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />
                                    <input type="text" id="devedorlabel" class="form-control autocomplete-credordevedor" name="devedorlabel" value="<?= @$obj->_razao_social; ?>" />
                                    <label class="form-label">Receber de:</label>
                                    <ul id="lista_credordevedor" class="dropdown-content ac-dropdown"></ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="classe" id="classe" class="form-control show-tick" data-live-search="true">
                                    <option value="">Selecione uma classe...</option>
                                    <? foreach ($classe as $value) : ?>
                                        <option value="<?= $value->descricao; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="conta" id="conta" class="form-control show-tick" data-live-search="true">
                                    <option value="">Selecione uma conta...</option>
                                    <? foreach ($conta as $value) : ?>
                                        <option value="<?= $value->forma_entradas_saida_id; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-8 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea cols="70" rows="3" name="Observacao" id="Observacao" class="form-control"></textarea>
                                    <label class="form-label">Observação</label>
                                </div>
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
                            <?= botao_voltar('/cadastros/caixa'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>