<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Cadastro de Classe</h3></div>
            <div class="body">
                <form name="form_classe" id="form_classe" action="<?= site_url('/cadastros/classe/gravar') ?>" method="post">
                    <input type="hidden" name="txtfinanceiroclasseid" value="<?= @$obj->_financeiro_classe_id; ?>" />
                    <div class="row clearfix">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtNome" class="form-control" value="<?= @$obj->_descricao; ?>" />
                                    <label class="form-label">Nome</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="txttipo_id" id="txttipo_id" class="form-control show-tick" data-live-search="true">
                                    <? foreach ($tipo as $value) : ?>
                                        <option value="<?= $value->tipo_id; ?>"<? if (@$obj->_tipo_id == $value->tipo_id):echo 'selected';
                                        endif;
                                        ?>><?= $value->descricao; ?></option>
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
                            <?= botao_voltar('/cadastros/classe'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



