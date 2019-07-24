<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");

class Verificar extends Controller {

    function Verificar() {

        parent::Controller();
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/modelodeclaracao_model', 'modelodeclaracao');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('ambulatorio/sala_model', 'sala');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('cadastro/grupoconvenio_model', 'grupoconvenio');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('ambulatorio/GExtenso', 'GExtenso');
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        redirect(base_url() . "verificar/verificarcpf");
    }

    function verificarcpf($data = null, $paciente_nome_titular = null, $listadependentes = NULL) {

        $this->carregarView($data, $paciente_nome_titular, $listadependentes);
    }

    private function carregarView($param = null, $paciente_nome_titular = NULL, $listadependentes = NULL, $view = null) {

        @$listarempresalogada = $this->empresa->listarempresalogada();

        if (!isset($param)) {
            $data['mensagem'] = '';
        } else {
            if ($param == 'true') {
                for($i = 0; $i < 3 ; $i++){
                $data['mensagem'] = 'Carência liberada.<br>Titular:<b title="' . $paciente_nome_titular . '">' . mb_strimwidth($paciente_nome_titular, 0, 37, "...") . "</b><br>";
              }
                foreach ($listadependentes as $dependente) {

                    if ($paciente_nome_titular != $dependente->nome) {

                        $data['mensagem'] .= 'Dependente: <b title="' . $dependente->nome . '" >' . mb_strimwidth($dependente->nome, 0, 32, "...") . "</b><br>";
                    }
                }
               
            } elseif ($param == 'false') {
                $data['mensagem'] = 'Carência não-liberada ';
            } elseif ($param == 'pending') {
                $data['mensagem'] = 'Pendência<br>Favor verificar junto a empresa <br>' . @$listarempresalogada[0]->nome;
            } else {
                $data['mensagem'] = 'Cliente não Cadastrado<br>Favor verificar junto a empresa <br>' . @$listarempresalogada[0]->nome;
            }
        }

//        $data['empresa'] = $this->login->listar();
        $this->load->view('verificarcpf', $data);
    }

