<?php
include_once('../persistencia/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Bogota");

$username = $_POST["username"];
$pass = $_POST["pass"];
$fecha = date('Y-m-d');
$aux= 0;
$response = [];

$query = "SELECT cod_cliente, c.nom_cliente, c.ape_cliente, c.cc_cliente, c.dir_cliente, c.correo_cliente, c.password_cliente, c.tarjeta_credito,c.tipo_membresia, c.plan_pago 
from cliente c where c.correo_cliente ='".$username."' and c.password_cliente='".$pass."'";
$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_cliente,$nom_cliente,$ape_cliente,
$cc_cliente,$dir_cliente,$correo_cliente,$password_cliente,$tarjeta_credito,
$tipo_membresia, $plan_pago );


while($stmt -> fetch()) {
    $aux=1;
        
        session_start();
        $_SESSION['cod_cliente']=$cod_cliente;
        $_SESSION['nom_cliente']=$nom_cliente;
        $_SESSION['ape_cliente']=$ape_cliente;
        $_SESSION['cc_cliente']=$cc_cliente;
        $_SESSION['dir_cliente']=$dir_cliente;
        $_SESSION['correo_cliente']=$correo_cliente;
        $_SESSION['password_cliente']=$password_cliente;
        $_SESSION['tarjeta_credito']=$tarjeta_credito;
        $_SESSION['tipo_membresia']=$tipo_membresia;
        $_SESSION['plan_pago']=$plan_pago;
        $_SESSION['redirect']='clienteHome.php';

        $primer_nombre=explode(' ',$nom_cliente);
        $response = array(
            'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
            'redirect' =>'clienteHome.php',
            'status' => true
        );
    
        $sql="CALL p_update_login(".$cod_cliente.",1)";
        $mysqli2->query($sql);
        $mysqli2->close();
        
    
    

    
    
    
}
$stmt->close();

if($aux==0){
    $query = "SELECT c.cod_distribuidor, c.razon_social, c.NIT_distribuidor, c.categoria_distribuidor, c.correo_distribuidor, c.password_distribuidor, c.plan_pago_distribuidor
    from distribuidor c where c.correo_distribuidor ='".$username."' and c.password_distribuidor='".$pass."'";
    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($cod_distribuidor,$razon_social,$NIT_distribuidor,$categoria_distribuidor,
    $correo_distribuidor,$password_distribuidor,$plan_pago_distribuidor);
    while($stmt -> fetch()) {
        $aux=1;
        
            session_start();
            $_SESSION['cod_distribuidor']=$cod_distribuidor;
            $_SESSION['razon_social']=$razon_social;
            $_SESSION['NIT_distribuidor']=$NIT_distribuidor;
            $_SESSION['categoria_distribuidor']=$categoria_distribuidor;
            $_SESSION['correo_distribuidor']=$correo_distribuidor;
            $_SESSION['password_distribuidor']=$password_distribuidor;
            $_SESSION['plan_pago_distribuidor']=$plan_pago_distribuidor;
            $_SESSION['redirect']='distribuidoresHome.php';
            $primer_nombre=explode(' ',$razon_social);
            $response = array(
                'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
                'redirect' =>'distribuidoresHome.php',
                'status' => true
            );
            $sql="CALL p_update_login(".$cod_distribuidor.",2)";
            $mysqli2->query($sql);
            $mysqli2->close();
        
    }
    $stmt->close();
}


if($aux==0){
    $query = "SELECT c.cod_empleado, c.nom_empleado, c.correo_empleado, c.password_empleado from empleado c where c.correo_empleado ='".$username."' and c.password_empleado='".$pass."'" ;
    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($cod_empleado,$nom_empleado,$correo_empleado,$password_empleado);
    while($stmt -> fetch()) {
        session_start();
        $aux=1;
        $_SESSION['cod_empleado']=$cod_empleado;
        $_SESSION['nom_empleado']=$nom_empleado;
        $_SESSION['correo_empleado']=$correo_empleado;
        $_SESSION['password_empleado']=$password_empleado;

        $_SESSION['redirect']='empleadoHome.php';
        $primer_nombre=explode(' ',$nom_empleado);
        $response = array(
            'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
            'redirect' =>'empleadoHome.php',
            'status' => true
        );
    }
    $stmt->close();
}
if($aux==0){
    $response = array(
        'comment' => 'No se encuentran registradas las credenciales en el sistema',
        'redirect' => '',
        'status' => false
    );
}
echo json_encode($response);

?>