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
.sidebar .navigation-menu li a {
    
    color: #ffffff;
    
}
.sidebar {
    
    background: #790606;
    
}


</style>

<script>
   window.onload=function(){
   
    getDistribuidores();

  };
 

  function ocultar(){
    $('#alert_pwo').css('display','none');
  }


  function modDistribuidor(){
      $.ajax({
        type: "POST",
        url: "ws/modDistribuidor.php",
        data: new FormData($('#mod')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
              console.log(data);
              $('.dropify-clear').click();
              Swal.fire(
                  'Bien hecho!',
                  'Se ha modificado de forma exitosa!!!',
                  'success'
                ).then(function(){
                  window.location='adminDistribuidores.php';
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

  function getDistribuidores(){
    $.ajax({
        type: "POST",
        url: "ws/getDistribuidores.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["distribuidores"];   
                var i=0;
                var econtro = false;
                while(econtro==false){
                  if(data[i]["NIT_distribuidor"]=='<?php echo $nit ?>'){
                   econtro=true;    

                  }else{
                    i++;
                  }                                      
                }

                var html ='<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">Razon Social</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="razon_social" id="razon_social" value ="'+data[i]["razon_social"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                        '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">NIT</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="NIT_distribuidor" id="NIT_distribuidor" readonly value ="'+data[i]["NIT_distribuidor"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                        '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">categoria</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="categoria_distribuidor" id="categoria_distribuidor" value ="'+data[i]["categoria_distribuidor"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="email">Correo</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="email" class="form-control" id="correo_distribuidor" name="correo_distribuidor" value ="'+data[i]["correo_distribuidor"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">Contrase??a</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" id="password_distribuidor" name="password_distribuidor" value ="'+data[i]["password_distribuidor"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                        '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">plan de pago</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="plan_pago_distribuidor" id="plan_pago_distribuidor" value ="'+data[i]["plan_pago_distribuidor"]+'" style="width:180%;">'+
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
        
                  <a class="dropdown-grid" href="logout.php">
                    <i class="grid-icon mdi mdi-exit-to-app mdi-2x"></i>
                    <span class="grid-tittle">Cerrar sesi??n</span>
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
            <p class="user-name"><?php echo $_SESSION['user_admin'];?></p>
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
            <a href="adminEmpleados.php">
              <span class="link-title">Gestion de empleados</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminClientes.php">
              <span class="link-title">Gestion de clientes</span>
              <i class="mdi mdi mdi-human-greeting link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminDistribuidores.php">
              <span class="link-title">Gestion de distribuidores</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
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
                <h4>Distribuidor</h4>
                <div class="form-group">
                                                           

              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-10 equel-grid">
                <div class="grid">
                  <p class="grid-header">Editar Distribuidor</p>
                   <div class="grid-body">
                    <div class="item-wrapper">
                      <form id="mod" action="javascript:void(0);" onsubmit="modDistribuidor();">
                          <div id="insertar">
                          

                          </div>     
                          <div >
                            <br>
                              <div class="form-group row showcase_row_area" style="float:right;" >
                                <div>                  
                                  <a href="adminDistribuidores.php" class="btn btn-warning" style="margin-right:15px;">Cancelar</a>
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