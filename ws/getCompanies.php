<?php
include_once('../persistencia/db.php');
$query = "SELECT NIT, nombre, password_empresa, correo_empresa, logo, descripcion_empresa, estado, num_ingresos, cc_empresa from EMPRESA";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($NIT,$nombre,$password,$correo,$logo,$descripcion,$estado,$num_ingresos,$cc);

$rta="";
$companies=array();
while($stmt -> fetch()) {
    $aux=1;
    $company=array(
        "NIT"=>$NIT,
        "nombre"=>$nombre,
        "password_empresa"=>$password,
        "correo_empresa"=>$correo,
        "logo"=>$logo,
        "descripcion_empresa"=>$descripcion,
        "estado"=>$estado,
        "num_ingresos"=>$num_ingresos,
        "cc_empresa"=>$cc
    );
    array_push($companies,$company);
}
$response=array();
if(count($companies)>0){
    $response = array(
        'companies' => $companies,
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
