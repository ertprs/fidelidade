<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#data").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

</script>
<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Auditoria Parcela de: <?=date("d/m/Y", strtotime($pagamento[0]->data))?></h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravaralterarobservacao/<?= $paciente_contrato_parcelas_id; ?>/<?= $paciente_id; ?>/<?= $contrato_id; ?>" method="post">
                <fieldset>

                    <table border="0">
                        <tr>
                            <td>
                                Cadastro: <?=$pagamento[0]->operador_cadastro?> Data: <?=date("d/m/Y H:i:s", strtotime($pagamento[0]->data_cadastro))?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Última atualização: <?=$pagamento[0]->operador_atualizacao?> Data: <?=($pagamento[0]->data_atualizacao != '')? date("d/m/Y H:i:s", strtotime($pagamento[0]->data_atualizacao)): '';?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Cadastro Agendamento Cartão: <?=$pagamento[0]->operador_cartao_cadastro?> Data: <?=($pagamento[0]->data_cartao_cadastro != '')? date("d/m/Y H:i:s", strtotime($pagamento[0]->data_cartao_cadastro)): ''?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Cancelamento Agendamento Cartão: <?=$pagamento[0]->operador_cartao_exclusao?> Data: <?=($pagamento[0]->data_cartao_exclusao != '')? date("d/m/Y H:i:s", strtotime($pagamento[0]->data_cartao_exclusao)): ''?>
                            </td>
                        </tr>
                    </table>

                    <hr/>
                    <!-- <button type="submit" name="btnEnviar" >Enviar</button> -->
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
