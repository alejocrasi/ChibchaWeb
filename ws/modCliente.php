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

$cod_cliente  = $_POST["cod_cliente"];
$nom_cliente = $_POST["nom_cliente"];
$ape_cliente = $_POST["ape_cliente"];
$cc_cliente = $_POST["cc_cliente"];
$dir_cliente = $_POST["dir_cliente"];
$correo_cliente = $_POST["correo_cliente"];
$password_cliente = $_POST["password_cliente"];
$tarjeta_credito = $_POST["tarjeta_credito"];
$tipo_membresia = $_POST["tipo_membresia"];
$plan_pago = $_POST["plan_pago"];



$sql = "UPDATE cliente  SET  nom_cliente='".$nom_cliente."',  ape_cliente='".$ape_cliente."',
                             cc_cliente='".$cc_cliente."', dir_cliente='".$dir_cliente."' , correo_cliente='".$correo_cliente."',
                             password_cliente='".$password_cliente."', tarjeta_credito='".$tarjeta_credito."' ,
                             tipo_membresia='".$tipo_membresia."', plan_pago='".$plan_pago."' 
        WHERE cod_cliente = '".$cod_cliente."' ;";

        $_SESSION['cod_cliente']=$cod_cliente;
        $_SESSION['nom_cliente']=$nom_cliente;
        $_SESSION['ape_cliente']=$ape_cliente;
        $_SESSION['cc_cliente']=$cc_cliente;
        $_SESSION['dir_cliente']=$dir_cliente;
        $_SESSION['correo_cliente']=$correo_cliente;
        $_SESSION['password_cliente']=$password_cliente;
        $_SESSION['tarjeta_credito']=$tarjeta_credito;
        $_SESSION['tipo_membresia']=$tipo_membresia;
        $_SESSION['plan_pago']=$plan_pago;

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