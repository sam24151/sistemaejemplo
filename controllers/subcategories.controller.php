<?php

class SubcategoriesController{

	/*=============================================
	Creación subcategorías
	=============================================*/	

	public function create(){

		if(isset($_POST["name-subcategory"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-subcategory"] )){


			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(	
				
					"name_subcategory" => trim(TemplateController::capitalize($_POST["name-subcategory"])),
					"url_subcategory" => trim($_POST["url-name_subcategory"]),
					"id_category_subcategory" => $_POST["category-subcategory"],
					"title_list_subcategory" => $_POST["titleList-subcategory"],
					"date_created_subcategory" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		

				//$url = "subcategories?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
				//$method = "POST";
				//$fields = $data;

				//$response = CurlController::request($url,$method,$fields);
				$table= "subcategories";
				$response = json_decode(AdminModel::createData($table,$data));
				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncSweetAlert("success", "Your records were created successfully", "/subcategories");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error saving Subcategory");

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
	Edición Category
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idSubcategory"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idSubcategory"]){

				//$select = "id_subcategory";

				//$url = "subcategories?select=".$select."&linkTo=id_subcategory&equalTo=".$id;
				//$method = "GET";
				//$fields = array();
				$table= "subcategories";
				$campo ="id_subcategory";
				$response = json_decode(AdminModel::getidData($table,$campo,$id));
				//$response = CurlController::request($url,$method,$fields);
                error_log("RESPONSE SUBCATEGORI ID::");
				error_log(json_encode($response));
				if($response->status == 200){

					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-subcategory"] )){

					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						//$data = "name_subcategory=".trim(TemplateController::capitalize($_POST["name-subcategory"]))."&url_subcategory=".trim($_POST["url-name_subcategory"])."&id_category_subcategory=".$_POST["category-subcategory"]."&title_list_subcategory=".$_POST["titleList-subcategory"];
						$data = [
						   "name_subcategory" => trim(TemplateController::capitalize($_POST["name-subcategory"])),
						   "url_subcategory" => trim($_POST["url-name_subcategory"]),
						   "id_category_subcategory" => $_POST["category-subcategory"],
						   "title_list_subcategory" => $_POST["titleList-subcategory"]
						];
						/*=============================================
						Solicitud a la API
						=============================================*/		

						//$url = "subcategories?id=".$id."&nameId=id_subcategory&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						//$method = "PUT";
						//$fields = $data;
						$table="subcategories";
                        $campo="id_subcategory";
						
						$response = json_decode(AdminModel::updateData($table,$campo,$data,$id));
						//$response = CurlController::request($url,$method,$fields);
						error_log("RESPUESTA SUBCATEGORIES");
						error_log(json_encode($response));
						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/subcategories");

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

