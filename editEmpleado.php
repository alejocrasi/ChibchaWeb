<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();

if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}

$nit=$_GET["nit"];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <title>Home</title>
    <!-- plugins:css -->
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- Layout style -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="assets/vendors/js/core.js"></script>

    <!-- Dropify file input -->
    <script src="assets/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" href="assets/dist/css/dropify.min.css">

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
    dropify = $('.dropify').dropify({
      messages: {
        'default': 'Arrastra el archivo o haz click aqui',
        'replace': 'Arrastra o clikea para remplazar',
        'remove':  'Quitar',
        'error':   'Ooops, algo a salido mal.'
    }
    });
   
    getCompanies();

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
  function verifyPass2(){
    var pass=document.getElementById('pass_1').value;
    var verify=document.getElementById('verify_1').value;
    console.log('entra? verify');
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_pw_1').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_pw_1').css('display','block');
    }else{
      $('#alert_pw_1').css('display','none');
    }
    return false;
  }
   function modCompany(){
    if(verifyPass2()){
      $.ajax({
        type: "POST",
        url: "ws/modCompany.php",
        data: new FormData($('#mod')[0]),
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
                  'Se ha modificado la empresa de forma exitosa!!!',
                  'success'
                ).then(function(){
                  window.location='adminCompany.php';
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
  }

  function getCompanies(){
    $.ajax({
        type: "POST",
        url: "ws/getCompanies.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["companies"];   
                var i=0;
                var econtro = false;
                while(econtro==false){
                  if(data[i]["NIT"]==<?php echo $nit ?>){
                   econtro=true;    

                  }else{
                    i++;
                  }                                      
                }

                var html ='<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">NIT</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="nit" id="nit" value ="'+data[i]["NIT"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="razonSocial">Razón Social</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" id="razonSocial" name="razonSocial" value ="'+data[i]["nombre"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="email">Correo</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="email" class="form-control" id="email" name="email" value ="'+data[i]["correo_empresa"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="descrip">Descripción</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<textarea class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="descrip" name="descrip" required maxlength="1200" style="width:190%;">'+data[i]["descripcion_empresa"]+'</textarea>'+
                          '</div>'+
                        '</div>'+
                        '<div class="alert alert-danger mb-0" role="alert" id="alert_pw_1" style="display:none;width: 70%;text-align: center;margin-left: 25%;"><strong>Error!</strong> Las contraseñas no coinciden</div><br>'+                                         
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="pass">Contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="pass_1" name="pass_1" required value ="'+data[i]["password_empresa"]+'" onchange="verifyPass2();"  minlength="6" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="verify">Verificar contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            ' <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="verify_1" name="verify" required value ="'+data[i]["password_empresa"]+'" onchange="verifyPass2();" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                         '<div>'+
                         '<div class="form-group row showcase_row_area" >'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="logo">Logo de la empresa:</label>'+
                          '</div>'+
                          '<div class="col-md-5 showcase_content_area">'+                  
                            '<input type="file" class="form-control-file dropify" name="logo" id="logo" accept=".png,.jpeg,.jpg" data-allowed-file-extensions="png jpeg jpg" data-default-file="assets/images/logos/'+data[i]["logo"]+'">'+
                          '</div>'+
                         '</div>'+
                       '</div>';
                      

                      
          $('#insertar').html(html);
          
          dropify = $('#logo').dropify({
                          messages: {
                            'default': 'Arrastra el archivo o haz click aqui',
                            'replace': 'Arrastra o clikea para remplazar',
                            'remove':  'Quitar',
                            'error':   'Ooops, algo a salido mal.'
                        }
                        });
            }
        },
        error: function (data) {
            console.log(data);
        },
    })
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
                  <a class="dropdown-grid" data-target="#seePassword" data-toggle="modal">
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
          <div class="viewport-header">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Empresa</h4>
                <div class="form-group">
                                                           

              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-10 equel-grid">
                <div class="grid">
                  <p class="grid-header">Editar empresa</p>
                   <div class="grid-body">
                    <div class="item-wrapper">
                      <form id="mod" action="javascript:void(0);" onsubmit="modCompany();">
                          <div id="insertar">

                          </div>     
                          <div >
                            <br>
                              <div class="form-group row showcase_row_area" style="float:right;" >
                                <div>                  
                                  <a href="adminCompany.php" class="btn btn-warning" style="margin-right:15px;">Cancelar</a>
                                </div>
                                <div>
                                  <button type="submit" class="btn btn-success">Aceptar</button>
                                </div>
                                
                              </div>
                          </div>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>   
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
         
        <!-- content viewport ends -->
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
    <!--  <script src="assets/vendors/js/vendor.addons.js"></script>-->
     <script src="assets/js/charts/chartjs.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- build:js -->
    <!--  -->
  </body>
</html>