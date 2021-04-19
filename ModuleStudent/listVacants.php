<script>
    window.onload=function(){
        getData();
    };
    function getData(){
        $.ajax({
            type: "POST",
            url: "ws/getVacantsForStudent.php",
            success: function (data) {
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    $("#contentPage").html(data['vacants']);
                    $('#myTable').DataTable({
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
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function openModal(id){
        
            $.ajax({
                type: "POST",
                url: "ws/getDetailsOfVacant.php",
                data:{
                    'cod':id
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data["status"] == 1) {
                        $("#modalBody").html(data['html']);
                    }
                    $("#seeVacant").modal('show');
                },
                error: function (data) {
                    console.log(data);
                },
            });
        
        
    }
    function applyAtVacant(id){
        var estado = "<?php echo $_SESSION['estado'] ?>";
        if(estado != 'CONTRATADO'){
            Swal.fire({
                    title: '¿Estas seguro?',
                    text: "No vas a poder revertir esta acción y se enviara tu hoja de vida a la empresa",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor:'#fc3e25',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, estoy seguro!',
                }).then(function (result) {
                    if(result.value){
                        $.ajax({
                            type: "POST",
                            url: "ws/applyAtVacant.php",
                            data:{
                                'cod':id
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                if (data["status"] == 1) {
                                    Swal.fire(
                                        'Bien hecho!',
                                        'Se ha enviado tu hoja de vida con exito!',
                                        'success'
                                    );
                                }else{
                                    Swal.fire(
                                        'Bien hecho!',
                                        data['error'],
                                        'error'
                                    );
                                }
                                getData();
                                $("#seeVacant").modal('hide');
                            },
                            error: function (data) {
                                console.log(data);
                            },
                        });
                    }
                });
        }else{
            Swal.fire(
                    'Ya has sido contratado en un empresa!!',
                    '',
                    'error'
                );   
        }
       
        
    }
    
</script>
<style>
.form-control {
    border:0.5px solid lightgrey;
    color: #000;
}
</style>
<div class="viewport-header"style="margin-left: -2%;">
    <div class="row">
        <div>
        <h4 style="margin-left: 15%; width: 100%;" >Vacantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row">              
        <div id="contentPage" style="width:80%; margin-left:8%;">
        
            <!-- Aqui va todo el contenido de la pagina -->
        </div>
        <div class="modal fade" id="seeVacant" tabindex="-1" role="dialog" aria-labelledby="addFavorite_modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="modalBody" name="modalBody">
                    <!-- Aqui va todo el contenido de ver vacante-->
                </div>
            </div>
        </div>
