<?php
include_once('../persistencia/db.php');
$query = "SELECT cod_cliente,nom_cliente,ape_cliente,cc_cliente,dir_cliente,correo_cliente,password_cliente,tarjeta_credito,tipo_membresia,plan_pago FROM cliente";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_cliente,$nom_cliente,$ape_cliente,$cc_cliente,$dir_cliente,$correo_cliente,$password_cliente,$tarjeta_credito,$tipo_membresia,$plan_pago);

$rta="";
$clientes=array();
while($stmt -> fetch()) {
    $aux=1;
    $cliente=array(
        "cod_cliente"=>$cod_cliente,
        "nom_cliente"=>$nom_cliente,
        "ape_cliente"=>$ape_cliente,
        "cc_cliente"=>$cc_cliente,
        "dir_cliente"=>$dir_cliente,
        "correo_cliente"=>$correo_cliente,
        "password_cliente"=>$password_cliente,
        "tarjeta_credito"=>$tarjeta_credito,
        "tipo_membresia"=>$tipo_membresia,
        "plan_pago"=>$plan_pago,
    );
    array_push($clientes,$cliente);
}
$response=array();
if(count($clientes)>0){
    $response = array(
        'clientes' => $clientes,
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
