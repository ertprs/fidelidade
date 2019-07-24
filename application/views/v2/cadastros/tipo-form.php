<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Cadastro de Tipo Entrada/saida</h3></div>
            <div class="body">
                <form name="form_sala" id="form_sala" action="<?= site_url('/cadastros/tipo/gravar') ?>" method="post">
                    <input type="hidden" name="txtcadastrostipoid" value="<?= @$obj->_tipo_entradas_saida_id; ?>" />
                    <div class="row clearfix">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_descricao; ?>" />
                                    <label class="form-label">Nome</label>
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
                            <?= botao_voltar('/cadastros/tipo'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>