<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Parceiro</a></h3>

        <div>
            <form name="form_parceiro" id="form_parceiro" action="<?= base_url() ?>cadastros/parceiro/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosparceiroid" class="texto10" value="<?= @$obj->_financeiro_parceiro_id; ?>" />
                        <input type="text" name="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                    <label>Nome Fantasia</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtfantasia" class="texto10" value="<?= @$obj->_fantasia; ?>" />
                    </dd>
                    <dt>
                    <label>ID no Parceiro</label>
                    </dt>
                    <dd>
                        <input type="number" name="convenio_id" class="texto10" value="<?= @$obj->_convenio_id; ?>" />
                    </dd>
                    <dt>
                        <label title="(DDNS OU IP FIXO)">Endereço Web </label>
                    </dt>
                    <dd>
                        <input type="text" name="txtendereco_ip" class="texto10" value="<?= @$obj->_endereco_ip; ?>" />
                    </dd>
                    <dt>
                    <label>ID no Parceiro (Med)</label>
                    </dt>
                    <dd>
                        <input type="number" name="parceriaMed_id" class="texto10" value="<?= @$obj->_parceriamed_id; ?>" />
                    </dd>
                    <dt>
                        <label title="(DDNS OU IP FIXO)">Endereço Web (Med)</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtenderecoMed_ip" class="texto10" value="<?= @$obj->_enderecomed_ip; ?>" />
                    </dd>
                    <dt>
                    <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>
                    <dt>
                    <label>CPF</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCPF" maxlength="11" alt="cpf" class="texto03" value="<?= @$obj->_cpf; ?>" />
                    </dd>
                    <dt>
                    <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="txttipo_id" id="txttipo_id" class="size4">
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->tipo_logradouro_id; ?>"<?
                                if (@$obj->_tipo_logradouro_id == $value->tipo_logradouro_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
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
                    <label>Complemento</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtComplemento" class="texto10" name="complemento" value="<?= @$obj->_complemento; ?>" />
                    </dd>
                    <dt>
                    <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                    <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>
                    <dt>
                    <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    
                    <dt>
                    <label>Usuário</label>
                    </dt>
                    <dd>                      
                        <input type="text" id="txtCidade" class="texto04" name="usuario" value="<?= @$obj->_usuario; ?>" />
                    </dd>
                    <dt>
                    <label>Senha</label>
                    </dt>
                    <dd>                      
                        <input type="password" id="senhaparce" class="texto04" name="senha" value="" />
                    </dd>
                   
                </dl>    
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
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>cadastros/parceiro');
    });
    $(function() {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });


    $(function() {
        $("#accordion").accordion();
    });

    $(document).ready(function() {
        jQuery('#form_parceiro').validate({
            rules: {
                txtrazaosocial: {
                    required: true,
                    minlength: 3
                },
                endereco: {
                    required: true
                },
                cep: {
                    required: true
                },
                cns: {
                    maxLength: 15
                }, rg: {
                    maxLength: 20
                }

            },
            messages: {
                txtrazaosocial: {
                    required: "*",
                    minlength: "*"
                },
                endereco: {
                    required: "*"
                },
                cep: {
                    required: "*"
                },
                cns: {
                    required: "Tamanho m&acute;ximo do campo CNS é de 15 caracteres"
                },
                rg: {
                    maxlength: "Tamanho m&acute;ximo do campo RG é de 20 caracteres"
                }
            }
        });
    });

</script>