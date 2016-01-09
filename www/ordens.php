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
    @$dados = Obter("OrderList&pair=btc_brl&status=active");
    if(is_null($dados)){?>
        <tr><td colspan="4" style="text-align:center;">Erro ao obter ordens em BTC</td></tr><?php
    }else{
        foreach($dados["return"] as $id => $linha){
            ConfigLoad();?>
            <tr>
                <td><a href="#" onclick="Ajax('index.php?action=Del&pair=btc&id=<?php echo $id;?>','Ordens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
                <td style="text-align:center;">BTC</td>
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
    }
    $dados = Obter("OrderList&pair=ltc_brl&status=active");
    if(is_null($dados)){?>
        <tr><td colspan="4" style="text-align:center;">Erro ao obter ordens em LTC</td></tr><?php
    }else{
        foreach($dados["return"] as $id => $linha){
            ConfigLoad();?>
            <tr>
                <td><a href="#" onclick="Ajax('index.php?action=Del&pair=ltc&id=<?php echo $id;?>','Ordens')" onclick="return confirm('Deseja realmente excluir essa ordem?')"><img src="del.gif" border="0"></a></td>
                <td style="text-align:center;">LTC</td>
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
</table>