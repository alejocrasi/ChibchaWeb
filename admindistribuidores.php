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
    
    getDis();
    

  };
  
  function ocultar(){
    $('#alert_pwo').css('display','none');
  }
   

  function getDis(){
    if ($.fn.DataTable.isDataTable( '#dis' ) ) {
        $('#dis').DataTable().destroy();
    }
    $.ajax({
        type: "POST",
        url: "ws/getDistribuidores.php",
        success: function (data) { 
          console.log(data);   
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["distribuidores"];
                var html = '';
                var i;
                for (i = 0; i < data.length ; i++) {
                  
                html += '<tr>' +
                        '<td>' + data[i]["cod_distribuidor"] + '</td>' +
                        '<td>' + data[i]["razon_social"] + '</td>' +
                        '<td>' + data[i]["NIT_distribuidor"] + '</td>' +
                        '<td>' + data[i]["categoria_distribuidor"] + '</td>' + 
                        '<td>' + data[i]["correo_distribuidor"] + '</td>' +
                        '<td>' + data[i]["password_distribuidor"] + '</td>' +
                        '<td>' + data[i]["plan_pago_distribuidor"] + '</td>' +
                        '<td><a href="editDistribuidor.php?correo=' + data[i]["correo_distribuidor"] +'">'+'<button type="button" rel=tooltip" class="btn btn-info btn-rounded">editar ' +  
                        '</tr>';
           }
          
          $('#dis tbody').html(html);
          
            }
            $("#contentPage").html(data);
                    $('#dis').DataTable({
                        "language": {
                            "sProcessing":    "Procesando...",
                            "sLengthMenu":    "Mostrar _MENU_ registros",
                            "sZeroRecords":   "No se encontraron resultados",
                            "sEmptyTable":    "Ningún dato disponible en esta tabla",
                            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":   "",
                            "sSearch":        "Buscar:",
                            "sUrl":           "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":    "Último",
                                "sNext":    "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    });
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
        <a href="adminEmpleados.php">
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
            <a href="adminDistribuidoes.php">
              <span class="link-title">Gestion de distribuidores</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
          </li>

          
        </ul>
      </div>
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header" style="margin-left: -2%;">
            <div class="row">
              <div class="col-12 py-5">
                <h4 style="margin-left: 2%; width: 100%;">Distribuidor</h4>
              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-27">
                <div class="grid">
                  <p class="grid-header">Lista de Distribuidor</p>
                  <div class="item-wrapper text-center">
                      <div style="width: 1060px;">
                      <table id="dis" name="dis" class="display nowrap dataTable dtr-inline collapsed no-footer" role="grid" aria-describedby="dis_info">
                      <thead>
                      <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="codigo: Activar para ordenar la columna de manera ascendente" style="width: 1px;">codigo</th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="nom_empleado: Activar para ordenar la columna de manera ascendente" style="width: 1px;">razon social</th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="NIT : Activar para ordenar la columna de manera ascendente" style="width: 1px;">NIT </th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="categoria_distribuidor: Activar para ordenar la columna de manera ascendente" style="width: 1px;">categoria</th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="correo_distribuidor: Activar para ordenar la columna de manera ascendente" style="width: 1px;">correo</th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="password_distribuidor: Activar para ordenar la columna de manera ascendente" style="width: 1px;">password</th>
                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="plan_pago_distribuidor: Activar para ordenar la columna de manera ascendente" style="width: 1px;">plan pago</th>

                        <th class="sorting" tabindex="0" aria-controls="dis" rowspan="1" colspan="1" aria-label="opciones: Activar para ordenar la columna de manera ascendente" style="width: 1px;">opciones</th>

                      </tr>


                    </thead>
                      <tbody id="dis" name="dis"><tr role="row" class="odd"></tr>
                      </tbody>
                        
                      </table>
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
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
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
  </body>
</html>