<?php
session_start();
header ("Pragma-directive: no-cache");
header ("Cache-directive: no-cache");
header ("Cache-control: no-cache");
header ("Pragma: no-cache");
header ("Expires: 0");
if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}
include('graficas.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Home</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- Layout style -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  </head>


<style>
.t-header .t-header-brand-wrapper a .logo {
  width:150px;
  height:50px;
}
.display-avatar.animated-avatar:before {
  background-color: orange;
  background-image: linear-gradient(19deg, orange 0%, red 100%)
}
.navbar-dropdown .dropdown-body .dropdown-grid {
  width:40%;
  margin-left:8%;
}
</style>
<script>
   window.onload=function(){
    graf();
    getData();
  };
  function verifyPass(){
    var pass=document.getElementById('pass').value;
    var verify=document.getElementById('passnew').value;
    var passold=document.getElementById('passold').value;
    console.log(pass+' '+verify);
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','block');
      $('#alert_ex').css('display','none');
    }
    else if(pass=='' || pass=='' || verify==''){
      $('#alert_va').css('display','block');
      $('#alert_ex').css('display','none');
    }else{
      $('#alert_pw').css('display','none');
      $('#alert_va').css('display','none');
      $('#alert_ex').css('display','none');
    }
    return false;
  }

  function ocultar(){
    $('#alert_pwo').css('display','none');
  }
   function modAdmin(pa){
    var pass=document.getElementById('pass').value;
    if(verifyPass() && pa){

      $.ajax({
        type: "POST",
        url: "ws/modAdmin.php",
        data:{
                'pass':pass,
            },
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
              $('.dropify-clear').click();
              Swal.fire(
                  'Bien hecho!',
                  'Se ha modificado la contraseña!!!',
                  'success'
                ).then(function(){
                  $('#alert_pw').css('display','none');
                  $('#alert_va').css('display','none');
                  $('#alert_pwo').css('display','none');
                  $("#seePassword").modal("hide");
                })
            }else{
              if(data['error'] == 1062){
                Swal.fire(
                  'Error!',
                  data['error'],
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
    else{

    }
  }
     function passCheck(){
     var passold=document.getElementById('passold').value;
     trigger=true
     if(trigger){
      $.ajax({
        type: "POST",
        url: "ws/currentpassCheck.php",
        success: function (data) {
            data = JSON.parse(data);
            data = data["passes"];
            if(passold == data[0]["password"]){
              modAdmin(true);
              trigger=false;
            }
            else{
              $('#alert_ex').css('display','none');
              $('#alert_pwo').css('display','block');
              trigger=false;
            }

        },
        error: function (data) {
            console.log(data);
        },
    });
    }
  }
  function getData(){
      $.ajax({
        type: "POST",
        url: "ws/getGraph.php",
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
                var data = data["usuarios"];
                var estu = data[0]["num_estudiantes"];
                var empre = data[0]["num_empresas"]; 
                var vacant = data[0]["num_vacantes"];

                var estuH= '<p>'+estu+'</p>'+
                '<p></p>';
                 var empreH= '<p>'+empre+'</p>'+
                '<p></p>';
                 var vacantH= '<p>'+vacant+'</p>'+
                '<p></p>';

                $('#num_estudiantes').html(estuH);
                $('#num_empresas').html(empreH);
                $('#num_vacantes').html(vacantH);

                    }
        },
        error: function (data) {
            console.log(data);
        },
    });
  }
</script>

  <body class="header-fixed">
    <!-- partial:../partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="adminHome.php">
          <img class="logo" src="assets/images/logo.png" alt="">
          <img class="logo-mini" src="assets/images/logo.png" alt="">
        </a>
      </div>
      <div class="t-header-content-wrapper">
        <div class="t-header-content">
          <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
            <i class="mdi mdi-menu"></i>
          </button>
          <ul class="nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="appsDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-apps mdi-1x"></i>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="appsDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">Opciones</h6>
                </div>
                <div class="dropdown-body border-top pt-0">
                  <a class="dropdown-grid" data-target="#seePassword" data-toggle="modal" class="MainNavText" id="MainNavHelp" 
                   href="#seePassword">
                    <i class="grid-icon mdi mdi-security mdi-2x"></i>
                    <span class="grid-tittle">Cambiar contraseña</span>
                  </a>
                  <a class="dropdown-grid" href="logout.php">
                    <i class="grid-icon mdi mdi-exit-to-app mdi-2x"></i>
                    <span class="grid-tittle">Cerrar sesión</span>
                  </a>
                </div>
                
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- partial -->
    <div class="page-body">
      <!-- partial:../partials/_sidebar.html -->
      <div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" src="assets\images\profile\users\logoAdmin.jpg" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name"><?php echo $_SESSION['nombre'];?></p>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">Menu</li>
          <li>
            <a href="adminHome.php">
              <span class="link-title">Estadisticas</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          
          <li>
            <a href="adminCompany.php">
              <span class="link-title">Empresas</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminStudents.php">
              <span class="link-title">Estudiantes</span>
              <i class="mdi mdi mdi-human-greeting link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminVacant.php">
              <span class="link-title">Vacantes</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
          </li>
          <li>
          <a href="assets/manuales/Manual Administrador.pdf" target="blank">
              <span class="link-title">Manual Administrador</span>
              <i class="mdi mdi-file-pdf link-icon"></i>
            </a>
          </li>
          
        </ul>
        
      </div>
      <!-- partial -->
    <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="content-viewport">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Dashboard</h4>
              </div>
            </div>
            <div class="row">

              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid" >
                  <div class="grid-body text-gray" >
                    <div class="d-flex justify-content-between" id="num_estudiantes" name="num_estudiantes"  >
                      <p ></p>
                    </div>
                    <p class="text-black">Estudiantes</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_1"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between" id="num_empresas" name="num_empresas">
                      <p ></p>
                    </div>
                    <p class="text-black">Empresas</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_2"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
             <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between" id="num_vacantes" name="num_vacantes">
                      <p ></p>
                    </div>
                    <p class="text-black">Vacantes</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_3"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
             
              

              <div class="col-md-6">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Numero de Estudiantes por Programa Academico</h2>
                  <div class="item-wrapper">
                    <canvas id="programas-graph" width="600" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>

            

            <div class="col-md-6">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Estudiantes aceptados por Programa</h2>
                  <div class="item-wrapper">
                    <canvas id="aceptados-programas-graph" width="600" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Estadistica de los rechazos</h2>
                  <div class="item-wrapper">
                    <canvas id="motivo-rechazo-graph" width="1200" height="600"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-12">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Actividad de las vacantes</h2>
                  <div class="item-wrapper">
                    <canvas id="actividad-line-graph" width="1200" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>
      <!-- page content ends -->
        <!-- partial:../partials/_footer.html -->
        <footer class="footer">
          <div class="row" style="display:block;text-align:center;">
            <div>
              <ul class="text-gray">
                Powered By SoftHub Developments
              </ul>
            </div>
            <div style="float:right;">
              <ul>
                <li><a href="#">Terminos de uso</a></li>
                <li><a href="#">Politica de Privacidad</a></li>
              </ul>
            </div>
            
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- page content ends -->
    </div>
    <div class="modal fade" id="seePassword" tabindex="-1" role="dialog" aria-labelledby="addFavorite_modalLabel" aria-hidden="true">
        <div class="modal-dialog ui-corner-all" role="document">
            <div class="modal-content" id="modalBody" name="modalBody">
                <div class="modal-body">
                <div class="form-group">
                  <div class="alert alert-success mb-0" role="alert" id="alert_ex" style="display:none;"><strong>Exito!</strong> Se cambio la contraseña!</div>
                  <div class="alert alert-danger mb-0" role="alert" id="alert_va" style="display:none;"><strong>Error!</strong> Uno o mas de los campos estan vacios!</div>
                  <div class="alert alert-danger mb-0" role="alert" id="alert_pwo" style="display:none;"><strong>Error!</strong> Contraseña equivocada!</div>
                    <center>Ingrese su contraseña</center><br>
                    <input onchange="ocultar();" type="password" id="passold" name="passold" class="form-control" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                </div>
                <div class="alert alert-danger mb-0" role="alert" id="alert_pw" style="display:none;"><strong>Error!</strong> Las contraseñas no coinciden</div>
                <div class="form-group">
                    <center>Ingrese su nueva contraseña</center><br>
                    <input type="password" id="passnew" name="passnew" class="form-control" style="max-width:70%;width:70%; margin-left:15%; text-align:center;">
                </div>
                <div class="form-group">
                    <center>Confirme su contraseña</center><br>
                    <input type="password" id="pass" name="pass" class="form-control" style="max-width:70%;width:70%; margin-left:15%; text-align:center;" onchange="verifyPass();">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success" onclick="passCheck();">Confirmar</button>
            </div>
            </div>
        </div>
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <!--  <script src="assets/vendors/js/vendor.addons.js"></script>-->
     <script src="assets/js/charts/chartjs.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <!--  -->
  </body>
</html>