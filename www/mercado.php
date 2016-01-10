<?php
require_once("system.php");
Update();?>

<table class="Center">
    <tr>
        <td style="vertical-align:top;">
            <table border="1">
                <tr><th colspan="2">Ordens de compra</th></tr>
                <tr><th>Quantia</th><th>Valor</th></tr><?php
                $dados = array_slice($_SESSION["Config"]["btc"]["Ordens"]["bids"], 0, 50);
                foreach($dados as $linha){?>
                    <tr title="1% = <?php echo $linha[0] * 1.01;?>"<?php
                        if(isset($_SESSION["Config"]["Ordens"]) and in_array(number_format($linha[0], 5, ".", ""), $_SESSION["Config"]["Ordens"], true)){
                            echo " style=\"background-color:#99ccff\"";
                            $find = true;
                        }?>>
                        <td><?php echo $linha[1];?></td>
                        <td><?php echo $linha[0];?></td>
                    </tr><?php
                }?>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table border="1">
                <tr><th colspan="2">Ordens de venda</th></tr>
                <tr><th>Quantia</th><th>Valor</th></tr><?php
                $dados = array_slice($_SESSION["Config"]["btc"]["Ordens"]["asks"], 0, 50);
                foreach($dados as $linha){?>
                    <tr<?php if(isset($_SESSION["Config"]["Ordens"]) and in_array(number_format($linha[0], 5, ".", ""), $_SESSION["Config"]["Ordens"], true)){
                        echo " style=\"background-color:#99ccff\"";}?>>
                        <td><?php echo $linha[1];?></td>
                        <td><?php echo $linha[0];?></td>
                    </tr><?php
                }?>
            </table>
        </td>
        <td style="vertical-align:top;">
            <table border="1">
                <tr><th colspan="4">Ordens executadas</th></tr>
                <tr><th>Hora</th><th>Tipo</th><th>Quantia</th><th>Valor</th></tr><?php
                $dados = array_slice($_SESSION["Config"][$_GET["pair"]]["Trades"], 0, 50);
                foreach($dados as $linha){?>
                    <tr title="Tempo: <?php echo (time()-$linha["date"]) / 60;?> minutos">
                        <td><?php echo date("d/m/Y H:i:s", $linha["date"]);?></td>
                        <td><?php echo $linha["type"] == "buy"?
                            "<span style=\"color:#0a0\">Compra</span>":
                            "<span style=\"color:#f00\">Venda</span>";?></td>
                        <td><?php echo number_format($linha["amount"], 8);?></td>
                        <td><?php echo $linha["price"];?></td>
                    </tr><?php
                }?>
            </table>
        </td>
    </tr>
</table>