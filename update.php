<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Access-Type: application/json; charset-UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection ->dbConnection();
$data = json_decode(file_get_contents("php://input"));
if(isset($data->id)){
    $msg ['mesagge'] = '';
    $post_id = $data->id;

    $get_post = "SELECT * FROM `estudiante` WHERE id=:post_id";
    $get_stmt = $conn->prepare($get_post);
    $get_stmt -> bindValue(':post_id',$post_id, PDO::PARAM_INT);
    $get_stmt ->execute();

if($get_stmt->rowCount() > 0) {
    
    $row = $get_stmt->fetch (PDO::FETCH_ASSOC);
        
    $post_nombre = isset($data->nombre) ? $data->nombre : $row['nombre'];
    $post_apellido=  isset($data->apellido) ? $data->apellido :$row['apellido'];
    $post_identificacion = isset($data->identificacion) ? $data->identificacion : $row['identificacion'];
    $post_correo = isset($data->correo) ? $data->correo : $row['correo'];
    $update_query = "UPDATE `estudiante` SET nombre=:nombre, apellido=:apellido, identificacion=:identificacion, correo=:correo WHERE id =:id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindValue(':nombre', htmlspecialchars(strip_tags($post_nombre),PDO::PARAM_STR));
    $update_stmt->bindValue(':apellido' , htmlspecialchars(strip_tags($post_apellido)),PDO::PARAM_STR);
    $update_stmt->bindValue(':identificacion' , htmlspecialchars(strip_tags($post_identificacion)),PDO::PARAM_STR);
    $update_stmt->bindValue(':correo' , htmlspecialchars(strip_tags($post_correo)),PDO::PARAM_STR);
    $update_stmt->bindValue(':id',PDO::PARAM_INT);

    if($update_stmt->execute()){
        $msg['mesagge']="Datos Actualizados";
    }else{
        $msg['mesagge']="Datos no Actualizados";

    }
}else{
    $msg['mesagge']="ID invalido";
    
}


echo json_encode($msg);
exit()

}


?>


