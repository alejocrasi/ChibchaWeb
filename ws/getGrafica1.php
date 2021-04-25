<?php
include_once('../persistencia/db.php');
$query = "SELECT ((SELECT count(num_ticket) FROM ticket WHERE respuesta=='')) AS num_tickets_resueltos, ((SELECT count(num_ticket) FROM ticket WHERE respuesta!='')) as num_tickets_pendientes;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_estudiantes, $num_empresas, $num_vacantes);


$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "num_estudiantes"=>$num_estudiantes,
        "num_empresas"=>$num_empresas,
        "num_vacantes"=>$num_vacantes       

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