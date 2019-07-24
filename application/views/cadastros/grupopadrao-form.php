<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Procedimentos Padrão Por Grupo</a></h3>
        <div>
            <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/gravargrupopadrao/<?= $convenioid; ?>" method="post">

                <dl class="dl_desconto_lista">

                    <dt>
                    <label>Convênio Selecionado</label>
                    </dt>
                    <dd>
                        
                        <input type="text" name="convenio_selecionado" value="<?= $convenio_selecionado[0]->nome; ?>" readonly="" />
                        <input type="hidden" name="convenio_id" id="convenio_id" value="<?= $convenioid; ?>" />
                    </dd>
                    <dt>
                    <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2">
                            <option value="">TODOS</option>
                            <? foreach ($grupos as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                        
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
                        <select required name="procedimento1" id="procedimento1" class="size2" data-placeholder="Selecione" tabindex="1">
                            <option value="">Selecione</option>
                        </select>
                        
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>

                <br>
                <br>
                <table>
                    <thead>
                       
                        <tr>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Proeedimento</th>
                            <th class="tabela_header" colspan="1"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir essa associação?');" href="<?= base_url() ?>cadastros/convenio/excluirgrupopadrao/<?= $item->convenio_grupo_padrao_id ?>/<?= $convenioid; ?>">Excluir</a></div>
                                    </td>
                      
                                </tr>

                            </tbody>
                            <?php
                            }
                              
                            ?>
                            <tfoot>
                           
                    </tfoot>
                </table>    
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });


     $(function () {
        $('#grupo').change(function () {
            if ($(this).val()) {

                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: $('#convenio_id').val()}, function (j) {
                    options = '<option value=""></option>';
            
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento1 option').remove();
                    $('#procedimento1').append(options);
                    $("#procedimento1").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });

</script>