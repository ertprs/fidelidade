 
<html>
    <head>
        <title>Documento</title>
        <meta charset="utf-8">
        <style>
            td{
                font-family: arial;
            }
        </style>
    </head>
    <body>
        <table  border=1 cellspacing=0 cellpadding=2 bordercolor="black">
            <tr>
                <td>Nome</td>
                <td>Nº Autorização</td>
                <td>Procedimento</td>
                <td>Data / Hora</td>
                <td>Parceiro</td>
                <td>Autorizador</td>
                <td>Plano</td>
                <?php
                if (@$addcolum == "sim") {
                    ?>
                    <td>Operador Autorização</td>
                    <?
                }
                ?>
                <?php
                foreach ($lista as $item) {
                    ?>
                <tr>
                    <td><?= @$item->paciente ?></td>
                    <td><?= @$item->numero_autorizacao ?></td>
                    <td><?= @$item->procedimento ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($item->data_cadastro)) ?></td>
                    <td><?= @$item->razao_social ?></td>
                    <?php
                    if (@$addcolum == "sim") {
                        ?>
                        <td>
                            <?= @$item->operador_autorizacao ?>
                        </td>
                        <?php
                    }
                    ?>
                    <?php if (@$item->operador_autorizacao != "") {
                        ?>
                        <td> <?= @$item->operador_autorizacao ?></td>
                    <?php } else { ?>
                        <td>Autorização Direta</td>
                    <? } ?>
                    <td> <?= @$item->plano ?></td>

                </tr>

                <?
            }
            ?>
        </tr>
    </table>

</body>
</html>
