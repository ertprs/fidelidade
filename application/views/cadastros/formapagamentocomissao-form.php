<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Comissão</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravarFormaRendimentoComissao/<?= @$obj->_forma_pagamento_id; ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Plano</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="plano_id" class="texto10" value="<?= @$obj->_forma_pagamento_id; ?>" />
                        <input readonly type="text" name="plano" class="texto03" value="<?= @$obj->_nome; ?>" />
                       
                    </dd>
                    <br>
                    <fieldset>
                        <dt>
                            <label>Forma Pagamento</label>
                        </dt>
                        <dd>
                            <select name="forma_rendimento_id" id="forma_rendimento_id" class="size2" required>
                                <option value='' >Selecione</option>
                                <?php
                                $forma = $this->formapagamento->listarformaRendimentoPaciente();
                                foreach ($forma as $itens) {
                                    ?>
                                    <option value =<?php echo $itens->forma_rendimento_id; ?>><?php echo $itens->nome; ?></option>

                                    <?php
                                }
                                ?> 
                            </select>
                            
                        </dd>
                        <br>
                        <dt>
                            <label>De: </label>
                        </dt>
                        <dd>
                            <input type="number" name="inicio_parcelas" min=0 class="texto01" required/>
                            
                        </dd>
                        <dt>
                            <label>Até (zero para infinito): </label>
                        </dt>
                        <dd>
                            <input type="number" name="fim_parcelas" min=0 class="texto01" />
                            
                        </dd>
                        <dt>
                            <label>Valor da Comissão </label>
                        </dt>
                        <dd>
                            <input type="text" alt="decimal" name="valor_comissao" class="texto01" required/>
                        </dd>
                    </fieldset>       


                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
            <br>
            <table>
                <thead>
                        
                        <tr>
                            <th class="tabela_header">Forma de Pagamento</th>
                            <th class="tabela_header">De:</th>
                            <th class="tabela_header">Até: </th>
                            <th class="tabela_header">Valor: </th>
                            <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                        </tr>
                </thead>
            
            <?
            if (count($forma_comissao) > 0) {
                ?>
                <tbody>
                    <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($forma_comissao as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                        <tr >
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->forma; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio_parcelas; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?=($item->fim_parcelas > 0) ? $item->fim_parcelas: 'Sem fim'; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_comissao, 2, ',', '.'); ?></td>

                            <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Forma?');" href="<?= base_url() ?>cadastros/formapagamento/excluirFormaRendimentoComissao/<?= $item->forma_rendimento_comissao_id ?>/<?= $item->plano_id ?>">Excluir</a>
                            </td>
         
                        </tr>

                </tbody>
                <?
                        }
                    }
                ?>
           </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script> -->
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });


    // $(document).ready(function () {
    //     jQuery('#form_formapagamento').validate({
    //         rules: {
    //             txtNome: {
    //                 required: true,
    //                 minlength: 3
    //             },
    //             ajuste: {
    //                 required: true

    //             },
    //             parcelas: {
    //                 required: true
    //             }

    //         },
    //         messages: {
    //             txtNome: {
    //                 required: "*",
    //                 minlength: "!"
    //             },
    //             ajuste: {
    //                 required: "*"

    //             },
    //             parcelas: {
    //                 required: "*"
    //             }
    //         }
    //     });
    // });

</script>
