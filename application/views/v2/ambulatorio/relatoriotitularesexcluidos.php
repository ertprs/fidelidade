<fieldset>
    <div class="header">
        <legend>
            Gerar Relatório Titulares Excluídos
        </legend>
    </div>
    <div class="body">
        <form method="post" class="ajax-relatorio" data-target="#relatorio-titulares-excluidos" action="<?= site_url('/ambulatorio/guia/gerarelatoriotitularesexcluidos/') ?>">
            <div class="row clearfix">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <?= botao_pesquisar(); ?>
                </div>
            </div>
        </form>
    </div>
</fieldset>

<div id="relatorio-titulares-excluidos" class="ajax-datatable"></div>


