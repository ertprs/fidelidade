<fieldset>
    <div class="header">
        <legend>
            Gerar Relatório Vendedores
        </legend>
    </div>
    <div class="body">
        <form method="post" class="ajax-relatorio" data-target="#relatorio-vendedores" action="<?= site_url('/ambulatorio/guia/gerarelatoriovendedores/') ?>">
            <div class="row clearfix">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <?= botao_pesquisar(); ?>
                </div>
            </div>
        </form>
    </div>
</fieldset>

<div id="relatorio-vendedores" class="ajax-datatable"></div>



