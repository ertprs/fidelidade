<div class="row clearfix" style="margin-bottom: 2rem;">
    <div class="col-sm-2">
        <?= botao_voltar('ambulatorio/guia/listarpagamentos/'.$paciente_id.'/'.$contrato_id) ?>
    </div>
</div>

<fieldset>
    <div class="header">
        <legend class="singular">Alterar Observação Pagamento</legend>
    </div>

    <div class="body">
        <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravaralterarobservacaoavulsa/<?= $consulta_avulsa_id; ?>/<?= $paciente_id; ?>/<?= $contrato_id; ?>" method="post">
            <fieldset>
                <div class="header">
                    <legend>Observação</legend>
                </div>

                <div class="body">
                    <div class="row clearfix">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <textarea cols="55"  name="observacao" id="observacao"  ><?=$pagamento[0]->observacao?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <?= botao_salvar() ?>
                        </div>
                    </div>
                </div>
        </form>
</fieldset>

