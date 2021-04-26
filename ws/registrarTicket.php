<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';
 require '../mailer/Exception.php';



$URL_dominio = $_POST["URL_dominio"];
$nivel_ticket = $_POST["nivel_ticket"];
$correo_cliente = $_POST["correo_cliente"];
$reclamo = $_POST["reclamo"];

$response = [];
$sql = "INSERT INTO `tickets`(`num_ticket`,`URL_dominio`, `nivel_ticket`, `correo_cliente`, `reclamo`, `respuesta`) 
        VALUES (0,'".$URL_dominio."' ,'".$nivel_ticket."','".$correo_cliente."','".$reclamo."','""')";
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
    $query='SELECT num_ticket from tickets where correo_cliente ="'.$_POST['correo_cliente'].'"';
    $r=$mysqli->query($query);
    if ($row=$r-> fetch_assoc()) {
        $id=$row["num_ticket"];

        $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
        );
        
        
    }
}
$mysqli->close();

echo json_encode($response);

?>
