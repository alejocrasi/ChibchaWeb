<?php
include_once('../persistencia/db.php');
$query = "SELECT URL_dominio,ip_dominio,correo_cliente,NIT_distribuidor FROM dominio";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($URL_dominio,$ip_dominio,$correo_cliente,$NIT_distribuidor);

$rta="";
$dominos=array();
while($stmt -> fetch()) {
    $aux=1;
    $dominio=array(
        "URL_dominio"=>$URL_dominio,
        "ip_dominio"=>$ip_dominio,
        "correo_cliente"=>$correo_cliente,
        "NIT_distribuidor"=>$NIT_distribuidor
    );
    array_push($dominos,$dominio);
}
$response=array();
if(count($dominos)>0){
    $response = array(
        'dominios' => $dominos,
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