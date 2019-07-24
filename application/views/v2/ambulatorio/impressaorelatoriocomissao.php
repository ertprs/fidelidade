<?php $total = 0; ?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório Comissão',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'Cliente' => 'paciente',
                'Plano' => 'plano',
                'Comissão' => [ 'comissao', function($valor) use (&$total) {
                    $total += $valor;
                    return number_format($valor, 2, ",", ".");
                } ],
                'Comissão Vendedor' => [ 'comissao_vendedor', function($valor) {
                    return number_format($valor, 2, ",", ".");
                } ],
                'Comissão Gerente' => [ 'comissao_gerente', function($valor) {
                    return number_format($valor, 2, ",", ".");
                } ],
                'Comissão Seguradora' => [ 'comissao_seguradora', function($valor) {
                    return number_format($valor, 2, ",", ".");
                } ],
            ],
        ] ]); ?>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="icon bg-blue">
                <i class="material-icons">monetization_on</i>
            </div>
            <div class="content">
                <div class="text">Total</div>
                <div class="number">
                    <?= number_format($total, 2, ",", "."); ?>
                </div>
            </div>
        </div>
    </div>
</div>
