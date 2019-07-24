<?php $lista = $this->formapagamento->listar()->orderby('nome')->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Planos',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'nome',
            ],
            'actions' => [
                botao_editar('/cadastros/formapagamento/carregarformapagamento/{forma_pagamento_id}'),
                botao_carencia('/cadastros/formapagamento/carregarformapagamentocarencia/{forma_pagamento_id}'),
                botao_excluir('/cadastros/formapagamento/excluir/{forma_pagamento_id}')
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/formapagamento/carregarformapagamento/0'); ?>

