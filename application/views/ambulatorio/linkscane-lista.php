<html>
    <head>
        <title>Links</title>
        <meta charset="utf-8">
    </head>
    <style>
        tr:nth-child(2n+2) {
    background: #ccc;
        }a{
            text-decoration: none;
        }
        td{            
            font-family: arial;
        }
    </style>
    <body>
        <table border=1 cellspacing=0 cellpadding=2 bordercolor="666633" style="width: 100%;">
            <tr>
                <td>Links</td>
            </tr>

            <?php
            foreach ($listarpagamentoscontrato as $item) {
                @$quantidade_cada{$item->link_carne} ++;
            }
            foreach ($listarpagamentoscontrato as $item) {
                if ($item->carne == "t") {

                    if (@$count{$item->link_carne} > 0) {
                        
                    } else {
                        @$carner_gerado = "true";
                        ?>
                        <tr><td>
                                <a href="<?= @$item->link_carne; ?>" target="_blank" >Carnê <?= @$quantidade_cada{$item->link_carne}; ?>x R$<?= @$item->valor; ?></a>
                            </td>
                        </tr>   

                        <?
                        @$count{$item->link_carne} ++;
                    }
                    @$quantidade_cada{$item->link_carne} ++; //contar quantidade de parcela de cada;
                }
            }
            ?>

        </table>

    </body>
</html>

