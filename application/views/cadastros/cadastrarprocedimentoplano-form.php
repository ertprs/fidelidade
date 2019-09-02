<?php
//echo '<pre>';
//print_r($procedimento);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Procedimento Plano</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravarprocedimentoplano" method="post" target="_blank">
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>                      
                        <select name="txtProcedimento" id="txtProcedimento" required="">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($procedimento as $item) {
                                ?>
                                <option value="<?= $item->procedimento_convenio_id; ?>"><?= $item->procedimento; ?></option>

                                <?
                            }
                            ?>
                        </select>
                    </dd>

                    <fieldset>
                        <dt>
                            <label>Quantidade</label>
                        </dt>
                        <dd>
                            <input type="number" min="1" name="qtd" class="texto01"  required=""/>
                            <input type="hidden"  name="formapagamento_id" value="<?= $formapagamento_id; ?>"class="texto01"  />
                        </dd>

                        <dt>
                            <label>Tempo</label>
                        </dt>
                        <dd>
                            <input type="time" name="tempo" class="texto02 hora"  required="" />

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
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Quantidade</th>
                        <th class="tabela_header">Tempo</th>                            
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                </tr>
                <?php
                     $estilo_linha = "tabela_content01";
                foreach ($procedimentopano as $value) {
                     ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?= $estilo_linha; ?>"><?= $value->procedimento; ?></td>                        
                        <td class="<?= $estilo_linha; ?>"><?= $value->quantidade; ?></td>
                        <td class="<?= $estilo_linha; ?>"><?= $value->tempo; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                            <a onclick="javascript: return confirm('Deseja realmente Excluir?');" href="<?= base_url() ?>cadastros/formapagamento/excluirprocedimentoplano/<?= $value->procedimentos_plano_id ?>" target="_blank">Excluir</a>
                  </td> 
                    </tr>
                    <?
                }
                ?>

                </thead>


            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script> -->
<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script> -->
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>cadastros/formapagamento');
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
