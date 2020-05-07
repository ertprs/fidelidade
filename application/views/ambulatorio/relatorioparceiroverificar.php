
<meta charset="utf-8">

<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio parceiro verificar</a></h3>
        <div>
            <form name="relatorio" id="relatorio" method="post"  action="<?= base_url() ?>ambulatorio/guia/gerarelatorioparceiroverificar">
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
                        <label>Parceiro</label>
                    </dt> 
                    <dd>
                        <select name="parceiro" id="parceiro">
                            <option value="0">TODOS</option>
                            <?php foreach($listarparceiro as $item){
                                ?>
                            <option value="<?= $item->financeiro_parceiro_id; ?>"><?= $item->fantasia; ?></option>
                            <?
                            }
                         ?>                            
                        </select>
                    </dd> 
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