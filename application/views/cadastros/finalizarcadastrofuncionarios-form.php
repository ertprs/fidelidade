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
        <h2>Finalizar Cadastro de funcionarios</h2>
        <form action="<?= base_url() ?>cadastros/pacientes/finalizarcadastrofuncionarios" method="post"> 
            <div>
                <label>  Forma de Pagamento</label>
                <select name="forma_rendimento" id="forma_rendimento_id" required=""> 
                    <option value="">Selecione</option>
                    <?
                    foreach ($forma_rendimento as $item) {
                        ?> 
                        <option value="<?= $item->forma_rendimento_id ?>" ><?= $item->nome ?></option> 
                        <?
                    }
                    ?> 
                </select>
                <br>
            </div>
            <div>
                <label> Vencimento</label>
                <input type="number" name="vencimento" min="1" max="31" value="<?= date('d'); ?>"> 
                <input type="hidden" name="empresa_id"  value="<?= $empresa_id; ?>" > <br> 
            </div> 
            <div>
                <label>Vendedor</label> 
                <select name="vendedor" id="vendedor" class="size2" required="" >
                    <option value="" >selecione</option>
                    <?php
                    $listarvendedor = $this->paciente->listarvendedor();
                    foreach ($listarvendedor as $item) {
                        ?>
                        <option   value =<?php echo $item->operador_id; ?> ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>  
            <input type="submit" value="Finalizar"> 
        </form> 
    </body>
</html>
