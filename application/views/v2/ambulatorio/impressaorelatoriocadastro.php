

<?php $total = 0; ?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório de Cadastro',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                'Numero Registro' => 'paciente_id',
                'Nome' => 'nome',
                'Segmento' => 'convenio',
                'Nascimento' => [ 'nascimento', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'CPF' => 'cpf',
                'RG' => 'rg',
                'Endereço' => 'logradouro',
                'Data Cadastro' => [ 'data_cadastro', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'Cidade' => 'municipio',
                'Situacao' => 'situacao'
            ],
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



