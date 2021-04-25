<?php
include_once('../persistencia/db.php');
$query = "SELECT ((SELECT count(num_ticket) FROM ticket WHERE respuesta='')) AS num_tickets_pendientes, ((SELECT count(num_ticket) FROM ticket WHERE respuesta!='')) as num_tickets_resueltos;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_tickets_resueltos, $num_tickets_pendientes);


$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "num_tickets_resueltos"=>$num_tickets_resueltos,
        "num_tickets_pendientes"=>$num_tickets_pendientes,

    );
    array_push($usuarios,$usuario);
}

$response=array();
if(count($usuarios)>0){
    $response = array(
        'tickets' => $usuarios,
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