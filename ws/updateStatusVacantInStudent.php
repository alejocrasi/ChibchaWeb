<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");
session_start();


require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

function enviarCorreoContrato($mailTo, $nombre,$cargo)
{
   $PHPmail=new PHPMailer();
   $PHPmail->CharSet = 'UTF-8';
   $PHPmail->IsSMTP();
   $PHPmail->Host       = 'smtp.gmail.com';
   $PHPmail->SMTPSecure = 'tls';

   $PHPmail->Port       = 587;
   $PHPmail->SMTPDebug  = 0;
   $PHPmail->SMTPAuth   = true;
   $PHPmail->Username   = 'practicas.uelbosque@gmail.com';
   $PHPmail->Password   = 'PracticasUEB123';
   $PHPmail->SetFrom('practicas.uelbosque@gmail.com', "Practicas UEB");

   $PHPmail->AddEmbeddedImage('../assets/images/logos/logoMail.png', 'logoMail');
   $PHPmail->AddEmbeddedImage('../assets/images/logos/footer.png', 'logofooter');
   $PHPmail->Subject    = 'Un estudiante ha aceptado una vacante';
   $PHPmail->MsgHTML('
           <div style="background-color: rgba(222,222,222,0.6); margin-left: 15%; margin-right: 15%;">
            <div style=" margin-left: 5%; margin-right: 5%; padding-top: 5%; padding-bottom: 5%;">
                <div style="background-color: rgba(255,255,255);">
                    <div style="text-align: center;">
                        <img src=\'cid:logoMail\' alt="Universidad El Bosque" style=" max-width: 100%; max-height: 100%;
                        pointer-events: none;
                        cursor: default;">
                    </div>
                    <div style="margin-left: 10%; margin-right: 10%;"><br><br>
                        <p>Te informamos que un estudiante ha aceptado la oferta en la vacante '.$cargo.'</p>
                        <br><br>
                    </div>
                    <br><br><br><br>
                    <center>
                        <img src=\'cid:logofooter\' alt="footer" style=" max-width: 100%; max-height: 100%;  "></center>
                </div>
            </div>
            </div>
           ');

   $PHPmail->AddAddress($mailTo, $nombre);
   $PHPmail->Send();
  
}


function enviarCorreoRechazo($mailTo,$nombre,$cargo)
{
   $PHPmail=new PHPMailer();
   $PHPmail->CharSet = 'UTF-8';
   $PHPmail->IsSMTP();
   $PHPmail->Host       = 'smtp.gmail.com';
   $PHPmail->SMTPSecure = 'tls';

   $PHPmail->Port       = 587;
   $PHPmail->SMTPDebug  = 0;
   $PHPmail->SMTPAuth   = true;
   $PHPmail->Username   = 'practicas.uelbosque@gmail.com';
   $PHPmail->Password   = 'PracticasUEB123';
   $PHPmail->SetFrom('practicas.uelbosque@gmail.com', "Practicas UEB");

   $PHPmail->AddEmbeddedImage('../assets/images/logos/logoMail.png', 'logoMail');
   $PHPmail->AddEmbeddedImage('../assets/images/logos/footer.png', 'logofooter');
   $PHPmail->Subject    = 'Un estudiante ha rechazado una vacante';
   $PHPmail->MsgHTML('
           <div style="background-color: rgba(222,222,222,0.6); margin-left: 15%; margin-right: 15%;">
            <div style=" margin-left: 5%; margin-right: 5%; padding-top: 5%; padding-bottom: 5%;">
                <div style="background-color: rgba(255,255,255);">
                    <div style="text-align: center;">
                        <img src=\'cid:logoMail\' alt="Universidad El Bosque" style=" max-width: 100%; max-height: 100%;
                        pointer-events: none;
                        cursor: default;">
                    </div>
                    <div style="margin-left: 10%; margin-right: 10%;"><br><br>
                        <p>Lamentamos informarte que un estudiante ha rechazado la oferta en la vacante '.$cargo.'.</p>
                        <br><br>
                    </div>
                    <br><br><br><br>
                    <center>
                        <img src=\'cid:logofooter\' alt="footer" style=" max-width: 100%; max-height: 100%;  "></center>
                </div>
            </div>
            </div>
           ');

   $PHPmail->AddAddress($mailTo, $nombre);
   $PHPmail->Send();
  
}

$fecha = date('Y-m-d H:i:s');


$e=$_POST['cod_estudiante'];
$c=$_POST['cod_vacante'];
$est=$_POST['estado'];


$nomEstu="";
$cargo="";
$correo="";

$sql = "SELECT EMPRESA.correo_empresa, EMPRESA.nombre, VACANTE.nombre_cargo FROM EMPRESA, VACANTE WHERE EMPRESA.cod_empresa = VACANTE.cod_empresa AND VACANTE.cod_vacante = ".$c;
$r=$mysqli3->query($sql);
if ($row=$r-> fetch_assoc()) {
    $nombre=$row["nombre"];
    $correo=$row["correo_empresa"];
    $cargo=$row["nombre_cargo"];
}

$mysqli3->close();
if($est=="RECHAZADA"){
    enviarCorreoRechazo($correo,$nomEstu,$cargo);
            
}
if($est=="ACEPTADA"){
    enviarCorreoContrato($correo,$nomEstu,$cargo);
}


$response = [];
if($est=='ACEPTADA'){
    $sql = "UPDATE DETALLE SET estado='RECHAZADA' WHERE cod_estudiante=".$e.";";  
    $mysqli->query($sql);
    $update="UPDATE ESTUDIANTE SET estado='CONTRATADO' WHERE cod_estudiante=".$_SESSION['id'];
    $mysqli2->query($update);
    $_SESSION['estado']='CONTRATADO'; 
}
$sql2 = "UPDATE DETALLE SET estado='".$est."' WHERE cod_vacante=".$c." AND cod_estudiante=".$e;
if (!$mysqli2->query($sql2)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
    
    $response = array(
    'comment' => "Se agregó satisfactoriamente",
    'status' => 1
    );
    
}

$mysqli->close();
$mysqli2->close();

echo json_encode($response);

?>
