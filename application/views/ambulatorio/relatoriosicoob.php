

<style>
    * {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

body {
    background: #353a40;
}

table {
    border-collapse: separate;
    background: #fff;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    margin: 50px auto;
    -moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
}

thead {
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
}

thead th {
    font-family: 'Patua One', cursive;
    font-size: 16px;
    font-weight: 400;
    color: #fff;
    text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
    text-align: left;
    padding: 20px;
    background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzY0NmY3ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzRhNTU2NCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    background-size: 100%;
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #646f7f), color-stop(100%, #4a5564));
    background-image: -moz-linear-gradient(#646f7f, #4a5564);
    background-image: -webkit-linear-gradient(#646f7f, #4a5564);
    background-image: linear-gradient(#646f7f, #4a5564);
    border-top: 1px solid #858d99;
}
thead th:first-child {
    -moz-border-radius-topleft: 5px;
    -webkit-border-top-left-radius: 5px;
    border-top-left-radius: 5px;
}
thead th:last-child {
    -moz-border-radius-topright: 5px;
    -webkit-border-top-right-radius: 5px;
    border-top-right-radius: 5px;
}

tbody tr td {
    font-family: 'Open Sans', sans-serif;
    font-weight: 400;
    color: #5f6062;
    font-size: 13px;
    padding: 20px 20px 20px 20px;
    border-bottom: 1px solid #e0e0e0;
}

tbody tr:nth-child(2n) {
    background: #f0f3f5;
}

tbody tr:last-child td {
    border-bottom: none;
}
tbody tr:last-child td:first-child {
    -moz-border-radius-bottomleft: 5px;
    -webkit-border-bottom-left-radius: 5px;
    border-bottom-left-radius: 5px;
}
tbody tr:last-child td:last-child {
    -moz-border-radius-bottomright: 5px;
    -webkit-border-bottom-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

tbody:hover > tr td {
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    opacity: 0.5;
    /* uncomment for blur effect */
    /* color:transparent;
    @include text-shadow(0px 0px 2px rgba(0,0,0,0.8));*/
}

tbody:hover > tr:hover td {
    text-shadow: none;
    color: #2d2d2d;
    filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
    opacity: 1;
}
</style>


<?
// echo '<pre>';
// print_r($relatorio);
// die;

function cmp($a, $b) {
	return $a['status'] > $b['status'];
}

usort($relatorio, 'cmp');

// echo '<pre>';
// print_r($relatorio);
// die;
?>

<select name="status" id="status" onchange="AlterarTabela()">
    <option value="0">Selecione</option>
    <option value="2">Entradas Confirmadas</option>
    <option value="3">Entradas Rejeitadas</option>
    <option value="6">Liquidações</option>
    <option value="9">Baixas</option>
    <option value="11">Títulos em Carteira (Em Ser)	</option>
</select>


        <table id="relatoriogeral">
            <thead>
                <tr>
                    <th>Titular</th>
                    <th>Status</th>
                    <th>Data Liquidação</th>
                    <th>Nosso Número</th>
                    <th>Seu Número</th>
                </tr>
            </thead>
            <tbody id="tabelarelatorio">
<?


    foreach($relatorio as $item){
        ?>
            <tr>
            <td><?=$item['nome']?></td>
            <td><?=$item['status']?></td>
            <td><?=$item['pagamento']?></td>
            <td><?=$item['nossonumero']?></td>
            <td><?=$item['seunumero']?></td>
            </tr>

        <?
    }

?>
            </tbody>
        </table>

        <script type="text/javascript" src="<?= base_url() ?>js/bootstrap4/jquery-3.5.1.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>

<script type="text/javascript">

function AlterarTabela(){
    // console.log($("#status").val());
    id_parcela = $("#status").val();
    array_parcelas = <?=json_encode($relatorio)?>;

    if(id_parcela > 0){

        if(id_parcela == 2){
            texto = '02 - Entrada Confirmada';
        }else if(id_parcela == 3){
            texto = '03 - Entrada Rejeitada';
        }else if(id_parcela == 6){
            texto = '06 - Liquidação';
        }else if(id_parcela == 9){
            texto = '09 - Baixa';
        }else if(id_parcela == 11){
            texto = '11 - Títulos em Carteira (Em Ser)';
        }

        $("#tabelarelatorio").remove();

        table = '';
        // console.log(array_parcelas[0].status);
        table += '<tbody id="tabelarelatorio">'
        for(c = 0; c < array_parcelas.length; c++){

            if(texto != array_parcelas[c].status){
                continue;
            }
            
            table += '<tr>';
            table += '<td>'+array_parcelas[c].nome+'</td>';
            table += '<td>'+array_parcelas[c].status+'</td>';
            table += '<td>'+array_parcelas[c].pagamento+'</td>';
            table += '<td>'+array_parcelas[c].nossonumero+'</td>';
            table += '<td>'+array_parcelas[c].seunumero+'</td>';
            table += '</tr>';

        }
        table += '</tbody>';

        $("#relatoriogeral").append(table);
    }else{

        $("#tabelarelatorio").remove();

        table = '';
        // console.log(array_parcelas[0].status);
        table += '<tbody id="tabelarelatorio">'
        for(c = 0; c < array_parcelas.length; c++){
            
            table += '<tr>';
            table += '<td>'+array_parcelas[c].nome+'</td>';
            table += '<td>'+array_parcelas[c].status+'</td>';
            table += '<td>'+array_parcelas[c].pagamento+'</td>';
            table += '<td>'+array_parcelas[c].nossonumero+'</td>';
            table += '<td>'+array_parcelas[c].seunumero+'</td>';
            table += '</tr>';

        }
        table += '</tbody>';

        $("#relatoriogeral").append(table);


    }
}
// $("#tabelarelatorio").remove();
</script>
            