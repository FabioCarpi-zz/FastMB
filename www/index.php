<?php
require_once("system.php");

if(isset($_GET["action"])){
    if($_GET["action"] == "Del"){
        require_once("head.php");
        $dados = MB("CancelOrder&pair=".$_GET["pair"]."_brl&order_id=".$_GET["id"]);?>
        <div style="text-align:center;"><?php
            if($dados["success"]){
                echo "Ordem excluída com êxito<br>";
                unset($_SESSION["Config"]["Auto"][$_GET["pair"]][$_GET["id"]]);
                ConfigSave();
            }else{
                echo $dados["error"]."<br>";
            }?>
            <a href="#" onclick="Ajax('ordens.php?pair=<?php echo $_GET["pair"];?>','AjaxOrdens');
                Ajax('mercado.php?pair=<?php echo $_GET["pair"];?>','AjaxMercado');
                Ajax('index.php?action=Saldo','AjaxSaldo');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "New2"){
        $dados = MB("Trade&pair=".$_POST["pair"]."_brl&type=".$_POST["tipo"].
            "&volume=".str_replace(",", ".", $_POST["volume"]).
            "&price=".str_replace(",", ".", $_POST["valor"]));?>
        <div style="text-align:center;"><?php
            if($dados["success"]){
                echo "Ordem criada com êxito<br>";
                if($_POST["autovenda"] != ""){
                    $_SESSION["Config"]["Auto"][$_POST["pair"]][key($dados["return"])] = array(
                        "tipo" => $_POST["tipo"],
                        "vendacent" => $_POST["autovenda"],
                        "venda" => number_format($temp = $_POST["valor"] + (($_POST["valor"] * $_POST["autovenda"]) / 100), 5),
                        "compracent" => $_POST["autocompra"],
                        "compra" => number_format($temp - (($temp * $_POST["autocompra"]) / 100), 5)
                    );
                    ConfigSave();
                }
            }else{
                echo $dados["error"]."<br>";
            }?>
            <a href="#" onclick="Ajax('ordens.php?pair=<?php echo $_POST["pair"];?>','AjaxOrdens');
                Ajax('mercado.php?pair=<?php echo $_POST["pair"];?>','AjaxMercado');
                Ajax('index.php?action=Saldo','AjaxSaldo');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "Saldo"){
        @$dados = MB("getInfo");
        if(!is_null($dados)){
            $_SESSION["Config"]["Saldos"] = $dados["return"]["funds"];
        }?>
        BRL: <span id="brl"><?php echo $_SESSION["Config"]["Saldos"]["brl"];?></span><br>
        BTC: <span id="btc"><?php echo $_SESSION["Config"]["Saldos"]["btc"];?></span><br>
        LTC: <span id="ltc"><?php echo $_SESSION["Config"]["Saldos"]["ltc"];?></span>
        <script>
            setTimeout(function (){
                Ajax("index.php?action=Saldo", "AjaxSaldo");
            }, 30 * 1000);
        </script><?php
    }
}else{
    require_once("head.php");?>
    <table class="Center" style="width:100%">
        <tr>
            <td style="text-align:center;width:300px;" id="AjaxSaldo">
                <script>
                    Ajax("index.php?action=Saldo", "AjaxSaldo");
                </script>
            </td>
            <td style="text-align:center;">
                <a href="#" onclick="Ajax('mercado.php?pair=btc','AjaxMercado');">Bitcoins</a> -
                <a href="#" onclick="Ajax('mercado.php?pair=ltc','AjaxMercado');">Litecoin</a><br> 
                <a href="#" onclick="Ajax('concluidas.php','AjaxMercado');">Ordens concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','AjaxMercado')">Simulador</a>
            </td>
            <td style="text-align:center;width:220px;vertical-align:top;white-space:nowrap;" rowspan="2">
                <form name="forme" style="border:solid 1px #000;">
                    <select name="pair">
                        <option value="btc">Bitcoin</option>
                        <option value="ltc">Litecoin</option>
                    </select>
                    <select name="tipo">
                        <option value="buy">Comprar</option>
                        <option value="sell">Vender</option>
                    </select><br>
                    Valor: 
                    <input type="text" name="valor" size="7" onkeyup="document.forme.valor2.value=document.forme.valor.value*1.01">
                    <input type="text" name="valor2" size="7" disabled><br>
                    Quantidade: <input type="text" name="volume" size="7">
                    <input type="button" value="&lt;&lt;" onclick="
                        if(document.forme.tipo.value == 'buy' && document.forme.pair.value == 'btc'){
                            num = (document.getElementById('brl').innerHTML / document.forme.valor.value) - 0.00000001;
                            document.forme.volume.value = num.toFixed(8);
                        }else if(document.forme.tipo.value == 'sell' && document.forme.pair.value == 'btc'){
                            document.forme.volume.value=document.getElementById('btc').innerHTML;
                        }else if(document.forme.tipo.value == 'sell' && document.forme.pair.value == 'ltc'){
                            document.forme.volume.value=document.getElementById('ltc').innerHTML;
                        }"><br>
                    Auto venda: <input type="text" name="autovenda" size="2" onkeyup="
                        document.forme.autovenda2.value = parseFloat(document.forme.valor.value) + ((document.forme.valor.value * document.forme.autovenda.value) / 100);
                    "><input type="text" name="autovenda2" size="7" disabled><br>
                    Auto compra: <input type="text" name="autocompra" size="2" onkeyup="
                        num = parseFloat(document.forme.autovenda2.value) - (document.forme.autovenda2.value * document.forme.autocompra.value / 100);
                        document.forme.autocompra2.value = num.toFixed(5);
                    "><input type="text" name="autocompra2" size="7" disabled><br>
                    <input type="button" value=" Criar " onclick="Ajax('index.php?action=New2','AjaxOrdens',
                        'pair='+document.forme.pair.value+
                        '&tipo='+document.forme.tipo.value+
                        '&valor='+document.forme.valor.value+
                        '&volume='+document.forme.volume.value+
                        '&autovenda='+document.forme.autovenda.value+
                        '&autocompra='+document.forme.autocompra.value);">
                </form>
            </td>
            <td rowspan="3" style="vertical-align:top;width:810px;">
                <iframe src="https://www.tradingview.com/chart/slfdymsk/" width="810" height="830"></iframe>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2">
                <span id="AjaxOrdens">
                    <script>
                        Ajax("ordens.php?pair=btc", "AjaxOrdens");
                        setInterval(function(){
                            document.getElementById("TimerOrdens").innerHTML--;
                        }, 1000);
                    </script>
                </span>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="3" id="AjaxMercado">
                <script>
                    Ajax("mercado.php?pair=btc", "AjaxMercado");
                </script>
            </td>
        </tr>
    </table><?php
}
require_once("foot.php");