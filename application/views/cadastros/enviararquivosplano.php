<div class="content"> <!-- Inicio da DIV content -->

    <? $perfil_id = $this->session->userdata('perfil_id'); ?>
    <div id="accordion">
        <h3><a href="#">Carregar Arquivos </a></h3>
        <div >
            <?= form_open_multipart(base_url() . "cadastros/formapagamento/importararquivos/$plano_id"); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" multiple="" name="userfile"/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="plano_id" value="<?= $plano_id; ?>" />
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar imagens </a></h3>
        <div >
            <table>
                <tr>
                    <?
                    $i = 0;
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) :
                            $i++;
                            ?>

                            <td width="10px"><img  width="50px" height="50px" 
                                                   onclick="javascript:window.open('<?= base_url() . "upload/planos/" . $plano_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" 
                                                   src="<?= base_url() . "upload/planos/" . $plano_id . "/" . $value ?>">
                                <br><?=$value ?>
                                <? if ($perfil_id != 11 && $perfil_id != 2) { ?>
                                    <br><a onclick="jasvascript: return confirm('Deseja realmente excluir o arquivo?');" href="<?= base_url() ?>cadastros/formapagamento/excluirimagem/<?= $plano_id ?>/<?= $value ?>">Excluir</a>
                                <? } ?>
                            </td>
                            <?
                            if ($i == 8) {
                                ?>
                            </tr><tr>
                                <?
                            }
                        endforeach;
                    endif
                    ?>
            </table>
        </div> <!-- Final da DIV content -->
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });



</script>
