
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
   
    getCompanies();

  };
  
  function verifyPass(){
    var pass=document.getElementById('pass_1').value;
    var verify=document.getElementById('verify').value;
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','block');
    }else{
      $('#alert_pw').css('display','none');
    }
    return false;
  }
   function modCompany(){
    if(verifyPass()){
      $.ajax({
        type: "POST",
        url: "ws/modCompany.php",
        data: new FormData($('#mod')[0]),
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
                  'Se ha modificado la empresa de forma exitosa!!!',
                  'success'
                ).then(function(){
                  window.location='companyHome.php';
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
  }

  function getCompanies(){
    $.ajax({
        type: "POST",
        url: "ws/getCompanies.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["companies"];   
                var i=0;
                var econtro = false;
                while(econtro==false){
                  if(data[i]["NIT"]==<?php echo $nit ?>){
                   econtro=true;    

                  }else{
                    i++;
                  }                                      
                }

                var html ='<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nit">NIT</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="nit" id="nit" value ="'+data[i]["NIT"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="razonSocial">Razón Social</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" id="razonSocial" name="razonSocial" value ="'+data[i]["nombre"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="email">Correo</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="email" class="form-control" id="email" name="email" value ="'+data[i]["correo_empresa"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="descrip">Descripción</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<textarea class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="descrip" name="descrip" required maxlength="1200" style="width:190%;">'+data[i]["descripcion_empresa"]+'</textarea>'+
                          '</div>'+
                        '</div>'+
                        '<div class="alert alert-danger mb-0" role="alert" id="alert_pw" style="display:none;width: 70%;text-align: center;margin-left: 25%;"><strong>Error!</strong> Las contraseñas no coinciden</div><br>'+                                                                
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="pass">Contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="pass_1" name="pass_1" required value ="'+data[i]["password_empresa"]+'" onchange="verifyPass();"  minlength="6" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="verify">Verificar contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            ' <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="verify" name="verify" required value ="'+data[i]["password_empresa"]+'" onchange="verifyPass();" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                         '<div>'+
                         '<div class="form-group row showcase_row_area" >'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="logo">Logo de la empresa:</label>'+
                          '</div>'+
                          '<div class="col-md-5 showcase_content_area">'+                  
                            '<input type="file" class="form-control-file dropify" name="logo" id="logo" accept=".png,.jpeg,.jpg" data-allowed-file-extensions="png jpeg jpg" data-default-file="assets/images/logos/'+data[i]["logo"]+'">'+
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

      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Empresa</h4>
                <div class="form-group">
                                                           

              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-10 equel-grid">
                <div class="grid">
                  <p class="grid-header">Editar perfil</p>
                   <div class="grid-body">
                    <div class="item-wrapper">
                      <form id="mod" action="javascript:void(0);" onsubmit="modCompany();">
                          <div id="insertar">

                          </div>     
                          <div >
                            <br>
                              <div class="form-group row showcase_row_area" style="float:right;" >
                                <div>                  
                                  <a href="companyHome.php" class="btn btn-warning" style="margin-right:15px;">Cancelar</a>
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
         </div>
      <!-- page content ends -->
    </div>
  