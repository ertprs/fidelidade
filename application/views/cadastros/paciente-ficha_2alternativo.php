<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar2" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome *</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" readonly/>
            </div>
            <div>
                <label>Nascimento *</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" readonly/>
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" readonly/>
            </div>
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>" readonly/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size1">
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
                <label>T. logradouro *</label>


                <select name="tipo_logradouro" id="txtTipoLogradouro" class="size2" >
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
            <div>
                <label>Endere&ccedil;o *</label>
                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_endereco; ?>" readonly/>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" readonly/>
            </div>
            <div>
                <label>Complemento</label>


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>" readonly/>
            </div>
            <div>
                <label>Bairro *</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" readonly/>
            </div>


            <div>
                <label>Município *</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" readonly/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" readonly/>
            </div>
            <div>
                <label>Ocupa&ccedil;&atilde;o</label>
                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" readonly/>
            </div>


            <div>
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

            <div>
                <label>Situacao</label>
                <select name="situacao" id="situacao" class="size2">
                    <option value="Titular" <?
                    if (@$obj->_situacao == "Titular"):echo 'selected';
                    endif;
                    ?>>Titular</option>
                    <option value="Dependente" <?
                    if (@$obj->_situacao == "Dependente"):echo 'selected';
                    endif;
                    ?>>Dependente</option>
                </select>
            </div>
            <div>
                <label>Responsavel financeiro</label>
                <input type="text" id="financeiro" class="texto10"  name="financeiro" value="<?= @$obj->_financeiro; ?>" readonly/>
            </div>
            <div>
                <label>Cód. cliente</label>
                <input type="text" id="cod_pac" class="texto04" name="cod_pac" value="<?= @$obj->_codigo_paciente; ?>" readonly/>
            </div>
            <div>
                <label>Protocolo liga&ccedil;&atilde;o</label>
                <input type="text" id="ligacao" class="texto04" name="ligacao" value="<?= @$obj->_ligacao; ?>" readonly/>
            </div>
            <div>
                <label>Plano *</label>

                <select name="plano" id="plano" class="size2" >
                    <option value="" >selecione</option>
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

            <div>
                <label>Vendedor</label>

                <select name="vendedor" id="vendedor" class="size2" >
                    <option value="" >selecione</option>
                    <?php
                    $listarvendedor = $this->paciente->listarvendedor();
                    foreach ($listarvendedor as $item) {
                        ?>
                        <option   value =<?php echo $item->operador_id; ?><?
                        if (@$obj->_vendedor == $item->operador_id):echo 'selected';
                        endif;
                        ?>><?php echo $item->nome; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
            </div>

            <div>
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

            <div>
                <label>Parceiro</label>
                <input type="text" id="parceiro" class="texto03" name="parceiro" value="<?= @$obj->_parceiro; ?>" readonly/>
            </div>

            <div>
                <label>Cod. Paciente</label>
                <input type="text" id="codigo_paciente" class="texto03" name="codigo_paciente" value="<?= @$obj->_codigo_paciente; ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Documentos / Contatos</legend>
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
                <label>CPF/CNPJ</label>
                <input type="text" name="cpf" id ="cpfcnpj" maxlength="18"  class="texto03" value="<?= @$obj->_cpf; ?>" required/>
                <input type="checkbox" name="cpf_responsavel" id ="cpf_responsavel" <? if (@$obj->_cpf_responsavel_flag == 't') echo "checked"; ?>> CPF do resposável
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" />
            </div>
            <div>
                <label>UF Expedidor</label>


                <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>"/>
            </div>
            <div>
                <div>
                    <label>Data Emiss&atilde;o</label>


                    <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" />
                </div>

                <div>

                    <label>Outro documento</label>


                    <input type="text"   name="outro_documento" id="outro_documento" class="texto03" value="<?= @$obj->_outro_documento; ?>" />
                </div>

                <div>
                    <label>Numero</label>
                    <input type="text"   name="numero_documento" id="numero_documentor" class="texto02" value="<?= @$obj->_numero_documento; ?>" />
                </div>


                <div>
                    <label>Email</label>
                    <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$obj->_cns; ?>" required/>
                </div>
                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>"/>
                </div>
                <div>
                    <label>Celular *</label>
                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="(99) 99999-9999" value="<?= @$obj->_celular; ?>" required/>
                </div>
                <div class="bt_linkm">
                    <a onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . @$obj->_paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                    </a></div>
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
                        $("#txtDataEmissao").mask("99/99/9999");
                        $("#txtCelular").mask("(99) 99999-9999");
                        $("#txtTelefone").mask("(99) 9999-9999");

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

//                        $(document).ready(function () {
//                            jQuery('#form_paciente').validate({
//                                rules: {
//                                    celular: {
//                                        required: true
//                                    },
//                                    cpf: {
//                                        required: true
//                                    },
//                                    telefone: {
//                                        required: true
//                                    }
//
//                                },
//                                messages: {
//                                    celular: {
//                                        required: "*"
//                                    },
//                                    cpf: {
//                                        required: "*"
//                                    },
//                                    telefone: {
//                                        required: "*"
//                                    }
//                                }
//                            });
//                        });

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
