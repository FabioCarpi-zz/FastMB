<script>
    var num;
    
    function Calcular(){
        num = document.simulador.reais.value / document.simulador.compra.value;
        document.simulador.bitcoins.value = num.toFixed(8);
        num = document.simulador.bitcoins.value * 0.003;
        document.simulador.taxac.value = num.toFixed(8);
        num = document.simulador.bitcoins.value - document.simulador.taxac.value;
        document.simulador.comprado.value = num.toFixed(8);
        num = document.simulador.compra.value * 1.01;
        document.simulador.venda.value = num.toFixed(5);
        num = document.simulador.comprado.value * 0.003;
        document.simulador.taxav.value = num.toFixed(8);
        num = document.simulador.comprado.value - document.simulador.taxav.value;
        document.simulador.vendido.value = num.toFixed(8);
        num = document.simulador.vendido.value * document.simulador.venda.value;
        document.simulador.saldo.value = num.toFixed(5);
        num = document.simulador.saldo.value - document.simulador.reais.value;
        document.simulador.ganho.value = num.toFixed(5);
        num = (document.simulador.saldo.value - document.simulador.reais.value) * 100 / document.simulador.reais.value;
        document.simulador.lucro.value = num.toFixed(2) + "%";
    }

    function Calcular2(){
        num = document.simulador.vendido.value * document.simulador.venda.value;
        document.simulador.saldo.value = num.toFixed(5);
        num = document.simulador.saldo.value - document.simulador.reais.value;
        document.simulador.ganho.value = num.toFixed(5);
        num = (document.simulador.saldo.value - document.simulador.reais.value) * 100 / document.simulador.reais.value;
        document.simulador.lucro.value = num.toFixed(2) + "%";
    }
</script>

<br><br>
<form name="simulador">
    <table class="Center">
        <tr>
            <td>Reais:</td>
            <td><input type="text" name="reais" size="13" onkeyup="Calcular()" onchange="Calcular()"></td>
            <td><input type="button" value="&lt;&lt;" onclick="
                document.simulador.reais.value = document.getElementById('brl').innerHTML;
            "></td>
        </tr>
        <tr>
            <td>Valor pretendido:</td>
            <td><input type="text" name="compra" size="13" onkeyup="Calcular()" onchange="Calcular()">
            </td>
            <?php $dados = json_decode(file_get_contents("https://www.mercadobitcoin.net/api/ticker/"), true);?>
            <td><input type="button" value="&lt;&lt;" onclick="
                document.simulador.compra.value = <?php echo $dados["ticker"]["last"];?>;
                Calcular();
            "></td>
        </tr>
        <tr>
            <td>Bitcoins:</td>
            <td><input type="text" name="bitcoins"  size="13" disabled></td>
            <td><input type="button" value="&gt;&gt;" onclick="
                document.forme.valor.value = document.simulador.compra.value;
                document.forme.volume.value = document.simulador.bitcoins.value;
            "></td>
        </tr>
        <tr>
            <td>Taxa compra:</td>
            <td><input type="text" name="taxac" size="13" disabled></td>
        </tr>
        <tr>
            <td>Comprado:</td>
            <td><input type="text" name="comprado" size="13" disabled></td>
        </tr>
        <tr>
            <td>Valor pretendido:</td>
            <td><input type="text" name="venda" size="13" onkeyup="Calcular2()" onchange="Calcular2()"></td>
            <td><input type="button" value="&lt;&lt;" onclick="
                document.simulador.venda.value = <?php echo $dados["ticker"]["last"];?>;
                Calcular2();
            "></td>
        </tr>
        <tr>
            <td>Taxa venda:</td>
            <td><input type="text" name="taxav" size="13" disabled></td>
        </tr>
        <tr>
            <td>Vendido:</td>
            <td><input type="text" name="vendido" size="13" disabled></td>
        </tr>
        <tr>
            <td>Saldo:</td>
            <td><input type="text" name="saldo" size="13" disabled></td>
        </tr>
        <tr>
            <td>Ganho:</td>
            <td><input type="text" name="ganho" size="13" disabled></td>
        </tr>
        <tr>
            <td>Lucro:</td>
            <td><input type="text" name="lucro" size="13" disabled></td>
        </tr>
    </table>
</form>