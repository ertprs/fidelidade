<?php $lista = $this->classe->listar()->orderby('descricao')->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter classe',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'descricao',
                'Tipo' => 'tipo',
            ],
            'actions' => [
                botao_editar('/cadastros/classe/carregarclasse/{financeiro_classe_id}'),
                botao_excluir('/cadastros/classe/excluir/{financeiro_classe_id}')
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/classe/carregarclasse/0'); ?>
