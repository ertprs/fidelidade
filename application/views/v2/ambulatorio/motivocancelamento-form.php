<fieldset>
    <div class="header">
        <legend>Cadastro de Motivo cancelamento</legend>
    </div>

    <div class="body">
        <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/motivocancelamento/gravar" method="post">

            <div class="row clearfix">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label>Motivo do Cancelamento</label>
                            <input type="hidden" name="txtambulatoriomotivocancelamentoid" class="texto10" value="<?= @$obj->_ambulatorio_cancelamento_id; ?>" />
                            <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <fieldset>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_salvar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_limpar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_voltar('/ambulatorio/motivocancelamento/'); ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</fieldset>