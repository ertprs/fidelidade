<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Gerar relatório Comissão Vendedor</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" class="ajax-relatorio" data-target="#relatorio-comissao" action="<?= site_url('/ambulatorio/guia/gerarelatoriocomissaovendedor') ?>" method="post">
                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtdata_inicio" id="txtdata_inicio" class="form-control nascimento" alt="date"/>
                                    <label class="form-label">Data início</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtdata_fim" id="txtdata_fim" class="form-control nascimento" alt="date"/>
                                    <label class="form-label">Data fim</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="vendedor" class="form-control show-tick" data-live-search="true" required="true">
                                    <option value="">Selecione um vendedor...</option>
                                    <?php foreach ($listarvendedor as $item) : ?>
                                        <option value="<?php echo $item->operador_id; ?>"><?php echo $item->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-3 col-md-2 col-xs-12">
                            <?= botao_pesquisar(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="relatorio-comissao" class="ajax-datatable"></div>