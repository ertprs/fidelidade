<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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
<style>
    td{
        width: 70px;
    }
</style>
<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">STATUS CONSULTA EXTRA</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarstatusconsultaextra/<?= $consulta_avulsa_id; ?>/<?= $paciente_id; ?>/<?= $contrato_id; ?>" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <table>
                            
                            <tr>
                                <td style="width:100px;">
                                    STATUS:
                                </td>
                                <td>
                                    <? $operador_id = $this->session->userdata('operador_id');?>
                                    <? $perfil_id = $this->session->userdata('perfil_id');?>
                                    <select <?=($perfil_id != 1 && @$consulta[0]->utilizada == 't') ? 'disabled' : ''?> name="status" id="status" class="size2" required>
                                        <option value="f" <?if (@$consulta[0]->utilizada == 'f'):echo 'selected';endif;?>>
                                            NÃO UTILIZADA
                                        </option>
                                        <option value="t"  <?if (@$consulta[0]->utilizada == 't'):echo 'selected';endif;?>>
                                            UTILIZADA
                                        </option>
                                        
                                                
                                            
                                    </select>
                                </td>
                            </tr>
                        </table>
                            
                        
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
