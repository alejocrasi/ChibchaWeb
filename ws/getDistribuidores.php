<?php
include_once('../persistencia/db.php');
$query = "SELECT cod_distribuidor,razon_social,NIT_distribuidor,categoria_distribuidor,correo_distribuidor,password_distribuidor,plan_pago_distribuidor FROM distribuidor";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_distribuidor,$razon_social,$NIT_distribuidor,$categoria_distribuidor,$correo_distribuidor,$password_distribuidor,$plan_pago_distribuidor);

$rta="";
$distribuidores=array();
while($stmt -> fetch()) {
    $aux=1;
    $distribuidor=array(
        "cod_distribuidor"=>$cod_distribuidor,
        "razon_social"=>$razon_social,
        "NIT_distribuidor"=>$NIT_distribuidor,
        "categoria_distribuidor"=>$categoria_distribuidor,
        "correo_distribuidor"=>$correo_distribuidor,
        "password_distribuidor"=>$password_distribuidor,
        "plan_pago_distribuidor"=>$plan_pago_distribuidor,

    );
    array_push($distribuidores,$distribuidor);
}
$response=array();
if(count($distribuidores)>0){
    $response = array(
        'distribuidores' => $distribuidores,
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
