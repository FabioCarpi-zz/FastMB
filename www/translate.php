<?php
if($_GET["tipo"] == "Ordens" and $_GET["pair"] == "btc"){
    echo file_get_contents("https://www.mercadobitcoin.net/api/orderbook");
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "btc"){
    echo file_get_contents("https://www.mercadobitcoin.net/api/trades/".strtotime("-12 hours"));
}elseif($_GET["tipo"] == "Ordens" and $_GET["pair"] == "ltc"){
    echo file_get_contents("https://www.mercadobitcoin.net/api/orderbook_litecoin");
}elseif($_GET["tipo"] == "Mercado" and $_GET["pair"] == "ltc"){
    echo file_get_contents("https://www.mercadobitcoin.net/api/trades_litecoin/".strtotime("-12 hours"));
}