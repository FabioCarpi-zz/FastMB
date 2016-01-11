<?php
require_once("system.php");

if(isset($_GET["Action"])){
    if($_GET["Action"] == "Saldo"){
        @$dados = MB("getInfo");
        if(!is_null($dados)){
            $_SESSION["Temp"]["Saldos"] = $dados["return"]["funds"];
        }?>
        BRL: <span id="brl"><?php echo $_SESSION["Temp"]["Saldos"]["brl"];?></span><br>
        BTC: <span id="btc"><?php echo $_SESSION["Temp"]["Saldos"]["btc"];?></span><br>
        LTC: <span id="ltc"><?php echo $_SESSION["Temp"]["Saldos"]["ltc"];?></span><?php
    }
}else{
    require_once("head.php");?>
    <table class="Center" style="width:100%">
        <tr>
            <td style="text-align:center;width:300px;" id="AjaxSaldo">
                <script>
                    Ajax("index.php?Action=Saldo", "AjaxSaldo", null, true);
                </script>
            </td>
            <td style="text-align:center;">
                Versão <?php echo file_get_contents("versao.txt");?> de <?php echo file_get_contents("https://raw.githubusercontent.com/FabioCarpi/FastMB/master/www/versao.txt");?><br>
                Negociações: <a href="#" onclick="Ajax('mercado.php?pair=btc','AjaxMercado',null,true);">Bitcoins</a> -
                <a href="#" onclick="Ajax('mercado.php?pair=ltc','AjaxMercado',null,true);">Litecoin</a><br> 
                Ordens: <a href="#" onclick="Ajax('ordens.php?Action=Form','AjaxMercado');">Nova</a> -
                <a href="#" onclick="Ajax('concluidas.php','AjaxMercado');">Concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','AjaxMercado')">Simulador</a>
            </td>
            <td rowspan="3" style="vertical-align:top;width:810px;">
                <iframe src="https://www.tradingview.com/chart/slfdymsk/" width="810" height="830"></iframe>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2" id="AjaxOrdens">
                <script>
                    Ajax("ordens.php?pair=btc", "AjaxOrdens", null, true);
                    setInterval(function(){
                        document.getElementById("TimerOrdens").innerHTML--;
                    }, 1000);
                </script>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="2">
                <br>
                <span id="AjaxMercado">
                    <script>
                        Ajax("mercado.php?pair=btc", "AjaxMercado", null, true);
                    </script>
                </span>
            </td>
        </tr>
    </table><?php
}
require_once("foot.php");