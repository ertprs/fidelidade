<div class="row clearfix">
    <div class="col-xs-12">
        <div class="card">
            <div class="header"><h3>Cadastro de Parceiro</h3></div>
            <div class="body mascara-input">
                <form name="form_forma" id="form_forma" action="<?= site_url('/cadastros/parceiro/gravar') ?>" method="post">
                    <input type="hidden" name="txtcadastrosparceiroid" value="<?= @$obj->_financeiro_parceiro_id; ?>" />

                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtrazaosocial" class="form-control" value="<?= @$obj->_razao_social; ?>" />
                                    <label class="form-label">Razão social</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtfantasia" class="form-control" value="<?= @$obj->_fantasia; ?>" />
                                    <label class="form-label">Nome Fantasia</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="convenio_id" class="form-control" value="<?= @$obj->_convenio_id; ?>" />
                                    <label class="form-label">ID no Parceiro</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtendereco_ip" class="form-control" value="<?= @$obj->_endereco_ip; ?>" />
                                    <label class="form-label">Endereço Web</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="form-control cnpj" value="<?= @$obj->_cnpj; ?>" />
                                    <label class="form-label">CNPJ</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="txtCPF" maxlength="11" alt="cpf" class="form-control cpf" value="<?= @$obj->_cpf; ?>" />
                                    <label class="form-label">CPF</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <select name="txttipo_id" id="txttipo_id" class="show-tick form-control" data-live-search="true">
                                    <? foreach ($tipo as $value) : ?>
                                        <option value="<?= $value->tipo_logradouro_id; ?>"<?
                                        if (@$obj->_tipo_logradouro_id == $value->tipo_logradouro_id):echo'selected';
                                        endif;
                                        ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtendereco" class="form-control" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                                    <label class="form-label">Endereço</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtNumero" class="form-control" name="numero" value="<?= @$obj->_numero; ?>" />
                                    <label class="form-label">Número</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtBairro" class="form-control" name="bairro" value="<?= @$obj->_bairro; ?>" />
                                    <label class="form-label">Bairro</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtComplemento" class="form-control" name="complemento" value="<?= @$obj->_complemento; ?>" />
                                    <label class="form-label">Complemento</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtTelefone" class="form-control tel-fixo" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                                    <label class="form-label">Telefone</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="txtCelular" class="form-control tel-celular" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                                    <label class="form-label">Celular</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                                    <input type="text" id="txtCidade" class="form-control autocomplete-municipio" name="txtCidade" value="<?= @$obj->_nome; ?>" />
                                    <label class="form-label">Município</label>
                                    <ul id="lista_municipio" class="dropdown-content ac-dropdown"></ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_salvar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_limpar(); ?>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <?= botao_voltar('/cadastros/parceiro'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
