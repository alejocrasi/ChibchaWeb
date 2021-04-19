<?php
include_once('../persistencia/db.php');
session_start();
$query = "SELECT COUNT( DETALLE.cod_vacante) AS num_vacantes, DETALLE.estado as estado FROM DETALLE, EMPRESA, VACANTE 
WHERE EMPRESA.cod_empresa = VACANTE.cod_empresa AND VACANTE.cod_vacante = DETALLE.cod_vacante AND EMPRESA.cod_empresa =".$_SESSION['id']." GROUP BY DETALLE.estado;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_vacantes, $estado);


$rta="";
$registros=array();
while($stmt -> fetch()) {
    $aux=1;
    $registro=array(
        "num_vacantes"=>$num_vacantes,
        "estado"=>$estado

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