<div class="content ficha_ceatox">
    <div>
        <?
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa');
        $perfil_id = $this->session->userdata('perfil_id');
        $empresa = $this->guia->listarempresa();
        ?>
        <h3 class="singular"><a href="#">Marcar exames</a></h3>
        <div> 
             <fieldset>
                    <div class="bt_link"> 
                        <a href="<?= base_url() . "ambulatorio/guia/listarpagamentosconsultaavulsa/$paciente_id/$contrato_id"; ?>">
                            Consulta Extra
                        </a>

                    </div>  
                    <div class="bt_link">

                        <a href="<?= base_url() . "ambulatorio/guia/listarpagamentosconsultacoop/$paciente_id/$contrato_id"; ?>">
                            Consulta Coparticipação
                        </a>

                    </div>  
                    <div class="bt_link">

                        <a  href="<?= base_url() . "ambulatorio/guia/criarparcelacontrato/$paciente_id/$contrato_id"; ?>">
                            Criar Parcela
                        </a>
                    </div> 
                </fieldset>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravardependentes" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                      
                    </div>
                    <div>
                        <label>Sexo</label>
                        <select name="sexo" id="txtSexo" class="size2">
                            <option value="M" <?
                            if ($paciente['0']->sexo == "M"):echo 'selected';
                            endif;
                            ?>>Masculino</option>
                            <option value="F" <?
                            if ($paciente['0']->sexo == "F"):echo 'selected';
                            endif;
                            ?>>Feminino</option>
                        </select>
                    </div>

                    <div>
                        <label>Nascimento</label>


                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                    </div>

                    <div>

                        <label>Idade</label>
                        <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                    </div>

                    <div>
                        <label>Nome da M&atilde;e</label>


                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>

            </form>

            <fieldset>
                <legend>Parcelas</legend>
                <? if (count($parcelas) > 0) { ?>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Valor</th>
                          
                            </tr>
                        </thead>
                        <?
                        foreach ($parcelas as $item) {                           
                          
                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                                                 
                               <td class="<?php echo $estilo_linha; ?>"><?= $item->parcelas ?>x vezes de <?= number_format($item->valor, 2, ',', '.') ?></td>
                <? } ?>
                </tr>
                </tbody>
                <?
            }
            ?>
            <tfoot>

            </tfoot>
        </table> 
        <br/>
       
    </table> 
    <br/>


</fieldset>



</div> 
</div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

<?php if ($this->session->flashdata('message') != ''): ?>
                                alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>
                            
    $(function () {
        $("#accordion").accordion();
    });
                          


</script>