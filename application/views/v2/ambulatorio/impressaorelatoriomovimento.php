<?php $total = 0; ?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório Movimentação',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'Conta' => 'contanome',
                'Data' => [ 'data', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'Nome' => 'razao_social',
                'Tipo' => [['tiposaida', 'tipoentrada'], function($tipo, $row, $field) {
                    return $tipo;
                }],
                'Classe' => [['classesaida', 'classeentrada'], function($classe) {
                    return $classe;
                }],
                'Valor' => [ 'valor', function($valor) use (&$total) {
                    $total += $valor;
                    return number_format($valor, 2, ",", ".");
                } ],
                'Observação' => [['observacaosaida', 'observacaoentrada'], function($observacao, $row, $field) {
                    return $observacao;
                }],
                'Saldo' => ['saldo', function($saldo) use (&$total) {
                    return number_format($total, 2, ",", ".");;
                }],
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