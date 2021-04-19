<?php
include_once('../persistencia/db.php');
$query = "SELECT username, password from ADMINISTRADOR";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($nombre,$password);

$rta="";
$admins=array();
while($stmt -> fetch()) {
    $aux=1;
    $admin=array(
        "username"=>$nombre,
        "password"=>$password
    );
    array_push($admins,$admin);
}
$response=array();
if(count($admins)>0){
    $response = array(
        'admins' => $admins,
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