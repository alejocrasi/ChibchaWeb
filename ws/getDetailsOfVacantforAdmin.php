<?php
include_once('../persistencia/db.php');
$query = "SELECT VACANTE.cod_vacante,VACANTE.nombre_cargo, VACANTE.horario_disponibilidad, VACANTE.rango_salarial, EMPRESA.nombre, EMPRESA.logo, VACANTE.descripcion_vacante, VACANTE.educacion_base FROM VACANTE, EMPRESA WHERE VACANTE.cod_empresa = EMPRESA.cod_empresa AND VACANTE.estado='PUBLICADO' AND VACANTE.cod_vacante=".$_POST['cod'];

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_vacante,$nombre_cargo,$horario_disponibilidad,$rango_salarial,$nombre,$logo,$descripcion,$educacion);

$html='';
$entro=false;
while($stmt -> fetch()) {
    $entro=true;
    $html.='
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group" style="margin-top:4%;text-align:center;">
                        <h2>'.$nombre.'</h2>
                        <img src="assets/images/logos/'.$logo.'" width="100px" height="100px" class="thumb-sm rounded-circle mr-4">
                    </div>
                    <div class="form-group">
                        <center><h4>Puesto de trabajo</h4></center><br>
                        <input type="text" class="form-control" value="'.$nombre_cargo.'" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                    </div>
                    <div class="form-group">
                        <center><h4>Descripción de la vacante</h4></center><br>
                        <input type="text" class="form-control" value="'.$descripcion.'" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                    </div>
                    <div class="form-group">
                        <center><h4>Horario disponible</h4></center><br>
                        <input type="text" class="form-control" value="'.$horario_disponibilidad.'" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                    </div>
                    <div class="form-group">
                        <center><h4>Rango salarial</h4></center><br>
                        <input type="text" class="form-control" value="'.$rango_salarial.'" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                    </div>
                    <div class="form-group">
                        <center><h4>Educación previa</h4></center><br>
                        <input type="text" class="form-control" value="'.$educacion.'" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
'
            
            ;
}
$response=array();
if($entro){
    $html.='';
    $response = array(
        'html' => $html,
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
