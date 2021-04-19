<?php
include_once('../persistencia/db.php');

$response = [];
$query='SELECT nombre from EMPRESA where nit ="'.base64_decode($_POST['nit']).'"';
$r=$mysqli->query($query);
$razon='';

if ($row=$r-> fetch_assoc()) {
    $razon=$row["nombre"];
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
$logo='';

if($_FILES["cc"]["name"]){
    $logo = removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    $img = "../assets/images/cc/" . removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    file_put_contents($img, file_get_contents($_FILES["cc"]["tmp_name"]));
}
$addLogo=($logo=='') ? '' :', cc_empresa="'.$logo.'"';

$sql = 'UPDATE EMPRESA SET estado="REGISTRADO" '.$addLogo.' WHERE nit="'.base64_decode($_POST['nit']).'"';
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
        'comment' => "Se envio correctamente, te notificaremos a tu correo cuando tu solicitud sea aprobada",
        'status' => 1
        );
}


    
$mysqli->close();

echo json_encode($response);

?>
