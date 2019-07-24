<?php $pacientes = $this->paciente->listar()->get()->result();
foreach ($pacientes as $paciente){
    $paciente->ativo == 't' ? $paciente->ativo = 'Ativo' : $paciente->ativo = 'Inativo';
}
?>
    <div class="row clearfix" style="margin-bottom: 73px;">
        <div class="col-xs-12">
            <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
                'titulo' => 'Listar Pacientes',
                'driver' => 'object',
                'data' => $pacientes,
                'columns' => [
                    'ID' => 'paciente_id',
                    'Nome' => 'nome',
                    'Nome da Mãe' => 'nome_mae',
                    'Nascimento' => 'nascimento',
                    'Telefone' => 'telefone',
                    'Situação' => 'ativo'
                ],
                'actions' => [
                    botao_editar('/cadastros/pacientes/carregar/{paciente_id}/'),
                    botao_auxiliar('/emergencia/filaacolhimento/novo/{paciente_id}','Opções'),
                    botao_auxiliar('/cadastros/pacientes/anexarimagem/{paciente_id}/','Arquivos')
                ]
            ] ]); ?>
        </div>
    </div>

<?php botao_novo('/cadastros/pacientes/novo/'); ?>