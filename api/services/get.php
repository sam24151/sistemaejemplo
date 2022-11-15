<?php
$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);

if(!count($routesArray) || $routesArray[1] == "?i=1"){
	require_once "api/controllers/get.controller.php";
	require_once "api/models/connection.php";
}else{
	require_once "../api/controllers/get.controller.php";
	require_once "../api/models/connection.php";
}

error_log('array fieldss::');
error_log(json_encode($fielss));
error_log('Valor de select::');
error_log($fielss["select"]);
error_log("table::".$table);
$select = $fielss["select"] ?? "*";
$orderBy = $fielss["orderBy"] ?? null;
$orderMode = $fielss["orderMode"] ?? null;
$startAt = $fielss["startAt"] ?? null;
$endAt = $fielss["endAt"] ?? null;
$filterTo = $fielss["filterTo"] ?? null;
$inTo = $fielss["inTo"] ?? null;



/*=============================================
Peticiones GET con filtro
=============================================*/


$response = new GetController();
if(isset($fielss["linkTo"]) && isset($fielss["equalTo"]) && !isset($fielss["rel"]) && !isset($fielss["type"]) ){
    error_log("-----1");
	$n = $response -> getDataFilter($table, $select,$fielss["linkTo"],$fielss["equalTo"],$orderBy,$orderMode,$startAt,$endAt);

/*=============================================
Peticiones GET sin filtro entre tablas relacionadas
=============================================*/

}else if(isset($fielss["rel"]) && isset($fielss["type"]) && $table == "relations" && !isset($fielss["linkTo"]) && !isset($fielss["equalTo"])){
	error_log("-----2");
	$n = $response -> getRelData($fielss["rel"],$fielss["type"],$select,$orderBy,$orderMode,$startAt,$endAt);
	
/*=============================================
Peticiones GET con filtro entre tablas relacionadas
=============================================*/

}else if(isset($fielss["rel"]) && isset($fielss["type"]) && $table == "relations" && isset($fielss["linkTo"]) && isset($fielss["equalTo"])){
	error_log("-----3");
	$n = $response -> getRelDataFilter($fielss["rel"],$fielss["type"],$select,$fielss["linkTo"],$fielss["equalTo"],$orderBy,$orderMode,$startAt,$endAt);

/*=============================================
Peticiones GET para el buscador sin relaciones
=============================================*/

}else if(!isset($fielss["rel"]) && !isset($fielss["type"]) && isset($fielss["linkTo"]) && isset($fielss["search"])){
	error_log("-----4");
	$n = $response -> getDataSearch($table, $select,$fielss["linkTo"],$fielss["search"],$orderBy,$orderMode,$startAt,$endAt);
    error_log(json_encode($n));
/*=============================================
Peticiones GET para el buscador con relaciones
=============================================*/

}else if(isset($fielss["rel"]) && isset($fielss["type"]) && $table == "relations" && isset($fielss["linkTo"]) && isset($fielss["search"])){

	error_log("-----5");
	$n = $response -> getRelDataSearch($fielss["rel"],$fielss["type"],$select,$fielss["linkTo"],$fielss["search"],$orderBy,$orderMode,$startAt,$endAt);

/*=============================================
Peticiones GET para selección de rangos
=============================================*/

}else if(!isset($fielss["rel"]) && !isset($fielss["type"]) && isset($fielss["linkTo"]) && isset($fielss["between1"]) && isset($fielss["between2"])){
	error_log("-----6");
	$n = $response -> getDataRange($table,$select,$fielss["linkTo"],$fielss["between1"],$fielss["between2"],$orderBy,$orderMode,$startAt,$endAt, $filterTo, $inTo);
    
/*=============================================
Peticiones GET para selección de rangos con relaciones
=============================================*/

}else if(isset($fielss["rel"]) && isset($fielss["type"]) && $table == "relations" && isset($fielss["linkTo"]) && isset($fielss["between1"]) && isset($fielss["between2"])){
	error_log("-----7");
	$n = $response -> getRelDataRange($fielss["rel"],$fielss["type"],$select,$fielss["linkTo"],$fielss["between1"],$fielss["between2"],$orderBy,$orderMode,$startAt,$endAt, $filterTo, $inTo);

}else{
	error_log("-----8");
	/*=============================================
	Peticiones GET sin filtro
	=============================================*/

	$n = $response -> getData($table, $select,$orderBy,$orderMode,$startAt,$endAt);


}









