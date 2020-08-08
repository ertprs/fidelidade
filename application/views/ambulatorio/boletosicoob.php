
<?php
if($agencia == "" || $conta_corrente == "" || $convenio == ""){
    echo "<h2>Favor, verificar dados da Empresa</h2>";
}

// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto BANCOOB/SICOOB: Marcelo de Souza              |
// | Ajuste de algumas rotinas: Anderson Nuernberg                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

if(@!function_exists(formata_numdoc))
	{
		function formata_numdoc($num,$tamanho)
			{
				while(strlen($num)<$tamanho)
					{
						$num= "0".$num; 
					}
				return $num;
			}
	}

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 0;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", strtotime($vencimento) + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $valor_boleto; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$num_contrato_con = $conta_corrente."-1"; // Número do contrato: É o mesmo número da conta
$agencia = $agencia;

while(strlen($paciente_contrato_id) < 7) {
      $paciente_contrato_id = "1".$paciente_contrato_id; 
}

$NossoNumero = formata_numdoc($paciente_contrato_id,7);  // Até 7 dígitos, número sequencial iniciado em 1 (Ex.: 1, 2...)

$qtde_nosso_numero = strlen($NossoNumero);
$sequencia = formata_numdoc($agencia,4).formata_numdoc(str_replace("-","",$num_contrato_con),10).formata_numdoc($NossoNumero,7);
$cont=0;
$calculoDv = 0;
for($num=0;$num<=strlen($sequencia);$num++)
	{
		$cont++;
		if($cont == 1)
			{
				$constante = 3;
			}
		if($cont == 2)
			{
				$constante = 1;
			}
		if($cont == 3)
			{
				$constante = 9;
			}
		if($cont == 4)
			{
				$constante = 7;
				$cont = 0;
			}
		$calculoDv = $calculoDv + (substr($sequencia,$num,1) * $constante);
	}

$Resto = $calculoDv % 11;
if($Resto == 0 || $Resto == 1)
	{
		$Dv = 0;
	}
else
	{
		$Dv = 11 - $Resto;
	}
        
      

$dadosboleto["nosso_numero"] = $NossoNumero.$Dv;

$dadosboleto["nosso_numero_mostrar"] = $NossoNumero."-".$Dv;

$dadosboleto["numero_documento"] = "$paciente_contrato_id";	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $paciente;
$dadosboleto["endereco1"] = $logradouro;
$dadosboleto["endereco2"] = $municipio." - ". $estado." - "."CEP:". $cep;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = $valor_cobrado;
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS ESPECIFICOS DO SICOOB
$dadosboleto["modalidade_cobranca"] = "01";
$dadosboleto["numero_parcela"] = "001";


// DADOS DA SUA CONTA - BANCO SICOOB
$dadosboleto["agencia"] = $agencia; // Num da agencia, sem digito
$dadosboleto["conta"] = $conta_corrente; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - SICOOB
$dadosboleto["convenio"] = "0".$convenio;  // Num do convênio - É o mesmo número da conta_cedente formatado de outra forma, exemplo: Se a conta é 19719-0, então o convênio é: 0197190
$dadosboleto["carteira"] = "1";

// SEUS DADOS
$dadosboleto["identificacao"] = $paciente_contrato_id;
$dadosboleto["cpf_cnpj"] = $cnpj;
$dadosboleto["endereco"] = $logradouroEmpresa;
$dadosboleto["cidade_uf"] = $municipio." / ".$estado;
$dadosboleto["cedente"] = $cedente." / ".$cnpj;

// NÃO ALTERAR!
  include_once("./sicoob/funcoes_bancoob.php"); 
  include("./sicoob/layout_bancoob.php");
?>

<script type="text/javascript">  
//   print();
</script>