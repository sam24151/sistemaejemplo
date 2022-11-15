<div class="card card-dark card-outline">
   
	<form method="post" class="needs-validation" novalidate>
	
		<div class="card-header">

			<?php
                include_once "models/adminModel.php";
			 	require_once "controllers/subcategories.controller.php";

				$create = new SubcategoriesController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de subcategoría
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateRepeat(event,'text','subcategories','name_subcategory')"
					name="name-subcategory"
					required>

					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>

				<!--=====================================
                Url de la subcategoría
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Url</label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_subcategory"
					required>

				</div>

				<!--=====================================
		        Categoría
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoría<sup class="text-danger">*</sup></label>

		            <?php 

		            //$url = "categories?select=id_category,name_category";
		            //$method = "GET";
		            //$fields = array();

		            //$categories = CurlController::request($url, $method, $fields)->results;
					$table= "categories";
					$sql = "SELECT id_category,name_category FROM categories";
					$categories = json_decode(AdminModel::getData($sql))->results;
		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="category-subcategory"
		                style="width:100%"
		                onchange="changeCategory(event, 'subcategories')"
		                required>

		                    <option value="">Selecciona Categoría</option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_category ?>"><?php echo $value->name_category ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Válido.</div>
            			<div class="invalid-feedback">Campo requerido.</div>

		            </div>

		        </div>

				<!--=====================================
                Listado de títulos de subcategoría
                ======================================-->
				
		        <div class="form-group titleList" style="display:none">
		            
		            <label>Título List<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">
		                    
		                <select
		                class="form-control"
		                name="titleList-subcategory"
		                required>
		                    
		                    <option value="">Seleccione Título list</option>

		                </select>

		                <div class="valid-feedback">Válidó.</div>
		                <div class="invalid-feedback">Campo requerido.</div>

		           </div>

		        </div>


			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="subcategories" class="btn btn-light border text-left">Atrás</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>