$(document).ready(function () {
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
});

/* ..:: CARGA DATOS PAC | AJAX ::.. */
function carga_datos_pac(id){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/pac/get_pac/" + id,
    data: {"token":token},
    success: function(resp){
      console.log(resp);
      // Obtiene los datos del servicio
      var id = resp.data.Id;
      var nombre = resp.data.Nombre;
      var nombre_corto = resp.data.NombreCorto;
      var endpoint = resp.data.EndPoint;
      var endpoint_pruebas = resp.data.EndPoint_Pruebas;
      var usuario_pac = resp.data.UsrPAC;
      var password_pac = resp.data.PassPAC;
      var observaciones = resp.data.Observaciones;
      // Setea los datos en el formulario
      $("input[name='id_pac']").val(id);
      $("input[name='nombre_pac_edit']").val(nombre);
      $("input[name='nombre_corto_edit']").val(nombre_corto);
      $("input[name='endpoint_edit']").val(endpoint);
      $("input[name='endpoint_pruebas_edit']").val(endpoint_pruebas);
      $("input[name='usuario_edit']").val(usuario_pac);
      $("input[name='pass_edit']").val(password_pac);
      $("textarea[name='observaciones_edit']").val(observaciones);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
