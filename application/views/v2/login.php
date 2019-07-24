<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
<head>
    <title>STG - CLINICAS v1.0</title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <?php show_styles(); ?>
</head>
<body>

<!--<div class="header">-->
<!--    <div id="imglogo">-->
<!--        <img src="--><?//= base_url(); ?><!--img/stg - logo.jpg" alt="Logo"-->
<!--             title="Logo" height="70" id="Insert_logo"/>-->
<!--        <div id="sis_info">SISTEMA DE GESTAO DE CLINICAS - v1.0</div>-->
<!--    </div>-->
<!--</div>-->


﻿<div class="login-page">
    <div class="login-box">
        <div class="logo">
            <a id="texto_logo" class="texto-logo" href="javascript:void(0);"><strong>MED PLURAL</strong>
            </a>
            <!--            <small>Sistema</small>-->
        </div>
        <div class="card">
            <div class="body">
                <form id="login" method="post" action="<?php echo site_url('login/autenticar/'); ?>">
                    <div class="msg"></div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" id="txt_login" name="txtLogin" placeholder="Usuário" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                        <div class="form-line">
                            <input type="password" id="txt_senha" class="form-control" name="txtSenha" placeholder="Senha" required>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <select class="form-control show-tick" id="txt_empresa" name="txtEmpresa" required>
                                        <?php foreach ($empresas as $empresa):?>
                                            <option value="<?= $empresa['empresa_id'] ?>">
                                                <?php echo $empresa['nome'] ?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>

                                </div>
                            <div class="row clearfix">
                                <!--                    <div class="col-xs-8 p-t-5">-->
                                <!--                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-indigo">-->
                                <!--                        <label for="rememberme">Lembrar</label>-->
                                <!--                    </div>-->
                                <div class="col-md-12">
                                    <button class="btn btn-block bg-indigo waves-effect" type="submit">Login</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="row m-t-15 m-b&#45;&#45;20">-->
                    <!--                    <div class="col-xs-6">-->
                    <!--                    <a href="sign-up.html">Register Now!</a>-->
                    <!--                    </div>-->
                    <!--                    <div class="col-xs-6 align-right">-->
                    <!--                    <a href="forgot-password.html">Forgot Password?</a>-->
                    <!--                    </div>-->
                    <!--                    </div>-->
                </form>
            </div>
        </div>
    </div>
</div>
<?php show_javascripts();?>
</body>
</html>
