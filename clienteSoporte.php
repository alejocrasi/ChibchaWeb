<?php
session_start();

if (!isset($_SESSION['redirect'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <title>Soporte cliente</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <link href="assets/Home/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/Home/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/Home/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/Home/style.css" rel="stylesheet">

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
.sidebar .navigation-menu li a {
    
    color: #ffffff;
    
}
.sidebar {
    
    background: #790606;
    
}
</style>

<script>
  function regTicket(){
    
    $.ajax({
      type: "POST",
      url: "ws/registrarTicket.php",
      data:$('#f_dom').serialize(),
      success: function (data) {
          data = JSON.parse(data);
          console.log(data);
          if (data["status"] == 1) {
            Swal.fire(
                'Bien hecho!',
                'Se ha enviado correctamente tu inquietud!!!',
                'success'
              ).then(function(){
                window.location='clienteSoporte.php';
              })
          }else{
            if(data['error'] ==1062){
              Swal.fire(
                'Error!',
                'No se ha podido enviar tu inquietud!!!',
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

</script>

  <body class="header-fixed">
    <!-- partial:../partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
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
                  </a>
                <a class="dropdown-grid">
                    <i class="grid-icon mdi mdi-security mdi-2x"></i>
                    <Center><span class="grid-tittle">Cambiar contraseña</span></Center>
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
            <h5 class="user-name"><?php echo $_SESSION['nom_cliente'];?></h5><br>
            <h6 class="display-income"><?php echo $_SESSION['correo_cliente']; ?></h6>
            <h6 class="display-income">Membresia <?php echo $_SESSION['tipo_membresia']; ?> </h6>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">Menu</li>
         
          <li>
            <a href="ClienteHome.php">
              <span class="link-title">Registrar Dominio</span>
              <i class="mdi mdi mdi-human-greeting link-icon"></i>
            </a>
          </li>
       
       


          <li>
            <a href="clienteDominio.php">
              <span class="link-title">Mis Dominios</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>

          <li>
            <a href="clienteSoporte.php">
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
          ?>
          
        <!-- content viewport ends -->
      <!-- partial -->
            <!-- ======= Contact Us Section ======= -->
                  
      <section id="contact" class="contact">
        <div class="container">

          <div class="section-title" data-aos="fade-down">
            <span>Comentanos tus inquietudes</span>
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-12" data-aos="fade-up" data-aos-delay="100">
              <div class="info-box">
                <i class="bx bx-map"></i>
                <h3>Direccion</h3>
                <p>Av. Cra. 9 No. 131 A - 02<br>Bogota Colombia</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
              <div class="info-box">
                <i class="bx bx-envelope"></i>
                <h3>Correo</h3>
                <p>atencionalusuario@<br>unbosque.edu.co</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
              <div class="info-box">
                <i class="bx bx-phone-call"></i>
                <h3>Contactanos</h3>
                <p>(571) 648 9000</p>
              </div>
            </div>
          </div>

          <form id="f_dom" method="post" role="form" class="php-email-form mt-4" data-aos="fade-up" data-aos-delay="400" onsubmit="regTicket();">
            <div class="form-row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Ingresa tu nombre" data-rule="minlen:4" data-msg="Porfavor ingresa tu nombre" />
                <div class="validate"></div>
              </div>
              <div class="col-md-6 form-group">
                <input type="email" class="form-control" name="correo_cliente" id="correo_cliente" value="<?php echo $_SESSION['correo_cliente']; ?>" data-rule="email" readonly data-msg="Porfavor ingresa tu Email" />
                <div class="validate"></div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="URL_dominio" id="URL_dominio" placeholder="Url paginaWeb" data-rule="minlen:4" data-msg="Porfavor ingresa tu url de pagina web" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
                <select name="nivel_ticket" class="form-control" id="nivel_ticket" required>
                  <option value="">Seleccione el nivel del ticket</option>              
                  <option value="5">Urgente</option>
                  <option value="4">Alto</option>
                  <option value="3">Normal</option>
                  <option value="2">Mediano</option>
                  <option value="1">Bajo</option>
                </select>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="reclamo" id="reclamo" rows="5" data-rule="required" data-msg="Porfavor ingresa tu inquietud" ></textarea>
              <div class="validate"></div>
            </div>
            <div class="mb-3">
              <div class="loading">Cargando</div>
              <!--<div class="error-message">Tu mensaje no se pudo enviar</div>-->
               <!--<div class="sent-message">Tu mensaje a sido enviado !gracias por tu contribucion!</div>-->
             <!--</div>-->
             <div class="text-center"><button type="submit">Enviar</button></div>
          </form>

        </div>
      </section><!-- End Contact Us Section -->

    </main><!-- End #main -->             
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
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <script src="assets/vendors/js/vendor.addons.js"></script>
    <script src="assets/Home/php-email-form/validate.js"></script>
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
  </body>
</html>