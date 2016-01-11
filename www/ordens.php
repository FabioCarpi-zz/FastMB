<?php
require_once("system.php");
require_once("autovenda.php");
Update("MyOrdens");

$_SESSION["Config"]["Ordens"] = array();?>
<table border="1" class="Center">
    <tr>
        <td id="TimerOrdens">30</td>
        <th>Moeda</th>
        <th>Tipo</th>
        <th>Volume</th>
        <th>Valor</th>
        <th>Auto venda</th>
        <th>Auto compra</th>
    </tr><?php
    foreach($_SESSION["Config"]["btc"]["MyOrdens"] as $id => $linha){?>
        <tr>
            <td><a href="#" onclick="Ajax('index.php?action=Del&pair=btc&id=<?php echo $id;?>','AjaxOrdens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
            <td style="text-align:center;">BTC</td>
            <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda";?></td>
            <td style="text-align:center;"><?php echo $linha["volume"];?></td>
            <td style="text-align:center;"><?php echo $_SESSION["Config"]["Ordens"][$id] = $linha["price"];?></td>
            <td style="text-align:center;"><?php
                if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"])){
                    echo $_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"]."% "; 
                    echo $_SESSION["Config"]["Auto"]["btc"][$id]["venda"];
                }?>
            </td>
            <td style="text-align:center;"><?php
                if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"])){
                    echo $_SESSION["Config"]["Auto"]["btc"][$id]["compracent"]."% "; 
                    echo $_SESSION["Config"]["Auto"]["btc"][$id]["compra"];
                }?>
            </td>
        </tr><?php
    }
    foreach($_SESSION["Config"]["ltc"]["MyOrdens"] as $id => $linha){?>
        <tr>
            <td><a href="#" onclick="Ajax('index.php?action=Del&pair=ltc&id=<?php echo $id;?>','AjaxOrdens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
            <td style="text-align:center;">LTC</td>
            <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda";?></td>
            <td style="text-align:center;"><?php echo $linha["volume"];?></td>
            <td style="text-align:center;"><?php echo $_SESSION["Config"]["Ordens"][$id] = $linha["price"];?></td>
            <td style="text-align:center;"><?php
                if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"])){
                    echo $_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"]."% "; 
                    echo $_SESSION["Config"]["Auto"]["ltc"][$id]["venda"];
                }?>
            </td>
            <td style="text-align:center;"><?php
                if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"])){
                    echo $_SESSION["Config"]["Auto"]["ltc"][$id]["compracent"]."% "; 
                    echo $_SESSION["Config"]["Auto"]["ltc"][$id]["compra"];
                }?>

            </td>
        </tr><?php
    }?>
</table>
<script>
    setTimeout(function (){
        Ajax("ordens.php?pair=<?php echo $_GET["pair"];?>", "AjaxOrdens");
    }, 30 * 1000);
</script>