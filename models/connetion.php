<?php

class Connectionn{

	/*=============================================
	Información de la base de datos
	=============================================*/

	static public function infoDatabase(){

		$infoDB = array(

			"database" => "epiz_32895235_market50",//"marketplace",   //sisadminstrativo50test
			"user" => "epiz_32895235",
			"pass" => "zHsxzlG5B0X"

		);

		return $infoDB;

	}

    	/*=============================================
	Conexión a la base de datos
	=============================================*/

	static public function connect(){

		try{

			$link = new PDO(
				"mysql:host=sql304.epizy.com:3306;dbname=".Connectionn::infoDatabase()["database"],
				Connectionn::infoDatabase()["user"], 
				Connectionn::infoDatabase()["pass"]
			);

			$link->exec("set names utf8");

		}catch(PDOException $e){

			die("Error: ".$e->getMessage());

		}

		return $link;

	}


}