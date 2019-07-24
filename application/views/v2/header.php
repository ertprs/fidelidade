<?
//Da erro no home

if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>MED PLURAL - SISTEMA DE FIDELIDADE</title>

    <?php show_styles(); ?>
</head>
<body class="theme-blue">

<?php $this->load->view('v2/_parts/navbar'); ?>

<section>
    <?php $this->load->view('v2/_parts/left_sidebar'); ?>
</section>

<section class="content">
    <div class="container-fluid">
