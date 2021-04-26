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

<script>
   window.onload=function(){
    
    getCompanies();

  };


  function getCompanies(){
    $.ajax({
        type: "POST",
        url: "ws/getCompanies.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["companies"];
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
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
              <div class="info-box">
                <i class="bx bx-envelope"></i>
                <h3>Correo</h3>
                <p>andres@uni.com<br>contact@example.com</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
              <div class="info-box">
                <i class="bx bx-phone-call"></i>
                <h3>Contactanos</h3>
                <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
              </div>
            </div>
          </div>

          <form action="forms/contact.php" method="post" role="form" class="php-email-form mt-4" data-aos="fade-up" data-aos-delay="400">
            <div class="form-row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Ingresa tu nombre" data-rule="minlen:4" data-msg="Porfavor ingresa tu nombre" />
                <div class="validate"></div>
              </div>
              <div class="col-md-6 form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa tu correo" data-rule="email" data-msg="Porfavor ingresa tu Email" />
                <div class="validate"></div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="Porfavor ingresa mas de 8 caracteres para el asunto" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Url" data-rule="minlen:4" data-msg="Porfavor ingresa mas de 8 caracteres para el asunto" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Porfavor ingresa tu inquietud" ></textarea>
              <div class="validate"></div>
            </div>
            <div class="mb-3">
              <div class="loading">Cargando</div>
              <div class="error-message">Tu mensaje no se pudo enviar</div>
              <div class="sent-message">Tu mensaje a sido enviado !gracias por tu contribucion!</div>
            </div>
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