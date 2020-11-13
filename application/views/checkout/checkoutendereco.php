<html>
    <head>
        <title>STG - Checkout Cartão</title>
        <meta charset='UTF-8' />

        <link href="<?= base_url() ?>css/bootstrap4/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/jquery-3.5.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.bundle.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/sweetalert2.all.min.js"></script>
    
        <style>
            .letra_pequena{
                font-size: 13px !important;
            }
            .fundo_cinza{
                background-color: #F2F2F2 !important;
            }
            .fundo_personalizado{
                background-color: #ADD8E6 !important;
            }
            .espaco{
                padding-bottom: 20px !important;
            }
            li{
                font-size: 13px !important;
            }
            
        </style>
    </head>

    <body>
    
        <img src="<?=base_url()?>upload/empresalogocheckout/logo.jpg" width="130px" class="rounded mx-auto d-block" alt="Responsive image">

        <div style="width: 100%; min-height: 14px; background: 0 repeat-x url('data:image/svg+xml;utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20width%3D%2214px%22%20height%3D%2212px%22%20viewBox%3D%220%200%2018%2015%22%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cpolygon%20id%3D%22Combined-Shape%22%20fill%3D%22%23ebebeb%22%20points%3D%228.98762301%200%200%209.12771969%200%2014.519983%209%205.40479869%2018%2014.519983%2018%209.12771969%22%3E%3C%2Fpolygon%3E%3C%2Fsvg%3E');"></div>

        <blockquote class="blockquote text-center"><h2><b>Informe os Dados do seu Endereço</b></h2></blockquote>

        <div class="row justify-content-center">
            <div class="col-auto">
            <table class="table table-borderless">
            <thead>
                <tr>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app-indicator.svg" alt="" width="45" height="45" title="Bootstrap"></th>
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

            <?
            
            $valorpormes = 0.00;

                if($planos[0]->valor24 != 0.00){
                    $valorpormes = $planos[0]->valor24;
                }else if($planos[0]->valor23 != 0.00){
                    $valorpormes = $planos[0]->valor23;
                }else if($planos[0]->valor12 != 0.00){
                    $valorpormes = $planos[0]->valor12;
                }else if($planos[0]->valor11 != 0.00){
                    $valorpormes = $planos[0]->valor11;
                }else if($planos[0]->valor10 != 0.00){
                    $valorpormes = $planos[0]->valor10;
                }else if($planos[0]->valor5 != 0.00){
                    $valorpormes = $planos[0]->valor5;
                }else if($planos[0]->valor1 != 0.00){
                    $valorpormes = $planos[0]->valor1;
                }
                
            ?>
        <div class="row justify-content-center">
            <div class="col-auto">
        <table class="table table-hover text-center">
                <tr class="table-info">
                    <td scope="row">Resumo: </td>
                    <th><?=$planos[0]->nome_impressao;?></th>
            <th><?=$planos[0]->parcelas - 1;?> Dependentes Gratuitos | <?=$_POST['forma_mes']?> Meses  <?if($planos[0]->valoradcional > 0.00){?> <div class="letra_pequena">+<?=number_format($planos[0]->valoradcional, 2, ',', '');?> Valor por Dependente adicional </div> <?}?></th>
                    <th>Valor: R$ <?=number_format($planos[0]->valortotal,2, ',','');?> (Valor 1° Mês) <div class="letra_pequena"> Demais mensalidades: R$ <?=number_format($valorpormes,2, ',','');?> </div></th>
                </tr>
            </table>
            </div>
        </div>


                <form>
        <div class="row fundo_cinza">
                    <input type="hidden" name="plano_id" value="<?=$_POST['plano_id']?>" />
                    <input type="hidden" name="forma_mes" value="<?=$_POST['forma_mes']?>" />
                <div class="col-sm-2 espaco"></div>
                <div class="col-sm-4 espaco"><input type="text" name="cep" id="cep" class="form-control" placeholder="CEP" required></div>
                <div class="col-sm-4 espaco"><input type="text" name="logradouro" id="logradouro" class="form-control" placeholder="RUA" required></div>
                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-2 espaco"></div>
                <div class="col-sm-2 espaco"><input type="text" name="numero" id="numero" onblur="validaremail()" class="form-control" placeholder="NÚMERO" required></div>
                <div class="col-sm-3 espaco"><input type="text" name="complemento" id="complemento" class="form-control" placeholder="COMPLEMENTO"></div>
                <div class="col-sm-3 espaco"><input type="text" name="bairro" id="bairro" class="form-control" placeholder="BAIRRO" required></div>
                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-2 espaco"></div>
                <input type="hidden" id="txtCidadeID" name="municipio_id" readonly="true" />
                <div class="col-sm-4 espaco"><input type="text" name="cidade" id="cidade" class="form-control" placeholder="CIDADE" required></div>
                <div class="col-sm-4 espaco"><input type="text" name="estado" id="estado" class="form-control" placeholder="ESTADO" required></div>
                <div class="col-sm-2 espaco"></div>
            </div>

            <div class="row fundo_cinza">
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><a style="width: 100%;" href='' onclick="window.history.go(-1);" class="btn btn-danger"><img src="<?=base_url()?>/css/bootstrap4/icons/arrow-left.svg" alt="" width="32" height="32" title="Bootstrap">Voltar </a></div>
            <div class="col-sm-3"><button style="width: 100%;" type="submit" class="btn btn-success">Avançar <img src="<?=base_url()?>/css/bootstrap4/icons/arrow-right.svg" alt="" width="32" height="32" title="Bootstrap"></button></div>
            <div class="col-sm-3"></div>
            </div>

            </form>

</body>

</html>


<script type="text/javascript">

$("#cep").mask("99999-999");

    $(document).ready(function () {

function limpa_formulário_cep() {

}
// $("#cep").mask("99999-999");

$("#cep").blur(function () {


    var cep = $(this).val().replace(/\D/g, '');


    if (cep != "") {

        var validacep = /^[0-9]{8}$/;

        if (validacep.test(cep)) {

            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#ibge").val(dados.ibge);
                    $.getJSON('<?= base_url() ?>autocomplete/cidadeibge', {ibge: dados.ibge}, function (j) {
                        $("#cidade").val(j[0].value);
                        $("#estado").val(j[0].estado);
                        $("#txtCidadeID").val(j[0].id);
                    });

                } 
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ops...',
                        text: 'CEP não encontrado'
                    });
                }
            });

        }
        else {
            limpa_formulário_cep();
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: "Formato de CEP inválido."
            });
        }
    }
    else {
        limpa_formulário_cep();
    }
});
});

</script>