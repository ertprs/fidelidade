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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar pagamento</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravaralterarpagamentoempresa/<?= $paciente_contrato_parcelas_id; ?>" method="post">
                <input type="hidden" name="empresa_cadastro_id" id="empresa_cadastro_id" value="<?= $empresa_cadastro_id; ?>">
                <fieldset> 
                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Data</label>
                        </dt>
                        <dd>
                            <input type="text" name="data" id="data" alt="date" value='<?=date("d/m/Y",strtotime($pagamento[0]->data))?>' required/>
                        </dd>
                        <dt>
                            <label>Forma de Pagamento</label>
                        </dt> 
                        <dd>
                             <select name="forma_rendimento_id" name="forma_rendimento_id">
                                <? foreach($forma_pagamentos as $item){  ?>
                                  <option value="<?=  $item->forma_rendimento_id; ?>"><?= $item->nome?></option> 
                                <? } ?>  
                            </select>
                        </dd>
                        <dt>
                            <label>Conta</label>
                        </dt>   
                        <dd>
                            <select  name="conta">
                                <option value="" >Selecione</option>
                                <?
                                foreach($contas as $conta){ 
                                    ?> 
                         <option value=<?= $conta->forma_entradas_saida_id ?>  ><?= $conta->descricao; ?></option> 
                                <?    
                                }
                                ?>
                            </select>
                        </dd>
                        
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
