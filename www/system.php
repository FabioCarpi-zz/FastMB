<?php
ini_set("error_reporting", E_ALL);
ini_set("html_errors", true);
ini_set("display_errors", true);
date_default_timezone_set("America/Sao_Paulo");
ini_set("default_socket_timeout", 1);
session_start();

require_once("functions.php");
ConfigLoad();