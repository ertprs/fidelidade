<?
// echo "<pre>";
// print_r($obj);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sala</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>ambulatorio/empresa/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtempresaid" class="texto10" value="<?= @$obj->_empresa_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" name="email" id="email" class="texto10" value="<?= @$obj->_email; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>
                    <dt>
                        <label>CNES</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNES" maxlength="14" class="texto03" value="<?= @$obj->_cnes; ?>" />
                    </dd>
                    <dt>
                        <label>Código Convênio (Banco)</label>
                    </dt>
                    <dd>
                        <input type="text" name="codigo_convenio_banco" maxlength="6" class="texto03" value="<?= @$obj->_codigo_convenio_banco; ?>" />
                    </dd>
                    <dt>
                        <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                    </dd>
                    <dt>
                        <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                    </dd>

                    <dt>
                        <label>Complemento</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtComplemento" class="texto02" name="complemento" value="<?= @$obj->_complemento; ?>" />
                    </dd>

                    <dt>
                        <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                    </dd>
                    <dt>
                        <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCEP" class="texto02" name="CEP" alt="cep" value="<?= @$obj->_cep; ?>" />
                    </dd>
                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto03" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>
                    <dt>
                        <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_municipio; ?>" />
                    </dd>
                    <dt>
                        <label>API Token IUGU</label>
                    </dt>
                    <dd>
                        <input type="text" id="iugu_token" class="texto07" name="iugu_token" value="<?= @$obj->_iugu_token; ?>" />
                    </dd>
                    <dt>
                        <label>Client ID Gerencianet</label>
                    </dt>
                    <dd>
                        <input type="text" id="client_id" class="texto07" name="client_id" value="<?= @$obj->_client_id; ?>" />
                    </dd>
                    <dt>
                        <label>Client Secret Gerencianet</label>
                    </dt>
                    <dd>
                        <input type="text" id="client_secret" class="texto07" name="client_secret" value="<?= @$obj->_client_secret; ?>" />
                    </dd>
                    <dt>
                        <label>E-Pharma (Usuário)</label>
                    </dt>
                    <dd>
                        <input type="text" id="usuario_epharma" class="texto07" name="usuario_epharma" value="<?= @$obj->_usuario_epharma; ?>" />
                    </dd>
                    <dt>
                        <label>E-Pharma (Senha)</label>
                    </dt>
                    <dd>
                        <input type="text" id="senha_epharma" class="texto07" name="senha_epharma" value="<?= @$obj->_senha_epharma; ?>" />
                    </dd>
                    <dt>
                        <label>E-Pharma (URL)</label>
                    </dt>
                    <dd>
                        <input type="text" id="url_epharma" class="texto07" name="url_epharma" value="<?= @$obj->_url_epharma; ?>" />
                    </dd>
                    <dt>
                        <label>E-Pharma (Código Plano)</label>
                    </dt>
                  
                    <dd>
                        <input type="text" id="codigo_plano" class="texto07" name="codigo_plano" value="<?= @$obj->_codigo_plano; ?>" />
                    </dd>
                    
                    <dt>
                        <label>Agência (sem o digito verificador)</label>
                    </dt> 
                    <dd>
                        <input type="text" id="agenciaSicoob" name="agenciaSicoob" value="<?= @$obj->_agenciasicoob; ?>">
                    </dd>
                     <dt>
                        <label>Conta Corrente</label>
                    </dt> 
                    <dd>
                        <input type="number" id="contacorrenteSicoob" name="contacorrenteSicoob" value="<?= @$obj->_contacorrentesicoob; ?>">
                    </dd>
                      <dt>
                        <label>Código do Beneficiário</label>
                    </dt> 
                    <dd>
                        <input type="number" id="codigobeneficiarioSicoob" name="codigobeneficiarioSicoob" value="<?= @$obj->_codigobeneficiariosicoob; ?>">
                    </dd>
                     
                    <dt>
                        <label>Modelo Carteira</label>
                    </dt>
                    <dd>
                        <input type="text" id="modelo_carteira" class="texto07" name="modelo_carteira" value="<?= @$obj->_modelo_carteira; ?>" />
                    </dd>

                    <!-- <dt>
                        <label>Modelo Carteira</label>
                    </dt>
                    <dd>
                        <input type="text" id="modelo_carteira" class="texto07" name="modelo_carteira" value="<?= @$obj->_modelo_carteira; ?>" />
                    </dd> -->

                    <dt>
                        <label>Banco</label>
                    </dt>
                    <dd>
                        <textarea name="banco" rows="1" cols="50"><?= @$obj->_banco; ?></textarea>
                    </dd>
                    <dt>
                        <label>API Agenda Google</label>
                    </dt>
                    <dd>
                        <input type="text" name="api_google" class="texto10" value='<?= @$obj->_api_google; ?>' />
                    </dd>
                    <dt>
                        <label>Titular ao cadastrar na integração</label>
                    </dt>
                    <dd>
                        <input type="checkbox" id="titular_flag" name="titular_flag" <? if (@$obj->_titular_flag == 't') echo "checked"; ?>/>
                    </dd>
                    <?
                    $operador = $this->session->userdata('operador_id');
                    if ($operador == 1) {
                        ?>
                        <dt>
                            <label>Cadastro</label>
                        </dt>
                        <dd>
                            <select name="cadastro" id="cadastro" class="size2" selected="<?= @$obj->_cadastro; ?>">
                                <option value=0 <?
                                if (@$obj->_cadastro == 0):echo 'selected';
                                endif;
                                ?>>Normal</option>
                                <option value=1 <?
                                if (@$obj->_cadastro == 1):echo 'selected';
                                endif;
                                ?>>Alternativo</option>
                                <option value=2 <?
                                if (@$obj->_cadastro == 2):echo 'selected';
                                endif;
                                ?>>Completo</option>
                                <option value=3 <?
                                if (@$obj->_cadastro == 3):echo 'selected';
                                endif;
                                ?>>Completo 2</option>
                            </select>
                        </dd>
                        <dt>
                            <label>Tipo de Carência</label>
                        </dt>
                        <dd>
                            <select name="tipo_carencia" id="tipo_carencia" class="size2" selected="<?= @$obj->_tipo_carencia; ?>">
                                <option value="SOUDEZ" <?
                                if (@$obj->_tipo_carencia == "SOUDEZ"):echo 'selected';
                                endif;
                                ?>>Sou Dez</option>
                                <option value="NORMAL" <?
                                if (@$obj->_tipo_carencia == "NORMAL"):echo 'selected';
                                endif;
                                ?>>Normal</option> 
                                 <option value="ESPECIFICA" <?
                                if (@$obj->_tipo_carencia == "ESPECIFICA"):echo 'selected';
                                endif;
                                ?>>Específica </option> 
                            </select>
                        </dd> 
                        <dt>
                            <label>Modelo de Declaração</label>
                        </dt>
                        <dd>
                            <select name="tipo_declaracao" id="tipo_declaracao" class="size2" selected="<?= @$obj->_tipo_declaracao; ?>">
                                <option value="1" <?
                                if (@$obj->_tipo_declaracao == "1"):echo 'selected';
                                endif;
                                ?>>Declaração Padrão</option>
                                <option value="2" <?
                                if (@$obj->_tipo_declaracao == "2"):echo 'selected';
                                endif;
                                ?>>Declaração 2</option>

                            </select>
                        </dd>
                    <? }
                    ?>

                </dl>  
                <div><br><br>
                    <dt>
                        <label title="Definir os botões no app">Botões do APP</label>
                    </dt>
                    <dd>
                        <?
                        if (@$obj->_botoes_app != '') {
                            $botoes_app = json_decode(@$obj->_botoes_app);
                        } else {
                            $botoes_app = array();
                        }
                        ?>
                        <select name="botoes_app[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>

                            <option value="p_hexames" <?= (in_array('p_hexames', $botoes_app)) ? 'selected' : ''; ?>>Histórico Exame</option>
                            <option value="p_hconsulta" <?= (in_array('p_hconsulta', $botoes_app)) ? 'selected' : ''; ?>>Histórico Consulta</option>
                            <option value="p_marcar_consulta" <?= (in_array('p_marcar_consulta', $botoes_app)) ? 'selected' : ''; ?>>Marcar Consulta</option>
                            <option value="p_risco_cirurgico" <?= (in_array('p_risco_cirurgico', $botoes_app)) ? 'selected' : ''; ?>>Risco Cirurgico</option>
                            <option value="p_carterinha_virtual" <?= (in_array('p_carterinha_virtual', $botoes_app)) ? 'selected' : ''; ?>>Carterinha Virtual</option>
                            <option value="p_mensalidades" <?= (in_array('p_mensalidades', $botoes_app)) ? 'selected' : ''; ?>>Mensalidades</option>
                            <option value="p_dicas_saude" <?= (in_array('p_dicas_saude', $botoes_app)) ? 'selected' : ''; ?>>Informativos</option>
                            <option value="p_como_chegar" <?= (in_array('p_como_chegar', $botoes_app)) ? 'selected' : ''; ?>>Como chegar</option>
                            <option value="p_convenios" <?= (in_array('p_convenios', $botoes_app)) ? 'selected' : ''; ?>>Convênios</option>
                            <option value="p_atendimento" <?= (in_array('p_atendimento', $botoes_app)) ? 'selected' : ''; ?>>Atendimento</option>
                            <option value="p_pesquisa_de_satisfacao" <?= (in_array('p_pesquisa_de_satisfacao', $botoes_app)) ? 'selected' : ''; ?>>Pesquisa de satisfação</option>
                            <option value="p_solicitar_consulta" <?= (in_array('p_solicitar_consulta', $botoes_app)) ? 'selected' : ''; ?>>Solicitar Consulta</option>
                            <option value="p_contato" <?= (in_array('p_contato', $botoes_app)) ? 'selected' : ''; ?>>Contato</option>
                            <option value="p_rede_credenciada" <?= (in_array('p_rede_credenciada', $botoes_app)) ? 'selected' : ''; ?>>Rede Credenciada</option>
                            <option value="p_rede_parceria" <?= (in_array('p_rede_parceria', $botoes_app)) ? 'selected' : ''; ?>>Rede Parceria</option>
                            
                        </select>
                    </dd>
                </div>
                   <br>
                <br>
                <div>
                    <dt>
                        <label title="Definir os campos que serao obrigatorios no cadastro de paciente.">Campos Obrigatorios Titular</label>
                    </dt>
                    <dd>
                        <?
                        if (@$obj->_campos_cadastro != '') {
                            $campos_obrigatorios = json_decode(@$obj->_campos_cadastro);
                        } else {
                            $campos_obrigatorios = array();
                        }
                        ?>
                        <select name="campos_obrigatorio[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                             <option value="nome" <?= (in_array('nome', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome</option> 
                            <option value="nascimento" <?= (in_array('nascimento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nascimento</option>
                            <option value="nome_mae" <?= (in_array('nome_mae', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome da Mãe</option>
                            <option value="nome_pai" <?= (in_array('nome_pai', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome do Pai</option>                          
                            <option value="email" <?= (in_array('email', $campos_obrigatorios)) ? 'selected' : ''; ?>>Email</option>
                            <option value="sexo" <?= (in_array('sexo', $campos_obrigatorios)) ? 'selected' : ''; ?>>Sexo</option>
                            <option value="tipologradouro" <?= (in_array('tipologradouro', $campos_obrigatorios)) ? 'selected' : ''; ?>>T. logradouro</option>
                            <option value="cpf" <?= (in_array('cpf', $campos_obrigatorios)) ? 'selected' : ''; ?>>CPF</option>
                            <option value="rg" <?= (in_array('rg', $campos_obrigatorios)) ? 'selected' : ''; ?>>RG</option>                          
                            <option value="endereco" <?= (in_array('endereco', $campos_obrigatorios)) ? 'selected' : ''; ?>>Endereço</option>
                            <option value="numero" <?= (in_array('numero', $campos_obrigatorios)) ? 'selected' : ''; ?>>Número</option>
                            <option value="complemento" <?= (in_array('complemento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Complemento</option>
                            <option value="indicacao" <?= (in_array('indicacao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Indicacao</option>
                            <option value="bairro" <?= (in_array('bairro', $campos_obrigatorios)) ? 'selected' : ''; ?>>Bairro</option>
                            <option value="municipio" <?= (in_array('municipio', $campos_obrigatorios)) ? 'selected' : ''; ?>>Município</option>
                            <option value="cep" <?= (in_array('cep', $campos_obrigatorios)) ? 'selected' : ''; ?>>CEP</option>
                            <option value="telefone1" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'selected' : ''; ?>>Telefone 1</option>
                            <option value="telefone2" <?= (in_array('telefone2', $campos_obrigatorios)) ? 'selected' : ''; ?>>Celular</option>                                                     
                            <option value="numero_carteira" <?= (in_array('numero_carteira', $campos_obrigatorios)) ? 'selected' : ''; ?>>Número Carteira</option>                          
                            <option value="ocupacao" <?= (in_array('ocupacao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Ocupação</option>                                                     
                            <option value="estado_civil" <?= (in_array('estado_civil', $campos_obrigatorios)) ? 'selected' : ''; ?>>Estado civil</option>
                            <option value="rendimentos" <?= (in_array('rendimentos', $campos_obrigatorios)) ? 'selected' : ''; ?>>Rendimentos</option>
                            <option value="forma_pagamento" <?= (in_array('forma_pagamento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Forma de pagamento</option>
                            <option value="vendedor" <?= (in_array('vendedor', $campos_obrigatorios)) ? 'selected' : ''; ?>>vendedor</option>
                            <option value="pessoa_indicacao" <?= (in_array('pessoa_indicacao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Pessoa indicação</option>
                            <option value="parceiro" <?= (in_array('parceiro', $campos_obrigatorios)) ? 'selected' : ''; ?>>Parceiro</option>
                            <option value="cod_paciente" <?= (in_array('cod_paciente', $campos_obrigatorios)) ? 'selected' : ''; ?>>Cód. Paciente</option>
                            <option value="reativar" <?= (in_array('reativar', $campos_obrigatorios)) ? 'selected' : ''; ?>>reativar</option>
                            <option value="nao_renovar" <?= (in_array('nao_renovar', $campos_obrigatorios)) ? 'selected' : ''; ?>>não renovar</option>
                            <option value="uf_expedido" <?= (in_array('uf_expedido', $campos_obrigatorios)) ? 'selected' : ''; ?>>UF Expedido</option>
                            <option value="data_emissao" <?= (in_array('data_emissao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Data Emissão</option>
                            <option value="outro_documento" <?= (in_array('outro_documento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Outro documento</option>
                            
                           

                        </select>
                    </dd>
                </div>
                
                <br>
               
                 <div>
                    <dt>
                        <label title="Definir os campos que serao obrigatorios no cadastro de paciente.">Campos Obrigatorios Dependente</label>
                    </dt>
                    <dd>
                        <?
                        if (@$obj->_campos_cadastro_dependente != '') {
                            $campos_obrigatorios_dependente = json_decode(@$obj->_campos_cadastro_dependente);
                        } else {
                            $campos_obrigatorios_dependente = array();
                        }
                         
                        ?>
                        <select name="campos_obrigatorio_dependente[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                            <option value="nome" <?= (in_array('nome', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Nome</option> 
                            <option value="nascimento" <?= (in_array('nascimento', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Nascimento</option>
                            <option value="nome_mae" <?= (in_array('nome_mae', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Nome da Mãe</option>
                            <option value="nome_pai" <?= (in_array('nome_pai', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Nome do Pai</option>                          
                            <option value="email" <?= (in_array('email', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Email</option>
                            <option value="sexo" <?= (in_array('sexo', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Sexo</option>
                            <option value="tipologradouro" <?= (in_array('tipologradouro', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>T. logradouro</option>
                            <option value="cpf" <?= (in_array('cpf', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>CPF</option>
                            <option value="rg" <?= (in_array('rg', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>RG</option>                          
                            <option value="endereco" <?= (in_array('endereco', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Endereço</option>
                            <option value="numero" <?= (in_array('numero', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Número</option>
                            <option value="complemento" <?= (in_array('complemento', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Complemento</option>
                            <option value="indicacao" <?= (in_array('indicacao', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Indicacao</option>
                            <option value="bairro" <?= (in_array('bairro', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Bairro</option>
                            <option value="municipio" <?= (in_array('municipio', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Município</option>
                            <option value="cep" <?= (in_array('cep', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>CEP</option>
                            <option value="telefone1" <?= (in_array('telefone1', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Telefone 1</option>
                            <option value="telefone2" <?= (in_array('telefone2', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Celular</option>                                                                       
                            <option value="numero_carteira" <?= (in_array('numero_carteira', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Número Carteira</option>                          
                            <option value="ocupacao" <?= (in_array('ocupacao', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Ocupação</option>                                                     
                            <option value="estado_civil" <?= (in_array('estado_civil', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Estado civil</option>                
                            <option value="grau_parentesco" <?= (in_array('grau_parentesco', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Grau de parentesco</option>           
                            <option value="forma_pagamento" <?= (in_array('forma_pagamento', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Forma de pagamento</option>
                            <option value="vendedor" <?= (in_array('vendedor', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>vendedor</option>
                            <option value="pessoa_indicacao" <?= (in_array('pessoa_indicacao', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Pessoa indicação</option>
                            <option value="parceiro" <?= (in_array('parceiro', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Parceiro</option>
                            <option value="cod_paciente" <?= (in_array('cod_paciente', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Cód. Paciente</option>
                            <option value="reativar" <?= (in_array('reativar', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>reativar</option>                          
                            <option value="uf_expedido" <?= (in_array('uf_expedido', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>UF Expedido</option>
                            <option value="data_emissao" <?= (in_array('data_emissao', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Data Emissão</option>
                            <option value="outro_documento" <?= (in_array('outro_documento', $campos_obrigatorios_dependente)) ? 'selected' : ''; ?>>Outro documento</option>                      
                        </select>
                    </dd>
                </div>
                <br>
                <table>
                    <tr>
                        <td><input type="checkbox" name="alterar_contrato"   <? if (@$obj->_alterar_contrato == 't') echo "checked"; ?>> 
                            <label  title="Ativando essa flag, possibilita alterar o número do contrato." >Alterar contrato</label></td>
                        <td><input type="checkbox" name="confirm_outra_data"   <? if (@$obj->_confirm_outra_data == 't') echo "checked"; ?>> 
                            <label  title="Ativando essa flag, possibilita alterar a Data e a Conta." >Confirmar para outra data</label></td>
                        <td><input type="checkbox" name="financeiro_maior_zero"   <? if (@$obj->_financeiro_maior_zero == 't') echo "checked"; ?>> 
                            <label  title=" " >Financeiro maior que Zero</label>  </td>

                        <td><input type="checkbox" name="carteira_padao_1"   <? if (@$obj->_carteira_padao_1 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 1</label>  </td>
                        <td><input type="checkbox" name="carteira_padao_2"   <? if (@$obj->_carteira_padao_2 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 2</label>   </td>
                    </tr> 

                    <tr>
                        <td><input type="checkbox" name="cadastro_empresa_flag"   <? if (@$obj->_cadastro_empresa_flag == 't') echo "checked"; ?>> 
                            <label  title=" " >Cadastro De Empresa</label>   </td>
                        <td><input type="checkbox" name="excluir_entrada_saida"   <? if (@$obj->_excluir_entrada_saida == 't') echo "checked"; ?>> 
                            <label  title="Ativando essa flag, além do ADM TOTAL, outros Usuários poderam excluir uma Entrada ou uma Saída" >Liberar Excluir (Entrada/Saída)</label>   </td>
                        <td><input type="checkbox" name="renovar_contrato_automatico"   <? if (@$obj->_renovar_contrato_automatico == 't') echo "checked"; ?>> 
                            <label  title="Ativando essa flag, o contrato irá ser renovado ao entrar no Sistema. " >Renovar Contrato Automático</label>   </td>
                        <td><input type="checkbox" name="carteira_padao_3"   <? if (@$obj->_carteira_padao_3 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 3</label>   </td>
                        <td><input type="checkbox" name="carteira_padao_4"   <? if (@$obj->_carteira_padao_4 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 4</label>   </td>
                    </tr>
                     <tr>
                        <td><input type="checkbox" name="carteira_padao_5"   <? if (@$obj->_carteira_padao_5 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 5</label>  
                        </td> 
                        <td><input type="checkbox" name="carteira_padao_6"   <? if (@$obj->_carteira_padao_6 == 't') echo "checked"; ?>> 
                            <label  title=" " >Carteira Padrão 6</label>  
                        </td> 
                        <td>
                            <input type="checkbox" name="modificar_verificar"   <? if (@$obj->_modificar_verificar == 't') echo "checked"; ?>> 
                            <label  title="Ao ativar essa flag, a tela de verificar vai necessitar de senha do parceiro que irá poder" >Modificar Verificar</label>  
                        </td> 
                         <td>
                            <input type="checkbox" name="forma_dependente"   <? if (@$obj->_forma_dependente == 't') echo "checked"; ?>> 
                            <label  title="Ao ativar essa flag no cadastro do dependente irá aparecer a forma de pagamento" >F. Pagamento Dependente</label>  
                        </td>
                        <!-- <td>
                            <input type="checkbox" name="relacao_carencia"   <? if (@$obj->_relacao_carencia == 't') echo "checked"; ?>> 
                            <label>Situação de pagamento em relação a carência</label>  
                        </td>  -->

                        <td>
                            <input type="checkbox" name="contratos_inativos"   <? if (@$obj->_contratos_inativos == 't') echo "checked"; ?>> 
                            <label>Contratos Inativos</label>  
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox" name="agenda_google"   <? if (@$obj->_agenda_google == 't') echo "checked"; ?>> 
                            <label>Agenda Google</label>  
                        </td>
                        <td>
                            <input type="checkbox" name="conta_pagamento_associado"   <? if (@$obj->_conta_pagamento_associado == 't') echo "checked"; ?>> 
                            <label>Forma de Pagamento Associado a Conta</label>  
                        </td>
                    </tr>
                </table> 
                <br>
                
                <a title="Ao clicar nesse link, irá abrir uma tela branca isso significa que todos os pacientes serão exportados para o sistema clinica,exceto os que já estão cadastrados lá.(Verifica pelo CPF e Prontuário)" href="<?= base_url() ?>cadastros/pacientes/gravartodospacientesexterno" target="_blank">Gravar todos parceiros</a>
                
                <hr/>

                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
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

    $(document).ready(function () {
        jQuery('#form_empresa').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>
