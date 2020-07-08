 
<meta charset="UTF-8">

<html>
    <head>
        <title>Impressões</title>
    </head>
    <body style="background-color: silver;">

        <table border="2"  width="100%" >
            <tr>
                <td>Operador</td>
                <td>Data</td>
            </tr>

            <?
             
            foreach ($impressoes as $item) {
                ?>
                <tr>
                    <td><?= $item->operador_cadastro; ?></td>
                    <td><?
                        $date = $item->data_cadastro;
                        $ts = strtotime($date);
                        echo date('d/m/Y H:i:s', $ts);?></td>
                    <td   width="50px;">       
                        <div class="bt_link_new" style="width: 100px;">
                            <a   href="<?= base_url() . "ambulatorio/guia/impressaorecibocarteira/" . @$item->titular_id."/".$item->dependente_id."/".$item->impressoes_contratro_dependente_id; ?>">
                                 Recibo
                            </a>
                        </div>
                      </td>
                </tr>


    <?
}
?>



        </table>

    </body>
</html>

<script type="text/javascript">


</script>