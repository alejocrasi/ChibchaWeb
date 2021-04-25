<?php

?>
<script>



function graf() {
  'use strict';  

  


  if ($("#grafica_tickets_resueltos").length) {

    $.ajax({
        type: "POST",
        url: "ws/getGrafica1.php",
        success: function (data) {  
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["tickets"];
                var resueltos = data[0]["num_tickets_resueltos"];
                var pendientes = data[0]["num_tickets_pendientes"];
                console.log(resueltos,pendientes);

                 
                    var BarData = {
                    labels: ["resueltos", "pendientes"],
                    datasets: [{
                      
                      label: 'tickets resueltos',
                      data: [resueltos ,pendientes],
                      backgroundColor: chartColors,
                      borderColor: chartColors,
                      borderWidth: 0
                    }
                  ]


                  };
                  var barChartCanvas = $("#grafica_tickets_resueltos").get(0).getContext("2d");
                  var barChart = new Chart(barChartCanvas, {
                    
                    type: 'bar',
                    data: BarData,
                    options: {
                      scales: {
                         xAxes: [
                                {
                                  ticks: {
                                    callback: function(label, index, labels) {
                                      if ( label.length  > 30) {
                                        return label.match(/.{1,22}/g) ;
                                      }else{
                                        return label ;
                                      }              
                                    }
                                  }
                                }
                              ],
                          yAxes: [{
                              display: true,
                              ticks: {
                                  suggestedMin: 0,   
                                  beginAtZero: true 
                              }
                          }]
                      },
                      legend: false
                    }
                  });
    
              }
        },
        error: function (data) {
            console.log(data);
        },
      })
    
    }


};

</script>