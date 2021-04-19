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
   $PHPmail->Subject    = 'Has sido aceptado en la vacante ';
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
                        <p>Felicidades, has sido aceptado en la vacante '.$cargo.'</p>
                        <p>Para terminar el proceso debes aceptar la vacante para poder notificarle a la empresa que estas de acuerdo.</p><br><br><br>
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


function enviarCorreoRechazo($mailTo,$nombre,$cargo,$razones)
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
   $PHPmail->Subject    = 'Has sido rechazado en la vacante';
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
                        <p>Lamentamos informarte que has sido rechazado en la vacante '.$cargo.'.</p>
                        <p>Debido a las razones <br>'.$razones.'</p><br><br><br>
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

$sql = "SELECT nombre_completo,correo_estudiante, nombre_cargo FROM ESTUDIANTE, VACANTE WHERE cod_estudiante= ".$e." AND cod_vacante = ".$c;
$r=$mysqli3->query($sql);
if ($row=$r-> fetch_assoc()) {
    $nomEstu=$row["nombre_completo"];
    $correo=$row["correo_estudiante"];
    $cargo=$row["nombre_cargo"];
}

if($est=="OFERTA"){
    enviarCorreoContrato($correo,$nomEstu,$cargo);
}

$response = [];
$sql = "UPDATE DETALLE SET estado='".$est."' WHERE cod_vacante=".$c." AND cod_estudiante=".$e;
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
    if(isset($_POST['motivos'])){
        $aDoor = $_POST['motivos'];
        if(!empty($aDoor)){
            $N = count($aDoor);
            $razones="";
            for($i=0; $i < $N; $i++){
                $otros=($aDoor[$i]==5) ? $_POST['otrosTxt'] : '';
                $add="INSERT INTO DETALLE_RECHAZO VALUES (".$c.",".$e.",".$aDoor[$i].",'".$otros."');";
                $mysqli2->query($add);
                $sql2 = " SELECT motivo FROM MOTIVOS_RECHAZO WHERE cod_motivo = ".$aDoor[$i];
                $r=$mysqli3->query($sql2);
                if ($row=$r-> fetch_assoc()) {
                    $motivo=$row["motivo"];
                }
                $razones.="- $motivo  $otros<br>";

            }
            if($est=="RECHAZADA"){
                enviarCorreoRechazo($correo,$nomEstu,$cargo,$razones);
            }
            $response = array(
                'comment' => "Se agregó satisfactoriamente",
                'status' => 1
                );
        }
    }else{
        $response = array(
        'comment' => "Se agregó satisfactoriamente x",
        'status' => 1
        );
    }
}

$mysqli->close();
$mysqli2->close();

echo json_encode($response);

?>
