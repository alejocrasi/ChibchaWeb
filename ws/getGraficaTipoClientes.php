<?php
include_once('../persistencia/db.php');
$query = "SELECT `tipo_membresia`, COUNT(*) as num_tipo FROM cliente GROUP BY `tipo_membresia`;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($tipo_membresia, $num_tipo);


$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "tipo_membresia"=>$tipo_membresia,
        "num_tipo"=>$num_tipo,

    );
    array_push($usuarios,$usuario);
}

$response=array();
if(count($usuarios)>0){
    $response = array(
        'clientes' => $usuarios,
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