<?php
include_once('../persistencia/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Bogota");

$id = $_POST["codigo"];

$query = "SELECT e.cod_estudiante, e.nombre_completo, e.correo_estudiante, e.numero_solicitudes, p.nom_programa, e.semestre,e.estado, e.cod_HV from ESTUDIANTE e, PROGRAMA p where e.cod_estudiante = $id  and e.cod_programa = p.cod_programa";
$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($id,$nombre,$correo,$numero_solicitudes,$programa,$semestre,$estado,$cod_hv);

$aux=0;
$response = [];

while ($stmt -> fetch()) {
    session_start();
    $aux=1;
    $_SESSION['id']=$id;
    $_SESSION['nombre']=$nombre;
    $_SESSION['correo']=$correo;
    $_SESSION['numero_solicitudes']=$numero_solicitudes;
    $_SESSION['programa']=$programa;
    $_SESSION['semestre']=$semestre;
    $_SESSION['estado']=$estado;
    $_SESSION['cod_hv']=$cod_hv;
    $_SESSION['foto']= 'default-user-image.png';

    $primer_nombre=explode(' ', $nombre);

    $sql="CALL p_update_login(".$id.",1)";
    $mysqli2->query($sql);
    $mysqli2->close();
   
    $response = array(
    'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
    'status' => 1
    );
}

$stmt->close();
if($aux==0){
    $response = array(
        'html' => "error",
        'comment' => 'No se encuentran registradas las credenciales en el sistema',
        'status' => 0
    );
}
echo json_encode($response);

?>