<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="true"></a>
            <a href="javascript:void(0);" class="bars" style="display: none;"></a>
            <a class="navbar-brand" href="<?= site_url('/'); ?>">Med Plural</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse" aria-expanded="true">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
<!--                <li>-->
<!--                    <a href="javascript:void(0);" class="js-search" data-close="true">-->
<!--                        <i class="material-icons">search</i>-->
<!--                    </a>-->
<!--                </li>-->
                <!-- #END# Call Search -->
                <li>
                    <a>Seja Bem-Vindo(a) <?= $this->session->userdata('login'); ?>!</a>
                </li>
                <!-- Deslogar -->
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="body">
                            <a href="<?php echo site_url('login/sair'); ?>" onclick="return confirm('Deseja realmente sair da aplicação?');" class=" waves-effect waves-block">Sair</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Deslogar -->
            </ul>
        </div>
    </div>
</nav>