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
                <label>RG</label>
                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
            </div>
             <div>
                 <label> &nbsp;</label>
                 <input type="checkbox" name="cpf_responsavel" id ="cpf_responsavel" <? if (@$obj->_cpf_responsavel_flag == 't') echo "checked"; ?>> CPF do resposável
            </div>
            <div>
                <label>CPF</label>
                <input type="text" name="cpf" id ="txtcpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$obj->_cpf; ?>"   onblur="verificarCPF()"  required/>
              
            </div>
            <div>
                <label>Grau de Parentesco</label>
                <input type="text"  name="grau_parentesco" id="grau_parentesco" class="texto06" value="<?= @$obj->_nomepai; ?>" />
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
            <div>
                <label>Parceiro</label>
                <? $listarparceiro = $this->paciente->listarparceiros(); ?>
                <select name="financeiro_parceiro_id" id="parceiro_id" class="size2">
                    <option value='' >selecione</option>
                    <?php
                    if (count($listarparceiro) == 1) {
                        $true = "selected";
                    } else {
                        $true = "";
                    }
                    foreach ($listarparceiro as $item) {
                        ?>
                        <option   value =<?php echo $item->financeiro_parceiro_id; ?> <?
                        if (@$obj->_financeiro_parceiro_id == $item->financeiro_parceiro_id):echo 'selected';
                        endif;

                        if ($true != "") {
                            echo $true;
                        }
                        ?> ><?php echo $item->fantasia; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
            </div>
            <div>
                <label>Cód. Paciente</label>
                <input type="text" id="cod_pac" class="texto02" name="cod_pac"/>
            </div>
            <div>
                <label>Endereço</label>
                <input type="text"  name="logradouro" id="logradouro" class="texto06" value="<?= @$obj->_endereco; ?>" />
            </div>
            <div>
                <label>Número</label>
                <input type="text"  name="numero" id="numero" class="texto02" value="<?= @$obj->_numero; ?>" />
            </div>
            <div>
                <label>Bairro</label>
                <input type="text"  name="bairro" id="bairro" class="texto03" value="<?= @$obj->_bairro; ?>" />
            </div>
            <div>
                <label>Município </label> 
                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" />
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" />
            </div>
            <div>
                <label>Email</label>
                <input type="text" id="email" class="texto06" name="email"  value="<?= @$obj->_cns; ?>" />
            </div>
            <div>
                <label>Reativar</label> 
                <input type="checkbox"  name="reativar" id="reativar">
            </div>

            <fieldset>
                <legend>Titular</legend>
                <div>
                    <label>Nome</label>
                    <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                    <input type="text" id="txtNomepaciente" name="txtNomepaciente" class="texto10" required=""/>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>

<script type="text/javascript">

                    $("#txtcpf").mask("999.999.999-99");
                    $("#txtNascimento").mask("99/99/9999");
                    $("#cep").mask("99999-999");
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
 
                    function verificarCPF() {
                        // txtcpf
                        var cpf = $("#txtcpf").val();
                        var paciente_id = $("#txtPacienteId").val();
                        if ($('#cpf_responsavel').prop('checked')) {
                            var cpf_responsavel = 'on';
                        } else {
                            var cpf_responsavel = '';
                        }

                        $.getJSON('<?= base_url() ?>autocomplete/verificarcpfpaciente', {cpf: cpf, cpf_responsavel: cpf_responsavel, paciente_id: paciente_id, ajax: true}, function (j) {
                            if (j != '') {
                                alert(j);
                                $("#txtcpf").val('');
                            }
                        });
                    }

</script>
