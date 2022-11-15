<?php

//require_once "models/connection.php";
//require_once "controllers/get.controller.php";

class Routes{
    static public function getDataApi($method, $url, $tabla,$fielss){
        error_log('La url es::'.$url);
        $routesArray = explode("/", $url);
        $routesArray = array_filter($routesArray);

        /*=============================================
        Cuando no se hace ninguna petición a la API
        =============================================*/
        /*
        if(false){
            error_log('La url tiene algo 404');
            $json = array(

                'status' => 404,
                'results' => 'Not Found'

            );


            return json_encode($json);

        }

        /*=============================================
        Cuando si se hace una petición a la API
        =============================================*/

       // if(count($routesArray) == 2 && isset($method)){
            //obtenemos los parametros & de url;
            $table = $tabla;//explode("?", $routesArray[2])[0];
            //error_log("La tabla obtenida de la url::".json_encode($table));
            /*=============================================
            Validar llave secreta
            =============================================*/
            /*
            if(!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != Connection::apikey()){

                if(in_array($table, Connection::publicAccess()) == 0){
            
                    $json = array(
                
                        'status' => 400,
                        "results" => "You are not authorized to make this request"
                    );

                    echo json_encode($json, http_response_code($json["status"]));

                    return;

                }else{

                    /*=============================================
                    Acceso público
                    =============================================*//*
                    $response = new GetController();
                    $response -> getData($table, "*",null,null,null,null);

                    return;
                }
            
            }

            /*=============================================
            Peticiones GET
            =============================================*/

            if($method == "GET"){

                include "services/get.php";
                error_log("TTTTTTTTTT.".json_encode($n));
                return json_encode($n);
            }

            /*=============================================
            Peticiones POST
            =============================================*/

            if($method == "POST"){

                include "services/post.php";

            }

            /*=============================================
            Peticiones PUT
            =============================================*/

            if($method == "PUT"){

                include "services/put.php";

            }

            /*=============================================
            Peticiones DELETE
            =============================================*/

            if($method == "DELETE"){

                include "services/delete.php";

            }

        }

    //}
}


