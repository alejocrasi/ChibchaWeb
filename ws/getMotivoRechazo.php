<?php
include_once('../persistencia/db.php');
$query = "SELECT motivo, COUNT(cod_vacante) FROM DETALLE_RECHAZO, MOTIVOS_RECHAZO WHERE DETALLE_RECHAZO.cod_motivo = MOTIVOS_RECHAZO.cod_motivo GROUP BY(motivo);";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($motivo, $num_rechazos);


$rta="";
$registros=array();
while($stmt -> fetch()) {
    $aux=1;
    $registro=array(
        "motivo"=>$motivo,
        "num_rechazos"=>$num_rechazos

    );
    array_push($registros,$registro);
}

$response=array();
if(count($registros)>0){
    $response = array(
        'registros' => $registros,
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