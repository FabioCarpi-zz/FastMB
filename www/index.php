<?php
require("system.php");

if(isset($_GET["action"])){
    if($_GET["action"] == "Del"){
        require("head.php");
        $dados = Obter("CancelOrder&pair=".$_GET["pair"]."_brl&order_id=".$_GET["id"]);?>
        <div style="text-align:center;"><?php
            if($dados["success"]){
                echo "Ordem excluída com êxito<br>";
                unset($_SESSION["Config"]["Auto"][$_GET["id"]]);
            }else{
                echo $dados["error"]."<br>";
            }?>
            <a href="#" onclick="Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Ordens','Ordens');
                Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo','Saldo',null,'self');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "New2"){
        require("head.php");
        $dados = Obter("Trade&pair=".$_POST["pair"]."_brl&type=".$_POST["tipo"].
            "&volume=".str_replace(",", ".", $_POST["volume"]).
            "&price=".str_replace(",", ".", $_POST["valor"]));?>
        <div style="text-align:center;"><?php
            if($dados["success"]){
                echo "Ordem criada com êxito<br>";
                if($_POST["autovenda"] != ""){
                    ConfigLoad();
                    $_SESSION["Config"]["Auto"][key($dados["return"])] = array(
                        "pair" => $dados["return"][key($dados["return"])]["pair"],
                        "tipo" => $_POST["tipo"],
                        "vendacent" => $_POST["autovenda"],
                        "venda" => $_POST["valor"] + ($_POST["valor"] * ($_POST["autovenda"] / 100))
                    );
                    ConfigSave();
                }
            }else{
                echo $dados["error"]."<br>";
            }?>
            <a href="#" onclick="Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Ordens','Ordens');
                Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo','Saldo',null,'self');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "Saldo"){
        $dados = Obter("getInfo");?>
        <strong>Saldos</strong><br>
        BRL: <span id="brl"><?php echo $dados["return"]["funds"]["brl"];?></span><br>
        BTC: <span id="btc"><?php echo $dados["return"]["funds"]["btc"];?></span><br>
        LTC: <span id="ltc"><?php echo $dados["return"]["funds"]["ltc"];?></span><?php

    }elseif($_GET["action"] == "Ordens"){
        require("ordens.php");
    }elseif($_GET["action"] == "Mercado"){
        require("mercado.php");
    }
}else{
    require("head.php");?>
    <table class="Center" style="width:100%">
        <tr>
            <td style="text-align:center;" id="Saldo">
                <script>
                    Ajax("<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo", "Saldo", null, "self");
                </script>
            </td>
            <td style="text-align:center;width:210px;vertical-align:top;" rowspan="2">
                <form name="forme" style="border:solid 1px #000;">
                    Moeda: 
                    <select name="pair">
                        <option value="btc">Bitcoin</option>
                        <option value="ltc">Litecoin</option>
                    </select><br>
                    Tipo: 
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
                    Auto venda: <input type="text" name="autovenda" size="2"><br>
                    Auto compra: <input type="text" name="autocompra" size="2"><br>
                    <input type="button" value=" Criar " onclick="Ajax('index.php?action=New2','Ordens',
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
            <td style="text-align:center;">
                <span id="Ordens">
                    <script>
                        Ajax("<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Ordens&pair=btc", "Ordens", null, "self");
                    </script>
                </span>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="2">
                <a href="#" onclick="Ajax('index.php?action=Mercado&pair=btc','Mercado',null,'self');">Bitcoins</a> -
                <a href="#" onclick="Ajax('index.php?action=Mercado&pair=ltc','Mercado',null,'self');">Litecoin</a> - 
                <a href="#" onclick="Ajax('concluidas.php','Mercado');">Ordens concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','Mercado')">Simulador</a><br>
                <span id="Mercado">
                    <script>
                        Ajax("index.php?action=Mercado&pair=btc", "Mercado", null, "self");
                    </script>
                </span>
            </td>
        </tr>
    </table><?php
}
require("foot.php");