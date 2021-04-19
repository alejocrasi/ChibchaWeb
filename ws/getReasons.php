<?php
include_once('../persistencia/db.php');
$query = "SELECT cod_motivo, motivo from MOTIVOS_RECHAZO";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod,$mot);

$rta="";
$motivos=array();
while($stmt -> fetch()) {
    $aux=1;
    $motivo=array(
        "cod_motivo"=>$cod,
        "motivo"=>$mot
    );
    array_push($motivos,$motivo);
}
$response=array();
if(count($motivos)>0){
    $response = array(
        'reasons' => $motivos,
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