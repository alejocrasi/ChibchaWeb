<?php
session_start();


if (!isset($_SESSION['programa'])) {
    header('Location: index.php');
} else {
    $_SESSION['redirect']="registerCV.php";
    $nombre=$_SESSION['nombre'];
    $id=$_SESSION['id'];
    $correo=$_SESSION['correo'];
    $carrera=$_SESSION['programa'];

}
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>UEB Registro</title>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

        <link href="assets/css/hvcss.css" rel="stylesheet"/>

        <!-- Custom fonts for this template-->
        <link href="estilos_tp2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"/>
        <link rel="icon" type="image/png" href="assets/images/favicon.ico"/>
        <script src="estilos_tp2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Custom styles for this template-->
        <link rel="icon" type="image/png" href="assets/images/favicon.ico"/>
        <script src="estilos_tp2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>

        <link rel="icon" type="image/png" href="assets/images/favicon.ico" />

        
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    </head>
    <style>
        body {
            background-image: url('assets/images/register.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        
        .fit-image {
            width: 100%;
            object-fit: cover
        }
        .action-button{
            background:#eda86a !important;
        }
    </style>
    <script>
        $(document).ready(function() {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".nextInfPer").click(function() {
                if (verifyInforPer()) {
                   siguiente($(this));  
                }
            });

            $(".nextPerfilPro").click(function() {
                if (verifyPerfilPro()) {
                    siguiente($(this));  
                }
            });
            $(".nextFormAca").click(function() {
                if (verifyFormAca()) {
                    siguiente($(this));  
                }
            });
            $(".nextFormCom").click(function() {
                siguiente($(this));  
            });
            $(".nextExpAca").click(function() {
                if (verifyExpAca()) {
                    siguiente($(this));  
                }
            });
            $(".nextExpLab").click(function() {
                if (verifyExpLab()) {
                    siguiente($(this)); 
                    $('#confirm').css('display', 'block');
                
                 }
            });  
           

            function siguiente(val){

                current_fs = val.parent();
                next_fs = val.parent().next();
                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            }


            $(".skip").click(function() {
                $('#confirm').css('display', 'block');
               
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            
            });
            $(".previous").click(function() {
                $('#confirm').css('display', 'none');
               
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 600
                });
            });

            $('.radio-group .radio').click(function() {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function() {
                return false;
            })

        });

        function verifyInforPer() {
            var address = document.getElementById('address').value;
            var residence = document.getElementById('residence').value;
            var telephone = document.getElementById('telephone').value;
            var documento = document.getElementById('document').value;
            var dId = document.getElementById('document_id').value;

            if (address != '' && residence != '' && telephone != '' && documento != '' && dId != '') {
                $('#alert_address').css('display', 'none');
                $('#alert_residence').css('display', 'none');
                $('#alert_telephone').css('display', 'none');
                $('#alert_document').css('display', 'none');
                $('#alert_document_id').css('display', 'none');
                return true;
            } else {
                if (address == '') {
                    $('#alert_address').html('<strong>Error!</strong> Debe ingresar una dirección');
                    $('#alert_address').css('display', 'block');
                } else {
                    $('#alert_address').css('display', 'none');
                }
                if (residence == '') {
                    $('#alert_residence').html('<strong>Error!</strong> Debe ingresar un lugar de residencia');
                    $('#alert_residence').css('display', 'block');
                } else {
                    $('#alert_residence').css('display', 'none');

                }
                if (telephone == '') {
                    $('#alert_telephone').html('<strong>Error!</strong> Debe ingresar un número de celular');
                    $('#alert_telephone').css('display', 'block');
                } else {
                    $('#alert_telephone').css('display', 'none');

                }
                if (documento == '') {
                    $('#alert_document').html('<strong>Error!</strong> Debe ingresar seleccionar un tipo de documento');
                    $('#alert_document').css('display', 'block');
                } else {
                    $('#alert_document').css('display', 'none');

                }
                if (dId == '') {
                    $('#alert_document_id').html('<strong>Error!</strong> Debe ingresar su número de documento');
                    $('#alert_document_id').css('display', 'block');
                } else {
                    $('#alert_document_id').css('display', 'none');

                }
            }
            return false;
        }

        function verifyPerfilPro() {
            var ppro = document.getElementById('ppro').value;

            if (ppro != '') {
                $('#alert_ppro').css('display', 'none');
                return true;
            } else {
                $('#alert_ppro').html('<strong>Error!</strong> Debe ingresar su perfil profesional');
                $('#alert_ppro').css('display', 'block');
            }
            return false;
        }

        function verifyFormAca() {
            var semester = document.getElementById('semester').value;
            var startDate = document.getElementById('startDateAca').value;

            if (semester != '' && startDate != '') {
                $('#alert_semester').css('display', 'none');
                $('#alert_startDate').css('display', 'none');

                return true;
            } else {
                if (semester == '') {
                    $('#alert_semester').html('<strong>Error!</strong> Debe ingresar su semestre actual');
                    $('#alert_semester').css('display', 'block');
                } else {
                    $('#alert_semester').css('display', 'none');
                }
                if (startDate == '') {
                    $('#alert_startDate').html('<strong>Error!</strong> Debe ingresar la fecha en que inicio la carrera');
                    $('#alert_startDate').css('display', 'block');

                } else {
                    $('#alert_startDate').css('display', 'none');
                }
            }
            return false;
        }
                   
        function verifyExpAca() {

            var tituloP = document.getElementById('tituloP').value;
            var materia = document.getElementById('materia').value;
            var periodo = document.getElementById('periodo').value;
            var expAca = document.getElementById('expAca').value;
           
            if (tituloP != '' && materia != '' && periodo != '' && expAca != '' ) {
                $('#alert_tituloP').css('display', 'none');
                $('#alert_materia').css('display', 'none');
                $('#alert_periodo').css('display', 'none');
                $('#alert_expAca').css('display', 'none');
                return true;
            } else {
                if (tituloP == '') {
                    $('#alert_tituloP').html('<strong>Error!</strong> Debe ingresar el titulo del proyecto');
                    $('#alert_tituloP').css('display', 'block');
                } else {
                    $('#alert_tituloP').css('display', 'none');
                }
                if (materia == '') {
                    $('#alert_materia').html('<strong>Error!</strong> Debe ingresar la materia');
                    $('#alert_materia').css('display', 'block');
                } else {
                    $('#alert_materia').css('display', 'none');
                }
                if (periodo == '') {
                    $('#alert_periodo').html('<strong>Error!</strong> Debe ingresar el periodo en el que desarrollo el proyecto');
                    $('#alert_periodo').css('display', 'block');
                } else {
                    $('#alert_periodo').css('display', 'none');
                }
                if (expAca == '') {
                    $('#alert_expAca').html('<strong>Error!</strong> Debe ingresar la descripción de su experiencia');
                    $('#alert_expAca').css('display', 'block');
                } else {
                    $('#alert_expAca').css('display', 'none');
                }
               
            }
            return false;
        }

        function verifyExpLab() {
       
            var cargo = document.getElementById('cargo').value;
            var company = document.getElementById('company').value;
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;
            var functions = document.getElementById('functions').value;
           
            if (cargo != '' && company != '' && startDate != '' && endDate != '' && functions != '' ) {
                $('#alert_cargo').css('display', 'none');
                $('#alert_company').css('display', 'none');
                $('#alert_startDate').css('display', 'none');
                $('#alert_endDate').css('display', 'none');
                $('#alert_functions').css('display', 'none');
                return true;
            } else {
                if (cargo == '') {
                    $('#alert_cargo').html('<strong>Error!</strong> Debe ingresar el cargo');
                    $('#alert_cargo').css('display', 'block');
                } else {
                    $('#alert_cargo').css('display', 'none');
                }
                if (company == '') {
                    $('#alert_company').html('<strong>Error!</strong> Debe ingresar el nombre de compañia');
                    $('#alert_company').css('display', 'block');
                } else {
                    $('#alert_company').css('display', 'none');
                }
                if (startDate == '') {
                    $('#alert_startDate').html('<strong>Error!</strong> Debe ingresar la fecha de inicio ');
                    $('#alert_startDate').css('display', 'block');
                } else {
                    $('#alert_startDate').css('display', 'none');
                }
                if (endDate == '') {
                    $('#alert_endDate').html('<strong>Error!</strong> Debe ingresar la fecha de finalización o un estimado');
                    $('#alert_endDate').css('display', 'block');
                } else {
                    $('#alert_endDate').css('display', 'none');
                }
                if (functions == '') {
                    $('#alert_functions').html('<strong>Error!</strong> Debe ingresar la descripción de su experiencia academica');
                    $('#alert_functions').css('display', 'block');
                } else {
                    $('#alert_functions').css('display', 'none');
                }
               
            }
            return false;
        }

        function verifyRefe() {
                                                    
            var nomRef1 = document.getElementById('nombreRef1').value;
            var carRef1 = document.getElementById('cargoRef1').value;
            var numRef1 = document.getElementById('numeroRef1').value;

            var nomRef2 = document.getElementById('nombreRef2').value;
            var carRef2 = document.getElementById('cargoRef2').value;
            var numRef2 = document.getElementById('numeroRef2').value;

            if (nomRef1 != '' && carRef1 != '' && numRef1 != '' && nomRef2 != '' && carRef2 != '' && numRef2 != '' ) {
                
                $('#alert_nombreRef1').css('display', 'none');
                $('#alert_cargoRef1').css('display', 'none');
                $('#alert_numeroRef1').css('display', 'none');

                $('#alert_nombreRef2').css('display', 'none');
                $('#alert_cargoRef2').css('display', 'none');
                $('#alert_numeroRef2').css('display', 'none');
                return true;

            } else {
                if (nomRef1 == '') {
                    $('#alert_nombreRef1').html('<strong>Error!</strong> Debe ingresar el nombre en la referencia 1');
                    $('#alert_nombreRef1').css('display', 'block');
                } else {
                    $('#alert_nombreRef1').css('display', 'none');
                }
                if (carRef1 == '') {
                    $('#alert_cargoRef1').html('<strong>Error!</strong> Debe ingresar el cargo en la referencia 1');
                    $('#alert_cargoRef1').css('display', 'block');
                } else {
                    $('#alert_cargoRef1').css('display', 'none');
                }
                if (numRef1 == '') {
                    $('#alert_numeroRef1').html('<strong>Error!</strong> Debe ingresar el número de contacto en la referencia 1');
                    $('#alert_numeroRef1').css('display', 'block');
                } else {
                    $('#alert_numeroRef1').css('display', 'none');
                }
                if (nomRef2 == '') {
                    $('#alert_nombreRef2').html('<strong>Error!</strong> Debe ingresar el nombre en la referencia 2');
                    $('#alert_nombreRef2').css('display', 'block');
                } else {
                    $('#alert_nombreRef2').css('display', 'none');
                }
                if (carRef2 == '') {
                    $('#alert_cargoRef2').html('<strong>Error!</strong> Debe ingresar el cargo en la referencia 2');
                    $('#alert_cargoRef2').css('display', 'block');
                } else {
                    $('#alert_cargoRef2').css('display', 'none');
                }
                if (numRef2 == '') {
                    $('#alert_numeroRef2').html('<strong>Error!</strong> Debe ingresar número de contacto en la referencia 2');
                    $('#alert_numeroRef2').css('display', 'block');
                } else {
                    $('#alert_numeroRef2').css('display', 'none');
                }
            }
            return false;
        }

        function regCV(){
            console.log("entro1");
            if (verifyInforPer() && verifyPerfilPro() && verifyFormAca() && verifyExpAca() && verifyRefe()) {
            $.ajax({
                type: "POST",
                url: "ws/registerCurriculumVitae.php",
                data:new FormData($('#msform')[0]),
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data["status"] == 1) {
                        $('.dropify-clear').click();
                        Swal.fire(
                                'Bien hecho!',
                                'Se has creado exitosamente tu hoja de vida!!!',
                                'success'
                                ).then(function(){
                                window.location='index.php';
                        })
                    }else{
                    if(data['error'] == 1062){
                        Swal.fire(
                            'Error!',
                            'Ya se encuentra registrado en la plataforma!!!',
                            'error'
                            )
                    }else{
                        Swal.fire(
                            'Error!',
                            'Ya se encuentra registrado en la plataforma!!!',
                            'error'
                            )
                        
                    }
                    }
                },
                error: function (data) {
                    console.log(data);
                },
            });
            }
        }

        function solonumeros(e) {
            var key = window.event ? e.which : e.keyCode;
            if (key < 48 || key > 57)
                e.preventDefault();
        }
    </script>

    <!-- 
