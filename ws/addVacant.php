<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");
session_start();

$fecha = date('Y-m-d H:i:s');


$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$cantidad=$_POST['cantidad'];
$descripcion=$_POST['descripcion'];
$rangMin=$_POST['rang-min'];
$rangMax=$_POST['rang-max'];
$horario=$_POST['horario'];
$educacion=$_POST['educacion'];

$salario=$rangMin.'-'.$rangMax;

$response = [];
$sql = "CALL p_add_vacant('".$nombre."', '".$descripcion."', '".$educacion."', '".$horario."', '".$salario."',".$cantidad.",'".$fecha."',".$_SESSION['id'].")";
if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
    $response = array(
    'comment' => "Se agregó satisfactoriamente",
    'status' => 1
    );
}

$mysqli->close();

echo json_encode($response);

?>
