<html>
    <head>
        <title>title</title>

        <style>
            body{


                background-color: silver;
            }

        </style>

        <meta charset="utf-8">
    </head>
    <body>
        <h1>Alterar Quantidade funcionários</h1>
        <form action="<?= base_url() ?>cadastros/pacientes/atualizarquantidadefuncionarios" method="post">
            
            <input type="number" name="quantidade_fun"  min="1"  > <br>
            <input type="hidden" name="plano_id"  value="<?= $plano_id; ?>" > <br>
            <input type="hidden" name="qtd_funcionarios_empresa_id" value="<?= $qtd_funcionarios_empresa_id; ?>"  > <br>
            <input type="hidden" name="empresa_id"  value="<?= $empresa_id; ?>" > <br>

            <input type="submit" value="Alterar">
        </form>

    </body>
</html>
