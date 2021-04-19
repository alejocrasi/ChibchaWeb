<?php
include_once('../persistencia/db.php');
if (isset($_POST["id"])) {
    $id=$_POST["id"];
    $query = "SELECT e.cod_estudiante, e.nombre_completo, e.correo_estudiante, e.numero_solicitudes, p.nom_programa, e.semestre, 
e.cod_HV,hv.tipo_documento,hv.numero_documento, hv.perfil_profesional, hv.lugar_de_residencia,hv.numero_telefono,hv.educacion,hv.informacion_complementaria,hv.experiencia_laboral,
hv.experiencia_academica,hv.referencias 
FROM ESTUDIANTE e, PROGRAMA p, HOJA_VIDA hv 
WHERE e.cod_HV = hv.cod_HV AND e.cod_programa=p.cod_programa AND e.cod_estudiante=$id";

    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($id, $nombre, $correo, $numero_solicitudes, $programa, $semestre, $cod_hv,$tDocu,$numDocu, $perfilPro, $Lresidencia, $numeroTel, $educacion, $infoComple, $expLab, $expAca, $ref);

    $rta="";
    $cv=array();
    while ($stmt -> fetch()) {

        $nom_est=$nombre;
        $mail=$correo;
        $program=$programa;
        $semester=$semestre;
        $telephone = $numeroTel;
        $residence = $Lresidencia;
    
        $dirr =explode('<br>', $residence);
        $residence=$dirr[0];
        $direccion=$dirr[1];
        $cargo=null;
    
        if ($expLab!=null) {
            $laboral=explode('<br>', $expLab);

            $cargo = $laboral[0];
            $company = $laboral[1];
            $startDate =$laboral[2];
            $endDate = $laboral[3];
            $functions = $laboral[4];
        }
    
        $academica=explode('<br>', $expAca);
        $tituloP = $academica[0];
        $materia = $academica[1];
        $periodo = $academica[2];
        $desAca = $academica[3];
    
        //	$educa=explode('<br>', $educacion);
        $fechaIni = $educacion;
        //	$materia = $educa[1];

        $complementaria=explode('<br>', $infoComple);
        $cursos = $complementaria[0];
        $idiomas = $complementaria[1];
    
        $referencias=explode('<br>', $ref);
        $nomR1 = $referencias[0];
        $carR1 = $referencias[1];
        $numR1 = $referencias[2];
        $nomR2 = $referencias[3];
        $carR2 = $referencias[4];
        $numR2 = $referencias[5];

        $aux=1;
        $hv=array(
        "nom_estu"=>$nom_est,
        "mail"=>$mail,
        "program"=>$program,
        "semester"=>$semester,
        "telephone"=>$telephone,
        "residence"=>$residence,
        "direccion"=>$direccion,
        "tDocu"=>$tDocu,
        "numDocu"=>$numDocu,
        "ppro"=>$perfilPro,
        "cargo"=>$cargo,
        "company"=>$company,
        "startDate"=>$startDate,
        "endDate"=>$endDate,
        "functions"=>$functions,
        "tituloP"=>$tituloP,
        "materia"=>$materia,
        "periodo"=>$periodo,
        "desAca"=>$desAca,
        "fechaIni"=>$fechaIni,
        "cursos"=>$cursos,
        "idiomas"=>$idiomas,
        "nomR1"=>$nomR1,
        "carR1"=>$carR1,
        "numR1"=>$numR1,
        "nomR2"=>$nomR2,
        "carR2"=>$carR2,
        "numR2"=>$numR2,
        );
        array_push($cv, $hv);
    }
    $response=array();
    if (count($cv)>0) {
        $response = array(
        'cv' => $cv,
        'status' => 1
    );
    } else {
        $response = array(
        'html' => "error",
        'status' => 0
    );
    }
    $stmt->close();
    echo json_encode($response);
}
?>
