<?php
include_once('../persistencia/db.php');
session_start();
$query = "SELECT COUNT(VACANTE.cod_empresa) AS num_vacantes FROM VACANTE, EMPRESA WHERE EMPRESA.cod_empresa = VACANTE.cod_empresa AND  EMPRESA.cod_empresa = ".$_SESSION['id']." GROUP BY VACANTE.cod_empresa;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_vacantes);


$rta="";
$registros=array();
while($stmt -> fetch()) {
    $aux=1;
    $registro=array(
        "num_vacantes"=>$num_vacantes
        

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