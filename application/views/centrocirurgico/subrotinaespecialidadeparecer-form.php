<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sub-Rotinas</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarespecialidadeparecersubrotina/<?= @$especialidade_parecer_id; ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Especialidade Parecer</label>
                    </dt>
                    <dd>
                        <input readonly type="text" name="especialidade_parecer" id="especialidade_parecer" class="texto10" value="<?=@$parecer[0]->nome;?>"/>
                    </dd>
                    <!-- <hr> -->
                    <dt>
                    <label>Sub-Rotina</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="especialidade_parecer_id" class="texto10" value="<?= @$especialidade_parecer_id; ?>" />
                        <input type="text" name="subrotina" id="subrotina" class="texto10" required/>
                    </dd>
                    <dt>
                        <label>Telas</label>
                    </dt>
                    <dd>
                        <select name="telas" id="telas" class="size4" >
                            <option value="">Selecione</option>
                            <option value="parecercirurgia" >Parecer Cirurgia Pediátrica</option>
                            <option value="laudoapendicite" >Laudo Apendicite</option>
                            
                        </select>
                    </dd>

                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Adicionar</button>

                <br>
                <br>
                <table>
                    <thead>
                       
                        <tr>
                            <th class="tabela_header">Sub-Rotina</th>
                            <th class="tabela_header">Tela</th>
                            <th class="tabela_header" colspan="1"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $estilo_linha = "tabela_content01";
                            foreach ($lista as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                                $tela = $this->centrocirurgico_m->retornarNomeRotina($item->tela);
                            ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->subrotina; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $tela; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir essa especialidade parecer?');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirespecialidadeparecersubrotina/<?= $item->especialidade_parecer_subrotina_id ?>/<?= $item->especialidade_parecer_id ?>">Excluir</a></div>
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

    $(function() {
        $( "#txtCidade" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.value );
                $( "#txtCidadeID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_empresa').validate( {
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