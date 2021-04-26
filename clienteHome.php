<?php
session_start();

if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <title>Cliente</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <link href="assets/Home/styleDomonio.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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

    <link href="assets/css/hvcss.css" rel="stylesheet"/>
 <!-- Custom styles for this template-->
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
    
    getDominios();

  };


  function getDominios(){
    $.ajax({
        type: "POST",
        url: "ws/getDominios.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["dominios"];
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                html += '<tr>' +
             '<td><img width="50px" height="50px" src="assets/images/logos/' + data[i]["logo"] + '"></td>' +
             '<td>' + data[i]["programa"] + '</td>' +
             '<td>' + data[i]["nombre"] + '</td>' +
             '<td>' + data[i]["correo_empresa"] + '</td>' +
             '<td>' + data[i]["descripcion_empresa"] + '</td>' +
             '<td>' + data[i]["num_ingresos"] + '</td>' +
             '<td>' + data[i]["estado"] + '</td>' +
             '<td><a href="assets/images/cc/' + data[i]["cc_empresa"] + '">documento</a></td>' +
             '<td><a href="">'+'<button type="button" rel=tooltip" class="btn btn-outline-info btn-rounded">edit'
             '</tr>';

           }
          $('#company').html(html);
          
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
        <a href="?menu=stats">
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
                  <a class="dropdown-grid">
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
          <div class="info-wrapper">
            <h5 class="user-name"><?php echo $_SESSION['nom_cliente'];?></h5><br>
            <h6 class="display-income"><?php echo $_SESSION['correo_cliente']; ?></h6>
            <h6 class="display-income">Menbrecia <?php echo $_SESSION['tipo_membresia']; ?> </h6>
          </div>
          </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">Menu</li>
         
          <li>
            <a href="ClienteHome">
              <span class="link-title">Registrar Dominio</span>
              <i class="mdi mdi mdi-human-greeting link-icon"></i>
            </a>
          </li>
       
       
          <li>
            <a href="#hv-pages" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">No se</span>
              <i class="mdi mdi-account-card-details link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="hv-pages">
              <li>
                <a href="?menu=EditCV"><strong>Editar</strong></a>
              </li>
              <li>
                <form method="post" target="_blank" action="pdf.php" id="formPDF">
                  <a href="" onclick="this.closest('form').submit();return false;">
                    <span class="link-title"><strong>Ver en PDF</strong> </span>
                  </a>
                  <input type="hidden" id="id" name="id" value="<?php echo $_SESSION["id"];?>"/>
                </form>
              </li>
            </ul>
          </li>


          <li>
            <a href="clienteDominio.php">
              <span class="link-title">Mis Dominios</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>

          <li>
            <a href="clienteSoporte">
              <span class="link-title">Soporte</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>

          <li>
          <a href="assets/manuales/Manual Estudiante.pdf" target="blank">
              <span class="link-title">Manual usuario</span>
              <i class="mdi mdi-file-pdf link-icon"></i>
            </a>
          </li>
          
        </ul>
        
      </div>
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <?php 
            require_once('routingSt.php');
          ?>
          
        <!-- content viewport ends -->
<footer id="footer">

<div class="footer-top">

  <div class="container">

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <a class="scrollto footer-logo"><img src="assets/img/hero-logo.png" alt=""></a>
        <h3>OBTÉN TU DOMINIO</h3>
        <p>Usa tu creatividad para elegir el nombre perfecto para tu dominio.</p>
      </div>
    </div>

    <div class="row footer-newsletter justify-content-center">
      <div class="col-lg-6">
        <form action="" method="post">
          <input type="email" name="email" placeholder="Ingresa el dominio que deseas registrar"><input type="submit" value="Buscar">
        </form>
      </div>
    </div>
  </div>
</div>

</footer><!-- End Footer -->


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
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <script src="assets/vendors/js/vendor.addons.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <script src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Dropify file input -->
    <script src="assets/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" href="assets/dist/css/dropify.min.css">

   
    <!--  -->
  </body>
</html>