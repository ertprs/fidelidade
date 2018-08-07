
<?
if (count($exames) > 0) {

    foreach ($exames as $item) {
        if ($item->ativo == 't') {
            $ativo = 't';
            break;
        } else {
            $ativo = 'f';
        }
    }
} else {
    $ativo = 'f';
}
?>
<div class="content ficha_ceatox">
    <? if ($ativo == 'f') { ?>


        <div class="bt_link_new">
            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/novocontrato/" . $paciente['0']->paciente_id; ?> ', '_blank', 'width=900,height=600');">
                Novo Contrato
            </a>
        </div>
    <? } ?>
    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
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
            <?
            $guia_id = 0;
            $cancelado = 0;
            if (count($exames) > 0) {
                ?>
                <table >
                    <thead>
                        <tr>
                            <th class="tabela_header">Contrato</th>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Status</th>
                            <th colspan="4" class="tabela_header"></th>


                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) :
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><a href="<?= base_url() ?>ambulatorio/guia/listardependentes/<?= $paciente['0']->paciente_id; ?>/<?= $item->paciente_contrato_id ?>" target="_blank"><?= $item->paciente_contrato_id . "-" . $item->plano; ?></a></td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <? if ($item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">Ativo</td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">Inativo</td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                    <div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . $item->paciente_contrato_id ?> ', '_blank', 'width=1000,height=1000');">
                                            Carteira
                                        </a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                    <div class="bt_link_new">
                                        <a target="_blank" href="<?= base_url() . "ambulatorio/guia/listarpagamentos/" . $paciente['0']->paciente_id . "/" . $item->paciente_contrato_id ?>">
                                            Pagamento
                                        </a>
                                    </div>
                                </td>
                                <? if ($perfil_id == 1 && $item->ativo == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                        <div class="bt_link_new">
                                            <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas');"   href="<?= base_url() . "ambulatorio/guia/excluircontrato/" . $paciente[0]->paciente_id . "/" . $item->paciente_contrato_id ?>">
                                                Excluir
                                            </a>
                                        </div>
                                    </td>   
                                <? } else {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"> 
                                        <? if ($ativo == 'f') { ?>
                                            <div class="bt_link_new">
                                                <a onclick="javascript: return confirm('Deseja realmente re-ativar o contrato?');"   href="<?= base_url() . "ambulatorio/guia/ativarcontrato/" . $paciente['0']->paciente_id . "/" . $item->paciente_contrato_id ?>">
                                                    Re-Ativar
                                                </a>
                                            </div>
                                        <? } ?>
                                    </td>      
                                <? } ?>
                                <?
                                if ($operador_id == 1) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                        <div class="bt_link_new">
                                            <a onclick="javascript: return confirm('Deseja realmente excluir o contrato?\nObs: Esse processo poderá ser demorado se houver parcelas no Iugu geradas. Excluir por esse botão fará o contrato sumir');"   href="<?= base_url() . "ambulatorio/guia/excluircontratoadmin/" . $paciente[0]->paciente_id . "/" . $item->paciente_contrato_id ?>">
                                                Excluir (Admin)
                                            </a>
                                        </div>
                                    </td> 
                                    <?
                                }
                                ?>

                                        <!--                            <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                                            <div class="bt_link_new">
                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/integracaoiugu/" . $paciente['0']->paciente_id . "/" . $item->paciente_contrato_id ?> ', '_blank', 'width=800,height=1000');">
                                                    Pagamento Iugu
                                                </a>
                                            </div>
                                        </td>-->




                            </tr>


                            <?
                        endforeach;
                    } else {
                        $estilo_linha = "tabela_content01";
                        ?>
                    <table >
                        <thead>
                            <tr>
                                <th class="tabela_header">Contrato</th>
                                <th class="tabela_header">Titular</th>
                                <th colspan="2" class="tabela_header"></th>


                            </tr>
                        </thead>
                        <tbody>

                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= $titular['0']->paciente_id; ?>/<?= $titular['0']->paciente_contrato_id ?>');"><?= $titular['0']->paciente_contrato_id; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listardependentes/<?= $titular['0']->paciente_id; ?>/<?= $titular['0']->paciente_contrato_id ?>');"><?= $titular['0']->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="50px;">       
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoficha/" . $titular['0']->paciente_contrato_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=1000');">
                                    Carteira
                                </a>
                            </div>
                        </td>
                        <?
                    }
                    ?>
                    </tbody>                                
                    <br>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="11">
                            </th>
                        </tr>
                    </tfoot>
                </table>
        </fieldset>
    </div>


    <script type="text/javascript">



        $(function () {
            $(".competencia").accordion({autoHeight: false});
            $(".accordion").accordion({autoHeight: false, active: false});
            $(".lotacao").accordion({
                active: true,
                autoheight: false,
                clearStyle: true

            });


        });
    </script>
