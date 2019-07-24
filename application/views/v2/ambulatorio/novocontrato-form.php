
<div class="content ficha_ceatox">

    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarplano" method="post">
            <div style="display: none;">
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
                                        <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                                        <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Nascimento *</label>
                                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Nome da M&atilde;e</label>
                                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" readonly/>
                                    </div>
                                </div>
                            </div>
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
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Documentos / Contatos</legend>
                    <div>
                        <label>CPF *</label>

                        <? if (strlen(@$obj->_cpf) <= 11) { ?>
                            <input type="text" name="cpf" id ="txtCpf"  alt="cpf" class="texto04" value="<?= @$obj->_cpf; ?>" readonly/>
                        <? } else { ?>
                            <input type="text" name="cpf" id ="txtCpf"  alt="cnpj" class="texto04" value="<?= @$obj->_cpf; ?>" readonly/>
                        <? } ?>
                        <?php
                        if (@$obj->_cpfresp == "t") {
                            ?>
                            <input type="checkbox" name="cpfresp" checked ="true" readonly/>CPF Responsavel
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="cpfresp"  readonly/>CPF Responsavel
                            <?php
                        }
                        ?>
                    </div>
                    <div>
                        <label>RG</label>


                        <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" readonly/>
                    </div>
                    <div>
                        <label>UF Expedidor</label>


                        <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>"readonly/>
                    </div>
                    <div>
                        <div>
                            <label>Data Emiss&atilde;o</label>


                            <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" readonly/>
                        </div>

                        <div>

                            <label>Outro documento</label>


                            <input type="text"   name="outro_documento" id="outro_documento" class="texto03" value="<?= @$obj->_outro_documento; ?>" readonly/>
                        </div>

                        <div>
                            <label>Numero</label>
                            <input type="text"   name="numero_documento" id="numero_documentor" class="texto02" value="<?= @$obj->_numero_documento; ?>" readonly/>
                        </div>


                        <div>
                            <label>Email</label>
                            <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$obj->_cns; ?>" readonly/>
                        </div>
                        <div>
                            <label>Telefone</label>


                            <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" readonly/>
                        </div>
                        <div>
                            <label>Celular *</label>
                            <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" readonly/>
                        </div>
                        <div class="bt_linkm">
                            <a onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . @$obj->_paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                            </a></div>
                </fieldset>
            </div>
            <fieldset>
                <div class="header">
                    <legend>Dados do Paciente</legend>
                </div>
                <div class="body">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label>Nome</label>
                                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                                <input type="hidden" id="txtpaciente" name="txtpaciente"  class="texto09" value="<?= $paciente_id; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="header">
                    <legend>Forma de pagamento</legend>
                </div>

                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Plano</label>
                                <select name="plano" id="plano" class="size2" >
                                    <option value='' >Selecione</option>
                                    <?php
                                    foreach ($planos as $item) {
                                        ?>

                                        <option   value =<?php echo $item->forma_pagamento_id; ?>><?php echo $item->nome; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="pagamento">
                            <!--                    <input required="" type="radio" name="checkboxvalor1" value="01 - "/>1 x <br>
                                                <input required type="radio" name="checkboxvalor1"  value="05 - "/>5 x <br>
                                                <input required type="radio" name="checkboxvalor1"  value="06 - "/>6 x <br>
                                                <input required type="radio" name="checkboxvalor1"  value="10 - "/>10 x <br>-->
                            <input required type="hidden" name="checkboxvalor1"  value="12"/>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label>Data Ades&atilde;o</label>
                                    <input type="text" name="adesao" id="adesao" required class="data" alt="date" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="input-group spinner" data-trigger="spinner">
                                    <label>Dia Vencimento Parcela</label>
                                    <div class="form-line">
                                        <input type="text" name="vencimentoparcela" id="vencimentoparcela" required max="30" min="1" required class="form-control text-center" value="1" data-rule="quantity">
                                    </div>
                                    <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                        </span>
                                </div>
                                <!--                                <div class="form-line">-->
                                <!--                                    -->
                                <!---->
                                <!--                                    <input type="number" name="vencimentoparcela" id="vencimentoparcela" required max="30" min="1" required />-->
                                <!--                                </div>-->
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-7">
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
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="input-group spinner" data-trigger="spinner">
                                    <label>Pular Meses</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control text-center" value="1" data-rule="quantity" name="pularmes" id="pularmes" min="0">
                                    </div>
                                    <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                        </span>
                                </div>
                                <!--                                <div>-->
                                <!---->
                                <!--                                    <input type="number" name="pularmes" id="pularmes" min="0" class="texto02" />-->
                                <!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix" style="padding: 2rem;">
                    <div class="col-sm-2 col-xs-12">
                        <?= botao_salvar(); ?>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
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

    $(function () {
        $("#accordion").accordion();
    });


    $(function () {
        $('#plano').change(function () {
            if ($(this).val()) {
//                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/parcelascontratojson', {plano: $(this).val(), ajax: true}, function (j) {
                    options = '<input required="" type="radio" name="checkboxvalor1" value="01-' + j[0].valor1 + ' "/>1 x  ' + j[0].valor1 + '<br>';
                    options += '<input required type="radio" name="checkboxvalor1"  value="05-' + j[0].valor5 + '  "/>5 x ' + j[0].valor5 + '<br>';
                    options += '<input required type="radio" name="checkboxvalor1"  value="06-' + j[0].valor6 + '  "/>6 x ' + j[0].valor6 + '<br>';
                    options += '<input required type="radio" name="checkboxvalor1"  value="10-' + j[0].valor10 + '  "/>10 x ' + j[0].valor10 + ' <br>';
                    options += '<input required type="radio" name="checkboxvalor1"  value="12-' + j[0].valor12 + '  "/>12 x ' + j[0].valor12 + '<br>';

                    $('#pagamento').html(options).show();
//                    $('.carregando').hide();
                });
            } else {
                options = '';
                $('#pagamento').html(options).show();
            }
        });
    });


</script>
