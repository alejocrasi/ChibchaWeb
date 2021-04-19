<?php
include_once('../persistencia/db.php');
session_start();

$query = "SELECT d.cod_estudiante, v.cod_vacante, v.nombre_cargo, v.descripcion_vacante, v.educacion_base, v.horario_disponibilidad, v.rango_salarial, v.estado, v.cantidad_vacantes, v.fecha_vacante, v.cod_empresa, d.estado, d.fecha_detalle, e.logo, e.nombre FROM VACANTE v, DETALLE d, EMPRESA e WHERE v.cod_vacante = d.cod_vacante AND v.cod_empresa=e.cod_empresa AND d.cod_estudiante = ".$_SESSION['id'];

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_estudiante,$cod_vacante,$nombre_cargo,$descripcion_vacante,$educacion_base,$horario_disponibilidad,$rango_salarial,$estado,$cantidad_vacantes,$fecha_vacante,$cod_empresa,$estadoDetalle,$fecha_detalle,$logo,$empresa);

$rta="";
$vacants=array();
while($stmt -> fetch()) {
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
        "cantidad_vacantes"=>$cantidad_vacantes,
        "estado_detalle"=>$estadoDetalle,
        "fecha_detalle"=>$fecha_detalle,
        "cod_estudiante"=>$cod_estudiante,
        "cod_vacante"=>$cod_vacante,
        "logo"=>$logo,
        "empresa"=>$empresa
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


