$(document).ready(function () {
  var token = $("input[name='token']").val();
  /* Chart Comprobantes Por Mes */
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./API/chartjs/dashboard1",
    data: {"token":token},
    success: function(resp){
      // console.log(resp);
      show_chartjs("chart_meses", "bar", "Comprobantes Generados", "#449FDE", "#4E73DF", resp.data.CFDIsMeses[0], resp.data.CFDIsMeses[1]);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
  /* Chart Top Clientes */
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./API/chartjs/dashboard2",
    data: {"token":token},
    success: function(resp){
      console.log(resp);
      show_chartjs("chart_clientes", "bar", "Comprobantes", "#F3F727", "#E9EE0F", resp.data.CFDIsClientes[0], resp.data.CFDIsClientes[1]);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
});

function show_chartjs(canvas_id, chart_type, label, background, border, labels, values){
  var ctx = document.getElementById(canvas_id).getContext('2d');
  var myChart = new Chart(ctx,{
    type: chart_type,
    data: {
      labels: labels,
      datasets: [{
        label: label,
        data: values,
        backgroundColor: background,
        borderColor: border,
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}
