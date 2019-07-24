<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Gerar relatório Saida</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" class="ajax-relatorio" data-target="#relatorio-saida" action="<?= site_url('/cadastros/caixa/gerarelatoriosaida') ?>" method="post">
                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="conta" id="conta" class="form-control show-tick" data-live-search="true">
                                    <option value="0">Todas as contas</option>
                                    <? foreach ($conta as $value) : ?>
                                        <option value="<?= $value->forma_entradas_saida_id; ?>" ><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="credordevedor" id="credordevedor" class="form-control show-tick" data-live-search="true">
                                    <option value="0">Todos os credores</option>
                                    <? foreach ($credordevedor as $value) : ?>
                                        <option value="<?= $value->financeiro_credor_devedor_id; ?>" ><?php echo $value->razao_social; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="tipo" id="tipo" class="form-control show-tick" data-live-search="true">
                                    <option value= 0 >Todos os tipos</option>
                                    <? foreach ($tipo as $value) : ?>
                                        <option value="<?= $value->tipo_entradas_saida_id; ?>" ><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="classe" id="classe" class="form-control show-tick" data-live-search="true">
                                    <option value="">Todas as classes</option>
                                </select>
                            </div>
                        </div>

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
                                <select name="email" id="email" class="form-control show-tick">
                                    <option value="NAO">Enviar para Email?</option>
                                    <option value="NAO">NÃO</option>
                                    <option value="SIM">SIM</option>
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

<div id="relatorio-saida" class="ajax-datatable"></div>