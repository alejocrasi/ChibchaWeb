<?php 
include_once('persistencia/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST["id"])) {
    $id=$_POST["id"];
    $query = "SELECT e.cod_estudiante, e.nombre_completo, e.correo_estudiante, e.numero_solicitudes, p.nom_programa, e.semestre, 
e.cod_HV, e.foto, hv.perfil_profesional, hv.lugar_de_residencia,hv.numero_telefono,hv.educacion,hv.informacion_complementaria,hv.experiencia_laboral,
hv.experiencia_academica,hv.referencias 
FROM ESTUDIANTE e, PROGRAMA p, HOJA_VIDA hv 
WHERE e.cod_HV = hv.cod_HV AND e.cod_programa=p.cod_programa AND e.cod_estudiante=$id";

    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($id, $nombre, $correo, $numero_solicitudes, $programa, $semestre, $cod_hv, $foto, $perfilPro, $Lresidencia, $numeroTel, $educacion, $infoComple, $expLab, $expAca, $ref);

    while ($stmt -> fetch()) {
        $nom_est=$nombre;
        $mail=$correo;
        $program=$programa;
        $semester=$semestre;
        $telephone = $numeroTel;
        $residence = $Lresidencia;
    
        $photo=$foto;

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
    }
    $stmt->close();
    if(isset($nom_est)){ 
?>

<body id="top">
    <div id="cv" class="instaFade">
        <div class="mainDetails">

            <div id="name">
                <h1 class="quickFade delayTwo">&nbsp;
                    <?php echo $nom_est; ?>
                </h1>
                <h2 class="quickFade delayThree">&nbsp;
                    <?php echo $program; ?>
                </h2>
                <div id="contactDetails">
                    <ul>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp; Email:
                            <a href="mailto:<?php echo $mail; ?>" target="_blank">
                                <?php echo $mail; ?>
                            </a>
                        </li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp; Teléfono:
                            <?php echo $telephone; ?>
                        </li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp; Dirección:
                            <?php echo $direccion.' - '.$residence; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="mainArea" class="quickFade delayFive">
            <section>
                <article>
                    <div class="sectionTitle">
                        <h1>Perfil Profesional</h1>
                    </div>

                    <div class="sectionContent">
                        <p>
                            <?php echo $perfilPro; ?>
                        </p>
                    </div>
                </article>
                <div class="clear"></div>
            </section>

            <section>
                <div class="sectionTitle">
                    <h1>Formación Academica</h1>
                </div>

                <div class="sectionContent">
                    <article>
                        <h2>
                            <?php echo $program; ?>
                        </h2>
                        <p>Semestre:
                            <?php echo $semester; ?><br>Fecha de Inicio:
                            <?php echo $fechaIni; ?>
                        </p>

                    </article>
                </div>
                <div class="clear"></div>
            </section>

            <?php
        if ($idiomas!=null || $cursos!=null) {
     	
		echo '<section>
			<div class="sectionTitle">
				<h1>Formación Complementaria</h1>
			</div>
			<div class="sectionContent">';
			if($idiomas != null){
				echo'  <article>
					<h2>Idiomas</h2>
					<p>'.$idiomas.'</p>
				</article>	';
			}
			if	($cursos!=null){
				echo '<article>
					<h2>Cursos</h2>
					<p>'.$cursos.'</p>
				</article>';

        }
        echo '</div><div class="clear"></div>
		</section>';
	}
		?>
                <section>
                    <div class="sectionTitle">
                        <h1>Experiencia Academica</h1>
                    </div>

                    <div class="sectionContent">
                        <article>
                            <h2>
                                <?php echo $tituloP; ?>
                            </h2>
                            <p class="subDetails">
                                <?php echo $materia." - ".$periodo; ?>
                            </p>
                            <p>
                                <?php echo $desAca; ?>
                            </p>
                        </article>
                    </div>
                    <div class="clear"></div>
                </section>
                <?php
					if ($cargo!=null) {
						echo '<section>
						<div class="sectionTitle">
							<h1>Experiencia Laboral</h1>
						</div>
						
						<div class="sectionContent">
							<article>
								<h2>'.$cargo.' en '.$company.'</h2>
								<p class="subDetails">'.$startDate.' - '.$endDate.'</p>
								<p>'.$functions.'</p>
							</article>
						</div>
						<div class="clear"></div>
					</section>';
					} ?>

                    <section>
                        <div class="sectionTitle">
                            <h1>Referencias</h1>
                        </div>
                        <div class="sectionContent">
                            <article>
                                <h2>
                                    <?php echo $nomR1; ?>
                                </h2>
                                <p> Cargo:
                                    <?php echo $carR1; ?> <br>Teléfono:
                                    <?php echo $numR1; ?>
                                </p>

                            </article>

                            <article>
                                <h2>
                                    <?php echo $nomR2; ?>
                                </h2>
                                <p>Cargo:
                                    <?php echo $carR2; ?><br>Teléfono:
                                    <?php echo $numR2; ?>
                                </p>
                            </article>
                        </div>
                        <div class="clear"></div>
                    </section>

        </div>
    </div>
</body>

<?php
    }else{
        echo "<center><h1 style='font-size: 30pm;  margin-left:18%; margin-top: 18%; margin-right:18%;'>El estudiante no ha completado la hoja de vida</h1></center>";   
    }
}

else{
	echo "<center><h1 style='font-size: 30pm;  margin-left:18%; margin-top: 18%;'>No puede recargar esta pagina</h1></center>";
}
?>