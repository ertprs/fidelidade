
<div class="content ficha_ceatox">

    <div >
        <?
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa');
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
        <?
        $empresa = $this->guia->listarempresa();
        ?>
        <h3 class="singular"><a href="#">Nova Parcela</a></h3>
        <div>
            <!--<form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravardependentes" method="post">-->
            <fieldset>
                <div class="header">
                    <legend>Dados do Paciente</legend>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Nome</label>
                                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                                    <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                                    <input type="hidden" id="txtcontrato_id" name="txtcontrato_id"  value="<?= $contrato_id; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Sexo</label>
                                <select name="sexo" id="txtSexo" class="size2">
                                    <option value="M" <?
                                    if ($paciente['0']->sexo == "M"):echo 'selected';
                                    endif;
                                    ?>>Masculino</option>
                                    <option value="F" <?
                                    if ($paciente['0']->sexo == "F"):echo 'selected';
                                    endif;
                                    ?>>Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Nascimento</label>


                                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Idade</label>
                                    <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-10">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Nome da M&atilde;e</label>


                                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!--</form>-->
            <fieldset>
                <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarnovaparcelacontrato/<?= $paciente_id ?>/<?= $contrato_id ?>" method="post">
                    <fieldset>
                        <div class="header">
                            <legend>Dados da Consulta</legend>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Valor</label>
                                            <input type="text" id="valor" name="valor" alt="decimal" class="valor-base" value="" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Data</label>
                                            <input type="text" id="data" name="data"  class="texto02" value="" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <?= botao_salvar() ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>


            </fieldset>

        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!---->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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
    <?php if ($this->session->flashdata('message') != ''): ?>
    alert("<? echo $this->session->flashdata('message') ?>");
    <? endif; ?>

    $(function () {
        $("#accordion").accordion();
    });

</script>