<?php
require_once "models/adminModel.php";
class AdminsController{

	/*=============================================
	Login de administradores
	=============================================*/	
    
	public function login(){

		if(isset($_POST["loginEmail"])){

			echo '<script>

				matPreloader("off");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/	

			if(preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["loginEmail"] )){

				$fields = array(

					"email_user" => $_POST["loginEmail"],
					"password_user" => $_POST["loginPassword"]

				);
				//buscamos en la base de datos el usuario y el pass
				//require_once "./models/connection.php";
				//require_once "models/loginModel.php";
				//$response = LoginModel::getData($fields);
				//var_dump(json_encode($response));
				
				require_once "models/loginModel.php";
				$response = json_decode(LoginModel::getData($fields));
				error_log(json_encode($response));
                
				//$response = CurlController::request($url,$method,$fields);

				/*=============================================
				Validamos que si escriba correctamente los datos
				=============================================*/	
				
				if($response->status == 200){

					/*=============================================
					Validamos que si tenga rol administrativo
					=============================================*/	

					if($response->results[0]->rol_user != "admin"){

						echo ' <div class="alert alert-danger">You do not have permissions to access</div>';
						return;
					}


					/*=============================================
					Creamos variable de sesión
					=============================================*/	

					$_SESSION["admin"] = $response->results[0];
					
					echo '<script>

					fncFormatInputs();

					localStorage.setItem("token_user", "'.$response->results[0]->token_user.'");

					window.location = "'.$_SERVER["REQUEST_URI"].'"

					</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
				
					</script> 
					<div class="alert alert-danger">'.$response->results.'</div>';

				}

			}else{

				echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
				
					</script> 

				 <div class="alert alert-danger">Field syntax error</div>';

			}		

		}

	}

	/*=============================================
	Creación administradores
	=============================================*/	

	public function create(){

		if(isset($_POST["displayname"])){
            error_log('en create de adminController');
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["displayname"] ) && 
			   preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["username"] ) && 
			   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"] ) &&
			   preg_match('/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["password"] ) && 
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["city"] ) &&
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["address"] ) &&
			   preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["phone"] )){

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(

					"rol_user" => "admin",
					"displayname_user" => trim(TemplateController::capitalize($_POST["displayname"])),
					"username_user" => trim(strtolower($_POST["username"])),
					"email_user" => trim(strtolower($_POST["email"])),
					"password_user" =>  crypt(trim($_POST["password"]), '$2a$07$azybxcags23425sdg23sdfhsd$'),
					"country_user" => trim(explode("_",$_POST["country"])[0]),
					"city_user" => trim(TemplateController::capitalize($_POST["city"])),
					"address_user" => trim($_POST["address"]),
					"phone_user" =>  trim(explode("_",$_POST["country"])[1]."_".$_POST["phone"]),
					"method_user" => "direct",
					"verification_user" => 1,
					"date_created_user" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		
                error_log('creando nuevo admin');
				//$url = "users?register=true&suffix=user";
				//$method = "POST";
				//$fields = $data;
				$table = "users";
                $response = json_decode(AdminModel::createData($table,$data));
				//$response = CurlController::request($url,$method,$fields);
				error_log('respuesta de CurlController::');
                error_log(json_encode($response));
				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){

					/*=============================================
					Tomamos el ID
					=============================================*/		

					$id = $response->lastId;

					/*=============================================
					Validamos y creamos la imagen en el servidor
					=============================================*/	

					if(isset($_FILES["picture"]["tmp_name"]) && !empty($_FILES["picture"]["tmp_name"])){	

						$fields = array(
							"file"=>$_FILES["picture"]["tmp_name"],
							"type"=>$_FILES["picture"]["type"],
							"name"=>$_FILES["picture"]["name"],
							"folder"=>"views/img/users/".$id,
							"id"=>$id,
							"width"=>300,
							"height"=>300
						);
						//INICIO PICTURE
						include_once 'views/img/validadorimg.php';

						//FIN PICTURE
                        $picture = Validacion::validarimg($fields);
						//$picture = CurlController::requestFile($fields);
                        error_log('respuesta de curlcontrollerFile::');
						error_log($picture);
					
						/*=============================================
						Solicitud a la API
						=============================================*/	
						
						//$url = "users?id=".$id."&nameId=id_user&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						//$method = "PUT";
						//$fields = 'picture_user='.$picture;
						$table="users";
						$campo = "id_user";
						$dataen = [
							"picture_user" => $picture
						];
                        $response = json_decode(AdminModel::updateData($table,$campo,$dataen,$id));
						//$response = CurlController::request($url,$method,$fields);
						error_log('respuesta de curlController después de almacenar imagen');
						error_log(json_encode($response));
						if(!$response){
							echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error saving image");

							</script>';
							return;
						}
						if($response->status == 200){

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/admins");

							</script>';



						}
						

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error saving image");

						</script>';

					}
					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Field syntax error");

				</script>';

				
			}
		}

	}

	/*=============================================
	Edición administradores
	=============================================*/	

	public function edit($id){
		error_log('En edit de adminController');
		error_log('obtenemos el id::'. $id);
		if(isset($_POST["idAdmin"])){
            error_log('enviamos por forumlario el idAdmin');
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idAdmin"]){
                error_log('El id es igual al idAdmin pasado por post');
				$select = "password_user,picture_user";
                $table = "users";
				$campo = "id_user";
				//$url = "users?select=".$select."&linkTo=id_user&equalTo=".$id;
				//$method = "GET";
				//$fields = array();
                //buscamos el id
				//$response = CurlController::request($url,$method,$fields);
				error_log('obteniendo datos del id::'.$id.'Resultado::');
				$response = json_decode(AdminModel::getidData($table,$campo,$id));
			    error_log(json_encode($response));
				
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["displayname"] ) && 
					   preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["username"] ) && 
					   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"] ) &&
					   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["city"] ) &&
					   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["address"] ) &&
					   preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["phone"] )){
                        error_log('validando lado backend campos: pasan prueba');

					   	/*=============================================
						Validar cambio contraseña
						=============================================*/	

						if(!empty($_POST["password"])){
                            error_log('hay cambio de contraseña');
							$password = crypt(trim($_POST["password"]), '$2a$07$azybxcags23425sdg23sdfhsd$');
						
						}else{
							error_log('No cambio de contraseña');
							$password = $response->results[0]->password_user;

						}

						/*=============================================
						Validar cambio imagen
						=============================================*/	
						
						if(isset($_FILES["picture"]["tmp_name"]) && !empty($_FILES["picture"]["tmp_name"])){	
							error_log("hay imagen");
								$fields = array(
								
									"file"=>$_FILES["picture"]["tmp_name"],
									"type"=>$_FILES["picture"]["type"],
									"name"=>$_FILES["picture"]["name"],
									"folder"=>"views/img/users/".$id,
									"id"=>$id,
									"width"=>300,
									"height"=>300
								);
								include_once 'views/img/validadorimg.php';
								error_log('Validando imagen resultado::::');
								$picture = Validacion::validarimg($fields);
								error_log(json_encode($picture));
								//$picture = CurlController::requestFile($fields);

						}else{
							error_log('Es la misma imagen');
							$picture = $response->results[0]->picture_user;

						}

					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = [

						"displayname_user" => trim(TemplateController::capitalize($_POST["displayname"])),
						"username_user" => trim(strtolower($_POST["username"])),
						"email_user" => trim(strtolower($_POST["email"])),
						"password_user" => $password,
						"country_user" => trim(explode("_",$_POST["country"])[0]),
						"city_user" =>  trim(TemplateController::capitalize($_POST["city"])),
						"address_user" => trim($_POST["address"]),
						"phone_user" => trim(explode("_",$_POST["country"])[1]."_".$_POST["phone"]),
						"picture_user" => $picture
						];
						error_log('los datos a enviar a update::');
						error_log(json_encode($data));
						/*=============================================
						Solicitud a la API
						=============================================*/		
						$table ="users";
						$campo = "id_user";
						//$url = "users?id=".$id."&nameId=id_user&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						//$method = "PUT";
						//$fields = $data;
						$response = json_decode(AdminModel::updateData($table,$campo,$data,$id));
						error_log('response de updateData');
						error_log(json_encode($response));
						//$response = CurlController::request($url,$method,$fields);

						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/admins");

							</script>';
	
						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error editing the registry");

							</script>';
							
						}

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Field syntax error");

						</script>';
						
					}

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error editing the registry");

					</script>';

					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Error editing the registry");

				</script>';

				
			}
		}
        error_log('fin de la funcion edit de admincontroller');
	}

}

