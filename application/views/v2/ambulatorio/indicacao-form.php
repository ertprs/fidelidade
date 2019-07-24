<fieldset>
    <div class="header">
        <legend>
            Nova Indica&ccedil;&atilde;o
        </legend>
    </div>
    <div class="body">
        <form name="form_indicacao" id="form_indicacao" action="<?= base_url() ?>ambulatorio/indicacao/gravar" method="post">

            <div class="row clearfix">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <label>Nome</label>
                            <input type="hidden" name="paciente_indicacao_id" class="texto10" value="<?= @$obj->_paciente_indicacao_id; ?>" />
                            <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
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
                    <?= botao_voltar('/ambulatorio/indicacao/'); ?>
                </div>
            </div>

        </form>
    </div>
</fieldset>>