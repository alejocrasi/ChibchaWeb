<?php
include_once('../persistencia/db.php');
$query = "SELECT nom_programa, COUNT(*) as num_estu FROM ESTUDIANTE, PROGRAMA WHERE ESTUDIANTE.cod_programa = PROGRAMA.cod_programa GROUP BY nom_programa";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($nom_programa,$num_estu);

$rta="";
$estudiantes=array();
while($stmt -> fetch()) {
    $aux=1;
    $estudiante=array(
        "nom_programa" => $nom_programa,
        "num_estu"=>$num_estu,
        
    );
    array_push($estudiantes,$estudiante);
}
$response=array();
if(count($estudiantes)>0){
    $response = array(
        'estudiantes' => $estudiantes,
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
