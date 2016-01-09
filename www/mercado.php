<?php
//require("autovenda.php");
if($_GET["pair"] == "btc"){
    $temp = "orderbook";
}else{
    $temp = "orderbook_litecoin";
}
@$dados = json_decode(file_get_contents("https://www.mercadobitcoin.net/api/".$temp), true);?>
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
                        <tr title="1% = <?php echo $linha[0] * 1.01;?>"<?php
                            if(isset($_SESSION["Config"]["Ordens"]) and in_array(number_format($linha[0], 5, ".", ""), $_SESSION["Config"]["Ordens"], true)){
                                echo " style=\"background-color:#99ccff\"";
                                $find = true;
                            }?>>
                            <td><?php echo $linha[1];?></td>
                            <td><?php echo $linha[0];?></td>
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
        if($_GET["pair"] == "btc"){
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
                        <tr title="Tempo: <?php echo (time()-$linha["date"]) / 60;?> minutos">
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
</table>
<div style="position:absolute; border:solid 1px #000; visibility:hidden;"></div>