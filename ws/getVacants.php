<?php
include_once('../persistencia/db.php');
$query = "SELECT cod_vacante, nombre_cargo, descripcion_vacante, educacion_base, 
horario_disponibilidad, rango_salarial, VACANTE.estado, fecha_vacante, 
nombre, logo from VACANTE, EMPRESA
WHERE VACANTE.cod_empresa=EMPRESA.cod_empresa
GROUP BY cod_vacante;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_vacante, $nombre_cargo,$descripcion_vacante,$educacion_base,$horario_disponibilidad,$rango_salarial,
    $estado, $fecha_vacante, $nom_empresa, $logo);

$rta="";
$vacants=array();
while($stmt -> fetch()) {
    $aux=1;
    $vacant=array(
        "cod_vacante"=>$cod_vacante,
        "nombre_cargo"=>$nombre_cargo,
        "descripcion_vacante"=>$descripcion_vacante,
        "educacion_base"=>$educacion_base,
        "horario_disponibilidad"=>$horario_disponibilidad,
        "rango_salarial"=>$rango_salarial,
        "estado"=>$estado,
        "fecha_vacante"=>$fecha_vacante,
        "nom_empresa"=>$nom_empresa,
        "logo"=>$logo
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
