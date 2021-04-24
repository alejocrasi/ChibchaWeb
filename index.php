<?php
session_start();

include_once('persistencia/db.php');
include_once('config.php');
if (isset($_SESSION['redirect'])) {
    header('Location: '.$_SESSION['redirect']);
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


  <title>Chibcha Web Login</title>

  <!-- Custom fonts for this template-->
  <link href="estilos_tp2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="estilos_tp2/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/images/favicon.ico"/>
  <script src="estilos_tp2/vendor/jquery/jquery.min.js"></script>
  <script src="estilos_tp2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="estilos_tp2/js/sb-admin-2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <!-- Dropify file input -->
  <script src="assets/dist/js/dropify.min.js"></script>
  <link rel="stylesheet" href="assets/dist/css/dropify.min.css">
</head>

<style>
body {
  background-image: url('assets/images/wallpaper.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
.bg-login-image {
    background: url('assets/images/santosesgei.png');
    background-position: center;
    background-repeat: no-repeat;
}
.card{
  background-color: rgba(255,255,255,0.6);
}
</style>

<?php
$url_google='';
if(isset($_GET['code'])){
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(!isset($token['error'])){
      $google_client->setAccessToken($token['access_token']);
      $_SESSION['access_token'] = $token['access_token'];
      $google_service= new Google_Service_Oauth2($google_client);
      $data= $google_service->userinfo->get();
      echo '<script>checkGmail("'.$data['email'].'");</script>';
  }else{
      echo '<script>console.log("'.$token['error'].'");</script>';
  }
}else{
  $url_google = $google_client->createAuthUrl();
}
?>
<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5" style="margin-top: 10%!important;">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6" style="background-color: white;">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenido a Chibcha Web</h1>
                  </div>
                  <div class="form-group row" id="alert_login"></div>
                  <form class="user" id="form_login" action="javascript:void(0);" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Ingrese el correo electronico...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-warning btn-user btn-block">
                      Iniciar Sesión
                    </button>
                    <hr>
                    <a href="register.php" class="btn btn-google btn-user btn-block"> Registrarme!
                    </a>
                  </form>
                  <hr>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script>
    $('#form_login').submit(function () {
      $.ajax({
          type: "POST",
          url: "ws/checkCredentials.php",
          data: $('#form_login').serialize(),
          success: function (data) {                        
              console.log(data);
              data = JSON.parse(data);
              if (data["status"]) {
                Swal.fire(
								  data['comment'],
								  '',
								  'success'
								).then(function(){
                  window.location = data['redirect'];
                });
              } else {
                if(data['redirect']==''){
                  $('#alert_login').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' + data["comment"] +
                '                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '                                <span aria-hidden="true">&times;</span>\n' +
                '                            </button>\n' +
                '                        </div>');
                console.log(data);
                }else{
                  Swal.fire(
								  data['comment'],
								  '',
								  'error').then(function(){
                    window.location=data['redirect'];
                  });
                }
                
              }
          },
          error: function (data) {
              console.log(data);
          },
      })
        
    });
  </script>

<script>
  function activar(id) {
    $.ajax({
        type: "POST",
        url: "ws/checkMailUser.php",
        data: { 
            'codigo': id,
        },
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"]==1) {
              Swal.fire({
                title: "Felicitaciones!",
                text: "Su cuenta ha sido activada",
                icon: "success"
              }
              ).then(function() {
                  window.location = "registerCV.php";
              });
            }else {
                $('#alert_login').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' + data["comment"] +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</div>');
            }
        },
        error: function (data) {
            console.log(data);
        },
    })
  }
  function alreadyActive(id) {
    $.ajax({
        type: "POST",
        url: "ws/checkMailUser.php",
        data: { 
            'codigo': id,
        },
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"]==1) {
              Swal.fire({
                title: "Advertencia!",
                text: "Su cuenta ya se encuentra activada, pero todavia se encuentra en proceso de inscripción",
                icon: "warning"
              }
              ).then(function() {
                  window.location = "registerCV.php";
              });

            }else {
                $('#alert_login').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' + data["comment"] +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</div>');
            }
        },
        error: function (data) {
            console.log(data);
        },
    })
  }
</script>
  <?php
    if (isset($_GET['i'])) {
        $cod = base64_decode($_GET['i']);
        $sql = "SELECT estado FROM ESTUDIANTE where cod_estudiante = ".$cod;
        $stmt = $mysqli->prepare($sql);
        $result = $mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            if ($stmt -> execute()) {
                $stmt -> bind_result($estado);
                while ($stmt -> fetch()) {
                    if ($estado=='REGISTRADO') {
                        $stmt->close();
                        $sql2 = "UPDATE ESTUDIANTE set estado= 'ACTIVADO' where cod_estudiante = ".$cod;
                        $stmt2 = $mysqli->prepare($sql2);
              
                        if (!$stmt2 -> execute()) {
                            echo '<script> swal.fire({
                            title: "Error!",
                            text: "No se ha podido activar su cuenta!",
                            icon: "error",
                        }
                         ).then(function() {
                            window.location = "index.php";
                          });</script>';
                        } else {
                            $stmt2->close();
                            echo "<script>
                          activar(".$cod.");
                          </script>  ";
                        break;
                        }
                    }
                    elseif ($estado=='ACTIVADO') {
                      $stmt->close();
                      
                            echo "<script>alreadyActive(".$cod.");</script>";
                        break;
                       
                    }else {
                        echo '<script> swal.fire({
                        title: "Aviso!",
                        text: "Su cuenta ya se encuentra activada",
                        icon: "warning",
                            }
                        ).then(function() {
                                window.location = "index.php";
                         });</script>';
                    }
                }
            }else {
              echo '<script> swal.fire({
              title: "Error!",
              text: "No se ha podido activar su cuenta!",
              icon: "error",
          }
           ).then(function() {
              window.location = "index.php";
            });</script>';
          }
            } else {
                echo '<script> swal.fire({
                title: "Error!",
                text: "No se ha podido activar su cuenta!",
                icon: "error",
            }
             ).then(function() {
                window.location = "index.php";
              });</script>';
            }
        
    }
  ?>


</body>

</html>
