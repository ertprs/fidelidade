
<?php
$total = 0;
foreach ($relatorio as $item){
    $total++;
    $item->situacao != 'Titular' ? $item->titular = $item->nome : '';
}
?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório de Dependentes',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'Dependente' => 'dependente',
                'Situação' => 'situacao',
                'Titular' => 'titular',
                'Número' => 'paciente_contrato_id',
                'Plano' => 'plano'
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
                    <?= $total ?>
                </div>
            </div>
        </div>
    </div>
</div>