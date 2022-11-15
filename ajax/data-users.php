<?php

require_once "../models/adminModel.php";
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
            $method = "GET";
            $url = "users?select=id_user&linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=rol_user&inTo='default'";
            $tabla = 'users';
			
			$fieldss = [
				"select" => "id_user",
				"linkTo" => "date_created_user",
				"between1" => $_GET["between1"],
				"between2" => $_GET["between2"],
				"filterTo" => "rol_user",
				"inTo"  => "default"
			];

			//$response = json_decode(AdminModel::getData($fields));
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

            $select = "id_user,picture_user,displayname_user,username_user,email_user,country_user,city_user,date_created_user,method_user,address_user,phone_user";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["displayname_user","username_user","email_user","country_user","city_user","date_created_user"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);

	            	foreach ($linkTo as $key => $value) {
	            		$method ="GET";
	            		$url = "users?select=".$select."&linkTo=".$value.",rol_user&search=".$search.",default&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
						$tabla = 'users';
						$fieldss = [
							"select" => $select,
							"linkTo" => $value.",rol_user",
							"search" => $search.",default",
							"orderBy" => $orderBy,
							"orderMode" => $orderType,
							"startAt" => $start,
							"endAt" => $length
						];
	            		//$data = CurlController::request($url,$method,$fields)->results;
						$data = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss))->results;
                        error_log('QQQQQQQQQQQQQ::'.json_encode($data));
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
				$method ="GET";
	            $url = "users?select=".$select."&linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=rol_user&inTo='default'&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;
				$tabla = "users";
				$fieldss = [
					"select" => $select,
					"linkTo" => "date_created_user",
					"between1" => $_GET["between1"],
					"between2" => $_GET["between2"],
					"filterTo" => "rol_user",
					"inTo" => "default",
					"orderBy" => $orderBy,
					"orderMode" => $orderType,
					"startAt" => $start,
					"endAt" => $length
				];

				$data = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss))->results;
				error_log("QQQQQQQdata:::::".json_encode($data));
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
	            	
	            	$picture_user = $value->picture_user;
	            	$actions = "";
	            	
            	}else{


            	    $picture_user = "<img src='".TemplateController::returnImg($value->id_user,$value->picture_user,$value->method_user)."' class='img-circle' style='width:70px'>";

            	}	


            	$displayname_user = $value->displayname_user;
            	$username_user = $value->username_user;	
            	$email_user = $value->email_user;
            	$method_user = $value->method_user;
            	$country_user = $value->country_user;	
            	$city_user = $value->city_user;	
            	$address_user = $value->address_user;
            	$phone_user = $value->phone_user;	
            	$date_created_user = $value->date_created_user;	

            	$dataJson.='{ 

            		"id_user":"'.($start+$key+1).'",
            		"picture_user":"'.$picture_user.'",
            		"displayname_user":"'.$displayname_user.'",
            		"username_user":"'.$username_user.'",
            		"email_user":"'.$email_user.'",
            		"method_user":"'.$method_user.'",
            		"country_user":"'.$country_user.'",
            		"city_user":"'.$city_user.'",
            		"address_user":"'.$address_user.'",
            		"phone_user":"'.$phone_user.'",
            		"date_created_user":"'.$date_created_user.'"

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


