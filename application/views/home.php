<div class="content">

</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>




<script type="text/javascript">

    
    $(document).ready(function () {
        
        $.getJSON('<?= base_url() ?>autocomplete/pagamentoautomaticoiugu', {plano: 'teste', ajax: true}, function (j) {
//           alert(j);
//                    
        });
        
        $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticoiugu', {plano: 'teste', ajax: true}, function (j) {
//           alert(j);
//                    
        });
        
         $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticoiuguempresa', {plano: 'teste', ajax: true}, function (j) {
//           alert(j); 
        });
        
        $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticoconsultaavulsaiugu', {plano: 'teste', ajax: true}, function (j) {
//           alert(j);
//                    
        });
        
         $.getJSON('<?= base_url() ?>autocomplete/verificarcontratospacientes', {plano: 'teste', ajax: true}, function (j) {
//           alert("teste");
//                    
        });
        
        
         $.getJSON('<?= base_url() ?>autocomplete/confirmarpagamentoautomaticogerencianet', {plano: 'teste', ajax: true}, function (j) {
//           alert(j);
//                    
        });
        
        
    });







</script>