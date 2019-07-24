<!--<div class="row clearfix" style="margin-bottom: 2rem;">-->
<!--    <div class="col-sm-2">-->
<!--        <a class="btn btn-primary btn-block" href="--><?php //echo site_url('seguranca/operador/novo/') ?><!--">Novo Operador</a>-->
<!--    </div>-->
<!--</div>-->

<?php $operadores = $this->operador_m->listar()->get()->result();
foreach ($operadores as $operador){
    $operador->ativo == 't' ? $operador->ativo = 'Ativo' : $operador->ativo = 'Inativo';
}
?>
<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Listar Operadores',
            'driver' => 'object',
            'data' => $operadores,
            'columns' => [
                'ID' => 'operador_id',
                'Nome' => 'nome',
                'Usuário' => 'usuario',
                'Perfil' => 'nomeperfil',
                'Ativo' =>'ativo'
            ],
            'actions' => [
                botao_editar('/seguranca/operador/alterar/{operador_id}/'),
                botao_excluir('/seguranca/operador/excluirOperador/{operador_id}/')
            ]
        ] ]); ?>
    </div>
</div>

<?php botao_novo('/seguranca/operador/novo/'); ?>