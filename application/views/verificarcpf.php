<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >

    <head>
        <title>STG - CLINICAS v1.0</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/forms.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/form-style.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/form-structure.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>

    </head>

    <style>
        #div_mensagem{
            height:auto;
            width: 500px; 


        }
        #mensagem_lado{ 
            position: absolute;
            /*border:1px solid red;*/
            width: 100%;
            margin-top:70px;


        }a#login_sair{
            float: right;
            float: right;
            display: block;
            background: url("../img/login_sair.png") no-repeat;
            width: 25px;
            height: 25px;
            text-indent: 99999px;
            overflow: hidden;
        }#login_controles{
            margin-top: -5%;

            float: right;

        }

    </style>
    <?php 
        $permissao = $this->empresa->listarpermissoesaleatorio();
     if (@count($permissao) > 0) {
             foreach ($permissao as $item) {
                if ($item->modificar_verificar == "t") {
                    $flag_parceiro = "true";
                }
            }
        }
    ?>
    <body> 


        <div class="header">
            <div id="imglogo">
                <img src="<?= base_url(); ?>img/stg - logo.jpg" alt="Logo"
                     title="Logo" height="70" id="Insert_logo"/>
                <div id="sis_info">SISTEMA DE GESTAO DE CLINICAS - v1.0</div>
            </div>
            <?php
            if (@$flag_parceiro == 'true') {
                ?>

                <div id="login_controles">
                    <!--
                    <a href="#" alt="Alterar senha" id="login_pass">Alterar Senha</a>
                    -->
                    <a id="login_sair" title="Sair do Sistema" onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                       href="<?= base_url() ?>login/sair">Sair</a>


                </div>
                <?php
            }
            ?>


        </div>

        <?php
        if (@$permissao[0]->modificar_verificar == 't' && $this->session->userdata('financeiro_parceiro_id') == "") {
            ?>
            <div id="login">
                <div id="login-box">
                    <h2>Login</h2>
                    <form name="form_login" id="form_login" action="<?= base_url() ?>login/autenticarparceiro"
                          method="post"> 
                        <div>
                            <label id="labelUsuario">Usuário</label>
                            &nbsp;<input type="text" id="usuario" name="usuario"  class="texto05" value="<?= @$obj->_login; ?>" />  
                        </div>

                        <div>
                            <label id="labelUsuario">Senha  </label>
                            &nbsp;<input type="password" id="senha" name="senha" class="texto05"  />  
                        </div>
                        <br><br>

                                <div style="padding-left: 110px;">
                                    <button type="submit" name="btnEnviar">Login</button>  
                                </div>
                                </form>

                                </div>
                                </div> 

                                <?
                            } else {
                                ?>
                                <div id="login">
                                    <div id="login-box">
                                        <h2>Verificar &nbsp; &nbsp;  
                                        </h2>  
                                        <form name="form_login" id="form_login" action="<?= base_url() ?>verificar/validarcpf"
                                              method="post"> 

                                            <div>
                                                <label id="labelUsuario">CPF</label>
                                                &nbsp;<input type="text" id="cpf" name="cpf" maxlength="11" class="texto05" value="<?= @$obj->_login; ?>" />  
                                            </div>

                                            <div>
                                                <label id="labelUsuario">Matrícula  </label>
                                                &nbsp;<input type="number" id="paciente_id" name="paciente_id" class="texto05" min="1" pattern="^[0-9]+" />  
                                            </div>
                                            <div>
                                                <label id="labelUsuario">Nome  </label>
                                                &nbsp;<input type="text" id="nome" name="nome" class="texto05"   />  
                                            </div>
                                            <?php
                                            if (@$permissao[0]->modificar_verificar == 't') {
                                                ?>
                                                <div>
                                                    <label id="labelUsuario">Proced.</label>
                                                    &nbsp;  <select name="procedimento_convenio_id" >
                                                        <option value="">Selecione</option>
                                                        <?php
                                                        foreach ($procedimentos as $item) {
                                                            ?>
                                                            <option value="<?= $item->procedimento_convenio_id; ?>"><?= $item->nome ?></option>


                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?
                                            }
                                            ?>


                                            <div style="padding-left: 110px; margin-top: -5%; ">
                                                <button type="submit" name="btnEnviar">Verificar</button>  
                                                 <?  if (@$permissao[0]->modificar_verificar == 't') { ?>
                                                <a href="<?= base_url() ?>home" style="font-size: 15px; border:1px solid white; background-color: white; border-radius: 10px;padding: 6px; font-weight: bold; text-decoration: none;" >Procedimentos</a>
                                                 <? }  ?>
                                            </div>


                                        </form>

                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                            <?
//         $grupo_busca = file_get_contents("http://localhost/clinicas/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id=139437");
//       echo "<pre>";
//       print_r($grupo_busca);

                            if (@$titulares) {
                                foreach (@$titulares as $item) {

                                    $numero_consultas_aut = 1;
                                    $data = date("Y-m-d");
                                    $listadependentes = $this->paciente->listardependentescontrato(@$item->paciente_contrato_id);
 
                                    if (count($titulares) > 0) {
                                        $paciente_id = @$item->paciente_id;
                                        @$paciente_nome_titular = @$item->nome; 
                                        if (@$item->situacao == 'Dependente') {
                                            $dependente = true;
                                        } else {
                                            $dependente = false;
                                        }

                                        if ($dependente) {
                                            $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
                                            @$paciente_titular_id = $retorno[0]->paciente_id;
                                        } else {
                                            $paciente_titular_id = $paciente_id;
                                            $paciente_dependente_id = null;
                                        }
                                        
                                        $parcelas = $this->guia->listarparcelaspaciente($paciente_titular_id); // Traz as paarcelas que ja estão pagas
                                        $parcelasPrevistas = $this->guia->listarparcelaspacienteprevistas($paciente_titular_id); // Traz as parcelas anteriores a data atual

                                        $parcelas_nao_paga = $this->guia->listarparcelaspacientetotal($paciente_titular_id);
                                        $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
                                        $quantidade_parcelas_pagas = $this->guia->listarparcelaspagas($paciente_titular_id);
                                        
                                        $empresa_p = $this->guia->listarempresa($titulares[0]->empresa_id_contrato);
                                         
                                       if($empresa_p[0]->tipo_carencia  == "ESPECIFICA"){ 
                                        
                                            $data_atual = date('Y-m-d');        
                                            $liberado = false;
                                            $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
                                            $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id); 
                                            $parcelas = $this->guia->listarparcelaspacientetotal($paciente_titular_id); 
                                            $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
                                            $quantidade_parcelas_pagas = $this->guia->listarparcelaspagasgeral($paciente_titular_id);        
                                            $quantidade_para_uso = $carencia[0]->quantidade_para_uso;
                                            $dias_carencia = $carencia[0]->dias_carencia;

                                            foreach ($parcelas as $valuedata) {
                                                $liberado = true;
                                                if ($valuedata->ativo == 't') {
                                                    break;
                                                }
                                            }

                                             if($liberado){
                                                $data_carencia = date('Y-m-d', strtotime("+$dias_carencia days", strtotime($valuedata->data)));
                                             }
                                             $exame_liberado = "Pendência";
                                             $consulta_liberado = "Pendência";
                                             $especialidade_liberado = "Pendência";

                                               $pg = 0;
                                             foreach($quantidade_parcelas_pagas as $value){ 
                                               if(!($value->taxa_adesao == 't')){
                                                 $pg++;  
                                               }
                                             }
                                             if (count($parcelas) == 0) {
                                                $exame_liberado = 'Liberado';
                                                $consulta_liberado = 'Liberado';
                                                $especialidade_liberado = 'Liberado'; 
                                             }elseif($liberado && count($parcelas) > 0 && strtotime($data_atual) <= strtotime($data_carencia)){
                                                $exame_liberado = 'Liberado';
                                                $consulta_liberado = 'Liberado';
                                                $especialidade_liberado = 'Liberado'; 
                                             }   
                                             if(($pg >= $quantidade_para_uso && count($parcelas) == 0) || ($liberado && count($parcelas) > 0 && strtotime($data_atual) <= strtotime($data_carencia) && $pg >= $quantidade_para_uso)){
                                                $exame_liberado = 'Liberado';
                                                $consulta_liberado = 'Liberado';
                                                $especialidade_liberado = 'Liberado'; 
                                             }else{
                                                $exame_liberado = "Pendência";
                                                $consulta_liberado = "Pendência";
                                                $especialidade_liberado = "Pendência";
                                             }  
                                             if($exame_liberado == "Liberado"){
                                             
                                               echo "<br><br><br><div id='div_mensagem'>Carencia liberada<br>";
                                             }else{
                                                   echo "<br><br><br><div id='div_mensagem'>Pendência<br>";
                                             }
                                            
                                            if(@$permissao[0]->modificar_verificar == 't'){
                                                ?>
                                              Titular:<b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarvoucher/<?= $paciente_titular_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');"><?= @$item->nome ?> (Voucher)</b><br>
                                                   <?
                                            }else{
                                                 echo "Titular:<b>" . @$item->nome . "</b><br>";  
                                            }
                                            foreach ($listadependentes as $value) {
                                                if ($value->nome != $item->nome) {
                                                    echo "Dependente:<b title='$value->nome'>" . $value->nome;
                                                    if (@$permissao[0]->modificar_verificar == 't') {
                                                        $dadosverificacao = $this->guia->verficarsituacao($value->paciente_id);
                                                    }
                                                    echo " </b>";
                                                    if (@$dadosverificacao[0]->ativo == 't') {
                                                        echo " - <a href='" . base_url() . "ambulatorio/guia/listarinfo/$value->paciente_id' target='_blank'>Documento</a>";
                                                    } else {
//                                                        echo " - <b style='color:black;'>F. autorizar</b>";
                                                    }
                                                    echo "<br>";
                                                }
                                            }
                                            echo " </div>"; 
                                            
                                            
                                       }else{
                                        
                                        //verificando se tem parcelas não pagas  com o $parcelas_nao_paga, depois verifica a quantidade de parcelas que esse paciente tem, depois verifica se a quantidade de parcelas pagas é igual a quantidade de parcelas que o paciente posssui.
                                        if (count($parcelas_nao_paga) == 0 && count($quantidade_parcelas) > 0 && count($quantidade_parcelas_pagas) == count($quantidade_parcelas)) {
                                            //caso entre aqui ele está liberado;
//                $this->verificarcpf('true', $paciente_nome_titular, $listadependentes);
                                            $carencia = 't';
                                            echo "<br><br><br><div id='div_mensagem'>Carencia liberada<br>";
                                            if(@$permissao[0]->modificar_verificar == 't'){
                                                ?>
                                              Titular:<b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarvoucher/<?= $paciente_titular_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');"><?= @$item->nome ?> (Voucher)</b><br>
                                                   <?
                                            }else{
                                                 echo "Titular:<b>" . @$item->nome . "</b><br>";  
                                            }
                                            foreach ($listadependentes as $value) {
                                                if ($value->nome != $item->nome) {
                                                    echo "Dependente:<b title='$value->nome'>" . $value->nome;
                                                    if (@$permissao[0]->modificar_verificar == 't') {
                                                        $dadosverificacao = $this->guia->verficarsituacao($value->paciente_id);
                                                    }
                                                    echo " </b>";
                                                    if (@$dadosverificacao[0]->ativo == 't') {
                                                        echo " - <a href='" . base_url() . "ambulatorio/guia/listarinfo/$value->paciente_id' target='_blank'>Documento</a>";
                                                    } else {
//                                                        echo " - <b style='color:black;'>F. autorizar</b>";
                                                    }
                                                    echo "<br>";
                                                }
                                            }
                                            echo " </div>";
                                            
                                        } else {
                                            echo "<pre>";
 
                                            if (count($parcelas) >= count($parcelasPrevistas)) { // Verifica se as parcelas estão em dia
                                                $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id);
                                                $grupo = 'CONSULTA';

                                                $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_titular_id, $grupo);
//                $listaragendamentocriado = array();
                                                // So quem pode usar da carencia são procedimentos do grupo consulta.
                                                $carencia_exame = 0; /* $carencia[0]->carencia_exame; */
                                                $carencia_exame_mensal = 0; /* $carencia[0]->carencia_exame_mensal; */
                                                $carencia_especialidade = 0; /* $carencia[0]->carencia_especialidade; */
                                                $carencia_especialidade_mensal = 0; /* $carencia[0]->carencia_especialidade_mensal; */
                                                @$carencia_consulta = $carencia[0]->carencia_consulta;
                                                @$carencia_consulta_mensal = $carencia[0]->carencia_consulta_mensal;

                                                // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
                                                if ($grupo == 'EXAME') {
                                                    $carencia = (int) $carencia_exame;
                                                    $carencia_mensal = $carencia_exame_mensal;
                                                } elseif ($grupo == 'CONSULTA') {
                                                    $carencia = (int) $carencia_consulta;
                                                    $carencia_mensal = $carencia_consulta_mensal;
                                                } elseif ($grupo == 'FISIOTERAPIA' || $grupo == 'ESPECIALIDADE') {
                                                    $carencia = (int) $carencia_especialidade;
                                                    $carencia_mensal = $carencia_especialidade_mensal;
                                                }

                                                //            var_dump($carencia_mensal); die;
                                                $parcelas_mensal = $this->guia->listarparcelaspacientemensal($paciente_titular_id);
                                                 
                                                if ($carencia_mensal == 't') {
                                                    $listaratendimentomensal = $this->guia->listaratendimentoparceiromensal($paciente_titular_id, $grupo);
                                                    //            var_dump($listaratendimentomensal);
                                                    //            die;

                                                    if (count($listaratendimentomensal) == 0 && count($parcelas_mensal) > 0) {
                                                        $carencia_mensal_liberada = 't';
                                                    } else {
                                                        $carencia_mensal_liberada = 'f';
                                                    }
                                                }
                                                $dias_parcela = 30 * count($parcelas);
                                                $dias_atendimento = $carencia * count($listaratendimento);
                                                $carencia_necessaria = $carencia * $numero_consultas_aut;
                                                 
                                                // Divide o número de dias da parcela pelo de atendimentos. Caso não exista atendimento, iguala a zero para poder entrar na condição abaixo
                                                // Abaixo tem vários var_dumps para saber algumas coisas. Eles são de deus. Eles me fizeram conseguir concluir essa parada
                                                // 
//                        echo '<pre>';
//                        var_dump($paciente_titular_id);
//                        var_dump($grupo);
//                        var_dump($carencia);
//                        var_dump($dias_parcela);
//                        var_dump($dias_atendimento);
//                        var_dump($parcelas);
//                        var_dump($parcelas_mensal);
//                        var_dump($listaratendimento);
//                        die;
                                                // Nesse caso, se o número de dias de parcela que ele tem menos o número de dias de atendimento (carência x numero de atendimentos) que ele tem for maior que a carência
                                                // o sistema vai gravar. 
                                                 
         
                                                if ($carencia_mensal == 't') {
                                                    if ($carencia_mensal_liberada == 't') {
                                                        $carencia_liberada = 't';
                                                    } else {
                                                        $carencia_liberada = 'f';
                                                    } 
                                                } else {
                                                    if ((($dias_parcela - $dias_atendimento) >= $carencia_necessaria) && $dias_parcela > 0) {
                                                        // Caso o paciente tenha carência, ele faz o exame de graça, caso não, ele cai na condição abaixo que grava na tabela exames como false
                                                        // Assim ele vai ter que pagar, porem, com um desconto cadastrado já como o valor do procedimento na clinica
                                                        $carencia_liberada = 't';
                                                    } else {
                                                        $carencia_liberada = 'f';
                                                    }
                                                    
                                                }
               
                                                //        $carencia_liberada = 'f';
                                                // Caso o cliente não tenha carência, o sistema vai buscar consultas avulsas
                                                if ($carencia_liberada == 'f') {

                                                    $listarconsultaavulsa = $this->guia->listarconsultaavulsaliberada($paciente_titular_id);
                                                    //                var_dump($listarconsultaavulsa); die;
                                                    if (count($listarconsultaavulsa) > 0) {
                                                        $consulta_avulsa_id = $listarconsultaavulsa[0]->consultas_avulsas_id;
                                                        $tipo_consulta = $listarconsultaavulsa[0]->tipo;
                                                        $carencia_liberada = 't';
                                                    } else {
                                                        $tipo_consulta = '';
                                                    }
                                                } else {
                                                    @$listarconsultaavulsa = array();
                                                    @$tipo_consulta = '';
                                                }
                                                
                                                
                                                
                                            //   $empresa_p = $this->guia->listarempresa();
                                               $empresa_p = $this->guia->listarempresa($item->empresa_id_contrato);
                                            //   print_r($titulares); 
                                                
                                                

                                                /* Se no fim das contas se tudo der errado, a variável carencia_liberada vai conter a informacao 'f'que irá ser salva na linha da consulta
                                                  no banco, para dessa forma o sistema cobrar o valor do exame ao invés de utilizar da carência */

                                                
                                                if ($carencia_liberada == 't') {
                                                     $carencia = 'true';
                                                     echo "<br><br><br><div id='div_mensagem'>Carencia liberada<br>";                                                    
                                                     if(@$permissao[0]->modificar_verificar == 't'){  ?>
                                                       Titular:<b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarvoucher/<?= $paciente_titular_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');"><?= @$item->nome ?> (Voucher)</b><br>
                                                            <?
                                                     }else{
                                                          echo "Titular:<b>" . @$item->nome . "</b><br>";  
                                                     }
                                                    foreach ($listadependentes as $value) {
                                                        if ($value->nome != $item->nome) {

                                                            echo "Dependente:<b title='$value->nome'>" . $value->nome;
                                                            if (@$permissao[0]->modificar_verificar == 't') {
                                                                $dadosverificacao = $this->guia->verficarsituacao($value->paciente_id);
                                                            }
                                                            echo " </b>";
                                                            if (@$dadosverificacao[0]->ativo == 't') {
                                                                if (@$dadosverificacao[0]->operador_autorizacao_manual != "") {
                                                                    @$addcolum = "sim";
                                                                } else {
                                                                    @$addcolum = "";
                                                                }
                                                                echo " - <a href='" . base_url() . "ambulatorio/guia/listarinfo/$value->paciente_id/$addcolum' target='_blank'>Documento</a>";
                                                            } else {
//                                                        echo " - <b style='color:black;'>F. autorizar</b>";
                                                            }
                                                            echo "<br>";
                                                        }
                                                    }
                                                    echo " </div>";
                                                } else {
//                    echo json_encode('false');
//                        $this->verificarcpf('false');
                                                    $carencia = 'false';

                                                    echo "<br><br><br><div id='div_mensagem'>Carência não-liberada <br>";
                                            if(@$permissao[0]->modificar_verificar == 't'){
                                                ?>
                                              Titular:<b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarvoucher/<?= $paciente_titular_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');"><?= @$item->nome ?> (Voucher)</b><br>
                                                   <?
                                            }else{
                                                 echo "Titular:<b>" . @$item->nome . "</b><br>";  
                                            }
                                                    foreach ($listadependentes as $value) {
                                                        if ($value->nome != $item->nome) {
                                                            echo "Dependente:<b title='$value->nome'>" . $value->nome;
                                                            echo "</b><br>";
                                                        }
                                                    }
                                                    echo " </div>";
                                                }
                                            } else {
//                echo json_encode('pending');
//                    $this->verificarcpf('pending');
                                                $carencia = 'pending';


                                                echo "<br><br><br><div id='div_mensagem'>Pendência<br>";
                                              if(@$permissao[0]->modificar_verificar == 't'){
                                                ?>
                                              Titular:<b onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/listarvoucher/<?= $paciente_titular_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');"><?= @$item->nome ?>  (Voucher)</b><br>
                                                   <?
                                            }else{
                                                 echo "Titular:<b>" . @$item->nome . "</b><br>";  
                                            }
                                                foreach ($listadependentes as $value) {
                                                    if ($value->nome != $item->nome) {
                                                        echo "Dependente:<b title='$value->nome'>" . $value->nome;
                                                        echo "</b><br>";
                                                    }
                                                }
                                                echo " </div>";
                                            }
                                        }
                                    }
                                        
                                        
                                        
                                        
                                        
                                    } else {
//            echo json_encode('no_exists');
//            $this->verificarcpf('no_exists');
                                        $carencia = 'no';
                                    }
                                }
                            }
                            ?>

                            <?php
                            $listarempresalogada = $this->empresa->listarempresalogada();
                            if (count(@$titulares) <= 0 && @$mensagem == "") {
                                echo "<br><br><br><div id='div_mensagem'>  ";
                                echo "Cliente não Cadastrado<br>Favor verificar junto a empresa<br>" . @$listarempresalogada[0]->nome . "<br>";
                                echo " </div>";
                            }
                            ?>


                            <div id="mensagem_lado">
                                <?php
                                if (strlen(@$mensagem)) {
                                    $divMensagem = "<div id='div_mensagem'>" . @$mensagem . "</div>";
                                    echo $divMensagem;
                                    unset($mensagem);
                                }
                                ?>

                            </div>



                            </body>
                            </html>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                            
                            <script type="text/javascript">
                                




                    //    document.addEventListener('click', function (e) {
                    //
                    //        var self = e.target;
                    //
                    //        if (['cpf', 'paciente_id'].indexOf(self.id) !== -1) {
                    //            var el = document.getElementById(self.id === 'cpf' ? 'paciente_id' : 'cpf');
                    //
                    //            self.removeAttribute('disabled');
                    //
                    //            el.setAttribute('disabled', '');
                    //            el.value = "";
                    //        }
                    //    })






                    $(document).ready(function () {
                        jQuery('#form_login').validate({
                            rules: {
                                txtLogin: {
                                    required: true,
                                    minlength: 3
                                },
                                txtSenha: {
                                    required: true,
                                    minlength: 3
                                },
                                txtempresa: {
                                    required: true,
                                    minlength: 1
                                }
                            },
                            messages: {
                                txtLogin: {
                                    required: "",
                                    minlength: "!"
                                },
                                txtSenha: {
                                    required: "",
                                    minlength: "!"
                                },
                                txtempresa: {
                                    required: "",
                                    minlength: "!"
                                }
                            }
                        });
                    });

                            </script>
