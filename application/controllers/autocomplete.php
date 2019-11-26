<?php

require_once APPPATH . 'controllers/base/BaseController.php';
require_once("./iugu/lib/Iugu.php");
require_once('./gerencianet/vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class Autocomplete extends Controller {

    function Autocomplete() {

        parent::Controller();
        $this->load->model('ponto/funcao_model', 'funcao');
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('estoque/fornecedor_model', 'fornecedor_m');
        $this->load->model('estoque/produto_model', 'produto_m');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->model('cadastro/parceiro_model', 'parceiro');
        $this->load->model('cadastro/contaspagar_model', 'contaspagar');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('emergencia/solicita_acolhimento_model', 'solicita_acolhimento_m');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('estoque/menu_model', 'menu');
        $this->load->model('ambulatorio/empresa_model', 'empresa_m');
        $this->load->library('utilitario');
    }

    function index() {
        
    }

    function procedimentoconsultarcarencia() {
        header('Access-Control-Allow-Origin: *');
        $parceiro_id = $_GET['parceiro_id'];
        $paciente_id = $_GET['paciente'];
        // $empresa_id = $this->session->userdata('empresa_id');
        $empresa_p = $this->guia->listarempresa();
//        $paciente_ip = $_GET['paciente_ip'];

        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
//        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;



        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_GET['procedimento']}");
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
            // var_dump($parcelas); 



            if ($grupo == 'ESPECIALIDADE' && $especialidade_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'CONSULTA' && $consulta_liberado == 'Liberado') {
                $liberado = true;
            } elseif ($grupo == 'EXAME' && $exame_liberado == 'Liberado') {
                $liberado = true;
            } else {
                $liberado = false;
            }


            // var_dump($liberado); 
            // var_dump($item->data); 
            // var_dump($item->data); 
            // die;

            echo json_encode($liberado);
        }

