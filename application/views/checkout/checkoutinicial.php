<html>
    <head>
        <title>STG - Checkout Cartão</title>
        <meta charset='UTF-8' />

        <link href="<?= base_url() ?>css/bootstrap4/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/jquery-3.5.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.bundle.min.js" ></script>
    
        <style>
            .letra_pequena{
                font-size: 11px !important;
            }
            .fundo_cinza{
                background-color: #F2F2F2 !important;
            }
            .fundo_personalizado{
                background-color: #ADD8E6 !important;
            }
            .espaco{
                padding-bottom: 8px !important;
            }
            li{
                font-size: 13px !important;
            }
        </style>
    </head>

    <body>
    
        <img src="<?=base_url()?>upload/empresalogocheckout/logo.jpg" width="130px" class="rounded mx-auto d-block" alt="Responsive image">

        <div style="width: 100%; min-height: 14px; background: 0 repeat-x url('data:image/svg+xml;utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20width%3D%2214px%22%20height%3D%2212px%22%20viewBox%3D%220%200%2018%2015%22%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cpolygon%20id%3D%22Combined-Shape%22%20fill%3D%22%23ebebeb%22%20points%3D%228.98762301%200%200%209.12771969%200%2014.519983%209%205.40479869%2018%2014.519983%2018%209.12771969%22%3E%3C%2Fpolygon%3E%3C%2Fsvg%3E');"></div>

        <blockquote class="blockquote text-center"><h2><b>Escolha seu Plano e Confira seus Dados</b></h2></blockquote>


        <div class="row justify-content-center">
            <div class="col-auto">
            <table class="table table-borderless">
            <thead>
                <tr>
                    <!-- <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app-indicator.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app.svg" alt="" width="45" height="45" title="Bootstrap"></th> -->
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app-indicator.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                </tr>
                <tr>
                    <th scope="col">Plano</th>
                    <th scope="col"></th>
                    <th scope="col">Titular</th>
                    <th scope="col"></th>
                    <th scope="col">Endereço</th>
                    <th scope="col"></th>
                    <th scope="col">Pagamento</th>
                </tr>
            </thead>
            </table>
            </div>
        </div>


            <form action="<?=base_url()?>checkout/inicio/titular" method="POST">
        <div class="row">

        <div class="col-sm-9 row">

            <?foreach($planos as $plano){
                $valorpormes = 0.00;

                if($plano->valor24 != 0.00){
                    $valorpormes = $plano->valor24;
                }else if($plano->valor23 != 0.00){
                    $valorpormes = $plano->valor23;
                }else if($plano->valor12 != 0.00){
                    $valorpormes = $plano->valor12;
                }else if($plano->valor11 != 0.00){
                    $valorpormes = $plano->valor11;
                }else if($plano->valor10 != 0.00){
                    $valorpormes = $plano->valor10;
                }else if($plano->valor5 != 0.00){
                    $valorpormes = $plano->valor5;
                }else if($plano->valor1 != 0.00){
                    $valorpormes = $plano->valor1;
                }
                ?>
                <div class="col-sm-4 espaco">
                    <div class="card text-center fundo_cinza">
                    <div class="card-body">
                        <h5 class="card-title"><?=$plano->nome_impressao?></h5>
                        <p class="card-text"> <b><h5>Assinatura Mensal</h5> <h5>R$ <?=number_format($valorpormes, 2, ',', '');?> /Mês</b> </h5>
                        +Taxa de Adesão: R$<?=number_format($plano->valor_adesao, 2, ',', '');?> <br> 
                        +Carteirinha: R$<?=number_format($plano->valor_carteira_titular, 2, ',', '');?> <br>
                        <b class="letra_pequena">*A taxa de adesão é uma cobrança única</b> <br><br>
                        <a href="#resumo_assinatura" class="btn btn-primary" onclick="informacoes_resumo(<?=$plano->forma_pagamento_id?>)">Ver Detalhes</a>
                    </div>
                    </div>
                </div>
            <?}?>
        </div>

            <div class="col-sm-3" id="resumo_assinatura">
                <div class="card text-right" id="removeresumo">
                <div class="card-body">
                    <h5 class="card-title"><b>Selecione um Plano</b></h5> <hr>
                    <p class="card-text"><h5><b>Resumo</b></h5></p> <hr>
                    <b>Valor Total: <font size='5'>R$ 0,00 </font></b>
                    <!-- <a href="#" class="btn btn-primary">TESTE</a> -->
                </div>
                </div>
            </div>

        </div>
                </form>
    </body>