    function validarcpf() {
        header('Access-Control-Allow-Origin: *');

        if (@$_POST['cpf'] == "") {
            $cpf = "";
        } else {
            $cpf = @$_POST['cpf'];
        }


        if (@$_POST['paciente_id'] == "") {
            $paciente_id = "";
        } else {
            $paciente_id = @$_POST['paciente_id'];
        }
        
        
       if (@$_POST['nome'] == "") {
            $nome = "";
        

        $numero_consultas_aut = 1; 
//        var_dump($grupo); die; 
        $data = date("Y-m-d"); 
        $paciente_informacoes = $this->guia->listarpacientecpf($cpf, $paciente_id,$nome); 
        $listadependentes = $this->paciente->listardependentescontrato(@$paciente_informacoes[0]->paciente_contrato_id);
    
        
        
        if (count($paciente_informacoes) > 0) {
            $paciente_id = $paciente_informacoes[0]->paciente_id;
            @$paciente_nome_titular = $paciente_informacoes[0]->nome;


//        var_dump($paciente_informacoes); die;
//        $paciente_informacoes = $this->paciente_m->listardados($_POST['txtNomeid']);
            if ($paciente_informacoes[0]->situacao == 'Dependente') {
                $dependente = true;
            } else {
                $dependente = false;
            }

            if ($dependente) {
                $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
//                $paciente_id = $retorno[0]->paciente_id;
                @$paciente_titular_id = $retorno[0]->paciente_id;
//            $paciente_dependente_id = $paciente_informacoes[0]->paciente_id;
            } else {
//            $paciente_id = $_POST['txtNomeid'];
                $paciente_titular_id = $paciente_id;
                $paciente_dependente_id = null;
            }

            $parcelas = $this->guia->listarparcelaspaciente($paciente_titular_id); // Traz as paarcelas que ja estão pagas
            $parcelasPrevistas = $this->guia->listarparcelaspacienteprevistas($paciente_titular_id); // Traz as parcelas anteriores a data atual


            $parcelas_nao_paga = $this->guia->listarparcelaspacientetotal($paciente_titular_id);
            $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
            $quantidade_parcelas_pagas = $this->guia->listarparcelaspagas($paciente_titular_id);
           //verificando se tem parcelas não pagas  com o $parcelas_nao_paga, depois verifica a quantidade de parcelas que esse paciente tem, depois verifica se a quantidade de parcelas pagas é igual a quantidade de parcelas que o paciente posssui.
            if (count($parcelas_nao_paga) == 0 && count($quantidade_parcelas) > 0 && count($quantidade_parcelas_pagas) == count($quantidade_parcelas)) {
             //caso entre aqui ele está liberado;
                $this->verificarcpf('true', $paciente_nome_titular, $listadependentes);
                
            } else {

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
                    //
            //
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
//                var_dump($carencia_mensal); die;
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
                        $listarconsultaavulsa = array();
                        $tipo_consulta = '';
                    }

                    /* Se no fim das contas se tudo der errado, a variável carencia_liberada vai conter a informacao 'f'que irá ser salva na linha da consulta
                      no banco, para dessa forma o sistema cobrar o valor do exame ao invés de utilizar da carência */

                    if ($carencia_liberada == 't') {
//                    echo json_encode('true');
                        
                        
                        $this->verificarcpf('true', $paciente_nome_titular, $listadependentes);
                        
                        
                    } else {
//                    echo json_encode('false');
                        $this->verificarcpf('false');
                    }
                } else {
//                echo json_encode('pending');
                    $this->verificarcpf('pending');
                }
            }
            
            
            
        } else {
//            echo json_encode('no_exists');
            $this->verificarcpf('no_exists');
        }
        
        
        } else {
            
            $nome = @$_POST['nome'];
             $data['titulares'] = $this->guia->listarpacientecpf($cpf, $paciente_id,$nome); 
               
            $this->load->view('verificarcpf', $data);
            
        }

        
        // Realiza a gravação da consulta caso o teste seja verdadeiro 
    }

    function procedimentoconsultarcarencia() {
        header('Access-Control-Allow-Origin: *');
        $parceiro_id = $_GET['parceiro_id'];
        $paciente_id = $_GET['paciente'];
//        $paciente_ip = $_GET['paciente_ip'];

        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
//        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;



        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/verificar/listargrupoagendamentoweb?procedimento_convenio_id={$_GET['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        $paciente_informacoes = $this->paciente_m->listardados($_GET['paciente']);
        if ($paciente_informacoes[0]->situacao == 'Dependente') {
            $dependente = true;
        } else {
            $dependente = false;
        }

        if ($dependente == true) {
            $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
            $paciente_id = $retorno[0]->paciente_id;
            $paciente_titular_id = $retorno[0]->paciente_id;
            $paciente_dependente_id = $_GET['paciente'];
        } else {
            $paciente_id = $_GET['paciente'];
            $paciente_titular_id = $_GET['paciente'];
            $paciente_dependente_id = null;
        }
//        var_dump($_POST['txtNomeid']);
//        var_dump($paciente_id);
//        var_dump($paciente_titular_id);
//        die;
//        $paciente_id = $_POST['txtNomeid'];
        $empresa_p = $this->guia->listarempresa();

        if ($empresa_p[0]->tipo_carencia == "SOUDEZ") {
            $parcelas = $this->guia->listarparcelaspaciente($paciente_id);
            $carencia = $this->guia->listarparcelaspacientecarencia($paciente_id);

            $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_titular_id, $grupo);
            $carencia_exame = $carencia[0]->carencia_exame;
            $carencia_consulta = $carencia[0]->carencia_consulta;
            $carencia_especialidade = $carencia[0]->carencia_especialidade;

            // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
            if ($grupo == 'EXAME') {
                $carencia = (int) $carencia_exame;
            } elseif ($grupo == 'CONSULTA') {
                $carencia = (int) $carencia_consulta;
            } elseif ($grupo == 'FISIOTERAPIA' || $grupo == 'ESPECIALIDADE') {
                $carencia = (int) $carencia_especialidade;
            } else {
                $carencia = 0;
            }
            //        var_dump($grupo); die;
            // 
            $dias_parcela = 30 * count($parcelas);
            $dias_atendimento = $carencia * count($listaratendimento);

            //        var_dump($dias_parcela);
            //        var_dump($dias_atendimento);
            //        var_dump($carencia);
            //        die;
            if (($dias_parcela - $dias_atendimento) >= $carencia) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            $liberada = false;
            $parcelas = $this->guia->listarparcelaspacientetotal($paciente_id);
            $carencia = $this->guia->listarparcelaspacientecarencia($paciente_id);

            $exame_liberado = 'Pendência';
            $consulta_liberado = 'Pendência';
            $especialidade_liberado = 'Pendência';

            $liberado = false;

            $carencia_exame = @$carencia[0]->carencia_exame;
            $carencia_consulta = @$carencia[0]->carencia_consulta;
            $carencia_especialidade = @$carencia[0]->carencia_especialidade;
            // Se alguma das parcelas não tiver sido paga, o sistema não vai retornar true pra carencia
            foreach ($parcelas as $item) {
                // as variaveis acima já tão definidas, então nessa parte eu deixei esse foreach que só roda uma vez
                // e atribui valor ao objeto item
                $liberado = true;
                if ($item->ativo == 't') {
                    break;
                }
            }
            // Se tiverem parcelas, vai pegar a ultima parcela do foreach acima e usa a data abaixo.
            if (count($parcelas) > 0 && $liberado) {
                $data_atual = date("Y-m-d");
                $data_exame = date('Y-m-d', strtotime("+$carencia_exame days", strtotime($item->data)));
                $data_consulta = date('Y-m-d', strtotime("+$carencia_consulta days", strtotime($item->data)));
                $data_especialidade = date('Y-m-d', strtotime("+$carencia_especialidade days", strtotime($item->data)));
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
                $liberado = false;
            }

            // echo '<pre>';
            // // var_dump($parcelas); 
            // var_dump($liberado); 
            // var_dump($item->data); 
            // die;
            if ($grupo == 'ESPECIALIDADE' && $especialidade_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'CONSULTA' && $consulta_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'EXAME' && $exame_liberado == 'Liberado') {
                $liberado = true;
            } else {
                $liberado = false;
            }

            echo json_encode($liberado);
        }

//        die;
    }

    function verificarcarenciaweb() {
        header('Access-Control-Allow-Origin: *');
        $parceiro_id = $_GET['parceiro_id'];
        $paciente_id = $_GET['paciente'];
//        $paciente_ip = $_GET['paciente_ip'];

        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
//        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;



        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/verificar/listargrupoagendamentoweb?procedimento_convenio_id={$_GET['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        $paciente_informacoes = $this->paciente_m->listardados($_GET['paciente']);
        if ($paciente_informacoes[0]->situacao == 'Dependente') {
            $dependente = true;
        } else {
            $dependente = false;
        }

        if ($dependente == true) {
            $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
            $paciente_id = $retorno[0]->paciente_id;
            $paciente_titular_id = $retorno[0]->paciente_id;
            $paciente_dependente_id = $_GET['paciente'];
        } else {
            $paciente_id = $_GET['paciente'];
            $paciente_titular_id = $_GET['paciente'];
            $paciente_dependente_id = null;
        }
//        var_dump($_POST['txtNomeid']);
//        var_dump($paciente_id);
//        var_dump($paciente_titular_id);
//        die;
//        $paciente_id = $_POST['txtNomeid'];
        $empresa_p = $this->guia->listarempresa();

        if ($empresa_p[0]->tipo_carencia == "SOUDEZ") {

            echo json_encode(true);
            // Se for no Modelo SouDez, 
            // o javascript vai apenas liberar o botão independe de qualquer coisa.
        } else {
            $liberada = false;
            $parcelas = $this->guia->listarparcelaspacientetotal($paciente_id);
            $carencia = $this->guia->listarparcelaspacientecarencia($paciente_id);

            $exame_liberado = 'Pendência';
            $consulta_liberado = 'Pendência';
            $especialidade_liberado = 'Pendência';

            $liberado = false;

            $carencia_exame = @$carencia[0]->carencia_exame;
            $carencia_consulta = @$carencia[0]->carencia_consulta;
            $carencia_especialidade = @$carencia[0]->carencia_especialidade;
            // Se alguma das parcelas não tiver sido paga, o sistema não vai retornar true pra carencia
            foreach ($parcelas as $item) {
                // as variaveis acima já tão definidas, então nessa parte eu deixei esse foreach que só roda uma vez
                // e atribui valor ao objeto item
                $liberado = true;
                if ($item->ativo == 't') {
                    break;
                }
            }
            // Se tiverem parcelas, vai pegar a ultima parcela do foreach acima e usa a data abaixo.
            if (count($parcelas) > 0 && $liberado) {
                $data_atual = date("Y-m-d");
                $data_exame = date('Y-m-d', strtotime("+$carencia_exame days", strtotime($item->data)));
                $data_consulta = date('Y-m-d', strtotime("+$carencia_consulta days", strtotime($item->data)));
                $data_especialidade = date('Y-m-d', strtotime("+$carencia_especialidade days", strtotime($item->data)));
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
                $liberado = false;
            }

            // echo '<pre>';
            // // var_dump($parcelas); 
            // var_dump($liberado); 
            // var_dump($item->data); 
            // die;
            if ($grupo == 'ESPECIALIDADE' && $especialidade_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'CONSULTA' && $consulta_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'EXAME' && $exame_liberado == 'Liberado') {
                $liberado = true;
            } else {
                $liberado = false;
            }

            echo json_encode($liberado);
        }

//        die;
    }

    function autorizaragendaweb() {
        
    }

    function autorizaratendimentoweb() {
        header('Access-Control-Allow-Origin: *');

        $parceiro_id = (int) $_GET['parceiro_id'];

        $cpf = $_GET['cpf'];

        $agenda_exames_id = (int) $_GET['agenda_exames_id'];

        $paciente_parceiro_id = (int) $_GET['paciente_id'];

        $grupo = $_GET['grupo'];

        $procedimento = $_GET['procedimento'];

        $valor = $_GET['valor'];

        if ($_GET['numero_consultas'] > 0) {
            $numero_consultas_aut = (int) $_GET['numero_consultas'];
        } else {
            $numero_consultas_aut = (int) $_GET['numero_consultas'];
        }
//        var_dump($grupo); die;


        $data = date("Y-m-d");

        $parceiro = $this->parceiro->listarparceiroenderecoconvenio($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;

        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA
//        $grupo_busca = file_get_contents("http://{$endereco}/verificar/listargrupoagendamentoweb?procedimento_convenio_id={$_POST['procedimento']}");
//        $grupo = json_decode($grupo_busca);
        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        $paciente_informacoes = $this->guia->listarpacientecpf($cpf);
//        echo "<pre>";
//        var_dump($paciente_informacoes); die;
        if (count($paciente_informacoes) > 0) {

            $paciente_id = $paciente_informacoes[0]->paciente_id;
//        var_dump($paciente_informacoes); die;
//        $paciente_informacoes = $this->paciente_m->listardados($_POST['txtNomeid']);
            if ($paciente_informacoes[0]->situacao == 'Dependente') {
                $dependente = true;
            } else {
                $dependente = false;
            }

            if ($dependente) {
                $retorno = $this->guia->listarparcelaspacientedependente($paciente_id);
//                $paciente_id = $retorno[0]->paciente_id;
                $paciente_titular_id = $retorno[0]->paciente_id;
//            $paciente_dependente_id = $paciente_informacoes[0]->paciente_id;
            } else {
//            $paciente_id = $_POST['txtNomeid'];
                $paciente_titular_id = $paciente_id;
                $paciente_dependente_id = null;
            }

            $parcelas = $this->guia->listarparcelaspaciente($paciente_titular_id); // Traz as paarcelas que ja estão pagas
            $parcelasPrevistas = $this->guia->listarparcelaspacienteprevistas($paciente_titular_id); // Traz as parcelas anteriores a data atual

            if (count($parcelas) >= count($parcelasPrevistas)) { // Verifica se as parcelas estão em dia
                $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id);

                $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_titular_id, $grupo);
                $listaragendamentocriado = $this->guia->listaratendimentoagendaexames($paciente_titular_id, $agenda_exames_id);

                // So quem pode usar da carencia são procedimentos do grupo consulta.
                $carencia_exame = 0; /* $carencia[0]->carencia_exame; */
                $carencia_exame_mensal = 0; /* $carencia[0]->carencia_exame_mensal; */
                $carencia_especialidade = 0; /* $carencia[0]->carencia_especialidade; */
                $carencia_especialidade_mensal = 0; /* $carencia[0]->carencia_especialidade_mensal; */
                $carencia_consulta = $carencia[0]->carencia_consulta;
                $carencia_consulta_mensal = $carencia[0]->carencia_consulta_mensal;

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
                //        echo '<pre>';
                //        var_dump($paciente_titular_id);
                //        var_dump($grupo);
                //        var_dump($carencia);
                //        var_dump($dias_parcela);
                //        var_dump($dias_atendimento);
                //        var_dump($parcelas);
                //        var_dump($parcelas_mensal);
                //        var_dump($listaratendimento);
                //        die;
                // Nesse caso, se o número de dias de parcela que ele tem menos o número de dias de atendimento (carência x numero de atendimentos) que ele tem for maior que a carência
                // o sistema vai gravar. 
                //
            //
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
                        // Marcando que foi utilizada

                        $gravar_utilizacao = $this->guia->utilizarconsultaavulsaliberada($consulta_avulsa_id);

                        // Libera a consulta sem necessidade de pagamento adicional
                        $carencia_liberada = 't';
                    } else {
                        $tipo_consulta = '';
                    }
                } else {
                    $listarconsultaavulsa = array();
                    $tipo_consulta = '';
                }



                /* Se no fim das contas se tudo der errado, a variável carencia_liberada vai conter a informacao 'f'que irá ser salva na linha da consulta
                  no banco, para dessa forma o sistema cobrar o valor do exame ao invés de utilizar da carência */

                if ($carencia_liberada == 't') {
                    if (count($listaragendamentocriado) == 0) {
                        $gravaratendimento = $this->guia->gravaratendimentoparceiroweb($paciente_id, $parceiro_id, $valor, $procedimento, $parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data, $grupo, $paciente_titular_id, $carencia_liberada, $tipo_consulta);
                    }

                    echo json_encode('true');
                } else {
                    if (count($listaragendamentocriado) == 0) {
                        $gravaratendimento = $this->guia->gravaratendimentoparceiroweb($paciente_id, $parceiro_id, $valor, $procedimento, $parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data, $grupo, $paciente_titular_id, $carencia_liberada, $tipo_consulta);
                    }
                    echo json_encode('false');
                }
            } else {
                echo json_encode('pending');
            }
        } else {
            echo json_encode('no_exists');
        }
        // Realiza a gravação da consulta caso o teste seja verdadeiro 
    }

    function horariosambulatorio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarverificarhorarios($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarverificarhorarios();
        }
        echo json_encode($result);
    }

    function triggerinformationiugu() {
        $invoice_id = $_POST["data"]['id'];
        $status = $_POST["data"]['status'];
//        $invoice_id = '0F9A25CAC06E486FA04359714E7CC378';
//        $status = 'paid';
        if ($status == 'paid') {
            $this->guia->confirmarpagamentogatilhoiugu($invoice_id);
            echo 'true';
        } else {

            echo 'false';
        }
    }

    function apagarcontratosiugu() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelaiuguexcluidos();
        //echo '<pre>';
        //var_dump($pagamento);
        // die;

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        if ($key != '') {

            foreach ($pagamento as $item) {


                Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
                $invoice_id = $item->invoice_id;

                $retorno = Iugu_Invoice::fetch($invoice_id);
//                echo '<pre>';
//                var_dump($retorno);
//                die;
                if ($retorno['status'] == 'paid') {

                    $this->guia->confirmarpagamento($item->paciente_contrato_parcelas_id);
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function confirmarpagamentoautomaticoiugu() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelaiugupendentes();
//        echo '<pre>';
//        var_dump($pagamento);
//        die;

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        if ($key != '') {

            foreach ($pagamento as $item) {


                Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
                $invoice_id = $item->invoice_id;

                $retorno = Iugu_Invoice::fetch($invoice_id);
//                echo '<pre>';
//                var_dump($retorno);
//                die;
                if ($retorno['status'] == 'paid') {

                    $this->guia->confirmarpagamentoautomaticoiugu($item->paciente_contrato_parcelas_id);
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function confirmarpagamentoautomaticoconsultaavulsaiugu() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelaiugupendentesconsultaavulsa();
//        echo '<pre>';
//        var_dump($pagamento);
//        die;

        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        if ($key != '') {

            foreach ($pagamento as $item) {


                Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
                $invoice_id = $item->invoice_id;
                $tipo = $item->tipo;
                $valor = $item->valor;
                $paciente_id = $item->paciente_id;
                $retorno = Iugu_Invoice::fetch($invoice_id);
//                echo '<pre>';
//                var_dump($retorno);
//                die;
                if ($retorno['status'] == 'paid') {

                    $this->guia->confirmarpagamentoautomaticoconsultaavulsaiugu($item->consultas_avulsas_id, $paciente_id, $tipo, $valor);
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function pagamentoautomaticoiugu() {

        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão

        $pagamento = $this->paciente_m->listarparcelaiugucartao();

//        echo '<pre>';
//        var_dump($pagamento);
//        die;

        $retorno = 'false';


        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa

        foreach ($pagamento as $item) {

            $paciente_id = $item->paciente_id;

            $cartao_cliente = $this->paciente_m->listarcartaoclienteverificar($paciente_id);
            $cliente = $this->paciente_m->listardados($paciente_id);
            $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
            $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
            $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
            $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
            $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
            $valor = $pagamento[0]->valor * 100;
            $description = $empresa[0]->nome . " - " . $pagamento[0]->plano;

            $paciente_contrato_parcelas_id = $item->paciente_contrato_parcelas_id;

            $payment_token = Iugu_PaymentToken::create(
                            Array(
                                'method' => 'credit_card',
                                'data' => Array(
                                    'number' => $cartao_cliente[0]->card_number,
                                    'verification_value' => $cartao_cliente[0]->card_csv,
                                    'first_name' => $cartao_cliente[0]->first_name,
                                    'last_name' => $cartao_cliente[0]->last_name,
                                    'month' => $cartao_cliente[0]->mes,
                                    'year' => $cartao_cliente[0]->ano,
                                ),
                            )
            );
//            echo '<pre>';
//            var_dump($payment_token);
//            die;
            if ($payment_token['errors'] == 0) {

                $gerar = Iugu_Charge::create(
                                Array(
                                    'token' => $payment_token,
                                    "email" => $cliente[0]->cns,
                                    'items' => Array(
                                        Array(
                                            "description" => $description,
                                            "quantity" => "1",
                                            "price_cents" => $valor
                                        )
                                    ),
                                    "payer" => Array(
                                        "cpf_cnpj" => $cpfcnpj,
                                        "name" => $cliente[0]->nome,
                                        "phone_prefix" => $prefixo,
                                        "phone" => $celular_s_prefixo,
                                        "email" => $cliente[0]->cns,
                                        "address" => Array(
                                            "street" => $cliente[0]->logradouro,
                                            "number" => $cliente[0]->numero,
                                            "city" => $cliente[0]->cidade_desc,
                                            "state" => $codigoUF,
                                            "district" => $cliente[0]->bairro,
                                            "country" => "Brasil",
                                            "zip_code" => $cliente[0]->cep,
                                            "complement" => $cliente[0]->complemento
                                        )
                                    )
                                )
                );
            } else {
                $gerar["url"] = '';
                $gerar["invoice_id"] = '';
                $gerar["message"] = 'Cartão de Crédito Inválido';
                $gerar["LR"] = '14';
            }
            echo '<pre>';
            var_dump($payment_token);
            var_dump($gerar);
            die;

            $retorno = 'true';
            $gravar = $this->guia->gravarintegracaoiuguverificar($gerar["url"], $gerar["invoice_id"], $paciente_contrato_parcelas_id, $gerar["message"], $gerar["LR"]);
        }
        echo json_encode($retorno);
    }

    function unidadeleito() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao();
        }
        echo json_encode($result);
    }

    function parcelascontratojson() {

        if (isset($_GET['plano'])) {
            $result = $this->guia->parcelascontratojson($_GET['plano']);
        } else {
            $result = $this->guia->parcelascontratojson();
        }
        echo json_encode($result);
    }

    function horariosambulatorioconsulta() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosconsulta($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosconsulta();
        }
        echo json_encode($result);
    }

    function horariosambulatoriogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosgeral($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosgeral();
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentosconveniomedico($_GET['convenio1'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconveniomedico();
        }
        echo json_encode($result);
    }

    function conveniopaciente() {
        if (isset($_GET['txtNomeid'])) {
            $result = $this->exametemp->listarverificarconveniopaciente($_GET['txtNomeid']);
        } else {
            $result = $this->exametemp->listarverificarconveniopaciente();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function classeportiposaidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarverificarclassessaida($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarverificarclassessaida();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos11() {

        if (isset($_GET['convenio11'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio11']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos12() {

        if (isset($_GET['convenio12'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio12']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos13() {

        if (isset($_GET['convenio13'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio13']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos14() {

        if (isset($_GET['convenio14'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio14']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos15() {

        if (isset($_GET['convenio15'])) {
            $result = $this->exametemp->listarverificarprocedimentostodos($_GET['convenio15']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioajustarvalor() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentosajustarvalor($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosajustarvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoporconvenio() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarverificarprocedimentos($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function estoqueclasseportipo() {

        if (isset($_GET['tipo_id'])) {
            $result = $this->menu->listarverificarclasseportipo($_GET['tipo_id']);
        } else {
            $result = $this->menu->listarverificarclasseportipo();
        }
        echo json_encode($result);
    }

    function estoquesubclasseporclasse() {

        if (isset($_GET['classe_id'])) {
            $result = $this->menu->listarverificarsubclasseporclasse($_GET['classe_id']);
        } else {
            $result = $this->menu->listarverificarsubclasseporclasse();
        }
        echo json_encode($result);
    }

    function estoqueprodutosporsubclasse() {

        if (isset($_GET['subclasse_id'])) {
            $result = $this->menu->listarverificarprodutosporsubclasse($_GET['subclasse_id']);
        } else {
            $result = $this->menu->listarverificarprodutosporsubclasse();
        }
        echo json_encode($result);
    }

    function formapagamento($forma) {

        if (isset($forma)) {
            $result = $this->formapagamento->buscarforma($forma);
        } else {
            $result = $this->formapagamento->buscarforma();
        }
        echo json_encode($result);
    }

    function classeportipo() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarverificarclasse($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarverificarclasse();
        }
        echo json_encode($result);
    }

    function classeportiposaida() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarverificarclassessaida($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarverificarclassessaida();
        }
        echo json_encode($result);
    }

    function medicoconvenio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio1() {

        if (isset($_GET['medico_id1'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id1']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio2() {

        if (isset($_GET['medico_id2'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id2']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio3() {

        if (isset($_GET['medico_id3'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id3']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio4() {

        if (isset($_GET['medico_id4'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id4']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio5() {

        if (isset($_GET['medico_id5'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id5']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio6() {

        if (isset($_GET['medico_id6'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id6']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio7() {

        if (isset($_GET['medico_id7'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id7']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio8() {

        if (isset($_GET['medico_id8'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id8']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio9() {

        if (isset($_GET['medico_id9'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id9']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio10() {

        if (isset($_GET['medico_id10'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id10']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio11() {

        if (isset($_GET['medico_id11'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id11']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio12() {

        if (isset($_GET['medico_id12'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id12']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio13() {

        if (isset($_GET['medico_id13'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id13']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio14() {

        if (isset($_GET['medico_id14'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id14']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio15() {

        if (isset($_GET['medico_id15'])) {
            $result = $this->exametemp->listarverificarmedicoconvenio($_GET['medico_id15']);
        } else {
            $result = $this->exametemp->listarverificarmedicoconvenio();
        }
        echo json_encode($result);
    }

    function procedimentoformapagamento() {

        if (isset($_GET['txtpagamento'])) {
            $result = $this->procedimentoplano->listarverificarformapagamento($_GET['txtpagamento']);
        } else {
            $result = $this->procedimentoplano->listarverificarformapagamento();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->forma_pagamento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconvenioconsulta() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofisioterapia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentosfisioterapia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosfisioterapia();
        }
        echo json_encode($result);
    }

    function procedimentoconveniopsicologia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarverificarprocedimentospsicologia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentospsicologia();
        }
        echo json_encode($result);
    }

    function procedimentovalor() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia11() {

        if (isset($_GET['procedimento11'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento11']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia12() {

        if (isset($_GET['procedimento12'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento12']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia13() {

        if (isset($_GET['procedimento13'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento13']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia14() {

        if (isset($_GET['procedimento14'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento14']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia15() {

        if (isset($_GET['procedimento15'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento15']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorpsicologia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarverificarprocedimentos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarverificarprocedimentosconsulta($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarverificarprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento1() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarverificarprocedimentosforma($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarverificarprocedimentosforma();
        }
        echo json_encode($result);
    }

    function credordevedor() {

        if (isset($_GET['term'])) {
            $result = $this->contaspagar->listarverificarcredro($_GET['term']);
        } else {
            $result = $this->contaspagar->listarverificarcredro();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->razao_social;
            $retorno['id'] = $item->financeiro_credor_devedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudo() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceita() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelosreceita($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelosreceita();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosatestado() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelosatestado($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelosatestado();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexames() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelossolicitarexames();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceitaespecial() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelosreceitaespecial($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelosreceitaespecial();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modeloslinhas() {

        if (isset($_GET['linha'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarlinha($_GET['linha']);
        } else {
            $result = $this->exametemp->listarverificarlinha();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicoespecialidade() {

        if (isset($_GET['txtcbo'])) {
            $result = $this->exametemp->listarverificarmedicoespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->exametemp->listarverificarmedicoespecialidade();
        }


        echo json_encode($result);
    }

    function cboprofissionaismultifuncao() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisverificar($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function linhas() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarverificarlinha($_GET['term']);
        } else {
            $result = $this->exametemp->listarverificarlinha();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . '-' . $item->texto;
            $retorno['id'] = $item->texto;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudos() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarverificarmodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarverificarmodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function laudosanteriores() {

        if (isset($_GET['anteriores'])) {

            $result = $this->laudo->listarverificarlaudos($_GET['anteriores']);
        } else {
            $result = $this->laudo->listarverificarlaudos();
        }
        echo json_encode($result);
    }

    function cidade() {

        if (isset($_GET['term'])) {
            $result = $this->paciente_m->listarCidades($_GET['term']);
        } else {
            $result = $this->paciente_m->listarCidades();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produto() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->verificarproduto($_GET['term']);
        } else {
            $result = $this->produto_m->verificarproduto();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedor() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->verificarfornecedor($_GET['term']);
        } else {
            $result = $this->fornecedor_m->verificarfornecedor();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->estoque_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotuss() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarverificartuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarverificartuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . ' - ' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cbo() {

        if (isset($_GET['term'])) {
            $result = $this->operador_m->listarcbo($_GET['term']);
        } else {
            $result = $this->operador_m->listarcbo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_grupo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cargo() {
        if (isset($_GET['term'])) {
            $result = $this->cargo->listarverificar($_GET['term']);
        } else {
            $result = $this->cargo->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->cargo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function motivo_atendimento() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listamotivoverificar($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listamotivoverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->emergencia_motivoatendimento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicosaida() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listarmedicosaida($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listarmedicosaida();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicos() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarmedicos($_GET['term']);
        } else {
            $result = $this->guia->listarmedicos();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientes() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarpacientes($_GET['term']);
        } else {
            $result = $this->guia->listarpacientes();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcao() {
        if (isset($_GET['term'])) {
            $result = $this->funcao->listarverificar($_GET['term']);
        } else {
            $result = $this->funcao->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function ocorrenciatipo() {
        if (isset($_GET['term'])) {
            $result = $this->ocorrenciatipo->listarverificar($_GET['term']);
        } else {
            $result = $this->ocorrenciatipo->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->ocorrenciatipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function setor() {
        if (isset($_GET['term'])) {
            $result = $this->setor->listarverificar($_GET['term']);
        } else {
            $result = $this->setor->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->setor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function horariostipo() {
        if (isset($_GET['term'])) {
            $result = $this->horariostipo->listarverificar($_GET['term']);
        } else {
            $result = $this->horariostipo->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->horariostipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcionario() {
        if (isset($_GET['term'])) {
            $result = $this->funcionario->listarverificar($_GET['term']);
        } else {
            $result = $this->funcionario->listarverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcionario_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function unidade() {
        if (isset($_GET['term'])) {
            $result = $this->unidade_m->listaunidadeverificar($_GET['term']);
        } else {
            $result = $this->unidade_m->listaunidadeverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->internacao_unidade_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operador() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorverificar($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cboprofissionais() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisverificar($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cbo_ocupacao_id . '-' . $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function paciente() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarverificarpaciente($_GET['term']);
        } else {
            $result = $this->exame->listarverificarpaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientetitular() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarverificarpacientetitular($_GET['term']);
        } else {
            $result = $this->exame->listarverificarpacientetitular();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientenascimento() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarverificarpacientenascimento($_GET['term']);
        } else {
            $result = $this->exame->listarverificarpacientenascimento();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cid1() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidverificar($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cid2() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidverificar($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimento() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listaprocedimentoverificar($_GET['term']);
        } else {
            $result = $this->internacao_m->listaprocedimentoverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->procedimento . '-' . $item->descricao;
            $retorno['id'] = $item->procedimento;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function enfermaria() {

        if (isset($_GET['term'])) {
            $result = $this->enfermaria_m->listaenfermariaverificar($_GET['term']);
        } else {
            $result = $this->enfermaria_m->listaenfermariaverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_enfermaria_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function leito() {

        if (isset($_GET['term'])) {
            $result = $this->leito_m->listaleitoverificar($_GET['term']);
        } else {
            $result = $this->leito_m->listaleitoverificar();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->enfermaria . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
