<?php

$dados = MB("OrderList&pair=btc_brl&status=completed&type=buy&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["vendacent"])){
        $dados = MB("Trade&pair=btc_brl&type=sell&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["btc"][$id]["venda"]);
        if($dados["success"] == 1){
            $_SESSION["Config"]["Auto"]["btc"][$id]["tipo"] = "sell";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=btc_brl&status=completed&type=sell&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["compracent"])){
        $dados = MB("Trade&pair=btc_brl&type=buy&volume=".$dados["operations"]["volume"]."&price=".$_SESSION["Config"]["Auto"]["btc"][$id]["compra"]);
        if($dados["success"] == 1){
            $_SESSION["Config"]["Auto"]["btc"][$id]["tipo"] = "buy";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=ltc_brl&status=completed&type=buy&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["vendacent"])){
        $dados = MB("Trade&pair=ltc_brl&type=sell&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["ltc"][$id]["venda"]);
        if($dados["success"] == 1){
            $_SESSION["Config"]["Auto"]["ltc"][$id]["tipo"] = "sell";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=ltc_brl&status=completed&type=sell&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["compracent"])){
        $dados = MB("Trade&pair=ltc_brl&type=buy&volume=".$dados["operations"]["volume"]."&price=".$_SESSION["Config"]["Auto"]["ltc"][$id]["compra"]);
        if($dados["success"] == 1){
            $_SESSION["Config"]["Auto"]["ltc"][$id]["tipo"] = "buy";
            ConfigSave();
        }
    }
}