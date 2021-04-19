<?php
include_once('../persistencia/db.php');
$query = "SELECT password from ADMINISTRADOR WHERE id=1;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($password);

$rta="";
$passes=array();
while($stmt -> fetch()) {
    $aux=1;
    $pass=array(
        "password"=>$password
    );
    array_push($passes,$pass);
}
$response=array();
if(count($passes)>0){
    $response = array(
        'passes' => $passes,
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
