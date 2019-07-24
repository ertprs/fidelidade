
 
<html>
    <head>
        <title>Notas fiscais</title>
    </head>
    <body style="background-color: silver;">    
        <h1>GERADOR DE NOTAS FISCAIS</h1>  
        <form action="<?= base_url() ?>ambulatorio/guia/gravarxmlrps" method="post">
            <!--Pegando todos os valores importantes para gerar o RPS-->
            <?
            foreach ($listarprocedimentoamb as $item) {
                ?>
                <input type="text" name="procedimentos[]" value="<?= $item->procedimento ?>" hidden>
                <?
            }
            ?>   
            <input type="text" name="ambulatorio_guia" value="<?= @$ambulatorio_guia; ?>" hidden>
            <input type="text" name="total" value="<?= @$listar[0]->total; ?>" hidden>
            <input type="text" name="cnae" value="<?= @$listar[0]->cnae; ?>" hidden>
            <input type="text" name="item_lista" value="<?= @$listar[0]->item_lista; ?>" hidden>
            <input type="text" name="aliquota" value="<?= @$listar[0]->aliquota; ?>" hidden>
            <input type="text" name="cnpjxml" value="<?= @$listar[0]->cnpjxml; ?>" hidden>
            <input type="text" name="inscri_municipal" value="<?= @$listar[0]->inscri_municipal; ?>" hidden>    
            <input type="text" name="desconto_indicionado" value="<?= @$listar[0]->desconto_indicionado; ?>" hidden> 
            <input type="text" name="cpftomador" value="<?= @$listar[0]->cpf; ?>" hidden> 
            <input type="text" name="logradouro" value="<?= @$listar[0]->logradouro; ?>" hidden>
            <input type="text" name="numero" value="<?= @$listar[0]->numero; ?>" hidden>
            <input type="text" name="complemento" value="<?= @$listar[0]->complemento; ?>" hidden>
            <input type="text" name="bairro" value="<?= @$listar[0]->bairro; ?>" hidden>
            <input type="text" name="cep" value="<?= @$listar[0]->cep; ?>" hidden>
            <input type="text" name="municipio" value="<?= @$listar[0]->municipio; ?>" hidden>
            <input type="text" name="telefone" value="<?= @$listar[0]->telefone; ?>" hidden>
            <input type="text" name="codigo_ibge" value="<?= @$listar[0]->codigo_ibge; ?>" hidden>
            <input type="submit" value="Gerar Nova Nota fiscal">
        </form>        
        <hr>
        Notas fiscais Geradas    
        <div>
            <table>
                <tr>
                    <?
                    $this->load->helper('directory');
                    $arquivo_pasta = directory_map("./upload/notasrps/$ambulatorio_guia/");
                    if ($arquivo_pasta != false) {
                        ?>
                    </tr>
                    <tr>
                        <?
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <td width="10px"> <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/notasrps/" . $ambulatorio_guia . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?php echo base_url(); ?>img/archive-zip-icon.png"><br><? echo $value ?></td>
                            <td>&nbsp;</td>        
                        <br><?
                        //   echo base64_encode($value);
                    }
                }
                ?>
                </tr>
                <? ?>
            </table>
        </div>

    </body>
</html>
