<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">&nbsp;&nbsp;&nbsp; Gerar CNAB</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarcnab">
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>
            <hr>
            <h3 class="singular"><a href="#">Arquivos CNAB</a></h3>
            <div>
                <table>
                    <tr>
                        <?
                        $this->load->helper('directory');
                        $arquivo_pasta = directory_map("./upload/CNAB/");
                        if ($arquivo_pasta != false) {
                            ?>
                        <tr>
                            <?
                            foreach ($arquivo_pasta as $value) {
                                ?>
                                <td width="10px"> <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "./ambulatorio/guia/downloadTXTsicoob/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url(); ?>img/archive-zip-icon.png"><br><? echo $value ?></td>
                                <td>&nbsp;</td>        
                            <br><?
                            }
                        }
                        ?>
                        </tr>
                   
                </table>
            </div>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
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

    $(function () {
        $('#tipo').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaida', {tipo: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#classe').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe').html('<option value="">TODOS</option>');
            }
        });
    });
</script>