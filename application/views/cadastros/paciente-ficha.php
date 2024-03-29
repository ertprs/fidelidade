<? if (@$empresa[0]->campos_cadastro != '') {
                $campos_obrigatorios = json_decode(@$empresa[0]->campos_cadastro);
            } else {
                $campos_obrigatorios = array();
            }
            ?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome *</label>                      
                <input type ="hidden" name ="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId" >
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" <?= (in_array('nome', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nascimento *</label>
                <input  type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>" <?= (in_array('nascimento', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>" <?= (in_array('nome_mae', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>" <?= (in_array('nome_pai', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size1" <?= (in_array('sexo', $campos_obrigatorios)) ? 'required' : '' ?>>
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


                <select name="tipo_logradouro" id="txtTipoLogradouro" class="size2" <?= (in_array('tipologradouro', $campos_obrigatorios)) ? 'required' : '' ?>>
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
            <?if(@$obj->_situacao == "Dependente"){?>
                <div>
                    <label>Carregar *</label>
                    <button type="button" onclick="carregarEnderecoTitular();">End. Titular</button>
                </div>
            <?}?>
            <div>
                <label>Endere&ccedil;o *</label>
                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_endereco; ?>" <?= (in_array('endereco', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" <?= (in_array('numero', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Complemento</label>


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>" <?= (in_array('complemento', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Bairro *</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" <?= (in_array('bairro', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>


            <div>
                <label>Município *</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" <?= (in_array('municipio', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" <?= (in_array('cep', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Ocupa&ccedil;&atilde;o</label>
                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" />
                <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" <?= (in_array('ocupacao', $campos_obrigatorios)) ? 'required' : '' ?>/>
                <input type="hidden" id="txtcbohidden" class="texto04" name="txtcbohidden" value="<?= @$obj->_cbo_nome; ?>" />
            </div>

            <?if(@$obj->_situacao != "Dependente"){?>
            <div>
                <label>Rendimentos</label>
                <input type="text" alt="decimal" id="rendimentos" class="texto02" name="rendimentos" value="<?=  number_format(@$obj->_rendimentos, 2, ',', '.'); ?>" <?= (in_array('rendimentos', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <?}?>

            <div>

                <label>Indicacao</label>


                <select name="indicacao" id="indicacao" class="size2" <?= (in_array('indicacao', $campos_obrigatorios)) ? 'required' : '' ?>>
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
                <label>Plano *</label>
                <select name="plano" id="plano" class="size2" >
                    <option value='' >selecione</option>
                    <?php
                    $plano_dependente_id = 0;
                    if(@$obj->_situacao == "Dependente"){
                      $plano_ativo = $this->paciente->listarEnderecoTitular(@$obj->_paciente_id);
                      $plano_dependente_id = $plano_ativo[0]->plano_id;
                    }
                   
                    $planos = $this->formapagamento->listarforma();
                    foreach ($planos as $itens) {
                        ?>
                        <option   value =<?php echo $itens->forma_pagamento_id; ?> <?
                        if (@$obj->_plano_id == $itens->forma_pagamento_id || $plano_dependente_id == $itens->forma_pagamento_id ):echo 'selected';
                        endif;
                        ?>><?php echo $itens->nome; ?></option>

                        <?php
                    }
                    ?> 
                       
                </select>
            </div> 
         
            <div>
                <label>Forma Pagamento </label> 
                <select name="forma_rendimento_id" id="forma_rendimento_id" class="size2" >
                    <option value='' >Selecione</option>
                    <?php
                    $forma = $this->formapagamento->listarformaRendimentoPaciente();
                    foreach ($forma as $itens) {
                        ?>
                        <option   value =<?php echo $itens->forma_rendimento_id; ?> <?
                        if (@$obj->_forma_rendimento_id == $itens->forma_rendimento_id):echo 'selected';
                        endif;
                        ?>><?php echo $itens->nome; ?></option>

                        <?php
                    }
                    ?> 
                </select>
            </div> 

            <div>
                <label>Situacao</label>
                <select name="situacao"> 

                    <option  <?
                    if (@$obj->_situacao == "Titular"): echo "selected";
                    endif;
                    ?> >Titular</option>
                    <option  <?
                    if (@$obj->_situacao == "Dependente"): echo "selected";
                    endif;
                    ?> >Dependente</option>

                </select> 
                <!--<input  name="situacao" id="situacao" class="texto03" readonly value="<?= @$obj->_situacao ?>">-->

            </div>

            <?if(@$obj->_situacao != "Dependente"){?>
            <div>
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
                <?}?>

            <div>
                <label>Estado civil</label>


                <select name="estado_civil_id" id="txtEstadoCivil" class="size2" selected="<?= @$obj->_estado_civil; ?>" <?= (in_array('estado_civil', $campos_obrigatorios)) ? 'required' : '' ?>>
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

            <?if(@$obj->_situacao != "Dependente"){?>
            <div>
                <label>Parceiro</label>

                <? $listarparceiro = $this->paciente->listarparceiros(); ?>
                <select name="financeiro_parceiro_id" id="parceiro_id" class="size2" <?= (in_array('parceiro', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value='' >selecione</option>
                    <?php
                    foreach ($listarparceiro as $item) {
                        ?>

                        <option   value =<?php echo $item->financeiro_parceiro_id; ?> <?
                        if (@$obj->_parceiro_id == $item->financeiro_parceiro_id):echo 'selected';
                        endif;
                        ?>><?php echo $item->fantasia; ?></option>
                                  <?php
                              }
                              ?> 
                </select>
            </div>

            <div>
                <label>Cód. Paciente</label>
                <input type="text" id="cod_pac" class="texto02" value="<?= @$obj->_codigo_paciente ?>" name="cod_pac" <?= (in_array('cod_paciente', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <?}?>

            <div>
                <label>Reativar</label> 
                <input type="checkbox"  name="reativar" id="reativar" <?= (@$obj->_reativar == "t") ? "checked" : ""; ?> <?= (in_array('reativar', $campos_obrigatorios)) ? 'required' : '' ?>>
            </div>
            <?php
            if ($this->session->userdata('operador_id') == '1') {
                ?>
                <div>
                    <label>Credor Devedor</label> 
                    <input type="text"  name="credor_devedor_id" id="credor_devedor_id" value="<?= $obj->_credor_devedor_id; ?>"  >
                </div>
                <?
            }
            ?>
        </fieldset>
        <fieldset>
            <legend>Documentos / Contatos</legend>
            <div>
                <label>CPF/CNPJ</label>
                <? if (strlen(@$obj->_cpf) <= 11) { ?>
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcpf"  value="CPF" checked=""/>CPF
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                <? } elseif (strlen(@$obj->_cpf) > 11) { ?>
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcnpj" value="CNPJ" checked=""/>CNJP<br>
                <? } else { ?>
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                    <input required type="radio" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                <? } ?>
            </div>
            <div>
                <label>&nbsp;</label>
                  <?php
                if (@$obj->_cpfresp == "t" || @$obj->_cpf_responsavel_flag == 't') {
                    ?>
                <input type="checkbox" name="cpfresp" id="cpfresp" checked ="true" />CPF Responsavel
                    <?php
                } else {
                    ?>
                <input type="checkbox" name="cpfresp" id="cpfresp"  />CPF Responsavel
                    <?php
                }
                ?>
            </div>
            <div>
                <label>CPF *</label>
                <input type="text" name="cpf" id ="cpfcnpj" class="texto03" value="<?= @$obj->_cpf; ?>" onblur="verificarCPF()" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?>/>
                <!--<input type="text" name="cpfcnpj" id ="cpfcnpj" class="texto02" value="" />-->
              
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>" <?= (in_array('rg', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>UF Expedidor</label>


                <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>" <?= (in_array('uf_expedido', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <div>
                    <label>Data Emiss&atilde;o</label>


                    <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" <?= (in_array('data_emissao', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>

                <?if(@$obj->_situacao != "Dependente"){?>
                <div>

                    <label>Outro documento</label>


                    <input type="text"   name="outro_documento" id="outro_documento" class="texto03" value="<?= @$obj->_outro_documento; ?>" />
                </div>

                <div>
                    <label>Numero</label>
                    <input type="text"   name="numero_documento" id="numero_documentor" class="texto02" value="<?= @$obj->_numero_documento; ?>" <?= (in_array('numero_carteira', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>


                <div>
                    <label>Email</label>
                    <input type="text" id="txtCns" name="cns"  onchange="validaremail2()" class="texto06" value="<?= @$obj->_cns; ?>" <?= (in_array('email', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <div>
                    <label>Celular *</label>
                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" <?= (in_array('telefone2', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <?}?>
                <div class="bt_linkm">
                    <a onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . @$obj->_paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                    </a></div>
        </fieldset>
        <fieldset>
            <legend>Acesso</legend>
            <div>
                <label>Email</label>

                <input type="text" id="txtUsuario" name="txtUsuario"  class="texto04" onchange="validaremail()" value="<?= @$obj->_cns; ?>" />
            </div>
            <div>
                <label>Senha App</label>
                <input type="password" name="txtSenha" id="txtSenha" class="texto04" value="" />
            </div>

        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>

        <a href="<?= base_url() ?>cadastros/pacientes">
            <button type="button" id="btnVoltar">Voltar</button>
        </a>

    </form>

    <? // var_dump(strlen(@$obj->_cpf)); die;    ?>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/maskedmoney.js"></script>
<script type="text/javascript">
                        $("#txtDataEmissao").mask("99/99/9999");
                        $("#txtNascimento").mask("99/99/9999");
                        $("#txtCelular").mask("(99) 9?9999-9999");
                        $("#txtTelefone").mask("(99) 9?9999-9999");
                        $("#seletorcpf").click(function () {
                            $("#cpfcnpj").mask("999.999.999-99");
                            $("#cpfcnpj").val('');
                        });
                        $("#seletorcnpj").click(function () {
                            $("#cpfcnpj").mask("99.999.999/9999-99");
                        });

                        $('#rendimentos').maskMoney({ decimal: ',', thousands: '.', precision: 2 });
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

                        function validaremail(){
                            var email = $("#txtUsuario").val();
                            if(email != ''){
                                $.getJSON('<?= base_url() ?>autocomplete/verificaremailpaciente', {email: email,  ajax: true}, function (j) {
                                    if(j != ''){
                                        alert(j);
                                        $("#txtUsuario").val('');
                                        $("#txtCns").val('');
                                    }
                                });
                            }
                        }

                        function validaremail2(){
                            var email = $("#txtCns").val();
                            if(email != ''){
                                $.getJSON('<?= base_url() ?>autocomplete/verificaremailpaciente', {email: email,  ajax: true}, function (j) {
                                    if(j != ''){
                                        alert(j);
                                        $("#txtUsuario").val('');
                                        $("#txtCns").val('');
                                    }
                                });
                            }
                        }

                        function verificarCPF() {
                            // cpfcnpj
                            if ($('#seletorcpf').prop('checked')) {
                                var cpf = $("#cpfcnpj").val();
                                var paciente_id = $("#txtPacienteId").val();
                                if ($('#cpfresp').prop('checked')) {
                                    var cpf_responsavel = 'on';
                                } else {
                                    var cpf_responsavel = '';
                                }

                                $.getJSON('<?= base_url() ?>autocomplete/verificarcpfpaciente', {cpf: cpf, cpf_responsavel: cpf_responsavel, paciente_id: paciente_id, ajax: true}, function (j) {
                                    if (j != '') {
                                        alert(j);
                                        $("#cpfcnpj").val('');
                                    }
                                });
                            }


                        }

                        function carregarEnderecoTitular() {
                            // cpfcnpj
                            var paciente_id = $("#txtPacienteId").val();
                            $.getJSON('<?= base_url() ?>autocomplete/carregarEnderecoTitular', {paciente_id: paciente_id, ajax: true}, function (j) {
                                if(j.length > 0){
                                    $("#txtendereco").val(j[0].logradouro);
                                    $("#txtNumero").val(j[0].numero);
                                    $("#cep").val(j[0].cep);
                                    $("#txtComplemento").val(j[0].complemento);
                                    $("#txtBairro").val(j[0].bairro);
                                    $("#txtCidade").val(j[0].cidade_desc);
                                    $("#txtCidadeID").val(j[0].municipio_id);
                                }
                            });
                        }



</script>
