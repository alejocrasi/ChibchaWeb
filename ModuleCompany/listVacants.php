<script>
    window.onload=getData();
    function getData(){
        $.ajax({
            type: "POST",
            url: "ws/getVacantsOfCompany.php",
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                var aux=0;

                if (data["status"] == 1) {
                    
                    console.log(data['vacants']);
                    var html="<div class='row' style='float:right; margin-bottom:5%; margin-right:5%'>\n"+
                        "<a class='btn btn-warning' href='javascript:void(0)' onclick='openModal();'>Publicar</a>\n"+
                    "</div>\n"+
                    "<div class='row' style='margin-top:6%;'>";
                    data=data["vacants"];
                    for (let x in data ){
                        aux=aux+1;
                        margin=(aux==1) ? '' : 'margin-left:5%;';
                        aux=(aux==3) ? 0 : aux;
                        html+='<div class="card" style="width: 30%; '+margin+' margin-top:2%; background-image: linear-gradient(120deg,#00e795 0,#0095e2 100%);">\n'+
                                '<div class="card-body" style="color:#fff">\n'+
                                    '<h4 class="text-center">'+data[x]['nombre_cargo']+'</h4><br>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >Vacantes disponibles: '+data[x]["cantidad_vacantes"]+'</h6>\n'+
                                    '<center><label class="badge badge-dark">'+data[x]["estado"]+'</label></center>\n'+
                                    '<p class="card-text">\n'+
                                       '<strong>Rango salarial:</strong> '+data[x]["rango_salarial"]+'<br>\n'+
                                        '<strong>Horario:</strong> '+data[x]["horario_disponibilidad"]+'<br>\n'+
                                        '<strong>Fecha:</strong> '+data[x]["fecha_vacante"]+'<br>\n'+
                                        '<strong>Descripción:</strong> '+data[x]["descripcion_vacante"]+'<br>\n'+
                                        '<strong>Educación base:</strong> '+data[x]["educacion_base"]+'<br>\n'+
                                    '</p>\n'+
                                '</div>\n'+
                            '</div>';   
                    }
                    html+='</div>';
                    $('#contentPage').html(html);
                }else{
                    console.log('entra?');
                    var h="<div style='margin-top:3%;margin-left:15%;'>\n"+
                        "<h1>Aun no has publicado ninguna vacante </h1><br>\n"+
                        "<img src='assets/images/comencemos.png' width='600px' height='500px'>\n"+
                        "<a class='btn btn-warning btn-lg' style='color:white;' href='javascript:void(0)' onclick='openModal();'>Comencemos!!</a>\n"+
                   "</div>";
                   $('#contentPage').html(h);

                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function openModal(){
        $('#addVacant').modal('show');
    }
    function addVacant(){
        $.ajax({
            type: "POST",
            url: "ws/addVacant.php",
            data: $("#form_vac").serialize(),
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    Swal.fire(
                        'Bien hecho!',
                        'Se ha publicado de manera exitosa!',
                        'success'
                    );
                    getData();
                }else{
                    Swal.fire(
                        'Bien hecho!',
                        data['error'],
                        'error'
                    );
                }
                $('#addVacant').modal('hide');
                $("#form_vac")[0].reset();
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    $( document ).ready(function() {
        $(".modal").on("hidden.bs.modal", function(){
            $("#form_vac")[0].reset();
        });
    });
    
    function rangMin(){
        var x=document.getElementById('rang-min').value;
        $("#rang-max").attr('min',x);
    }
    
</script>
<style>
.form-control {
    border:0.5px solid lightgrey;
    color: #000;
}
</style>
<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
        <h4 style="margin-left: 15%; width: 100%;">Mis vacantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row">              
        <div id="contentPage" style="width:100%;">
            <!-- Aqui va todo el contenido de la pagina -->
        </div>
        <div class="modal fade" id="addVacant" tabindex="-1" role="dialog" aria-labelledby="addFavorite_modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="javascript:void(0);" onsubmit="addVacant();" id="form_vac" name="form_vac">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Publicar vacante </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="addBody">
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="nombre">Cargo</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="nombre">Cantidad vacantes</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1">
                                </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="descripcion">Descripción vacante</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                <textarea class="form-control" id="descripcion" name="descripcion" cols="12" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="sueldo">Rango salarial</label>
                                </div>
                                <div class="col-md-9 showcase_content_area row">
                                    <input type="number" class="form-control" min="0" style="width:48%;margin-right:2%;margin-left:1.4%;" required id="rang-min" name="rang-min" onchange="rangMin();">
                                    <input type="number" class="form-control" max="5000000" style="width:48.6%;" required id="rang-max" name="rang-max">
                                </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="horario">Horario</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                <textarea class="form-control" id="horario" name="horario" cols="12" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                                <div class="col-md-3 showcase_text_area">
                                    <label for="educacion">Educación base</label>
                                </div>
                                <div class="col-md-9 showcase_content_area">
                                <textarea class="form-control" id="educacion" name="educacion" cols="12" rows="3" required></textarea>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="guardarCambios">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
