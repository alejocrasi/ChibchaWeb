<?php
include_once('../persistencia/db.php');
session_start();
$query = "SELECT * from VACANTE where cod_empresa=".$_SESSION['id'];

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_vacante,$nombre_cargo,$descripcion_vacante,$educacion_base,$horario_disponibilidad,$rango_salarial,$estado,$cantidad_vacantes,$fecha_vacante,$cod_empresa);

$rta="";
$vacants=array();
while($stmt -> fetch()) {
    $queryAux = "SELECT COUNT(cod_vacante) as aspirantes FROM DETALLE WHERE estado='APROBADA' and cod_vacante=".$cod_vacante;

    $stmt2 = $mysqli2->prepare($queryAux);
    $stmt2 -> execute();
    $stmt2 -> bind_result($aspirantes);
    $rta=0;
    while($stmt2 -> fetch()) {
        $rta=$aspirantes;
    }
    $stmt2->close();

    $rta=$cantidad_vacantes-$rta;
    $aux=1;
    $vacant=array(
        "nombre_cargo"=>$nombre_cargo,
        "descripcion_vacante"=>$descripcion_vacante,
        "educacion_base"=>$educacion_base,
        "horario_disponibilidad"=>$horario_disponibilidad,
        "rango_salarial"=>$rango_salarial,
        "estado"=>$estado,
        "fecha_vacante"=>$fecha_vacante,
        "cod_empresa"=>$cod_empresa,
        "cantidad_vacantes"=>$rta
    );
    array_push($vacants,$vacant);
}
$response=array();
if(count($vacants)>0){
    $response = array(
        'vacants' => $vacants,
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
