$(document).ready(function () {
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./API/chartjs/dashboard",
    data: {"token":token},
    success: function(resp){
      console.log(resp);
      show_chartjs("chart_meses", resp.data.CFDIsMeses[0], resp.data.CFDIsMeses[1]);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
});

function show_chartjs(canvas_id, labels, values){
  var ctx = document.getElementById(canvas_id).getContext('2d');
  var myChart = new Chart(ctx,{
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Comprobantes generados',
        data: values,
        borderColor: 'rgb(75, 192, 192)',
        borderWidth: 1
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
