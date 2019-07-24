<script type="text/javascript" src="https://js.iugu.com/v2"></script>
<?
$string = base64_encode("e4c1fc720f305fbcba7325f387fa3eb8:");
$string = "Basic " . $string;
header("Access-Control-Allow-Origin: *");
//var_dump($string); die;
?>




<script>
Iugu.setTestMode(true);
Iugu.setup();

//alert('asad');

var data = JSON.stringify({
  "method": "bank_slip",
//  "api_token": "e4c1fc720f305fbcba7325f387fa3eb8",
  "email": "cleysonalves1999@gmail.com",
  "items": [
    {
      "description": "TESTE",
      "quantity": 1,
      "price_cents": 10000
    }
  ],
  "payer": {
    "cpf_cnpj": "07430894305",
    "name": "Cleyson Alves dos Santos",
    "phone_prefix": "85",
    "phone": "996954467",
    "email": "cleysonalves1999@gmail.com",
    "address": {
      "street": "Rua Cruzeiro Velho",
      "number": "1011",
      "district": "Jurema",
      "city": "Caucaia",
      "state": "CE",
      "zip_code": "61652330"
    }
  }
});

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;



xhr.addEventListener("readystatechange", function () {
  if (this.readyState === this.DONE) {
//    console.log(this.responseText);
//    alert(this.responseText);
  }
});

xhr.open("POST", "https://api.iugu.com/v1/charge");
//xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
//xhr.setRequestHeader("Access-Control-Allow-Headers", "Origin, X-Request-Width, Content-Type, Accept");
//header;
xhr.setRequestHeader('Authorization','<?=$string?>');
xhr.send(data);
</script>