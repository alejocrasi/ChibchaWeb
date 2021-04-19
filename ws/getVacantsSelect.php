<?php
include_once('../persistencia/db.php');
session_start();
$query = "SELECT cod_vacante, nombre_cargo from VACANTE WHERE cod_empresa=".$_SESSION['id'];

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod,$nom);

$rta="";
$programs=array();
while($stmt -> fetch()) {
    $aux=1;
    $program=array(
        "cod_programa"=>$cod,
        "nom_programa"=>$nom
    );
    array_push($programs,$program);
}
$response=array();
if(count($programs)>0){
    $response = array(
        'vacants' => $programs,
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