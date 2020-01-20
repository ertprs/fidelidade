
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?= base_url()?>cadastros/pacientes/carregarprecadastro">Novo Pré-cadastro</a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#"> Pré-cadastro</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>cadastros/pacientes/listarenviosparauigu"> 
                              
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Plano</th>
                        <th class="tabela_header">Cpf</th>
                        <th class="tabela_header">Telefone</th>
                        <th class="tabela_header">Vendedor</th>
                        <th class="tabela_header" colspan="3"><center>Ações</center></th>
                        
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->paciente->listarprecadastro($_GET)->get()->result();                 
                $total = count($consulta);
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->paciente->listarprecadastro($_GET)->limit($limit, $pagina)->orderby('pc.data_cadastro','desc')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {                          
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                 <td class="<?php echo $estilo_linha; ?>"> <?= $item->nome; ?></td>
                                 <td class="<?php echo $estilo_linha; ?>"> <?= $item->forma_pagamento; ?></td>
                                 
                                 <td class="<?php echo $estilo_linha; ?>"> <?= @ereg_replace("([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})","\\1.\\2.\\3-\\4",$item->cpf);?></td>
                                
                                <td class="<?php echo $estilo_linha; ?>"> <?= $item->telefone; ?></td>
                                 <td class="<?php echo $estilo_linha; ?>"> <?= $item->vendedor; ?></td>
                                
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">                                  
                                   <div class="bt_link">
                                    <a href="<?= base_url() ?>cadastros/pacientes/novo/<?= $item->precadastro_id?>">
                                        <center> Confirmar</center>
                                    </a>
                                     </div>
                                </td>
                                
                                
                               <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                   
                                   <div class="bt_link">
                                    <a href="<?= base_url() ?>cadastros/pacientes/carregarprecadastro/<?= $item->precadastro_id?>">
                                        <center> Editar</center>
                                    </a>
                                     </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                   <div class="bt_link">
                                    <a href="<?= base_url() ?>cadastros/pacientes/excluirprecadastro/<?= $item->precadastro_id?>" onclick="javascript: return confirm('Deseja realmente excluir?');">
                                          <center>  Excluir</center>
                                    </a>
                                  </div>
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
