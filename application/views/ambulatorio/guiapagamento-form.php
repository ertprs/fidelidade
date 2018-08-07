
<div class="content ficha_ceatox">

    <div >
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
                        <input type="hidden" id="txtcontrato_id" name="txtcontrato_id"  value="<?= $contrato_id; ?>"/>
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
                <? if (count($listarpagamentoscontrato) > 0) { ?>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Parcela</th>
                                <th width="70px;" class="tabela_header">Data</th>
                                <th width="70px;" class="tabela_header">Valor</th>
                                <th width="70px;" class="tabela_header">Situacao</th>
                                <th width="70px;" class="tabela_header">Observações</th>
    <!--                                <th width="70px;" class="tabela_header">Taxa de Adesão</th>-->
                                <th width="70px;" colspan="2" class="tabela_header"></th>
                                <? if (@$listarpagamentoscontrato[0]->contrato == 't') { ?>


                                    <th class="tabela_header" colspan="1">
                                        <div class="bt_link" id="botaogerartodos">
                                            <a href="<?= base_url() ?>ambulatorio/guia/gerartodosiugu/<?= $paciente_id ?>/<?= $contrato_id ?>">Gerar Todos Iugu
                                            </a>
                                        </div>
                                    </th>
                                    <th class="tabela_header" colspan="2">
                                        <div  class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/guia/pagamentocartaoiugu/<?= $paciente_id ?>/<?= $contrato_id ?>">Pag. Cartão Agendado
                                            </a>
                                        </div>
                                    </th>
                                <? } ?>
                            </tr>
                        </thead>
                        <?
                        $key = $empresa[0]->iugu_token;
                        Iugu::setApiKey($key);
                        $contador = 0;
                        foreach ($listarpagamentoscontrato as $item) {
                            $contador ++;
//                            if ($empresa[0]->iugu_token != '' && $item->ativo == 't' && $item->invoice_id != '') {
//                                $invoice_id = $item->invoice_id;
//
//                                $retorno = Iugu_Invoice::fetch($invoice_id);
//                                if ($retorno['status'] == 'paid') {
////                                    echo '<pre>';
////                                    var_dump($retorno);
////                                    die;
//                                    $this->guia->confirmarpagamento($item->paciente_contrato_parcelas_id);
//                                }
//                            }
                            ?>
                            <?
                            $MES = substr($item->data, 5, 2);

                            switch ($MES) {
                                case "01": $mes = 'Janeiro';
                                    break;
                                case "02": $mes = 'Fevereiro';
                                    break;
                                case "03": $mes = 'Março';
                                    break;
                                case "04": $mes = 'Abril';
                                    break;
                                case "05": $mes = 'Maio';
                                    break;
                                case "06": $mes = 'Junho';
                                    break;
                                case "07": $mes = 'Julho';
                                    break;
                                case "08": $mes = 'Agosto';
                                    break;
                                case "09": $mes = 'Setembro';
                                    break;
                                case "10": $mes = 'Outubro';
                                    break;
                                case "11": $mes = 'Novembro';
                                    break;
                                case "12": $mes = 'Dezembro';
                                    break;
                            }


                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $mes; ?> <? if ($item->taxa_adesao == 't') { ?><span style="color:green;">Adesão </span><? } ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.') ?></td>


                                    <? if ($item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>">ABERTA</td>
                                        <td style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>" target="_blank">=> <?= $item->observacao ?></a></td>
                                        <? if ($item->contrato == 't') { ?>


                                            <? if ($perfil_id == 1) { ?>
                                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                    <div class="bt_link">
                                                        <a href="<?= base_url() ?>ambulatorio/guia/confirmarpagamento/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Confirmar
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                    <div class="bt_link">

                                                        <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/alterardatapagamento/$paciente_id/$contrato_id/$item->paciente_contrato_parcelas_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');">
                                                            Alterar Data
                                                        </a>
                                                    </div>
                                                </td>
                                            <? }
                                            ?>
                                            <? if ($item->paciente_contrato_parcelas_iugu_id == '' && $empresa[0]->iugu_token != '' && $item->data_cartao_iugu == '') { ?>
                                                <td  class="<?php echo $estilo_linha; ?>" ><div style="width: 100px;" class="bt_link">
                                                        <a id="botaopagamento<?= $contador ?>" href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiugu/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Gerar Pag. Iugu
                                                        </a></div>
                                                </td>  
                                                <? if ($item->pago_cartao != 't') { ?>
                                                    <td  class="<?php echo $estilo_linha; ?>" >

                                                    </td>   
                                                <? } else { ?>
                        <!--                                            <td  class="<?php echo $estilo_linha; ?>" style="color: #ebcf11" >Aguardando Confirmação
                                                    </td>  -->
                                                <? } ?>

                                            <? } elseif ($item->data_cartao_iugu != '') { ?>
                                                <? if ($item->status != '') { ?>
                                                    <td colspan="1" class="<?php echo $estilo_linha; ?>" ><span style="color: #888001;font-weight: bold" > <?
                                                            if ($item->status == 'pending') {
                                                                echo 'Pendente';
                                                            } else {
                                                                echo $item->status . ". Código LR: " . $item->codigo_lr;
                                                            }
                                                            ?></span><a target="_blank" href="https://support.iugu.com/hc/pt-br/articles/206858953-Como-identificar-o-erro-da-tentativa-de-pagamento-com-cart%C3%A3o-de-cr%C3%A9dito-falha-">->></a> </td>
                                                <? } else { ?>
                                                    <td colspan="1" class="<?php echo $estilo_linha; ?>" ><span style="color: #01882e;font-weight: bold" > Pagamento por Cartão Agendado</span> </td>      
                                                <? } ?>


                                                <td  class="<?php echo $estilo_linha; ?>" ><div style="width: 120px;" class="bt_link">
                                                        <a id="" href="<?= base_url() ?>ambulatorio/guia/cancelaragendamentocartao/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Cancelar Agen.
                                                        </a></div> 

                                                </td> 
                                            <? } else { ?>
                                                <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                                    <div style="width: 100px;" class="bt_link">
                                                        <a target="_blank" href="<?= $item->url ?>">Pag. Iugu
                                                        </a>
                                                    </div>
                                                </td>
                                                <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                                    <div style="width: 100px;" class="bt_link">
                                                        <a  href="<?= base_url() ?>ambulatorio/guia/reenviaremail/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Re-enviar Email
                                                        </a>
                                                    </div>
                                                </td>


                                            <? }
                                            ?>
                                            <? if ($perfil_id == 1) { ?>
                                                <td onclick="javascript: return confirm('Deseja realmente excluir a parcela?');"  class="<?php echo $estilo_linha; ?>" ><div style="width: 50px;" class="bt_link">
                                                        <a id="" href="<?= base_url() ?>ambulatorio/guia/excluirparcelacontrato/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Excluir
                                                        </a></div> 

                                                </td>
                                            <? }
                                            ?>
                                        <? } else { ?>
                                            <td colspan="8" class="<?php echo $estilo_linha; ?>"></td> 
                                        <? } ?>
                                    <? } else { ?>
                                        <td style="width: 130px" class="<?php echo $estilo_linha; ?>">PAGA (<?
                                            if ($item->data_cartao_iugu != '') {
                                                echo 'Cartão';
                                            } elseif ($item->manual == 't') {
                                                echo 'Manual';
                                            } else {
                                                echo 'Boleto';
                                            }
                                            ?>)</td>
            <!--                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiugu/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>">Gerar Pagamento Iugu
                                                </a></div>
                                        </td> -->
                                        <td colspan="7" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->paciente_contrato_parcelas_id ?>" target="_blank">=> <?= $item->observacao ?></a></td>
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
                    <?
                }
                ?>
                </table> 
                <br/>


            </fieldset>

            <fieldset>
                <legend>Consulta Extra</legend>
                <? if (count($listarpagamentosconsultaextra) > 0) { ?>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Parcela</th>
                                <th width="70px;" class="tabela_header">Data</th>
                                <th width="70px;" class="tabela_header">Valor</th>
                                <th width="70px;" class="tabela_header">Situacao</th>
                                <th width="70px;" class="tabela_header">Observações</th>
                                <th width="70px;" colspan="6" class="tabela_header"></th>
                            </tr>
                        </thead>
                        <?
                        $contador = 0;
                        foreach ($listarpagamentosconsultaextra as $item) {
                            $contador ++;
                            ?>
                            <?
                            $MES = substr($item->data, 5, 2);

                            switch ($MES) {
                                case "01": $mes = 'Janeiro';
                                    break;
                                case "02": $mes = 'Fevereiro';
                                    break;
                                case "03": $mes = 'Março';
                                    break;
                                case "04": $mes = 'Abril';
                                    break;
                                case "05": $mes = 'Maio';
                                    break;
                                case "06": $mes = 'Junho';
                                    break;
                                case "07": $mes = 'Julho';
                                    break;
                                case "08": $mes = 'Agosto';
                                    break;
                                case "09": $mes = 'Setembro';
                                    break;
                                case "10": $mes = 'Outubro';
                                    break;
                                case "11": $mes = 'Novembro';
                                    break;
                                case "12": $mes = 'Dezembro';
                                    break;
                            }


                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $mes; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.') ?></td>

                                    <? if ($item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>">ABERTA</td>
                                        <td style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
                                        <? if ($perfil_id == 1) { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                <div class="bt_link">
                                                    <a href="<?= base_url() ?>ambulatorio/guia/confirmarpagamentoconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Confirmar
                                                    </a>
                                                </div>
                                            </td>

                                        <? }
                                        if ($item->invoice_id == '' && $empresa[0]->iugu_token != '') {
                                            ?>
                                            <td colspan="1" class="<?php echo $estilo_linha; ?>" width="60px;"><div style="width: 160px;" class="bt_link">
                                                    <a id="botaopagamento<?= $contador ?>" href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiuguconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>/EXTRA">Gerar Pagamento Iugu
                                                    </a></div>
                                            </td>  
            <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>" colspan="1">
                                                <div style="width: 160px;" class="bt_link">
                                                    <a target="_blank" href="<?= $item->url ?>">Pagamento Iugu
                                                    </a>
                                                </div>
                                            </td>                                                                                                
                                        <? }
                                        if ($perfil_id == 1) {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>">
                                                <div class="bt_link">
                                                    <a href="<?= base_url() ?>ambulatorio/guia/excluirconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Excluir
                                                    </a>
                                                </div>
                                            </td>
                                        <? }
                                        ?>

                                    <? } else { ?>
                                        <td colspan="" class="<?php echo $estilo_linha; ?>">PAGA</td>
                                        <td colspan="5" style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
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
                    <?
                }
                ?>
                </table> 
                <br/>


            </fieldset>

            <fieldset>
                <legend>Consulta Coparticipação</legend>
<? if (count($listarpagamentosconsultacoop) > 0) { ?>
                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th width="70px;" class="tabela_header">Parcela</th>
                                <th width="70px;" class="tabela_header">Data</th>
                                <th width="70px;" class="tabela_header">Valor</th>
                                <th width="70px;" class="tabela_header">Situacao</th>
                                <th width="70px;" class="tabela_header">Observações</th>
    <!--                                <th width="70px;" class="tabela_header">Taxa de Adesão</th>-->
                                <th width="70px;" colspan="6" class="tabela_header"></th>
        <!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <?
                        $contador = 0;
                        foreach ($listarpagamentosconsultacoop as $item) {
                            $contador ++;
                            ?>
                            <?
                            $MES = substr($item->data, 5, 2);

                            switch ($MES) {
                                case "01": $mes = 'Janeiro';
                                    break;
                                case "02": $mes = 'Fevereiro';
                                    break;
                                case "03": $mes = 'Março';
                                    break;
                                case "04": $mes = 'Abril';
                                    break;
                                case "05": $mes = 'Maio';
                                    break;
                                case "06": $mes = 'Junho';
                                    break;
                                case "07": $mes = 'Julho';
                                    break;
                                case "08": $mes = 'Agosto';
                                    break;
                                case "09": $mes = 'Setembro';
                                    break;
                                case "10": $mes = 'Outubro';
                                    break;
                                case "11": $mes = 'Novembro';
                                    break;
                                case "12": $mes = 'Dezembro';
                                    break;
                            }


                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $mes; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.') ?></td>

                                    <? if ($item->ativo == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>">ABERTA</td>
                                        <td style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
            <? if ($perfil_id == 1) { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                <div class="bt_link">
                                                    <a href="<?= base_url() ?>ambulatorio/guia/confirmarpagamentoconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Confirmar
                                                    </a>
                                                </div>
                                            </td>
            <? }
            if ($item->invoice_id == '' && $empresa[0]->iugu_token != '') {
                ?>
                                            <td colspan="1" class="<?php echo $estilo_linha; ?>" width="60px;"><div style="width: 160px;" class="bt_link">
                                                    <a id="botaopagamento<?= $contador ?>" href="<?= base_url() ?>ambulatorio/guia/gerarpagamentoiuguconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>/COOP">Gerar Pagamento Iugu
                                                    </a></div>
                                            </td>   
            <? } else { ?>
                                            <td class="<?php echo $estilo_linha; ?>" colspan="1">
                                                <div style="width: 160px;" class="bt_link">
                                                    <a target="_blank" href="<?= $item->url ?>">Pagamento Iugu
                                                    </a>
                                                </div>
                                            </td>                                                                                                  </td>-->
            <? }
            if ($perfil_id == 1) {
                ?>
                                            <td class="<?php echo $estilo_linha; ?>">
                                                <div class="bt_link">
                                                    <a href="<?= base_url() ?>ambulatorio/guia/excluirconsultaavulsa/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>">Excluir
                                                    </a>
                                                </div>
                                            </td>

                                        <? }
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>">PAGA</td>
                                        <td colspan="4" style="width: 130px" class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacaoavulso/<?= $paciente_id ?>/<?= $contrato_id ?>/<?= $item->consultas_avulsas_id ?>" target="_blank">=> <?= @$item->observacao ?></a></td>
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
    <?
}
?>
                </table> 
                <br/>


            </fieldset>

            <fieldset>
                <legend>Historico de Consultas Realizadas</legend>
<? if (count($historicoconsultasrealizadas) > 0) { ?>
                    <table id="table_justa">
                        <thead>
                            <tr>                                
                                <th width="70px;" class="tabela_header">Nome</th>
                                <th width="70px;" class="tabela_header">Parceiro</th>
                                <th width="70px;" class="tabela_header">Grupo</th>
                                <th width="70px;" class="tabela_header">Data</th>
                                <th width="70px;" class="tabela_header">Situação</th>
                            </tr>
                        </thead>
                        <?
                        $contador = 0;
                        foreach ($historicoconsultasrealizadas as $item) {
                            $estilo_linha = "tabela_content01";
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                            $situacao = '';
                            $cor = '';
                            if ($item->carencia_liberada == 't') {
                                if ($item->consulta_avulsa == 't') {
                                    $situacao = "Consulta $item->consulta_tipo";
                                    $cor = 'green';
                                } else {
                                    $situacao = 'Carência Utilizada';
                                    $cor = 'green';
                                }
                                $pagamento = 'ok';
                            } else {
                                if ($item->pagamento_confirmado == 'f') {
                                    $situacao = "Pagamento Pendente R$: " . number_format($item->valor, 2, ",", ".");
                                    $cor = 'red';
                                    $pagamento = 'pendente';
                                } else {
                                    $situacao = "Pagamento Confirmado R$: " . number_format($item->valor, 2, ",", ".");
                                    $cor = 'green';
                                    $pagamento = 'ok';
                                }
                            }
                            ?>

                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td> <!--nome-->
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->parceiro; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data)); ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" style="color: <?= $cor ?>;"><?= $situacao; ?></td>
                                </tr>
                            </tbody>
        <?
    }
    ?>
                        <tfoot>

                        </tfoot>
                    </table> 
                    <br/>
    <?
}
?>
                <!--</table>--> 
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
                                    $("#data").datepicker({
                                        autosize: true,
                                        changeYear: true,
                                        changeMonth: true,
                                        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                        buttonImage: '<?= base_url() ?>img/form/date.png',
                                        dateFormat: 'dd/mm/yy'
                                    });
                                });
                                $(function () {
                                    $("#accordion").accordion();
                                });
                                $(function () {
                                    $("#medico1").autocomplete({
                                        source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                                        minLength: 3,
                                        focus: function (event, ui) {
                                            $("#medico1").val(ui.item.label);
                                            return false;
                                        },
                                        select: function (event, ui) {
                                            $("#medico1").val(ui.item.value);
                                            $("#crm1").val(ui.item.id);
                                            return false;
                                        }
                                    });
                                });

//                                botaogerartodos
                                $("#botaogerartodos").click(function () {
                                    $("#botaogerartodos").hide();
                                });

<? for ($i = 0; $i <= $contador; $i++) { ?>
                                    $("#botaopagamento<?= $i ?>").click(function () {
                                        $("#botaopagamento<?= $i ?>").hide();
                                    });
<? } ?>
                                $(function () {
                                    $('#convenio1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                                options = '<option value=""></option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                                }
                                                $('#procedimento1').html(options).show();
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#procedimento1').html('<option value="">Selecione</option>');
                                        }
                                    });
                                });
                                $(function () {
                                    $('#procedimento1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                options = "";
                                                options += j[0].valortotal;
                                                document.getElementById("valor1").value = options
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#valor1').html('value=""');
                                        }
                                    });
                                });
                                $(function () {
                                    $('#procedimento1').change(function () {
                                        if ($(this).val()) {
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                                                var options = '<option value="0">Selecione</option>';
                                                for (var c = 0; c < j.length; c++) {
                                                    if (j[c].forma_pagamento_id != null) {
                                                        options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                                    }
                                                }
                                                $('#formapamento').html(options).show();
                                                $('.carregando').hide();
                                            });
                                        } else {
                                            $('#formapamento').html('<option value="0">Selecione</option>');
                                        }
                                    });
                                });
</script>