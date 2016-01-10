<?php

$dados = Obter("OrderList&pair=".$_GET["pair"]."_brl&status=completed&type=buy&since=".strtotime("-1 minutes"));
if(!is_null($dados) and count($dados["return"]) == 1){
    $id = key($dados["return"]);
    $dados = $dados["return"][$id];
    if(isset($_SESSION["Config"]["Auto"][$_GET["pair"]][$id]) and !is_null($_SESSION["Config"]["Auto"][$_GET["pair"]][$id]["vendacent"])){
        Obter("Trade&pair=".$_GET["pair"]."&type=sell&volume=".$dados["volume"]."&price=".$_SESSION["Config"]["Auto"][$_GET["pair"]][$id]["venda"]);
    }
}