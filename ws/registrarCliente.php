<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';
 require '../mailer/Exception.php';




$nom_cliente = $_POST["nom_cliente"];
$ape_cliente = $_POST["ape_cliente"];
$cc_cliente = $_POST["cc_cliente"];
$dir_cliente = $_POST["dir_cliente"];
$correo_cliente = $_POST["correo_cliente"];
$password_cliente = $_POST["pass"];
$tarjeta_credito = $_POST["tarjeta_credito"];
$tipo_membresia = $_POST["tipo_membresia"];
$plan_pago = $_POST["plan_pago"];

$response = [];
$sql = "INSERT INTO `cliente`(`cod_cliente`,`nom_cliente`, `ape_cliente`, `cc_cliente`, `dir_cliente`, `correo_cliente`, `password_cliente`, `tarjeta_credito`, `tipo_membresia`, `plan_pago`) 
        VALUES (0, '".$nom_cliente."' ,'".$ape_cliente."','".$cc_cliente."','".$dir_cliente."','".$correo_cliente."','".$password_cliente."','".$tarjeta_credito."','".$tipo_membresia."','".$plan_pago."')";
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
