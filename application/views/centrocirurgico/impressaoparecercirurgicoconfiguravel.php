<!--<style>
    /*    .teste {
            
    
        }*/

</style>-->
<style>
@page {
	
	/* margin-bottom: 2cm;  */
    /* padding-bottom: 2px; */
    /* margin-bottom: 15px; */

}

</style>

<?
if ($empresapermissoes[0]->desativar_personalizacao_impressao == 'f') {

    if (file_exists("./upload/operadortimbrado/" . $laudo['0']->medico_id . ".png")) {
        $caminho_background = base_url() . "upload/operadortimbrado/" . $laudo['0']->medico_id . ".png";
        $timbrado = true;
    } elseif (file_exists("./upload/upload/timbrado/timbrado.png")) {
        $caminho_background = base_url() . 'upload/timbrado/timbrado.png';
        $timbrado = true;
    } else {
        $timbrado = false;
    }
    ?>

    <? if ($timbrado) { ?>
        <div class="teste" style="background-size: contain; height: 70%; width: 100%;background-image: url(<?= $caminho_background ?>);">
        <? } ?>

        <?
        if (file_exists("./upload/1ASSINATURAS/" . $laudo['0']->medico_id . ".jpg")) {
            $assinatura = "<img src='" . base_url() . "./upload/1ASSINATURAS/" . $laudo['0']->medico_id . ".jpg'>";
        } else {
            $assinatura = "";
        }
    }

//echo $assinatura;
    @$corpo = $impressaolaudo[0]->texto;
    @$corpo = str_replace("<p", '<div', @$corpo);
    @$corpo = str_replace("</p>", '</div>', @$corpo);
//    echo($corpo);
//    die;

    $texto = $laudo['0']->texto;
//    $texto = str_replace("<p", '<div', $texto);
//    $texto = str_replace("</p>", '</div><br>', $texto);
    $corpo = str_replace("_paciente_", $laudo['0']->paciente, $corpo);
    $corpo = str_replace("_sexo_", $laudo['0']->sexo, $corpo);
    $corpo = str_replace("_nascimento_", date("d/m/Y", strtotime($laudo['0']->nascimento)), $corpo);
    $corpo = str_replace("_convenio_", $laudo['0']->convenio, $corpo);
    $corpo = str_replace("_sala_", '', $corpo);
    $corpo = str_replace("_CPF_", $laudo['0']->cpf, $corpo);
    $corpo = str_replace("_RG_", $laudo['0']->rg, $corpo);
    $corpo = str_replace("_solicitante_", $laudo['0']->solicitante, $corpo);
    $corpo = str_replace("_data_", substr($laudo['0']->data, 8, 2) . '/' . substr($laudo['0']->data, 5, 2) . '/' . substr($laudo['0']->data, 0, 4), $corpo);
    $corpo = str_replace("_medico_", $laudo['0']->solicitante, $corpo);
    $corpo = str_replace("_revisor_", '', $corpo);
    $corpo = str_replace("_procedimento_", '', $corpo);
    $corpo = str_replace("_laudo_", $texto, $corpo);
    $corpo = str_replace("_nomedolaudo_", '', $corpo);
    $corpo = str_replace("_queixa_", '', $corpo);
    $corpo = str_replace("_peso_", '', $corpo);
    $corpo = str_replace("_altura_", '', $corpo);
    $corpo = str_replace("_cid1_", '', $corpo);
    $corpo = str_replace("_cid2_", '', $corpo);
    $corpo = str_replace("_guia_", '', $corpo);
    $operador_id = $this->session->userdata('operador_id');
    $operador_atual = $this->operador_m->operadoratualsistema($operador_id);
    @$corpo = str_replace("_usuario_logado_", @$operador_atual[0]->usuario, $corpo);
    $corpo = str_replace("_prontuario_", $laudo[0]->paciente_id, $corpo);
    $corpo = str_replace("_usuario_salvar_", $laudo[0]->usuario_salvar, $corpo);
    $corpo = str_replace("_telefone1_", $laudo[0]->telefone, $corpo);
    $corpo = str_replace("_telefone2_", $laudo[0]->celular, $corpo);
    $corpo = str_replace("_whatsapp_", $laudo[0]->whatsapp, $corpo);
//    if($laudo['0']->situacao == "FINALIZADO"){
    $corpo = str_replace("_assinatura_", $assinatura, $corpo);
//    }else{
//        $corpo = str_replace("_assinatura_", '', $corpo);
//    }

    // echo "<style> p {margin-top:0px;margin-bottom:0px;}</style>";
    echo $corpo;
//    var_dump($corpo);
//    die;
    ?>
    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

