<?php
require_once("system.php");

if(isset($_GET["Action"])){
    if($_GET["Action"] == "Form"){
        Update("Saldos");?>
        <script>TimerStop("AjaxPagina");</script>
        <form name="ordem">
            Moeda: <select name="pair">
                <option value="btc">Bitcoin</option>
                <option value="ltc">Litecoin</option>
            </select><br>
            Tipo: <select name="tipo">
                <option value="buy">Comprar</option>
                <option value="sell">Vender</option>
            </select><br>
            Valor: 
            <input type="text" name="valor" size="7" onkeyup="
                num = document.ordem.valor.value * 1.01;
                document.ordem.valor2.value = num.toFixed(5);
            ">
            <input type="text" name="valor2" size="7" disabled><br>
            Quantidade: <input type="text" name="volume" size="7">
            <input type="button" value="&lt;&lt;" onclick="
                if(document.ordem.tipo.value == 'buy'){
                    num = <?php echo $_SESSION["Temp"]["Saldos"]["brl"];?> / document.ordem.valor.value;
                    document.ordem.volume.value = num.toFixed(8);
                }else if(document.ordem.tipo.value == 'sell' && document.ordem.pair.value == 'btc'){
                    document.ordem.volume.value = <?php echo $_SESSION["Temp"]["Saldos"]["btc"];?>;
                }else if(document.ordem.tipo.value == 'sell' && document.ordem.pair.value == 'ltc'){
                    document.ordem.volume.value = <?php echo $_SESSION["Temp"]["Saldos"]["ltc"];?>
                }"><br>
            Auto venda: <input type="text" name="autovenda" size="2" onkeyup="
                document.ordem.autovenda2.value = parseFloat(document.ordem.valor.value) + ((document.ordem.valor.value * document.ordem.autovenda.value) / 100);
            "><input type="text" name="autovenda2" size="7" disabled><br>
            Auto compra: <input type="text" name="autocompra" size="2" onkeyup="
                num = parseFloat(document.ordem.autovenda2.value) - (document.ordem.autovenda2.value * document.ordem.autocompra.value / 100);
                document.ordem.autocompra2.value = num.toFixed(5);
            "><input type="text" name="autocompra2" size="7" disabled><br>
            <br>
            <input type="button" value=" Criar " onclick="Ajax('ordens.php?Action=New','AjaxSave',
                'pair='+document.ordem.pair.value+
                '&tipo='+document.ordem.tipo.value+
                '&valor='+document.ordem.valor.value+
                '&volume='+document.ordem.volume.value+
                '&autovenda='+document.ordem.autovenda.value+
                '&autocompra='+document.ordem.autocompra.value);"><br>
            <span id="AjaxSave"></span>
        </form><br><?php
    }elseif($_GET["Action"] == "New"){
        $dados = MB("Trade&pair=".$_POST["pair"]."_brl&type=".$_POST["tipo"].
            "&volume=".str_replace(",", ".", $_POST["volume"]).
            "&price=".str_replace(",", ".", $_POST["valor"]));
        if($dados["success"]){
            echo "Ordem criada com êxito";
            if($_POST["autovenda"] != ""){
                $_SESSION["Config"]["Auto"][$_POST["pair"]][key($dados["return"])] = array(
                    "tipo" => $_POST["tipo"],
                    "venda" => number_format($temp = $_POST["valor"] + (($_POST["valor"] * $_POST["autovenda"]) / 100), 5),
                    "compra" => number_format($temp - (($temp * $_POST["autocompra"]) / 100), 5)
                );
                if($_POST["min"] != "" and $_POST["max"] != ""){
                    $_SESSION["Config"]["Bot"][key($dados["return"])] = array(
                        "moeda" => $_POST["pair"],
                        "tipo" => $_POST["tipo"],
                        "min" => $_POST["min"],
                        "max" => $_POST["max"]
                    );
                }
                ConfigSave();
            }
        }else{
            echo $dados["error"];
        }
        ?><br><?php
    }elseif($_GET["Action"] == "Del"){
        $dados = MB("CancelOrder&pair=".$_GET["pair"]."_brl&order_id=".$_GET["id"]);
        if($dados["success"]){
            echo "Ordem excluída com êxito<br>";
            unset($_SESSION["Config"]["Auto"][$_GET["pair"]][$_GET["id"]]);
            unset($_SESSION["Config"]["Bot"][$_GET["id"]]);
            ConfigSave();
        }else{
            echo $dados["error"];
        }?>
        <a href="#" onclick="Ajax('ordens.php?pair=<?php echo $_GET["pair"];?>','AjaxOrdens',null,true);
            Ajax('index.php?Action=Saldo','AjaxSaldo',null,true);">Atualizar</a><?php
    }
}else{
    require_once("autovenda.php");
    Update("MyOrdens");
    $_SESSION["Temp"]["Auto"] = array();?>
    <table class="Center">
        <tr>
            <td id="TimerOrdens">30</td>
            <th>Moeda</th>
            <th>Tipo</th>
            <th>Volume</th>
            <th>Valor</th>
            <th>Auto venda</th>
            <th>Auto compra</th>
            <th>Mínimo</th>
            <th>Máximo</th>
        </tr><?php
        $_SESSION["Temp"]["Precos"] = array();
        foreach($_SESSION["Temp"]["btc"]["MyOrdens"] as $id => $linha){?>
            <tr>
                <td>
                    <a href="#" onclick="if(confirm('Deseja realmente excluir essa ordem?')) Ajax('ordens.php?Action=Del&pair=btc&id=<?php echo $id;?>; else return false;','AjaxOrdens')"><img src="del.gif" alt=""></a>
                </td>
                <td style="text-align:center;">BTC</td>
                <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda"; echo " (".count($linha["operations"]).")";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $_SESSION["Temp"]["Precos"][] = $linha["price"];?></td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["venda"])){
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["venda"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["compra"])){
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["compra"];
                    }?>
                </td>
                <td style="text-align:center;"><?php if(isset($_SESSION["Config"]["Bot"][$id])){echo $_SESSION["Config"]["Bot"][$id]["min"];}?></td>
                <td style="text-align:center;"><?php if(isset($_SESSION["Config"]["Bot"][$id])){echo $_SESSION["Config"]["Bot"][$id]["max"];}?></td>
            </tr><?php
        }
        foreach($_SESSION["Temp"]["ltc"]["MyOrdens"] as $id => $linha){?>
            <tr>
                <td>
                    <a href="#" onclick="if(confirm('Deseja realmente excluir essa ordem?')) Ajax('ordens.php?Action=Del&pair=ltc&id=<?php echo $id;?>; else return false;','AjaxOrdens')"><img src="del.gif" alt=""></a>
                </td>
                <td style="text-align:center;">LTC</td>
                <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda"; echo " (".count($linha["operations"]).")";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $_SESSION["Temp"]["Precos"][] = $linha["price"];?></td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["venda"])){
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["venda"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["compra"])){
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["compra"];
                    }?>
                </td>
                <td style="text-align:center;"><?php if(isset($_SESSION["Config"]["Bot"][$id])){echo $_SESSION["Config"]["Bot"][$id]["min"];}?></td>
                <td style="text-align:center;"><?php if(isset($_SESSION["Config"]["Bot"][$id])){echo $_SESSION["Config"]["Bot"][$id]["max"];}?></td>
            </tr><?php
        }?>
    </table><?php
}