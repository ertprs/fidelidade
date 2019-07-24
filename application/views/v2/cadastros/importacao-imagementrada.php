<div class="card">
    <div class="header"><h3>Carregar imagem entrada</h3></div>
    <div class="body">
        <?= form_open_multipart(site_url('/cadastros/caixa/importarimagementrada'), [
            'class' => 'dropzone',
            'id' => 'frmFileUpload'
        ]); ?>
        <input type="hidden" name="paciente_id" value="<?= $entradas_id; ?>" />
        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="dz-message">
                    <div class="drag-icon-cph">
                        <i class="material-icons">touch_app</i>
                    </div>
                    <h3>Jogue as imagens aqui ou clique para carregá-las.</h3>
                    <em>(As imagens serão enviadas automaticamente a medida que são selecionadas.)</em>
                </div>
                <div class="fallback">
                    <input name="userfile" type="file" />
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<div class="card">
    <div class="header"><h3>Visualizar imagens</h3></div>
    <div class="body">
        <div class="list-unstyled row clearfix galeria-imagens">
            <?php foreach ($arquivo_pasta as $value): ?>
                <?php
                $baseUrl = base_url();
                $imagem = site_url("/upload/entrada/" . $entradas_id . "/" . $value);
                $botaoExcluir = "<a class='btn btn-danger waves-effect waves-float botao-excluir-arquivo' href='{$baseUrl}cadastros/caixa/ecluirimagementrada/$entradas_id/$value\'>Excluir</a>";
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <a href="<?= $imagem; ?>"
                       data-sub-html="<?= $botaoExcluir; ?>">
                        <img class="img-responsive thumbnail" src="<?= $imagem ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>