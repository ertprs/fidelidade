 
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Gerar BPA</a></h3>
        <div> 
            <?
            $salas = $this->exame->listartodassalas();
            $convenios = $this->convenio->listarconvenionaodinheiro();
            $medicos = $this->operador_m->listarmedicos();
            $classificacao = $this->guia->listarclassificacao();
            $empresa = $this->guia->listarempresas();
            $guia = "";
            ?>
            <form method="post" action="<?= base_url() ?>ambulatorio/exame/gerarbpa" target="_blank" >
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1" required=""/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datafim" alt="date" name="datafim" class="size1" required=""/>
                    </dd>
                    <dt>
                        <label>Nome Arquivo</label>
                    </dt>
                    <dd>
                        <input type="text"  id="paciente" name="paciente" class="size3"/>
                    </dd>
                    <dt>
                        <label>Faturamento</label>
                    </dt>
                    <dd>
                        <select name="faturamento" id="faturamento" class="size2" >
                            <option value='0' >TODOS</option>
                            <option value='t' >Faturado</option>
                            <option value='f' >Nao Faturado</option>
                        </select>
                    </dd> 
                    <dt>
                        <label title="Boletim de Produção Ambulatorial">BPA</label>
                    </dt>
                    <dd>
                        <select name="bpa" id="bpa" class="size2" >
                            <option value='bpa-c'title="BPA-C (Boletim de Produção Ambulatorial CONSOLIDADO)" >CONSOLIDADO</option>
                            <option value='bpa-i' title="BPA-I (Boletim de Produção Ambulatorial INDIVIDUALIZADA)" >INDIVIDUALIZADA</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value="" >TODOS</option>
                            <? foreach ($convenios as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >SEM RETORNO</option>
                            <? foreach ($classificacao as $value) : ?>
                                <option value="<?= $value->tuss_classificacao_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd> 
                    <dt>
                        <label>Apagar</label>
                    </dt>
                    <dd>
                        <select name="apagar" id="apagar" class="size2">
                            <option value=0 >NAO</option>
                            <option value=1 >SIM</option>
                        </select>
                    </dd> 
<!--                    <dt>
                        <label>Autorização</label>
                    </dt>-->
<!--                    <dd>
                        <select name="autorizacao" id="autorizacao" class="size2">
                            <option value='NAO'>NÃO</option>
                            <option value='SIM' >SIM</option>
                        </select>
                    </dd> -->
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd> 
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <!--<option value="0">TODOS</option>-->
                        </select>
                    </dd>
                    <dt>
                        <label title="PDF ou PLANILHA">Gerar</label>
                    </dt>
                    <dd>
                        <select name="gerararq" id="gerararq" class="size2">
                           
                            <option value="gerarpdfs">PDF</option>
                            <option value="gerarplanilhas">PLANILHA</option>
                            <!--<option value="arqtexto">Arquivo de texto</option>-->
                        </select>
                    </dd>
                </dl>
                <button type="submit" id="enviar" onClick='refresh()'>Gerar</button>
            </form>
        </div>
        <h3 class="singular"><a href="#">Arquivos </a></h3> 
        <div>
            <table border="2">
                <tr>
                    <td class="tabela_header" ><b>Consolidado</b></td>
                </tr>
                <tr>
               
                    <?
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("./upload/bpa/consolidado/");
                    if ($arquivo_pasta != false) {
                        ?>


                        <?
                        foreach ($arquivo_pasta as $value) {
                            ?>
                    <td width="10px">
                       
                        <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/bpa/consolidado/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?php echo base_url(); ?>img/archive-zip-icon.png"><br><? echo $value ?>
             
                    </td> 
                    <td>&nbsp;</td>        
                        
                <br><?
                    }
                }
                ?> 
                </tr>   
                <tr>
                    <td  class="tabela_header">  <b>Individualizada</b></td>
                </tr> 
                <tr> 
                    <?
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("./upload/bpa/individualizada/");
                    if ($arquivo_pasta != false) {
                        ?>
                        <?
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <td width="10px"> <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/bpa/individualizada/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?php echo base_url(); ?>img/archive-zip-icon.png"><br><? echo $value ?></td>
                            <td>&nbsp;</td>        
                        <br>   
                      <?
                    }
                }
                ?>
                </tr>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
function refresh() {

    setTimeout(function () {
        location.reload()
    }, 5000);
}
                        $(function () {
                            $("#datainicio").datepicker({
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
                            $("#datafim").datepicker({
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

</script>
