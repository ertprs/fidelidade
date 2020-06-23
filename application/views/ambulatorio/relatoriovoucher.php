
<meta charset="utf-8">

<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Voucher</a></h3>
        <div>
            <form name="relatorio" id="relatorio" method="post"  action="<?= base_url() ?>ambulatorio/guia/gerarelatoriovoucher">
                <dl>
                     
                    <dt>
                        <label> Data inicio</label>
                     </dt>
                    <dd>
                        <input id="txtdata_inicio" name="txtdata_inicio"  required="">                        
                    </dd>
                    <dt>
                        <label> Data fim</label>
                     </dt>
                    <dd>
                        <input id="txtdata_fim" name="txtdata_fim" required="">                        
                    </dd>
                    <dt>
                        <label> Parceiro</label>
                     </dt>
                    <dd>
                    <select name="parceiro_id" id="parceiro_id" class="size2" required>
                                        <option value='0' >TODOS</option>
                                        <?php foreach ($listarparceiro as $item) {?>
                                            <option   value =<?php echo $item->financeiro_parceiro_id; ?>>
                                                <?php echo $item->fantasia; ?>
                                            </option>
                                        <? }?> 
                                                
                                            
                                    </select>                   
                    </dd>
                    <dt>
                        <label> Confirmado?</label>
                     </dt>
                    <dd>
                    <select name="confirmacao" id="confirmacao" class="size2">
                        <option value="NAO">NÃO</option>
                        <option value="SIM">SIM</option>
                    </select>                   
                    </dd>

                    <dt>
                        <label> Gratuito?</label>
                     </dt>
                    <dd>
                    <select name="gratuito" id="gratuito" class="size2">
                        <option value="0">TODOS</option>                
                        <option value="NAO">NÃO</option>
                        <option value="SIM">SIM</option>
                    </select>                   
                    </dd>

                    <!-- <dt>
                        <label> Forma Pagamento</label>
                     </dt>
                    <dd>
                    <select name="pagamento_id" id="pagamento_id" class="size2" title="A forma de pagamento só aparece após a confirmação do Voucher" required>
                                        <option value='0' >TODOS</option>
                                        <?php foreach ($pagamentos as $item) {?>
                                            <option   value =<?php echo $item->forma_rendimento_id; ?>>
                                                <?php echo $item->nome; ?>
                                            </option>
                                        <? }?> 
                                                
                                            
                                    </select>                   
                    </dd> -->

                </dl>
                <button type="submit" >Pesquisar</button>
            </form> 
        </div>
    </div>  
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    
    $(function () {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function () {
        $("#accordion").accordion();
    });



</script>