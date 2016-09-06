<?php
require_once("system.php");

if(isset($_GET["Action"])){
    if($_GET["Action"] == "Form"){
        Update("Saldos");?>
        <script>
            function Atualizar(){
                var num = document.ordem.valor.value * 1.01;
                document.ordem.valor2.value = num.toFixed(5);
                document.ordem.autovenda2.value = parseFloat(document.ordem.valor.value) + ((document.ordem.valor.value * document.ordem.autovenda.value) / 100);
                num = parseFloat(document.ordem.autovenda2.value) - (document.ordem.autovenda2.value * document.ordem.autocompra.value / 100);
                document.ordem.autocompra2.value = num.toFixed(5);
            }
        </script>
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
            <input type="text" name="valor" size="7" onchange="Atualizar();" onkeyup="Atualizar();" onclick="this.select();">
            <input type="text" name="valor2" size="7" disabled><br>
            Quantidade: <input type="text" name="volume" size="10">
            <input type="button" value="&lt;&lt;" onclick="
                if(document.ordem.tipo.value == 'buy'){
                    num = <?php echo $_SESSION["Temp"]["Saldos"]["brl"];?> / document.ordem.valor.value;
                    document.ordem.volume.value = num.toFixed(8);
                }else if(document.ordem.tipo.value == 'sell' && document.ordem.pair.value == 'btc'){
                    document.ordem.volume.value = <?php echo $_SESSION["Temp"]["Saldos"]["btc"];?>;
                }else if(document.ordem.tipo.value == 'sell' && document.ordem.pair.value == 'ltc'){
                    document.ordem.volume.value = <?php echo $_SESSION["Temp"]["Saldos"]["ltc"];?>
                }"><br>
            <br>
            <input type="button" value=" Criar " onclick="Ajax('ordens.php?Action=New','AjaxSave',
                'pair='+document.ordem.pair.value+
                '&tipo='+document.ordem.tipo.value+
                '&valor='+document.ordem.valor.value+
                '&volume='+document.ordem.volume.value);"><br>
            <span id="AjaxSave"></span>
        </form><br><?php
    }elseif($_GET["Action"] == "New"){
        $dados = MB("Trade&pair=".$_POST["pair"]."_brl&type=".$_POST["tipo"].
            "&volume=".str_replace(",", ".", $_POST["volume"]).
            "&price=".str_replace(",", ".", $_POST["valor"]));
        if($dados["success"]){
            echo "Ordem criada com êxito";
        }else{
            echo $dados["error"];
        }
        ?><br><?php
    }elseif($_GET["Action"] == "Del"){
        $dados = MB("CancelOrder&pair=".$_GET["pair"]."_brl&order_id=".$_GET["id"]);
        if($dados["success"]){
            echo "Ordem excluída com êxito<br>";
        }else{
            echo $dados["error"];
        }?>
        <a href="#" onclick="Ajax('ordens.php?pair=<?php echo $_GET["pair"];?>','AjaxOrdens',null,true);
            Ajax('index.php?Action=Saldo','AjaxSaldo',null,true);">Atualizar</a><?php
    }
}else{
    Update("MyOrdens");
    $_SESSION["Temp"]["Auto"] = array();?>
    <table class="Center">
        <tr>
            <td id="TimerOrdens" onclick="
                Ajax('index.php?Action=Saldo', 'AjaxSaldo', null, true);
                Ajax('ordens.php?pair=btc', 'AjaxOrdens', null, true);
            ">60</td>
            <th>Moeda</th>
            <th>Tipo</th>
            <th>Volume</th>
            <th>Valor</th>
        </tr><?php
        $_SESSION["Temp"]["Precos"] = array();
        if(isset($_SESSION["Temp"]["btc"])){
            foreach($_SESSION["Temp"]["btc"]["MyOrdens"] as $id => $linha){?>
                <tr>
                    <td>
                        <a href="#" onclick="if(confirm('Deseja realmente excluir essa ordem?')) Ajax('ordens.php?Action=Del&pair=btc&id=<?php echo $id;?>; else return false;','AjaxOrdens')">
                            <img src="images/del.gif" alt="">
                        </a>
                    </td>
                    <td style="text-align:center;">BTC</td>
                    <td style="text-align:center;"><?php if($linha["type"] == "buy"){?>
                        <span style="color:#0a0">Compra</span><?php
                    }else{?>
                        <span style="color:#c00">Venda</span><?php
                    }
                    echo " (".count($linha["operations"]).")";?></td>
                    <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                    <td style="text-align:center;"><?php echo $linha["price"];?></td>
                </tr><?php
            }
            foreach($_SESSION["Temp"]["ltc"]["MyOrdens"] as $id => $linha){?>
                <tr>
                    <td>
                        <a href="#" onclick="if(confirm('Deseja realmente excluir essa ordem?')) Ajax('ordens.php?Action=Del&pair=ltc&id=<?php echo $id;?>; else return false;','AjaxOrdens')">
                            <img src="images/del.gif" alt="">
                        </a>
                    </td>
                    <td style="text-align:center;">LTC</td>
                    <td style="text-align:center;"><?php echo $linha["type"] == "buy"? "Compra": "Venda"; echo " (".count($linha["operations"]).")";?></td>
                    <td style="text-align:center;"><?php echo $linha["volume"];?></td>
                    <td style="text-align:center;"><?php echo $linha["price"];?></td>
                </tr><?php
            }
        }?>
    </table><?php
    $api = @file_get_contents("https://www.mercadobitcoin.net/api/ticker");
    $api = @json_decode($api, true);
    echo "Menor: ".$api["ticker"]["low"]." - Maior: ".$api["ticker"]["high"]." - Volume: ".$api["ticker"]["vol"];
}