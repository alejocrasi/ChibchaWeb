<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registro Chibcha WEB</title>

  <!-- Custom fonts for this template-->
  <link href="estilos_tp2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="estilos_tp2/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/images/favicon.ico"/>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
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
  background-image: url('assets/images/register.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
.company {
  width:250px;
  height:150px;
  display:block;
  background-image: url('assets/images/com_grey.png');
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
}

.company:hover {
   background-image: url('assets/images/company.jpg');
}
.student {
  width:250px;
  height:150px;
  display:block;
  background-image: url('assets/images/stud_grey.png');
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
}

.student:hover {
   background-image: url('assets/images/student.png');
}

.black-text{
  color:#000;
}
.section-header {
	position: relative;
	text-align: center;
}

.section-header:before {
	content: '';
	z-index: 1;

	position: absolute;
	left: 0;
	top: 50%;
	transform: translateY(-50%);

	width: 100%;
	height: 1px;

	background: red;
}
.btn-success {
    color: #fff;
    background-color: #6b0000;
    border-color: #1cc88a;
}
	.section-header__title {
		position: relative;
		z-index: 2;

		background: #fff;
		padding: 20px 2px;

		display: inline-block;

		color: grey;
	}
  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #1cc88a;
    color: #fff;
  }
</style>

<!-- FUNCIONES -->
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
  };
 

  function formAtStud(){
    $('#form_estudiante').css('display','block');
    $('#form_bienvenida').css('display','none');
    $('#form_empresa').css('display','none');
  }
  function formAtWelcome(){
    $('#form_estudiante').css('display','none');
    $('#f_est')[0].reset();
    $('#f_emp')[0].reset();
    $('#alert_name').css('display','none');
    $('#alert_cc').css('display','none');
    $('#alert_dir').css('display','none');
    $('#alert_correo').css('display','none');
    $('#alert_password').css('display','none');
    $('#alert_tarjeta').css('display','none');
    $('#alert_tipo').css('display','none');
    $('#alert_plan').css('display','none');
    $('#form_bienvenida').css('display','block');
    $('#form_empresa').css('display','none');

  }
  function formAtCompany(){
    $('#form_empresa').css('display','block');
    $('#form_bienvenida').css('display','none');
    $('#form_estudiante').css('display','none');
  }
  function verifyPass(){
    var pass=document.getElementById('pass').value;
    var verify=document.getElementById('verify').value;
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_password').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_password').css('display','block');
    }else{
      $('#alert_password').css('display','none');
    }
    return false;
  }
  function verifyPassCp(){
    var pass=document.getElementById('passCp').value;
    var verify=document.getElementById('verifyCp').value;
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_pwCp').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_pwCp').css('display','block');
    }else{
      $('#alert_pwCp').css('display','none');
    }
    return false;
  }
  
  function verifyName(){
    var correo=document.getElementById('nom_cliente').value;
    var array=correo.split(" ");
    if(array.length>2){
      $('#alert_name').css('display','none');
      return true;
    }else{
      $('#alert_name').html('<strong>Error!</strong> Debe ingresar su nombre completo');
      $('#alert_name').css('display','block');
    }
    return false;
  }

  function verifyCC(){
    var cc=document.getElementById('cc_cliente').value;
    var array=cc.split(" ");
    if(array.length<=10){
      $('#alert_cc').css('display','none');
      return true;
    }else{
      $('#alert_cc').html('<strong>Error!</strong> No puden ser más de 10 digitos');
      $('#alert_cc').css('display','block');
    }
    return false;
  }
  function verifDir(){
    var dir =document.getElementById('dir_cliente').value;
    
    if(array.length<=20 ){
      $('#alert_dir').css('display','none');
      return true;
    }else{
      $('#alert_dir').html('<strong>Error!</strong> No puden ser mas de 20 digitos');
      $('#alert_dir').css('display','block');
    }
    return false;
  }
  function verifyTarjeta(){
    var cc=document.getElementById('tarjeta_credito').value;
    var array=cc.split(" ");
    if(array.length==16){
      $('#alert_tarjeta').css('display','none');
      return true;
    }else{
      $('#alert_tarjeta').html('<strong>Error!</strong> Ingrese una tarjeta de credito valida');
      $('#alert_tarjeta').css('display','block');
    }
    return false;
  }

  function reg(){
    if(verifyPass() && verifyName() && verifyCC()&& verifyTarjeta()&& verifDir()){
      $.ajax({
        type: "POST",
        url: "ws/registrarCliente.php",
        data:$('#f_est').serialize(),
        success: function (data) {
            data = JSON.parse(data);
            if (data["status"] == 1) {
              Swal.fire(
								  'Bien hecho!',
								  'Se han enviado a tu correo las credenciales, activa tu cuenta y disfruta de la plataforma!!!',
								  'success'
								).then(function(){
                  window.location='index.php';
                })
            }else{
              if(data['error'] ==1062){
                Swal.fire(
								  'Error!',
								  'Ya se encuentra registrado en la plataforma!!!',
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

  function regCompany(){
    if(verifyPassCp()){
      $.ajax({
        type: "POST",
        url: "ws/registerCompany.php",
        data:new FormData($('#f_emp')[0]),
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
								  'Se han enviado a tu correo las credenciales para que accedas a tu cuenta y disfruta de la plataforma!!!',
								  'success'
								).then(function(){
                  window.location='index.php';
                })
            }else{
              if(data['error'] == 1062){
                Swal.fire(
								  'Error!',
								  'Ya se encuentra registrado en la plataforma!!!',
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

</script>


<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="card w-75 black-text" style="margin-top:6%;padding-bottom: 2%;">
        <div class="card-body" id="body_form" name="body_form">

          <!-- Este es el formulario que se despliega cuando se pulsa estudiante -->
          <div id="form_estudiante" name="form_estudiante" style="display:none;">
            <a href="javascript:void(0);" class="btn btn-success" style="float:left;" onclick="formAtWelcome();">Volver</a>
            <form id="f_est" action="javascript:void(0);" onsubmit="reg();">
              <center><h3 style="margin-right: 10%;">Registrate</h3></center><br>
              <div class="alert alert-danger mb-0" role="alert" id="alert_name" style="display:none;"></div>
              <label>Nombre</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="nom_cliente" name="nom_cliente" required onchange="verifyName();" placeholder="Digita tu nombre " maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_name" style="display:none;"></div>
              <label>Apellido</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="ape_cliente" name="ape_cliente" required onchange="verifyName();" placeholder="Digita tu apellido " maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_correo" style="display:none;"></div>
              <label>Correo </label>
              <div class="input-group input-group-sm mb-3">
                <input type="email" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required id="correo_cliente" name="correo_cliente"  placeholder="Ingresa tu correo" maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_cc" style="display:none;"></div>
              <label>Cedula</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required id="cc_cliente" name="cc_cliente" onchange="verifyCC();" placeholder="Ingresa tu cedula" maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_dir" style="display:none;"></div>
              <label>Direccion</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required id="dir_cliente" name="dir_cliente" onchange="verifDir();" placeholder="Ingresa tu Direccion" maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_tarjeta" style="display:none;"></div>
              <label>Tarjeta de credito</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required id="tarjeta_credito" name="tarjeta_credito" onchange="verifyTarjeta();" placeholder="Ingresa tu tarjeta de credito" maxlength="50">
              </div>
              <label for="tipo_membresia">Tipo de membresia</label>
              <div class="input-group input-group-sm mb-3">
                <select name="tipo_membresia" class="form-control" id="tipo_membresia" required>
                  <option value="">Seleccione la membresía que deseas inscribirte</option>              
                  <option value="platino">PLATINO</option>
                  <option value="plata">PLATA</option>
                  <option value="oro">ORO</option>

                </select>
              </div>
              <label for="plan_pago">plan de pago</label>
              <div class="input-group input-group-sm mb-3">
                <select name="plan_pago" class="form-control" id="plan_pago" required>
                <option value="">Seleccione la membresía que deseas inscribirte</option>              
                  <option value="mensual">Mensual</option>
                  <option value="trimestral">trimestral</option>
                  <option value="semestral">semestral</option>
                  <option value="anual">anual</option>
                </select>
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_password" style="display:none;"><strong>Error!</strong> Las contraseñas no coinciden</div>
              <label>Contraseña</label>
              <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="pass" name="pass" required onchange="verifyPass();" placeholder="Digita tu contraseña" minlength="6" maxlength="12">
              </div>
              <label>Confirmar Contraseña</label>
              <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="verify" name="verify" required onchange="verifyPass();" placeholder="Verifica tu contraseña" maxlength="12">
              </div>
              <center><button type="submit" class="btn btn-success btn-user btn-block">Registrar</button></center>    
            </form>
          </div>
          <!-- Este es el formulario que se desplega cuando se pulsa empresa -->
          <div id="form_empresa" name="form_empresa" style="display:none;" enctype="multipart/form-data">
            <a href="javascript:void(0);" class="btn btn-success" style="float:left;" onclick="formAtWelcome();">Volver</a>
            <form id="f_emp" action="javascript:void(0);" onsubmit="regCompany();">
              <center><h3 style="margin-right: 10%;">Formulario de registro Empresas</h3></center><br>
              <div class="form-group">
                  <label for="photo">Logo de la empresa:</label>
                  <input type="file" class="form-control-file dropify" name="logo" id="logo" accept=".png,.jpeg,.jpg" data-allowed-file-extensions="png jpeg jpg" required>
              </div>
              <label>Razon social</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="nameCp" name="nameCp" required placeholder="Digita la razon social de la empresa" maxlength="50">
              </div>
              <label>NIT</label>
              <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="nitCp" name="nitCp" required placeholder="Digita el NIT de la empresa" maxlength="50">
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_mailCp" style="display:none;"></div>
              <label>Correo</label>
              <div class="input-group input-group-sm mb-3">
                <input type="email" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required id="mailCp" name="mailCp" placeholder="Ingresa tu correo" maxlength="50">
              </div>
              <label>Descripción</label>
              <div class="input-group input-group-sm mb-3">
                <textarea class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="desCp" name="desCp" required placeholder="Danos una breve descripción de tu empresa" maxlength="1200"></textarea>
              </div>
              <div class="form-group">
                  <label for="photo">Camara de comercio de la empresa:</label>
                  <input type="file" class="form-control-file dropify" name="cc" id="cc" accept=".pdf" data-allowed-file-extensions="pdf" required>
              </div>
              <div class="alert alert-danger mb-0" role="alert" id="alert_pwCp" style="display:none;"><strong>Error!</strong> Las contraseñas no coinciden</div>
              <label>Contraseña</label>
              <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="passCp" name="passCp" required onchange="verifyPassCp();" placeholder="Digita tu contraseña" minlength="6" maxlength="12">
              </div>
              <label>Confirmar Contraseña</label>
              <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="verifyCp" name="verifyCp" required onchange="verifyPassCp();" placeholder="Verifica tu contraseña" maxlength="12">
              </div>
              <center><button type="submit" class="btn btn-success btn-user btn-block">Registrar</button></center>    
            </form>
          </div>
          <!-- Este div se desplega, para seleccionar si es un estudiante o una empresa -->
          <div id="form_bienvenida" class="text-center">
            <a href="index.php" class="btn btn-warning" style="float:left;">Volver</a><br>
            <h5 class="card-title">Bienvenido al formulario de registro</h5>
            <p class="card-text">¿Quien eres?</p><br>
            <center><table>
                <tr>
                  <td>
                    <a href="javascript:void(0);" onclick="formAtCompany();" class="company"></a>
                  </td>
                  <td>
                    <a href="javascript:void(0);" onclick="formAtStud();" class="student"></a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    Cliente
                  </td>
                  <td class="text-center">
                    Distribuidor
                  </td>
                </tr>
            </table></center>
          </div>
        </div>
      </div>
    </div>
  </div>
  

  <!-- Bootstrap core JavaScript-->


</body>

</html>
