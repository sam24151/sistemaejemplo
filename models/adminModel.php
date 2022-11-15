<?php

class AdminModel{
    static public function getData($sql){
        
		$stmt = Connectionn::connect()->prepare($sql);
		if($stmt -> execute()){
			$results =$stmt -> fetchAll(PDO::FETCH_CLASS);
			return json_encode([
				"status" =>  200,
				"results" => $results,
				"total"  => count($results)
			]);
		}else{
			error_log("Error SQL::");
            error_log(json_encode($stmt->errorInfo()[2]));
			return json_encode([
                "status" =>  404,
                "results" => [],
                "total"  => 0
            ]);
		}
    }
	
	static public function getidData($table,$campo,$id,$campos="*"){
        $sql = "SELECT $campos FROM $table WHERE $campo = $id";
		error_log("sql queda::");
		error_log($sql);
		$stmt = Connectionn::connect()->prepare($sql);
		try{

			$stmt -> execute();

		}catch(PDOException $Exception){

			return json_encode([
                "status" =>  404,
                "results" => [],
                "total"  => 0
            ]);
		
		}
        $results =$stmt -> fetchAll(PDO::FETCH_CLASS);
        error_log(json_encode($results));
		if(count($results) == 0){
			error_log("SIN RESULTS. REVISAR");
		}
		return json_encode([
            "status" =>  200,
            "results" => $results,
            "total"  => count($results)
        ]);
		
    }

    static public function createData($table, $data){
        $columns = "";
		$params = "";

		foreach ($data as $key => $value) {
			
			$columns .= $key.",";
			
			$params .= ":".$key.",";
			
		}

		$columns = substr($columns, 0, -1);
		$params = substr($params, 0, -1);


		$sql = "INSERT INTO $table ($columns) VALUES ($params)";

		$link = Connectionn::connect();
		$stmt = $link->prepare($sql);

		foreach ($data as $key => $value) {

			$stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
		
		}

		if($stmt -> execute()){

			$response = json_encode([
                "status" => 200,
				"lastId" => $link->lastInsertId(),
				"comment" => "The process was successful"
            ]);

			return $response;
		
		}else{
			error_log("Error SQL::");
            error_log(json_encode($stmt->errorInfo()[2]));
			return json_encode([
                "status" => 500,
				"lastId" => null,
				"comment" => "Error no save"
            ]);

		}


    }
    static public function updateData($table,$campo,$data,$id){
		error_log("Actualizando elemento $table::".$id);
		error_log("la data que llega::");
		error_log(json_encode($data));
		$nameId = "id_user";
        $set = "";

		foreach ($data as $key => $value) {
			
			$set .= $key." = '".$value."',";
			
		}
        
		$set = substr($set, 0, -1);

		$sql = "UPDATE $table SET $set WHERE $campo = $id";
		error_log('sentancia sql queda::');
		error_log($sql);

		$link = Connectionn::connect();
		$stmt = $link->prepare($sql);
        
		if($stmt -> execute()){

			$response = json_encode([
                "status" => 200,
				"lastId" => $link->lastInsertId(),
				"comment" => "The process was successful"
            ]);

			return $response;
		
		}else{
			error_log("Error SQL::");
            error_log(json_encode($stmt->errorInfo()[2]));
			return json_encode([
                "status" => 500,
				"lastId" => null,
				"comment" => "Error no save"
            ]);

		}

	}
    
}