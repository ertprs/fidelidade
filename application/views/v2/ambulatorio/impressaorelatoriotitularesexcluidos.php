<!--<meta charset="utf-8">-->
<!---->
<!---->
<!--    <!--<h4>PERIODO: --><?//= $txtdata_inicio; ?><!-- ate --><?//= $txtdata_fim; ?><!--</h4>-->
<!--    <hr>-->
<!--    --><?//
//    if (count($relatorio) > 0) {
//        ?>
<!--        <table border="1" cellspacing="0" cellpadding="5">-->
<!--            <thead>-->
<!--                <tr>-->
<!--                    <th class="tabela_header">Nome</th>-->
<!--                    <th class="tabela_header">CPF</th>-->
<!--                    <th class="tabela_header">Telefone</th>-->
<!--                    <th class="tabela_header">Data Nascimento</th>-->
<!--                    <th class="tabela_header">Data Exclusao</th>-->
<!--                    <th class="tabela_header">Operador Exclusão</th>-->
<!--                </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--                --><?php
//                $total = 0;
//                foreach ($relatorio as $item) :
//                    $total++;
//                    ($item->telefone != '') ? $telefone = $item->telefone : $telefone = $item->celular;
//                    ?>
<!--                    <tr>-->
<!--                        <td >--><?//= $item->nome; ?><!--</td>-->
<!--                        <td >--><?//= $item->cpf; ?><!--</td>-->
<!--                        <td >--><?//= $telefone; ?><!--</td>-->
<!--                        <td style="text-align: right">--><?//= date("d/m/Y", strtotime($item->nascimento))?><!--</td>-->
<!--                        <td style="text-align: right">--><?//= date("d/m/Y", strtotime($item->data_exclusao))?><!--</td>-->
<!--                         <td >--><?//= $item->operador; ?><!--</td>-->
<!--                    </tr>-->
<!--                --><?// endforeach; ?>
<!--                <tr>-->
<!--                    <td colspan="4"><b>TOTAL</b></td>-->
<!--                    <td colspan="1"><b>--><?//= $total; ?><!--</b></td>-->
<!--                </tr>-->
<!--            </tbody>-->
<!--        </table>-->
<!--            --><?//
//        }
//        else {
//            ?>
<!--            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>-->
<!--            --><?//
//        }
//        ?>
<!---->
<!--</div> <!-- Final da DIV content -->

<?php

$total = 0; ?>
<div class="row clearfix">
    <div class="col-xs-12">
        <?php $this->load->view('v2/_parts/datatable', [ 'config' => [
            'titulo' => 'Relatório de Titulares Excluídos',
            'driver' => 'object',
            'data' => $relatorio,
            'columns' => [
                    'Nome' => 'nome',
                'CPF' => 'cpf',
                'Telefone' => 'telefone',
                'Nascimento' => [ 'nascimento', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'Data Exclusão' => [ 'data_exclusao', function($data) {
                    return preg_replace("/^(\d{4})\-(\d{2})\-(\d{2})$/", "$3/$2/$1", $data);
                } ],
                'Operador Exlusão' => 'operador'
            ]
        ] ]); ?>
    </div>
</div>









