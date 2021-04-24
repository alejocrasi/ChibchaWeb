<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../persistencia/db.php');

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';


function removeAccents($input){
    $output = "";
    $output = str_replace("á", "a", $input);
    $output = str_replace("é", "e", $output);
    $output = str_replace("í", "i", $output);
    $output = str_replace("ï", "i", $output);
    $output = str_replace("ì", "i", $output);
    $output = str_replace("ó", "o", $output);
    $output = str_replace("ú", "u", $output);
    $output = str_replace("ñ", "n", $output);
    $output = str_replace("Á", "a", $output);
    $output = str_replace("É", "e", $output);
    $output = str_replace("Í", "i", $output);
    $output = str_replace("Ó", "o", $output);
    $output = str_replace("Ú", "u", $output);
    $output = str_replace("Ñ", "n", $output);
    $output = str_replace("ü", "u", $output);
    return $output;
}

$response = [];

$nom_empleado= $_POST["nombre"];
$correo_empleado= $_POST["correo"];
$password_empleado= $_POST["password"];

$sql = "UPDATE empleado  SET  nom_empleado='".$nom_empleado."', correo_empleado='".$correo_empleado."' , password_empleado='".$password_empleado."' WHERE correo_empleado = '".$correo_empleado."' ;";
$_SESSION['nom_empleado']=$nom_empleado;
$_SESSION['correo_empleado']=$correo_empleado;
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
        'comment' => "Se Actualizo satisfactoriamente",
        'status' => 1
    );
  
     
}

$mysqli->close();

echo json_encode($response);

?>