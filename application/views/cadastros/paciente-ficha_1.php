<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravardocumentoscompleto" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome *</label>                      
                
                <?php 
            
                
            if (@$empresa[0]->campos_cadastro != '') {
                $campos_obrigatorios = json_decode(@$empresa[0]->campos_cadastro);
            } else {
                $campos_obrigatorios = array();
            }
             
                if (@$precadastro_id != "") {
                    ?>                 
                    <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$lista[0]->nome; ?>" required/>   
                    <input type ="hidden" name="email" value ="<?= @$lista[0]->email; ?>" id ="email">             
                    <input type ="hidden" name="senha_app"  value ="<?= @$lista[0]->senha_app; ?>" id ="senha_app">             
                    <input type ="hidden" name="whatsapp"  value ="<?= @$lista[0]->whatsapp; ?>" id ="whatsapp">             
                    <input type ="hidden" name="nascimento"  value ="<?= @$lista[0]->nascimento; ?>" id ="nascimento">             
                <?
                }else{
                ?>
                <input type ="hidden" name="paciente_id"  value ="<?= @$obj->_paciente_id; ?>" id ="txtPacienteId">
                
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" <?= (in_array('nome', $campos_obrigatorios)) ? 'required' : '' ?>/>
                <?php }?>
                
            </div>
            <div>
                <?if(count(@$lista) > 0){
                    $nascimento = @$lista[0]->nascimento;
                    $email = @$lista[0]->email;
                }else{
                    $nascimento = @$obj->_nascimento;
                    $email = @$obj->_cns;
                }
                // var_dump($nascimento); die;
                ?>
                
                <label>Nascimento *</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$nascimento, 8, 2) . '/' . substr(@$nascimento, 5, 2) . '/' . substr(@$nascimento, 0, 4); ?>" <?= (in_array('nascimento', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto06" value="<?= @$obj->_nomemae; ?>"  <?= (in_array('nome_mae', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Nome do Pai</label>
                <input type="text"  name="nome_pai" id="txtNomePai" class="texto06" value="<?= @$obj->_nomepai; ?>" <?= (in_array('nome_pai', $campos_obrigatorios)) ? 'required' : '' ?> />
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


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$obj->_complemento; ?>" <?= (in_array('complemento', $campos_obrigatorios)) ? 'required' : '' ?> />
            </div>
            <div>
                <label>Bairro *</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" <?= (in_array('bairro', $campos_obrigatorios)) ? 'required' : '' ?> />
            </div>


            <div>
                <label>Município *</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" <?= (in_array('municipio', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$obj->_cep; ?>" <?= (in_array('cep', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Ocupa&ccedil;&atilde;o</label>
                <input type="hidden" id="txtcboID" class="texto_id" name="txtcboID" value="<?= @$obj->_cbo_ocupacao_id; ?>" readonly="true" />
                <input type="text" id="txtcbo" class="texto04" name="txtcbo" value="<?= @$obj->_cbo_nome; ?>" <?= (in_array('ocupacao', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <label>Rendimentos</label>
                <input type="text" alt="decimal" id="rendimentos" class="texto02" name="rendimentos" value="<?=  number_format(@$obj->_rendimentos, 2, ',', '.'); ?>" <?= (in_array('rendimentos', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>

            <div>
                <label>Indicacao</label>


                <select name="indicacao" id="indicacao" class="size2" <?= (in_array('indicacao', $campos_obrigatorios)) ? 'required' : '' ?> >
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

            <div style="display: none;">
                <label>Situacao</label>
                <select name="situacao" id="situacao" class="size2" required>
                    <option value="Titular" selected="true">Titular</option>
                    <!--<option value="Dependente">Dependente</option>-->
                </select>
            </div>
            <div>
                <label>Plano *</label>
                <select name="plano" id="plano" class="size2" required>
                    <option value="" >selecione</option>
                    <?php
                    $planos = $this->formapagamento->listarforma();
                    foreach ($planos as $item) {
                        ?>
                    <option   value ="<?php echo $item->forma_pagamento_id; ?>"  <? if(@$lista[0]->plano_id == $item->forma_pagamento_id){ echo "selected"; } ?> ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
                
            </div>
            <div>
                <label>Não renovar</label> 
                <input type="checkbox"  name="nao_renovar" id="nao_renovar" <?= (in_array('nao_renovar', $campos_obrigatorios)) ? 'required' : '' ?>>
            </div>
            <div>
                <label>Forma Pagamento </label>
                <select name="forma_rendimento_id" id="forma_rendimento_id" class="size2" <?= (in_array('forma_pagamento', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value="" >Selecione</option>
                    <?php
                    $forma = $this->formapagamento->listarformaRendimentoPaciente();
                    foreach ($forma as $item) {
                        ?>
                        <option   value =<?php echo $item->forma_rendimento_id; ?>><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>



            </div>
            <div>
                <label>Vendedor</label>

                <select name="vendedor" id="vendedor" class="size2" <?= (in_array('vendedor', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value="">Selecione</option>
                    <?php
                    foreach ($listarvendedor as $item) {
                        ?>
                        <option   value =<?php echo $item->operador_id; ?>    ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>

            <div>
                <label>Pessoa Indicação</label>

                <select name="pessoaindicacao" id="pessoaindicacao" class="size2" <?= (in_array('pessoa_indicacao', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value="">Selecione</option>
                    <?php
                    foreach ($listarindicacao as $item) {
                        ?>
                        <option   value =<?php echo $item->operador_id; ?>  <? if(@$lista[0]->vendedor == $item->operador_id){ echo "selected"; } ?>   ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>


            <div>
                <label>Estado civil</label>  
                <select name="estado_civil_id" id="txtEstadoCivil" class="size2" selected="<?= @$obj->_estado_civil; ?>" <?= (in_array('estado_civil', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value="" <?
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
                <select name="parceiro_id" id="parceiro_id" class="size2" <?= (in_array('parceiro', $campos_obrigatorios)) ? 'required' : '' ?>>
                    <option value="">Selecione</option>
                    <? foreach ($parceiros as $item) { ?>
                        <option value="<?= $item->financeiro_parceiro_id ?>"> <?= $item->razao_social ?> </option>
                    <? } ?>
                </select>
            </div>


            <div>
                <label>Cód. Paciente</label>
                <input type="text" id="cod_pac" class="texto02" name="cod_pac" <?= (in_array('cod_paciente', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>

            <div>
                <label>Reativar</label> 
                <input type="checkbox"  name="reativar" id="reativar" <?= (in_array('reativar', $campos_obrigatorios)) ? 'required' : '' ?>>
            </div>


        </fieldset>



        <fieldset>
            <legend>Documentos / Contatos</legend>
            <div>
                <label>CPF/CNPJ</label>
                <? if (strlen(@$obj->_cpf) <= 11) { ?>
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcpf"  value="CPF" checked=""/>CPF
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                <? } elseif (strlen(@$obj->_cpf) > 11) { ?>
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ" checked=""/>CNJP<br>
                <? } else { ?>
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcpf"  value="CPF"/>CPF
                    <input <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?> type="radio" name="seletorcpf" id="seletorcnpj" value="CNPJ"/>CNJP<br>
                <? } ?>

            </div>
            <div>
                <label>&nbsp;</label>
                <input type="checkbox" name="cpf_responsavel" id ="cpf_responsavel" <? if (@$obj->_cpf_responsavel_flag == 't') echo "checked"; ?> > CPF do resposável
            </div>
            <div>               
                <label>CPF/CNPJ</label>   
                <?php 
                if (@$precadastro_id != "") {
                    ?> 
                <input type="text" name="cpf" id ="cpfcnpj" maxlength="18" onblur="verificarCPF()" class="texto03" value="<?= @$lista[0]->cpf; ?>" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?>/>  
                <?php }else{?>
                
                 <input type="text" name="cpf" id ="cpfcnpj" maxlength="18" onblur="verificarCPF()" class="texto03" value="<?= @$obj->_cpf; ?>" <?= (in_array('cpf', $campos_obrigatorios)) ? 'required' : '' ?>/>  
                <?php }?>
            </div>
            <div>
                <label>RG</label>


                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$obj->_documento; ?>"<?= (in_array('rg', $campos_obrigatorios)) ? 'required' : '' ?> />
            </div>
            <div>
                <label>UF Expedidor</label>


                <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" maxlength="20" value="<?= @$obj->_uf_rg; ?>" <?= (in_array('uf_expedido', $campos_obrigatorios)) ? 'required' : '' ?>/>
            </div>
            <div>
                <div>
                    <label>Data Emiss&atilde;o</label>


                    <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr(@$obj->_data_emissao, 8, 2) . '/' . substr(@$obj->_data_emissao, 5, 2) . '/' . substr(@$obj->_data_emissao, 0, 4); ?>" <?= (in_array('data_emissao', $campos_obrigatorios)) ? 'required' : '' ?> />
                </div>

                <div>

                    <label>Outro documento</label> 

                    <input type="text"   name="outro_documento" id="outro_documento" class="texto03" value="<?= @$obj->_outro_documento; ?>"  <?= (in_array('outro_documento', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <div>
                    <label>Numero</label>
                    <input type="text"   name="numero_documento" id="numero_documentor" class="texto02" value="<?= @$obj->_numero_documento; ?>" <?= (in_array('numero_carteira', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div> 
                <div>
                    <label>Email</label>
                    <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$email; ?>"  <?= (in_array('email', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <div>
                    <label>Telefone</label>
 
<?php 
                if (@$precadastro_id != "") {
                    ?> 
                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$lista[0]->telefone; ?>" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'required' : '' ?>/>
                    
                    
                <?php }else{
                    ?>
                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'required' : '' ?>/>
                        
                    <?
                }
?>
                </div>
                <div>
                    <label>Celular *</label>
                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="(99) 99999-9999" value="<?= @$obj->_celular; ?>" <?= (in_array('telefone2', $campos_obrigatorios)) ? 'required' : '' ?>/>
                </div>
                <?php if(@$obj->_paciente_id != ""){?>
                <div class="bt_linkm">
                    <a onclick="javascript:window.open('<?= base_url() . "cadastros/pacientes/anexarimagem/" . @$obj->_paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Arquivos
                    </a></div>
                <?php }?>
        </fieldset>
        
        <fieldset>
                <legend>Forma de pagamento</legend>
                <div class="valores">
                    <input required="" type="radio" name="testec" value=""/>1 x 0.00<br>
                    <input required="" type="radio" name="testec" value=""/>5 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>6 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>10 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>11 x 0.00<br>  
                    <input required="" type="radio" name="testec" value=""/>12 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>23 x 0.00<br> 
                    <input required="" type="radio" name="testec" value=""/>24 x 0.00<br> 
                </div>
                <div>
                    <label>Data Ades&atilde;o</label>
                    <input type="text" name="adesao" id="adesao" required class="texto02" alt="date" required/>
                </div>
                <div>
                    <label>Valor Ades&atilde;o</label>
                    <input type="text" name="valor_adesao" id="valor_adesao"  style="text-align: right;" required class="texto02" alt="decimal" value="0,00"/>
                </div>
                <div>
                    <label>Dia Vencimento Parcela</label>
                    <input type="number" name="vencimentoparcela" id="vencimentoparcela" required max="30" min="1" class="texto02" required />
                </div>
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
                <div>
                    <label>Pular Meses</label>

                    <input type="number" name="pularmes" id="pularmes" min="0" class="texto02" />
                </div>
                  
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
<script type="text/javascript" src="<?= base_url() ?>js/maskedmoney.js"></script>

<input type="hidden" id="mensagem_erro" value="<?= $this->session->userdata('mensagem_erro') ?>"> 


<script type="text/javascript">
     $(function () {
         if($("#mensagem_erro").val() != "" ){
               alert($("#mensagem_erro").val());
         }
         <?  $this->session->set_userdata('mensagem_erro',"") ?>
         $("#mensagem_erro").val("");
     });
   
                        $("#txtDataEmissao").mask("99/99/9999");
                        $("#txtNascimento").mask("99/99/9999");
                        $("#txtCelular").mask("(99) 9?9999-9999");
                        $("#txtTelefone").mask("(99) 9?9999-9999");
                        $("#cep").mask("99999-999");
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

                        function verificarCPF() {
                            // cpfcnpj
                            if ($('#seletorcpf').prop('checked')) {
                                var cpf = $("#cpfcnpj").val();
                                var paciente_id = $("#txtPacienteId").val();
                                if ($('#cpf_responsavel').prop('checked')) {
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
                    $('#plano').change(function () {
                        if ($(this).val()) {
                            $('.carregando').show();
                            $.getJSON('<?= base_url() ?>autocomplete/carregarprecos', {tipo: $(this).val(), ajax: true}, function (j) {
                            console.log(j);
                                var options = '';
                                for (var c = 0; c < j.length; c++) {
                                    //CARREGANDO TODOS OS INPUTS COM OS RESPECTIVOS VALORES DOS SEUS CAMPOS VINDO DO AUTOCOMPLETE
                                    options += ' <input required="" id="checkboxvalor1" type="radio" name="checkboxvalor1" value="01-' + j[0].valor1 + '  "/>1 x ' + j[0].valor1 + ' <br>\n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="05-' + j[0].valor5 + ' "/>5 x ' + j[0].valor5 + '<br>\n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="06-' + j[0].valor6 + ' "/>6 x ' + j[0].valor6 + '<br>   \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="10-' + j[0].valor10 + ' "/>10 x ' + j[0].valor10 + '  <br> \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="11-' + j[0].valor11 + ' "/>11 x ' + j[0].valor11 + ' <br>     \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="12-' + j[0].valor12 + ' "  />12 x ' + j[0].valor12 + '<br>  \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="23-' + j[0].valor23 + ' "  />23 x ' + j[0].valor23 + '<br>   \n\
                                                          <input required id="checkboxvalor1" type="radio" name="checkboxvalor1"  value="24-' + j[0].valor24 + ' "  />24 x ' + j[0].valor24 + '<br>                 ';
                                     
                                      var adesao = parseFloat(j[0].valor_adesao).toLocaleString('pt-br', {minimumFractionDigits: 2});  
                                      $("#valor_adesao").val(adesao);
                                }
                                $('.valores').html(options).show();
                                $('.carregando').hide();
                            });
                        } else {
//                                                    $('#classe').html('<option value="">TODOS</option>');
                        }
                    });
                 });
                 
             
$("#valor_adesao").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

</script>