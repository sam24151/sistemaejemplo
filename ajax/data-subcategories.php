<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";
require_once "../api/Routes.php";

class DatatableController{

	public function data(){

		if(!empty($_POST)){

			/*=============================================
            Capturando y organizando las variables POST de DT
            =============================================*/
			
			$draw = $_POST["draw"];//Contador utilizado por DataTables para garantizar que los retornos de Ajax de las solicitudes de procesamiento del lado del servidor sean dibujados en secuencia por DataTables 

			$orderByColumnIndex = $_POST['order'][0]['column']; //Índice de la columna de clasificación (0 basado en el índice, es decir, 0 es el primer registro)

			$orderBy = $_POST['columns'][$orderByColumnIndex]["data"];//Obtener el nombre de la columna de clasificación de su índice

			$orderType = $_POST['order'][0]['dir'];// Obtener el orden ASC o DESC

			$start  = $_POST["start"];//Indicador de primer registro de paginación.

            $length = $_POST['length'];//Indicador de la longitud de la paginación.

            /*=============================================
            El total de registros de la data
            =============================================*/
            
            $url = "relations?rel=subcategories,categories&type=subcategory,category&select=id_subcategory&linkTo=date_created_subcategory&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

			$method = "GET";
			$tabla = "relations";
			$fieldss = [
			     "rel" => "subcategories,categories",
				 "type" => "subcategory,category",
				 "select" => "id_subcategory",
				 "linkTo" => "date_created_subcategory",
				 "between1" => $_GET["between1"],
				 "between2" => $_GET["between2"]
			];

			//$response = CurlController::request($url,$method,$fields);  
            $response = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss));
			if($response->status == 200){	

				$totalData = $response->total;
			
			}else{

				echo '{"data": []}';

                return;

			}	

			/*=============================================
           	Búsqueda de datos
            =============================================*/	

            $select = "id_subcategory,image_subcategory,name_subcategory,title_list_subcategory,url_subcategory,name_category,views_subcategory,date_created_subcategory";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["name_subcategory","url_subcategory","name_category","date_created_subcategory"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=subcategories,categories&type=subcategory,category&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
                        $fieldss = [
							"rel" => "subcategories,categories",
							"type" => "subcategory,category",
							"select" => $select,
							"linkTo" => $value,
							"search" => $search,
							"orderBy" => $orderBy,
							"orderMode" => $orderType,
							"startAt" => $start,
							"endAt=" =>$length

						];
	            		//$data = CurlController::request($url,$method,$fields)->results;
						$data = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss))->results; 
	            		if($data  == "Not Found"){

	            			$data = array();
	            			$recordsFiltered = count($data);

	            		}else{

	            			$data = $data;
	            			$recordsFiltered = count($data);

	            			break;

	            		}

	            	}

            	}else{

        			echo '{"data": []}';

                	return;

            	}

            }else{

	            /*=============================================
	            Seleccionar datos
	            =============================================*/

	            $url = "relations?rel=subcategories,categories&type=subcategory,category&select=".$select."&linkTo=date_created_subcategory&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
				$fieldss = [
					"rel" => "subcategories,categories",
					"type" => "subcategory,category",
					"select" => $select,
					"linkTo" => "date_created_subcategory",
					"between1" => $_GET["between1"],
					"between2" => $_GET["between2"],
					"orderBy" => $orderBy,
					"orderMode" => $orderType,
					"startAt" => $start,
					"endAt" => $length

				];
	            
				//$data = CurlController::request($url,$method,$fields)->results;
				$data = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss))->results; 


	            $recordsFiltered = $totalData;

            }  


            /*=============================================
            Cuando la data viene vacía
            =============================================*/

            if(empty($data)){

            	echo '{"data": []}';

            	return;

            }

            /*=============================================
            Construimos el dato JSON a regresar
            =============================================*/

            $dataJson = '{

            	"Draw": '.intval($draw).',
            	"recordsTotal": '.$totalData.',
            	"recordsFiltered": '.$recordsFiltered.',
            	"data": [';

            /*=============================================
            Recorremos la data
            =============================================*/	

            foreach ($data as $key => $value) {

            	if($_GET["text"] == "flat"){

	            	$actions = "";
	            	
            	}else{


            		$actions = "<a href='/subcategories/edit/".base64_encode($value->id_subcategory."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>

	            		<i class='fas fa-pencil-alt'></i>

	            		</a>

	            		<a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_subcategory."~".$_GET["token"])."' table='subcategories' suffix='subcategory' deleteFile='no' page='subcategories'>

	            		<i class='fas fa-trash'></i>

            		</a>";

			        $actions = TemplateController::htmlClean($actions);
            	}	


            	$name_subcategory = $value->name_subcategory;
            	$title_list_subcategory =$value->title_list_subcategory;
            	$name_category = $value->name_category;
            	$url_subcategory = $value->url_subcategory;		
            	$views_subcategory = $value->views_subcategory;	
            	$date_created_subcategory = $value->date_created_subcategory;	

            	$dataJson.='{ 

            		"id_subcategory":"'.($start+$key+1).'",
            		"name_subcategory":"'.$name_subcategory.'",
            		"title_list_subcategory":"'.$title_list_subcategory.'",
            		"name_category":"'.$name_category.'",
            		"url_subcategory":"'.$url_subcategory.'",		
            		"views_subcategory":"'.$views_subcategory.'",
            		"date_created_subcategory":"'.$date_created_subcategory.'",
            		"actions":"'.$actions.'"

            	},';

            }

            $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

            $dataJson .= ']}';

            echo $dataJson;
		}

	}

}

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();


