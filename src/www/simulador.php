<?php
require_once("system.php");?>

<script>
    var num;
    
    function Calcular(){
        num = document.simulador.reais.value / document.simulador.compra.value;
        document.simulador.bitcoins.value = num.toFixed(8);
        num = document.simulador.bitcoins.value * 0.003;
        document.simulador.taxac.value = num.toFixed(8);
        num = document.simulador.bitcoins.value - document.simulador.taxac.value;
        document.simulador.comprado.value = num.toFixed(8);
        num = document.simulador.comprado.value * 0.003;
        document.simulador.taxav.value = num.toFixed(8);
        num = document.simulador.comprado.value - document.simulador.taxav.value;
        document.simulador.vendido.value = num.toFixed(8);
        num = document.simulador.vendido.value * document.simulador.venda.value;
        document.simulador.saldo.value = num.toFixed(5);
        num = document.simulador.saldo.value - document.simulador.reais.value;
        document.simulador.ganho.value = num.toFixed(5);
        num = document.simulador.ganho.value * 100 / document.simulador.reais.value;
        document.simulador.lucro.value = num.toFixed(2) + "%";
    }

    function Calcular2(){
        num = document.simulador.vendido.value * document.simulador.venda.value;
        document.simulador.saldo.value = num.toFixed(5);
        num = document.simulador.saldo.value - document.simulador.reais.value;
        document.simulador.ganho.value = num.toFixed(5);
        num = document.simulador.ganho.value * 100 / document.simulador.reais.value;
        document.simulador.lucro.value = num.toFixed(2) + "%";
    }
</script>

<form name="simulador">
    <table class="Center" style="border:none;">
        <tr>
            <td style="border:none;">Reais:</td>
            <td style="border:none;"><input type="text" name="reais" size="12" onkeyup="Calcular()" onchange="Calcular()"></td>
        </tr>
        <tr>
            <td style="white-space:nowrap;border:none;">Valor pretendido:</td>
            <td style="border:none;"><input type="text" name="compra" size="12" onkeyup="Calcular()" onchange="Calcular()" onclick="this.select();"></td>
        </tr>
        <tr>
            <td style="border:none;">Bitcoins:</td>
            <td style="border:none;"><input type="text" name="bitcoins"  size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Taxa compra:</td>
            <td style="border:none;"><input type="text" name="taxac" size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Comprado:</td>
            <td style="border:none;"><input type="text" name="comprado" size="12" disabled></td>
        </tr>
        <tr>
            <td style="white-space:nowrap;border:none;">Valor pretendido:</td>
            <td style="border:none;"><input type="text" name="venda" size="12" onkeyup="Calcular2()" onchange="Calcular2()" onclick="this.select();"></td>
        </tr>
        <tr>
            <td style="border:none;">Taxa venda:</td>
            <td style="border:none;"><input type="text" name="taxav" size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Vendido:</td>
            <td style="border:none;"><input type="text" name="vendido" size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Saldo:</td>
            <td style="border:none;"><input type="text" name="saldo" size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Ganho:</td>
            <td style="border:none;"><input type="text" name="ganho" size="12" disabled></td>
        </tr>
        <tr>
            <td style="border:none;">Lucro:</td>
            <td style="border:none;"><input type="text" name="lucro" size="12" disabled></td>
        </tr>
    </table>
</form><br>