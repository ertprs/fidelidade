<?php $lista = $this->forma->listar()->orderby('descricao')->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Conta',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'descricao',
            ],
            'actions' => [
                botao_editar('/cadastros/forma/carregarforma/{forma_entradas_saida_id}'),
                botao_excluir('/cadastros/forma/excluir/{forma_entradas_saida_id}')
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/forma/carregarforma/0'); ?>