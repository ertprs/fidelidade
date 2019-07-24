<?php $lista = $this->tipo->listar()->orderby("descricao")->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Tipo Entrada/saida',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'descricao',
            ],
            'actions' => [
                botao_editar('/cadastros/tipo/carregartipo/{tipo_entradas_saida_id}'),
                botao_excluir('/cadastros/tipo/excluir/{tipo_entradas_saida_id}')
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/tipo/carregartipo/0'); ?>
