
<div class="content ficha_ceatox">

    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarplanovalor" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                    <input type="hidden" id="txtpaciente" name="txtpaciente"  class="texto09" value="<?= $paciente_id; ?>" />
                    <input type="hidden" id="paciente_contrato_id" name="paciente_contrato_id"  class="texto09" value="<?= $paciente_contrato_id; ?>" />
                </div>
                <div>
                    <label>Plano</label>                      
                    <select name="plano" id="plano" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        foreach ($planos as $item) {
                            ?>
                        <option   value =<?php echo $item->forma_pagamento_id; ?> <?
                    if ($plano_id == $item->forma_pagamento_id):echo 'selected';
                    endif;
                        ?>><?php echo $item->nome; ?></option>
                            <?php
                        }
                        ?> 
                    </select>
                </div>
                <div>
                    <legend>Forma de pagamento</legend>
                    <div>
                        <input type="radio" name="checkboxvalor1" value="<?= "01" . "-" . $forma_pagamento[0]->valor1; ?>"/>1 x <?= $forma_pagamento[0]->valor1; ?><br>
                        <input type="radio" name="checkboxvalor1"  value="<?= "05" . "-" . $forma_pagamento[0]->valor5; ?>"/>5 x <?= $forma_pagamento[0]->valor5; ?><br>
                        <input type="radio" name="checkboxvalor1"  value="<?= "06" . "-" . $forma_pagamento[0]->valor6; ?>"/>6 x <?= $forma_pagamento[0]->valor6; ?><br>
                        <input type="radio" name="checkboxvalor1"  value="<?= "10" . "-" . $forma_pagamento[0]->valor10; ?>"/>10 x <?= $forma_pagamento[0]->valor10; ?><br>
                        <input type="radio" name="checkboxvalor1"  value="<?= "12" . "-" . $forma_pagamento[0]->valor12; ?>"/>12 x <?= $forma_pagamento[0]->valor12; ?><br>
                    </div>
                    <label>Data Ades&atilde;o</label>
                    <input type="text" name="adesao" id="adesao" class="texto02"/>
                </div>
            </fieldset>
            <button type="submit">Enviar</button>
        </form>

    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function () {
        $("#adesao").datepicker({
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