</html>

<script type="text/javascript">

    function informacoes_resumo(plano_id){

        $.getJSON('<?= base_url() ?>autocomplete/listardetalhesplano', {plano_id: plano_id,  ajax: true}, function (j) {
            qtdmeses = 0;
            valor_mes = 0;
            if(j[0].valor24 != 0.00){
                qtdmeses = 24;
                valor_mes = j[0].valor24;
            }else if(j[0].valor23 != 0.00){
                qtdmeses = 23;
                valor_mes = j[0].valor23;
            }else if(j[0].valor12 != 0.00){
                qtdmeses = 12;
                valor_mes = j[0].valor12;
            }else if(j[0].valor11 != 0.00){
                qtdmeses = 11;
                valor_mes = j[0].valor11;
            }else if(j[0].valor10 != 0.00){
                qtdmeses = 10;
                valor_mes = j[0].valor10;
            }else if(j[0].valor5 != 0.00){
                qtdmeses = 5;
                valor_mes = j[0].valor5;
            }else if(j[0].valor1 != 0.00){
                qtdmeses = 1;
                valor_mes = j[0].valor1;
            }

            if(qtdmeses <= 1){
                texto_mes = qtdmeses+' Mês de Fidelidade';
            }else{
                texto_mes = qtdmeses+' Meses de Fidelidade';
            }
                  
            qtd_dependentes = j[0].parcelas - 1;
            
            if(j[0].valoradcional > 0.00){
                textocompleto = '<li>'+qtd_dependentes+' Dependentes Gratuitos</li>'+
                                '<li>'+j[0].valoradcional.replace(".", ",")+' Valor por Dependente adicional</li>';
            }else{
                textocompleto = '<li>'+qtd_dependentes+' Dependentes Gratuitos</li>';
            }
            
            // totalgeral = Number(valor_mes) + Number(j[0].valortotal);
            totalgeral = Number(j[0].valortotal);
            // totalgeral = Number(j[0].valortotal) + Number(j[0].valor_carteira_titular);
                $("#removeresumo").remove();

                $("#resumo_assinatura").append(
                    '<div class="card text-right fundo_personalizado" id="removeresumo">'+
                        '<div class="card-body">'+
                            '<h5 class="card-title"><b>Detalhes do Plano</b></h5> <hr>'+
                                '<ul>'+
                                    '<li>'+texto_mes+'</li>'+
                                    textocompleto+
                                    '<li>Taxa de Adesão: Cobrança Única</li>'+
                                '</ul>'+
                            '<p class="card-text"><h5><b>Resumo</b></h5></p> <hr>'+
                                // '+Mensalidade: R$ '+valor_mes.replace(".", ",")+' <br>'+
                                '+Taxa de Adesão: R$ '+j[0].valor_adesao.replace(".", ",")+' <br>'+
                                '+Carteirinha: R$ '+j[0].valor_carteira_titular.replace(".", ",")+' <br>'+
                            '<b>Valor Total: <font size="5">R$ '+totalgeral.toFixed(2).toString().replace(".", ",")+' </font></b>'+
                            '<input type="hidden" name="plano_id" value="'+plano_id+'"/>'+
                            '<input type="hidden" name="forma_mes" value="'+qtdmeses+'"/>'+
                            '<input type="hidden" name="guardarsessao" value="ok" />'+
                            '<br> <br> <button type="submit" class="btn btn-success">Avançar <img src="<?=base_url()?>/css/bootstrap4/icons/arrow-right.svg" alt="" width="32" height="32" title="Bootstrap"></button>'
                );
            });
    }

</script>