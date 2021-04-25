<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';
 require '../mailer/Exception.php';




$cod_empleado = $_POST["cod_empleado"];
$nom_empleado = $_POST["nom_empleado"];
$correo_empleado = $_POST["correo_empleado"];
$password_empleado = $_POST["password_empleado"];


$response = [];
$sql = "INSERT INTO `empleado`(`cod_empleado`,`nom_empleado`, `correo_empleado`, `password_empleado`) 
        VALUES ('".$cod_empleado."' ,'".$nom_empleado."','".$correo_empleado."','".$password_empleado."' )";
if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
    $query='SELECT cod_empleado from empleado where correo_empleado ="'.$_POST['correo_empleado'].'"';
    $r=$mysqli->query($query);
    if ($row=$r-> fetch_assoc()) {
        $id=$row["cod_empleado"];

        $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
        );
        
        
    }
}
$mysqli->close();

echo json_encode($response);

?>
