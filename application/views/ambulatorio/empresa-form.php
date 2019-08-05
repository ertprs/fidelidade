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
                        <label>Modelo Carteira</label>
                    </dt>
                    <dd>
                        <input type="text" id="modelo_carteira" class="texto07" name="modelo_carteira" value="<?= @$obj->_modelo_carteira; ?>" />
                    </dd>

                    <dt>
                        <label>Banco</label>
                    </dt>
                    <dd>
                        <textarea name="banco" rows="1" cols="50"><?= @$obj->_banco; ?></textarea>
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

                            </select>
                        </dd>
                    <? }
                    ?>

                </dl>  
                <br>
                <br>
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
                        <td>
                            <input type="checkbox" name="modificar_verificar"   <? if (@$obj->_modificar_verificar == 't') echo "checked"; ?>> 
                            <label  title="Ao ativar essa flag, a tela de verificar vai necessitar de senha do parceiro que irá poder" >Modificar Verificar</label>  
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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
