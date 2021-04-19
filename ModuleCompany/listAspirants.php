<script>

    var noMotivos=0;

    window.onload = function(){
        getVacants();
    }
    function getVacants(){
        $.ajax({
            type: "POST",
            url: "ws/getVacantsSelect.php",
            success: function (data) {
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    data = data["vacants"];
                    let options = '<option value="">Seleccione una vacante</option>';
                    for(let i in data){
                        options += '<option value="'+data[i]["cod_programa"]+'">'+data[i]["nom_programa"]+'</option>'
                    }
                    $('#vacants').select2({ width: '90%' });
                    $('#vacants').html(options);
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function getData(id){
        $.ajax({
            type: "POST",
            url: "ws/getAspirantsOfCompany.php",
            data:{
                'cod':id
            },
            success: function (data) {
                data = JSON.parse(data);
                var aux=0;

                if (data["status"] == 1) {
                    var html="<div class='row'>";
                    data=data["aspirants"];
                    for (let x in data ){
                        aux=aux+1;
                        margin=(aux==1) ? 'margin-left:2%;' : 'margin-left:3%;';
                        aux=(aux==3) ? 0 : aux;
                        img=(data[x]['foto']=='') ? 'default-user-image.png': data[x]['foto'];
                        onsb=(data[x]["estado"]=='ENVIADA') ? 'onsubmit="changeStatus('+ data[x]["cod_estudiante"] +','+id+',\'EN PROCESO\');"' : '';
                        btn=(data[x]["estado"]=='EN PROCESO') ? '<center><a href="javascript:void(0);" onclick="openReject('+ data[x]["cod_estudiante"] +','+id+');" class="btn btn-warning" style="border-right: inherit; border-top-right-radius: inherit; border-bottom-right-radius: inherit;">Rechazar</a>'+
                                    '<button class="btn btn-primary" style="border-left: inherit; border-top-left-radius: inherit; border-bottom-left-radius: inherit;" onclick="changeStatus('+ data[x]["cod_estudiante"] +','+id+',\'OFERTA\');">Contratar</button></center>' : '';
                        html+='<div class="card" style="'+margin+' margin-top:2%; background: linear-gradient(135deg, rgb(197, 108, 214) 0%, rgb(52, 37, 175) 100%);">\n'+
                                '<div class="card-body" style="color:#fff">\n'+
                                    '<center><label class="badge badge-dark">'+data[x]["estado"]+'</label></center>\n'+
                                    '<h4 class="text-center">'+data[x]['nombre_completo']+'</h4><br>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["nom_programa"]+'</h6>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["correo_estudiante"]+'</h6><br>\n'+
                                    '<center><form method="post" target="_blank" action="pdf.php" id="formCV" '+onsb+'">\n'+
                                        '<input type="hidden" id="id" name="id" value="'+ data[x]["cod_estudiante"] +'"/>'+
                                        '<button class="btn btn-rounded social-btn btn-reddit">\n'+
                                        '<i class="mdi mdi-file-pdf"></i>Ver hoja de vida</button></form>\n'+
                                    '</button></center><br>\n'+
                                    btn+
                                '</div>'+
                            '</div>';   
                    }
                    html+='</div>';
                    $('#contentPage').html(html);
                }else{
                    var h="<div style='margin-top:3%;margin-left:15%;'>\n"+
                        "<h1 style='margin-left:5%;'>Aun nadie ha aplicado para esta vacante </h1><br>\n"+
                        "<img src='assets/images/vac.png' width='400px' height='400px' style='margin-left:15%;'>\n"+
                   "</div>";
                   $('#contentPage').html(h);

                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function change(x){
        getData(x.value);
    }
    function changeStatus(id,dta,estado){
        $.ajax({
            type: "POST",
            url: "ws/updateStatusVacant.php",
            data:{
                'cod_estudiante':id,
                'cod_vacante':dta,
                'estado':estado
            },
            success: function (data) {
                if(estado=='OFERTA'){
                    getData(dta);
                    Swal.fire(
                            'Bien hecho!',
                            'Se le ha notificado al estudiante que ha sido seleccionado para el puesto, te avisaremos cuando acepte la propuesta',
                            'success'
                        );
                }else{
                    getData(dta);
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function openReject(id,dta){
        $.ajax({
            type: "POST",
            url: "ws/getReasons.php",
            success: function (data) {
                data=JSON.parse(data);
                if(data['status']==1){
                    var reasons=data['reasons'];
                    var bd="<input type='text' id='cod_estudiante' name='cod_estudiante' value='"+id+"' style='display:none;'><input type='text' id='cod_vacante' name='cod_vacante' value='"+dta+"' style='display:none;'><input type='text' id='estado' name='estado' value='RECHAZADA' style='display:none;'>";
                    var ultimo =reasons.length-1;
                    noMotivos=reasons.length;
                    for (var i = 0; i < reasons.length; i++) {
                        var action=(i==ultimo) ? 'onchange="quitDisabled(this);"' :'';
                        bd+='<label><input type="checkbox" id="R'+reasons[i]['cod_motivo']+'" ' + action +' name="motivos[]" value="'+reasons[i]['cod_motivo']+'"> '+ reasons[i]['motivo'] +'</label><br>';

                        var otros=(i==ultimo) ? '<textarea id="otrosTxt" name="otrosTxt" class="form-control" cols="12" rows="5" disabled style="width:100%;"></textarea>' : '';
                        bd+=otros;
                    }
                    $("#reasonsBody").html(bd);
                    $("#rejectAspirants").modal("show");
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function quitDisabled(atr){
        if (atr.checked == true){
            $("#otrosTxt").prop('disabled', false);
            $("#otrosTxt").removeClass('form-control');
            $("#otrosTxt").attr("required", true);
        }else{
            $("#otrosTxt").prop('disabled', true);
            $("#otrosTxt").addClass('form-control');
            $("#otrosTxt").attr("required", false);

        }
    }
    function sendReasons(){
        let motivos=[];
        for(var i=1;i<=noMotivos;i++){
            if($("#R"+i).prop('checked')){
                var otros=(i==(noMotivos)) ? $("#otrosTxt").val() : '';
                let motivo=[i,otros];
                motivos.push(motivo);
            }
        }
        if(motivos.length>0){
            $.ajax({
            type: "POST",
            url: "ws/updateStatusVacant.php",
            data:new FormData($('#form_rej')[0]),
            processData: false,  // tell jQuery not to process the data
            contentType: false,  
            success: function (data) {
                console.log(data);
                data=JSON.parse(data);
                if(data['status']==1){
                    getData(document.getElementById("cod_vacante").value);
                    $("#form_rej")[0].reset();
                    Swal.fire(
                        'Proceso finalizado!',
                        'Se le ha notificado al estudiante que no ha sido seleccionado para el puesto',
                        'success'
                    ).then(function(){
                        $("#rejectAspirants").modal("hide");
                    })
                }
                    
            },
            error: function (data) {
                console.log(data);
            },
        })
        }else{
            Swal.fire(
                'Error!',
                'Debes seleccionar al menos un motivo',
                'error'
            );
        }
    }
    $( document ).ready(function() {
        $(".modal").on("hidden.bs.modal", function(){
            $("#form_rej")[0].reset();
        });
    });
    
</script>
<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
        <h4 style="margin-left: 15%; width: 100%;">Aspirantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row"> 
        <div style="width:100%;">
            <h3 style='margin-left:0%;'>Selecciona una vacante</h3><br>
            <select name="program" class="form-control" id="vacants" onchange="change(this);"></select>
            <div id="contentPage">
                <br>
                <img src='assets/images/sel2.png' width='600px' height='562px' style='margin-left:15%;'>
            </div>
        </div>
        <div class="modal fade" id="rejectAspirants" tabindex="-1" role="dialog" aria-labelledby="reject_modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form action="javascript:void(0);" onsubmit="sendReasons();" id="form_rej" name="form_rej">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Motivos rechazo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="reasonsBody">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" id="guardarCambios">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>             
        