<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Cadastro de Carência</h3></div>
            <div class="body">
                <form name="form_sala" id="form_sala" action="<?= site_url('/cadastros/formapagamento/gravarcarencia') ?>" method="post">
                    <input type="hidden" name="txtcadastrosformapagamentoid" value="<?= @$obj->_forma_pagamento_id; ?>" />

                    <div class="row clearfix">
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="carencia_exame" class="form-control" value="<?= @$obj->_carencia_exame; ?>" />
                                    <label class="form-label">Carência Exame</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <?php if (@$obj->_carencia_exame_mensal == "t") : ?>
                                <input type="checkbox" id="carencia_exame_mensal" name="carencia_exame_mensal" class="filled-in" checked="true"/>
                            <?php else : ?>
                                <input type="checkbox" id="carencia_exame_mensal" name="carencia_exame_mensal" class="filled-in" />
                            <?php endif; ?>
                            <label for="carencia_exame_mensal">Carência Mensal Exame</label>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="carencia_consulta" class="form-control" value="<?= @$obj->_carencia_consulta; ?>" />
                                    <label class="form-label">Carência Consulta</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <?php if (@$obj->_carencia_consulta_mensal == "t") : ?>
                                <input type="checkbox" id="carencia_consulta_mensal" name="carencia_consulta_mensal" class="filled-in" checked="true"/>
                            <?php else : ?>
                                <input type="checkbox" id="carencia_consulta_mensal" name="carencia_consulta_mensal" class="filled-in" />
                            <?php endif; ?>
                            <label for="carencia_consulta_mensal">Carência Mensal Consulta</label>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="carencia_especialidade" class="form-control" value="<?= @$obj->_carencia_especialidade; ?>" />
                                    <label class="form-label">Carência Especialidade</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <?php if (@$obj->_carencia_especialidade_mensal == "t") : ?>
                                <input type="checkbox" id="carencia_especialidade_mensal" name="carencia_especialidade_mensal" class="filled-in" checked="true"/>
                            <?php else : ?>
                                <input type="checkbox" id="carencia_especialidade_mensal" name="carencia_especialidade_mensal" class="filled-in" />
                            <?php endif; ?>
                            <label for="carencia_especialidade_mensal">Carência Mensal Especialidade</label>
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