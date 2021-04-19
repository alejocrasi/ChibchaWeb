<?php
include_once('../persistencia/db.php');
$query = "SELECT nom_programa, COUNT(*) as aceptados FROM DETALLE, ESTUDIANTE, PROGRAMA WHERE DETALLE.estado='ACEPTADA' AND DETALLE.cod_estudiante= ESTUDIANTE.cod_estudiante AND ESTUDIANTE.cod_programa=PROGRAMA.cod_programa GROUP BY nom_programa;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($nom_programa, $aceptados);


$rta="";
$registros=array();
while($stmt -> fetch()) {
    $aux=1;
    $registro=array(
        "nom_programa"=>$nom_programa,
        "aceptados"=>$aceptados

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