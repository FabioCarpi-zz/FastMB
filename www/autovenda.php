<?php

$dados = MB("OrderList&pair=btc_brl&status=completed&type=buy&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["venda"])){
        $dados = reset($dados["operations"]);
        $dados = MB("Trade&pair=btc_brl&type=sell&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["btc"][$id]["venda"]);
        if($dados["success"] == 1){
            unset($_SESSION["Config"]["Auto"]["btc"][$id]);
            $_SESSION["Config"]["Auto"]["btc"][key($dados["return"])]["tipo"] = "sell";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=btc_brl&status=completed&type=sell&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["btc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["btc"][$id]["compra"])){
        $dados = reset($dados["operations"]);
        $dados = MB("Trade&pair=btc_brl&type=buy&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["btc"][$id]["compra"]);
        if($dados["success"] == 1){
            unset($_SESSION["Config"]["Auto"]["btc"][$id]);
            $_SESSION["Config"]["Auto"]["btc"][key($dados["return"])]["tipo"] = "buy";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=ltc_brl&status=completed&type=buy&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["venda"])){
        $dados = reset($dados["operations"]);
        $dados = MB("Trade&pair=ltc_brl&type=sell&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["ltc"][$id]["venda"]);
        if($dados["success"] == 1){
            unset($_SESSION["Config"]["Auto"]["ltc"][$id]);
            $_SESSION["Config"]["Auto"]["ltc"][key($dados["return"])]["tipo"] = "sell";
            ConfigSave();
        }
    }
}

$dados = MB("OrderList&pair=ltc_brl&status=completed&type=sell&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"]["ltc"][$id]) and !is_null($_SESSION["Config"]["Auto"]["ltc"][$id]["compra"])){
        $dados = reset($dados["operations"]);
        $dados = MB("Trade&pair=ltc_brl&type=buy&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"]["ltc"][$id]["compra"]);
        if($dados["success"] == 1){
            unset($_SESSION["Config"]["Auto"]["ltc"][$id]);
            $_SESSION["Config"]["Auto"]["ltc"][key($dados["return"])]["tipo"] = "buy";
            ConfigSave();
        }
    }
}