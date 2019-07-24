 
 
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div style="width: 100%">
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/empresa/gravarconfiguracaowhatsapp" method="post">
            <fieldset>
                <legend>Dados do Pacote</legend>
                <? $operador_id = $this->session->userdata('operador_id');
                if ($operador_id == 1) {
                    ?>
                    <div style="width: 100%">
                        <label>Pacote</label>
                        <input type="hidden" name="empresa_whatsapp_id" value="<?= @$mensagem[0]->empresa_whatsapp_id; ?>"/>
                        <input type="hidden" name="empresa_id" value="<?= @$empresa_id ?>"/>
                        <input type="number" name="num_pacote" value="<?= @$mensagem[0]->pacote; ?>" required=""> 
                       
                    </div>
                    <div style="width: 100%">
                        <label onclick="mostrarPopUpIndentificao()" title="Clique para obter mais informações.">Identificação da Empresa</label>
                        <input type="text" name="numero_identificacao_whatsapp" value="<?=  @$mensagem[0]->cnpj; ?>" required=""/>
                    </div>
                
                
                    <div style="width: 100%">
                        <label>Endereço Externo( http://endereco_externo/ )</label>
                        <input type="text" name="endereco_externo" value="<?= @$mensagem[0]->endereco_externo; ?>" required=""/>
                    </div>
                
                
                    <div style="width: 100%">
                        <label>Endereço Clinica( http://endereco_clinca/ )</label>
                        <input type="text" name="endereco_clinica" value="<?= @$mensagem[0]->endereco_clinica; ?>" required=""/>
                    </div>
                
                
                <? } ?>
                

                <div style="width: 100%">
                    <label>Mensagem(@paciente, @medico , @exame, @clinica, @data) </label>
                    <textarea name="mensagem" style="width:700px;"   required=""><?= @$mensagem[0]->mensagem; ?></textarea>
                </div>

                <div style="width: 100%">
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </div>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    .mensagem_texto{
        width: 500pt;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
