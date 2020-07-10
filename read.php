<?php
// SET HEADER

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Type: application/json; charset-UTF-8");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection -> dbConnection();

if(isset($_GET['id'])){

    $post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
        'options' => [
         'default' => 'all:posts',
         'min_range' => 1
        ]
    ]);
}else{
    $post_id = 'all_posts';
}

$sql = is_numeric($post_id) ? " SELECT * FROM `estudiante` WHERE id='$post_id" : "SELECT * FROM `estudiante`";
$stmt = $conn ->prepare($sql);
$stmt -> execute();

if($stmt->rowCount() > 0){

    $estudiante_array = [];
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $post_data = [
            'id' =>  $row['id'],
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'identificacion' => $row['identificacion'],
            'correo' => $row['correo'],
        ];
        array_push ($estudiante_array,$post_data);
    }

    echo json_encode($estudiante_array);
}else{
    echo json_encode(['menssage'=>'Estudiante no encontrado']);
    exit()

}




?>
