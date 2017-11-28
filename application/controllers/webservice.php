<?php

class Webservice extends Controller {

    function Webservice() {

        parent::Controller();
        $this->load->model('webservice_model', 'webservice');
    }

    function listarlocaisatendimento() {
        header('Access-Control-Allow-Origin: *');
        
        $retorno = $this->webservice->listarlocaisatendimento();
        
        foreach ($retorno as $value) {
            $result[] = array(
                "parceiro_id" => $value->parceiro_id,
                "razao_social" => $value->razao_social, 
                "nome" => $value->nome, 
                "cnpj" => $value->cnpj, 
                "cep" => $value->cep, 
                "logradouro" => $value->logradouro, 
                "numero" => $value->numero, 
                "complemento" => $value->complemento, 
                "bairro" => $value->bairro, 
                "municipio" => $value->municipio, 
                "celular" => $value->celular, 
                "telefone" => $value->telefone, 
                "banco" => $value->banco
            );
        }
        
        die(json_encode($result));
    }
    
    function listardadosempresa() {
        header('Access-Control-Allow-Origin: *');
        
        $retorno = $this->webservice->listardadosempresa();
        
        foreach ($retorno as $value) {
            $result = array(
                "razao_social" => $value->razao_social,
                "celular" => $value->celular, 
                "telefone" => $value->telefone, 
                "bairro" => $value->bairro, 
                "logradouro" => $value->logradouro, 
                "numero" => $value->numero, 
                "municipio" => $value->municipio,
                "estado" => $value->estado
            );
        }
        
        die(json_encode($result));
    }

    function autenticarusuario() {
        header('Access-Control-Allow-Origin: *');
        
        $usuario = $_GET['user'];
        $senha   = $_GET['pw'];
        /*
         * CODIGOS DE RETORNO
         * 
         * 01 -> Autenticado com sucesso
         * 02 -> Usuario ou senha incorreto
         * 03 -> Usuario nao informado
         * 04 -> Senha nao informada       */
        
        if($usuario == ""){
            $result = array(
                "codigo" => "03",
                "mensagem" => "Usuario nao informado"
            );
            die(json_encode($result));
        }
        if($senha == ""){
            $result = array(
                "codigo" => "04",
                "mensagem" => "Senha nao informada"
            );
            die(json_encode($result));
        }
//        echo md5($senha); die;
        
        $retorno = $this->webservice->autenticarusuario($usuario, $senha);
        
        if(count($retorno) == 0){
            $result = array(
                "codigo" => "02",
                "mensagem" => "Usuario ou senha incorreto"
            );
            die(json_encode($result));            
        }
        else{
            $result = array(
                "codigo" => "01",
                "mensagem" => "Autenticado com sucesso", 
                "usuario"=> $retorno[0]->usuario,
                "paciente_id"=> $retorno[0]->paciente_id
            );
            die(json_encode($result));            
        }
    }
    
    function solicitarConsulta() {
        header('Access-Control-Allow-Origin: *');
        
        $paciente_id = $_GET['paciente_id'];
        $data   = $_GET['data'];
        $consulta   = $_GET['consulta'];
        $manha   = $_GET['manha'];
        $tarde   = $_GET['tarde'];
        $noite   = $_GET['noite'];
        /*
         * CODIGOS DE RETORNO
         * 
         * 01 -> Solicitacao efetuada com sucesso
         * 02 -> Data não informada
         * 03 -> Turno não informado       */
        
        if($data == ""){
            $result = array(
                "codigo" => "02",
                "mensagem" => "Data não informada"
            );
            die(json_encode($result));
        }
        if( $manha == "f" && $tarde == "f" && $noite == "f" ){
            $result = array(
                "codigo" => "03",
                "mensagem" => "Turno não informado"
            );
            die(json_encode($result));
        }
        
//        $retorno = $this->webservice->autenticarusuario($usuario, $senha);
        
        $result = array(
            "codigo" => "01",
            "mensagem" => "Consulta solicitada com sucesso"
        );
        die(json_encode($result));    
    }
    
    function solicitarExame() {
        header('Access-Control-Allow-Origin: *');
        
        $paciente_id = $_GET['paciente_id'];
        $data   = $_GET['data'];
        $exame   = $_GET['exame'];
        $manha   = $_GET['manha'];
        $tarde   = $_GET['tarde'];
        $noite   = $_GET['noite'];
        /*
         * CODIGOS DE RETORNO
         * 
         * 01 -> Exame solicitado com sucesso
         * 02 -> Data não informada
         * 03 -> Turno não informado       */
        
        if($data == ""){
            $result = array(
                "codigo" => "02",
                "mensagem" => "Data não informada"
            );
            die(json_encode($result));
        }
        if( $manha == "f" && $tarde == "f" && $noite == "f" ){
            $result = array(
                "codigo" => "03",
                "mensagem" => "Turno não informado"
            );
            die(json_encode($result));
        }
        
//        $retorno = $this->webservice->autenticarusuario($usuario, $senha);
        
        $result = array(
            "codigo" => "01",
            "mensagem" => "Exame solicitado com sucesso"
        );
        die(json_encode($result));    
    }
}

/* End of file welcome.php */
/* Location: ./system/webservicelication/controllers/welcome.php */
