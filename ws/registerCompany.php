<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../persistencia/db.php');

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

function enviarCorreo($mail, $name)
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
   $PHPmail->Subject    = 'Confirma tu correo electrónico';
   
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
                        <p>Te damos la bienvenida '.$name.' al portal de practicas de la Universidad El Bosque.</p>
                        <p>En este momento te encuentras en proceso de espera.</p><br><br><br>
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

function removeAccents($input){
    $output = "";
    $output = str_replace("á", "a", $input);
    $output = str_replace("é", "e", $output);
    $output = str_replace("í", "i", $output);
    $output = str_replace("ï", "i", $output);
    $output = str_replace("ì", "i", $output);
    $output = str_replace("ó", "o", $output);
    $output = str_replace("ú", "u", $output);
    $output = str_replace("ñ", "n", $output);
    $output = str_replace("Á", "a", $output);
    $output = str_replace("É", "e", $output);
    $output = str_replace("Í", "i", $output);
    $output = str_replace("Ó", "o", $output);
    $output = str_replace("Ú", "u", $output);
    $output = str_replace("Ñ", "n", $output);
    $output = str_replace("ü", "u", $output);
    return $output;
}

$response = [];
$razon = $_POST["nameCp"];
$nit = $_POST["nitCp"];
$logo = '';
$mail = $_POST["mailCp"];
$descripcion = $_POST["desCp"];
$cc='';
$pass = $_POST["passCp"];

if($_FILES["logo"]["name"]){
    $logo = removeAccents(str_replace(' ', '', $razon)) . ".png";
    $img = "../assets/images/logos/" . removeAccents(str_replace(' ', '', $razon)) . ".png";
    file_put_contents($img, file_get_contents($_FILES["logo"]["tmp_name"]));
}
if($_FILES["cc"]["name"]){
    $cc = removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    $img = "../assets/images/cc/" . removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    file_put_contents($img, file_get_contents($_FILES["cc"]["tmp_name"]));
}
$response = [];
$sql = "CALL p_add_company('".$nit."', '".$razon."', '".$pass."', '".$mail."','".$logo."','".$descripcion."','".$cc."')";
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
    $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
    );
    enviarCorreo($mail, $razon);
     
}

$mysqli->close();

echo json_encode($response);

?>