<fieldset>
    <div class="header">
        <legend>
            Gerar Relatório Dependentes
        </legend>
    </div>
    <div class="body">
        <form method="post" class="ajax-relatorio" data-target="#relatorio-dependentes" action="<?= site_url('/ambulatorio/guia/gerarelatoriodependentes/') ?>">
            <div class="row clearfix">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <?= botao_pesquisar(); ?>
                </div>
            </div>
        </form>
    </div>
</fieldset>

<div id="relatorio-dependentes" class="ajax-datatable"></div>


