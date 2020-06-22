
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter envio cartão iugu</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>cadastros/pacientes/listarenviosparauigu">
                                
                                <table>
                                    <tr>
                                        <td>Número do Cliente</td>
                                        <td>Nome</td>                                       
                                        <td>Nº contrato</td>
                                        <td>Data envio</td>
                                    </tr>
                                    <tr>
                                      <td><input type="number" name="numero_cliente" id="numero_cliente" class="texto6 bestupper" value="<?php echo @$_GET['numero_cliente']; ?>" />  </td>
                                      <td><input type="text" name="nome" id="nome" class="texto6 bestupper" value="<?php echo @$_GET['nome']; ?>" />  </td>
                                     
                                      <td><input type="text" name="numero_contrato" id="numero_contrato" class="texto6 bestupper" value="<?php echo @$_GET['numero_contrato']; ?>" />  </td>
                                      <td><input type="text" name="data" id="data" alt="date"  class="texto6 bestupper" value="<?php echo @$_GET['data']; ?>" />  </td>
                                     
                                      <td>  <button type="submit" id="enviar">Pesquisar</button> </td>
                                      
                                    </tr>
                                </table> 
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header"  width="50px">Número</th>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header"  width="70px">Data envio</th>
                        <th class="tabela_header" width="80px">Data parcela</th>
                        <th class="tabela_header"  width="70px">Valor</th>
                        <th class="tabela_header"  width="70px">Nº contrato</th>    
                        <th class="tabela_header">Situação</th> 
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $perfil_id = $this->session->userdata('perfil_id'); 
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->paciente->listarenviosiugucard($_GET)->get()->result();                 
                $total = count($consulta);
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->paciente->listarenviosiugucard($_GET)->limit($limit, $pagina)->orderby('eg.data_cadastro')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $parcela = $this->paciente->listarpagamentoscontratoparcela($item->paciente_contrato_parcelas_id);
                            
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"> <?= $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"> <?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date('d/m/Y', strtotime($item->data_cadastro)); ?> </td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date('d/m/Y', strtotime($item->data)); ?> </td>
                                <td class="<?php echo $estilo_linha; ?>"> <?= $item->valor; ?></td> 
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente_contrato_id; ?></td>
                                 <td class="<?php echo $estilo_linha; ?>"><?
                                         if (@$parcela[0]->ativo == "f") {
                                           echo "Parcela paga!";  
                                         }else{
                                             echo "Não paga";
                                         }
                                 ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                   <?php if($perfil_id != 10){?>
                                    <a href="<?= base_url() ?>cadastros/pacientes/excluirenvioiugu/<?= $item->envio_iugu_card_id; ?>">
                                        Excluir
                                    </a>
                                     <?php }?>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    
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

</script>
