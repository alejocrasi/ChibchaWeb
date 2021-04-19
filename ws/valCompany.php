<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once('../persistencia/db.php');

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

function enviarCorreo($mail, $name,$id)
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
   $PHPmail->Subject    = 'Rechazo empresa';
   $PHPmail->AddEmbeddedImage('../assets/images/logos/logoMail.png', 'logoMail');
   $PHPmail->AddEmbeddedImage('../assets/images/logos/footer.png', 'logofooter');
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
               <p>Te informamos que tu empresa '.$name.' fue rechazada para unirse al portal de practicas de la Universidad El Bosque.</p>
               <p>Para poder usar todos nuestros servicios por favor haz click en el siguiente boton para volver a enviar los archivos necesarios para la verificación.</p><br><br><br>
               <center><a href="https://practicasueb.azurewebsites.net/verifyCompany.php?id='.base64_encode($id).'" style="background-color:#f3984d;border:10px solid #f3984d;text-decoration:none;color:#fff" target="_blank">Activar Cuenta</a></center>
               <br><br>
           </div>
           <br><br><br><br>
           <center>
           <img src=\'cid:logofooter\' alt="footer" style=" max-width: 100%; max-height: 100%;  "></center>
       </div>
   </div>
</div>
           ');

   $PHPmail->AddAddress($mail, $name);
   $PHPmail->Send();
  
}

function enviarCorreoAprobar($mail, $name,$id)
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
   $PHPmail->Subject    = 'Aprobación empresa';
   $PHPmail->AddEmbeddedImage('../assets/images/logos/logoMail.png', 'logoMail');
   $PHPmail->AddEmbeddedImage('../assets/images/logos/footer.png', 'logofooter');
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
                        <p>Te informamos que tu empresa '.$name.' fue aceptada para unirse al portal de practicas de la Universidad El Bosque.</p>
                        <p>Para poder usar todos nuestros servicios por favor ve a la pagina principal para iniciar sesión.</p><br><br><br>
                        <br><br>
                    </div>
                    <br><br><br><br>
                    <center>
                    <img src=\'cid:logofooter\' alt="footer" style=" max-width: 100%; max-height: 100%;  "></center>
                </div>
            </div>
            </div>
           ');

   $PHPmail->AddAddress($mail, $name);
   $PHPmail->Send();
  
}


$response = [];

//info per

$id = $_POST["nitVal2"];
$estado = $_POST["VEstado"];


$nombre="";
$correo="";

$sql = "SELECT * FROM EMPRESA WHERE EMPRESA.NIT = '".$id."'";
$r=$mysqli3->query($sql);
if ($row=$r-> fetch_assoc()) {
    $nombre=$row["nombre"];
    $correo=$row["correo_empresa"];
}

$mysqli3->close();

$sql = "UPDATE EMPRESA SET estado = '".$estado."' WHERE NIT = '".$id." '";

if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló valcompani CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
    if($estado=="RECHAZADO"){
        enviarCorreo($correo, $nombre, $id);
    }
    if($estado=="APROBADO"){
        enviarCorreoAprobar($correo, $nombre, $id);
    }
      $response = array(
        'comment' => "Se actualizo satisfactoriamente",
        'status' => 1
    );
     
}

$mysqli->close();

echo json_encode($response);

?>