luegar residencia
direccion
perfil profesional
tipo de documento
numero documento
educacion secundaria hasta que bachillerato
informacion comlementaria
experiencia laboras
experiencia academica
referencias
  - alerta perfiul profesional- tenga en cuenta que debe tener 7 conceptos basicos, capacitacion, conocimiento, experiencia, competencia, habilidades, gustos o
  areas disciplinarias que quiere ejercer.

  - formacion academica: asume carrera seleccionada, campo semestre y fecha de inicio
  bachiller tecnico
  bachiller academico o bachiller tecnico, titulo bachiller, fecha grado
  tecnico- titulo obtenido, institucion, año grado

  - formacion complementaria
  idiomas que maneja
  curso, seminiario, talleres que tengan certificado 

  - lo que sabe pero no tiene certificado va en perfil academico
- exp academica
- exp laboral
 cargo, empresa, fecha inicio, fecha fin, mision principal o funciones
 - 2 referencias sea laboral o academica 
  nombre, cargo profesion, numero contacto
-->

    <body>
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="card w-75 black-text" style="margin-top:6%;padding-bottom: 2%;">
                    <div class="card-body" id="body_form" name="body_form">
                        <!-- MultiStep Form -->
                        <div class="row justify-content-center mt-0">
                            <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">
                                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h2><strong>Por favor completa los siguientes campos para terminar tu registro</strong></h2>
                                    <p>Llena todos los campos para pasar al siguiente paso</p><br>
                                    <div class="row">
                                        <div class="col-md-12 mx-0" enctype="multipart/form-data">
                                            <form id="msform" action="javascript:void(0);"  onsubmit="regCV();">
                                               
                                                <!-- progressbar -->
                                                <ul id="progressbar">
                                                    <li style="width:14.2%;" class="active" id="account"><strong>Información Personal</strong></li>
                                                    <li style="width:14.2%;" id="personal"><strong>Perfil Profesional</strong></li>
                                                    <li style="width:14.2%;" id="payment"><strong>Formación Academica</strong></li>
                                                    <li style="width:14.2%;" id="payment"><strong>Formación Complementaria</strong></li>
                                                    <li style="width:14.2%;" id="payment"><strong>Experiencia Academica</strong></li>
                                                    <li style="width:14.2%;" id="payment"><strong>Experiencia Laboral</strong></li>
                                                    <li style="width:14.2%;" id="payment"><strong>Referencias</strong></li>
                                                </ul>
                                                <!-- fieldsets -->

                                                <!-- fieldset 1 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Información Personal</h2> <br>

                                                        <input type="text" style="background-color: #f4f4f4;" value="<?php echo $nombre;?>" disabled />
                                                       
                                                        <input type="hidden" id="name" name="name" value="<?php echo $nombre;?>"/>

                                                        <input type="hidden" id="cod_estu" name="cod_estu" value="<?php echo $id;?>">

                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_document" style="display:none;"></div>
                                                        <label for="document">Tipo de documento*</label>
                                                        <div class="input-group input-group-sm mb-3">
                                                            <select name="document" class="form-control" id="document"  >
                                                                <option value="">Seleccione el tipo de documento</option>
                                                                <option value="cc">(CC) Cédula de Ciudadania</option>
                                                                <option value="ce">(CE) Cédula de Extranjeria</option>
                                                              </select>
                                                        </div>

                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_document_id" style="display:none;"></div>
                                                        <input type="text" id="document_id" name="document_id" placeholder="Número de documento"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10"   min="1" max="100000000" class="form-control"
                                                            onkeypress="solonumeros(event);">

                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_telephone" style="display:none;"></div>
                                                        <input type="text" id="telephone" name="telephone" placeholder="Número Telefónico" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10"   min="1" max="100000000" class="form-control"
                                                            onkeypress="solonumeros(event);">
                                                            
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_residence" style="display:none;"></div>
                                                        <input type="text" name="residence" id="residence" placeholder="Lugar de residencia*" />

                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_address" style="display:none;"></div>
                                                        <input type="text" name="address" id="address" placeholder="Dirección*" />                                                    
                                                       
                                                        <input type="text" style="background-color: #f4f4f4;" name="umail" value="<?php echo $correo;?>" disabled />
                                                    </div>
                                                    <input type="button" name="next" class="nextInfPer action-button" value="Siguiente" />
                                                </fieldset>

                                                <!-- fieldset 2 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Perfil Profesional</h2>

                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_ppro" style="display:none;"></div>
                                                        <textarea id="ppro" name="ppro" rows="4" cols="1200" placeholder="Escriba aqui su perfil profesional"></textarea>

                                                        <p>Nota: Tenga en cuenta los siguientes conceptos básicos al momento de llenar su perfil profesional: capacitación, conocimiento, experiencia, competencias, habilidades, gustos o áreas disciplinarias que quiere
                                                            ejercer.</p>
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                                    <input type="button" name="next" class="nextPerfilPro action-button" value="Siguiente" />
                                                </fieldset>

                                                <!-- fieldset 3 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Formación Academica</h2>
                                                        <input type="text" style="background-color: #f4f4f4;" name="carrera" id="carrera" value="<?php echo $carrera;?>" disabled/>
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_semester" style="display:none;"></div>
                                                        <input type="text" id="semester" name="semester" placeholder="Semestre" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2"   min="1" max="20" class="form-control" onkeypress="solonumeros(event);">
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_startDate" style="display:none;"></div>
                                                        <label for="startDate">Fecha de inicio*</label>
                                                        <input type="date" id="startDateAca" name="startDateAca" placeholder="Fehca de inicio" />
                                                   
                                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                                    <input type="button" name="next" class="nextFormAca action-button" value="Siguiente" />
                                                </fieldset>

                                                <!-- fieldset 4 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Formación Complementaria</h2> 
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_languages" style="display:none;"></div>
                                                        <input type="text" name="languages" id="languages" placeholder="Idiomas" />
                                                        
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_courses" style="display:none;"></div>
                                                        <input type="text" name="courses" id="courses" placeholder="Cursos, seminarios o talleres con certificado"/>
                                                   
                                                        <p>Nota: Si no cuenta con ningun tipo de formación complementaria puede pasar al siguiente paso.</p>
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                                    <input type="button" name="next" class="nextFormCom action-button" value="Siguiente" />
                                                </fieldset>

                                                <!-- fieldset 5 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Experiencia Academica</h2>
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_tituloP" style="display:none;"></div>
                                                        <input type="text" name="tituloP" id="tituloP" placeholder="Titulo del proyecto*" />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_materia" style="display:none;"></div>
                                                        <input type="text" name="materia" id="materia" placeholder="Marco de materia*" />
                                                   
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_periodo" style="display:none;"></div>
                                                        <input type="text" name="periodo" id="periodo" placeholder="Periodo Academico* ej: 2020-02" />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_expAca" style="display:none;"></div>
                                                        <textarea id="expAca" name="expAca" rows="10" cols="12" placeholder="Escriba aqui su experiencia academica"></textarea>
                                                       
                                                        <p>Nota: Los trabajos o proyectos realizados durante las diferentes materias son la experiencia academica.</p>
                                                   
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                               
                                                    <input type="button" name="next" class="nextExpAca action-button" value="Siguiente" />
                                             
                                                 </fieldset>
                                              
                                                <!-- fieldset 6 -->
                                                <fieldset>
                                                    <div class="form-card">
                                                        <h2 class="fs-title">Experiencia Laboral</h2> 
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>
                                                        <input type="text" name="cargo" id="cargo" placeholder="Cargo*" />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_company" style="display:none;"></div>
                                                        <input type="text" name="company" id="company" placeholder="Empresa*" />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_startDate" style="display:none;"></div>
                                                        <label for="startDate">Fecha de inicio*</label>
                                                        <input type="date" id="startDate" name="startDate" />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_endDate" style="display:none;"></div>
                                                        <label for="endtDate">Fecha de finalización*</label>
                                                        <input type="date" id="endDate" name="endDate"  />
                                                       
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_functions" style="display:none;"></div>
                                                        <textarea id="functions" name="functions" rows="10" cols="12" placeholder="Describa aqui sus funciones segun su cargo"></textarea>
                                                       
                                                        <p>Nota: Si no cuenta con experiencia laboral puede omitir este paso.</p>
                                                   
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />

                                                    <input type="button" name="next" class="nextExpLab action-button" value="Siguiente" />
                                                    <input type="button" name="skip" style="margin-left: 80%; background: #008375!important;" class="skip action-button" value="Saltar" />
                                               
                                                </fieldset>
                                                
                                                <!-- fieldset 7 -->
                                                <fieldset>
                                                    <div class="form-card" style="text-align: center;">
                                                        <h2 class="fs-title">Referencias</h2> 
                                                        
                                                       <label for="startDate">Referencia 1</label>
                                                      
                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_nombreRef1" style="display:none;"></div>
                                                        <input type="text" name="nombreRef1" id="nombreRef1" placeholder="Nombre*" />
                                                      
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_cargoRef1" style="display:none;"></div>
                                                        <input type="text" name="cargoRef1" id="cargoRef1" placeholder="Cargo*" />
                                                      
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_numeroRef1" style="display:none;"></div>
                                                        <input type="text" name="numeroRef1" id="numeroRef1" placeholder="Numero*" />
                                                       
                                                        <label for="startDate">Referencia 2</label>
                                                      
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_nombreRef2" style="display:none;"></div>
                                                      <input type="text" name="nombreRef2" id="nombreRef2" placeholder="Nombre*" />
                                                        
                                                      <div class="alert alert-danger mb-0" role="alert" id="alert_cargoRef2" style="display:none;"></div>
                                                        <input type="text" name="cargoRef2" id="cargoRef2" placeholder="Cargo*" />
                                                        
                                                        <div class="alert alert-danger mb-0" role="alert" id="alert_numeroRef2" style="display:none;"></div>
                                                        <input type="text" name="numeroRef2" id="numeroRef2" placeholder="Numero*" />
                                               
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                                   
                                                </fieldset>
                                                <button type="submit" style="display: none; margin: 5px 85%;" id="confirm" name="confirm" class="action-button">Confirmar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
    </body>

    </html>