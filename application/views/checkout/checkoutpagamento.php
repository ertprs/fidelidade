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
            .letra_grande{
                font-size: 20px !important;
            }
            .fundo_cinza{
                background-color: #F2F2F2 !important;
            }
            .fundo_personalizado{
                background-color: #ADD8E6 !important;
            }
            /* .espaco{
                padding-bottom: 1px !important;
            } */
            li{
                font-size: 13px !important;
            }
            .informacao_parcela {
                display: none;
                width: 100%;
                margin-top: 0.25rem;
                font-size: 80%;
                color: #28a745;
                display: block;
            }
            .img_pequena{
                width: 100;
                height: 100;
            }
            
        </style>
    </head>

    <body>
    
        <img src="<?=base_url()?>upload/empresalogocheckout/logo.jpg" width="130px" class="rounded mx-auto d-block" alt="Responsive image">

        <div style="width: 100%; min-height: 14px; background: 0 repeat-x url('data:image/svg+xml;utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20width%3D%2214px%22%20height%3D%2212px%22%20viewBox%3D%220%200%2018%2015%22%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cpolygon%20id%3D%22Combined-Shape%22%20fill%3D%22%23ebebeb%22%20points%3D%228.98762301%200%200%209.12771969%200%2014.519983%209%205.40479869%2018%2014.519983%2018%209.12771969%22%3E%3C%2Fpolygon%3E%3C%2Fsvg%3E');"></div>

        <blockquote class="blockquote text-center"><h2><b>Realize o Pagamento do seu Plano <?=$planos[0]->nome_impressao;?></b></h2></blockquote>

        <div class="row justify-content-center">
            <div class="col-auto">
            <table class="table table-borderless">
            <thead>
                <tr>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/check2-square.svg" alt="" width="45" height="45" title="Bootstrap"></th>
                    <th>_______________________</th>
                    <th align="center" scope="col"><img class="rounded mx-auto d-block" src="<?=base_url()?>/css/bootstrap4/icons/app-indicator.svg" alt="" width="45" height="45" title="Bootstrap"></th>
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
            <th><?=$planos[0]->parcelas - 1;?> Dependentes Gratuitos | <?=$forma_mes?> Meses  <?if($planos[0]->valoradcional > 0.00){?> <div class="letra_pequena">+<?=number_format($planos[0]->valoradcional, 2, ',', '');?> Valor por Dependente adicional </div> <?}?></th>
                    <th>Valor: R$ <?=number_format($planos[0]->valortotal,2, ',','');?> (Valor 1° Mês) <div class="letra_pequena"> Demais mensalidades: R$ <?=number_format($valorpormes,2, ',','');?> </div></th>
                </tr>
            </table>
            </div>
        </div>


                <form class="needs-validation" novalidate action="<?=base_url()?>checkout/inicio/finalizar" method="POST">

        <div class="row fundo_cinza ">
                <input type="hidden" name="guardarsessaocartao" value="ok" />

                <div class="col-sm-2 espaco"></div>
                <div class="col-sm-4 espaco form-group">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item">
                            <b class="letra_grande">Cartão de Cŕedito</b>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4 espaco"></div>
                <div class="col-sm-2 espaco"></div>


                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-4 espaco">
                <label for="nome_cartao">Nome Completo</label>
                    <input type="text" class="form-control" name="nome_cartao" id="nome_cartao" placeholder="NOME COMPLETO" required>
                    <div class="invalid-feedback">
                        Por favor, insira seu nome completo!
                    </div>
                </div>
                
                <div class="col-sm-4 espaco">
                <label for="numero_cartao">Numero Cartão</label>
                    <input type="text" class="form-control" name="numero_cartao" id="numero_cartao" placeholder="NUMERO CARTÃO" required>
                    <div class="invalid-feedback">
                        Por favor, insira seu número de cartão valido!
                    </div>
                </div>
                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-4 espaco form-group">
                <label for="validade">Validade Cartão</label>
                    <input type="text" class="form-control" name="validade" id="validade" placeholder="VALIDADE CARTÃO" required>
                    <div class="invalid-feedback">
                        Por favor, insira uma data valida de Vencimento!
                    </div>
                </div>
                
                <div class="col-sm-4 espaco form-group">
                <label for="cvv">CVV 
                <a data-toggle="tooltip" data-html="true" title="<img src='<?=base_url()?>css/bootstrap4/cvv.png'/>"> <img src="<?=base_url()?>/css/bootstrap4/icons/info-square.svg"/>  </a>
                 </label>
                    <input type="password" class="form-control" name="cvv" id="cvv" placeholder="CVV" maxlength="4" required>
                    <div class="invalid-feedback">
                        Por favor, insira o CVV do seu cartão!
                    </div>
                </div>

                <div class="col-sm-2 espaco"></div>

                <div class="col-sm-2 espaco"></div>
                <div class="col-sm-4 espaco form-group">
                <label for="vencimento">Vencimento da Parcela</label>
                        <select name="vencimento" class="custom-select" id="vencimento" required>
                            <option value='' >Vencimento da Parcela</option>
                            <option value="5" >5</option>
                            <option value="10" >10</option>
                            <option value="15" >15</option>
                            <option value="20" >20</option>
                        </select>
                        <div class="invalid-feedback">Escolha o Dia de Vencimento de sua Parcela!</div>
                        <div id="aviso_parcela" class="informacao_parcela"><spam id="remover"></spam></div>
                </div>
                <div class="col-sm-8 espaco"></div>

                
        </div>

        <div class="row fundo_cinza">
            <div class="col-sm-2 espaco"></div>

            <div class="col-sm-8 form-group form-check">
                <input class="form-check-input" type="checkbox" value="aceito" name="termo" id="termo" required>
                <label class="form-check-label" for="termo">
                Declaro que li e estou de acordo com os <a href="<?=base_url()?>ambulatorio/guia/impressaodeclaracaopacientepdf/" target="_blank">Termos e Condições de Uso</a>
                </label>
                <div class="invalid-feedback">
                    Você deve concordar com o Termo antes de enviar.
                </div>
            </div>           

            <div class="col-sm-2 espaco"></div>
        </div>
        
        <div class="row fundo_cinza">
            <div class="col-sm-4"></div>
            <div class="col-sm-2"><a style="width: 100%;" href='<?=base_url()?>checkout/inicio/endereco' class="btn btn-danger"><img src="<?=base_url()?>/css/bootstrap4/icons/arrow-left.svg" alt="" width="32" height="32" title="Bootstrap">Voltar </a></div>
            <div class="col-sm-2"><button  id="submit" style="width: 100%;" type="submit" class="btn btn-success">Finalizar <img src="<?=base_url()?>/css/bootstrap4/icons/arrow-right.svg" alt="" width="32" height="32" title="Bootstrap"></button></div>
            <div class="col-sm-4"></div>
        </div>

            </form>

</body>
</html>


<script type="text/javascript">

$("#numero_cartao").mask("9999 9999 9999 9999");
$("#validade").mask("99/9999");


function check(div){
    if(div.checked == true){
      document.getElementById('submit').disabled = false;
    }
    else{
      document.getElementById('submit').disabled = true;
    }
  }

$("#vencimento").change(function() {
    var data = new Date();
    var dia = data.getDate();

    console.log(dia);
    console.log($("#vencimento").val());
    if($("#vencimento").val() >= dia){
        $("#remover").remove();
        $("#aviso_parcela").append('<spam id="remover">Ao escolher um Dia superior ao de Hoje, a 1º parcela será cobrada ainda esse mês</spam>');
    } 
});


  (function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


$(function() {
 $('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'right',
    html: true
 });
});

</script>