
<meta charset="utf-8">
<div id="tabs-a">
    <fieldset>
        <legend><b><font size="3" color="red">Historico de consultas</font></b></legend>
        <div>
            <?
// Esse código serve para mostrar os históricos que foram importados
// De outro sistema STG.
// Na hora que o médico finaliza o atendimento, o sistema manda os dados para o endereço do sistema
// Digitado no cadastro do médico, caso exista ele salva numa tabela especifica.
// Para não criar um outro local onde iriam aparecer os atendimentos dessa tabela 
// Há essa lógica aqui embaixo para inserir no meio dos outros atendimentos da ambulatorio_laudo os outros
// da integração
            $contador_teste = 0;
// Contador para utilizar no array
//                            $historico = array();
            foreach ($historico as $item) {
                // Verifica se há informação
                if (isset($historicowebcon[$contador_teste])) {
                    // Define as datas
                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                    $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data));
                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                    while ($data_while > $data_foreach) {
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td ><span style="color: #007fff">Integração</span></td>
                                </tr>
                                <tr>
                                    <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                                </tr>
                                <tr>
                                    <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                                </tr>
                                <?
                                $idade = 0;
                                $dataFuturo2 = $historicowebcon[$contador_teste]->data;
                                $dataAtual2 = @$obj->_nascimento;
                                if ($dataAtual2 != '') {
                                    $date_time2 = new DateTime($dataAtual2);
                                    $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                                    $teste2 = $diff2->format('%Y');
                                    $idade = $teste2;
                                }
                                ?>
                                <tr>
                                    <td >Idade no atendimento: <?= $idade ?> Anos</td>
                                </tr>
                                <tr>
                                    <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                                </tr>

                                <tr>
                                    <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                                </tr>
                                <tr>
                                    <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <?
                        $contador_teste ++;
                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                        if (isset($historicowebcon[$contador_teste])) {
                            $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data_cadastro));
                        } else {
                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                            break;
                        }
                    }
                }
                ?>
                <table>
                    <tbody>
                        <tr>
                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        </tr>
                        <?
                        $idade = 0;
                        $dataFuturo2 = $item->data_cadastro;
                        $dataAtual2 = @$obj->_nascimento;
                        if ($dataAtual2 != '') {
                            $date_time2 = new DateTime($dataAtual2);
                            $diff2 = $date_time2->diff(new DateTime($dataFuturo2));
                            $teste2 = $diff2->format('%Y');
                            $idade = $teste2;
                        }
                        ?>
                        <tr>
                            <td >Idade no atendimento: <?= $idade ?> Anos</td>
                        </tr>
                        <tr>
                            <td >Medico: <?= $item->medico; ?></td>
                        </tr>
                        <tr>
                            <td >Tipo: <?= $item->procedimento; ?></td>
                        </tr>
                        <tr>
                            <td >Queixa principal: <?= $item->texto; ?></td>
                        </tr>
                        <tr>
                            <td>Arquivos anexos:
                                <?
                                $this->load->helper('directory');
                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");


                                $w = 0;
                                if ($arquivo_pasta != false):
                                    foreach ($arquivo_pasta as $value) :
                                        $w++;
                                        ?>

                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                        <?
                                        if ($w == 8) {
                                            
                                        }
                                    endforeach;
                                    $arquivo_pasta = "";
                                endif
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            <? }
            ?>
        </div>
        <?
        if (count($historico) == 0 || $contador_teste < count($historicowebcon)) {
            while ($contador_teste < count($historicowebcon)) {
                ?>
                <table>
                    <tbody>
                        <tr>
                            <td><span style="color: #007fff">Integração</span></td>
                        </tr>
                        <tr>
                            <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                        </tr>
                        <tr>
                            <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                        </tr>
                        <tr>
                            <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                        </tr>

                        <tr>
                            <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                        </tr>
                        <tr>
                            <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                        </tr>

                    </tbody>
                </table>
                <hr>

                <?
                $contador_teste++;
            }
        }
        ?>



    </fieldset>

    <fieldset>
        <legend><b><font size="3" color="red">Historico de exames</font></b></legend>
        <div>

            <?
            $contador_exame = 0;
            foreach ($historicoexame as $item) {
                // Verifica se há informação
                if (isset($historicowebexa[$contador_exame])) {
                    // Define as datas
                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                    $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data));
                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                    while ($data_while > $data_foreach) {
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td ><span style="color: #007fff">Integração</span></td>
                                </tr>
                                <tr>
                                    <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                                </tr>
                                <tr>
                                    <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                                </tr>
                                <tr>
                                    <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                                </tr>

                                <tr>
                                    <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                                </tr>
                                <tr>
                                    <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <?
                        $contador_exame ++;
                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                        if (isset($historicowebexa[$contador_exame])) {
                            $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data_cadastro));
                        } else {
                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                            break;
                        }
                    }
                }
                ?>
                <table>
                    <tbody>


                        <tr>
                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        </tr>
                        <tr>
                            <td >Medico: <?= @$item->medico; ?></td>
                        </tr>
                        <tr>
                            <td >Tipo: <?= @$item->procedimento; ?></td>
                        </tr>
                        <tr>
                            <?
                            $this->load->helper('directory');
                            $arquivo_pastaimagem = directory_map("./upload/$item->exames_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
                            if ($arquivo_pastaimagem != false) {
                                sort($arquivo_pastaimagem);
                            }
                            $i = 0;
                            if ($arquivo_pastaimagem != false) {
                                foreach ($arquivo_pastaimagem as $value) {
                                    $i++;
                                }
                            }
                            ?>
                            <td >Imagens : <font size="2"><b> <?= $i ?></b>
                                <?
                                if ($arquivo_pastaimagem != false):
                                    foreach ($arquivo_pastaimagem as $value) {
                                        ?>
                                        <a onclick="javascript:window.open('<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?>"></a>
                                        <?
                                    }
                                    $arquivo_pastaimagem = "";
                                endif
                                ?>
                                <!--                <ul id="sortable">

                                                </ul>-->
                            </td >
                        </tr>
                        <tr>
                            <td >Laudo: <?= $item->texto; ?></td>
                        </tr>
                        <tr>
                            <td>Arquivos anexos:
                                <?
                                $this->load->helper('directory');
                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                $w = 0;
                                if ($arquivo_pasta != false):

                                    foreach ($arquivo_pasta as $value) :
                                        $w++;
                                        ?>

                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                        <?
                                        if ($w == 8) {
                                            
                                        }
                                    endforeach;
                                    $arquivo_pasta = "";
                                endif
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style='width:10pt;border:solid windowtext 1.0pt;
                                border-bottom:none;mso-border-top-alt:none;border-left:
                                none;border-right:none;' colspan="10">&nbsp;</th>
                        </tr>


                    </tbody>
                </table>
            <? }
            ?>
            <?
            if (count($historico) == 0 || $contador_exame < count($historicowebexa)) {
                while ($contador_exame < count($historicowebexa)) {
                    ?>
                    <table>
                        <tbody>
                            <tr>
                                <td><span style="color: #007fff">Integração</span></td>
                            </tr>
                            <tr>
                                <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                            </tr>
                            <tr>
                                <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                            </tr>
                            <tr>
                                <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                            </tr>

                            <tr>
                                <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                            </tr>
                            <tr>
                                <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                            </tr>

                        </tbody>
                    </table>
                    <hr>

                    <?
                    $contador_exame++;
                }
            }
            ?>
        </div>

    </fieldset>
    <fieldset>
        <legend><b><font size="3" color="red">Historico de especialidades</font></b></legend>
        <div>

            <?
            $contador_especialidade = 0;
            foreach ($historicoespecialidade as $item) {
                // Verifica se há informação
                if (isset($historicowebesp[$contador_especialidade])) {
                    // Define as datas
                    $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                    $data_while = date("Y-m-d", strtotime($historicowebesp[$contador_especialidade]->data));
                    // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                    while ($data_while > $data_foreach) {
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td ><span style="color: #007fff">Integração</span></td>
                                </tr>
                                <tr>
                                    <td >Empresa: <?= $historicowebesp[$contador_especialidade]->empresa; ?></td>
                                </tr>
                                <tr>
                                    <td >Data: <?= substr($historicowebesp[$contador_especialidade]->data, 8, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 5, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 0, 4); ?></td>
                                </tr>
                                <tr>
                                    <td >Medico: <?= $historicowebesp[$contador_especialidade]->medico_integracao; ?></td>
                                </tr>

                                <tr>
                                    <td >Tipo: <?= $historicowebesp[$contador_especialidade]->procedimento; ?></td>
                                </tr>
                                <tr>
                                    <td >Queixa principal: <?= $historicowebesp[$contador_especialidade]->texto; ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                        <?
                        $contador_especialidade ++;
                        // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                        if (isset($historicowebesp[$contador_especialidade])) {
                            $data_while = date("Y-m-d", strtotime($historicowebesp[$contador_especialidade]->data_cadastro));
                        } else {
                            // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                            break;
                        }
                    }
                }
                ?>
                <table>
                    <tbody>


                        <tr>
                            <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                        </tr>
                        <tr>
                            <td >Medico: <?= $item->medico; ?></td>
                        </tr>
                        <tr>
                            <td >Tipo: <?= $item->procedimento; ?></td>
                        </tr>
                        <tr>
                            <?
                            $this->load->helper('directory');
                            $arquivo_pastaimagem = directory_map("./upload/$item->exames_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$especialidade_id/");
                            if ($arquivo_pastaimagem != false) {
                                sort($arquivo_pastaimagem);
                            }
                            $i = 0;
                            if ($arquivo_pastaimagem != false) {
                                foreach ($arquivo_pastaimagem as $value) {
                                    $i++;
                                }
                            }
                            ?>
                            <td >Imagens : <font size="2"><b> <?= $i ?></b>
                                <?
                                if ($arquivo_pastaimagem != false):
                                    foreach ($arquivo_pastaimagem as $value) {
                                        ?>
                                        <a onclick="javascript:window.open('<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?>"></a>
                                        <?
                                    }
                                    $arquivo_pastaimagem = "";
                                endif
                                ?>
                                <!--                <ul id="sortable">

                                                </ul>-->
                            </td >
                        </tr>
                        <tr>
                            <td >Laudo: <?= $item->texto; ?></td>
                        </tr>
                        <tr>
                            <td>Arquivos anexos:
                                <?
                                $this->load->helper('directory');
                                $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                $w = 0;
                                if ($arquivo_pasta != false):

                                    foreach ($arquivo_pasta as $value) :
                                        $w++;
                                        ?>

                                        <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                        <?
                                        if ($w == 8) {
                                            
                                        }
                                    endforeach;
                                    $arquivo_pasta = "";
                                endif
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style='width:10pt;border:solid windowtext 1.0pt;
                                border-bottom:none;mso-border-top-alt:none;border-left:
                                none;border-right:none;' colspan="10">&nbsp;</th>
                        </tr>


                    </tbody>
                </table>
            <? }
            ?>
            <?
            if (count($historico) == 0 || $contador_especialidade < count($historicowebesp)) {
                while ($contador_especialidade < count($historicowebesp)) {
                    ?>
                    <table>
                        <tbody>
                            <tr>
                                <td><span style="color: #007fff">Integração</span></td>
                            </tr>
                            <tr>
                                <td >Empresa: <?= $historicowebesp[$contador_especialidade]->empresa; ?></td>
                            </tr>
                            <tr>
                                <td >Data: <?= substr($historicowebesp[$contador_especialidade]->data, 8, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 5, 2) . "/" . substr($historicowebesp[$contador_especialidade]->data, 0, 4); ?></td>
                            </tr>
                            <tr>
                                <td >Medico: <?= $historicowebesp[$contador_especialidade]->medico_integracao; ?></td>
                            </tr>

                            <tr>
                                <td >Tipo: <?= $historicowebesp[$contador_especialidade]->procedimento; ?></td>
                            </tr>
                            <tr>
                                <td >Queixa principal: <?= $historicowebesp[$contador_especialidade]->texto; ?></td>
                            </tr>

                        </tbody>
                    </table>
                    <hr>

                    <?
                    $contador_especialidade++;
                }
            }
            ?>
        </div>

    </fieldset>
