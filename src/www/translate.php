<?php
// Este arquivo traduz PHP para JavaScript

if($_GET["tipo"] == "Ordens" and $_GET["pair"] == "btc"){
    $linha = file_get_contents("https://www.mercadobitcoin.net/api/orderbook");
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "btc"){
    $linha = @file_get_contents("https://www.mercadobitcoin.net/api/trades/");
    $linha = json_decode($linha, true);
    $linha = array_reverse($linha);
    $linha = json_encode($linha);
}elseif($_GET["tipo"] == "Ordens" and $_GET["pair"] == "ltc"){
    $linha = file_get_contents("https://www.mercadobitcoin.net/api/orderbook_litecoin");
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "ltc"){
    $linha = file_get_contents("https://www.mercadobitcoin.net/api/trades_litecoin/");
    $linha = json_decode($linha, true);
    $linha = array_reverse($linha);
    $linha = json_encode($linha);
}
if($linha !== null){
    echo $linha;
}else{
    echo "{}";
}