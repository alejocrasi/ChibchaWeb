<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';
 require '../mailer/Exception.php';





$razon_social = $_POST["razon_social"];
$NIT_distribuidor = $_POST["NIT_distribuidor"];
$categoria_distribuidor = $_POST["categoria_distribuidor"];
$correo_distribuidor = $_POST["correo_distribuidor"];
$password_distribuidor = $_POST["passCp"];
$plan_pago_distribuidor = $_POST["plan_pago_distribuidor"];


$response = [];
$sql = "INSERT INTO `cliente`(`cod_distribuidor`,`razon_social`, `NIT_distribuidor`, `categoria_distribuidor`, `password_distribuidor`, `plan_pago_distribuidor`) 
        VALUES (0 ,'".$razon_social."','".$NIT_distribuidor."','".$categoria_distribuidor."','".$password_distribuidor."','".$plan_pago_distribuidor."')";
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
    $query='SELECT cod_distribuidor from distribuidor where NIT_distribuidor ="'.$_POST['NIT_distribuidor'].'"';
    $r=$mysqli->query($query);
    if ($row=$r-> fetch_assoc()) {
        $id=$row["NIT_distribuidor"];

        $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
        );
        
        
    }
}
$mysqli->close();

echo json_encode($response);

?>