</div>

<fieldset>
    <legend><b><font size="3" color="red">Arquivos Anexados Paciente</font></b></legend>
    <table>
        <tr>
            <?
            $l = 0;
            if ($arquivos_paciente != false):
                foreach ($arquivos_paciente as $value) :
                    $l++;
                    ?> 
                    <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br> </td>
                    <?
                    if ($l == 8) {
                        ?>
                    </tr><tr>
                        <?
                    }
                endforeach;
            endif
            ?>
    </table>
</fieldset>
<fieldset>
    <legend><b><font size="3" color="red">Arquivos Anexados Laudo</font></b></legend>
    <table>
        <tr>
            <?
            $o = 0;
            
            
            if ($arquivos_anexados != false):
                foreach (@$arquivos_anexados as $value) :
                    $o++;
                    ?>

                    <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . @$ambulatorio_laudo_id . "/" . @$value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/consulta/" . @$ambulatorio_laudo_id . "/" . @$value ?>"><br><? echo substr(@$value, 0, 10) ?><br></td>
                    <?
                    if ($o == 8) {
                        ?>
                    </tr><tr>
                        <?
                    }
                endforeach;
            endif;
                
                
                
             
            ?>
    </table>
</fieldset>
<!--<a href="<?= base_url() ?>ambulatorio/laudo/excluirimagemlaudo/<?= @$ambulatorio_laudo_id ?>/<?= @$value ?>">Excluir</a>-->
<fieldset>
    <legend><b><font size="3" color="red">Digitaliza&ccedil;&otilde;es</font></b></legend>
    <div>
        <table>
            <tbody>

                <tr>
                    <td>
                        <?
                        $this->load->helper('directory');
                        $arquivo_pasta = directory_map("./upload/paciente/$paciente_id/");

                        $w = 0;
                        if ($arquivo_pasta != false):

                            foreach ($arquivo_pasta as $value) :
                                $w++;
                                ?>

                            <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?></td>
                            <?
                            if ($w == 8) {
                                
                            }
                        endforeach;
                        $arquivo_pasta = "";
                    endif
                    ?>
                    </td>
                </tr>



            </tbody>
        </table>
    </div>

</fieldset>

 