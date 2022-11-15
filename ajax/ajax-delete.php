<?php

//require_once "../controllers/curl.controller.php";
require_once "../models/connetion.php";
class DeleteController{

	public $idItem;
	public $table;
	public $suffix;
	public $token;
	public $deleteFile;

	public function dataDelete(){

		$security = explode("~",base64_decode($this->idItem));
        error_log('Validando token');
		if($security[1] == $this->token){
           error_log('El token es correcto');
		   error_log('security tiene::');
		   error_log(json_encode($security));
			/*=============================================
			Validar primero que la categoría no tenga productos
			=============================================*/
			/*	
			if($this->table == "categories" || $this->table == "subcategories" || $this->table == "stores"){

				$url = "products?select=id_product&linkTo=id_".$this->suffix."_product&equalTo=".$security[0];
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);
				
				if($response->status == 200){

					echo "no-delete";

					return;

				}
			
			}


			/*=============================================
			Validar que si vengan archivos para borrar
			=============================================*/
            /*
			if($this->deleteFile != "no"){

				if($this->table == "products"){

					$count = 0;

					foreach (json_decode(base64_decode($this->deleteFile),true) as $key => $value) {

						$count++;
						
						$fields = array(
									
						 "deleteFile"=>$value

						);

						CurlController::requestFile($fields);

						if($count == count(json_decode(base64_decode($this->deleteFile),true))){

							$picture = "ok";
						}
					}

				}else{

					$fields = array(
									
					 "deleteFile"=>$this->deleteFile,
					 "deleteDir"=>$this->suffix

					);

					$picture = CurlController::requestFile($fields);

				}

			}else{

				$picture = "ok";
				
			}

			/*=============================================
			Eliminar registro
			=============================================*/
            $picture ="ok";
			if($picture == "ok"){
                error_log('Preparndo eliminar el registro de tabla');
				error_log($this->table);
				//validamos el id
				$table = $this->table;
				$suffix = $this->suffix;
				//$idItem = $this->idItem;
				$sql = "DELETE FROM $table WHERE id_$suffix = ".$security[0];
                error_log("sql queda::");
				error_log($sql);
				$link = Connectionn::connect();
				$stmt = $link->prepare($sql);


				if($stmt -> execute()){

					$response = array(

						"comment" => "The process was successful"
					);
                    echo 200;
					return 0;
				
				}else{
					echo 404;
					error_log(json_encode($link->errorInfo()));
					return ;

				}

	            
				//$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				//$method = "DELETE";
				//$fields = array();

				//$response = CurlController::request($url, $method, $fields);
				
				//echo  $response->status;
				echo 404;

			}

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idItem"])){

	$validate = new DeleteController();
	$validate -> idItem = $_POST["idItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> deleteFile = $_POST["deleteFile"];
	$validate -> dataDelete();

}