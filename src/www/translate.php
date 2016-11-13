<?php
// Este arquivo traduz PHP para JavaScript

if($_GET["tipo"] == "Ordens" and $_GET["pair"] == "btc"){
    $linha = "https://www.mercadobitcoin.net/api/orderbook";
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "btc"){
    $linha = "https://www.mercadobitcoin.net/api/trades/".strtotime("-24 hours");
}elseif($_GET["tipo"] == "Ordens" and $_GET["pair"] == "ltc"){
    $linha = "https://www.mercadobitcoin.net/api/orderbook_litecoin";
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "ltc"){
    $linha = "https://www.mercadobitcoin.net/api/trades_litecoin/".strtotime("-24 hours");
}
$linha = @file_get_contents($linha);
if($linha !== null){
    echo $linha;
}else{
    echo "{}";
}