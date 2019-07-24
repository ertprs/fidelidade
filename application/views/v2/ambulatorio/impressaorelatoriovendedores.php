
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório de Vendedores',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'ID' => 'operador_id',
                'Nome' => 'nome'
            ]
        ] ]); ?>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="content">
                <div class="text">Total</div>
                <div class="number">
                    <?= count($relatorio) ?>
                </div>
            </div>
        </div>
    </div>
</div>

