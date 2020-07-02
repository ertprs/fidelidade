<div class="content"> <!-- Inicio da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Relatório</title>
    <style>
        .bolinha{
            border-radius: 100px;
            background-color: red;
            width: 30px;
            height: 30px;
        } 
        td{
            font-family: arial;
        }
    </style>
    
    <h4>RELATÓRIO DE CADASTRO</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <table>
        <tr>
            <td>
                <div class="bolinha"></div>
            </td>
            <td>
                <b>Pendência de confirmação do Financeiro.</b>
            </td>
        </tr>
    </table>
    <hr>
    <?
     
    
    if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header">Numero Registro</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Segmento</th>
                    <th class="tabela_header">Nascimento</th>
                    <th class="tabela_header">CPF</th>
                    <th class="tabela_header">RG</th>
                    <th class="tabela_header">Endere&ccedil;o</th>
                    <th class="tabela_header">Telefone</th>
                    <th class="tabela_header">Data Cadastro</th>
                    <th class="tabela_header">Cidade</th>
                    <th class="tabela_header">Situa&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                
                foreach ($relatorio as $item) :
                   if($item->situacao == "Dependente"){
                     $plano = $this->guia->listarplanodependente($item->paciente_id);  
                   }else{
                     $plano = Array();  
                   } 
                     
                  $cor = "";
                  $contpendenciaadesao = 0 ; 
                  if($item->situacao == "Titular"){  
                      $contpendenciaadesao = count($this->guia->listarpendenciaadesao($item->paciente_id));
                  }else{
                      $contpendenciaadesao = 0;
                  }
                  if($contpendenciaadesao > 0){
                     $cor = "red"; 
                  }
                    $total++;
                    ?>
                    <tr>
                        <td ><font style="color:<?= $cor; ?>;"><?= $item->paciente_id; ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= $item->nome; ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?
                           if($item->situacao == "Dependente"){
                             echo  @$plano[0]->nome;
                           }else{
                             echo  $item->convenio;
                           }
                        
                        ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4); ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= ($item->cpf); ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= ($item->rg); ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= ($item->logradouro) . " " . $item->numero; ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?
                        echo $item->telefone;
                        if ($item->celular != "") {
                            echo " / ".$item->celular;
                        }                        
                        ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= ($item->municipio); ?></td>
                        <td ><font style="color:<?= $cor; ?>;"><?= ($item->situacao); ?></td>
                    </tr>
                <? endforeach; ?>
                <tr>
                    <td colspan="9"><b>TOTAL</b></td>
                    <td ><b><?= $total; ?></b></td>
                </tr>
            </tbody>


            <?
        }
        else {
            ?>
            <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
            <?
        }
        ?>

</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
