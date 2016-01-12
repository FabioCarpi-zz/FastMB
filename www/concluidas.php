<?php
require_once("system.php");

function cmp($A, $B){
   if($A["created"] == $B["created"]){
        return 0;
    }
    return $A["created"] > $B["created"] ? -1 : 1;
}

if(isset($_GET["action"])){

}else{?>
    <span id="AjaxTrades"></span>
    <table border="1" class="Center">
        <tr>
            <th>Moeda</th>
            <th>Tipo</th>
            <th>Volume</th>
            <th>Valor</th>
            <th>Total</th>
            <th>Criação</th>
            <th>Execução (Taxa)</th>
            <th>Dias</th>
        </tr><?php
        $dados = MB("OrderList&pair=btc_brl&status=completed");
        uasort($dados["return"], "cmp");
        foreach($dados["return"] as $linha){?>
            <tr>
                <td style="text-align:center;">BTC</td>
                <td><?php echo $linha["type"] == "buy"?
                    "<span style=\"color:#0a0\">Compra</span>":
                    "<span style=\"color:#f00\">Venda</span>";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $linha["price"];?></td>
                <td style="text-align:center;"><?php echo number_format($linha["volume"] * $linha["price"], 5);?></td>
                <td style="text-align:center;"><?php echo date("d/m/Y H:i:s", $linha["created"]);?></td>
                <td style="text-align:center;"><?php
                    foreach($linha["operations"] as $linha2){
                        echo date("d/m/Y H:i:s", $linha2["created"])." (".$linha2["rate"]."%)<br>";
                        $temp = $linha2["created"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    $temp = ($temp-$linha["created"]) / (60*60*24);
                    echo number_format($temp, 4);?>
                </td>
            </tr><?php
        }?>
    </table><br>
    <table border="1" class="Center">
        <tr>
            <th>Moeda</th>
            <th>Tipo</th>
            <th>Volume</th>
            <th>Valor</th>
            <th>Total</th>
            <th>Criação</th>
            <th>Execução (Taxa)</th>
            <th>Dias</th>
        </tr><?php
        $dados = MB("OrderList&pair=ltc_brl&status=completed");
        foreach($dados["return"] as $linha){?>
            <tr>
                <td style="text-align:center;">LCT</td>
                <td><?php echo $linha["type"] == "buy"?
                    "<span style=\"color:#0a0\">Compra</span>":
                    "<span style=\"color:#f00\">Venda</span>";?></td>
                <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                <td style="text-align:center;"><?php echo $linha["price"];?></td>
                <td style="text-align:center;"><?php echo number_format($linha["volume"] * $linha["price"], 5);?></td>
                <td style="text-align:center;"><?php echo date("d/m/Y H:i:s", $linha["created"]);?></td>
                <td style="text-align:center;"><?php
                    foreach($linha["operations"] as $linha2){
                        echo date("d/m/Y H:i:s", $linha2["created"])." (".$linha2["rate"]."%)<br>";
                        $temp = $linha2["created"];
                    }?>
                </td>
                <td style="text-align:center;"><?php
                    $temp = ($temp - $linha["created"]) / (60*60*24);
                    echo number_format($temp, 4);?>
                </td>
            </tr><?php
        }?>
    </table><?php
}

require_once("foot.php");