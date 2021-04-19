<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

session_start();




function enviarCorreoContrato($mailTo, $nombre,$cargo,$nomE)
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
   $PHPmail->Subject    = 'Un nuevo estudiante ha aplicado a una vacante';
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
                        <p>El estudiante '.$nomE.' ha aplicado a la vacante '.$cargo.'</p>
                        <p>Para mas detalles por favor revisar su perfil en la pagina principal.</p><br><br><br>
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



$cod=$_POST['cod'];

$nomEstu="";
$cargo="";
$correo="";

$sql = "SELECT EMPRESA.correo_empresa, EMPRESA.nombre, VACANTE.nombre_cargo FROM EMPRESA, VACANTE WHERE EMPRESA.cod_empresa = VACANTE.cod_empresa AND VACANTE.cod_vacante = ".$cod;
$r=$mysqli3->query($sql);
if ($row=$r-> fetch_assoc()) {
    $nomEstu=$row["nombre"];
    $correo=$row["correo_empresa"];
    $cargo=$row["nombre_cargo"];
}

$mysqli3->close();

$response = [];
$sql = "CALL p_add_detail(".$cod.", ".$_SESSION['id'].", 'ENVIADA', '".$fecha."')";
if (!$mysqli->query($sql)) {
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
    
    $nomE=$_SESSION['nombre'];
    enviarCorreoContrato($correo,$nomEstu,$cargo,$nomE);
    
    $response = array(
    'comment' => "Se agregó satisfactoriamente",
    'status' => 1
    );
}

$mysqli->close();


echo json_encode($response);

?>
