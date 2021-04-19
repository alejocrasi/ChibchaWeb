<?php

?>
<script>



function graf() {
  'use strict';  

   if ($("#num-usuarios").length) {

    $.ajax({
        type: "POST",
        url: "ws/getGraph.php",
        success: function (data) {  
        data = JSON.parse(data);   
            if (data["status"] == 1) {
                data = data["usuarios"];
                var estu = data[0]["num_estudiantes"];
                var empre = data[0]["num_empresas"];  
                var vacant = data[0]["num_vacantes"];                      
                    var PieData = {
                           datasets: [{
                             data: [estu, empre, vacant],
                             backgroundColor: chartColors,
                             borderColor: chartColors,
                             borderWidth: chartColors
                           }],

                           // These labels appear in the legend and in the tooltips when hovering different arcs
                           labels: [
                             'Estudiantes',
                             'Empresas',
                             'Vacantes',
                           ]
                         };
                         var PieOptions = {
                           responsive: true,
                           animation: {
                             animateScale: true,
                             animateRotate: true
                           }
                         };
                         var pieChartCanvas = $("#num-usuarios").get(0).getContext("2d");
                         var pieChart = new Chart(pieChartCanvas, {
                           type: 'pie',
                           data: PieData,
                           options: PieOptions
                         });
                       }
                     },
        error: function (data) {
            console.log(data);
        },
      })

  }

 

  if ($("#actividad-line-graph").length) {
    var fecha = new Array();
    var num_registros = new Array();

    $.ajax({
        type: "POST",
        url: "ws/getActividadDiaria.php",
        success: function (data) {  
        data = JSON.parse(data);   
        
            if (data["status"] == 1) {
                data = data["registros"]; 
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["fecha_detalle"]){
                    fecha.push(data[i]["fecha_detalle"]);
                     
                  }
                  if(data[i]["num_registros"]){
                    num_registros.push(data[i]["num_registros"]);
                  }
                }                                       
                var options = {
                     type: 'line',
                     data: {
                       labels: fecha,
                       datasets: [{
                           label: 'Numero de vacantes',
                           data: num_registros,
                           borderWidth: 2,
                           fill: false,
                           backgroundColor: chartColors[0],
                           borderColor: chartColors[0],
                           borderWidth: 0
                         },
                         
                       ]
                     },
                     options: {
                      scales: {
                          yAxes: [{
                              display: true,
                              ticks: {
                                  suggestedMin: 0,   
                                  beginAtZero: true 
                              }
                          }]
                      },
                       fill: false,
                       legend: false
                     }
                   }
               
                   var ctx = document.getElementById('actividad-line-graph').getContext('2d');
                   new Chart(ctx, options);
              }
              
        },
        error: function (data) {
            console.log(data);
        },
      })      
    
  }

  if ($("#programas-graph").length) {

    $.ajax({
        type: "POST",
        url: "ws/getProgramGraph.php",
        success: function (data) {  
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["estudiantes"];
                var prog = new Array();
                var num = new Array();
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["nom_programa"]){
                    prog.push(data[i]["nom_programa"]);
                  }
                  if(data[i]["num_estu"]){
                    num.push(data[i]["num_estu"]);
                  }
                  
                }  
                    var PieData = {
                           datasets: [{
                             data: num,
                             backgroundColor: chartColors,
                             borderColor: chartColors,
                             borderWidth: chartColors
                           }],

                           // These labels appear in the legend and in the tooltips when hovering different arcs
                           labels: prog
                         };
                         var PieOptions = {
                           responsive: true,
                           animation: {
                             animateScale: true,
                             animateRotate: true
                           }
                         };
                         var pieChartCanvas = $("#programas-graph").get(0).getContext("2d");
                         var pieChart = new Chart(pieChartCanvas, {
                           type: 'pie',
                           data: PieData,
                           options: PieOptions
                         });

              }
        },
        error: function (data) {
            console.log(data);
        },
      })
   
  }

  if ($("#motivo-rechazo-graph").length) {

    $.ajax({
        type: "POST",
        url: "ws/getMotivoRechazo.php",
        success: function (data) {  
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["registros"];
                var motivo = new Array();
                var num_rechazos = new Array();
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["motivo"]){
                    motivo.push(data[i]["motivo"]);
                    console.log(fecha); 
                  }
                   if(data[i]["num_rechazos"]){
                    num_rechazos.push(data[i]["num_rechazos"]);
                    console.log(fecha); 
                  }
                  
                }  

                    var BarData = {
                    labels: motivo,
                    datasets: [{
                      
                      label: 'numero de rechazos',
                      data: num_rechazos,
                      backgroundColor: chartColors,
                      borderColor: chartColors,
                      borderWidth: 0
                    }]
                  };
                  var barChartCanvas = $("#motivo-rechazo-graph").get(0).getContext("2d");
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



  if ($("#empresa-aspirantes-graph").length) {

    $.ajax({
        type: "POST",
        url: "ws/getAspirantesEmpresa.php",
        success: function (data) {  
          console.log(data);
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["registros"];
                var vac = new Array();
                var estado = new Array();
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["num_vacantes"]){
                    vac.push(data[i]["num_vacantes"]);
                  }
                  if(data[i]["estado"]){
                    estado.push(data[i]["estado"]);
                  }
                  
                }  
                    var PieData = {
                           datasets: [{
                             data: vac,
                             backgroundColor: chartColors,
                             borderColor: chartColors,
                             borderWidth: chartColors
                           }],

                           // These labels appear in the legend and in the tooltips when hovering different arcs
                           labels: estado
                         };
                         var PieOptions = {
                           
                           responsive: true,
                           animation: {
                             animateScale: true,
                             animateRotate: true
                           }
                         };
                         var pieChartCanvas = $("#empresa-aspirantes-graph").get(0).getContext("2d");
                         var pieChart = new Chart(pieChartCanvas, {
                           type: 'pie',
                           data: PieData,
                           options: PieOptions
                         });

              }
        },
        error: function (data) {
            console.log(data);
        },
      })
   
  }

  if ($("#empresa-vacante-graph").length) {

    $.ajax({
        type: "POST",
        url: "ws/getAspirantesVacante.php",
        success: function (data) {  
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["registros"];
                var aspirantes = new Array();
                var vacante = new Array();
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["vacante"]){
                    vacante.push(data[i]["vacante"]);                   
                  }
                   if(data[i]["aspirantes"]){
                    aspirantes.push(data[i]["aspirantes"]);
                    
                  }                 
                }
                 
                    var BarData = {
                    labels: vacante,
                    datasets: [{
                      
                      label: 'numero de aspirantes',
                      data: aspirantes,
                      backgroundColor: chartColors,
                      borderColor: chartColors,
                      borderWidth: 0
                    }]
                  };
                  var barChartCanvas = $("#empresa-vacante-graph").get(0).getContext("2d");
                  var barChart = new Chart(barChartCanvas, {
                    
                    type: 'bar',
                    data: BarData,
                    options: {
                      scales: {
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

   if ($("#aceptados-programas-graph").length) {
    $.ajax({
        type: "POST",
        url: "ws/getAceptadosPrograma.php",
        success: function (data) {  
        data = JSON.parse(data);   
        console.log(data);
            if (data["status"] == 1) {
                data = data["registros"];

                var nom_programa = new Array();
                var aceptados = new Array();
                for (var i = 0; i < data.length; i++) {
                  if(data[i]["nom_programa"]){
                    nom_programa.push(data[i]["nom_programa"]);                   
                  }
                   if(data[i]["aceptados"]){
                    aceptados.push(data[i]["aceptados"]);
                    
                  }                 
                }
                var DoughnutData = {
                     datasets: [{
                       data: aceptados,
                       backgroundColor: chartColors,
                       borderColor: chartColors,
                       borderWidth: chartColors
                     }],
                     labels: nom_programa
                   };
                   var DoughnutOptions = {
                     responsive: true,
                     animation: {
                       animateScale: true,
                       animateRotate: true
                     }
                   };
                   var doughnutChartCanvas = $("#aceptados-programas-graph").get(0).getContext("2d");
                   var doughnutChart = new Chart(doughnutChartCanvas, {
                     type: 'doughnut',
                     data: DoughnutData,
                     options: DoughnutOptions
                   });               
              }
        },
        error: function (data) {
            console.log(data);
        },
      })
    
  }






  if ($("#chartjs-staked-area-chart").length) {
    var options = {
      type: 'line',
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: chartColors[0],
            borderColor: chartColors[0],
            borderWidth: 1,
          },
          {
            label: '# of Points',
            data: [7, 11, 5, 8, 3, 7],
            borderColor: chartColors[1],
            borderWidth: 1,
            backgroundColor: chartColors[1]
          }
        ]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              reverse: false
            }
          }]
        },
        legend: false
      }
    }

    var ctx = document.getElementById('chartjs-staked-area-chart').getContext('2d');
    new Chart(ctx, options);
  }

  if ($("#chartjs-staked-line-chart").length) {
    var options = {
      type: 'line',
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 2,
            fill: false,
            backgroundColor: chartColors[0],
            borderColor: chartColors[0],
            borderWidth: 0
          },
          {
            label: '# of Points',
            data: [7, 11, 5, 8, 3, 7],
            borderWidth: 2,
            fill: false,
            backgroundColor: chartColors[1],
            borderColor: chartColors[1],
            borderWidth: 0
          }
        ]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              reverse: false
            }
          }]
        },
        fill: false,
        legend: false
      }
    }

    var ctx = document.getElementById('chartjs-staked-line-chart').getContext('2d');
    new Chart(ctx, options);
  }

  if ($("#chartjs-bar-chart").length) {
    var BarData = {
      labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
      datasets: [{
        label: '# of Votes',
        data: [10, 19, 3, 5, 12, 3],
        backgroundColor: chartColors,
        borderColor: chartColors,
        borderWidth: 0
      }]
    };
    var barChartCanvas = $("#chartjs-bar-chart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: BarData,
      options: {
        legend: false
      }
    });
  }

  if ($("#chartjs-staked-bar-chart").length) {
    var BarData = {
      labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
      datasets: [{
          label: 'Profit',
          data: [10, 19, 3, 5, 12, 3],
          backgroundColor: chartColors[0],
          borderColor: chartColors[0],
          borderWidth: 0
        },
        {
          label: 'Sales',
          data: [23, 12, 8, 13, 9, 17],
          backgroundColor: chartColors[1],
          borderColor: chartColors[1],
          borderWidth: 0
        }
      ]
    };
    var barChartCanvas = $("#chartjs-staked-bar-chart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: BarData,
      options: {
        tooltips: {
          mode: 'index',
          intersect: false
        },
        responsive: true,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        },
        legend: false
      }
    });
  }

  if ($("#chartjs-radar-chart").length) {
    var marksCanvas = document.getElementById("chartjs-radar-chart");

    var marksData = {
      labels: ["English", "Maths", "Physics", "Chemistry", "Biology", "History"],
      datasets: [{
          label: "Student A",
          data: [24, 55, 30, 56, 60, 68],
          backgroundColor: chartColors[0],
          borderColor: chartColors[0],
          borderWidth: 0
        }, {
          label: "Student B",
          data: [54, 65, 60, 70, 70, 75],
          backgroundColor: chartColors[1],
          borderColor: chartColors[1],
          borderWidth: 0
        },
        {
          label: "Student c",
          data: [43, 13, 33, 57, 50, 75],
          backgroundColor: chartColors[2],
          borderColor: chartColors[2],
          borderWidth: 0
        }
      ]
    };

    var radarChart = new Chart(marksCanvas, {
      type: 'radar',
      data: marksData
    });
  }

  if ($("#chartjs-doughnut-chart").length) {
    var DoughnutData = {
      datasets: [{
        data: [30, 40, 30],
        backgroundColor: chartColors,
        borderColor: chartColors,
        borderWidth: chartColors
      }],
      labels: [
        'Data 1',
        'Data 2',
        'Data 3',
      ]
    };
    var DoughnutOptions = {
      responsive: true,
      animation: {
        animateScale: true,
        animateRotate: true
      }
    };
    var doughnutChartCanvas = $("#chartjs-doughnut-chart").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: DoughnutData,
      options: DoughnutOptions
    });
  }

  if ($("#chartjs-pie-chart").length) {
    var PieData = {
      datasets: [{
        data: [30, 40, 30],
        backgroundColor: chartColors,
        borderColor: chartColors,
        borderWidth: chartColors
      }],

      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: [
        'Data 1',
        'Data 2',
        'Data 3',
      ]
    };
    var PieOptions = {
      responsive: true,
      animation: {
        animateScale: true,
        animateRotate: true
      }
    };
    var pieChartCanvas = $("#chartjs-pie-chart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: PieData,
      options: PieOptions
    });
  }
};

</script>