<?php
header ("Pragma-directive: no-cache");
header ("Cache-directive: no-cache");
header ("Cache-control: no-cache");
header ("Pragma: no-cache");
header ("Expires: 0");
session_start();


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
    getEstudiantes();


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

 function getEstudiantes(){
      $.ajax({
        type: "GET",
        url: "ws/getEstudiantes.php", 
        success: function (data) {
          console.log(data);
        data = JSON.parse(data);
            if (data["status"] == 1) {
                data = data["estudiantes"];
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                  if(data[i]["estado"]=="ACTIVADO"){
                    var estado = 'badge badge-primary';
                  }else if(data[i]["estado"]=="INSCRITO"){
                    estado='badge badge-success';
                  }else if(data[i]["estado"]=="REGISTRADO"){
                    estado='badge badge-dark';
                  }else if(data[i]["estado"]=="CONTRATADO"){
                    estado='badge badge-warning';
                  }else{
                    estado='badge badge-info';
                  }
                var olo= (data[i]['semestre']==null) ? '-' : data[i]['semestre'];
                var aux= (data[i]['numero_solicitudes']==null) ? '-' : data[i]['numero_solicitudes'];

                html += '<tr>' +
                '<td><center>  <form method="post" target="_blank" action="pdf.php" id="formCV"> '+
                              '<div title="Hoja De Vida">'+
                              '<input type="hidden" id="id" name="id" value="'+ data[i]["cod_estudiante"] +'"/>'+
                              '<button type="submit" style="background: url(assets/images/5112.png); width:50px; height:50px; background-size: 50px 50px; border: none;">'+
                              '</form></center></div><center>' + data[i]["nombre_completo"] + '</center></td>' +
                '<td><center>' + data[i]["correo_estudiante"] + '</center></td>' +
                '<td><center>' + aux + '</center></td>' +
                '<td><center>' + data[i]["nom_programa"] + '</center></td>' +
                '<td><center>' + olo + '</center></td>' +
                '<td><center><div class="'+estado+'">' + data[i]["estado"] + '</div></center></td>' +
                '<td><center>' + data[i]["num_ingresos"] + '</center></td>' +
                        '<td><a href="editStudents.php?codigo=' + data[i]["cod_estudiante"] +'">'+'<button type="button" rel=tooltip" class="btn btn-info btn-rounded">editar'
                '</tr>'
                }
              $('#estudiante').html(html);
            }
              $("#contentPage").html(data);
                    $('#estudiantes').DataTable({
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
        <a href="empresa.php">
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
          <div class="viewport-header" style="margin-left: -2%;">
            <div class="row">
              <div class="col-12 py-5">
                <h4 style="margin-left: 2%; width: 100%;">Estudiantes</h4>
              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-27">
                <div class="grid">
                  <p class="grid-header">Lista de Estudiantes</p>
                  <div class="item-wrapper text-center">
                   <div style="width: 100%; height: 100%; ">
                    <table id="estudiantes" name="estudiante" class="wrap dataTable dtr-inline collapsed no-footer" role="grid" aria-describedby="estudiante_info">
                        <thead>
                          <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Nombre Estudiante: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Nombre Estudiante</th>                            
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Correo Estudiante: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Correo Estudiante</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Solicitudes: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Solicitudes</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Programa: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Programa</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Semestre: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Semestre</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Estado: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Ingresos: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Ingresos</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Opciones: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Opciones</th>
                          </tr>
                        </thead>
                        <tbody id="estudiante" name="estudiante" ><tr role="row" class="odd"></tr>

                        </tbody>
                      </table>
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
    <!--  -->
  </body>
</html>