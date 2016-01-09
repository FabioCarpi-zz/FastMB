<?php // Versão 1.1.3 de 09/01/2016
ini_set("error_reporting", E_ALL);
ini_set("html_errors", true);
ini_set("display_errors", true);
date_default_timezone_set("America/Sao_Paulo");
ini_set("default_socket_timeout", 1);
session_start();

require_once("config.php");

function PhpLiveImport($nome){
	$arquivo = @file_get_contents("https://raw.githubusercontent.com/FabioCarpi/PHP-Live/master/".$nome.".txt");
	$nome = "PhpLive-".$nome.".php";
	if(!file_exists($nome) or ($arquivo !== false and hash_file("md5", $nome) != md5("<?php\n".$arquivo))){
		file_put_contents($nome, "<?php\n".$arquivo);
	}
	require_once($nome);
}

function Obter($Comando){
    $msg = "method=".$Comando."&tonce=".time();
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.mercadobitcoin.com.br/tapi/");
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
    return json_decode(curl_exec($ch), true);
}

function ConfigLoad(){
    if(!file_exists("db.dat")){
        file_put_contents("db.dat", null);
        $_SESSION["Config"]["Auto"] = array();
    }else{
        $_SESSION["Config"]["Auto"] = json_decode(file_get_contents("db.dat"), true);
    }
}

function ConfigSave(){

    file_put_contents("db.dat", json_encode($_SESSION["Config"]["Auto"]));
}