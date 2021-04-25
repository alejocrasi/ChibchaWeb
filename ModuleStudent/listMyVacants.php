<script>
    window.onload = getData();

    function getData() {
        console.log('entra1?');
        $.ajax({
            type: "POST",
            url: "ws/getVacantsForCurrentStudent.php",
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                var aux = 0;

                if (data["status"] == 1) {

                    console.log(data['vacants']);
                    var html = "<div class='row' >";
                    data = data["vacants"];
                    for (let x in data) {
                        aux = aux + 1;
                        margin = (aux == 1) ? '' : 'margin-left:4%;';
                        aux = (aux == 3) ? 0 : aux;
                        estado=(data[x]["estado_detalle"]=='OFERTA') ? '<br><center><a href="javascript:void(0);" onclick="changeStatus('+ data[x]["cod_estudiante"] +','+data[x]["cod_vacante"]+',\'RECHAZADA\');" class="btn btn-warning" style="border-right: inherit; border-top-right-radius: inherit; border-bottom-right-radius: inherit;">Rechazar</a>'+
                                    '<button class="btn btn-primary" style="border-left: inherit; border-top-left-radius: inherit; border-bottom-left-radius: inherit;" onclick="changeStatus('+ data[x]["cod_estudiante"] +','+data[x]["cod_vacante"]+',\'ACEPTADA\');">ACEPTAR!</button></center>' : '';
                        html += '<div class="card" style="width: 30%; ' + margin + ' margin-top:2%; background-image: linear-gradient(120deg,#00e795 0,#0095e2 100%);">\n' +
                            '<div class="card-body" style="color:#fff">\n' +
                            '<h4 class="text-center">' + data[x]['nombre_cargo'] + '</h4>\n' +
                            '<h5 class="text-center">' + data[x]['empresa'] + '</h5><br>\n' +
                            '<center><img src="assets/images/logos/'+ data[x]["logo"] +'" alt="" class="thumb-sm rounded-circle mr-2" width="80px" height="80px"></center>'+
                            '<center><label class="badge badge-dark">' + data[x]["estado_detalle"] + '</label></center>\n' +
                            '<p class="card-text">\n' +
                            '<strong>Rango salarial:</strong> ' + data[x]["rango_salarial"] + '<br>\n' +
                            '<strong>Horario:</strong> ' + data[x]["horario_disponibilidad"] + '<br>\n' +
                            '<strong>Descripción:</strong> ' + data[x]["descripcion_vacante"] + '<br>\n' +
                            '<strong>Educación base:</strong> ' + data[x]["educacion_base"] + '<br>\n' +
                            '</p>\n' +
                            estado +
                            '</div>\n' +
                            '</div>';
                    }
                    html += '</div>';
                    $('#contentPage').html(html);
                } else {
                    console.log('entra?');
                    var h = "<div style='margin-top:3%;margin-left:15%;'>\n" +
                        "<h1>Aun no te has postulado a ninguna vacante </h1><br>\n" +
                        "<img src='assets/images/HOJAV.png' height='600px'>\n" +
                        "<a class='btn btn-warning btn-lg' style='color:white;' href='?menu=vacants' >Comencemos!!</a>\n" +
                        "</div>";
                    $('#contentPage').html(h);

                }
            },
            error: function(data) {
                console.log(data);
            },
        })
    }

    function changeStatus(id,dta,estado){
        msg1=(estado=='ACEPTADA') ? 'De aceptar esta oferta, se cancelaran las otras, se le notificara a la empresa y no podras revertir esta acción' : 'De rechazar esta oferta, no podras revertir esta acción';
        msg2=(estado=='ACEPTADA') ? 'Se le ha notificado a la empresa que has aceptado la vacante!!!' : 'Se ha rechazado la vacante con exito!';
        
        Swal.fire({
                title: '¿Estas seguro?',
                text: msg1,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor:'#fc3e25',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, estoy seguro!',
            }).then(function (result) {
                if(result.value){
                    $.ajax({
                        type: "POST",
                        url: "ws/updateStatusVacantInStudent.php",
                        data:{
                            'cod_estudiante':id,
                            'cod_vacante':dta,
                            'estado':estado
                        },
                        success: function (data) {
                            console.log(data);
                            data=JSON.parse(data);
                            if(data['status']==1){
                                getData();
                                Swal.fire(
                                        'Bien hecho!',
                                        msg2,
                                        'success'
                                    );
                            }
                            else{
                                Swal.fire(
                                        'Error!!',
                                        data['error'],
                                        'error'
                                    );
                                getData();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    })
                }
            });
    }

    function addVacant() {
        $.ajax({
            type: "POST",
            url: "ws/addVacant.php",
            data: $("#form_vac").serialize(),
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    Swal.fire(
                        'Bien hecho!',
                        'Se ha publicado de manera exitosa!',
                        'success'
                    );
                    getData();
                } else {
                    Swal.fire(
                        'Bien hecho!',
                        data['error'],
                        'error'
                    );
                }
                $('#addVacant').modal('hide');
                $("#form_vac")[0].reset();
            },
            error: function(data) {
                console.log(data);
            },
        })
    }
    $(document).ready(function() {
        $(".modal").on("hidden.bs.modal", function() {
            $("#form_vac")[0].reset();
        });
    });

    function rangMin() {
        var x = document.getElementById('rang-min').value;
        $("#rang-max").attr('min', x);
    }
</script>

<style>
    .form-control {
        border: 0.5px solid lightgrey;
        color: #000;
    }
</style>

<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
            <h4 style="margin-left: 15%; width: 100%;"></h4>
        </div>
    </div>
    <hr>
</div>
<div class="content-viewport">
    <div class="row">
        <div id="contentPage" style="width:100%;">
            <!-- Aqui va todo el contenido de la pagina -->
        </div>
    </div>
</div>