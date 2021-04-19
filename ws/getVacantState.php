<?php
include_once('../persistencia/db.php');
$query = "SELECT estado, COUNT(cod_vacante) as num_registros FROM DETALLE GROUP BY estado ;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_estudiantes, $num_empresas);


$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "num_estudiantes"=>$num_estudiantes,
        "num_empresas"=>$num_empresas

    );
    array_push($usuarios,$usuario);
}

$response=array();
if(count($usuarios)>0){
    $response = array(
        'usuarios' => $usuarios,
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