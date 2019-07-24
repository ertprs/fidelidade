<?
// echo "<pre>";
// print_r($empresa);
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
                        <input type="hidden" name="txtempresaid" class="texto10" value="<?= @$empresa[0]->empresa_id; ?>" />
                        <input type="hidden" name="empresacadastro" class="texto10" value="sim" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$empresa[0]->nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$empresa[0]->razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" name="email" id="email" class="texto10" value="<?= @$empresa[0]->email; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$empresa[0]->cnpj; ?>" />
                    </dd>
<!--                    <dt>
                        <label>CNES</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNES" maxlength="14" class="texto03" value="<?= @$empresa[0]->cnes; ?>" />
                    </dd>-->
<!--                    <dt>
                        <label>Código Convênio (Banco)</label>
                    </dt>
                    <dd>
                        <input type="text" name="codigo_convenio_banco" maxlength="6" class="texto03" value="<?= @$empresa[0]->codigo_convenio_banco; ?>" />
                    </dd>-->
                    <dt>
                        <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$empresa[0]->logradouro; ?>" />
                    </dd>
                    <dt>
                        <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$empresa[0]->numero; ?>" />
                    </dd>
                    <dt>
                        <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$empresa[0]->bairro; ?>" />
                    </dd>
                    <dt>
                        <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCEP" class="texto02" name="CEP" alt="cep" value="<?= @$empresa[0]->cep; ?>" />
                    </dd>
                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" alt="phone" value="<?= @$empresa[0]->telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto03" name="celular" alt="phone" value="<?= @$empresa[0]->celular; ?>" />
                    </dd>
                    <dt>
                        <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$empresa[0]->municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$empresa[0]->municipio; ?>" />
                    </dd>
<!--                    <dt>
                        <label>API Token IUGU</label>
                    </dt>
                    <dd>
                        <input type="text" id="iugu_token" class="texto07" name="iugu_token" value="<?= @$empresa[0]->iugu_token; ?>" />
                    </dd>-->
                    <dt>
                        <label>Modelo Carteira</label>
                    </dt>
                    <dd>
                        <input type="text" id="modelo_carteira" class="texto07" name="modelo_carteira" value="<?= @$empresa[0]->modelo_carteira; ?>" />
                    </dd>

<!--                    <dt>
                        <label>Banco</label>
                    </dt>
                    <dd>
                        <textarea name="banco" rows="1" cols="50"><?= @$empresa[0]->banco; ?></textarea>
                    </dd>-->
                    <?
                    $operador = $this->session->userdata('operador_id');
                    if ($operador == 1) {
                        ?>
<!--                        <dt>
                            <label>Cadastro</label>
                        </dt>-->
<!--                        <dd>
                            <select name="cadastro" id="cadastro" class="size2" selected="<?= @$empresa[0]->cadastro; ?>">
                                <option value=0 <?
                                if (@$empresa[0]->cadastro == 0):echo 'selected';
                                endif;
                                ?>>Normal</option>
                                <option value=1 <?
                                if (@$empresa[0]->cadastro == 1):echo 'selected';
                                endif;
                                ?>>Alternativo</option>

                            </select>
                        </dd>-->
<!--                        <dt>
                            <label>Tipo de Carência</label>
                        </dt>
                        <dd>
                            <select name="tipo_carencia" id="tipo_carencia" class="size2" selected="<?= @$empresa[0]->tipo_carencia; ?>">
                                <option value="SOUDEZ" <?
                                if (@$empresa[0]->tipo_carencia == "SOUDEZ"):echo 'selected';
                                endif;
                                ?>>Sou Dez</option>
                                <option value="NORMAL" <?
                                if (@$empresa[0]->tipo_carencia == "NORMAL"):echo 'selected';
                                endif;
                                ?>>Normal</option>

                            </select>
                        </dd>-->
                    <? }
                    ?>

                </dl>  
                <br>
                <br>
                <br>
                <table> 
<!--                    <tr>
                        <td><input type="checkbox" name="cadastro_empresa_flag"   <? if (@$empresa[0]->cadastro_empresa_flag == 't') echo "checked"; ?>> 
                            <label  title=" " >Cadastro De Empresa</label>   </td> 
                    </tr> -->
                </table> 
                <br>
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