<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Voltar
        </a>
    </div>
    <?
    $args['paciente'] = $paciente_id;
    $empresa_p = $this->guia->listarempresa();
    $perfil_id = $this->session->userdata('perfil_id');
    $internacao = $this->session->userdata('internacao');
    ?>
    <?
    //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
    //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
    $paciente_informacoes = $this->paciente->listardados($paciente_id);
    if ($paciente_informacoes[0]->situacao == 'Dependente') {
        $dependente = true;
    } else {
        $dependente = false;
    }


    if ($dependente == true) {
        $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
//        $paciente_id = $retorno[0]->paciente_id;
        @$paciente_titular_id = $retorno[0]->titular_id;
        @$paciente_contrato_id = $retorno[0]->paciente_contrato_id;
        $paciente_dependente_id = $paciente_id;
    } else {
//        $paciente_id = $_POST['txtNomeid'];
        $paciente_titular_id = $paciente_id;
        $paciente_dependente_id = null;
    }


//        var_dump($_POST['txtNomeid']);
//        var_dump($paciente_id);
//        die;
//        $paciente_id = $_POST['txtNomeid'];




    $parcelas = $this->guia->listarparcelaspaciente($paciente_titular_id);
    // print_r($parcelas);
    $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id);
    // print_r($carencia);


    if ($empresa_p[0]->tipo_carencia == "SOUDEZ") {

        $listaratendimentoexame = $this->guia->listaratendimentoparceiro($paciente_titular_id, 'EXAME');
        $listaratendimentoconsulta = $this->guia->listaratendimentoparceiro($paciente_titular_id, 'CONSULTA');
        $listaratendimentoespecialidade = $this->guia->listaratendimentoparceiro($paciente_titular_id, 'ESPECIALIDADE');
        @$carencia_exame = $carencia[0]->carencia_exame;
        @$carencia_consulta = $carencia[0]->carencia_consulta;
        @$carencia_especialidade = $carencia[0]->carencia_especialidade;

        $dias_parcela = 30 * count($parcelas);
        $dias_atendimentoexame = $carencia_exame * count($listaratendimentoexame);
        $dias_atendimentoconsulta = $carencia_consulta * count($listaratendimentoconsulta);
        $dias_atendimentoespecialidade = $carencia_especialidade * count($listaratendimentoespecialidade);
        // Divide o número de dias da parcela pelo de atendimentos. Caso não exista atendimento, iguala a zero para poder entrar na condição abaixo
        // Abaixo tem vários var_dumps para saber algumas coisas. Eles são de deus. Eles me fizeram conseguir concluir essa parada
        // 
        //        echo '<pre>';
        //        var_dump($parcelas);
        //        var_dump($atendimento_parcela);
        //        var_dump($dias_parcela);
        //        var_dump($carencia);
        //        var_dump($dias_atendimentoexame);
        //        var_dump($listaratendimento);
        //        die;
        // Nesse caso, se o número de dias de parcela que ele tem menos o número de dias de atendimento (carência x numero de atendimentos) que ele tem for maior que a carência
        // o sistema vai gravar. 
        //
      
        if (($dias_parcela - $dias_atendimentoexame) >= $carencia_exame) {
            $exame_liberado = 'Liberado';
        } else {
            $exame_liberado = 'Pendência';
        }
        if (($dias_parcela - $dias_atendimentoconsulta) >= $carencia_consulta) {
            $consulta_liberado = 'Liberado';
        } else {
            $consulta_liberado = 'Pendência';
        }
        if (($dias_parcela - $dias_atendimentoespecialidade) >= $carencia_especialidade) {
            $especialidade_liberado = 'Liberado';
        } else {
            $especialidade_liberado = 'Pendência';
        }
    } else {

        $parcelas = $this->guia->listarparcelaspacientetotal($paciente_titular_id);
        $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id);
        $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
        $quantidade_parcelas_pagas = $this->guia->listarparcelaspagas($paciente_titular_id);

        if ($this->session->userdata('cadastro') == 2 && $dependente == true) {
            $parcelas = $this->guia->listarparcelaspacientetotal($paciente_titular_id, $paciente_contrato_id, $dependente);
            $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id, $paciente_contrato_id, $dependente);
            $quantidade_parcelas_pagas = $this->guia->listarparcelaspagas($paciente_titular_id, $paciente_contrato_id, $dependente);
        }

