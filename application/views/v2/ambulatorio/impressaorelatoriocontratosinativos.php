
<h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
<h4>BUSCANDO POR: <?= ($_POST['tipobusca'] == "I") ? "INATIVOS" : "ATIVOS"; ?></h4>
<hr>

<?php

if(!$_POST['tipobusca'] == 'I'){
    $colunas = [
        'Nome' => 'nome',
        'Número' => 'paciente_contrato_id',
        'Plano' => 'plano',
        'Data' => [ 'data_cadastro', function($data) {
            return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
        } ]
    ];
}else{
    $colunas = [
        'Nome' => 'nome',
        'Número' => 'paciente_contrato_id',
        'Plano' => 'plano',
        'Data' => [ 'data_cadastro', function($data) {
            return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
        } ],
        'Operador Exclusão' => 'operador'
    ];
}

$total = 0; ?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório Contratos Ativos',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => $colunas
        ] ]); ?>
    </div>
</div>








