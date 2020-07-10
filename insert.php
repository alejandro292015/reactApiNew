<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Type: application/json; charset-UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require 'config.php';
$db_connection = new Database();
$conn = $db_connection -> dbConnection();

$data = json_decode(file_get_contents("php://input"));

$msg['message'] = '' ;


if(isset($data->nombre) && isset($data->apellido) && isset($data->identificacion) && isset($data->correo)){

    if(!empty($data->nombre) && !empty($data->apellido) && !empty($data->identificacion) && !empty($data->correo)){
        $insert_query ="INSERT INTO `estudiante`(nombre,apellido,identificacion,correo)
        VALUES(:nombre,:apellido,:identificacion,:correo)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bindValue(':nombre',htmlspecialchars(strip_tags($data->nombre)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':apellido', htmlspecialchars(strip_tags($data->apellido)), PDO::PARAM_STR);
        $insert_stmt->bindValue(':identificacion', htmlspecialchars(strip_tags($data->identificacion)), PDO::PARAM_STR);
        $insert_stmt->bindValue(':correo', htmlspecialchars(strip_tags($data->correo)), PDO::PARAM_STR);


        if($insert_stmt->execute()) {
            $msg['mesagge']= 'Datos Insertados Correctamente';
        }else{
            $msg['mesagge']= 'Datos no Insertados ';

        }


    }else {
        $msg['mesagge']= 'Oops! hay un campo desocupado. Porfavor digilenciar todos los campos';
    }

    echo json_encode($msg);
    exit()

}
?>