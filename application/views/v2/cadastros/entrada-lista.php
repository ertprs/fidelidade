<?
$saldo = $this->caixa->saldo();
$empresa = $this->caixa->empresa();
$conta = $this->forma->listarforma();
$tipo = $this->tipo->listartipo();
?>
<!--<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Manter Conta</h3></div>
            <div class="body">
                <form name="form_forma" id="form_forma" action="<?= site_url('/cadastros/caixa/pesquisar') ?>" method="get">
                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="conta" id="conta" class="show-tick form-control" data-live-search="true">
                                    <option value="">Todas as contas</option>
                                    <? foreach ($conta as $value) : ?>
                                        <option value="<?= $value->forma_entradas_saida_id; ?>" <?
                                            if (@$_GET['conta'] == $value->forma_entradas_saida_id):echo 'selected';
                                            endif;
                                            ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" alt="date" name="datainicio" class="form-control" value="<?php echo @$_GET['datainicio']; ?>" />
                                    <label class="form-label">Data início</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" alt="date" name="datafim" class="form-control" value="<?php echo @$_GET['datafim']; ?>" />
                                    <label class="form-label">Data fim</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="nome" id="nome" class="show-tick form-control" data-live-search="true">
                                    <option value="">Todos os tipos</option>
                                    <? foreach ($tipo as $value) : ?>
                                        <option value="<?= $value->tipo_entradas_saida_id; ?>" <?
                                        if (@$_GET['nome'] == $value->tipo_entradas_saida_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="empresa" id="empresa" class="form-control show-tick" data-live-search="true">
                                    <option value="">Todas as empresas</option>
                                    <? foreach ($empresa as $value) : ?>
                                        <option value="<?= $value->financeiro_credor_devedor_id; ?>" <?
                                        if (@$_GET['empresa'] == $value->financeiro_credor_devedor_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->razao_social; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text"  id="obs" name="obs" class="form-control"  value="<?php echo @$_GET['obs']; ?>" />
                                    <label class="form-label">Observação</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <button type="submit" class="btn btn-block btn-primary waves-effect">
                                <i class="material-icons">search</i>
                                Pesquisar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->

<?php $totaldalista = 0; ?>
<?php $lista = $this->caixa->listarentrada()->orderby('data desc')->limit(500)->get()->result(); ?>
<div class="row clearfix" style="margin-bottom: 23px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Conta',
            'driver' => 'object',
            'data' => $lista,
            'columns' => [
                'Nome' => 'razao_social',
                'Tipo' => 'tipo',
                'Classe' => 'classe',
                'Dt entrada' => [ 'data', function($value, $row) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $value);
                } ],
                'Valor' => [ 'valor', function($value, $row) use (&$totaldalista) {
                    $totaldalista += $value;
                    return strtr($value, ".", ",");
                } ],
                'Conta' => 'conta',
                'Observação' => 'observacao',
            ],
            'actions' => [
                botao_excluir('/cadastros/caixa/excluirentrada/{entradas_id}'),
                botao_arquivos('/cadastros/caixa/anexarimagementrada/{entradas_id}'),
            ]
        ] ]); ?>
    </div>
</div>
<?php botao_novo('/cadastros/caixa/novaentrada'); ?>

<?php $CI = $this; ?>

<div class="row clearfix" style="margin-bottom: 73px;">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Manter Conta',
            'driver' => 'object',
            'data' => $conta,
            'exportable' => false,
            'columns' => [
                'Contas' => 'descricao',
                'Saldo' => [ 'forma_entradas_saida_id', function($value, $row) use ($CI) {
                    $valor = $CI->caixa->listarsomaconta($value);
                    return number_format($valor[0]->total, 2, ",", ".");
                } ],
            ]
        ] ]); ?>
    </div>
</div>
