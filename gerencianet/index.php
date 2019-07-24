<meta charset="utf-8">
<?php

 
require __DIR__.'/vendor/autoload.php'; // caminho relacionado a SDK
 
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = 'Client_Id_31c496ecb4fcc3dd56f83214a4ba72b3397b60dc'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientSecret = 'Client_Secret_12f09c6f274634b64585bee8a26a3d200fc8f228'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
];
 
$item_1 = [
    'name' => 'Item 1', // nome do item, produto ou serviço
    'amount' => 1, // quantidade
    'value' => 500, // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)

];
 
$item_2 = [
    'name' => 'Item 2', // nome do item, produto ou serviço
    'amount' => 2, // quantidade
    'value' => 500 // valor (2000 = R$ 20,00)
];
 
$items =  [
    $item_1 
];


// Exemplo para receber notificações da alteração do status da transação:
// $metadata = ['notification_url'=>'sua_url_de_notificacao_.com.br']
// Outros detalhes em: https://dev.gerencianet.com.br/docs/notificacoes
//$items =  [
//    $item_1,
//    $item_2
//];

// Como enviar seu $body com o $metadata
// $body  =  [
//    'items' => $items,
//    'metadata' => $metadata
// ];

 
$metadata = ['notification_url'=>'http://localhost/gerencianet/index.php'];


$body  =  [
    'items' => $items,
      'metadata' => $metadata

];

try {
    $api = new Gerencianet($options);
    $charge = $api->createCharge([], $body);
    // echo "<pre>"; 
    // print_r($charge); 

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

 

$charge_id = $charge['data']['charge_id'];





$params = [
  'id' => $charge_id // $charge_id refere-se ao ID da transação ("charge_id")
];

try {
    $api = new Gerencianet($options);
    $charge = $api->detailCharge($params, []);
    // echo '<pre>';
    // print_r($charge);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}



$params = [
  'id' => $charge_id
];
 
$customer = [
  'name' => 'Gorbadoc Oldbuck', // nome do cliente
  'cpf' => '94271564656' , // cpf válido do cliente
  'phone_number' => '5144916523', // telefone do cliente
   'birth' => '2000-09-11' // telefone do cliente

];
 
$bankingBillet = [
  'expire_at' => '2019-12-12', // data de vencimento do boleto (formato: YYYY-MM-DD)
  'customer' => $customer
];
 
$payment = [
  'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
];
 
$body = [
  'payment' => $payment
];
 
try {
    $api = new Gerencianet($options);
    $charge = $api->payCharge($params, $body);
    // print_r($charge);

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
 
 



 
 //marcar como pago
// $params = [
//   'id' => $charge_id
// ];
 
// try {
//     $api = new Gerencianet($options);
//     $charge = $api->settleCharge($params, []);
//   echo '<pre>';
//     print_r($charge);
// } catch (GerencianetException $e) {
//     print_r($e->code);
//     print_r($e->error);
//     print_r($e->errorDescription);
// } catch (Exception $e) {
//     print_r($e->getMessage());
// }

 
?>


<!DOCTYPE html>
 <html>
 <head>
   <title></title>
 </head>
 <body>
 <table border="2">
   <tr>
     <td>Nome</td>
      <td>Preço</td>
<td>Forma de pagamento</td>
      <td>Status</td>
      <td>Visualizar Boleto</td>
       <td> PDF</td>
   </tr>
   <tr>
    <td>Arroz</td>
     <td><?php echo $charge['data']['total']/100 ?></td>
     <td><?php echo $charge['data']['payment']   ?></td>
      <td><?php echo $charge['data']['status'] ?></td>
       <td><a href=<?php echo $charge['data']['link'] ?> target='_blank'>Link</a></td>
        <td><a href=<?php echo $charge['data']['pdf']['charge'] ?> target='_blank'>PDF</a></td>
   </tr>

 </table>
 </body>
 </html> 


