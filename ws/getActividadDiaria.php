<?php
include_once('../persistencia/db.php');
$query = "SELECT fecha_detalle, COUNT(cod_vacante) as num_registros FROM DETALLE GROUP BY fecha_detalle  ;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($fecha_detalle, $num_registros);


$rta="";
$registros=array();
while($stmt -> fetch()) {
    $aux=1;
    $registro=array(
        "fecha_detalle"=>$fecha_detalle,
        "num_registros"=>$num_registros

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