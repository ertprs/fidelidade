
<div class="content"> <!-- Inicio da DIV content -->


    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Toten</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            ?>
            <table>
                
                <tr>
                <td style="width: 70px;">
                    <div class="bt_link_new" >
                        <a onclick="javascript: return confirm('Deseja realmente excluir as senhas?');" href="<?= base_url() ?>ambulatorio/exame/excluirsenhastoten"  >
                        Excluir Senhas
                        </a>
                    </div>
                </td> 
                <td style="width: 70px;">
                    <div class="bt_link_new" >
                        <a onclick="javascript: return confirm('Deseja realmente excluir os chamados?');" href="<?= base_url() ?>ambulatorio/exame/excluirchamadototen"  >
                        Excluir Chamados
                        </a>
                    </div>
                </td> 
                <td style="width: 70px;">
                    <div class="bt_link_new" >
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/exame/mantersalastoten">
                        Manter Salas
                        </a>
                    </div>
                </td> 
                <td style="width: 70px;">
                    <div class="bt_link_new" >
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/exame/mantertelastoten" id="botaochamarunico" >
                        Manter Telas
                        </a>
                    </div>
                </td> 

                </tr>
            </table>
            <form id="formIdFila">
                <input type="hidden" name="IdFila" id="IdFila">
                <input type="hidden" name="SenhaFila" id="SenhaFila">
            </form>
            
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

 

</script>
