<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
    <head>
        <title>STG - CLINICAS v1.0</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/forms.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/form-style.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/form-structure.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>

    </head>
    <body>

        <div class="header">
            <div id="imglogo">
                <img src="<?= base_url(); ?>img/stg - logo.jpg" alt="Logo"
                     title="Logo" height="70" id="Insert_logo"/>
                <div id="sis_info">SISTEMA DE GESTAO DE CLINICAS - v1.0</div>
            </div>
        </div>


        <?php
        if (strlen($mensagem)) {
            $divMensagem = "<div id='div_mensagem'>" . $mensagem . "</div>";
            echo $divMensagem;
            unset($mensagem);
        }
        ?>

        <div id="login">
            <div id="login-box">
                <h2>Verificar</h2>
                <form name="form_login" id="form_login" action="<?= base_url() ?>verificar/validarcpf"
                      method="post">


                    <div>
                        <label id="labelUsuario">CPF</label>
                        <input type="text" id="cpf" name="cpf" maxlength="11" class="texto05" value="<?= @$obj->_login; ?>" />  
                    </div>

                    <div style="padding-left: 110px;">
                        <button type="submit" name="btnEnviar">Verificar</button>  
                    </div>






                </form>

            </div>
        </div>
    </body>
</html>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('#form_login').validate({
            rules: {
                txtLogin: {
                    required: true,
                    minlength: 3
                },
                txtSenha: {
                    required: true,
                    minlength: 3
                },
                txtempresa: {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                txtLogin: {
                    required: "",
                    minlength: "!"
                },
                txtSenha: {
                    required: "",
                    minlength: "!"
                },
                txtempresa: {
                    required: "",
                    minlength: "!"
                }
            }
        });
    });

</script>
