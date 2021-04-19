<div class="viewport-header">
    <div class="row">
        <div>
        <h4>Estadisticas</h4>
        </div>
    </div>    
    <hr> <?php include('graficas.php'); ?>
    <script>
      window.onload=function(){
       graf();   
       getData();  
       };
    function getData(){
      $.ajax({
        type: "POST",
        url: "ws/getNumVacantesEmpresa.php",
        success: function (data) {           
            data = JSON.parse(data);
            console.log(data);
            if (data["status"] == 1) {
                var data = data["registros"];
                
                var vacant = data[0]["num_vacantes"];

                 var vacantH= '<p>'+vacant+'</p>'+
                '<p></p>';

                $('#num_vacantes').html(vacantH);

                    }
        },
        error: function (data) {
            console.log(data);
        },
    });
  }
    </script>
    </div>
   
          <div class="content-viewport">
            
           

                  <div class="row">

                    <div class="col-md-3 col-sm-6 col-6 ">
                      <div class="grid" >
                        <div class="grid-body text-gray" >
                          <div class="d-flex justify-content-between" id="num_vacantes" name="num_vacantes" >
                            <p></p>
                          </div>
                          <p class="text-black">Mis Vacantes</p>
                          <div class="wrapper w-50 mt-4">
                            <canvas height="45" id="stat-line_1"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                 <div class="row">  
                  <div class="col-md-6">
                    <div class="grid">
                      <div class="grid-body">
                        <h2 class="grid-title">Numero de Aspirantes por Estado</h2>
                        <div class="item-wrapper">
                          <canvas id="empresa-aspirantes-graph" width="600" height="400"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="grid">
                      <div class="grid-body">
                        <h2 class="grid-title">Numero de Aspirantes por Vacante</h2>
                        <div class="item-wrapper">
                          <canvas id="empresa-vacante-graph" width="600" height="400"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>

                  </div>
                    


               

            
        </div>