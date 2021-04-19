<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>UEB Verificación Empresas</title>

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

	background: green;
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
  function updateCC(){
    $("#nit").val("<?php echo $_GET['id']; ?>");
    $.ajax({
        type: "POST",
        url: "ws/updateCC.php",
        data:new FormData($('#upForm')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
              Swal.fire(
								  'Bien hecho!',
                  data['comment'],
								  'success'
								).then(function(){
                  window.location='index.php';
                });
            }else{
              Swal.fire(
								  'Error!',
                  data['error'],
								  'error'
								);
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
  }
</script>

<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="card w-75 black-text" style="margin-top:6%;padding-bottom: 2%;">
        <div class="card-body text-center" id="body_form" name="body_form">
          <h2>Verificación de empresa</h2>
          <h4>Parece que no has pasado la verificación, envianos una camara de comercio valida, para poder darte acceso a la plataforma</h4>
          <form method="POST" action="javascript:void(0)" onsubmit="updateCC();" enctype="multipart/form-data" id="upForm">
            <input type="text" id="nit" name="nit" style="display:none;">
            <div class="form-group">
                <label for="cc">Camara de comercio de la empresa:</label>
                <input type="file" class="form-control-file dropify" name="cc" id="cc" accept=".pdf" data-allowed-file-extensions="pdf" required>
            </div>
            <button type="submit" class="btn btn-success">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <!-- Bootstrap core JavaScript-->


</body>

</html>
