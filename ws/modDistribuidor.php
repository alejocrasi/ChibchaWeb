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

$razon_social= $_POST["razon_social"];
$NIT_distribuidor= $_POST["NIT_distribuidor"];
$categoria_distribuidor= $_POST["categoria_distribuidor"];
$correo_distribuidor= $_POST["correo_distribuidor"];
$password_distribuidor= $_POST["password_distribuidor"];
$plan_pago_distribuidor= $_POST["plan_pago_distribuidor"];



$sql = "UPDATE distribuidor  SET  razon_social='".$razon_social."',  categoria_distribuidor='".$categoria_distribuidor."',
                                  correo_distribuidor='".$correo_distribuidor."', password_distribuidor='".$password_distribuidor."' , plan_pago_distribuidor='".$plan_pago_distribuidor."'
        WHERE NIT_distribuidor = '".$NIT_distribuidor."' ;";

$_SESSION['razon_social']=$razon_social;
$_SESSION['NIT_distribuidor']=$NIT_distribuidor;
$_SESSION['categoria_distribuidor']=$categoria_distribuidor;
$_SESSION['correo_distribuidor']=$correo_distribuidor;
$_SESSION['password_distribuidor']=$password_distribuidor;
$_SESSION['plan_pago_distribuidor']=$plan_pago_distribuidor;

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