//        echo "<pre>"; 
//        print_r($parcelas);
//        die;

        $exame_liberado = 'Pendência';
        $consulta_liberado = 'Pendência';
        $especialidade_liberado = 'Pendência';

        $liberado = false;
        if (@$carencia[0]->carencia_exame != "") {
            $carencia_exame = $carencia[0]->carencia_exame;
        } else {
            $carencia_exame = 0;
        }

        if (@$carencia[0]->carencia_consulta != "") {
            $carencia_consulta = $carencia[0]->carencia_consulta;
        } else {
            $carencia_consulta = 0;
        }

        if (@$carencia[0]->carencia_especialidade != "") {
            $carencia_especialidade = $carencia[0]->carencia_especialidade;
        } else {
            $carencia_especialidade = 0;
        }

 

        // Se alguma das parcelas não tiver sido paga, o sistema não vai retornar true pra carencia
        foreach ($parcelas as $item) {
            $liberado = true;
            if ($item->ativo == 't') {
                break;
            }
        }


        if (count($parcelas) == 0 && count($quantidade_parcelas) > 0 && count($quantidade_parcelas_pagas) == count($quantidade_parcelas)) {

            $exame_liberado = 'Liberado';
            $consulta_liberado = 'Liberado';
            $especialidade_liberado = 'Liberado';
            $liberado = true;
        } else {
            // Se tiverem parcelas, vai pegar a ultima parcela do foreach acima e usa a data abaixo.
            if (count($parcelas) > 0 && $liberado) {
                $data_atual = date("Y-m-d");

                $data_exame = date('Y-m-d', strtotime("-$carencia_exame days", strtotime($item->data)));
                $data_consulta = date('Y-m-d', strtotime("-$carencia_consulta days", strtotime($item->data)));
                $data_especialidade = date('Y-m-d', strtotime("-$carencia_especialidade days", strtotime($item->data)));
//                                var_dump($parcelas);
//                                echo '-------------';
//                                var_dump(strtotime($data_atual));
//                die;
                if (strtotime($data_atual) <= strtotime($data_exame)) {
                    $exame_liberado = 'Liberado';
                }
                if (strtotime($data_atual) <= strtotime($data_consulta)) {
                    $consulta_liberado = 'Liberado';
                }
                if (strtotime($data_atual) <= strtotime($data_especialidade)) {
                    $especialidade_liberado = 'Liberado';
                }
            } else {
                $exame_liberado = 'Pendência';
                $consulta_liberado = 'Pendência';
                $especialidade_liberado = 'Pendência';
            }
        }

        // echo '<pre>';
        // // var_dump($parcelas); 
        // var_dump($liberado); 
        // var_dump($item->data); 
        // die;
    }
    ?> 
    <fieldset>
        <legend>Solicita&ccedil;&otilde;es do Cliente</legend>
        <div>
            <table>
                <tr><td width="100px;"><div class="bt_linkm"><a href="<?= base_url() ?>ambulatorio/guia/pesquisar/<?= $args['paciente'] ?>">Contrato</a></div></td>
                    <? if ($perfil_id == 1) { ?> 
                        <td width="100px;"><div class="bt_linkm"><a onclick="javascript: return confirm('Deseja realmente excluir o cliente?');" href="<?= base_url() ?>ambulatorio/exametemp/excluirpaciente/<?= $paciente_id ?>">Excluir</a></div></td>
                    <?php } ?>
                    <td width="100px;">
                        <div class="bt_linkm">
                            <a  onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaodeclaracaopaciente/<?= $paciente_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=1000');">Declaração</a>

                        </div></td>



                    <? if ($perfil_id == 1) { ?>             
                        <td width="900px;" style="font-family: arial; font-size: 13px;"><div class="">  
                                VENDEDOR : <?= @$paciente[0]->vendedor_nome; ?> 
                            </div></td>

                            <td width="900px;" style="font-family: arial; font-size: 13px;"><div class="">  
                                INDICAÇÃO : <?= @$paciente[0]->nome_indicacao; ?> 
                            </div></td>
                    <? }
                    ?>
                </tr>
            </table>            
        </div>

    </fieldset>
    <div>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
            <fieldset>
                <legend>Dados do Cliente</legend>
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
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
                <div>
                    <label>Nome do Pai</label>


                    <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
                </div>
                <div>
                    <label>CNS</label>


                    <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
                </div>

            </fieldset>
            <?
            // if($empresa[0]->relacao_carencia == 't'){
            ?>
            <fieldset>
                <legend>Situação de pagamento em relação a carência</legend>
                <table border="1">
                    <tr>
                        <td style="width: 200px">
                            Carência Exame   
                        </td>
                        <td>
                            <?= $exame_liberado ?>     
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Carência Consulta    
                        </td>
                        <td>
                            <?= $consulta_liberado ?>       
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Carência Especialidade    
                        </td>
                        <td>
                            <?= $especialidade_liberado ?>       
                        </td>
                    </tr>
                </table>

            </fieldset>
            <? 
        // } 
        ?>
            <fieldset>
                <legend>Documentos</legend>
                <div>
                    <? if ($paciente['0']->cpf_responsavel_flag == 't') { ?>
                        <label>CPF do Resposável</label>
                    <? } else { ?>
                        <label>CPF</label>
                    <? } ?>

                    <? if (strlen($paciente['0']->cpf) <= 11) { ?>
                        <input type="text" name="cpf" id ="txtCpf"  alt="cpf" class="texto04" value="<?= $paciente['0']->cpf; ?>" readonly/>   
                    <? } else { ?>
                        <input type="text" name="cpf" id ="txtCpf"  alt="cnpj" class="texto04" value="<?= $paciente['0']->cpf; ?>" readonly/>   
                    <? } ?>

                </div>
                <div>
                    <label>RG</label>


                    <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= $paciente['0']->rg; ?>" readonly/>
                </div>
                <div>
                    <label>UF Expedidor</label>


                    <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" value="<?= $paciente['0']->uf_rg; ?>" readonly/>
                </div>
                <div>
                    <div>
                        <label>Data Emiss&atilde;o</label>


                        <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr($paciente['0']->data_emissao, 8, 2) . '/' . substr($paciente['0']->data_emissao, 5, 2) . '/' . substr($paciente['0']->data_emissao, 0, 4); ?>" readonly/>
                    </div>

                    <div>

                        <label>T. Eleitor</label>


                        <input type="text"   name="titulo_eleitor" id="txtTituloEleitor" class="texto02" value="<?= $paciente['0']->titulo_eleitor; ?>" readonly/>
                    </div>




            </fieldset>
            <fieldset>
                <legend>Domicilio</legend>

                <div>
                    <label>Endere&ccedil;o</label>


                    <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= $paciente['0']->logradouro; ?>" readonly/>
                </div>
                <div>
                    <label>N&uacute;mero</label>


                    <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= $paciente['0']->numero; ?>" readonly/>
                </div>
                <div>
                    <label>Bairro</label>


                    <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= $paciente['0']->bairro; ?>" readonly/>
                </div>
                <div>
                    <label>Complemento</label>


                    <input type="text" id="txtComplemento" class="texto06" name="complemento" value="<?= $paciente['0']->complemento; ?>" readonly/>
                </div>

                <div>
                    <label>CEP</label>


                    <input type="text" id="txtCep" class="texto02" name="cep" alt="cep" value="<?= $paciente['0']->cep; ?>" readonly/>
                </div>


                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= $paciente['0']->telefone; ?>" readonly/>
                </div>
                <div>
                    <label>Celular</label>


                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= $paciente['0']->celular; ?>" readonly/>
                </div>
                <div>
                    <label>Observa&ccedil;&otilde;es</label>


                    <input type  ="text" name="observacao" id="txtObservacao" class="texto10"  value ="<?= $paciente['0']->observacao; ?>" readonly/>

                </div>
            </fieldset>

    </div>
    <div class="clear"></div>
</div>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script type="text/javascript">

</script>