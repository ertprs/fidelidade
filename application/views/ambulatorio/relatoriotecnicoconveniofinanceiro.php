<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Produção Técnico</a></h3>
        <div>
            <form name="form_paciente" id="form_paciente"  method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriotecnicoconveniofinanceiro">
                <dl>
                    <dt>
                        <label>Técnico</label>
                    </dt>
                    <dd>
                        <select name="tecnicos" id="tecnicos" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($tecnicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >SEM PARTICULAR</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    
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
                    <dt>
                        <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size1" >
                            <option value='0' >TODOS</option>
                            <option value='1' >SEM RM</option>
                            <? foreach ($grupos as $grupo) { ?>                                
                                <option value='<?= $grupo->nome ?>' <?
                                if (@$obj->_grupo == $grupo->nome):echo 'selected';
                                endif;
                                ?>><?= $grupo->nome ?></option>
                                    <? } ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Forma de Pagamento</label>
                    </dt>
                    <dd>
                        <select name="forma_pagamento" id="forma_pagamento" class="size1" >
                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Situação</label>
                    </dt>
                    <dd>
                        <select name="situacao" id="situacao" class="size1" >
                            <option value='' >TODOS</option>
                            <option value='1'>FINALIZADO</option>
                            <option value='0' >ABERTO</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Recibo</label>
                    </dt>
                    <dd>
                        <select name="recibo" id="recibo" class="size1" >

                            <option value='NAO' >NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Ordem do Relatório</label>
                    </dt>
                    <dd>
                        <select name="ordem" id="recibo" class="size1" >

                            <option value='0' >NORMAL</option>
                            <option value='1' >ATENDIMENTO</option>
                        </select>
                    </dd>
                    <?$empresa_id = $this->session->userdata('empresa_id');?>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" <?if($empresa_id == $value->empresa_id){?>selected<?}?>><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Gerar PDF</label>
                    </dt>
                    <dd>
                        <select name="gerarpdf" id="gerarpdf" class="size2">
                            <option value="NAO">NÃO</option>
                            <option value="SIM">SIM</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(document).ready(function () {
        jQuery('#form_paciente').validate({
            rules: {
                txtdata_inicio: {
                    required: true
                },
                txtdata_fim: {
                    required: true
                },
                producao: {
                    required: true
                }

            },
            messages: {
                txtdata_inicio: {
                    required: "*"
                },
                txtdata_fim: {
                    required: "*"
                },
                producao: {
                    required: "*"
                }
            }
        });
    });

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