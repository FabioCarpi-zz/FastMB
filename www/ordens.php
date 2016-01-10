<?php
require_once("system.php");
require_once("autovenda.php");?>

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
    $_SESSION["Config"]["Ordens"] = array();
    @$dados = MB("OrderList&pair=btc_brl&status=active");
    if(is_null($dados)){?>
        <tr><td colspan="7" style="text-align:center;">Erro ao obter ordens em BTC</td></tr><?php
    }else{
        foreach($dados["return"] as $id => $linha){?>
            <tr>
                <td><a href="#" onclick="Ajax('index.php?action=Del&pair=btc&id=<?php echo $id;?>','AjaxOrdens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
                <td style="text-align:center;">BTC</td>
                <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $_SESSION["Config"]["Ordens"][$id] = $linha["price"];?></td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"])){
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"]."% - "; 
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["venda"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"])){
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["compracent"]."% - "; 
                        echo $_SESSION["Config"]["Auto"]["btc"][$id]["compra"];
                    }?>
                </td>
            </tr><?php
        }
    }
    $dados = MB("OrderList&pair=ltc_brl&status=active");
    if(is_null($dados)){?>
        <tr><td colspan="7" style="text-align:center;">Erro ao obter ordens em LTC</td></tr><?php
    }else{
        foreach($dados["return"] as $id => $linha){?>
            <tr>
                <td><a href="#" onclick="Ajax('index.php?action=Del&pair=ltc&id=<?php echo $id;?>','AjaxOrdens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
                <td style="text-align:center;">LTC</td>
                <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $_SESSION["Config"]["Ordens"][$id] = $linha["price"];?></td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"])){
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"]."% - "; 
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["venda"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"])){
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["compracent"]."% - "; 
                        echo $_SESSION["Config"]["Auto"]["ltc"][$id]["compra"];
                    }?>

                </td>
            </tr><?php
        }
    }?>
</table>