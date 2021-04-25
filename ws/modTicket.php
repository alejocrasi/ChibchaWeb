<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../persistencia/db.php');

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';




$response = [];

$num_ticket = $_POST["num_ticket"];

$nivel_ticket = $_POST["nivel_ticket"];
$correo_cliente = $_POST["correo_cliente"];
$reclamo = $_POST["reclamo"];
$respuesta = $_POST["respuesta"];



$sql = "UPDATE ticket  SET  respuesta='".$respuesta."' 
        WHERE num_ticket = '".$num_ticket."';";



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
    $response = array(
        'comment' => "Se Actualizo satisfactoriamente ".$sql." " ,
        'status' => 1
    );
  
     
}

$mysqli->close();

echo json_encode($response);

?>