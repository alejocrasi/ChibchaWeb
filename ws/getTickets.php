<?php
include_once('../persistencia/db.php');
$query = "SELECT `num_ticket`, `URL_pagina`, `nivel_ticket`, `correo_cliente`, `reclamo`, `respuesta`   FROM `ticket`";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_ticket,$URL_pagina,$nivel_ticket,$correo_cliente,$reclamo,$respuesta);

$rta="";
$tickets=array();
while($stmt -> fetch()) {
    $aux=1;
    $ticket=array(
        "num_ticket"=>$num_ticket,
        "URL_pagina"=>$URL_pagina,
        "nivel_ticket"=>$nivel_ticket,
        "correo_cliente"=>$correo_cliente,
        "reclamo"=>$reclamo,
        "respuesta"=>$respuesta,

    );
    array_push($tickets,$ticket);
}
$response=array();
if(count($tickets)>0){
    $response = array(
        'tickets' => $tickets,
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
