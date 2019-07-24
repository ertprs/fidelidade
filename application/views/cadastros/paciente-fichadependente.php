<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravardependente" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome *</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" required/>
            </div>
            <div>
                <label>Nascimento *</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" required/>
            </div>
            <div>
                <label>Grau de Parentesco</label>
                <input type="text"  name="grau_parentesco" id="grau_parentesco" class="texto06" value="<?= @$obj->_nomepai; ?>" />
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="(99) 99999-9999" value="<?= @$obj->_celular; ?>" required/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size1" required>
                    <option value="" <?
                    if (@$obj->_sexo == ""):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value="M" <?
                    if (@$obj->_sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if (@$obj->_sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                </select>
            </div>
            <fieldset>
                <legend>Titular</legend>
                <div>
                    <label>Nome</label>
                    <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                    <input type="text" id="txtNomepaciente" name="txtNomepaciente" class="texto10"/>
                </div>

            </fieldset>


        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>

        <a href="<?= base_url() ?>cadastros/pacientes">
            <button type="button" id="btnVoltar">Voltar</button>
        </a>

    </form>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">



    $(function () {
        $("#txtcbo").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtcbo").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtcbo").val(ui.item.value);
                $("#txtcboID").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });
    $(function () {
        $("#txtEstado").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=estado",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtEstado").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtEstado").val(ui.item.value);
                $("#txtEstadoID").val(ui.item.id);
                return false;
            }
        });
    });



    $(function () {
        $("#txtNomepaciente").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientetitular",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtNomepaciente").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNomepaciente").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#txtTelefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                $("#txtEnd").val(ui.item.endereco);
                return false;
            }
        });
    });


</script>
