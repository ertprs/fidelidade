<?php $lista = $lista = $this->parceiro->listar()->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Parceiros',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'razao_social',
                'CNPJ' => 'cnpj',
                'CPF' => 'cpf',
                'Endereço Web' => 'endereco_ip',
            ],
            'actions' => [
                botao_editar('/cadastros/parceiro/carregarparceiro/{financeiro_parceiro_id}'),
                botao_excluir('/cadastros/parceiro/excluir/{financeiro_parceiro_id}')
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/parceiro/carregarparceiro/0'); ?>