<?php

class LoginModel{
    static public function getData($fields){
        $email_user = $fields["email_user"];
        $password_user = $fields["password_user"];
        $crypt = crypt($password_user, '$2a$07$azybxcags23425sdg23sdfhsd$');
        $sql = "SELECT * FROM users where password_user='".$crypt."'
          AND email_user = '".$email_user."'";
		$stmt = Connectionn::connect()->prepare($sql);
		try{

			$stmt -> execute();

		}catch(PDOException $Exception){

			return null;
		
		}

        $re = $stmt -> fetchAll(PDO::FETCH_CLASS);
        if(count($re) == 0){
            return json_encode([
                "status" =>  404,
                "results" => "Error en Email o Password", 
            ]);
        }else{
        error_log("AQUI TENEMOS EL JSON DE LOGIN:::::::");
            error_log(json_encode($re));
            return json_encode([
                "status" =>  200,
                "results" => $re, 
            ]);
        }
    }
}

?>