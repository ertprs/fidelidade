
<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Gerar Relatório Contratos</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" class="ajax-relatorio" data-target="#relatorio-contratos-ativos" action="<?= site_url('/ambulatorio/guia/gerarelatoriocontratosinativos/') ?>" method="post">
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
                            <div class="form-group">
                                <select name="tipobusca" id="tipobusca" class="size2">
                                    <option value="I">Inativos</option>
                                    <option value="A">Ativos</option>
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

<div id="relatorio-contratos-ativos" class="ajax-datatable"></div>