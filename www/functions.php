<?php

function PhpLiveImport($nome){
    $arquivo = @file_get_contents("https://raw.githubusercontent.com/FabioCarpi/PHP-Live/master/".$nome.".txt");
    $nome = "PhpLive-".$nome.".php";
    if(!file_exists($nome) or ($arquivo !== false and hash_file("md5", $nome) != md5("<?php\n//".$arquivo))){
        file_put_contents($nome, "<?php\n".$arquivo);
    }
    require_once($nome);
}

function MB($Comando, $Json = false){
    $msg = "method=".$Comando."&tonce=".time();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.mercadobitcoin.net/tapi/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded",
        "Key: ".ChaveId,
        "Sign: ".hash_hmac("sha512", $msg, Chave)
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if($Json){
        return curl_exec($ch);
    }else{
        return json_decode(curl_exec($ch), true);
    }
}

function ConfigLoad(){
    //if(isset($_SESSION["Config"])){
    //}else
    if(!file_exists("db.json")){
        file_put_contents("db.json", null);
        $_SESSION["Config"] = array();
    }else{
        $_SESSION["Config"] = json_decode(file_get_contents("db.json"), true);
    }
}

function ConfigSave(){
    file_put_contents("db.json", json_encode($_SESSION["Config"], JSON_PRETTY_PRINT));
}

function Update($Tipo = null){
    if($Tipo == null or strtolower($Tipo) == strtolower("Saldos")){
        @$dados = MB("getInfo");
        if($dados["success"] == 0){
            echo $dados["error"];
        }elseif(!is_null($dados)){
            $_SESSION["Temp"]["Saldos"] = $dados["return"]["funds"];
        }
    }
    if($Tipo == null or $Tipo == "MyOrdens"){
        @$dados = MB("OrderList&pair=btc_brl&status=active");
        if($dados["success"] == 0){
            echo $dados["error"];
        }elseif(!is_null($dados)){
            $_SESSION["Temp"]["btc"]["MyOrdens"] = $dados["return"];
        }
        @$dados = MB("OrderList&pair=ltc_brl&status=active");
        if($dados["success"] == 0){
            echo $dados["error"];
        }elseif(!is_null($dados)){
            $_SESSION["Temp"]["ltc"]["MyOrdens"] = $dados["return"];
        }
    }
}