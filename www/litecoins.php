<?php
require("system.php");
define("Pair", "ltc");

if(isset($_GET["action"])){
    if($_GET["action"] == "Del"){
        require("head.php");
        $dados = Obter("CancelOrder&pair=".Pair."_brl&order_id=".$_GET["id"]);?>
        <div style="text-align:center;"><?php
            if($dados["success"]){
                echo "Ordem excluída com êxito<br>";
                unset($_SESSION["Config"]["Auto"][$_GET["id"]]);
            }else{
                echo $dados["error"]."<br>";
            }?>
            <a href="#" onclick="Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Ordens','Ordens');
                Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo','Saldo');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "New2"){
        require("head.php");
        $dados = Obter("Trade&pair=".Pair."_brl&type=".$_POST["tipo"].
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
                Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo','Saldo');">Atualizar</a>
        </div><?php

    }elseif($_GET["action"] == "Saldo"){
        $dados = Obter("getInfo");?>
        <strong>Saldos</strong><br>
        BRL: <span id="brl"><?php echo $dados["return"]["funds"]["brl"];?></span> (<?php echo $dados["return"]["funds"]["brl_with_open_orders"] - $dados["return"]["funds"]["brl"];?>)<br>
        BTC: <span id="btc"><?php echo $dados["return"]["funds"]["btc"];?></span> (<?php echo $dados["return"]["funds"]["btc_with_open_orders"] - $dados["return"]["funds"]["btc"];?>)<br>
        LTC: <span id="ltc"><?php echo $dados["return"]["funds"]["ltc"];?></span> (<?php echo $dados["return"]["funds"]["ltc_with_open_orders"] - $dados["return"]["funds"]["ltc"];?>)<?php

    }elseif($_GET["action"] == "Ordens"){?>
        <table border="1" class="Center">
            <tr>
                <td></td>
                <th>Moeda</th>
                <th>Tipo</th>
                <th>Volume</th>
                <th>Valor</th>
                <th>Auto venda</th>
                <th>Auto compra</th>
            </tr><?php
            $_SESSION["Config"]["Ordens"] = array();
            $dados = Obter("OrderList&pair=".Pair."_brl&status=active");
            if(is_null($dados)){?>
                <tr><td colspan="4" style="text-align:center;">Erro ao obter dados</td></tr><?php
            }else{
                foreach($dados["return"] as $id => $linha){
                    ConfigLoad();?>
                    <tr>
                        <td><a href="#" onclick="Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Del&id=<?php echo $id;?>','Ordens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
                        <td style="text-align:center;"><?php echo $linha["pair"] == "btc_brl"? "BTC": "LTC";?></td>
                        <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda";?></td>
                        <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                        <td style="text-align:center;"><?php echo $_SESSION["Config"]["Ordens"][$id] = $linha["price"];?></td>
                        <td style="text-align:center;"><?php
                            if(isset($_SESSION["Config"]["Auto"][$id]) and !is_null($_SESSION["Config"]["Auto"][$id]["vendacent"])){
                                echo $_SESSION["Config"]["Auto"][$id]["vendacent"]."% - "; 
                                echo $_SESSION["Config"]["Auto"][$id]["venda"];
                            }?>
                        </td>
                        <td style="text-align:center;">

                        </td>
                    </tr><?php
                }
            }?>
        </table><?php    

    }elseif($_GET["action"] == "Mercado"){
        //require("autovenda.php");
        if(Pair == "btc"){
            $temp = "orderbook";
        }else{
            $temp = "orderbook_litecoin";
        }
        @$dados = json_decode(file_get_contents("https://www.mercadobitcoin.net/api/".$temp), true);?>
        <span style="font-size:25px;font-weight:bold;">Mercado</span><br>
        <table class="Center">
            <tr>
                <td style="vertical-align:top;">
                    <table border="1">
                        <tr><th colspan="2">Ordens de compra</th></tr>
                        <tr><th>Quantia</th><th>Valor</th></tr><?php
                        if(is_null($dados)){?>
                            <tr><td colspan="4" style="text-align:center;">Erro ao obter dados</td></tr><?php
                        }else{
                            $dados["bids"] = array_slice($dados["bids"], 0, 50);
                            ConfigLoad();
                            foreach($dados["bids"] as $linha){?>
                                <tr<?php if(isset($_SESSION["Config"]["Ordens"]) and in_array(number_format($linha[0], 5, ".", ""), $_SESSION["Config"]["Ordens"], true)){
                                        echo " style=\"background-color:#99ccff\"";
                                        $find = true;
                                    }?>>
                                    <td><?php echo $linha[1];?></td>
                                    <td onmouseover="document.forme.valor2.value=<?php echo $linha[0];?>*1.01;
                                        this.style.backgroundColor='#aaa';"
                                        onmouseout="this.style.backgroundColor='#fff'"><?php echo $linha[0];?>
                                    </td>
                                </tr><?php
                            }
                        }?>
                    </table>
                </td>
                <td style="vertical-align:top;">
                    <table border="1">
                        <tr><th colspan="2">Ordens de venda</th></tr>
                        <tr><th>Quantia</th><th>Valor</th></tr><?php
                        if(is_null($dados)){?>
                            <tr><td colspan="4" style="text-align:center;">Erro ao obter dados</td></tr><?php
                        }else{
                            $dados["asks"] = array_slice($dados["asks"], 0, 50);
                            foreach($dados["asks"] as $linha){?>
                                <tr<?php if(isset($_SESSION["Config"]["Ordens"]) and in_array(number_format($linha[0], 5, ".", ""), $_SESSION["Config"]["Ordens"], true)){
                                    echo " style=\"background-color:#99ccff\"";}?>>
                                    <td><?php echo $linha[1];?></td>
                                    <td><?php echo $linha[0];?></td>
                                </tr><?php
                            }
                        }?>
                    </table>
                </td>
                <?php
                if(Pair == "btc"){
                    $temp = "trades";
                }else{
                    $temp = "trades_litecoin";
                }
                @$dados = array_reverse(json_decode(file_get_contents("https://www.mercadobitcoin.net/api/".$temp."/".strtotime("-12 hours")), true));?>
                <td style="vertical-align:top;">
                    <table border="1">
                        <tr><th colspan="4">Ordens executadas</th></tr>
                        <tr><th>Hora</th><th>Tipo</th><th>Quantia</th><th>Valor</th></tr><?php
                        if(is_null($dados)){?>
                            <tr><td colspan="4" style="text-align:center;">Erro ao obter dados</td></tr><?php
                        }else{
                            $dados = array_slice($dados, 0, 50);
                            foreach($dados as $linha){?>
                                <tr>
                                    <td><?php echo date("d/m/Y H:i:s", $linha["date"]);?></td>
                                    <td><?php echo $linha["type"]=="buy"?
                                        "<span style=\"color:#0a0\">Compra</span>":
                                        "<span style=\"color:#f00\">Venda</span>";?></td>
                                    <td><?php echo number_format($linha["amount"], 8);?></td>
                                    <td><?php echo $linha["price"];?></td>
                                </tr><?php
                            }
                        }?>
                    </table>
                </td>
            </tr>
        </table><?php
    }
}else{
    require("head.php");?>
    <table class="Center">
        <tr>
            <td style="text-align:center;" id="Saldo">
                <script>
                    Ajax("<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Saldo", "Saldo", null, "self");
                </script>
            </td>
            <td style="text-align:center;width:20%;" rowspan="2">
                <form name="forme" style="border:solid 1px #000;">
                    Tipo: 
                    <select name="tipo">
                        <option value="buy">Comprar</option>
                        <option value="sell">Vender</option>
                    </select><br>
                    Valor: 
                    <input type="text" name="valor" size="7" onkeyup="document.forme.valor2.value=document.forme.valor.value*1.01"><input type="text" name="valor2" size="7" disabled><br>
                    Quantidade: 
                    <input type="button" value="&gt;&gt;" onclick="
                        if(document.forme.tipo.value == 'buy'){
                            num = (document.getElementById('BRL').innerHTML / document.forme.valor.value) - 0.00000001;
                            document.forme.volume.value = num.toFixed(8);
                        }else if(document.forme.tipo.value == 'sell'){
                            document.forme.volume.value=document.getElementById('BTC').innerHTML;
                        }"><input type="text" name="volume" size="7"><br>
                    Auto venda: <input type="text" name="autovenda" size="2"><br>
                    Auto compra: <input type="text" name="autocompra" size="2"><br>
                    <br>
                    <input type="button" value="Criar" onclick="Ajax('<?php echo basename($_SERVER["PHP_SELF"]);?>?action=New2','Ordens',
                        'tipo='+document.forme.tipo.value+
                        '&valor='+document.forme.valor.value+
                        '&volume='+document.forme.volume.value+
                        '&autovenda='+document.forme.autovenda.value+
                        '&autocompra='+document.forme.autocompra.value);">
                </form>
            </td>
            <td rowspan="3" style="vertical-align:top;">
                <iframe src="https://www.tradingview.com/chart/slfdymsk/" width="810" height="830"></iframe>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">
                <strong>Ordens</strong><br>
                <span id="Ordens">
                    <script>
                        Ajax("<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Ordens", "Ordens", null, "self");
                    </script>
                </span>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="2">
                <a href="index.php">Bitcoins</a> -
                <a href="litecoins.php">Litecoin</a> - 
                <a href="#" onclick="Ajax('ordens.php','Mercado');">Ordens concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','Mercado')">Simulador</a><br>
                <span id="Mercado">
                    <script>
                        Ajax("<?php echo basename($_SERVER["PHP_SELF"]);?>?action=Mercado", "Mercado", null, "self");
                    </script>
                </span>
            </td>
        </tr>
    </table><?php
}
require("foot.php");