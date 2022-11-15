<?php
	include_once "models/adminModel.php";
	//$url = "stores?select=id_store,name_store&linkTo=id_user_store&equalTo=".$_SESSION["admin"]->id_user;
	//$method = "GET";
	//$fields = array();

	//$stores = CurlController::request($url,$method,$fields);
	$sql = "SELECT id_store,name_store FROM stores WHERE id_user_store=18";
			//error_log($sql);
            $stores = json_decode(AdminModel::getData($sql));
            //error_log("555555555555555555555555".json_encode($stores));
	if($stores->status == 200){

		$stores = $stores->results;
	
	}else{

		echo '<script>

		fncSweetAlert("error", "The administrator does not have a store created", "/stores");

		</script>';

	}
	

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/products.controller.php";

				$create = new ProductsController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Requirido</label>

				<!--=====================================
                Nombre de la tienda
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre de la Tienda <sup class="text-danger">*</sup></label>

					<select class="form-control select2" name="name-store" required>
						
						<option value>Selecciona Tienda</option>

						<?php foreach ($stores as $key => $value): ?>

							<option value="<?php echo $value->id_store ?>"><?php echo $value->name_store ?></option>
							
						<?php endforeach ?>

					</select>
					
					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>

				<!--=====================================
                Nombre del producto
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre del Producto <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="name-product"
					required>

					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>


				<!--=====================================
                Url de la tienda
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Url <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_product"
					required>

				</div>

				<!--=====================================
		        Categoría
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoría<sup class="text-danger">*</sup></label>

		            <?php 

		            //$url = "categories?select=id_category,name_category,url_category";
		            //$method = "GET";
		            //$fields = array();
				    $sql = "SELECT id_category,name_category,url_category FROM categories";
		            //$categories = CurlController::request($url, $method, $fields)->results;
				    $categories = json_decode(AdminModel::getData($sql))->results;
            		//error_log("555555555555555555555555::".json_encode($categories));
		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="name-category"
		                style="width:100%"
		                onchange="changeCategory(event, 'products')"
		                required>

		                    <option value="">Selecciona Categoría</option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_category ?>_<?php echo $value->url_category ?>"><?php echo $value->name_category ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Válido.</div>
            			<div class="invalid-feedback">Campo requerido.</div>

		            </div>

		        </div>

				<!--=====================================
                Subcategoría
                ======================================-->
				
		        <div class="form-group selectSubcategory mt-2" style="display:none">
		            
		            <label>Subcategoría<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">
		                    
		                <select
		                class="form-control"
		                name="name-subcategory"
		                required>
		                    
		                    <option value="">Selelecciona Subcategoría</option>

		                </select>

		                <div class="valid-feedback">Válido.</div>
		                <div class="invalid-feedback">Campo requerido.</div>

		           </div>

		        </div>

		        <!--=====================================
		        Precio de venta, precio de envío, dias de entrega y stock
		        ======================================-->

		         <div class="form-group mt-2">
		         	
		         	 <div class="row mb-3">

		         	 	<!--=====================================
		                Precio de venta
		                ======================================-->
		                
		                <div class="col-12 col-lg-3">
		                    
		                    <label>Precio del Producto<sup class="text-danger">*</sup></label>

	                        <input type="number"
	                        class="form-control"
	                        name="price-product"
	                        min="0"
	                        step="any"
	                        pattern="[.\\,\\0-9]{1,}"
	                        onchange="validateJS(event, 'numbers')"
	                        required>
	                    
	                        <div class="valid-feedback">Válido.</div>
	                        <div class="invalid-feedback">Campo requerido.</div>
       

		                </div>

		                <!--=====================================
		                Precio de envío
		                ======================================-->

		                <div class="col-12 col-lg-3">
		                    
		                    <label>Shipping<sup class="text-danger">*</sup></label>

	                        <input type="number"
	                        class="form-control"
	                        name="shipping-product"
	                        min="0"
	                        step="any"
	                        pattern="[.\\,\\0-9]{1,}"
	                         onchange="validateJS(event, 'numbers')"
	                        required>
	                    
	                        <div class="valid-feedback">Válido.</div>
	                        <div class="invalid-feedback">Campo requerido.</div> 

		                </div>

		                <!--=====================================
		                Días de entrega
		                ======================================-->

		                <div class="col-12 col-lg-3">
		                    
		                    <label>Liberación del Producto<sup class="text-danger">*</sup></label>

	                        <input type="number"
	                        class="form-control"
	                        name="delivery_time-product"
	                        min="0"
	                        pattern="[0-9]{1,}"
	                        onchange="validateJS(event, 'numbers')"
	                        required>
	                    
	                        <div class="valid-feedback">Válido.</div>
	                        <div class="invalid-feedback">Campo requerido..</div>  
 

		                </div> 

		                <!--=====================================
		                Stock
		                ======================================-->

		                <div class="col-12 col-lg-3">
		                    
		                    <label>Stock<sup class="text-danger">*</sup> (Max:100 unit)</label>

	                        <input type="number"
	                        class="form-control"
	                        name="stock-product"
	                        min="0"
	                        max="100"
	                        pattern="[0-9]{1,}"
	                        onchang onchange="validateJS(event, 'numbers')"
	                        required>
	                    
	                        <div class="valid-feedback">Válido.</div>
	                        <div class="invalid-feedback">Campo requerido.</div>  

		                     

		                </div>
		
		         	 </div>

		        </div>

		        <!--=====================================
                Imagen del producto
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen del Producto <sup class="text-danger">*</sup></label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-image.jpg" class="img-fluid changeImage" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changeImage')"
						name="image-product"
						required>

						<div class="valid-feedback">Válido.</div>
            			<div class="invalid-feedback">Campo requerido.</div>

						<label for="customFile" class="custom-file-label">Selecciona Imagen</label>

					</div>

				</div>


		        <!--=====================================
		        Descripción del producto
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Descripción del producto<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="description-product"
		            required
		            ></textarea>

		            <div class="valid-feedback">Válido.</div>
		            <div class="invalid-feedback">Campo requerido.</div>

		        </div>

		        <!--=====================================
                Palabras Claves
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Tags</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tags-product"
					required>

					<div class="valid-feedback">Válido.</div>
            		<div class="invalid-feedback">Campo requerido.</div>

				</div>	

				<!--=====================================
		        Resumen del producto
		        ======================================-->

		        <div class="form-group mt-2">
		         	
		        	<label>Producto resumen<sup class="text-danger">*</sup> Ejem: 20 horas de rebajas</label>

		        	<input type="hidden" name="inputSummary" value="1">

		        	<div class="input-group mb-3 inputSummary">
		        	 	
		        		 <div class="input-group-append">
		        		 	<span class="input-group-text">
		        		 		<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputSummary')">&times;</button>
		        		 	</span>
		        		 </div>

		        		<input
		                class="form-control py-4" 
		                type="text"
		                name="summary-product_0"
		                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
		                onchange="validateJS(event,'regex')"
		                required>

		                <div class="valid-feedback">Válido.</div>
                		<div class="invalid-feedback">Campo requerido.</div>

		        	</div>

		        	<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSummary')">Add Summary</button>

		        </div>

		        <!--=====================================
		        Detalles del producto
		        ======================================-->

		        <div class="form-group mt-2">
		         	
		        	<label>Detalles del Producto<sup class="text-danger">*</sup> Ex: <strong>Título:</strong> Bluetooth, <strong>Value:</strong> Yes</label>

		        	<input type="hidden" name="inputDetails" value="1">

		        	<div class="row mb-3 inputDetails">

		        		<!--=====================================
               			Entrada para el título del detalle
                		======================================--> 

                		<div class="col-12 col-lg-6 input-group">
		        	 	
			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputDetails')">&times;</button>
			        		 	</span>
			        		 </div>

			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		Título:
			        		 	</span>
			        		 </div>

			        		<input
			                class="form-control py-4" 
			                type="text"
			                name="details-title-product_0"
			                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
			                onchange="validateJS(event,'regex')"
			                required>

			                <div class="valid-feedback">Válido.</div>
	                		<div class="invalid-feedback">Campo requerido.</div>

	                	</div>

	                	<!--=====================================
               			Entrada para valores del detalle
                		======================================--> 

                		<div class="col-12 col-lg-6 input-group">
		        	 	
			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		Valor:
			        		 	</span>
			        		 </div>

			        		<input
			                class="form-control py-4" 
			                type="text"
			                name="details-value-product_0"
			                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
			                onchange="validateJS(event,'regex')"
			                required>

			                <div class="valid-feedback">Válido.</div>
	                		<div class="invalid-feedback">Campo requerido.</div>

	                	</div>


		        	</div>

		        	<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputDetails')">Agregar Detalles</button>

		        </div>

		         <!--=====================================
		        Especificaciones técnicas del producto
		        ======================================-->

		        <div class="form-group mt-2">
		         	
		        	<label>Especificationes del Producto Ejem: <strong>Tipo:</strong> Color, <strong>Valores:</strong> Black, Red, White</label>

		        	<input type="hidden" name="inputSpecifications" value="1">

		        	<div class="row mb-3 inputSpecifications">

		        		<!--=====================================
               			Entrada para el tipo de especificacion
                		======================================--> 

                		<div class="col-12 col-lg-6 input-group">
		        	 	
			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputSpecifications')">&times;</button>
			        		 	</span>
			        		 </div>

			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		Tipo:
			        		 	</span>
			        		 </div>

			        		<input
			                class="form-control py-4" 
			                type="text"
			                name="spec-type-product_0"
			                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
			                onchange="validateJS(event,'regex')"
			                >

			                <div class="valid-feedback">Válido.</div>
	                		<div class="invalid-feedback">Campo requerido.</div>

	                	</div>

	                	<!--=====================================
               			Entrada para valores de lae specificación
                		======================================--> 

                		<div class="col-12 col-lg-6 input-group">
		        	 	
	
			        		<input
			                class="form-control py-4 tags-input" 
			                type="text"
			                name="spec-value-product_0"
			                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
			                onchange="validateJS(event,'regex')"
			                >

			                <div class="valid-feedback">Válido.</div>
	                		<div class="invalid-feedback">Campo requerido.</div>

	                	</div>


		        	</div>

		        	<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSpecifications')">Add Specification</button>

		        </div>

		        <!--=====================================
		        Galería del producto
		        ======================================-->

		        <div class="form-group mt-2">
		        	
		        	<label>Galería del Producto: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">
		        	 	
		        		<div class="dz-message">
		        			
		        		   Seleccione su Imagen aquí, tamaño max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-product">

		        </div>

		        <!--=====================================
		        Video del producto
		        ======================================-->

		        <div class="form-group mt-2">
		        	

		        	<label>Video | Ejem: <strong>Tipo:</strong> YouTube, <strong>Id:</strong> Sl5FaskVpD4</label> 

		        	<div class="row mb-3"> 

		        		<div class="col-12 col-lg-6 input-group mx-0 pr-0">

		        			<div class="input-group-append">
		                        <span class="input-group-text">
		                            Tipo:
		                        </span>
		                    </div>

		                    <select 
		                    class="form-control"                               
		                    name="type_video"
		                    >
		                        <option value="">Seleccione Plataforma</option>
		                        <option value="youtube">YouTube</option>
		                        <option value="vimeo">Vimeo</option>

		                    </select>

		        		</div>

		        		<div class="col-12 col-lg-6  input-group mx-0">
		        			
		        			<div class="input-group-append">
		                        <span class="input-group-text">
		                            Id:
		                        </span>
		                    </div>

		                    <input
		                    type="text"
		                    class="form-control"                               
		                    name="id_video"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
		                    maxlength="100"
		                    onchange="validateJS(event,'regex')"
		                    >

		                    <div class="valid-feedback">Válido.</div>
                    		<div class="invalid-feedback">Campo requerido.</div>   

		        		</div>

		        	</div>


		        </div>

		          <!--=====================================
		        Banner Top del producto
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>Top Banner<sup class="text-danger">*</sup>, Ejem:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/example-top-banner.png" class="img-fluid">

		            </figure>

		            <div class="row mb-5">
		                
		                <!--=====================================
		                H3 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">
		                     
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3 Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: 20%"
		                    name="topBannerH3Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                 </div>

		                <!--=====================================
		                P1 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            P1 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Disccount"
		                    name="topBannerP1Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                H4 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H4 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: For Books Of March"
		                    name="topBannerH4Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                 <!--=====================================
		                P2 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            P2 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Enter Promotion"
		                    name="topBannerP2Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                Span Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Span Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: Sale2019"
		                    name="topBannerSpanTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                 <!--=====================================
		                Button Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Button Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: Shop now"
		                    name="topBannerButtonTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                IMG Tag
		                ======================================-->

		                <div class="col-12">

		                    <label>IMG Tag:</label>

		                    <div class="form-group__content">

		                        <label class="pb-5" for="topBanner">
		                           <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-top-banner.jpg" class="img-fluid changeTopBanner">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="topBanner"
		                            name="topBanner"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeTopBanner')"
		                            required>

		                            <div class="valid-feedback">Válido.</div>
		                            <div class="invalid-feedback">Campo requerido.</div>

		                            <label class="custom-file-label" for="topBanner">Seleccione Imagen</label>   

		                        </div>       

		                    </div>

		                </div>


		            </div>

		        </div>

		        <!--=====================================
		        Banner por defecto del producto
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>Default Banner<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="defaultBanner">
		                   <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-banner.jpg" class="img-fluid changeDefaultBanner" style="width:500px">
		                </label> 

		                <div class="custom-file">

		                    <input type="file"
		                    class="custom-file-input"
		                    id="defaultBanner"
		                    name="defaultBanner"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeDefaultBanner')"
		                    required>

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                    <label class="custom-file-label" for="defaultBanner">Elija Imagen</label>   

		                </div>         
		                
		            </div>

		        </div>

		         <!--=====================================
		        Slide Horizontal del producto
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>Horizontal Slider<sup class="text-danger">*</sup>, Ejem:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/example-horizontal-slider.png" class="img-fluid">

		            </figure>

		            <div class="row mb-3">
		                
		                <!--=====================================
		                H4 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H4 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Limit Edition"
		                    name="hSliderH4Tag"       
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                H3-1 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-1 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Happy Summer"
		                    name="hSliderH3_1Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                H3-2 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-2 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Combo Super Cool"
		                    name="hSliderH3_2Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                H3-3 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-3 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Up to"
		                    name="hSliderH3_3Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                H3-4s Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-4s Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: 40%"
		                    name="hSliderH3_4sTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>


		                <!--=====================================
		                Button Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Button Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Shop now"
		                    name="hSliderButtonTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    required
		                    >

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                </div>

		                <!--=====================================
		                IMG Tag
		                ======================================-->

		                <div class="col-12">

		                    <label>IMG Tag:</label>

		                    <div class="form-group__content">

		                        <label class="pb-5" for="hSlider">
		                           <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-horizontal-slider.jpg" class="img-fluid changeHSlider">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="hSlider"
		                            name="hSlider"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeHSlider')"
		                            required>

		                            <div class="valid-feedback">Válido.</div>
		                            <div class="invalid-feedback">Campo requerido.</div>

		                            <label class="custom-file-label" for="hSlider">Elija Imagen</label>   

		                        </div>         
		 
		                        
		                    </div>

		                </div>

		            </div>

		        </div> 

		        <!--=====================================
		        Slide Vertical del producto
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>Vertical Slider<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="vSlider">

		                    <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-vertical-slider.jpg" class="img-fluid changeVSlider" style="width:260px">

		                </label>

		                <div class="custom-file">

		                    <input type="file" 
		                    class="custom-file-input" 
		                    id="vSlider"
		                    name="vSlider"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeVSlider')"
		                    required>

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>

		                    <label class="custom-file-label" for="vSlider">Seleccione Imagen</label>

		                </div>     
		                
		            </div>

		        </div> 

		         <!--=====================================
		        Oferta del producto
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Oferta Producto Ejem: <strong>Tipo:</strong> Descontinuado, <strong>Porcentaje %:</strong> 25, <strong>Fin:</strong> 30/06/2020</label>

		            <div class="row mb-3">

		                <!--=====================================
		                Tipo de Oferta
		                ======================================-->
		                
		                <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">
		                    
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Tipo:
		                        </span>
		                    </div>

		                    <select
		                    class="form-control"
		                    name="type_offer"
		                    onchange="changeOffer(event)">
		                        
		                        <option value="Discount">Discount</option>
		                        <option value="Fixed">Fixed</option>

		                    </select>

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>        

		                </div>

		                <!--=====================================
		                El valor de la oferta
		                ======================================-->

		                <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">
		                
		                    <div class="input-group-append">
		                       
		                        <span 
		                        class="input-group-text typeOffer">
		                            Percentaje %:
		                        </span>

		                    </div>

		                    <input type="number"
		                    class="form-control"
		                    name="value_offer"
		                    min="0"
		                    step="any"
		                    pattern="[.\\,\\0-9]{1,}"
		                     onchange="validateJS(event, 'numbers')">

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>     

		                </div>

		                <!--=====================================
		                Fecha de vencimiento de la oferta
		                ======================================-->

		                <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">
		                    
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Fin:
		                        </span>
		                    </div>

		                    <input type="date"
		                    class="form-control"
		                    name="date_offer">

		                    <div class="valid-feedback">Válido.</div>
		                    <div class="invalid-feedback">Campo requerido.</div>     

		                </div>
		                  

		            </div>   

		        </div>

			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/admins" class="btn btn-light border text-left">Atrás</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>