//        die;
    }

    function verificarcarenciaweb() {
        header('Access-Control-Allow-Origin: *');

        $parceiro_id = $_GET['parceiro_id'];
        $cpf = $_GET['cpf'];
        $paciente_antigo_id = $_GET['paciente_antigo_id'];
        // var_dump($_GET); die;
//        $paciente_ip = $_GET['paciente_ip'];

        @$parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
//        $parceiro_id = $parceiro[0]->financeiro_parceiro_id;
        @$convenio_id = $parceiro[0]->convenio_id;



        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_GET['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        if ($paciente_antigo_id > 0) {
            $paciente_informacoes = $this->guia->listarpacientepacienteidantigo($paciente_antigo_id);
        } else {
            $paciente_informacoes = $this->guia->listarpacientecpf($cpf);
        }
        if ($paciente_informacoes[0]->situacao == 'Dependente') {
            $dependente = true;
        } else {
            $dependente = false;
        }
        $paciente_id = $paciente_informacoes[0]->paciente_id;

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
        header('Access-Control-Allow-Origin: *');

        $parceiro_id = $_GET['parceiro_id'];
        $cpf = $_GET['cpf'];

        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_GET['procedimento_convenio_id']}");
        $grupo = json_decode($grupo_busca);

        // LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE

        $paciente_id = $this->guia->listarpacientecpf($cpf);


        $parcelas = $this->guia->listarparcelaspaciente($paciente_id);
        $carencia = $this->guia->listarparcelaspacientecarencia($paciente_id);
        $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_id);
        $carencia_exame = $carencia[0]->carencia_exame;
        $carencia_consulta = $carencia[0]->carencia_consulta;
        $carencia_especialidade = $carencia[0]->carencia_especialidade;

        // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
        if ($grupo == 'EXAME') {
            $carencia = (int) $carencia_exame;
        } elseif ($grupo == 'CONSULTA') {
            $carencia = (int) $carencia_consulta;
        } elseif ($grupo == 'FISIOTERAPIA') {
            $carencia = (int) $carencia_especialidade;
        }
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
        die;
    }

    function autorizaratendimentoweb() {
        header('Access-Control-Allow-Origin: *');

        $parceiro_id = (int) $_GET['parceiro_id'];

        $cpf = $_GET['cpf'];

        $agenda_exames_id = (int) $_GET['agenda_exames_id'];

        $paciente_parceiro_id = (int) $_GET['paciente_id'];

        $paciente_antigo_id = (int) $_GET['paciente_antigo_id'];

        $grupo = $_GET['grupo'];

        $procedimento = $_GET['procedimento'];

        $valor = $_GET['valor'];

        if ($_GET['numero_consultas'] > 0) {
            $numero_consultas_aut = (int) $_GET['numero_consultas'];
        } else {
            $numero_consultas_aut = (int) $_GET['numero_consultas'];
        }
        $empresa_p = $this->guia->listarempresa();
//        var_dump($grupo); die;


        $data = date("Y-m-d");

        $parceiro = $this->parceiro->listarparceiroenderecoconvenio($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;

        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA
//        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_POST['procedimento']}");
//        $grupo = json_decode($grupo_busca);
        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE
        //VERIFICA SE É DEPENDENTE. CASO SIM, ELE VAI PEGAR O ID DO TITULAR E FAZER AS BUSCAS ABAIXO UTILIZANDO ESSE ID
        // Se vier ID antigo do STG ele vai buscar por ID e não por CPF
        if ($paciente_antigo_id > 0) {
            $paciente_informacoes = $this->guia->listarpacientepacienteidantigo($paciente_antigo_id);
        } else {
            $paciente_informacoes = $this->guia->listarpacientecpf($cpf);
        }
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

            if ($empresa_p[0]->tipo_carencia == "SOUDEZ") {
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
                // Se a carencia for normal, ele sempre vai retornar false pro STG gravar valor no atendimento
                $liberada = false;
                $parcelas = $this->guia->listarparcelaspacientetotal($paciente_titular_id);
                $carencia = $this->guia->listarparcelaspacientecarencia($paciente_titular_id);

                $exame_liberado = 'Pendência';
                $consulta_liberado = 'Pendência';
                $especialidade_liberado = 'Pendência';

                $liberado = false;

                $carencia_exame = @$carencia[0]->carencia_exame;
                $carencia_consulta = @$carencia[0]->carencia_consulta;
                $carencia_especialidade = @$carencia[0]->carencia_especialidade;
                $contador = 0;
                // Se alguma das parcelas não tiver sido paga, o sistema não vai retornar true pra carencia
                foreach ($parcelas as $item) {
                    // as variaveis acima já tão definidas, então nessa parte eu deixei esse foreach que só roda uma vez
                    // e atribui valor ao objeto item
                    $liberado = true;
                    if ($item->ativo == 't') {
                        break;
                    }
                }



                $quantidade_parcelas = $this->guia->listarnumpacelas($paciente_titular_id);
                $quantidade_parcelas_pagas = $this->guia->listarparcelaspagas($paciente_titular_id);

                if (count($parcelas) == 0 && count($quantidade_parcelas) > 0 && count($quantidade_parcelas_pagas) == count($quantidade_parcelas)) {

                    $exame_liberado = 'Liberado';
                    $consulta_liberado = 'Liberado';
                    $especialidade_liberado = 'Liberado';
                    $liberado = true;
                } else {
                    // echo '<pre>';
                    // var_dump($liberado);
                    // die; 
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
                }

                if ($grupo == 'ESPECIALIDADE' && $especialidade_liberado == 'Liberado') {
                    $liberado = true;
                } elseif ($grupo == 'CONSULTA' && $consulta_liberado == 'Liberado') {
                    $liberado = true;
                } elseif ($grupo == 'EXAME' && $exame_liberado == 'Liberado') {
                    $liberado = true;
                } else {
                    $liberado = false;
                }
                //  echo '<pre>';
                // // var_dump($parcelas); 
                // var_dump($liberado); 
                // var_dump($item->data); 
                // die;
                if ($liberado) {
                    $gravaratendimento = $this->guia->gravaratendimentoparceiroweb($paciente_id, $parceiro_id, $valor, $procedimento, $parceiro_gravar_id, $agenda_exames_id, $paciente_parceiro_id, $data, $grupo, $paciente_titular_id, 't', $grupo);
                    echo json_encode('false');
                } else {
                    echo json_encode('pending');
                }
            }
        } else {
            echo json_encode('no_exists');
        }
        // Realiza a gravação da consulta caso o teste seja verdadeiro 
    }

    function horariosambulatorio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorarios($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorarios();
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
                if ($retorno['status'] == 'expired') {
                    //$this->guia->excluirpagamentoautomaticoiugu($item->paciente_contrato_parcelas_id);
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function confirmarpagamentoautomaticoiugucliente() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $paciente_id = $_GET['paciente_id'];
        $pagamento = $this->paciente_m->listarparcelaiugupendentescliente($paciente_id);
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
                if ($retorno['status'] == 'expired') {
                    //$this->guia->excluirpagamentoautomaticoiugu($item->paciente_contrato_parcelas_id);
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

    function confirmarpagamentoautomaticoconsultaavulsaiugucliente() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $paciente_id = $_GET['paciente_id'];
        $pagamento = $this->paciente_m->listarparcelaiugupendentesconsultaavulsacliente($paciente_id);
        //    echo '<pre>';
        //    var_dump($pagamento);
        //    die;

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
//        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
//        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelaiugucartao();
//        echo '<pre>';
//        print_r($pagamento);
//        die;
        
        foreach ($pagamento as $item) {           
          $this->guia->confirmarenviohoje($item->paciente_contrato_parcelas_id); 
        }
        
        $retorno = 'false';
        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
        foreach ($pagamento as $item) {       
             
            $paciente_id = $item->paciente_id;
            $cartao_cliente = $this->paciente_m->listarcartaoclienteautocomplete($paciente_id);
            $cliente = $this->paciente_m->listardados($paciente_id);
            $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
            $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
            $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
            $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
            $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
            $valor = $item->valor * 100;
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
//            var_dump($cartao_cliente);
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
//            echo '<pre>';
//            var_dump($payment_token);
//            var_dump($gerar);
//            die;
            $retorno = 'true';
            $gravar = $this->guia->gravarintegracaoiuguautocomplete($gerar["url"], $gerar["invoice_id"], $paciente_contrato_parcelas_id, $gerar["message"], $gerar["LR"]);
        }
        echo json_encode($retorno);
    }

    function pagamentoautomaticoiugucliente() {

//        set_time_limit(7200); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
//        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $paciente_id = $_GET['paciente_id'];
        $pagamento = $this->paciente_m->listarparcelaiugucartaocliente($paciente_id);
//        echo '<pre>';
//        var_dump($pagamento);
//        die;
        
        foreach ($pagamento as $item) {           
          $this->guia->confirmarenviohoje($item->paciente_contrato_parcelas_id); 
        }
        
        $retorno = 'false';
        $empresa = $this->guia->listarempresa();
        $key = $empresa[0]->iugu_token;
        Iugu::setApiKey($key); // Ache sua chave API no Painel e cadastre nas configurações da empresa
        foreach ($pagamento as $item) {
            $paciente_id = $item->paciente_id;
            $cartao_cliente = $this->paciente_m->listarcartaoclienteautocomplete($paciente_id);
            $cliente = $this->paciente_m->listardados($paciente_id);
            $celular = preg_replace('/[^\d]+/', '', $cliente[0]->celular);
            $celular_s_prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 2, 50);
            $prefixo = substr(preg_replace('/[^\d]+/', '', $cliente[0]->celular), 0, 2);
            $codigoUF = $this->utilitario->codigo_uf($cliente[0]->codigo_ibge);
            $cpfcnpj = str_replace('/', '', $cliente[0]->cpf);
            $valor = $item->valor * 100;
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
//            var_dump($cartao_cliente);
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
//            echo '<pre>';
//            var_dump($payment_token);
//            var_dump($gerar);
//            die;

            $retorno = 'true';
            $gravar = $this->guia->gravarintegracaoiuguautocomplete($gerar["url"], $gerar["invoice_id"], $paciente_contrato_parcelas_id, $gerar["message"], $gerar["LR"]);
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
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico($_GET['convenio1'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico();
        }
        echo json_encode($result);
    }

    function conveniopaciente() {
        if (isset($_GET['txtNomeid'])) {
            $result = $this->exametemp->listarautocompleteconveniopaciente($_GET['txtNomeid']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniopaciente();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function classeportiposaidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos11() {

        if (isset($_GET['convenio11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos12() {

        if (isset($_GET['convenio12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos13() {

        if (isset($_GET['convenio13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos14() {

        if (isset($_GET['convenio14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos15() {

        if (isset($_GET['convenio15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioajustarvalor() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoporconvenio() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function estoqueclasseportipo() {

        if (isset($_GET['tipo_id'])) {
            $result = $this->menu->listarautocompleteclasseportipo($_GET['tipo_id']);
        } else {
            $result = $this->menu->listarautocompleteclasseportipo();
        }
        echo json_encode($result);
    }

    function estoquesubclasseporclasse() {

        if (isset($_GET['classe_id'])) {
            $result = $this->menu->listarautocompletesubclasseporclasse($_GET['classe_id']);
        } else {
            $result = $this->menu->listarautocompletesubclasseporclasse();
        }
        echo json_encode($result);
    }

    function estoqueprodutosporsubclasse() {

        if (isset($_GET['subclasse_id'])) {
            $result = $this->menu->listarautocompleteprodutosporsubclasse($_GET['subclasse_id']);
        } else {
            $result = $this->menu->listarautocompleteprodutosporsubclasse();
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
            $result = $this->financeiro_classe->listarautocompleteclasse($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclasse();
        }
        echo json_encode($result);
    }

    function classeportiposaida() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function medicoconvenio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio1() {

        if (isset($_GET['medico_id1'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id1']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio2() {

        if (isset($_GET['medico_id2'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id2']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio3() {

        if (isset($_GET['medico_id3'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id3']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio4() {

        if (isset($_GET['medico_id4'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id4']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio5() {

        if (isset($_GET['medico_id5'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id5']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio6() {

        if (isset($_GET['medico_id6'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id6']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio7() {

        if (isset($_GET['medico_id7'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id7']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio8() {

        if (isset($_GET['medico_id8'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id8']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio9() {

        if (isset($_GET['medico_id9'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id9']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio10() {

        if (isset($_GET['medico_id10'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id10']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio11() {

        if (isset($_GET['medico_id11'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id11']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio12() {

        if (isset($_GET['medico_id12'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id12']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio13() {

        if (isset($_GET['medico_id13'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id13']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio14() {

        if (isset($_GET['medico_id14'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id14']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio15() {

        if (isset($_GET['medico_id15'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id15']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function procedimentoformapagamento() {

        if (isset($_GET['txtpagamento'])) {
            $result = $this->procedimentoplano->listarautocompleteformapagamento($_GET['txtpagamento']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteformapagamento();
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
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofisioterapia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia();
        }
        echo json_encode($result);
    }

    function procedimentoconveniopsicologia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia();
        }
        echo json_encode($result);
    }

    function procedimentovalor() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia11() {

        if (isset($_GET['procedimento11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia12() {

        if (isset($_GET['procedimento12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia13() {

        if (isset($_GET['procedimento13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia14() {

        if (isset($_GET['procedimento14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia15() {

        if (isset($_GET['procedimento15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorpsicologia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento1() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function credordevedor() {

        if (isset($_GET['term'])) {
            $result = $this->contaspagar->listarautocompletecredro($_GET['term']);
        } else {
            $result = $this->contaspagar->listarautocompletecredro();
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
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceita() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceita($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceita();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosatestado() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosatestado($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosatestado();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexames() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelossolicitarexames();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceitaespecial() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modeloslinhas() {

        if (isset($_GET['linha'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletelinha($_GET['linha']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicoespecialidade() {

        if (isset($_GET['txtcbo'])) {
            $result = $this->exametemp->listarautocompletemedicoespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoespecialidade();
        }


        echo json_encode($result);
    }

    function cboprofissionaismultifuncao() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
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
            $result = $this->exametemp->listarautocompletelinha($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
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
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function laudosanteriores() {

        if (isset($_GET['anteriores'])) {

            $result = $this->laudo->listarautocompletelaudos($_GET['anteriores']);
        } else {
            $result = $this->laudo->listarautocompletelaudos();
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
            $result = $this->produto_m->autocompleteproduto($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteproduto();
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
            $result = $this->fornecedor_m->autocompletefornecedor($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedor();
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
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
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
            $result = $this->cargo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->cargo->listarautocomplete();
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
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete();
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
            $result = $this->funcao->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcao->listarautocomplete();
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
            $result = $this->ocorrenciatipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->ocorrenciatipo->listarautocomplete();
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
            $result = $this->setor->listarautocomplete($_GET['term']);
        } else {
            $result = $this->setor->listarautocomplete();
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
            $result = $this->horariostipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->horariostipo->listarautocomplete();
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
            $result = $this->funcionario->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcionario->listarautocomplete();
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
            $result = $this->unidade_m->listaunidadeautocomplete($_GET['term']);
        } else {
            $result = $this->unidade_m->listaunidadeautocomplete();
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
            $result = $this->operador_m->listaoperadorautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorautocomplete();
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
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
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
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
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
            $result = $this->exame->listarautocompletepacientetitular($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientetitular();
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
            $result = $this->exame->listarautocompletepacientenascimento($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientenascimento();
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
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
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
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
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
            $result = $this->internacao_m->listaprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listaprocedimentoautocomplete();
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
            $result = $this->enfermaria_m->listaenfermariaautocomplete($_GET['term']);
        } else {
            $result = $this->enfermaria_m->listaenfermariaautocomplete();
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
            $result = $this->leito_m->listaleitoautocomplete($_GET['term']);
        } else {
            $result = $this->leito_m->listaleitoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->enfermaria . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function carregarprecos() {


        if (isset($_GET['tipo'])) {
            $result = $this->paciente_m->listarpagamentosplano($_GET['tipo']);
        } else {
//            $result = $this->paciente_m->listarpagamentosplano();
        }
        echo json_encode($result);
    }

    function verificarcontratospacientes() {
        $data['pacientes'] = $this->guia->listarpacientes();
        $data['permissao'] = $this->empresa_m->listarpermissoes();
        if (count($data['pacientes']) > 0) {
            foreach ($data['pacientes'] as $item) {
                $data['exames'] = $this->guia->listarexames($item->paciente_id);
                $contrato_ativo = $this->guia->listarcontratoativo($item->paciente_id);
                if (count($contrato_ativo) > 0) {
                    if ($contrato_ativo[count($contrato_ativo) - 1]->data != "") {
                        $paciente_contrato_id = $contrato_ativo[0]->paciente_contrato_id;
                        $data_contrato = $contrato_ativo[count($contrato_ativo) - 1]->data;
                        $data_cadastro = $contrato_ativo[count($contrato_ativo) - 1]->data_cadastro;
                        $qtd_dias = $contrato_ativo[count($contrato_ativo) - 1]->qtd_dias;
                        if ($qtd_dias == "") {
                            $qtd_dias = 0;
                        } else {
                            
                        }
                        // $data_contrato_year = date('Y-m-d H:i:s', strtotime("+ 1 year", strtotime($data_contrato)));
                        //Abaixo soma data de cadastro do contrato com os dias colocados no plano.
                        $data_tot_contrato = date('Y-m-d', strtotime("+$qtd_dias days", strtotime($data_cadastro)));

                        $data_atual = date("Y-m-d");

//                  var_dump($data_tot_contrato);die;
//            print_r($data_tot_contrato);
//                echo "***********";
//                  print_r($data_atual);
//                echo "***********";
//                  print_r($qtd_dias);
//                echo "***********";
                        //verificando se a data atual for maior que a data do (contrato+dias do plano) se for maior vai criar um novo contrato.
                        if ($data_atual > $data_tot_contrato) {
                            if ($data['permissao'][0]->renovar_contrato_automatico == 't') {
                                $contrato_ativo = $this->guia->gravarnovocontratoanual($paciente_contrato_id);
                            } else {
                                $contrato_ativo = $this->guia->gravarnovocontratoanualdesativar($paciente_contrato_id);
                            }
                        }
                    }
                }
            }
        } else {
            echo 'false';
        }
    }

    function confirmarpagamentoautomaticoiuguempresa() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelasempresa();

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
                    $this->guia->confirmarpagamentoautomaticoiuguempresa($item->paciente_contrato_parcelas_id);
                }
                if ($retorno['status'] == 'expired') {
                    //$this->guia->excluirpagamentoautomaticoiugu($item->paciente_contrato_parcelas_id);
                }
            }
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function confirmarpagamentoautomaticogerencianet() {
//        $invoice_id = $_POST["data"]['id'];
//        $status = $_POST["data"]['status'];
        set_time_limit(0); // Limite de tempo de execução: 2h. Deixe 0 (zero) para sem limite
        ignore_user_abort(true); // Não encerra o processamento em caso de perda de conexão
        $pagamento = $this->paciente_m->listarparcelagerncianetpendentes();

        $empresa = $this->guia->listarempresa();
//        echo "<pre>";
//        print_r($pagamento);
//        die;

        $client_id = $empresa[0]->client_id;
        $client_secret = $empresa[0]->client_secret;

        $options = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
        ];


        if ($client_id != "" && $client_secret != "") {
            foreach ($pagamento as $item) {
                if ($item->carne == "t") {

                    $params = [
                        'id' => $item->carnet_id
                    ];
                    try {
                        $api = new Gerencianet($options);
                        $carnet = $api->detailCarnet($params, []);
                        $carnet['data']['charges'];
                        foreach ($carnet['data']['charges'] as $value) {
                            if ($item->charge_id == $value['charge_id'] && ($value['status'] == "settled" || $value['status'] == "paid") && $item->num_carne == $value['parcel']) {
                                $this->guia->confirmarpagamentoautomaticogerencianet($item->paciente_contrato_parcelas_id);
                            } else {
                                
                            }
                        }
                    } catch (GerencianetException $e) {
                        print_r($e->code);
                        print_r($e->error);
                        print_r($e->errorDescription);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                } else {

                    $params = [
                        'id' => $item->charge_id // $charge_id refere-se ao ID da transação ("charge_id")
                    ];
                    try {
                        $api = new Gerencianet($options);
                        $charge = $api->detailCharge($params, []);
                        echo '<pre>';
//                    print_r($charge);
                    } catch (GerencianetException $e) {
                        print_r($e->code);
                        print_r($e->error);
                        print_r($e->errorDescription);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }

                    if ($charge['data']['status'] == "settled" || $charge['data']['status'] == "paid") {
                        $this->guia->confirmarpagamentoautomaticogerencianet($item->paciente_contrato_parcelas_id);
                    }
                }
            }


            echo 'true';
        } else {
            echo 'false';
        }
    }

    function verificarcpfpaciente() {
        $cpf = $_GET['cpf'];
        $cpf_responsavel = $_GET['cpf_responsavel'];
        $paciente_id = $_GET['paciente_id'];
        $mensagem = '';
        if ($cpf != "" && $cpf != "000.000.000-00") {
            if ($this->utilitario->validaCPF($cpf)) {
                $contadorcpf = $this->paciente_m->contadorcpfautocomplete($cpf, $paciente_id);
                if ($cpf_responsavel == 'on') {
                    $contadorcpf = 0;
                }
                if ($contadorcpf > 0) {
                    $mensagem = 'CPF do paciente já cadastrado';
                }
            } else {
                $mensagem = 'Erro ao gravar paciente. CPF inválido';
            }
        }
        echo json_encode($mensagem);
    }
    

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
