<?php
$total = 0;
$comissaoMensalVendedor = 0;
?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório Comissão Vendedor',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'Cliente' => 'paciente',
                'Plano' => 'plano',
                'Data' => [ 'data', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'Valor Parcela' => [ 'valor', function($valor) use (&$total) {
                    $total += $valor;
                    return number_format($valor, 2, ",", ".");
                } ],
                'Comissão Vendedor' => [ 'comissao_vendedor_mensal', function($valor) use (&$comissaoMensalVendedor) {
                    $comissaoMensalVendedor = $valor;
                    return number_format($valor, 2, ",", ".");
                } ],
                'Comissão Gerente' => [ 'comissao_gerente_mensal', function($valor) {
                    return number_format($valor, 2, ",", ".");
                } ],
                'Situação da Parcela' => [ 'ativo', function($ativo) use (&$total, &$comissaoMensalVendedor) {
                    if ($ativo == 'f') {
                        $total += $comissaoMensalVendedor;
                        return 'Paga';
                    } else {
                        return 'Não paga';
                    }
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
