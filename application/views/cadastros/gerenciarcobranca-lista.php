<div class="content"> <!-- Inicio da DIV content -->


    <div id="accordion">
        <h3><a href=""> &nbsp; &nbsp; Gerenciar Cobranças</a></h3>
        <div>
            <table >
                <thead>
                    <tr>

                        <th class="tabela_title" >Numero</th>
                        <th class="tabela_title" >Nome</th>
                        <th class="tabela_title" >CPF</th>

                    </tr>
                    <tr>
                <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/gerenciarcobranca">
 
                    <th class="tabela_title" >
                        <input type="text" name="prontuario" class="texto02" value="<?php echo @$_GET['prontuario']; ?>" />
                    </th>
                    <th class="tabela_title" >
                        <input type="text" name="nome" class="texto06" value="<?php echo @$_GET['nome']; ?>" />
                    </th>
                    <th class="tabela_title" >
                        <input type="text" name="cpf" id ="cpfcnpj" class="texto03" value="<?php echo @$_GET['cpf']; ?>" />
                    </th>


                    <th class="tabela_title" >
                        <button type="submit" name="enviar">Pesquisar</button>
                    </th>
                </form>
                </tr>
            </table>
            <table >
                <tr>
                    <th class="tabela_header">Numero</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">CPF</th>
                    <th class="tabela_header" width="100px;">Endereço</th>
                    <th class="tabela_header" width="100px;">Bairro</th>
                    <th class="tabela_header" width="100px;">Complemento</th>
                    <th class="tabela_header" width="100px;">Fone</th>
                    <th class="tabela_header">Parcelas</th>
                    <th colspan='2' class="tabela_header">Ultima Parcela Paga</th>
                    <th class="tabela_header" width="150px;">Obs</th>
                    <!-- <th class="tabela_header" width="100px;">Vendedor</th>
                    <th class="tabela_header" width="100px;">Indicação</th>
                    <th class="tabela_header" colspan="4"  width="70px;"><center>A&ccedil;&otilde;es</center></th> -->

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->paciente->listargerenciarcobranca($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->paciente->listargerenciarcobranca($_GET)->orderby('paciente_id', 'desc')->limit($limit, $pagina)->get()->result();
                        // echo '<pre>';
                        // print_r($lista);
                        // die;
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            if ($item->celular == "") {
                                $telefone = $item->telefone;
                            } else {
                                $telefone = $item->celular;
                            }

                            $parcela = $this->paciente->ultimaparcelapaga($item->paciente_contrato_id);
                            
                            //  echo '<pre>';
                            //  print_r($parcela);
                            //  die;
                            
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->cpf; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->logradouro; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->bairro; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->complemento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $telefone; ?></td>

                                <? if(count($parcela) > 0){?>
                                    <? if($parcela[0]->parcela == 0){
                                        $parcelas = 'ADESÃO';
                                     }else{
                                         $parcelas = $parcela[0]->parcela;
                                     } ?>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo @$parcelas; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo @$parcela[0]->valor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><b><?php echo substr(@$parcela[0]->data, 8, 2) . '/' . substr(@$parcela[0]->data, 5, 2) . '/' . substr(@$parcela[0]->data, 0, 4); ?></b></td>
                                <td class="<?php echo $estilo_linha; ?>"><a href="<?= base_url() ?>ambulatorio/guia/alterarobservacao/<?= $item->paciente_id ?>/<?= $item->paciente_contrato_id ?>/<?= $parcela[0]->paciente_contrato_parcelas_id ?>" target="_blank"> =><?php echo @$parcela[0]->observacao; ?></td>
                                <? }else{ ?>
                                    <td class="<?php echo $estilo_linha; ?>"> </td>
                                    <td class="<?php echo $estilo_linha; ?>"> </td>
                                    <td class="<?php echo $estilo_linha; ?>"> </td>
                                    <td class="<?php echo $estilo_linha; ?>"> </td>
                                <? } ?>

                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>cadastros/pacientes/pesquisar/50');" <?
                                    if ($limit == 50) {
                                        echo "selected";
                                    }
                                    ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>cadastros/pacientes/pesquisar/100');" <?
                                            if ($limit == 100) {
                                                echo "selected";
                                            }
                                    ?>> 100 </option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $("#cpfcnpj").mask("999.999.999-99");

</script>