<?php
require_once "models/adminModel.php";
include_once 'views/img/validadorimg.php';
class CategoriesController{

	/*=============================================
	Creación categorías
	=============================================*/	

	public function create(){

		if(isset($_POST["name-category"])){
            error_log('CACACCAACACACACACACcreate category:::');
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-category"] ) && 
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["titleList-category"] ) && 
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["icon-category"] )){

                

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		
                $saveImageCategory = "";
				$data = array(
				
				
					"name_category" => trim(TemplateController::capitalize($_POST["name-category"])),
					"title_list_category" => json_encode(explode(",",$_POST["titleList-category"])),
					"url_category" => trim($_POST["url-name_category"]),
					"icon_category" => trim($_POST["icon-category"]),
					"image_category" => $saveImageCategory,
					"date_created_category" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		
                /*
				$url = "categories?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
				$method = "POST";
				$fields = $data;
                */
				$table = "categories";
				$response = json_decode(AdminModel::createData($table,$data));
				error_log("Respuesta de createData:::");
				error_log(json_encode($response));
				//$response = CurlController::request($url,$method,$fields);

				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){
					$id = $response->lastId;
					
						if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){	

							$fields = array(
							
								"file"=>$_FILES["image-category"]["tmp_name"],
								"type"=>$_FILES["image-category"]["type"],
								"name"=>$_FILES["image-category"]["name"],
								"folder"=>"views/img/categories/".$id,
								"id"=>$id,
								"width"=>300,
								"height"=>300
							);
							//INICIO PICTURE
								

								//FIN PICTURE
								$saveImageCategory = Validacion::validarimg($fields);
								error_log("La imagen de categoria es:::".$saveImageCategory);
								//$saveImageCategory = CurlController::requestFile($fields);
								$dataen = [
									"image_category" => $saveImageCategory
								];
								$table = "categories";
								$campo = "id_category";
								$response = json_decode(AdminModel::updateData($table,$campo,$dataen,$id));
								error_log("Actualizada tabla categories::::");
								error_log(json_encode($response));
						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Field image error");

							</script>';

							return;
						}

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncSweetAlert("success", "Your records were created successfully", "/categories");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error saving catogory");

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
		}

	}

	/*=============================================
	Edición Categoría
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idCategory"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idCategory"]){
                
				//$select = "image_category";
				$table = "categories";
				$campo = "id_category";
				//$url = "categories?select=".$select."&linkTo=id_category&equalTo=".$id;
				//$method = "GET";
				//$fields = array();

				//$response = CurlController::request($url,$method,$fields);
				$response = json_decode(AdminModel::getidData($table,$campo,$id));
				error_log("en categoriesupdate response de getidData:::");
				error_log(json_encode($response));
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-category"] ) && 
			   			preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["titleList-category"] ) && 
			   			preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["icon-category"] )){

						/*=============================================
						Validar cambio imagen
						=============================================*/	

						if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){		
							$fields = array(
							
								"file"=>$_FILES["image-category"]["tmp_name"],
								"type"=>$_FILES["image-category"]["type"],
								"name"=>$_FILES["image-category"]["name"],
								"folder"=>"views/img/categories/".$id,
								"id"=>$id,
								"width"=>300,
								"height"=>300
							);

							$saveImageCategory = Validacion::validarimg($fields);

						}else{

							$saveImageCategory = $response->results[0]->image_category;

						}

					   	/*=============================================
						Agrupamos la información 
						=============================================*/	

						//$data = "name_category=".trim(TemplateController::capitalize($_POST["name-category"]))."&title_list_category=".json_encode(explode(",",$_POST["titleList-category"]))."&url_category=".trim($_POST["url-name_category"])."&icon_category=".trim($_POST["icon-category"])."&image_category=".$saveImageCategory;
                        $data = [
							"name_category" => trim(TemplateController::capitalize($_POST["name-category"])),
							"title_list_category" => json_encode(explode(",",$_POST["titleList-category"])),
							"url_category" => trim($_POST["url-name_category"]),
							"icon_category" => trim($_POST["icon-category"]),
							"image_category" => $saveImageCategory

						];

						/*=============================================
						Solicitud a la API
						=============================================*/		
						/*
						$url = "categories?id=".$id."&nameId=id_category&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						$method = "PUT";
						$fields = $data;*/
						$table="categories";
                        $campo="id_category";
						//$response = CurlController::request($url,$method,$fields);
						$response = json_decode(AdminModel::updateData($table,$campo,$data,$id));

						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/categories");

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

	}

}

