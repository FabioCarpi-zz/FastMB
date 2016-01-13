<?php
require_once("system.php");

if(isset($_GET["Action"])){
    if($_GET["Action"] == "Saldo"){
        Update("Saldos");?>
        BRL: <span id="brl"><?php echo $_SESSION["Temp"]["Saldos"]["brl"];?></span><br>
        BTC: <span id="btc"><?php echo $_SESSION["Temp"]["Saldos"]["btc"];?></span><br>
        LTC: <span id="ltc"><?php echo $_SESSION["Temp"]["Saldos"]["ltc"];?></span><?php
    }
}else{
    require_once("head.php");?>
    <table class="Center" style="width:100%">
        <tr>
            <td style="text-align:center;width:20%;" id="AjaxSaldo"></td>
            <td style="text-align:center;">
                Versão <?php echo file_get_contents("versao.txt");?> de <?php echo file_get_contents("https://raw.githubusercontent.com/FabioCarpi/FastMB/master/www/versao.txt");?><br>
                Negociações: <a href="#" onclick="Ajax('mercadobtc.php','AjaxPagina');">Bitcoins</a> -
                <a href="#" onclick="Ajax('mercadoltc.php','AjaxPagina');">Litecoin</a><br> 
                Ordens: <a href="#" onclick="Ajax('ordens.php?Action=Form','AjaxTrades');">Nova</a> -
                <a href="#" onclick="Ajax('concluidas.php','AjaxPagina');">Concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','AjaxTrades')">Simulador</a>
            </td>
            <td rowspan="3" style="vertical-align:top;width:50%;">
                <iframe src="https://www.tradingview.com/chart/8rG7IftD/" width="100%" id="chart"></iframe>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2" id="AjaxOrdens"></td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="2" id="AjaxPagina"></td>
        </tr>
    </table>
    <script>
        Ajax("index.php?Action=Saldo", "AjaxSaldo", null, true);
        Ajax("ordens.php?pair=btc", "AjaxOrdens", null, true);
        Ajax("mercadobtc.php", "AjaxPagina");
        document.getElementById("chart").height = (window.innerHeight - 10) + "px";
        setInterval(function(){
           document.getElementById("TimerOrdens").innerHTML--;
        }, 1000);
    </script><?php
}
require_once("foot.php");