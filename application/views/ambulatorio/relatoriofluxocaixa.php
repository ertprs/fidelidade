<div class="content"> <!-- Inicio da DIV content -->
    <? $empresas = $this->exame->listarempresas(); ?>
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Fluxo de Caixa</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/caixa/gerarelatoriofluxocaixa">
                <dl>
                    <dt>
                        <label>Tipo de Pesquisa</label>
                    </dt>
                    <dd>
                        <select name="tipoPesquisa" id="tipoPesquisa" class="size2">
                            <option value="MENSAL">MENSAL</option>
                            <option value="ANUAL">ANUAL</option>
                         
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Período</label>
                    </dt>
                    <dd>
                        <select name="mes" id="mes" class="size2">
                            <option value="01">JANEIRO</option>
                            <option value="02">FEVEREIRO</option>
                            <option value="03">MARÇO</option>
                            <option value="04">ABRIL</option>
                            <option value="05">MAIO</option>
                            <option value="06">JUNHO</option>
                            <option value="07">JULHO</option>
                            <option value="08">AGOSTO</option>
                            <option value="09">SETEMBRO</option>
                            <option value="10">OUTUBRO</option>
                            <option value="11">NOVEMBRO</option>
                            <option value="12">DEZEMBRO</option>
                        </select>
                        <input type="number" name="ano" class="size1" id="ano" min=2000 required/>
                    </dd>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresas as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="">TODOS</option>
                        </select>
                    </dd>
                </dl>
                <button type="submit" >Pesquisar</button>

            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


    $(function () {
        $("#accordion").accordion();
    });

    $('#tipoPesquisa').change(function () {
        trocarAnoMes();
    });

    function trocarAnoMes(){
        if($('#tipoPesquisa').val() == 'MENSAL'){
            $('#ano').hide();
            $('#mes').show();
            $("#ano").prop('required', false);
        }else{
            $('#ano').show();
            $('#mes').hide();
            $("#ano").prop('required', true);
        }
    }

    trocarAnoMes();

</script>