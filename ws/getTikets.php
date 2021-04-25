<?php
include_once('../persistencia/db.php');
$query = "SELECT `num_ticket`, `nivel_ticket`, `correo_cliente`, `reclamo` FROM `tickets`";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_ticket,$nivel_ticket,$correo_cliente,$reclamo);

$rta="";
$tikets=array();
while($stmt -> fetch()) {
    $aux=1;
    $tiket=array(
        "num_ticket"=>$num_ticket,
        "nivel_ticket"=>$nivel_ticket,
        "correo_cliente"=>$correo_cliente,
        "reclamo"=>$reclamo,
    );
    array_push($tikets,$tiket);
}
$response=array();
if(count($tikets)>0){
    $response = array(
        'tikets' => $tikets,
        'status' => 1
    );
}else{
    $response = array(
        'html' => "error",
        'status' => 0
    );
}
$stmt->close();
echo json_encode($response);
?>
