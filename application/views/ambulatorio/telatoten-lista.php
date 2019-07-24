
<div class="content"> <!-- Inicio da DIV content -->
<style>
    .row{
        display: flex;
    }
    .col{
        flex: 1;
        align-self: start;
    }
</style>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Telas do Toten</a></h3>
        
        <div>
            <div class="row">
                <div class="col">
                    <table>
                        <thead>
                            
                            <tr>
                                <th class="tabela_header">ID</th>
                                <th class="tabela_header">Tela</th>
                                <!--<th class="tabela_header">Tipo</th>-->
                                <!-- <th class="tabela_header" colspan="8">Detalhes</th> -->
                            </tr>
                        </thead>
                        <?php
                            $data['empresa'] = $this->empresa->listarempresatoten();
                            $endereco = $data['empresa'][0]->endereco_toten;
                            $data['endereco'] = $endereco;
                            $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                            $consulta = $this->exame->listartelatoten($endereco);
                            $total    = $consulta->count_all_results();
                            $limit    = 5000000000;
                            isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                            if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                                $lista = $this->exame->listartelatoten($endereco)->orderby("id, nome")->get()->result();
                                $estilo_linha = "tabela_content01";
                                $telas_select = $lista;
                                foreach ($lista as $item) {
                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->id; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                                </tr>

                                </tbody>
                                <?php
                                        }
                                    }
                                ?>
                                <tfoot>
                                    
                        </tfoot>
                    </table>
                    <br>
                    <br>
                    <table>
                        <thead>
                            
                            <tr>
                                <th class="tabela_header">ID</th>
                                <th class="tabela_header">Setor</th>
                                <!--<th class="tabela_header">Tipo</th>-->
                                <!-- <th class="tabela_header" colspan="8">Detalhes</th> -->
                            </tr>
                        </thead>
                        <?php
                            $data['empresa'] = $this->empresa->listarempresatoten();
                            $endereco = $data['empresa'][0]->endereco_toten;
                            $data['endereco'] = $endereco;
                            $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                            $consulta = $this->exame->listarsetortoten($endereco);
                            $total    = $consulta->count_all_results();
                            $limit    = 5000000000;
                            isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                            if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                                $lista = $this->exame->listarsetortoten($endereco)->orderby("id, nome")->get()->result();
                                $estilo_linha = "tabela_content01";
                                $setor_select = $lista;
                                foreach ($lista as $item) {
                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->id; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                                </tr>

                                </tbody>
                                <?php
                                        }
                                    }
                                ?>
                                <tfoot>
                                
                        </tfoot>
                    </table>
                </div>
                <div class="col">
                    <form method="post" action="<?= base_url() ?>ambulatorio/exame/gravartotentelasetor">
                        <table>
                        
                            <tr>
                                <th class="tabela_title">
                                    Tela
                                </th>
                                <th class="tabela_title">
                                    Setor 
                                </th>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="telas_id" id="telas_id" class="size2">
                                        <?
                                        $selected = false;
                                        foreach ($telas_select as $value) :?>
                                            <option value="<?= $value->id; ?>"><?=$value->nome?></option>
                                        <? endforeach; ?>
                                    </select> 
                                </td>
                                <td>
                                    <select name="setor_id" id="setor_id" class="size2">
                                        <?
                                        $selected = false;
                                        foreach ($setor_select as $value) :?>
                                            <option value="<?= $value->id; ?>"><?=$value->nome?></option>
                                        <? endforeach; ?>
                                    </select>  
                                </td>
                                
                                <td>
                                <button type="submit" name="enviar">Enviar</button>  
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <br>
                    <table>
                        <thead>
                            
                            <tr>
                                <th class="tabela_header">Tela</th>
                                <th class="tabela_header">Setor</th>
                                <!--<th class="tabela_header">Tipo</th>-->
                                <!-- <th class="tabela_header" colspan="8">Detalhes</th> -->
                            </tr>
                        </thead>
                        <?php
                            $data['empresa'] = $this->empresa->listarempresatoten();
                            $endereco = $data['empresa'][0]->endereco_toten;
                            $data['endereco'] = $endereco;
                            $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                            $consulta = $this->exame->listartelasetortoten($endereco);
                            $total    = $consulta->count_all_results();
                            $limit    = 5000000000;
                            isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                            if ($total > 0) {
                        ?>
                        <tbody>
                            <?php
                                $lista = $this->exame->listartelasetortoten($endereco)->orderby("telas_id, setor_id")->get()->result();
                                $estilo_linha = "tabela_content01";
                                foreach ($lista as $item) {
                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->tela; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->setor; ?></td>
                                    <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>-->

                                </tr>

                                </tbody>
                                <?php
                                        }
                                    }
                                ?>
                                <tfoot>
                                
                        </tfoot>
                    </table>
                </div>
            </div>
           
            
            
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
