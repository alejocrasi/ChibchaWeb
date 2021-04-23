<?php
include_once('../persistencia/db.php');
$query = "SELECT cod_empleado , nom_empleado , correo_empleado , password_empleado FROM empleado";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_empleado,$nom_empleado,$correo_empleado,$password_empleado);

$rta="";
$empleados=array();
while($stmt -> fetch()) {
    $aux=1;
    $company=array(
        "cod_empleado"=>$cod_empleado,
        "nom_empleado"=>$nom_empleado,
        "correo_empleado"=>$correo_empleado,
        "password_empleado"=>$password_empleado,
    );
    array_push($empleados,$empleado);
}
$response=array();
if(count($empleados)>0){
    $response = array(
        'empleado' => $empleados,
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
