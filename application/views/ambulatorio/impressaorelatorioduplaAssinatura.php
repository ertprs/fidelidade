<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
<style>
    table{
        border-collapse: collapse;
        border-spacing: 20px;
    }
    .tabelaPadrao td,th{
        padding: 6px;
        /* margin-right: 10px; */
    }
    .left{
        text-align: left;
    }
    .right{
        text-align: right;
    }
    .cinza{
        /* background-color: gray; */
    }
    th{
        background-color: #AAA7A7;
    }
    a:hover{
        color: red;
    }
</style>

    <h4>RELATORIO DUPLA ASSINATURA</h4>
    <h4>EMPRESA: <?=($_POST['empresa'] > 0) ? $empresa[0]->nome : 'TODAS';?></h4>
    <h4>MOVIMENTAÇÃO: <?=($_POST['movimentacao'] != '') ? $_POST['movimentacao'] : 'TODAS';?></h4>
    <h4>STATUS: <?=($_POST['status'] != '') ? $_POST['status'] : 'TODOS';?></h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <hr>
    <?
    if (count($relatorio) > 0 || count($relatorio_desconto) > 0) {
        ?>
        <table border="1" class="tabelaPadrao">
            <thead>
                <tr >
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Movimentação</th>
                    <th class="tabela_header">Status</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Operador Cadastro</th>
                    <th class="tabela_header">Operador Confirmação</th>
                    <th class="tabela_header">Empresa</th>
                    <!-- <th class="tabela_header">Saldo</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $data = 0;
                $totalrelatorio = 0;
                foreach ($relatorio as $item) :
//                    if ($item->tiposaida != 'TRANSFERENCIA' && $item->tipoentrada != 'TRANSFERENCIA') {
                        $total = $total + abs($item->valor);
                        $totalrelatorio = $totalrelatorio + abs($item->valor);
                        if($item->entradas_id > 0){
                            $movimentacao = 'ENTRADA';
                            $id = $item->entradas_id;
                            $confirmacao = $item->confirmacao_entrada;
                            $operador_confirmacao = $item->operador_confirmacao_e;
                        }else{
                            $movimentacao = 'SAIDA';
                            $id = $item->saidas_id;
                            $confirmacao = $item->confirmacao_saida;
                            $operador_confirmacao = $item->operador_confirmacao_s;
                        }
                        $operador_cadastro = $item->operador;
                       
//                    }

//                    $totalrelatorio = $totalrelatorio + $item->valor;
                    $dataatual = substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4);
                    ?>

                    <tr>
                        <td class="right"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= $item->razao_social; ?></td>
                        <td ><?=$movimentacao?></td>
                        <?if($confirmacao == 't'){?>
                            <td >CONFIRMADO</td>
                        <?}else{?>
                        <td > 
                            <?
                            $operador_atual = $this->session->userdata('operador_id');
                            if($item->operador_cadastro != $operador_atual){?>
                                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "cadastros/caixa/confirmarduplaAssinatura/{$id}/{$movimentacao}"?>', '_blank', 'width=800,height=800');">
                                    NÃO CONFIRMADO
                                </a>
                            <?}else{?>
                                    NÃO CONFIRMADO
                            <?}?>
                            
                        </td>
                        <?}?>
                        
                        <td class="right"><b><?= number_format(abs($item->valor), 2, ",", "."); ?></b></td>
                        <td ><?= $operador_cadastro; ?></td>
                        <td ><?= $operador_confirmacao; ?></td>
                        <td ><?= $item->empresa; ?></td>
                        
                    </tr>


                <? endforeach; ?>
                <?php
               
                foreach ($relatorio_desconto as $item) :
//                    if ($item->tiposaida != 'TRANSFERENCIA' && $item->tipoentrada != 'TRANSFERENCIA') {
                        $total = $total + $item->valor;
                        $totalrelatorio = $totalrelatorio + $item->valor;
                     
                        $confirmacao = $item->confirmacao_desconto;
                        $movimentacao = 'DESCONTO';
                        $id = $item->agenda_exames_id;
                        $operador_desconto = $item->operador_desconto;
                        $operador_confirmacao = $item->operador_confirmacao;
                       
//                    }

//                    $totalrelatorio = $totalrelatorio + $item->valor;
                    $dataatual = substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4);
                    ?>

                    <tr>
                        <td class="right"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td ><?= $item->paciente; ?></td>
                        <td >DESCONTO</td>
                        <?if($confirmacao == 't'){?>
                            <td >CONFIRMADO</td>
                        <?}else{?>
                        <td > 
                            <?
                            $operador_atual = $this->session->userdata('operador_id');
                            if($item->operador_id != $operador_atual){?>
                                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "cadastros/caixa/confirmarduplaAssinatura/{$id}/{$movimentacao}"?>', '_blank', 'width=800,height=800');">
                                    NÃO CONFIRMADO
                                </a>
                            <?}else{?>
                                    NÃO CONFIRMADO
                            <?}?>
                            
                        </td>
                        <?}?>
                        
                        <td class="right"><b><?= number_format($item->valor, 2, ",", "."); ?></b></td>
                        <td ><?= $operador_desconto; ?></td>
                        <td ><?= $operador_confirmacao; ?></td>
                        <td ><?= $item->empresa; ?></td>
                    </tr>


                <? endforeach; ?>
              
            </tbody>


            <?
        } else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
