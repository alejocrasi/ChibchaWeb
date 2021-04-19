<?php
include_once('../persistencia/db.php');
session_start();
$codv=$_POST['cod'];
$query = "SELECT e.cod_estudiante, e.nombre_completo, e.foto, e.correo_estudiante, p.nom_programa, d.estado FROM ESTUDIANTE e, PROGRAMA p, VACANTE v, DETALLE d WHERE e.cod_programa = p.cod_programa AND v.cod_vacante = d.cod_vacante AND e.cod_estudiante=d.cod_estudiante AND v.cod_empresa=".$_SESSION['id']." AND v.cod_vacante=".$codv;

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_estudiante,$nombre_completo,$foto,$correo_estudiante,$nom_programa,$estado);

$aspirants=array();
while($stmt -> fetch()) {
    $aspirant=array(
        "cod_estudiante"=>$cod_estudiante,
        "nombre_completo"=>$nombre_completo,
        "correo_estudiante"=>$correo_estudiante,
        "nom_programa"=>$nom_programa,
        "estado"=>$estado
    );
    array_push($aspirants,$aspirant);
}
$response=array();
if(count($aspirants)>0){
    $response = array(
        'aspirants' => $aspirants,
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
