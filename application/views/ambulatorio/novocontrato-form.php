
<div class="content ficha_ceatox">

    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarplano" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                    <input type="hidden" id="txtpaciente" name="txtpaciente"  class="texto09" value="<?= $paciente_id; ?>" />
                </div>
                <div>
                    <label>Plano</label>                      
                    <select name="plano" id="plano" class="size2" >
                        <option value='' >selecione</option>
                        <?php
                        foreach ($planos as $item) {
                            ?>

                            <option   value =<?php echo $item->forma_pagamento_id; ?>><?php echo $item->nome; ?></option>
                            <?php
                        }
                        ?> 
                    </select>
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
