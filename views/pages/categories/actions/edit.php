<?php 
	include_once "models/adminModel.php";
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";
            //$method = "GET";
			//$url = "categories?select=".$select."&linkTo=id_category&equalTo=".$security[0];;
			$sql = "SELECT ".$select." FROM categories WHERE id_category ="."$security[0]";
			//error_log($sql);
            $response = json_decode(AdminModel::getData($sql));
            //error_log(json_encode($response));
			//$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$category = $response->results[0];

			}else{

				echo '<script>

				window.location = "/categories";

				</script>';
				return 0;
			}

		}else{

			echo '<script>

			window.location = "/categories";

			</script>';
			return 0;

		}

	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $category->id_category ?>" name="idCategory">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/categories.controller.php";

				$create = new CategoriesController();
				$create -> edit($category->id_category);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de categoría
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="name-category"
					value="<?php echo $category->name_category ?>"
					required>

					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>

				<!--=====================================
                Url de la categoría
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Url</label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_category"
					value="<?php echo $category->url_category ?>"
					required>

				</div>

				<!--=====================================
                Listado de títulos de categoría
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Título List</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="titleList-category"
					value="<?php echo implode(",",json_decode($category->title_list_category,true)) ?>"
					required>

					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>

				<!--=====================================
                Icono de categoría
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Icon | <a href="https://fontawesome.com/v5.15/icons" target="_blank">Buscar Icon</a></label>

					<div class="input-group mb-3">

						<div class="input-group-append input-group-text viewIcon">
							<i class="<?php echo $category->icon_category ?>"></i>
						</div>

						<input 
						type="text" 
						class="form-control"
						pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
						onchange="validateJS(event,'icon')"
						name="icon-category"
						value="<?php echo $category->icon_category ?>"
						required>

						<div class="valid-feedback">Válido.</div>
	            		<div class="invalid-feedback">Campo requerido.</div>

	            	</div>

				</div>

				<!--=====================================
                Foto
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen</label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg()?>views/img/categories/<?php echo $category->id_category."/".$category->image_category; ?>" class="img-fluid changePicture" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changePicture')"
						name="image-category">

						<div class="valid-feedback">Válido.</div>
            			<div class="invalid-feedback">Campo requerido.</div>

						<label for="customFile" class="custom-file-label">Seleccione Archivo</label>

					</div>

				</div>

			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="categories" class="btn btn-light border text-left">Atrás</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>