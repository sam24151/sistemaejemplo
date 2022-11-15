<?php

/*=============================================
Mostrar errores
=============================================*/
date_default_timezone_set('America/Mexico_City');
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "C:/xampp/htdocs/sisadminstrativo/50/php_error_log");

/*=============================================
CORS
=============================================*/
/*
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
*/
/*=============================================
Requerimientos
=============================================*/
error_log('*************************inicio');
require_once "controllers/template.controller.php";
//require_once "controllers/curl.controller.php";

require "extensions/vendor/autoload.php";
require_once "models/connetion.php";
require_once "api/Routes.php";
                  

$index = new TemplateController();
$index -> index();