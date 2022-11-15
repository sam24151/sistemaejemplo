<?php

error_log('en validadorimg.php ');

class Validacion{
   public static function validarimg($fiels){
    error_log("validarimg---------------------");
    //validar que exista archivo
    if(!isset($fiels['file']) && empty($fiels['file'])){ 
        error_log('no hay archivo');
        return "error";
    }
    //validar formato de imagen
    $formatos = ["image/jpeg","image/JPEG","image/jpg","image/png","image/gif"];  //formatos aceptados
    $mime = mime_content_type($fiels['file']);
    $ext = explode("/",$mime)[1];
    if(!in_array($mime,$formatos)){
        error_log("no hay extension");
        return "error"; 
    }
    error_log('La extesion es::'.$ext);
    //validar carpeta en donde se va almacenar
    $directory = strtolower($fiels["folder"]);
    if(!file_exists($directory)){
        error_log('Creamos directorio::'.$directory);
        if(mkdir($directory, 0755)){
            error_log('directorio creado');
        }else{
            error_log("error al crear directorio");
        }
    }
    //definimos nombre del archivo
    //para el nombre con fecha unix
    $unix = strtotime("now");
    $ran  = mt_rand(1,99);
    $newName  = $unix.$ran.".".$ext;
    
    //definimos el destino donde queremos guardar el archivo
    $folderPath = $directory.'/'.$newName;
    error_log("Destino almacenar::".$folderPath);
    error_log("File tiene".$fiels["file"]);
    if(isset($fiels["mode"]) && $fiels["mode"] == "base64"){
        error_log("es base64");
        file_put_contents($folderPath, file_get_contents($fiels["file"]));
        return $newName;
    }

    if(move_uploaded_file($fiels["file"],$folderPath)){
        error_log('almacenado');
        return $newName;
    }
    error_log("Error no almacenado::".$newName);
    return "error";
   }
}

//validar que sea imagen

/*

if($_POST["type"] != "image/jpeg" && $_POST["type"] != "image/png" && $_POST["type"] != "image/gif"){
   error_log('Error en imagen');
   echo 'error';
   return;
}

if(isset($_POST["file"]) && !empty($_POST["file"])){ 

    /*=============================================
    Configuramos la ruta del directorio donde se guardará la imagen
    =============================================*/
    /*
    error_log('Creamos ruta directorio');
    $directory = strtolower($_POST["folder"]);
    
    /*=============================================
    Preguntamos primero si no existe el directorio, para crearlo
    =============================================*/
    /*
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
/*
    list($lastWidth, $lastHeight) = getimagesize($_POST["file"]);

    /*=============================================
    De acuerdo al tipo de imagen aplicamos las funciones por defecto
    =============================================*/
/*
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
*/
