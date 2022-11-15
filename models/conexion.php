<?php
$infoDB = array(
				
    "database" => "marketplace",   //sisadminstrativo50test
    "user" => "root",
    "pass" => "Lina1010"

);

try{

    $link = new PDO(
        "mysql:host=localhost:33060;dbname=".$infoDB["database"],
        $infoDB["user"], 
        $infoDB["pass"]
    );

    $link->exec("set names utf8");

}catch(PDOException $e){

    die("Error: ".$e->getMessage());

}

$sql = "SELECT * FROM users where id_user=18";
$stmt = $link->prepare($sql);
try{

    $stmt -> execute();

}catch(PDOException $Exception){
    error_log('No conectado::');
    error_log($Exception);
    return 0;

}

error_log(json_encode($stmt -> fetchAll(PDO::FETCH_CLASS)));