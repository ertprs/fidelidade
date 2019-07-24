<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Histório de ações realizadas no agendamento</h3>
        <div>
           
                <fieldset>
               
                   <table border="1">
                        <thead>
                            <tr>
                                <th class="tabela_header">Responsável pela Marcação</th>
                                <th class="tabela_header">Responsável pela Alteração</th>
                                <th class="tabela_header">Responsável pela Exclusão</th>
                                 <th class="tabela_header">Responsável pela Autorização</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?
                            foreach ($lista as $item) :
                                ?>
                                <tr>
                                    <td width="400px;"><?= $item->nome_responsavel; ?></td>
                                    <td width="400px;"><?= $item->nome_atualizacao; ?></td>
                                    <td width="200px;"><?= $item->nome_cancelamento; ?> </td>
                                    <td width="200px;"><?= $item->nome_autorizacao; ?> </td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                    
                    
           
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript">
    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);

</script>