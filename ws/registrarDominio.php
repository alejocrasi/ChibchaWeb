<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';
 require '../mailer/Exception.php';




$URL_dominio = $_POST["URL_dominio"];
$ip_dominio = $_POST["ip_dominio"];
$correo_cliente = $_POST["correo_cliente"];
$NIT_distribuidor = $_POST["NIT_distribuidor"];


$response = [];
$sql = "INSERT INTO `cliente`(`URL_dominio`,`ip_dominio`, `correo_cliente`, `NIT_distribuidor`) 
        VALUES ('".$URL_dominio."' ,'".$ip_dominio."','".$correo_cliente."','".$NIT_distribuidor."')";
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
    $query='SELECT cod_cliente from cliente where correo_cliente ="'.$_POST['correo_cliente'].'"';
    $r=$mysqli->query($query);
    if ($row=$r-> fetch_assoc()) {
        $id=$row["cod_cliente"];

        $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
        );
        
        
    }
}
$mysqli->close();

echo json_encode($response);

?>