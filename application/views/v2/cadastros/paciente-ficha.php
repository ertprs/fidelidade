<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar/" method="post">
        <fieldset>
            <div class="header">
                <legend>Dados do Paciente</legend>
            </div>

            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Nome *</label>
                                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId" >
                                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Nascimento *</label>
                                <input  type="text" name="nascimento" id="txtNascimento" class="nascimento" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Nome da M&atilde;e</label>
                                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Nome do Pai</label>
                                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
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
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>T. logradouro *</label>


                            <select name="tipo_logradouro" id="txtTipoLogradouro" class="size2">
                                <option value='' >selecione</option>
                                <?php
                                $listaLogradouro = $this->paciente->listaTipoLogradouro($_GET);
                                foreach ($listaLogradouro as $item) {
                                    ?>

                                    <option   value =<?php echo $item->tipo_logradouro_id; ?> <?
                                    if (@$obj->_tipoLogradouro == $item->tipo_logradouro_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $item->descricao; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Endere&ccedil;o *</label>
                                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_endereco; ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>N&uacute;mero</label>


                                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Complemento</label>


                                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Bairro *</label>


                                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" required/>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Município *</label>


                                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" />
                                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>CEP</label>


                                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Ocupa&ccedil;&atilde;o</label>
                                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                                <input type="hidden" id="txtcbohidden" class="texto04" name="txtcbohidden" value="<?= @$obj->_cbo_nome; ?>" />
                                <!--                                    <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="--><?//= @$obj->_cbo_nome; ?><!--" />-->
                                <!---->
                                <!---->
                                <!--                                    --><?php
                                //                                    if (@$obj->_consulta == "t") {
                                //                                        ?>
                                <!--                                        <input type="checkbox" name="txtconsulta" checked ="true"/>Realiza consulta-->
                                <!--                                        --><?php
                                //                                    } else {
                                //                                        ?>
                                <!--                                        <input type="checkbox" name="txtconsulta"  />Realiza consulta-->
                                <!--                                        --><?php
                                //                                    }
                                //                                    ?>
                                <input type="hidden" name="txtconsulta" checked ="true"/>
                                <input type="text" id="txtCbo" class="form-control autocomplete-cbo" name="txtcbo"  value="<?php if(isset($obj)) echo $obj->_cbo_nome?>" />
                                <ul id="lista_cbo" class="dropdown-content ac-dropdown"></ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Plano *</label>

                            <select name="plano" id="plano" class="size2" >
                                <option value='' >selecione</option>
                                <?php
                                $planos = $this->formapagamento->listarforma();
                                foreach ($planos as $itens) {
                                    ?>
                                    <option   value =<?php echo $itens->forma_pagamento_id; ?> <?
                                    if (@$obj->_plano_id == $itens->forma_pagamento_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $itens->nome; ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Indicacao</label>


                            <select name="indicacao" id="indicacao" class="size2" >
                                <option value='' >selecione</option>
                                <?php
                                $indicacao = $this->paciente->listaindicacao($_GET);
                                foreach ($indicacao as $item) {
                                    ?>

                                    <option   value =<?php echo $item->paciente_indicacao_id; ?> <?
                                    if (@$obj->_indicacao == $item->paciente_indicacao_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $item->nome; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Pessoa Jurídica</label>

                            <select name="pessoajuridica" id="pessoajuridica" class="size2" required="true">
                                <option value="NAO" <?
                                if (@$obj->_pessoa_juridica == 'f') {
                                    echo 'selected';
                                }
                                ?>>NÃO</option>
                                <option value="SIM" <?
                                if (@$obj->_pessoa_juridica == 't') {
                                    echo 'selected';
                                }
                                ?>>SIM</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Estado civil</label>


                            <select name="estado_civil_id" id="txtEstadoCivil" class="size2" selected="<?= @$obj->_estado_civil; ?>">
                                <option value=0 <?
                                if (@$obj->_estado_civil == 0):echo 'selected';
                                endif;
                                ?>>Selecione</option>
                                <option value=1 <?
                                if (@$obj->_estado_civil == 1):echo 'selected';
                                endif;
                                ?>>Solteiro</option>
                                <option value=2 <?
                                if (@$obj->_estado_civil == 2):echo 'selected';
                                endif;
                                ?>>Casado</option>
                                <option value=3 <?
                                if (@$obj->_estado_civil == 3):echo 'selected';
                                endif;
                                ?>>Divorciado</option>
                                <option value=4 <?
                                if (@$obj->_estado_civil == 4):echo 'selected';
                                endif;
                                ?>>Viuvo</option>
                                <option value=5 <?
                                if (@$obj->_estado_civil == 5):echo 'selected';
                                endif;
                                ?>>Outros</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Situacao</label>
                                <input  name="situacao" id="situacao" class="texto03" readonly value="<?= @$obj->_situacao ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
</fieldset>

<fieldset>

    <div class="header">
        <legend>Documentos / Contatos</legend>
    </div>

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div>
                    <label>CPF/CNPJ</label>
                    <? if (strlen(@$obj->_cpf) <= 11) { ?>
                        <input required type="radio" name="seletorcpf" id="seletorcpf"  value="CPF" checked=""/>CPF
                        <input required type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                    <? } elseif (strlen(@$obj->_cpf) > 11) { ?>
                        <input required type="radio" name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                        <input required type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ" checked=""/>CNJP<br>
                    <? } else { ?>
                        <input required type="radio" name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                        <input required type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                    <? } ?>

                </div>
                <div>
                    <label>CPF *</label>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" name="cpf" id ="cpfcnpj" class="texto03" value="<?= @$obj->_cpf; ?>" />
                        </div>
                    </div>

                    <!--<input type="text" name="cpfcnpj" id ="cpfcnpj" class="texto02" value="" />-->
<!--                    --><?php
//                    if (@$obj->_cpfresp == "t") {
//                        ?>
<!--                        <input type="checkbox" name="cpfresp" checked ="true" />CPF Responsavel-->
<!--                        --><?php
//                    } else {
//                        ?>
<!--                        <input type="checkbox" name="cpfresp"  />CPF Responsavel-->
<!--                        --><?php
//                    }
//                    ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>RG</label>


                        <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>UF Expedidor</label>


                        <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>Data Emiss&atilde;o</label>


                        <input type="text" name="data_emissao" id="txtDataEmissao" class="data" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" />
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">

                        <label>Outro documento</label>


                        <input type="text"   name="outro_documento" id="outro_documento" class="texto03" value="<?= @$obj->_outro_documento; ?>" />
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>Numero</label>
                        <input type="text"   name="numero_documento" id="numero_documentor" class="texto02" value="<?= @$obj->_numero_documento; ?>" />
                    </div>
                </div>
            </div>
        </div>


        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>Email</label>
                        <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$obj->_cns; ?>" required/>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>Telefone</label>


                        <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" required/>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-float">
                    <div class="form-line">
                        <label>Celular *</label>
                        <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" required/>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <a class="btn btn-primary btn-block" onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . @$obj->_paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                </a>
            </div>
        </div>
    </div>
</fieldset>

<fieldset>
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-2 col-xs-12">
                <?= botao_salvar(); ?>
            </div>
            <div class="col-sm-2 col-xs-12">
                <?= botao_limpar(); ?>
            </div>
            <div class="col-sm-2 col-xs-12">
                <?= botao_voltar('/cadastros/pacientes/'); ?>
            </div>
        </div>
    </div>
</fieldset>

</form>

<? // var_dump(strlen(@$obj->_cpf)); die; ?>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $("#txtDataEmissao").mask("99/99/9999");

    $("#seletorcpf").click(function () {
        $("#cpfcnpj").mask("999.999.999-99");
    });
    $("#seletorcnpj").click(function () {
        $("#cpfcnpj").mask("99.999.999/9999-99");
    });


    //                        var tamanho = $("#cpfcnpj").val().length;
    //                        if (tamanho < 11) {
    ////                                alert('sdas');
    //                         $("#cpfcnpj").mask("999.999.999-99");
    //                        } else if (tamanho >= 11) {
    //                            $("#cpfcnpj").mask("99.999.999/9999-99");
    //                        }

    <? if (strlen(@$obj->_cpf) <= 11) { ?>
    $("#cpfcnpj").mask("999.999.999-99");
    <? } else { ?>
    $("#cpfcnpj").mask("99.999.999/9999-99");
    <? } ?>


    //                    $(document).ready(function () {
    //                        jQuery('#form_paciente').validate({
    //                            rules: {
    //                                nome: {
    //                                    required: true,
    //                                    minlength: 3
    //                                },
    //                                sexo: {
    //                                    required: true
    //                                },
    //                                situacao: {
    //                                    required: true
    //                                },
    //                                cpf: {
    //                                    required: true
    //                                },
    //                                telefone: {
    //                                    required: true
    //                                },
    //                                nascimento: {
    //                                    required: true
    //                                }
    //
    //                            },
    //                            messages: {
    //                                nome: {
    //                                    required: "*",
    //                                    minlength: "*"
    //                                },
    //                                sexo: {
    //                                    required: "*"
    //                                },
    //                                situacao: {
    //                                    required: "*"
    //                                },
    //                                cpf: {
    //                                    required: "*"
    //                                },
    //                                telefone: {
    //                                    required: "*"
    //                                },
    //                                nascimento: {
    //                                    required: "*"
    //                                }
    //                            }
    //                        });
    //                    });

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




</script>
