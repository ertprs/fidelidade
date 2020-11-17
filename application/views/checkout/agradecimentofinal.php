<html>
    <head>
        <title>STG - Checkout Cartão</title>
        <meta charset='UTF-8' />

        <link href="<?= base_url() ?>css/bootstrap4/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/bootstrap4/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/jquery-3.5.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/bootstrap.bundle.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/sweetalert2.all.min.js"></script>
    </head>

</html>

<script type="text/javascript">


$(document).ready(function(){

    Swal.fire({
            title: 'Agradeçemos Pela sua Preferência!',
            text: "Seus Dados já foram salvos e no momento estamos processando as informações de seu Cartão de Cŕedito, em breve você receberá um email com mais informações",
            icon: 'success',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?=base_url()?>checkout/inicio/";
            }
            });

})


</script>