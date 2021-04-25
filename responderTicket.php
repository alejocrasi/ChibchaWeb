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

$num_ticket =$_GET["num_ticket"];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Empleado</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


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
   
    getTickets();

  };
 

  function ocultar(){
    $('#alert_pwo').css('display','none');
  }


  function modTicket(){
      $.ajax({
        type: "POST",
        url: "ws/modTicket.php",
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
                  window.location='empleadoHome.php';
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

  function getTickets(){
    $.ajax({
        type: "POST",
        url: "ws/getTickets.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["tickets"];   
                var i=0;
                var econtro = false;
                while(econtro==false){
                  if(data[i]["num_ticket"]==<?php echo $num_ticket ?>){
                   econtro=true;    
                  }else{
                    i++;
                  }                                      
                }

                var html ='<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">Codigo</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="num_ticket" id="num_ticket" value ="'+data[i]["num_ticket"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                        '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">nivel ticket</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="nivel_ticket" id="nivel_ticket" value ="'+data[i]["nom_cliente"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                        '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">Correo del cliente</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="correo_cliente" id="correo_cliente" value ="'+data[i]["correo_cliente"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">Reclamo</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" id="reclamo" name="reclamo" value ="'+data[i]["reclamo"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="text">Respuesta</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" id="respuesta" name="respuesta" value ="'+data[i]["respuesta"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        
                        
                        
                       '</div>';
                      

                  
          $('#insertar').html(html);
          
          
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
            <p class="user-name"><?php echo $_SESSION['nom_empleado'];?></p>
          </div>
        </div>
        <ul class="navigation-menu">
        <li class="nav-category-divider">Menu</li>
          <li>
            <a href="empleadoHome.php">
              <span class="link-title">Estadisticas</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          
          <li>
            <a href="consultaTikets.php">
              <span class="link-title">Consultar Tickets</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
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
                <h4>Tiket</h4>
                <div class="form-group">
                                                           

              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-10 equel-grid">
                <div class="grid">
                  <p class="grid-header">Responder ticket</p>
                   <div class="grid-body">
                    <div class="item-wrapper">
                      <form id="mod" action="javascript:void(0);" onsubmit="modTicket();">
                          <div id="insertar">
                          

                          </div>     
                          <div >
                            <br>
                              <div class="form-group row showcase_row_area" style="float:right;" >
                                <div>                  
                                  <a href="empleadoHome.php" class="btn btn-warning" style="margin-right:15px;">Cancelar</a>
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
    <script src="assets/vendors/js/core.js"></script>
    <script src="assets/vendors/js/vendor.addons.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <script src="assets/js/charts/chartjs.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- build:js -->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <!--  -->
    <!--  -->
  </body>
</html>