<?php

/*=============================================
CORS
=============================================*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');

//validar si viene clave secreta
error_log("En views/img/index.php:::");
error_log('comprobando autorización::');
/**********
 * BORRAR ARCHIVO EN EL SERVIDOR
 */
if(isset($_POST['deleteFile'])){
   error_log('valor de deleteFile::');
   error_log($_POST['deleteFile']);
   //error_log($_SERVER['DOCUMENT_ROOT']);
   //borrando archivo
    unlink($_POST['deleteFile']);
    $str = $_POST['deleteFile'];
    $res = explode("/",$str);
    error_log(json_encode($res));
   //error_log("Ahora el array queda".json_encode($arrayDelete));
   //borrando directorio
    
   echo rmdir($res[0]."/".$res[1])?"ok":"";
   return;
}

if(!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != 'c5LTA6WPbMwHhEabYu77nN9cn4VcMj'){
    echo 'error';
    return ;
}
error_log('si');

//validar que sea imagen
if($_POST["type"] != "image/jpeg" && $_POST["type"] != "image/png" && $_POST["type"] != "image/gif"){
   error_log('Error en imagen');
   echo 'error';
   return;
}

if(isset($_POST["file"]) && !empty($_POST["file"])){ 

    /*=============================================
    Configuramos la ruta del directorio donde se guardará la imagen
    =============================================*/
    error_log('Creamos ruta directorio');
    $directory = strtolower($_POST["folder"]);
    
    /*=============================================
    Preguntamos primero si no existe el directorio, para crearlo
    =============================================*/
    error_log($directory);
    if(!file_exists($directory)){
        error_log('Creamos directorio::'.$directory);
        mkdir($directory, 0755);

    }

    /*=============================================
    Eliminar todos los archivos que existan en ese directorio
    =============================================*/
    /*
    if($folder != "img/products" && $folder != "img/stores"){

        $files = glob($directory."/*");

        foreach ($files as $file) {
            
            unlink($file);
        }

    }*/
    
    /*=============================================
    Capturar ancho y alto original de la imagen
    =============================================*/

    list($lastWidth, $lastHeight) = getimagesize($_POST["file"]);

    /*=============================================
    De acuerdo al tipo de imagen aplicamos las funciones por defecto
    =============================================*/

    if($_POST["type"] == "image/jpeg"){  //tipo jpeg

        //definimos nombre del archivo
        $newName  = $_POST["name"].'.jpg';

        //definimos el destino donde queremos guardar el archivo
        $folderPath = $directory.'/'.$newName;
        error_log("Destino almacenar::".$folderPath);

        if(isset($_POST["mode"]) && $_POST["mode"] == "base64"){

            file_put_contents($folderPath, file_get_contents($_POST["file"]));

        }else{

            //Crear una copia de la imagen
            $start = imagecreatefromjpeg($_POST["file"]);

            //Instrucciones para aplicar a la imagen definitiva crea la imagen con el tamaño definido.
            $end = imagecreatetruecolor($_POST["width"],$_POST["height"]);

            imagecopyresized($end, $start, 0, 0, 0, 0, $_POST["width"],$_POST["height"], $lastWidth, $lastHeight);

            imagejpeg($end, $folderPath);

        }

    }

    if($_POST["type"] == "image/png"){ //tipo png

        //definimos nombre del archivo
        $newName  = $_POST["name"].'.png';

        //definimos el destino donde queremos guardar el archivo
        $folderPath = $directory.'/'.$newName;

        if(isset($_POST["mode"]) && $_POST["mode"] == "base64"){

            file_put_contents($folderPath, file_get_contents($_POST["file"]));

        }else{

            //Crear una copia de la imagen
            $start = imagecreatefrompng($_POST["file"]);

            //Instrucciones para aplicar a la imagen definitiva
            $end = imagecreatetruecolor($_POST["width"], $_POST["height"]);

            imagealphablending($end, FALSE);
            
            imagesavealpha($end, TRUE);	

            imagecopyresampled($end, $start, 0, 0, 0, 0, $_POST["width"],$_POST["height"], $lastWidth, $lastHeight);

            imagepng($end, $folderPath);

        }

    }

    if($_POST["type"] == "image/gif"){ //tipo png
        error_log("Es::".$_POST["type"]);
        //definimos nombre del archivo
        $newName  = $_POST["name"].'.gif';

        //definimos el destino donde queremos guardar el archivo
        $folderPath = $directory.'/'.$newName;
        error_log("Se almacena en::".$folderPath);
        error_log("Se file es::".json_encode($_POST["file"]));
        copy($_POST["file"],$folderPath);
    }
    error_log("newName::".$newName);
    echo $newName;

}else{

    echo "error";

}
